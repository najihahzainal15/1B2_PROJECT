<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $attendanceID = $_POST['attendanceID'] ?? null;
    if (!$attendanceID) {
        die("Attendance ID is required.");
    }

    $link = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
    mysqli_select_db($link, "web_project") or die("Database selection failed: " . mysqli_error($link));

    // Escape inputs
    $eventName = mysqli_real_escape_string($link, $_POST['name']);
    $desc = mysqli_real_escape_string($link, $_POST['description']);
    $date = mysqli_real_escape_string($link, $_POST['date']);
    $time = mysqli_real_escape_string($link, $_POST['time']);
    $geolocation = mysqli_real_escape_string($link, $_POST['geolocation']);
    $venue = mysqli_real_escape_string($link, $_POST['venue']);
	$meritScore = mysqli_real_escape_string($link, $_POST['meritScore']);

    // Handle file upload
    $approvalLetterPath = null;
    if (isset($_FILES['approvalLetter']) && $_FILES['approvalLetter']['error'] == 0) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $fileName = basename($_FILES["approvalLetter"]["name"]);
        $targetFilePath = $uploadDir . time() . "_" . $fileName;

        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        if (!in_array($fileType, $allowedTypes)) {
            die("Invalid file type. Only PDF, JPG, JPEG, PNG allowed.");
        }

        if (move_uploaded_file($_FILES["approvalLetter"]["tmp_name"], $targetFilePath)) {
            $approvalLetterPath = $targetFilePath;
        } else {
            die("Error uploading the approval letter.");
        }
    } else {
        die("Please upload the approval letter.");
    }

    // Insert query without eventAdvisorID
    $query = "INSERT INTO event 
        (attendanceID, eventName, eventDesc, eventDate, eventTime, eventGeoLocation, eventLocation, approvalLetterPath, meritScore) 
        VALUES 
        ('$attendanceID', '$eventName', '$desc', '$date', '$time', '$geolocation', '$venue', '$approvalLetterPath', '$meritScore')";

    $result = mysqli_query($link, $query);

    if ($result) {
        echo "Data inserted successfully!";
        echo "<br><a href='ea_registerEvent.php'>Register another event</a>";
    } else {
        die("Insert failed: " . mysqli_error($link));
    }

    mysqli_close($link);
} else {
    echo "Invalid request method.";
}
?>
