<?php
// Get data from form
$username = trim($_POST["username"]);
$email = trim($_POST["email"]);
$role = trim($_POST["role"]);
$raw_password = $_POST["password"];

// Input validation
if (empty($username) || empty($email) || empty($raw_password) || $role === "Select Role") {
	header("Location: c_addNewUser.php?status=fail");
	exit;
}

$password = password_hash($raw_password, PASSWORD_DEFAULT);

// Database connection
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

// Insert into user table
$query = "INSERT INTO user (username, email, role, password) VALUES ('$username', '$email', '$role', '$password')";
$result = mysqli_query($link, $query) or die(mysqli_error($link));

if ($result) {
	$userID = mysqli_insert_id($link); // Get inserted userID

	// Match role exactly as used in form
	if ($role === "Student") {
		mysqli_query($link, "INSERT INTO student (userID) VALUES ('$userID')") or die(mysqli_error($link));
	} elseif ($role === "Coordinator") {
		mysqli_query($link, "INSERT INTO petakomcoordinator (userID) VALUES ('$userID')") or die(mysqli_error($link));
	} elseif ($role === "Event Advisor") {
		mysqli_query($link, "INSERT INTO eventadvisor (userID) VALUES ('$userID')") or die(mysqli_error($link));
	}

	header("Location: c_addNewUser.php?status=success");
	exit;
} else {
	header("Location: c_addNewUser.php?status=fail");
	exit;
}
