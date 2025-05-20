<!DOCTYPE html>
<html>
<body>
	<?php
		// get data from form
		$name = $_POST["name"];
		$email = $_POST["email"];
		$role = $_POST["role"];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

		// to make a connection with database
		$link = mysqli_connect("localhost", "root") or die(mysqli_connect_error());
		
		// to select the targeted database
		mysqli_select_db($link, "web_project") or die(mysqli_error());

		// to create a query to be executed in sql
		$query = "insert into user values('','$name','$email','$role','$password')" 	
		or die(mysqli_connect_error());

		// to run sql query in database
		$result = mysqli_query($link, $query);

		// Check whether the insert was successful or not
		if ($result) {
			echo "<script>alert('User added successfully!'); window.location.href='c_addNewUser.php';</script>";
		} else {
			die("Insert failed");
		}
	?>
</body>
</html>
