<?php
session_start(); // Start the session at the very beginning

// Database connection
$servername = "localhost";
$username = "root"; // Your database username
$password = "";     // Your database password
$dbname = "web_project"; // CORRECTED: Your actual database name from the image

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$loggedInStudentName = "Guest"; // Default name
$loggedInStudentEmail = ""; // Default email
$loggedInStudentId = ""; // Default student ID

if (isset($_SESSION['email'])) {
    $loggedInStudentEmail = $_SESSION['email'];

    // Fetch user's username (for display) and the associated studentID based on the logged-in email
    // Join user and student tables using userID
    $stmt = $conn->prepare("
        SELECT u.username, s.studentID
        FROM user u
        JOIN student s ON u.userID = s.userID
        WHERE u.email = ?
    ");
    $stmt->bind_param("s", $loggedInStudentEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $loggedInStudentName = $row['username']; // Use 'username' from 'user' table as the student's display name
        $loggedInStudentId = $row['studentID']; // Get 'studentID' from 'student' table
    }
    $stmt->close();
} else {
    // If no email in session, redirect to login page (or handle as appropriate)
    header("Location: login_page.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>View Event</title>
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
      overflow: hidden;
      background-color: #0074e4;
      padding: 0px 10px;
      margin-left: 160px;
    }
    .header-right {
      float: right;
      display: flex;
      align-items: center;
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
      color: white;
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
      margin-left: 150px;
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
    .actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      padding: 0 20px 30px;
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



    .section-header {
      background: #f0f0f0;
      padding: 12px;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      border-top: 2px solid black;
      border-bottom: 2px solid black;
    }
    .identity-row {
      display: flex;
      justify-content: center;
      gap: 10px;
      padding: 20px;
    }
    .identity-row input {
      text-align: center;
      font-weight: bold;
      font-size: 14px;
      padding: 10px;
      border: 2px solid black;
      background: white;
      border-radius: 5px;
    }
    .event-details {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 10px;
      background: #b3d9ff;
      padding: 20px;
    }
    .event-details label {
      background: #d3d3d3;
      font-weight: bold;
      padding: 10px;
      text-align: center;
      border: 2px solid black;
    }
    .event-details input {
      padding: 10px;
      font-weight: bold;
      background: white;
      border: 2px solid black;
    }

    .btn-group {
      display: flex;
      justify-content: space-between;
      /* Ensures buttons are at opposite ends */
      padding: 0 20px 30px;
    }


    .btn {
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      background: white;
      border: 2px solid black;
      border-radius: 8px;
      cursor: pointer;
    }
    .btn:hover {
      background: #f0f0f0;
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
      float: right;
      display: flex;
      align-items: center;
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
    .header-left {
      display: flex;
      align-items: center;
      gap: 10px;
      min-width: 120px;
    }

    .logo {
      height: 40px;
    }
    .logo2 {
      height: 35px;
      border-radius: 50%;
    }
    .back-button {
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
    }
    .back-button:hover {
      background-color: #005bb5;
    }
    .download-button {
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
    }
    .download-button:hover {
      background-color: #005bb5;
    }
    .tbody {
      background-color: white;
    }
  </style>
</head>
<body>
  <div class="header1">
    <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">

    <div class="header-center">
      <h2>View Event</h2>
      <p>Student: <?php echo htmlspecialchars($loggedInStudentName); ?></p>
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
          <a href="s_committeeAppView.php" class="sub-item active">View Event</a>
        </div>
      </div>
      <div class="item">
        <a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="s_attendance1.php" class="sub-item">Attendance Slot</a>
        </div>
      </div>
    </div>
  </div>
  <div class="content">
    <div class="table-container">
      <div class="section-header">EVENT DETAILS</div>

            <table>
        <thead>
          <tr>
            <th>Student ID</th>
            <th>Committee Role</th>
            <th>Event Name</th>
            <th>Event Date</th>
            <th>Event Location</th>
            <th>Event Status</th>
          </tr>
        </thead>
        <tbody class="tbody">
          <?php
          if (!empty($loggedInStudentId)) {
              // Fetch event details for the logged-in student
              // ASSUMPTIONS:
              // - Your event_participation table has 'studentID' and 'event_id'
              // - Your events table has 'event_id', 'event_name', 'event_date', 'event_location', 'event_status'
              // Please adjust 'event_participation' and 'events' table/column names if they differ.
              $stmt = $conn->prepare("
                  SELECT
                      s.studentID, /* Corrected: Use studentID from the student table */
                      ep.committee_role,
                      e.event_name,
                      e.event_date,
                      e.event_location,
                      e.event_status
                  FROM
                      student s /* Corrected: Use the 'student' table */
                  JOIN
                      event_participation ep ON s.studentID = ep.studentID /* Corrected: Join on studentID */
                  JOIN
                      events e ON ep.event_id = e.event_id
                  WHERE
                      s.studentID = ?
              ");
              $stmt->bind_param("s", $loggedInStudentId);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . htmlspecialchars($row['studentID']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['committee_role']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['event_date']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['event_location']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['event_status']) . "</td>";
                      echo "</tr>";
                  }
              } else {
                  echo "<tr><td colspan='6'>No events found for this student.</td></tr>";
              }
              $stmt->close();
          } else {
              echo "<tr><td colspan='6'>Student ID not found. Please log in again.</td></tr>";
          }
          $conn->close();
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
