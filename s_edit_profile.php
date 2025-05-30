<?php
session_start();

if (!isset($_SESSION['userID'])) {
	header("Location: login_page.php");
	exit();
}

$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());
$userID = $_SESSION['userID'];

// Get data from user table
$queryUser = "SELECT username, email, phone_No, password FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

// Get data from student table
$queryStudent = "SELECT studentID, programme, year_of_study FROM student WHERE userID = ?";
$stmtStudent = mysqli_prepare($link, $queryStudent);
mysqli_stmt_bind_param($stmtStudent, "i", $userID);
mysqli_stmt_execute($stmtStudent);
$resultStudent = mysqli_stmt_get_result($stmtStudent);
$studentData = mysqli_fetch_assoc($resultStudent);

// Assign to variables
$uName = $userData["username"] ?? '';
$uEmail = $userData["email"] ?? '';
$sID = $studentData["studentID"] ?? '';
$uPhone = $userData["phone_No"] ?? '';
$sProgramme = $studentData["programme"] ?? '';
$sYear = $studentData["year_of_study"] ?? '';
$currpass = $_POST['currpass'] ?? '';
$newpass = $_POST['npass'] ?? '';
$conpass = $_POST['conpass'] ?? '';
?>

<!DOCTYPE html>
<html>

<head>
	<title>STUDENT EDIT PROFILE</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<style>
		body {
			margin: 0;
			font-family: 'Poppins', sans-serif;
		}

		.header1 {
			display: flex;
			align-items: center;
			justify-content: space-between;
			background-color: #0074e4;
			padding: 10px 20px;
			margin-left: 160px;
			color: white;
		}

		.header-right {
			display: flex;
			align-items: center;
		}

		.header-right .logout {
			color: white;
			font-size: 14px;
			margin-right: 15px;
			/* space between Logout and profile icon */
			text-decoration: none;
			transition: color 0.3s;
		}

		.header-right .logout:hover {
			color: #ddd;
		}

		.header-center {
			text-align: center;
			flex-grow: 1;
		}

		.header-center h2 {
			margin: 0;
			font-size: 22px;
		}

		.header-center p {
			margin: 0;
			font-size: 14px;
		}

		.p1 {
			margin: 5px;
			font-size: 14px;
		}

		.nav {
			height: 100%;
			width: 170px;
			position: fixed;
			z-index: 1;
			top: 0;
			left: 0;
			background-color: #0074e4;
			overflow-x: hidden;
			padding-top: 20px;
		}

		.nav a {
			padding: 6px 8px 6px 16px;
			margin: 10px;
			text-decoration: none;
			font-size: 16px;
			color: white;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.nav a.active {
			background-color: #0264c2;
			color: white;
		}

		.nav a:hover {
			background-color: #0264c2;
			transition: all 0.4s ease;
		}


		.sub-menu {
			background: #044e95;
			display: none;
		}

		.sub-menu a {
			padding-left: 30px;
			font-size: 12px;
		}

		.cancel-button {
			background-color: #0074e4;
			font-family: 'Poppins', sans-serif;
			border: none;
			border-radius: 10px;
			color: white;
			padding: 6px 14px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
			margin: 5px 0 14px 5px;
			cursor: pointer;
			transition: 0.3s;
		}

		.cancel-button:hover {
			background-color: #005bb5;
		}

		.save-button {
			background-color: #0074e4;
			font-family: 'Poppins', sans-serif;
			border: none;
			border-radius: 10px;
			color: white;
			padding: 6px 14px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
			margin: 5px 25px;
			cursor: pointer;
			transition: 0.3s;
			float: right;
		}

		.save-button:hover {
			background-color: #005bb5;
		}


		.content {
			background-color: #e6f0ff;
			margin-left: 160px;
			height: auto;
		}


		.logo {
			height: 40px;
			margin: 10px;
		}

		.logo2 {
			height: 35px;
			margin: 10px;
		}

		.events-container {
			height: auto;
			display: flex;
			flex-direction: row;
			flex-wrap: wrap;
			gap: 30px;
			margin-left: 30px;
		}

		.event {
			width: 300px;
			height: 330px;
			background: white;
			margin: 20px;
			box-sizing: border-box;
			font-size: 14px;
			box-shadow: 0px 0px 10px 2px grey;
			transition: 1s;
		}

		.event:hover {
			transform: scale(1.05);
			z-index: 2;
		}

		.eventImage {
			height: 260px;
			width: 300px;
			justify-content: center;
			align-items: center;
		}

		.details1 {
			margin: 5px 0px 20px 0px;
			padding-left: 10px;
			height: 30px;
			font-family: 'Poppins', sans-serif;
			width: 30%;
			border: 1px solid #DCDCDC;
			border-radius: 4px;
			border-bottom-width: 2px;
			transition: 0.3s;
		}

		.details2 {
			margin: 5px 0px 20px 0px;
			padding-left: 10px;
			height: 30px;
			font-family: 'Poppins', sans-serif;
			width: 16%;
			border: 1px solid #DCDCDC;
			border-radius: 4px;
			border-bottom-width: 2px;
			transition: 0.3s;
		}

		.details3 {
			margin: 5px 0px 20px 0px;
			padding-left: 10px;
			height: 30px;
			font-family: 'Poppins', sans-serif;
			width: 20%;
			border: 1px solid #DCDCDC;
			border-radius: 4px;
			border-bottom-width: 2px;
			transition: 0.3s;
		}

		form {
			margin-left: 40px;
		}

		.select1 {
			font-family: 'Poppins', sans-serif;
			margin: 5px 0px 25px 0px;
			padding: 3px 100px;
			color: black;
			width: 60%;
			background-color: white;
			border: 1px solid #DCDCDC;
			border-radius: 4px;
			border-bottom-width: 2px;
		}

		.select2 {
			font-family: 'Poppins', sans-serif;
			margin: 5px 0px 25px 0px;
			padding: 3px 100px;
			color: black;
			width: 35%;
			background-color: white;
			border: 1px solid #DCDCDC;
			border-radius: 4px;
			border-bottom-width: 2px;
			text-align: left;
		}
	</style>
</head>

<body>
	<div class="header1">
		<img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo" />
		<img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo" />
		<div class="header-center">
			<h2>Profile Settings</h2>
			<p>Student: Alif</p>
		</div>
		<div class="header-right">
			<a href="logout_button.php" class="logout">Logout</a>
			<a href="s_displayProfile.php">
				<img src="images/profile.png" alt="Profile" class="logo2">
			</a>
		</div>
	</div>

	<div class="nav">
		<div class="menu">
			<div class="item"><a href="s_homepage.php">Dashboard</a></div>
			<div class="item">
				<a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
				<div class="sub-menu">
					<a href="s_membership.php" class="sub-item">Membership Application</a>
				</div>
			</div>

			<div class="item">
				<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
				<div class="sub-menu">
					<a href="s_homepage.php" class="sub-item">View Event</a>
				</div>
			</div>

			<div class="item">
				<a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
				<div class="sub-menu">
					<a href="s_attendance1.php" class="sub-item">Attendance Slot</a>
				</div>
			</div>
		</div>
	</div>

	<div class="content">
		<br>
		<form action="s_editProfile2.php" method="POST" class="form">

			<label>Full Name</label><br>
			<input type="text" name="username" placeholder="Enter your name" class="details1" value="<?php echo $uName; ?>"><br>

			<label>Email Address</label><br>
			<input type="email" name="email" placeholder="Enter your email address" class="details1" value="<?php echo $uEmail; ?>"><br>

			<label>Student ID</label><br>
			<input type="text" name="studentID" placeholder="Enter your student ID" class="details2" value="<?php echo $sID; ?>"><br>

			<label>Phone Number</label><br>
			<input type="text" name="phone_No" placeholder="Enter your phone number" class="details2" value="<?php echo $uPhone; ?>"><br>

			<label>Programme</label><br>
			<select name="programme" class="select1">
				<option value="Select programme" <?php if ($sProgramme == "Select Programme") echo "selected"; ?>>Select programme</option>
				<option value="Bachelor of Computer Science (Software Engineering) with Honours" <?php if ($sProgramme == "BCS") echo "selected"; ?>>Bachelor of Computer Science (Software Engineering) with Honours</option>
				<option value="Bachelor of Computer Science (Computer Systems & Networking) with Honours" <?php if ($sProgramme == "BCN") echo "selected"; ?>>Bachelor of Computer Science (Computer Systems & Networking) with Honours</option>
				<option value="Bachelor of Computer Science (Multimedia Software) with Honours" <?php if ($sProgramme == "BCG") echo "selected"; ?>>Bachelor of Computer Science (Multimedia Software) with Honours</option>
				<option value="Bachelor of Computer Science (Cyber Security) with Honours" <?php if ($sProgramme == "BCY") echo "selected"; ?>>Bachelor of Computer Science (Cyber Security) with Honours</option>
				<option value="Diploma in Computer Science" <?php if ($sProgramme == "DRC") echo "selected"; ?>>Diploma in Computer Science</option>
			</select><br>

			<label>Year of Study</label><br>
			<select name="year_of_study" class="select2">
				<option value="Select year of study" <?php if ($sYear == "Select Year of Study") echo "selected"; ?>>Select year of study</option>
				<option value="1" <?php if ($sYear == "1") echo "selected"; ?>>1</option>
				<option value="2" <?php if ($sYear == "2") echo "selected"; ?>>2</option>
				<option value="3" <?php if ($sYear == "3") echo "selected"; ?>>3</option>
				<option value="4" <?php if ($sYear == "4") echo "selected"; ?>>4</option>
			</select><br>

			<label>Current Password</label><br>
			<input type="password" name="currpass" placeholder="Enter your current password" class="details3"><br>

			<label>New Password</label><br>
			<input type="password" name="npass" placeholder="Enter your new password" class="details3"><br>

			<label>Confirm Password</label><br>
			<input type="password" name="conpass" placeholder="Confirm new password" class="details3"><br>

			<br>
			<input type="hidden" name="id2" value="<?php echo $userID; ?>">
			<a href="s_displayProfile.php" class="cancel-button">Cancel</a>
			<input type="submit" class="save-button" value="Save">

		</form>

		<script type="text/javascript">
			$(document).ready(function() {
				$('.sub-button').click(function() {
					$(this).next('.sub-menu').slideToggle();
				});
			});
		</script>
</body>

</html>