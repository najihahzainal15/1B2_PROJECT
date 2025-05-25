<?php
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

$idURL = $_GET['id'];

$query = "SELECT * FROM event WHERE eventID = '$idURL'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head><title>Edit Merit Status</title></head>
<body>
  <form method="post" action="c_meritAppUpdate2.php">
    Merit Application Status (Rejected/Approved):
    <input type="text" name="meritStatus" size="40" value="<?php echo htmlspecialchars($row["meritStatus"]); ?>">
    <br>
    <input type="hidden" name="id2" value="<?php echo htmlspecialchars($row["eventID"]); ?>">
    <input type="submit" value="Update">
    <input type="reset" value="Cancel">
  </form>
</body>
</html>


