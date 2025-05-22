<?php
	include "config.php";

	if (isset($_GET['id'])) {
	  $id = $_GET['id'];
	  $sql = "SELECT * FROM user WHERE userID = $id";
	  $result = mysqli_query($link, $sql);
	  $user = mysqli_fetch_assoc($result);
	} else {
	  echo "No user selected.";
	  exit;
	}
?>

<!DOCTYPE html>
<html>
<head>
  <title>View User</title>
</head>
<body>

	<h2>View User</h2>
	<p><strong>Username:</strong> <?= $user['username'] ?></p>
	<p><strong>Email:</strong> <?= $user['email'] ?></p>
	<p><strong>IC:</strong> <?= $user['ic'] ?></p>

	<a href="c_manageProfile.php">Back to list</a>

</body>
</html>
