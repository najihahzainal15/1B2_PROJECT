<?php
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

$idURL = $_GET['id'];  // Correct way to get URL parameter

$query = "SELECT * FROM event WHERE eventID = '$idURL'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

			$eventID = htmlspecialchars($row["eventID"]);
            $eventName = htmlspecialchars($row["eventName"]);
            $date = htmlspecialchars($row["eventDate"]);
            $status = htmlspecialchars($row["status"]);
?>

<!DOCTYPE html>
<html>
<body>
<form method="post" action="ea_viewEventUpdate2.php">
Status (ACTIVE/CANCELED/POSTPONE):
<input type="text" name="status" size="40" value="<?php echo $status ?>">
<br>
<input type="hidden" name="id2" value="<?php echo $eventID; ?>">
<input type="submit" value="Update">
<input type="reset" value="Cancel">
<br>
</form>
</body>
</html>
