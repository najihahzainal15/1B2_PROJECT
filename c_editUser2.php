<?php
	// Connect to the database server.
	$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());

	// Select the database.
	mysqli_select_db($link, "web_project") or die(mysqli_error($link));

	// Capture user input.
	$uName = $_POST["username"];
	$uRole = $_POST["role"];
	$uEmail = $_POST["email"];
	$uPass = $_POST["password"];
	$uid2 = $_POST["id2"];

	// Update user table.
	$query = "UPDATE user SET username = '$uName', role = '$uRole', email = '$uEmail', password = '$uPass'
			  WHERE userID = '$uid2'";

	$result = mysqli_query($link, $query) or die("Could not execute query in c_editUser2.php");

	// If user update is successful, insert userID into related tables if necessary.
	if ($result) {
		// Insert userID into student table if it doesn't exist.
		$query_student = "INSERT INTO student (userID) SELECT '$uid2' WHERE NOT EXISTS (SELECT 1 FROM student WHERE userID = '$uid2')";
		mysqli_query($link, $query_student) or die(mysqli_error($link));

		// Insert userID into petakomcoordinator table if it doesn't exist.
		$query_petakom = "INSERT INTO petakomcoordinator (userID) SELECT '$uid2' WHERE NOT EXISTS (SELECT 1 FROM petakomcoordinator WHERE userID = '$uid2')";
		mysqli_query($link, $query_petakom) or die(mysqli_error($link));

		// Insert userID into eventadvisor table if it doesn't exist.
		$query_eventadvisor = "INSERT INTO eventadvisor (userID) SELECT '$uid2' WHERE NOT EXISTS (SELECT 1 FROM eventadvisor WHERE userID = '$uid2')";
		mysqli_query($link, $query_eventadvisor) or die(mysqli_error($link));


		echo "<script type='text/javascript'> window.location='c_manageprofile.php'; </script>";
}
?>
