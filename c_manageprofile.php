<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login_page.php");
	exit;
}

$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());
$userID = $_SESSION["userID"];
$role = $_SESSION["role"];

// Get user's name from the database
$queryUser = "SELECT username FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

$loggedInUser = !empty($userData["username"]) ? ucwords(strtolower($userData["username"])) : "User";
?>

<!DOCTYPE html>
<html>

<head>
	<title>COORDINATOR MANAGE PROFILE</title>
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

			margin-left: 160px;
			min-height: 100vh;
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
			border: 1px solid #666;
			border-collapse: collapse;
			padding: 10px;
		}

		.member-table td:last-child {
			text-align: center;
			white-space: nowrap;
		}

		.member-table td:last-child a {
			margin: 0 5px;
		}

		.member-table td:first-child {
			text-align: center;
		}

		.action-btn {
			text-align: center;
			min-width: 50px;
			cursor: pointer;
			text-decoration: none;
		}

		.tbody {
			background-color: white;
		}

		.table-header {
			margin: 20px 30px;
			text-align: right;
		}

		.add-btn {
			background: #0074e4;
			color: white;
			padding: 6px 12px;
			font-size: 14px;
			border-radius: 6px;
			text-decoration: none;
			transition: background 0.3s;
		}

		.add-btn:hover {
			background: #005bb5;
		}
	</style>
</head>

<body>
	<div class="header1">
		<img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo" />
		<img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo" />
		<div class="header-center">
			<h2>User Profile Management</h2>
			<p>Petakom Coordinator: <?php echo  htmlspecialchars($loggedInUser); ?></p>
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

		<div class="table-header">
			<a href="c_addNewUser.php" class="add-btn">Add New User</a>
		</div>
		<form method="post" action="c_deleteUser.php">
			<table class="member-table">
				<thead>
					<tr>
						<th>NO.</th>
						<th>NAME</th>
						<th>ROLE</th>
						<th>EMAIL ADDRESS</th>
						<th>ACTIONS</th>
					</tr>
				</thead>
				<tbody class="tbody">
					<?php
					//Connect to the database server.
					$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());

					//Select the database.
					mysqli_select_db($link, "web_project") or die(mysqli_error($link));

					//SQL query
					$query = "SELECT * FROM user"
						or die(mysqli_connect_error());

					//Execute the query (the recordset $rs contains the result)
					$result = mysqli_query($link, $query);

					if (mysqli_num_rows($result) > 0) {
						$no = 1;
						while ($row = mysqli_fetch_assoc($result)) {
							$ID = $row["userID"];
							echo "<tr>";
							echo "<td>" . $no++ . "</td>";
							echo "<td>" . htmlspecialchars($row['username']) . "</td>";
							echo "<td>" . htmlspecialchars($row['role']) . "</td>";
							echo "<td>" . htmlspecialchars($row['email']) . "</td>";
							echo "<td>
						<a href='c_viewUser.php?id=" . $row['userID'] . "' class='action-btn'>VIEW</a> 
						<a href='c_editUser.php?id=" . $row['userID'] . "' class='action-btn'>EDIT</a>
						<a href='c_deleteUser.php?id=" . $row['userID'] . "' class='action-btn' onclick=\"return confirm('Are you sure you want to delete this user?');\">DELETE</a>
					  </td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='5'>No users found.</td></tr>";
					}

					mysqli_close($link);
					?>
				</tbody>
			</table>
		</form>

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