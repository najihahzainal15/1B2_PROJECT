<!DOCTYPE html>
<html>
<body>
	<?php
	// Get data from form
		$username = trim($_POST["username"]);
		$email = trim($_POST["email"]);
		$role = $_POST["role"];
		$raw_password = $_POST["password"];
		$raw_password = $_POST["password"];

		// Input validation: prevent empty fields or default role
		if (empty($username) || empty($email) || empty($raw_password) || $role === "Select Role") {
			header("Location: c_addNewUser.php?status=fail");
			exit;
		}

		// Hash the password only after validation
		$password = password_hash($raw_password, PASSWORD_DEFAULT);
		
		/// to make a connection with database
		$link = mysqli_connect("localhost", "root") or die(mysqli_connect_error());
		
		// to select the targeted database
		mysqli_select_db($link, "web_project") or die(mysqli_error($link));

		// Create and execute query
		$query = "INSERT INTO user (username, email, role, password) VALUES ('$username', '$email', '$role', '$password')";
		$result = mysqli_query($link, $query) or die(mysqli_error($link));

		// Redirect based on result
		if ($result) {
			$userID = mysqli_insert_id($link); // Get last inserted userID

			// Insert into the correct table based on role
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
	?>
</body>
</html>
