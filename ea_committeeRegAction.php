<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $eventID = $_POST["event"] ?? null;
    $roleID = $_POST["roleID"] ?? null;
    $studentID = $_POST["student_id"] ?? null;

    if (!$eventID || !$roleID || !$studentID) {
        die("Missing data: Please fill all required fields.");
    }

    $link = mysqli_connect("localhost", "root", "", "web_project") or die("Connection failed");

    // Check if roleID actually exists in committeerole table
    $checkRole = mysqli_query($link, "SELECT * FROM committeerole WHERE roleID = '$roleID'");
    if (mysqli_num_rows($checkRole) == 0) {
        die("Invalid role selected.");
    }

    // Insert into committee table
    $query = "INSERT INTO committee (eventID, roleID, studentID) VALUES ('$eventID', '$roleID', '$studentID')";

    if (mysqli_query($link, $query)) {
        echo "Committee member registered successfully!";
    } else {
        die("Insert failed: " . mysqli_error($link));
    }

    mysqli_close($link);
}
?>

