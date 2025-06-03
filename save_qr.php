<?php
// save_qr.php
header('Content-Type: text/plain');

$link = mysqli_connect("localhost", "root", "", "web_project");
if (!$link) {
    die("DB connection failed.");
}

if (isset($_POST['eventID'], $_POST['qrData'])) {
    $eventID = (int)$_POST['eventID'];
    $qrData = mysqli_real_escape_string($link, $_POST['qrData']);
    $qrImage = isset($_POST['qrImage']) ? mysqli_real_escape_string($link, $_POST['qrImage']) : '';

    // Update the eventQRCode column for this event
    $query = "UPDATE event 
              SET eventQRCode = '$qrImage' 
              WHERE eventID = $eventID";

    if (mysqli_query($link, $query)) {
        echo "QR code saved successfully in event table!";
    } else {
        echo "Failed to save QR code: " . mysqli_error($link);
    }
} else {
    echo "Invalid request.";
}
?>

