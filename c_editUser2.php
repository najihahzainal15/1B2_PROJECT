<?php
	//Connect to the database server.
	$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());

	//Select the database.
	mysqli_select_db($link, "web_project") or die(mysqli_error($link));
		
		$uName = $_POST["username"];
		$uRole = $_POST["role"];
		$uEmail = $_POST["email"];
		$uPass = $_POST["password"];
		$uid2 = $_POST["id2"];

	$query = "UPDATE user SET username = '$uName', role = '$uRole', email = '$uEmail', password = '$uPass'
	WHERE userID = '$uid2'";

	$result = mysqli_query($link,$query) or die ("Could not execute query in c_editUser.php");
	if($result){
	 echo "<script type = 'text/javascript'> window.location='c_manageprofile.php'  </script>";
	}
?>