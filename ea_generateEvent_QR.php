<?php
// Connect to MySQL database
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

// Get eventID from URL
$idURL = isset($_GET['id']) ? $_GET['id'] : null;

if ($idURL) {
    // Prepare the query using prepared statements to prevent SQL injection
    $query = "SELECT * FROM event WHERE eventID = ?";
    $stmt = mysqli_prepare($link, $query);
    
    // Bind the parameter to the prepared statement
    mysqli_stmt_bind_param($stmt, "i", $idURL); // 'i' stands for integer

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Fetch the result
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Check if event data was retrieved
    if ($row) {
        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode([
            'eventName' => $row['eventName'],
            'eventDate' => $row['eventDate'],
            'eventTime' => $row['eventTime'],
            'eventVenue' => $row['eventLocation'],
            'eventGeolocation' => $row['eventGeolocation']
        ]);
    } else {
        echo json_encode(['error' => 'No event found with ID: ' . $idURL]);
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(['error' => 'No event ID specified.']);
}

mysqli_close($link);
?>
