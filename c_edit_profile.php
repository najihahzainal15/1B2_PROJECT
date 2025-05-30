<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login_page.php");
    exit;
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

// Get data from user table
$queryUser = "SELECT username, email, phone_No, password FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

// Get data from coordinator table
$queryCoordinator = "SELECT coordinatorID, year_of_service FROM petakomcoordinator WHERE userID = ?";
$stmtCoordinator = mysqli_prepare($link, $queryCoordinator);
mysqli_stmt_bind_param($stmtCoordinator, "i", $userID);
mysqli_stmt_execute($stmtCoordinator);
$resultCoordinator = mysqli_stmt_get_result($stmtCoordinator);
$coordinatorData = mysqli_fetch_assoc($resultCoordinator);

// Assign to variables
$uName = $userData["username"] ?? '';
$uEmail = $userData["email"] ?? '';
$cID = $coordinatorData["coordinatorID"] ?? '';
$uPhone = $userData["phone_No"] ?? '';
$cYearService = $coordinatorData["year_of_service"] ?? '';
$currpass = $_POST['currpass'] ?? '';
$newpass = $_POST['npass'] ?? '';
$conpass = $_POST['conpass'] ?? '';
$loggedInUser = !empty($userData["username"]) ? ucwords(strtolower($userData["username"])) : "User";
?>
<!DOCTYPE html>
<html>

<head>
    <title>COORDINATOR EDIT PROFILE</title>
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

        .cancel-button {
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
            margin: 5px 0 14px 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .cancel-button:hover {
            background-color: #005bb5;
        }

        .save-button {
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
            margin: 5px 25px;
            cursor: pointer;
            transition: 0.3s;
            float: right;
        }

        .save-button:hover {
            background-color: #005bb5;
        }


        .content {
            background-color: #e6f0ff;
            margin-left: 160px;
            height: auto;
        }


        .logo {
            height: 40px;
            margin: 10px;
        }

        .logo2 {
            height: 35px;
            margin: 10px;
        }

        .events-container {
            height: auto;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 30px;
            margin-left: 30px;
        }

        .event {
            width: 300px;
            height: 330px;
            background: white;
            margin: 20px;
            box-sizing: border-box;
            font-size: 14px;
            box-shadow: 0px 0px 10px 2px grey;
            transition: 1s;
        }

        .event:hover {
            transform: scale(1.05);
            z-index: 2;
        }

        .eventImage {
            height: 260px;
            width: 300px;
            justify-content: center;
            align-items: center;
        }

        .details1 {
            margin: 5px 0px 20px 0px;
            padding-left: 10px;
            height: 30px;
            font-family: 'Poppins', sans-serif;
            width: 30%;
            border: 1px solid #DCDCDC;
            border-radius: 4px;
            border-bottom-width: 2px;
            transition: 0.3s;
        }

        .details2 {
            margin: 5px 0px 20px 0px;
            padding-left: 10px;
            height: 30px;
            font-family: 'Poppins', sans-serif;
            width: 16%;
            border: 1px solid #DCDCDC;
            border-radius: 4px;
            border-bottom-width: 2px;
            transition: 0.3s;
        }

        .details3 {
            margin: 5px 0px 20px 0px;
            padding-left: 10px;
            height: 30px;
            font-family: 'Poppins', sans-serif;
            width: 20%;
            border: 1px solid #DCDCDC;
            border-radius: 4px;
            border-bottom-width: 2px;
            transition: 0.3s;
        }

        form {
            margin-left: 40px;
        }

        .select1 {
            font-family: 'Poppins', sans-serif;
            margin: 5px 0px 25px 0px;
            padding: 3px 100px;
            color: black;
            width: 60%;
            background-color: white;
            border: 1px solid #DCDCDC;
            border-radius: 4px;
            border-bottom-width: 2px;
        }

        .select2 {
            font-family: 'Poppins', sans-serif;
            margin: 5px 0px 25px 0px;
            padding: 3px 100px;
            color: black;
            width: 35%;
            background-color: white;
            border: 1px solid #DCDCDC;
            border-radius: 4px;
            border-bottom-width: 2px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header1">
        <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo" />
        <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo" />
        <div class="header-center">
            <h2>Profile Settings</h2>
            <p>Petakom Coordinator: <?php echo  htmlspecialchars($loggedInUser); ?></p>
        </div>
        <div class="header-right">
            <a href="logout_button.php" class="logout">Logout</a>
            <a href="s_edit_profile.php">
                <img src="images/profile.png" alt="Profile" class="logo2">
            </a>
        </div>
    </div>

    <div class="nav">
        <div class="menu">
            <div class="item"><a class="active" href="c_homepage.php">Dashboard</a></div>

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
                    <a href="c_meritApp.php" class="sub-item">Merit Application</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <br>
        <form action="c_editProfile2.php" method="POST" class="form">

            <label>Full Name</label><br>
            <input type="text" name="username" placeholder="Enter your name" class="details1" value="<?php echo $uName; ?>"><br>

            <label>Email Address</label><br>
            <input type="email" name="email" placeholder="Enter your email address" class="details1" value="<?php echo $uEmail; ?>"><br>

            <label>Coordinator ID</label><br>
            <input type="text" name="coordinatorID" placeholder="Enter your coordinator ID" class="details2" value="<?php echo $cID; ?>"><br>

            <label>Phone Number</label><br>
            <input type="text" name="phone_No" placeholder="Enter your phone number" class="details2" value="<?php echo $uPhone; ?>"><br>

            <label>Year of Service</label><br>
            <input type="text" name="year_of_service" placeholder="Enter your year of service" class="details2" value="<?php echo $cYearService; ?>"><br>

            <label>Current Password</label><br>
            <input type="password" name="currpass" placeholder="Enter your current password" class="details3"><br>

            <label>New Password</label><br>
            <input type="password" name="npass" placeholder="Enter your new password" class="details3"><br>

            <label>Confirm Password</label><br>
            <input type="password" name="conpass" placeholder="Confirm new password" class="details3"><br>

            <br>
            <input type="hidden" name="id2" value="<?php echo $userID; ?>">
            <a href="s_displayProfile.php" class="cancel-button">Cancel</a>
            <input type="submit" class="save-button" value="Save">

        </form>

        <script type="text/javascript">
            $(document).ready(function() {
                $('.sub-button').click(function() {
                    $(this).next('.sub-menu').slideToggle();
                });
            });
        </script>
</body>

</html>