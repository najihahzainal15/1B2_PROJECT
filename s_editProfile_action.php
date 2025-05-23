<!DOCTYPE html>
<html>
<body>
	<?php
		$name = $_POST["nama"];
		$age = $_POST["umur"];
		$gender = $_POST["jantina"];
		$title = $_POST["pangkat"];
		$hobby = implode(", ", $_POST["hobi"]);
		$comment = $_POST["komen"];
		
		// to make a connection with database
		$link = mysqli_connect("localhost", "root") or die(mysqli_connect_error());
		
		// to select the targeted database
	mysqli_select_db($link, "mydb") or die(mysqli_error());
	
		// to create a query to be executed in sql
	$query = "insert into user values('','$name','$age','$gender','$title','$hobby','$comment')"		 
	or die(mysqli_connect_error());

	// to run sql query in database
	$result = mysqli_query($link, $query);
	     
	//Check whether the insert was successful or not
	if($result) 
	        {
		        
                    echo("Data insert");
					
		}
		else 
	        {
			        
	            die("Insert failed");
	        }
	
	?>
</form>
</body>
</html>




