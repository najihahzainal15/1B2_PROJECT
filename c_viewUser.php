<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login_page.php");
	exit();
}

$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());

// Get user ID from URL after coordinator clicks "View"
$userID = $_GET["id"] ?? null; // Ensure ID is passed correctly

if (!$userID) {
	die("Invalid User ID.");
}

// Fetch common user data
$queryUser = "SELECT username, email, phone_No, role FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

$role = $userData["role"] ?? '';
$userName = ucwords(strtolower($userData["username"] ?? "User"));
$userEmail = $userData["email"] ?? '';
$userPhone = $userData["phone_No"] ?? '';
$userIDType = "";
$extraField = "";

// Fetch additional data based on the role
if ($role === "Student") {
	$queryStudent = "SELECT studentID, programme, year_of_study FROM student WHERE userID = ?";
	$stmtStudent = mysqli_prepare($link, $queryStudent);
	mysqli_stmt_bind_param($stmtStudent, "i", $userID);
	mysqli_stmt_execute($stmtStudent);
	$resultStudent = mysqli_stmt_get_result($stmtStudent);
	$studentData = mysqli_fetch_assoc($resultStudent);

	$userIDType = "Student ID: " . ($studentData["studentID"] ?? '');
	$extraField = "Programme: " . ($studentData["programme"] ?? '') . "<br>Year of Study: " . ($studentData["year_of_study"] ?? '');
} elseif ($role === "Event Advisor") {
	$queryAdvisor = "SELECT eventAdvisorID, expertiseArea FROM eventadvisor WHERE userID = ?";
	$stmtAdvisor = mysqli_prepare($link, $queryAdvisor);
	mysqli_stmt_bind_param($stmtAdvisor, "i", $userID);
	mysqli_stmt_execute($stmtAdvisor);
	$resultAdvisor = mysqli_stmt_get_result($stmtAdvisor);
	$advisorData = mysqli_fetch_assoc($resultAdvisor);

	$userIDType = "Event Advisor ID: " . ($advisorData["eventAdvisorID"] ?? '');
	$extraField = "Expertise Area: " . ($advisorData["expertiseArea"] ?? '');
} elseif ($role === "Coordinator") {
	$queryCoordinator = "SELECT coordinatorID FROM petakomcoordinator WHERE userID = ?";
	$stmtCoordinator = mysqli_prepare($link, $queryCoordinator);
	mysqli_stmt_bind_param($stmtCoordinator, "i", $userID);
	mysqli_stmt_execute($stmtCoordinator);
	$resultCoordinator = mysqli_stmt_get_result($stmtCoordinator);
	$coordinatorData = mysqli_fetch_assoc($resultCoordinator);

	$userIDType = "Coordinator ID: " . ($coordinatorData["coordinatorID"] ?? '');
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>COORDINATOR VIEW USER</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<style>
		body {
			margin: 0;
			font-family: 'Poppins', sans-serif;
			overflow: auto;
			background-color: #e6f0ff;
			background-attachment: fixed;
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
			color: white;
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
			margin: 4px 25px;
			cursor: pointer;
			transition: 0.3s;
			float: right;
		}

		.save-button:hover {
			background-color: #005bb5;
		}


		.content {
			background-color: #ffffff;
			margin-left: 160px;
			min-height: 100vh;
			padding: 20px;
			box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
			border-radius: 8px;
		}

		h2 {
			font-size: 24px;
			font-weight: bold;
			color: #0074e4;
			margin-bottom: 20px;
		}

		.form {
			width: 60%;
			margin: auto;
			padding: 20px;
			background: #e6f0ff;
			border-radius: 10px;
			box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
		}

		label {
			font-size: 16px;
			font-weight: bold;
			color: #333;
			margin-bottom: 5px;
		}

		.details1,
		.details2 {
			width: 100%;
			padding: 10px;
			font-size: 14px;
			border: 1px solid #ccc;
			border-radius: 5px;
			margin-bottom: 15px;
			background-color: #fff;
		}

		.cancel-button {
			display: inline-block;
			background-color: #0074e4;
			color: white;
			padding: 10px 16px;
			font-size: 16px;
			border: none;
			border-radius: 5px;
			text-decoration: none;
			transition: 0.3s;
		}

		.cancel-button:hover {
			background-color: #005bb5;
		}


		.logo {
			height: 40px;
			margin: 10px;
		}

		.logo2 {
			height: 35px;
			margin: 10px;
		}


		.back-button {
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
			margin: 20px 0 20px 30px;
			cursor: pointer;
			transition: 0.3s;
		}

		.back-button:hover {
			background-color: #005bb5;
		}

		.member-table {
			margin-left: 40px;
			width: 95%;
			border-collapse: collapse;
			background: #d0e6ff;
		}

		.member-table th,
		.member-table td {
			border: 2px solid #666;
			padding: 10px;
		}

		.action-btn {
			margin: 0 5px;
			padding: 5px 10px;
			font-weight: bold;
			cursor: pointer;
		}

		.tbody {
			background-color: white;
		}

		.table-header {
			margin: 20px 30px;
			text-align: right;
		}
	</style>
</head>

<body>
	<div class="header1">
		<img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo" />
		<img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo" />
		<div class="header-center">
			<h2>User Profile Management</h2>
			<p>Petakom Coordinator: Dr. Haneef</p>
		</div>
		<div class="header-right">
			<a href="logout_button.php" class="logout">Logout</a>
			<a href="s_edit_profile.php">
				<img src="images/profile.png" alt="Profile" class="logo2">
			</a>
		</div>
	</div>

	<div class="nav">
		<div class="menu">
			<div class="item"><a href="c_homepage.php">Dashboard</a></div>

			<div class="item">
				<a href="#" class="sub-button">Users<i class="fa-solid fa-caret-down"></i></a>
				<div class="sub-menu">
					<a class="active" href="c_manageProfile.php" class="sub-item">Manage Profile</a>
					<a href="c_addNewUser.php" class="sub-item">Add New User</a>
				</div>
			</div>

			<div class="item">
				<a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
				<div class="sub-menu">
					<a href="c_membership.php" class="sub-item">Membership Approval</a>
				</div>
			</div>

			<div class="item">
				<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
				<div class="sub-menu">
					<a href="#events" class="sub-item">View Event</a>
					<a href="c_merit.php" class="sub-item">Merit Application</a>
				</div>
			</div>
		</div>
	</div>

	<div class="content">
		<br>

		<form method="POST" class="form">
			<label>Full Name</label><br>
			<input type="text" class="details1" value="<?php echo htmlspecialchars($userName); ?>" readonly><br>

			<label>Email Address</label><br>
			<input type="email" class="details1" value="<?php echo htmlspecialchars($userEmail); ?>" readonly><br>

			<label><?php echo htmlspecialchars($userIDType); ?></label><br>

			<label>Phone Number</label><br>
			<input type="text" class="details2" value="<?php echo htmlspecialchars($userPhone); ?>" readonly><br>

			<?php if (!empty($extraField)) { ?>
				<label>Additional Info</label><br>
				<input type="text" class="details2" value="<?php echo htmlspecialchars($extraField); ?>" readonly><br>
			<?php } ?>

			<br>
			<a class="cancel-button" href="c_manageProfile.php">Back</a>
		</form>
	</div>



	<script type="text/javascript">
		$(document).ready(function() {
			$('.sub-button').click(function() {
				$(this).next('.sub-menu').slideToggle();
			});
		});
	</script>
</body>

</html>