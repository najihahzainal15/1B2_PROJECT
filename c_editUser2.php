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

if ($result) {
	// First remove the user from all role-specific tables to avoid duplicates or conflicts.
	mysqli_query($link, "DELETE FROM student WHERE userID = '$uid2'");
	mysqli_query($link, "DELETE FROM petakomcoordinator WHERE userID = '$uid2'");
	mysqli_query($link, "DELETE FROM eventadvisor WHERE userID = '$uid2'");

	// Now insert into the correct role-specific table.
	if ($uRole == "Student") {
		$query_student = "INSERT INTO student (userID) 
                          SELECT '$uid2' 
                          WHERE NOT EXISTS (SELECT 1 FROM student WHERE userID = '$uid2')";
		mysqli_query($link, $query_student) or die(mysqli_error($link));
	} else if ($uRole == "Coordinator") {
		$query_petakom = "INSERT INTO petakomcoordinator (userID) 
                          SELECT '$uid2' 
                          WHERE NOT EXISTS (SELECT 1 FROM petakomcoordinator WHERE userID = '$uid2')";
		mysqli_query($link, $query_petakom) or die(mysqli_error($link));
	} else if ($uRole == "Event Advisor") {
		$query_eventadvisor = "INSERT INTO eventadvisor (userID) 
                               SELECT '$uid2' 
                               WHERE NOT EXISTS (SELECT 1 FROM eventadvisor WHERE userID = '$uid2')";
		mysqli_query($link, $query_eventadvisor) or die(mysqli_error($link));
	}

	// Redirect after successful update
	echo "<script type='text/javascript'> window.location='c_manageprofile.php'; </script>";
}
