<!DOCTYPE html>
<html>
<body>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventID = $_POST["event"];
    $position = $_POST["position"];
    $studentID = $_POST["student_id"];

    $link = mysqli_connect("localhost", "root", "") or die("Connection failed: " . mysqli_connect_error());
    mysqli_select_db($link, "web_project") or die("Database selection failed: " . mysqli_error($link));

    $query = "INSERT INTO committee (eventID, committeeRole, studentID)
              VALUES ('$eventID', '$position', '$studentID')";

    $result = mysqli_query($link, $query);

    if ($result) {
        echo "Data inserted successfully!";
    } else {
        die("Insert failed: " . mysqli_error($link));
    }

    mysqli_close($link);
}


?>

</body>
</html>

