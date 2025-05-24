<?php
header('Content-Type: application/json');

include 'db_connection.php'; // This connects to 'web_project' database

$sql = "SELECT eventID AS event_id, eventName AS event_name FROM event";
$result = $conn->query($sql);

$events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

echo json_encode($events);
?>
