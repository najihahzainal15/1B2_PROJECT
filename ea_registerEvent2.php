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

if (isset($_GET['id'])) {
  $id = (int)$_GET['id']; // Cast to int for safety
  $query = "SELECT * FROM event WHERE eventID = $id";
  $result = mysqli_query($link, $query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    $eventName = $row['eventName'];
    $eventDate = $row['eventDate'];
    $eventTime = $row['eventTime'];
    $eventLocation = $row['eventLocation'];
    $eventGeolocation = $row['eventGeolocation'];
    $status = $row['status'];
    $eventDesc = $row['eventDesc'];



    $existingQRCode = $row['eventQRCode']; // If you want to show or use it
  } else {
    die("Event not found.");
  }
} else {
  die("No ID provided.");
}

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
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>EVENT ADVISOR REGISTER NEW EVENT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet" />

  <style>
    /* Reset and base */
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f8ff;
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Header */
    .header1 {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #0074e4;
      padding: 10px 20px;
      margin-left: 170px;
      /* equal to nav width */
      color: white;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 60px;
      z-index: 1000;
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

    .logo,
    .logo2 {
      height: 40px;
      margin-right: 10px;
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




    /* Main content area */
    .content {
      margin-left: 170px;
      padding: 80px 20px 20px;
      /* top padding to clear fixed header */
      background-color: #f4f8ff;
      min-height: calc(100vh - 60px);
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }

    /* QR Container */
    .qr-container {
      background: white;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      text-align: center;
      max-width: 400px;
      width: 100%;
    }

    .qr-container h2 {
      color: #0074e4;
      margin-bottom: 20px;
    }

    .event-detail {
      margin: 10px 0;
      font-size: 16px;
      font-weight: 600;
    }

    canvas {
      margin-top: 20px;
      max-width: 100%;
      height: auto;
    }

    .back-button {
      margin-top: 30px;
      background-color: #0074e4;
      color: white;
      padding: 10px 20px;
      border: none;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
    }

    .back-button:hover {
      background-color: #005bb5;
    }

    /* Buttons */
    button.save-btn,
    button.download-btn,
    .submit-button {
      padding: 10px 20px;
      background-color: #0096D6;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 16px;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    button.save-btn:hover,
    button.download-btn:hover,
    .submit-button:hover {
      background-color: #0264c2;
    }

    button.save-btn {
      padding: 10px 20px;
      background-color: #0096D6;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 16px;
      border-radius: 5px;
      transition: background-color 0.3s;
      margin-top: 30px;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }
  </style>
</head>

<body>
  <div class="header1">
    <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo" />
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo" />
    <div class="header-center">
      <h2>Register New Event</h2>
      <p>Event Advisor: <?php echo htmlspecialchars($loggedInUser); ?></p>
    </div>
    <div class="header-right">
      <a href="logout_button.php" class="logout">Logout</a>
      <a href="s_edit_profile.html">
        <img src="images/profile.png" alt="Profile" class="logo2" />
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
          <a class="active" href="ea_registerEvent.php">Register New Event</a>
          <a href="ea_eventCommittee.php">Event Committee</a>
          <a href="ea_committeeReg.php">Register Committee Member</a>
        </div>
      </div>
      <div class="item">
        <a href="#attendance" class="sub-button">Attendance <i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="ea_attendanceSlot.php">Attendance Slot</a>
        </div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="qr-container">
      <h2>Scan Event QR Code</h2>
      <canvas id="qrcode"></canvas>
      <button id="saveQRBtn" class="save-btn">Save QR Code</button>
      <p id="saveStatus" style="margin-top:20px; font-weight:600;"></p>
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

  <script>
    const eventId = <?php echo (int)$id; ?>;
    const localIP = "10.66.40.220"; // Your PC's IP
    const projectFolder = "YAYA/1B2_PROJECT"; // Replace accordingly
    const qrData = `http://${localIP}/${projectFolder}/event_details.php?id=${eventId}`;

    QRCode.toCanvas(document.getElementById("qrcode"), qrData, function(error) {
      if (error) {
        console.error("QR Error:", error);
        document.getElementById("qrcode").outerHTML = "<p style='color:red;'>Failed to generate QR code.</p>";
      }
    });

    document.getElementById('saveQRBtn').addEventListener('click', function() {
      const canvas = document.getElementById('qrcode');
      const qrImageBase64 = canvas.toDataURL('image/png');

      $.ajax({
        url: 'save_qr.php',
        method: 'POST',
        data: {
          eventID: eventId,
          qrData: qrData,
          qrImage: qrImageBase64
        },
        success: function(response) {
          $('#saveStatus').text(response).css('color', 'green');
        },
        error: function() {
          $('#saveStatus').text('Error saving QR code.').css('color', 'red');
        }
      });
    });
  </script>
</body>

</html>


</body>

</html>