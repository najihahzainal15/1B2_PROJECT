<?php
	// Connect to the database
	$link = mysqli_connect("localhost", "root", "", "web_project");

	if (!$link) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// Check if ID is set
	if (isset($_GET['id'])) {
		$userID = intval($_GET['id']); // Sanitize input as integer

		// Delete query
		$query = "DELETE FROM user WHERE userID = $userID";

		if (mysqli_query($link, $query)) {
			// Redirect back to manage profile page
			header("Location: c_manageProfile.php");
			exit();
		} else {
			echo "Error deleting record: " . mysqli_error($link);
		}
	} else {
		echo "No user ID specified.";
	}

	mysqli_close($link);
?>
