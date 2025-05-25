<?php
session_start();

if (!isset($_SESSION['userID'])) {
	header("Location: login_page.php");
	exit();
}

$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());
$userID = $_SESSION['userID'];

// Get student data first
$queryStudent = "SELECT studentID, student_card_upload FROM student WHERE userID = ?";
$stmtStudent = mysqli_prepare($link, $queryStudent);
mysqli_stmt_bind_param($stmtStudent, "i", $userID);
mysqli_stmt_execute($stmtStudent);
$resultStudent = mysqli_stmt_get_result($stmtStudent);
$studentData = mysqli_fetch_assoc($resultStudent);

$sID = $studentData["studentID"] ?? ''; // Ensure student ID is properly assigned
$sCard = $studentData["student_card_upload"] ?? '';

// Get verification status from membership table **AFTER student ID is properly fetched**
$verificationStatus = "PENDING"; // Default status
if (!empty($sID)) {
	$queryMembership = "SELECT verification_status FROM membership WHERE studentID = ?";
	$stmtMembership = mysqli_prepare($link, $queryMembership);
	mysqli_stmt_bind_param($stmtMembership, "s", $sID);
	mysqli_stmt_execute($stmtMembership);
	$resultMembership = mysqli_stmt_get_result($stmtMembership);

	if ($membershipData = mysqli_fetch_assoc($resultMembership)) {
		$verificationStatus = $membershipData["verification_status"];
	}
}

// Get user data
$queryUser = "SELECT userID, username, email FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

// Assign variables
$ID = $userData["userID"];
$uName = $userData["username"] ?? '';
$uEmail = $userData["email"] ?? '';
?>
<!DOCTYPE html>
<html>

<head>
	<title>STUDENT MEMBERSHIP APPLICATION</title>
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
			margin: 0px 0px 20px 40px;
			font-size: 24px;
			padding-top: 20px;
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

		.submit-button {
			background-color: #0074e4;
			font-family: 'Poppins', sans-serif;
			border: none;
			border-radius: 10px;
			color: white;
			padding: 10px 14px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
			margin: 25px 30px;
			cursor: pointer;
			transition: 0.3s;
			float: right;
		}

		.submit-button:hover {
			background-color: #005bb5;
		}

		.content {
			background-color: #e6f0ff;
			margin-left: 160px;
			height: 100vh;
			overflow-y: auto;
		}


		.logo {
			height: 40px;
			margin: 10px;
		}

		.logo2 {
			height: 35px;
			margin: 10px;
		}

		.details1 {
			margin: 5px 0px 20px 0px;
			padding-left: 10px;
			height: 30px;
			font-family: 'Poppins', sans-serif;
			width: 25%;
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
			width: 15%;
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
			width: 30%;
			border: 1px solid #DCDCDC;
			border-radius: 4px;
			border-bottom-width: 2px;
			transition: 0.3s;
		}

		form {
			margin-left: 40px;
		}

		p {
			font-size: 12px;
		}

		.cancel-button {
			float: left;
			background-color: #0074e4;
			font-family: 'Poppins', sans-serif;
			border: none;
			border-radius: 10px;
			color: white;
			padding: 10px 14px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
			margin: 25px 8px;
			cursor: pointer;
			transition: 0.3s;
		}

		.cancel-button:hover {
			background-color: #005bb5;
		}

		.status-container {
			text-align: center;
			padding: 10px;
			font-size: 18px;
			font-weight: bold;
		}

		.status-text {
			padding: 5px 10px;
			border-radius: 5px;
		}

		.pending {
			background-color: #fff0b3;
			color: #997000;
		}

		.approved {
			background-color: #c6f6c6;
			color: #006600;
		}

		.rejected {
			background-color: #f6c6c6;
			color: #990000;
		}

		input[type="file"] {
			opacity: 0;
			position: absolute;
			z-index: -1;
		}

		.file-label {
			display: inline-block;
			padding: 6px 10px;
			margin-top: 10px;
			background-color: #0074e4;
			color: white;
			border-radius: 5px;
			cursor: pointer;
			font-size: 14px;
			font-family: 'Poppins', sans-serif;
		}

		#fileName {
			margin-left: 10px;
			font-size: 14px;
			font-family: 'Poppins', sans-serif;
		}
	</style>
</head>

<body>

	<div class="header1">
		<img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo" />
		<img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo" />
		<div class="header-center">
			<h2>Membership Application</h2>
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
					<a class="active" href="s_membership.php" class="sub-item">Membership Application</a>
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
		<div class="status-container">
			<h3>Application Status:
				<span class="status-text <?php echo strtolower($verificationStatus); ?>">
					<?php echo htmlspecialchars($verificationStatus); ?>
				</span>
			</h3>
		</div>

		<br>
		<form action="s_membership_action.php" method="POST" enctype="multipart/form-data">

			<label>Full Name</label><br>
			<input type="text" name="username" class="details1" value="<?php echo $uName; ?>" readonly><br>

			<label>Student ID</label><br>
			<input type="text" name="studID" class="details2" value="<?php echo $sID; ?>" readonly><br>

			<label>Email Address</label><br>
			<input type="email" name="email" class="details1" value="<?php echo $uEmail; ?>" readonly><br>

			<?php if ($verificationStatus !== 'Accepted') { ?>
				<label>Student Card</label><br>
				<label class="file-label" for="fileUpload">Choose File</label>
				<input type="file" name="student_card_upload" id="fileUpload">
				<span id="fileName"><?php echo !empty($sCard) ? basename($sCard) : "No file chosen"; ?></span>


				<p>Please upload your student card in JPG or PNG format. Maximum file size: 5MB.</p>
			<?php } else { ?>
				<p style="color: green;">Your student card has been verified and approved.</p>
			<?php } ?>

			<br>
			<input type="submit" class="submit-button" value="Submit">
			<button type="button" class="cancel-button" onclick="window.location.href='s_homepage.php'">Cancel</button>

		</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.sub-button').click(function() {
				$(this).next('.sub-menu').slideToggle();
			});
		});
	</script>

	<script>
		document.getElementById("fileUpload").addEventListener("change", function() {
			var fileName = this.files[0] ? this.files[0].name : "No file chosen";
			document.getElementById("fileName").textContent = fileName;
		});
	</script>


</body>

</html>