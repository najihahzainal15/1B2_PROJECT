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
  <title>EVENT ADVISOR REGISTER COMMITTEE</title>
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
      height: auto;
    }

    @media (max-width: 800px) {
      .table-container {
        margin-left: 20px;
        margin-right: 20px;
        width: calc(100% - 40px);
        /* Adjust for small screens */
        padding: 10px;
        /* Less padding on small screens */
      }

      .identity-row input,
      .event-details input {
        font-size: 14px;
        /* Smaller text for smaller screens */
      }
    }

    .section-title {
      background: #f0f0f0;
      padding: 12px;
      margin: 0;
      text-align: center;
      font-size: 20px;
      font-weight: bold;
      border-top: 2px solid #000;
      border-bottom: 2px solid #000;
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




    .registration-container {


      margin: 40px;
      padding: 30px;
      background-color: #F2F2F2;
      border: 2px solid #000;
      border-radius: 10px;

    }

    .registration-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-size: 14px;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      background-color: #fff;
      margin-bottom: 5px;
    }

    .form-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    button {
      padding: 10px 20px;
      background-color: #0096D6;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 16px;
    }

    button:hover {
      background-color: #0264c2;
    }


    .logo {
      height: 40px;
      margin: 10px;
    }

    .logo2 {
      height: 35px;
      margin: 10px;
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

    .eventname {
      background-color: white;
      border-top: 2px solid black;
      border-bottom: 2px solid black;
      text-align: center;
    }

    .event-table {
      width: 100%;
      max-width: 600px;
      border-collapse: collapse;
      margin: 20px auto;
      background-color: #f9f9f9;
    }

    .event-table td {
      padding: 10px;
      border: 1px solid #ddd;
      font-size: 18px;
    }

    select {
      width: 100%;
      padding: 8px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #fff;
    }
  </style>
</head>

<body>
  <div class="header1">
    <img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
    <div class="header-center">
      <h2>Register Committee Member</h2>
      <p>Event Advisor: <?php echo  htmlspecialchars($loggedInUser); ?></p>

    </div>
    <div class=" header-right">
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
        <a href="#events" class="sub-button">Events <i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="ea_viewEvent.php">View Event</a>
          <a href="ea_registerEvent1.php">Register New Event</a>
          <a href="ea_eventCommittee.php">Event Committee</a>
          <a class="active" href="ea_committeeReg.php">Register Committee Member</a>
        </div>
      </div>

      <div class="item">
        <a href="#attendance" class="sub-button">Attendance <i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="#attendance">Attendance Slot</a>
        </div>
      </div>


    </div>
  </div>

  <?php
  $servername = "localhost";
  $username = "root";        // Your MySQL username
  $password = "";
  $dbname = "web_project";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  ?>


  <div class="content">
    <div class="table-container">

      <div class="registration-container">
        <h2>COMMITTEE MEMBER REGISTRATION</h2>

        <form action="ea_committeeRegAction.php" method="POST">

          <table class="event-table">
            <tr>
              <td><label for="event">Choose an event:</label></td>
              <td>
                <select id="event" name="event" required>
                  <option value="">Loading events...</option>
                </select>

              </td>
            </tr>
          </table>

          <div class="form-group">
            <label for="name">NAME</label>
            <input type="text" id="name" name="name" placeholder="SITI HAZIRAH">
          </div>

          <div class="form-group">
            <label for="position">POSITION</label>
            <input type="text" id="position" name="position" placeholder="FINANCE ANALYST">
          </div>

          <div class="form-group">
            <label for="student-id">STUDENT ID</label>
            <input type="text" id="student-id" name="student_id" placeholder="CB23077">
          </div>

          <div class="form-actions">
            <button class="submit-button">Back</button>
            <button class="submit-button">Register</button>
          </div>
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