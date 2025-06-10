<?php
require_once "config.php";

// Initialize the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login_page.php");
    exit;
}

$userID = $_SESSION["userID"];

// Get event ID from URL
if (!isset($_GET['event_id'])) {
    header("location: c_viewAttendance.php");
    exit;
}

$eventID = $_GET['event_id'];

// Fetch event details
$event = [];
$sql = "SELECT * FROM event WHERE eventID = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "i", $eventID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$event = mysqli_fetch_assoc($result);

// Fetch attendance records for this event
$participants = [];
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';

// Modified query with LEFT JOINs to ensure all attendance records show up
$sql = "SELECT a.StudentID, a.date, a.time, 
               COALESCE(u.username, 'Unknown') AS username,
               COALESCE(u.email, 'N/A') AS email
        FROM attendance a 
        LEFT JOIN attendanceslot ats ON a.slot_ID = ats.slot_ID
        LEFT JOIN student s ON a.StudentID = s.studentID 
        LEFT JOIN user u ON s.userID = u.userID
        WHERE ats.eventID = ?";

// Add search condition if search term exists
if (!empty($search_term)) {
    $sql .= " AND (a.StudentID LIKE ? OR u.username LIKE ?)";
    $search_param = "%" . $search_term . "%";
}

$stmt = mysqli_prepare($link, $sql);

if (!empty($search_term)) {
    mysqli_stmt_bind_param($stmt, "iss", $eventID, $search_param, $search_param);
} else {
    mysqli_stmt_bind_param($stmt, "i", $eventID);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Debugging - uncomment to see raw query results
// echo "<pre>"; print_r(mysqli_fetch_all($result, MYSQLI_ASSOC)); echo "</pre>"; exit;

$participants = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch username from database for header
$queryUser = "SELECT username FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

$loggedInUser = !empty($userData["username"]) ? ucwords(strtolower($userData["username"])) : "User";
?>

<!DOCTYPE html>
<html>

<head>
    <title>EVENT ATTENDANCE DETAILS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .header1 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #0074e4;
            padding: 10px 20px;
            margin-left: 160px;
            color: white;
        }

        .header-right {
            display: flex;
            align-items: center;
        }

        .header-right .logout {
            color: white;
            font-size: 14px;
            margin-right: 15px;
            text-decoration: none;
            transition: color 0.3s;
        }

        .header-right .logout:hover {
            color: #ddd;
        }

        .header-center {
            text-align: center;
            flex-grow: 1;
        }

        .header-center h2 {
            margin: 0;
            font-size: 22px;
        }

        .header-center p {
            margin: 0;
            font-size: 14px;
        }

        .nav {
            height: 100%;
            width: 170px;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #0074e4;
            overflow-x: hidden;
            padding-top: 20px;
        }

        .nav a {
            padding: 6px 8px 6px 16px;
            margin: 10px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav a.active {
            background-color: #0264c2;
            color: white;
        }

        .nav a:hover {
            background-color: #0264c2;
            transition: all 0.4s ease;
        }

        .sub-menu {
            background: #044e95;
            display: none;
        }

        .sub-menu a {
            padding-left: 30px;
            font-size: 12px;
        }

        .content {
            background-color: #e6f0ff;
            margin-left: 170px;
            width: calc(100% - 170px);
            min-height: 100vh;
            padding-bottom: 100px;
            position: relative;
        }

        .event-details {
            background-color: white;
            margin: 20px 40px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .event-details h2 {
            margin-top: 0;
            color: #0074e4;
        }

        .event-details p {
            margin: 10px 0;
        }

        .participants-table {
            width: 90%;
            border-collapse: collapse;
            background: white;
            margin: 20px 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .participants-table th, .participants-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .participants-table th {
            background-color: #0074e4;
            color: white;
        }

        .participants-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .back-btn {
            background-color: #0074e4;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 20px 40px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }

        .back-btn:hover {
            background-color: #005bb5;
        }
        
        .logo {
            height: 40px;
            margin: 10px;
        }
        
        .logo2 {
            height: 35px;
            margin: 10px;
        }
        
        .status.active {
            color: green;
            font-weight: bold;
        }
        
        .status.canceled {
            color: red;
            font-weight: bold;
        }
        
        .status.postpone {
            color: orange;
            font-weight: bold;
        }

        .search-container {
            margin: 20px 40px;
            display: flex;
            gap: 10px;
        }
        
        .search-container input {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }
        
        .search-container button {
            background-color: #0074e4;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        
        .search-container button:hover {
            background-color: #005bb5;
        }
    </style>
</head>

<body>
    <div class="header1">
        <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo">
        <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
        <div class="header-center">
            <h2>Event Attendance Details</h2>
            <p>Coordinator: <?php echo htmlspecialchars($loggedInUser); ?></p>
        </div>
        <div class="header-right">
            <a href="logout_button.php" class="logout">Logout</a>
            <a href="c_displayProfile.php">
                <img src="images/profile.png" alt="Profile" class="logo2">
            </a>
        </div>
    </div>

    <div class="nav">
        <div class="menu">
            <div class="item"><a href="c_homepage.php">Dashboard</a></div>

            <div class="item">
                <a href="#" class="sub-button">Users<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="c_manageProfile.php" class="sub-item">Manage Profile</a>
                    <a href="c_addNewUser.php" class="sub-item">Add New User</a>
                </div>
            </div>

            <div class="item">
                <a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="c_membership.php" class="sub-item">Membership Approval</a>
                </div>
            </div>

            <div class="item">
                <a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="#events" class="sub-item">View Event</a>
                    <a href="c_viewAttendance.php" class="sub-item active">Event Attendance</a>
                    <a href="c_meritApp.php" class="sub-item">Merit Application</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="event-details">
            <h2><?php echo isset($event['eventName']) ? htmlspecialchars($event['eventName']) : 'Event Not Found'; ?></h2>
            <p><strong>Date:</strong> <?php echo isset($event['eventDate']) ? htmlspecialchars($event['eventDate']) : 'N/A'; ?></p>
            <p><strong>Location:</strong> <?php echo isset($event['eventLocation']) ? htmlspecialchars($event['eventLocation']) : 'N/A'; ?></p>
            <p><strong>Description:</strong> <?php echo isset($event['eventDesc']) ? htmlspecialchars($event['eventDesc']) : 'N/A'; ?></p>
            <p><strong>Status:</strong> <span class="status <?php echo isset($event['status']) ? strtolower($event['status']) : ''; ?>">
                <?php echo isset($event['status']) ? htmlspecialchars($event['status']) : 'N/A'; ?>
            </span></p>
        </div>

        <div class="search-container">
            <form method="GET" action="">
                <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($eventID); ?>">
                <input type="text" name="search" placeholder="Search by Student ID or Name..." value="<?php echo htmlspecialchars($search_term); ?>">
                <button type="submit">Search</button>
                <?php if (!empty($search_term)): ?>
                    <a href="?event_id=<?php echo htmlspecialchars($eventID); ?>" style="margin-left: 10px;">Clear Search</a>
                <?php endif; ?>
            </form>
        </div>

        <h2 style="margin: 20px 40px;">Participants List</h2>
        
        <table class="participants-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Attendance Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($participants) > 0): ?>
                    <?php foreach ($participants as $index => $participant): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($participant['StudentID']); ?></td>
                            <td><?php echo htmlspecialchars($participant['username']); ?></td>
                            <td><?php echo htmlspecialchars($participant['email']); ?></td>
                            <td><?php 
                                echo (isset($participant['date']) && isset($participant['time'])) 
                                    ? htmlspecialchars($participant['date'] . ' ' . $participant['time'])
                                    : 'Not attended';
                            ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">
                            <?php echo !empty($search_term) ? 'No matching participants found' : 'No attendance records found for this event'; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <button class="back-btn" onclick="window.location.href='c_viewAttendance.php'">Back to Events</button>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.sub-button').click(function() {
                $(this).next('.sub-menu').slideToggle();
            });
        });
    </script>
</body>
</html>