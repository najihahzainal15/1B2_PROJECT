<?php
// Connect to your database (adjust credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_project";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get event ID from URL
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM event WHERE eventID = $event_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
  $event = $result->fetch_assoc();
} else {
  echo "Event not found.";
  exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?php echo htmlspecialchars($event['eventName']); ?></title>
  <style>
    /* Base reset and font */
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f4f8ff;
      color: #333;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding: 40px 20px;
    }

    /* Container to center and style content */
    .event-container {
      background: white;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-width: 480px;
      width: 100%;
    }

    /* Event title */
    h1 {
      color: #0074e4;
      font-weight: 600;
      margin-bottom: 24px;
      font-size: 28px;
      text-align: center;
    }

    /* Event info labels and text */
    p {
      font-size: 16px;
      margin: 12px 0;
      font-weight: 500;
      border-bottom: 1px solid #ddd;
      padding-bottom: 8px;
    }

    p strong {
      color: #0074e4;
      width: 80px;
      display: inline-block;
    }
  </style>
</head>
<body>
  <div class="event-container">
    <h1><?php echo htmlspecialchars($event['eventName']); ?></h1> 
    <p><strong>Description:</strong> <?php echo htmlspecialchars($event['eventDesc']); ?></p>
    <p><strong>Date:</strong> <?php echo htmlspecialchars($event['eventDate']); ?></p>
    <p><strong>Time:</strong> <?php echo htmlspecialchars($event['eventTime']); ?></p>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($event['eventLocation']); ?></p>
 <p><strong>Geolocation:</strong> <?php echo htmlspecialchars($event['eventGeolocation']); ?></p>
    <p><strong>Event Status:</strong> <?php echo htmlspecialchars($event['status']); ?></p>
  </div>
</body>
</html>
