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

$statusFilter = $_GET['status'] ?? '';
if ($statusFilter !== '') {
  $query = "SELECT * FROM event WHERE meritStatus = '" . mysqli_real_escape_string($link, $statusFilter) . "'";
} else {
  $query = "SELECT * FROM event";
}


$result = mysqli_query($link, $query);

?>


<!DOCTYPE html>
<html>

<head>
  <title> EVENT ADVISOR MERIT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    p {
      margin: 0px 40px;
      font-size: 16px;
    }

    .p1 {
      margin: 5px;
      font-size: 14px;
    }


    h2 {
      margin: 0px 40px;
      font-size: 25px;
      color: black;
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

    form label {
      font-weight: bold;
    }

    form select,
    form button {
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
    }





    .content {
      margin-left: 150px;
      padding: 20px;
      background-color: #e6f0ff;
      display: flex;
      justify-content: center;
      overflow-x: auto;
      /* allow horizontal scroll if needed */
    }

    .table-container {
      padding: 40px;
      background-color: #F2F2F2;
      width: 150%;
      /* Increased from 80% */
      max-width: 1400px;
      /* Optional: limits max width on very large screens */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }


    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: auto;
      word-wrap: break-word;
      /* wrap long text */
      font-size: 13px;
      /* slightly smaller font */
    }

    table th,
    table td {
      padding: 15px;
      border: 1px solid #ddd;
      text-align: center;
      vertical-align: middle;
      word-wrap: break-word;
      /* wrap long text */
      white-space: normal;
      /* allow wrapping */
    }

    table th {
      background-color: #0096D6;
      color: white;
    }

    th:nth-child(4),
    td:nth-child(4) {
      width: 15%;
      /* Increase width */
    }

    th:nth-child(6),
    td:nth-child(6) {
      width: 20%;

    }

    th:nth-child(1),
    td:nth-child(1) {
      width: 11%;

    }

    th:nth-child(2),
    td:nth-child(2) {
      width: 8%;

    }

    th:nth-child(3),
    td:nth-child(3) {
      width: 8%;

    }


    th:nth-child(5),
    td:nth-child(5) {
      width: 13%;

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
      color: white;
    }

    .header-center p {
      margin: 0;
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

    table thead th {
      background-color: #0096D6;
      color: white;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    table tbody tr:hover {
      background-color: #e0f0ff;
      transition: background-color 0.2s ease;
    }

    table td,
    table th {
      padding: 12px 10px;
      text-align: center;
      vertical-align: middle;
      border: 1px solid #ddd;
    }

    a {
      color: #0066cc;
      text-decoration: none;
      font-weight: 600;
    }

    a:hover {
      text-decoration: underline;
    }

    td a {
      margin: 0 4px;
    }



    .content {
      margin-left: 170px;
      padding: 10px;
      background-color: #e6f0ff;
      display: flex;
      justify-content: center;
    }

    .table-container {
      padding: 20px;
      background-color: #F2F2F2;
      max-width: 100%;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .section-header {
      background: #f0f0f0;
      padding: 12px;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      border-top: 2px solid black;
      border-bottom: 2px solid black;
    }

    <style>body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
    }

    p {
      margin: 0px 40px;
      font-size: 16px;
    }

    .p1 {
      margin: 5px;
      font-size: 14px;
    }

    h2 {
      margin: 0px 40px;
      font-size: 25px;
      color: black;
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

    .nav a.active,
    .nav a:hover {
      background-color: #0264c2;
      color: white;
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

    form label {
      font-weight: bold;
    }

    form select,
    form button {
      font-family: 'Poppins', sans-serif;
      font-size: 14px;
    }

    .content {
      margin-left: 170px;
      padding: 10px;
      background-color: #e6f0ff;
      display: flex;
      justify-content: center;
      overflow-x: auto;
    }

    .table-container {
      padding: 20px 40px;
      background-color: #F2F2F2;
      width: 150%;
      max-width: 1400px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: auto;
      word-wrap: break-word;
      font-size: 13px;
    }

    table th,
    table td {
      padding: 12px 10px;
      border: 1px solid #ddd;
      text-align: center;
      vertical-align: middle;
      word-wrap: break-word;
      white-space: normal;
    }

    table th {
      background-color: #0096D6;
      color: white;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    table tbody tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    table tbody tr:hover {
      background-color: #e0f0ff;
      transition: background-color 0.2s ease;
    }

    th:nth-child(1),
    td:nth-child(1) {
      width: 11%;
    }

    th:nth-child(2),
    td:nth-child(2) {
      width: 8%;
    }

    th:nth-child(3),
    td:nth-child(3) {
      width: 8%;
    }

    th:nth-child(4),
    td:nth-child(4) {
      width: 15%;
    }

    th:nth-child(5),
    td:nth-child(5) {
      width: 13%;
    }

    th:nth-child(6),
    td:nth-child(6) {
      width: 20%;
    }

    .section-header {
      background: #f0f0f0;
      padding: 12px;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      border-top: 2px solid black;
      border-bottom: 2px solid black;
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
      color: white;
    }

    .header-center p {
      margin: 0;
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

    a {
      color: #0066cc;
      text-decoration: none;
      font-weight: 600;
    }

    a:hover {
      text-decoration: underline;
    }

    td a {
      margin: 0 4px;
    }

    /* Unified Blue Button Styles */
    .edit-btn,
    .view-btn,
    form button {
      padding: 6px 12px;
      background-color: #0074e4;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
      font-size: 13px;
    }

    .edit-btn:hover,
    .view-btn:hover,
    form button:hover {
      background-color: #005bb5;
    }

    @media (max-width: 768px) {
      .nav {
        width: 100px;
      }

      table th,
      table td {
        padding: 6px 4px;
        font-size: 11px;
      }
    }
  </style>


  </style>
</head>

<body>

  <div class="header1">
    <img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
    <div class="header-center">
      <h2>Merit Application</h2>
      <p>Petakom Coordinator: <?php echo htmlspecialchars($loggedInUser); ?></p>
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
          <a class="active" href="c_meritApp.php" class="sub-item">Merit Application</a>
        </div>
      </div>
    </div>
  </div>



  <div class="content">
    <div class="table-container">
      <div class="section-header">MERIT APPLICATION</div>
      <table border="1" cellspacing="0" cellpadding="5">

        <form method="GET" style="margin-bottom: 20px; text-align: right;">
          <label for="status">Filter by Merit Status:</label>
          <select name="status" id="status" style="padding: 6px 10px; border-radius: 5px; border: 1px solid #ccc; margin-left: 10px;">
            <option value="">-- All --</option>
            <option value="Pending" <?php if ($_GET['status'] ?? '' === 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="Approved" <?php if ($_GET['status'] ?? '' === 'Approved') echo 'selected'; ?>>Approved</option>
            <option value="Rejected" <?php if ($_GET['status'] ?? '' === 'Rejected') echo 'selected'; ?>>Rejected</option>
          </select>
          <button type="submit" style="padding: 6px 12px; background-color: #0074e4; color: white; border: none; border-radius: 5px; margin-left: 10px;">Search</button>
        </form>

        <thead>
          <tr>
            <th>EVENT NAME</th>
            <th>DATE</th>
            <th>TIME</th>
            <th>GEOLOCATION</th>
            <th>VENUE</th>
            <th>DESCRIPTION</th>
            <th>APPROVAL LETTER</th>
            <th>MERIT SCORE</th>
            <th>STATUS</th>
            <th>ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $eventID = htmlspecialchars($row["eventID"]);
              $eventName = htmlspecialchars($row["eventName"]);
              $date = htmlspecialchars($row["eventDate"]);
              $time = htmlspecialchars($row["eventTime"]);
              $geolocation = htmlspecialchars($row["eventGeolocation"]);
              $venue = htmlspecialchars($row["eventLocation"]);
              $desc = htmlspecialchars($row["eventDesc"]);
              $app = htmlspecialchars($row["approvalLetterPath"]);
              $meritStatus = htmlspecialchars($row["meritStatus"]);
              $meritScore = htmlspecialchars($row["meritScore"]);

              echo "<tr>";
              echo "<td>$eventName</td>";
              echo "<td>$date</td>";
              echo "<td>$time</td>";
              echo "<td>$geolocation</td>";
              echo "<td>$venue</td>";
              echo "<td>$desc</td>";
              echo "<td>
  <a href='$app' target='_blank'>
    <button class='view-btn'>View</button>
  </a>
</td>";





              echo "<td>$meritScore</td>";
              echo "<td>$meritStatus</td>";


              echo "<td>
  <a href='c_meritAppUpdate3.php?eventID=$eventID'>
    <button class='edit-btn'>Edit</button>
  </a>
</td>";
            }
          } else {
            echo "<tr><td colspan='10'>No committee records found.</td></tr>";
          }

          mysqli_close($link);
          ?>
        </tbody>
      </table>

    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.sub-button').click(function() {
        $(this).next('.sub-menu').slideToggle();
      });
    });