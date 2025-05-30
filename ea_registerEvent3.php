<?php
// Connect to DB and get event details
$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());

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
    } else {
        die("Event not found.");
    }
} else {
    die("No ID provided.");
}
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
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f8ff;
      height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .header1 {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #0074e4;
      padding: 10px 20px;
      margin-left: 170px;
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

    .logo, .logo2 {
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

    .content {
      margin-left: 170px;
      padding: 80px 20px 20px;
      background-color: #f4f8ff;
      min-height: calc(100vh - 60px);
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }

    .qr-container {
      background: white;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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

    button.save-btn, button.download-btn, .submit-button {
      padding: 10px 20px;
      background-color: #0096D6;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 16px;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    button.save-btn:hover, button.download-btn:hover, .submit-button:hover {
      background-color: #0264c2;
    }

    /* ===== MOBILE RESPONSIVE ADJUSTMENTS ===== */
    @media (max-width: 768px) {
      .nav {
        display: none;
      }

      .header1 {
        margin-left: 0;
        padding: 10px;
        flex-direction: column;
        align-items: flex-start;
        height: auto;
      }

      .header-center {
        text-align: left;
        margin-top: 10px;
      }

      .content {
        margin-left: 0;
        padding: 100px 10px 20px;
        align-items: center;
      }

      .qr-container {
        width: 100%;
        padding: 20px;
        box-shadow: none;
      }

      .logo, .logo2 {
        height: 30px;
      }

      .event-detail {
        font-size: 14px;
      }

      .back-button, .save-btn, .download-btn {
        width: 100%;
        font-size: 14px;
      }
    }
  </style>
</head>

<body>
  <div class="header1">
    <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo" />
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo" />
    <div class="header-center">
      <h2>Event Details</h2>
     
    </div>
    
  </div>

  <div class="content">
    <div class="qr-container">
      <h2>Event Details</h2>

      <div class="event-detail"><?= htmlspecialchars($eventName) ?></div>
      <div class="event-detail"><strong>Date:</strong> <?= htmlspecialchars($eventDate) ?></div>
      <div class="event-detail"><strong>Time:</strong> <?= htmlspecialchars($eventTime) ?></div>
      <div class="event-detail"><strong>Location:</strong> <?= htmlspecialchars($eventLocation) ?></div>

      <canvas id="qrcode"></canvas>
    </div>
  </div>

  <script>
    // Optional: Toggle submenu on clicking Events/Attendance
    $(document).ready(function() {
      $('.sub-button').click(function(e) {
        e.preventDefault();
        $(this).next('.sub-menu').slideToggle();
      });
    });

 
  </script>
</body>
</html>
