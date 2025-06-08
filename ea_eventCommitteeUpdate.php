<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login_page.php");
  exit;
}

// Database connection
$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());
$userID = $_SESSION["userID"];
$role = $_SESSION["role"];

// Fetch username from database
$queryUser = "SELECT username FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

// Assign username after database query
$loggedInUser = !empty($userData["username"]) ? ucwords(strtolower($userData["username"])) : "User";
?>
<!DOCTYPE html>
<html>

<head>
  <title>EVENT ADVISOR EVENT COMMITTEE</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

    h2 {
      margin: 0px 40px;
      font-size: 20px;
    }

    p {
      margin: 0px 40px;
      font-size: 16px;
    }

    .p1 {
      margin: 5px;
      font-size: 14px;
    }

    .logo {
      height: 40px;
      margin: 10px;
    }

    .logo2 {
      height: 35px;
      margin: 10px;
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
      margin-left: 170px;
      padding: 20px;
      background-color: #e6f0ff;
      min-height: 100vh;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th,
    table td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
    }

    table th {
      background-color: #0096D6;
      color: white;
    }

    button.edit-btn,
    button.delete-btn {
      padding: 5px 10px;
      margin: 0 5px;
      border: none;
      cursor: pointer;
    }

    button.edit-btn {
      background-color: #4CAF50;
      color: white;
    }

    button.delete-btn {
      background-color: #f44336;
      color: white;
    }

    .data {
      background-color: white;
    }

    .button {
      background-color: #0074e4;
      border: none;
      color: white;
      padding: 12px 20px;
      text-align: left;
      text-decoration: none;
      display: block;
      font-size: 16px;
      margin: 10px 0;
      cursor: pointer;
      border-radius: 5px;
      width: fit-content;
    }

    .button:hover {
      background-color: #005bb5;
    }

    .edit-btn:hover {
      background-color: #C5C7C4;
    }

    .delete-btn:hover {
      background-color: #C5C7C4;
    }

    .back {
      text-align: left;
      margin-top: 30px;
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
      margin-left: auto;
    }

    .submit-button:hover {
      background-color: #005bb5;
    }

    .h2 {
      color: black;
    }

    .tbody {
      background-color: white;
    }

    .button-container {
      text-align: left;
      margin-left: 1px;
    }

    .search-container {
      margin: 20px 0;
      padding: 10px 15px;
      background-color: #f0f7ff;
      border-left: 4px solid #0074e4;
      border-radius: 8px;
      width: fit-content;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .search-container label {
      margin-right: 10px;
      font-size: 16px;
      color: #333;
    }

    #searchRole {
      padding: 8px 12px;
      font-size: 14px;
      border: 1px solid #0074e4;
      border-radius: 5px;
      outline: none;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    #searchRole:focus {
      border-color: #005bb5;
      box-shadow: 0 0 5px rgba(0, 116, 228, 0.5);
    }

    .form-center {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: calc(100vh - 100px);
      /* adjust if your header height changes */
    }



    form {
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    label {
      font-weight: bold;
      display: block;
      margin-bottom: 8px;
    }

    select,
    input[type="submit"],
    input[type="reset"] {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    input[type="submit"] {
      background-color: #0074e4;
      color: white;
      border: none;
      cursor: pointer;
    }

    input[type="reset"] {
      background-color: #f44336;
      color: white;
      border: none;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #005bb5;
    }

    input[type="reset"]:hover {
      background-color: #e53935;
    }
  </style>
</head>

<body>
  <div class="header1">
    <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
    <div class="header-center">
      <h2>Committee Event</h2>
      <p>Event Advisor: <?php echo htmlspecialchars($loggedInUser); ?></p>
    </div>
    <div class="header-right">
      <a href="logout_button.php" class="logout">Logout</a>
      <a href="ea_displayProfile.php">
        <img src="images/profile.png" alt="Profile" class="logo2">
      </a>
    </div>
  </div>

  <div class="nav">
    <div class="menu">
      <div class="item"><a href="ea_homepage.php">Dashboard</a></div>
      <div class="item">
        <a href="#" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="ea_viewEvent.php" class="sub-item">View Event</a>
          <a href="ea_registerEvent1.php" class="sub-item">Register New Event</a>
          <a href="ea_eventCommittee.php" class="sub-item">Event Committee</a>
          <a href="ea_committeeReg.php" class="sub-item">Register Committee Event</a>
        </div>
      </div>
      <div class="item">
        <a href="#" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="c_membership.php" class="sub-item">Membership Approval</a>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="form-center">
      <div class="form-wrapper">

        <form method="post" action="ea_eventCommitteeUpdate2.php">
          <label for="roleID">Role:</label>
          <select name="roleID" id="roleID" required>
            <option value='1'>Event Director</option>
            <option value='2'>Vice Director</option>
            <option value='3'>Secretary</option>
            <option value='4'>Assistant Secretary</option>
            <option value='5'>Treasurer</option>
            <option value='6'>Assistant Treasurer</option>
            <option value='7' selected>Technical Coordinator</option>
            <option value='8'>Safety &amp; Health Officer</option>
            <option value='9'>Publicity &amp; Media Team</option>
            <option value='10'>Photographer/Videographer</option>
            <option value='11'>Graphic Designer</option>
            <option value='12'>Sponsorship &amp; Fundraising</option>
          </select>
          <input type="hidden" name="id2" value="27">
          <input type="submit" value="Update">
          <input type="reset" value="Cancel">
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('.sub-button').click(function() {
        $(this).next('.sub-menu').slideToggle();
      });
    });
  </script>
</body>

</html>