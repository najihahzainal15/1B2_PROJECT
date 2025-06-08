<?php
require_once "config.php";
// Initialize the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login_page.php");
    exit();
}
// Fetch events from database
$events = [];
$sql = "SELECT eventID, eventName, eventDate, status FROM event";
$result = mysqli_query($link, $sql);

if ($result) {
    $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    die("Database error: " . mysqli_error($link));
}

$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());
$userID = $_SESSION["userID"];
$role = $_SESSION["role"];

// Get user's name from the database
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
    <title>VERIFY ATTENDANCE 1</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            /* space between Logout and profile icon */
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

        h2 {
            margin: 0px 40px;
            font-size: 25px;
        }

        p {
            margin: 0px 40px;
            font-size: 16px;
        }

        .p1 {
            margin: 5px;
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

        .button {
            background-color: #D2D2D2;
            border: 2px solid #D0D0D0;
            color: black;
            padding: 16px 30px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 25px;
            cursor: pointer;
        }

        .content {
            background-color: #e6f0ff;
            margin-left: 160px;
            /* leave space for the nav */
            padding: 20px;
            min-height: calc(100vh - 60px);
            /* subtract the height of header */
            box-sizing: border-box;
        }

        .logo {
            height: 40px;
            margin: 10px;
        }

        .logo2 {
            height: 35px;
            margin: 10px;
        }

        .register-btn,
        .back-btn {
            background: #e6e6e6;
            padding: 10px 20px;
            border: 2px solid #999;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .back-btn {
            background-color: #0074e4;
            font-family: 'Poppins', sans-serif;
            border: none;
            border-radius: 10px;
            color: white;
            padding: 6px 14px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 20px 0 20px 30px;
            cursor: pointer;
            transition: 0.3s;
        }

        .event-table {
            width: 90%;
            border-collapse: collapse;
            background: #d0e6ff;
            margin: 30px auto;
            /* Center horizontally and add vertical spacing */
        }

        .event-table th,
        .event-table td {
            border: 2px solid #666;
            padding: 10px;
            text-align: center;
        }

        .status.active {
            background-color: #c6f6c6;
            font-weight: bold;
        }

        .status.canceled {
            background-color: #f6c6c6;
            font-weight: bold;
        }

        .status.postpone {
            background-color: #fff0b3;
            font-weight: bold;
        }

        .action-btn {
            margin: 0 5px;
            padding: 5px 10px;
            font-weight: bold;
            cursor: pointer;
        }

        .tbody {
            background-color: white;
        }

        .submit-button {
            background-color: #0074e4;
            font-family: 'Poppins', sans-serif;
            border: none;
            border-radius: 10px;
            color: white;
            padding: 8px 14px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 25px;
            cursor: pointer;
            transition: 0.3s;
            float: left;
        }

        .submit-button:hover {
            background-color: #005bb5;
        }

        td .QRButton {
            border-style: none;
            background-color: #6666f0ff;
        }
    </style>
</head>

<body>

    <div class="header1">
        <img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
        <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
        <div class="header-center">
            <h2>Attendance Slot</h2>
            <p>Student: <?php echo  htmlspecialchars($loggedInUser); ?></p>
        </div>
        <div class="header-right">
            <a href="logout_button.php" class="logout">Logout</a>
            <a href="s_displayProfile.php">
                <img src="images/profile.png" alt="Profile" class="logo2">
            </a>
        </div>
    </div>

    <div class="nav">
        <div class="menu">
            <div class="item"><a href="s_homepage.php">Dashboard</a></div>

            <div class="item">
                <a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="s_membership.php" class="sub-item">Membership Application</a>
                </div>
            </div>

            <div class="item">
                <a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="s_membershipAppView.php" class="sub-item">View Event</a>
                </div>
            </div>

            <div class="item">
                <a href="#attendance" class="sub-button active-parent">Attendance<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="s_attendance1.php" class="sub-item active">Attendance Slot</a>
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
                    <th>ATTENDANCE QR GENERATOR</th>
                </tr>
            </thead>
            <tbody class="tbody">
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['eventName']); ?></td>
                        <td><?php echo htmlspecialchars($event['eventDate']); ?></td>
                        <td class="status <?php echo strtolower($event['status']); ?>">
                            <?php echo htmlspecialchars($event['status']); ?>
                        </td>

                        <td class="QRButton">
                            <?php if (strtoupper($event['status']) === 'ACTIVE'): ?>
                                <a href="s_attendance2.php?event_id=<?php echo $event['eventID']; ?>">
                                    <button class="action-btn">VERIFY ATTENDANCE</button>
                                </a>
                            <?php else: ?>
                                <span style="color: grey; font-weight: bold;">Unavailable</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <br>
    <br>

    <button class="submit-button">Back</button>
    </main>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.sub-button').click(function() {
                $(this).next('.sub-menu').slideToggle();
            });

            // Automatically open sub-menu if it contains an active item
            $('.sub-menu').each(function() {
                if ($(this).find('.active').length > 0) {
                    $(this).show();
                    $(this).prev('.sub-button').addClass('active-parent');
                }
            });
        });
    </script>
</body>

</html>