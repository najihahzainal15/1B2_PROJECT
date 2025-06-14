<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login_page.php");
	exit;
}

// Connect to DB
$link = mysqli_connect("localhost", "root", "", "web_project");
if (!$link) {
	die("Connection failed: " . mysqli_connect_error());
}
$userID = $_SESSION["userID"];
$role = $_SESSION["role"];

// Fetch username from database
$queryUser = "SELECT username FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

// Assign username after database query
$loggedInUser = !empty($userData["username"]) ? ucwords(strtolower($userData["username"])) : "User";


// Query to get counts per status
$query = "SELECT status, COUNT(*) as count FROM event GROUP BY status";
$result = mysqli_query($link, $query);

// Initialize counts
$statusCounts = [
	'active' => 0,
	'postpone' => 0,
	'canceled' => 0,
];

// Fill counts from query result
while ($row = mysqli_fetch_assoc($result)) {
	$status = strtolower($row['status']);
	if (isset($statusCounts[$status])) {
		$statusCounts[$status] = (int)$row['count'];
	}
}

$totalEvents = array_sum($statusCounts);
$activeEvents = $statusCounts['active'];
$postponedEvents = $statusCounts['postpone'];
$cancelledEvents = $statusCounts['canceled'];

$committeeQuery = "
	SELECT cr.committeeRole, COUNT(*) as count 
	FROM committee c
	JOIN committeerole cr ON c.roleID = cr.roleID 
	GROUP BY cr.committeeRole
";
$committeeResult = mysqli_query($link, $committeeQuery);

$roleCounts = [];
$totalCommittees = 0;

while ($row = mysqli_fetch_assoc($committeeResult)) {
	$role = $row['committeeRole'];
	$count = (int)$row['count'];
	$roleCounts[$role] = $count;
	$totalCommittees += $count;
}

?>

<!DOCTYPE html>
<html>

<head>
	<title>EVENT ADVISOR DASHBOARD</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

		h2 {
			margin: 0px 40px;
			font-size: 20px;
		}

		p {
			margin: 0px 40px;
			font-size: 16px;
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

		.button {
			background-color: #D2D2D2;
			border: 2px solid #D0D0D0;
			color: black;
			padding: 16px 30px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 25px;
			cursor: pointer;
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


		.overview-cards {
			display: flex;
			gap: 20px;
			padding: 20px 30px;
			flex-wrap: wrap;
			margin-left: 19px;
		}

		.overview-cards .card {
			background: white;
			flex: 1 1 200px;
			padding: 20px;
			border-radius: 12px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			font-size: 16px;
			font-weight: 600;
			text-align: center;
		}

		/* -------- analytics/layout -------- */
		.analytics {
			display: grid;
			grid-template-columns: 2fr 1fr;
			gap: 30px;
			padding: 0 30px 30px;
		}

		/* Pie chart card */
		.event-status {
			background: white;
			padding: 20px;
			border-radius: 12px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			margin-left: 19px;
		}

		.event-status h3 {
			margin-top: 0;
			font-size: 18px;
		}

		.event-status .chart {
			display: block;
			max-width: 100%;
			height: 350px;
			margin: 20px auto 0;
		}

		/* Recent activities card */
		.recent-activities {
			background: white;
			padding: 20px;
			border-radius: 12px;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
		}

		.recent-activities h3 {
			margin-top: 0;
			font-size: 18px;
		}

		.recent-activities ul {
			list-style: none;
			padding: 0;
			margin: 15px 0 0;
		}

		.recent-activities li {
			padding: 8px 0;
			border-bottom: 1px solid #eee;
			font-size: 14px;
		}

		.recent-activities li:last-child {
			border-bottom: none;
		}

		.dashboard-table {
			width: 100%;
			border-collapse: separate;
			border-spacing: 30px 15px;
			/* horizontal gap between cells */
			margin-top: 20px;
		}

		.dashboard-table td {
			padding: 15px 40px;
			background-color: white;
			font-weight: bold;
			text-align: center;
			border-radius: 8px;
		}

		#chart-container {
			width: 90%;
			max-width: 900px;
			margin: 0 auto;
			background-color: #fff;
			padding: 30px;
			border-radius: 12px;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
		}

		canvas {
			width: 100% !important;
			max-height: 400px;
			margin-bottom: 40px;
		}

		#eventStatusChart {
			width: 100% !important;
			height: auto !important;
		}
	</style>
</head>

<body>
	<div class="header1">
		<img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
		<img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
		<div class="header-center">
			<h2>Dashboard</h2>
			<p>Event Advisor: <?php echo htmlspecialchars($loggedInUser); ?></p>
		</div>
		<div class="header-right">
			<a href="logout_button.php" class="logout">Logout</a>
			<a href="ea_displayProfile.php">
				<img src="images/profile.png" alt="Profile" class="logo2">
			</a>
		</div>
	</div>

	<div class="nav">
		<div class="menu">
			<div class="item"><a href="ea_homepage.php">Dashboard</a></div>

			<div class="item">
				<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
				<div class="sub-menu">
					<a href="ea_viewEvent.php" class="sub-item">View Event</a>
					<a href="ea_registerEvent1.php" class="sub-item">Register New Event</a>
					<a href="ea_eventCommittee.php" class="sub-item">Event Committee</a>
					<a href="ea_committeeReg.php" class="sub-item">Register Committee Member</a>
				</div>
			</div>

			<div class="item">
				<a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
				<div class="sub-menu">
					<a href="ea_attendanceSlot.php" class="sub-item">Attendance Slot</a>
				</div>
			</div>
		</div>
	</div>

	<div class="content">
		<br>
		<h2>Hi <?php echo htmlspecialchars($loggedInUser); ?></h2>
		<p>Welcome to MyPetakom's home.</p>
		<br>
		<div class="dashboard-content">
			<table class="dashboard-table">
				<tr>
					<td>Total Events Created: <?php echo $totalEvents; ?></td>
					<td>Active Events: <?php echo $activeEvents; ?></td>
					<td>Cancelled Events: <?php echo $cancelledEvents; ?></td>
					<td>Postponed Events: <?php echo $postponedEvents; ?></td>
				</tr>

				<tr>
					<td>Total Committees: <?php echo $totalCommittees; ?></td>
					<?php foreach ($roleCounts as $role => $count): ?>
						<td><?php echo htmlspecialchars($role); ?>: <?php echo $count; ?></td>
					<?php endforeach; ?>
				</tr>

			</table>
		</div>

		<div id="chart-container">
			<h2>Event Status Distribution (Pie Chart)</h2>
			<canvas id="eventStatusChartPie"></canvas>

			<h2 style="margin-top:40px;">Committee Role Distribution (Bar Chart)</h2>
			<canvas id="committeeRoleBarChart"></canvas>
		</div>


		<script type="text/javascript">
			$(document).ready(function() {
				$('.sub-button').click(function() {
					$(this).next('.sub-menu').slideToggle();
				});
			});
		</script>

		<script>
			const committeeRoles = <?= json_encode(array_keys($roleCounts)); ?>;
			const committeeCounts = <?= json_encode(array_values($roleCounts)); ?>;
		</script>

		<!-- Charts Initialization -->
		<script>
			// Pie Chart for Event Status
			const ctx1 = document.getElementById('eventStatusChartPie').getContext('2d');
			new Chart(ctx1, {
				type: 'pie',
				data: {
					labels: ['Active', 'Postpone', 'Canceled'],
					datasets: [{
						data: [<?= $statusCounts['active'] ?>, <?= $statusCounts['postpone'] ?>, <?= $statusCounts['canceled'] ?>],
						backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'],
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					plugins: {
						legend: {
							position: 'bottom'
						}
					}
				}
			});

			// Bar Chart for Committee Roles
			const ctx2 = document.getElementById('committeeRoleBarChart').getContext('2d');
			new Chart(ctx2, {
				type: 'bar',
				data: {
					labels: committeeRoles,
					datasets: [{
						label: 'Committee Count',
						data: committeeCounts,
						backgroundColor: '#4CAF50',
						borderColor: '#388E3C',
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					scales: {
						y: {
							beginAtZero: true,
							title: {
								display: true,
								text: 'Number of Committees'
							}
						},
						x: {
							title: {
								display: true,
								text: 'Committee Roles'
							}
						}
					}
				}
			});
		</script>
</body>

</html>