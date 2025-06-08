<?php
require_once "config.php";

// Initialize the session
session_start();

// Check if the user is logged in and is a coordinator, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'Coordinator') {
    header("location: login_page.php");
    exit;
}

$userID = $_SESSION["userID"];

// Fetch username from database
$queryUser = "SELECT username FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

// Assign username after database query
$loggedInUser = !empty($userData["username"]) ? ucwords(strtolower($userData["username"])) : "User";

// Fetch events from database
$events = [];
$sql = "SELECT eventID, eventName, eventDate, status FROM event";
$result = mysqli_query($link, $sql);

if ($result) {
    $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    die("Database error: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>COORDINATOR VIEW EVENTS</title>
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

        .event-table {
            width: 90%;
            border-collapse: collapse;
            background: white;
            margin: 20px 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .event-table th, .event-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .event-table th {
            background-color: #0074e4;
            color: white;
        }

        .event-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-btn {
            background-color: #0074e4;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: 0.3s;
        }

        .action-btn:hover {
            background-color: #005bb5;
        }

        .action-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
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
        
        .logo {
            height: 40px;
            margin: 10px;
        }
        
        .logo2 {
            height: 35px;
            margin: 10px;
        }
    </style>
</head>

<body>
    <div class="header1">
        <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo">
        <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
        <div class="header-center">
            <h2>View Events</h2>
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
                    <a href="#events" class="sub-item active">View Event</a>
                    <a href="c_viewAttendance.php" class="sub-item">Event Attendance</a>
                    <a href="c_meritApp.php" class="sub-item">Merit Application</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <table class="event-table">
            <thead>
                <tr>
                    <th>EVENT NAME</th>
                    <th>DATE</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['eventName']); ?></td>
                        <td><?php echo htmlspecialchars($event['eventDate']); ?></td>
                        <td class="status <?php echo strtolower($event['status']); ?>">
                            <?php echo htmlspecialchars($event['status']); ?>
                        </td>
                        <td>
                            <a href="c_viewAttendance2.php?event_id=<?php echo $event['eventID']; ?>">
                                <button class="action-btn" <?php echo strtoupper($event['status']) !== 'ACTIVE' ? 'disabled' : ''; ?>>
                                    View Attendance
                                </button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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