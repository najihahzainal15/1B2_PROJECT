 <?php
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

$idURL = $_GET['id'];  // Correct way to get URL parameter

$query = "SELECT * FROM committee WHERE committeeID = '$idURL'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

$commID = htmlspecialchars($row["committeeID"]);
$eventID = htmlspecialchars($row["eventID"]);
$role = htmlspecialchars($row["committeeRole"]);
$studentID = htmlspecialchars($row["studentID"]);
?>

<!DOCTYPE html>
<html>
<body>
<form method="post" action="ea_eventCommitteeUpdate2.php">
Role:
<input type="text" name="role" size="40" value="<?php echo $role; ?>">
<br>
<input type="hidden" name="id2" value="<?php echo $commID; ?>">
<input type="submit" value="Update">
<input type="reset" value="Cancel">
<br>
</form>
</body>
</html>
