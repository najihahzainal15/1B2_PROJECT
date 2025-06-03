<?php
// db_connect.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>EVENT ADVISOR REGISTER COMMITTEE</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MyPetakom Event Advisor Homepage</title>
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
      padding: 10px 50px;
      margin-left: 120px;
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
      margin-left: 170px;
      padding: 20px;
      background-color: #e6f0ff;
      display: flex;
      justify-content: center;
      width: calc(100% - 170px);
      /* Use available space */
      flex-direction: column;
      /* Stack items vertically */
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

    .logo {
      height: 40px;
      margin: 10px;
    }

    .logo2 {
      height: 35px;
      margin: 10px;
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
      <p>Event Advisor: Prof. Hakeem</p>
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
        <a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="ea_viewEvent.php" class="sub-item">View Event</a>
          <a href="ea_registerEvent1.php" class="sub-item">Register New Event</a>
          <a href="ea_eventCommittee.php" class="sub-item">Event Committee</a>
          <a href="ea_committeeReg.php" class="sub-item">Register Committee Event</a>
        </div>
      </div>

      <div class="item">
        <a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="ea_attendanceSlot.php" class="sub-item">Attendance Slot</a>
        </div>
      </div>
    </div>
  </div>

  <?php
  $servername = "localhost";
  $username = "root";        // Your MySQL username
  $password = "";            // Your MySQL password (often empty for localhost)
  $dbname = "web_project";  // Your database name

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
            <label for="roleID">Select Role:</label>
            <select name="roleID" required>
              <option value="">-- Select Role --</option>
              <?php
              $conn = new mysqli("localhost", "root", "", "web_project");
              $sql = "SELECT roleID, committeeRole FROM committeerole ORDER BY committeeRole ASC";
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['roleID'] . '">' . htmlspecialchars($row['committeeRole']) . '</option>';
              }
              $conn->close();
              ?>
            </select>

          </div>

          <div class="form-group">
            <label for="student-id">STUDENT ID</label>
            <input type="text" id="student-id" name="student_id" placeholder="CB23077">
          </div>

          <div class="form-actions">
            <button type="button" class="submit-button" onclick="window.location.href='ea_eventCommittee.php'">Back</button>
            <button type="submit" class="submit-button">Register</button>
          </div>

        </form>

        </select>
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

  <script>
    $(document).ready(function() {
      $('.sub-button').click(function(event) {
        event.preventDefault(); // Prevent page jump
        let $submenu = $(this).next('.sub-menu');

        if ($submenu.hasClass('open')) {
          $submenu.slideUp().removeClass('open'); // Close if it's open
        } else {
          $('.sub-menu').slideUp().removeClass('open'); // Close all others
          $submenu.slideDown().addClass('open'); // Open clicked one
        }
      });

      // Load events dynamically
      $.ajax({
        url: 'ea_committeeReg2.php',
        method: 'GET',
        dataType: 'json',
        success: function(events) {
          let $dropdown = $('#event');
          $dropdown.empty(); // Clear existing options
          $dropdown.append('<option value="">Select an event</option>');

          events.forEach(function(event) {
            let optionText = event.event_name;
            $dropdown.append(`<option value="${event.event_id}">${optionText}</option>`);
          });
        },
        error: function() {
          alert('Failed to load events. Please try again.');
        }
      });
    });
  </script>

</body>

</html>