<?php
// Connect to DB and get event details
$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM event WHERE eventID = $id";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $eventName = $row['eventName'];
        $eventDate = $row['eventDate'];
        $status = $row['status'];
    } else {
        die("Event not found.");
    }
} else {
    die("No ID provided.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Event QR Code</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f8ff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .qr-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            color: #0074e4;
            margin-bottom: 20px;
        }

        .event-detail {
            margin: 10px 0;
            font-size: 16px;
        }

        canvas {
            margin-top: 20px;
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
    </style>
</head>
<body>

<div class="qr-container">
    <h2>Event QR Code</h2>

    <div class="event-detail"><strong>Name:</strong> <?= htmlspecialchars($eventName) ?></div>
    <div class="event-detail"><strong>Date:</strong> <?= htmlspecialchars($eventDate) ?></div>
    <div class="event-detail"><strong>Status:</strong> <?= htmlspecialchars($status) ?></div>

    <canvas id="qrcode"></canvas>

    
</div>

<script>
    const canvas = document.getElementById("qrcode");
    const qrData = `Event Name: <?= addslashes($eventName) ?>\nDate: <?= $eventDate ?>\nStatus: <?= $status ?>`;

    QRCode.toCanvas(canvas, qrData, function (error) {
        if (error) {
            console.error("QR Error:", error);
            canvas.outerHTML = "<p style='color:red;'>Failed to generate QR code.</p>";
        }
    });
</script>

</body>
</html>
