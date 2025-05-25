<?php
// Initialize the session
session_start();
require_once "config.php"; // Database configuration

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login_page.php");
	exit;
}

$link = mysqli_connect("localhost", "root", "", "web_project");

// Fetch student membership applications
$query = "SELECT s.studentID, s.student_card_upload, s.programme, s.year_of_study, 
                 m.verification_status, m.membership_ID
          FROM student s
          INNER JOIN membership m ON s.studentID = m.studentID
          ORDER BY m.verification_status";

$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html>

<head>
	<title>COORDINATOR MEMBERSHIP APPROVAL</title>
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
			margin-left: 160px;
			height: auto;
			background-color: transparent;
		}

		.logo {
			height: 40px;
			margin: 10px;
		}

		.logo2 {
			height: 35px;
			margin: 10px;
		}

		.register-btn,
		.back-btn {
			background: #e6e6e6;
			padding: 10px 20px;
			border: 2px solid #999;
			font-weight: bold;
			cursor: pointer;
			margin-bottom: 20px;
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
			margin: 20px 0 20px 40px;
			cursor: pointer;
			transition: 0.3s;
		}

		.back-button:hover {
			background-color: #005bb5;
		}

		.member-table {
			margin-left: 40px;
			width: 90%;
			border-collapse: collapse;
			background: #d0e6ff;
			margin-top: 20px;
		}

		.member-table tbody tr {
			background-color: white;
		}


		.member-table th,
		.member-table td {
			border: 2px solid #666;
			padding: 10px;
			text-align: center;
			font-family: 'Poppins', sans-serif;
			vertical-align: middle;
		}

		.status-approve {
			background-color: #c6f6c6;
			font-weight: bold;
		}

		.status-reject {
			background-color: #f6c6c6;
			font-weight: bold;
		}

		.status-pending {
			background-color: #fff0b3;
			font-weight: bold;
		}

		.action-btn {
			font-family: 'Poppins', sans-serif;
			font-weight: bold;
			background-color: #b0b0b0;
			color: black;
			padding: 8px 12px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			transition: 0.3s;
			margin: 0 10px;
		}

		.action-btn:hover {
			background-color: #808080;
		}

		.header-right a {
			cursor: pointer;
		}

		.status-approve {
			background-color: #c6f6c6;
			font-weight: bold;
		}

		.status-reject {
			background-color: #f6c6c6;
			font-weight: bold;
		}

		.status-pending {
			background-color: #fff0b3;
			font-weight: bold;
		}

		.submit-button,
		.cancel-button {
			padding: 5px 10px;
			font-weight: bold;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}

		.submit-button {
			background-color: #4CAF50;
			color: white;
		}

		.submit-button:hover {
			background-color: #45a049;
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
	</style>
</head>

<body>
	<div class="header1">
		<img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo" />
		<img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo" />
		<div class="header-center">
			<h2>Membership Approval</h2>
			<p>Petakom Coordinator: Dr. Haneef</p>
		</div>

		<div class="header-right">
			<a href="logout_button.php" class="logout">Logout</a>
			<a href="c_displayProfile.php">
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
					<a href="c_manageProfile.php" class="sub-item">Manage Profile</a>
					<a href="c_addNewUser.php" class="sub-item">Add New User</a>
				</div>
			</div>

			<div class="item">
				<a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
				<div class="sub-menu">
					<a class="active" href="c_membership.php" class="sub-item">Membership Approval</a>
				</div>
			</div>

			<div class="item">
				<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
				<div class="sub-menu">
					<a href="#events" class="sub-item">View Event</a>
					<a href="c_meritApp.php" class="sub-item">Merit Application</a>
				</div>
			</div>
		</div>
	</div>

	<div class="content">
		<table class="member-table">
			<thead>
				<tr>
					<th>NO.</th>
					<th>STUDENT ID</th>
					<th>STUDENT CARD</th>
					<th>STATUS</th>
					<th>ACTIONS</th>
				</tr>
			</thead>

			<tbody>
				<?php
				$count = 1;
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr>";
					echo "<td>" . $count++ . "</td>"; // Auto-increment row number
					echo "<td>" . htmlspecialchars($row["studentID"]) . "</td>";
					echo "<td><a href='" . htmlspecialchars($row["student_card_upload"]) . "' target='_blank'>View</a></td>";
					echo "<td class='status-text " . strtolower($row["verification_status"]) . "'>" . htmlspecialchars($row["verification_status"]) . "</td>";
					echo "<td>
                <form action='c_membership_action.php' method='POST'>
                    <input type='hidden' name='membership_ID' value='" . htmlspecialchars($row["membership_ID"]) . "'>
                    <button type='submit' name='approve' class='action-btn'>APPROVE</button>
                    <button type='submit' name='reject' class='action-btn'>REJECT</button>
                </form>
              </td>";
					echo "</tr>";
				}
				?>
			</tbody>

		</table>

		<button class="back-button">Back</button>
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