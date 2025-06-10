<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
	header("location: login_page.php");
	exit();
}

$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());
$userID = $_SESSION["userID"];
$role = $_SESSION["role"];

$queryUser = "SELECT username FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

$loggedInUser = !empty($userData["username"]) ? ucwords(strtolower($userData["username"])) : "User";

// Count total users from user table
$userCountQuery = "SELECT COUNT(*) AS total_users FROM user";
$userCountResult = mysqli_query($link, $userCountQuery);
$userCountRow = mysqli_fetch_assoc($userCountResult);
$totalUsers = $userCountRow['total_users'];

// Count students by course prefix using COUNT and GROUP BY
$courseCounts = [
	'Software Engineering' => 0,
	'Multimedia Software' => 0,
	'Computer Systems & Networking' => 0,
	'Cyber Security' => 0
];

$courseQuery = "
	SELECT 
		LEFT(LOWER(studentID), 2) AS prefix,
		COUNT(*) AS total
	FROM student
	GROUP BY prefix
";
$courseResult = mysqli_query($link, $courseQuery);
while ($row = mysqli_fetch_assoc($courseResult)) {
	$prefix = $row['prefix'];
	$count = (int)$row['total'];

	if ($prefix == 'cb') $courseCounts['Software Engineering'] = $count;
	elseif ($prefix == 'cd') $courseCounts['Multimedia Software'] = $count;
	elseif ($prefix == 'ca') $courseCounts['Computer Systems & Networking'] = $count;
	elseif ($prefix == 'cf') $courseCounts['Cyber Security'] = $count;
}

// Count students by year of study using COUNT and GROUP BY
$yearCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
$yearQuery = "
	SELECT year_of_study, COUNT(*) AS total 
	FROM student 
	GROUP BY year_of_study
";
$yearResult = mysqli_query($link, $yearQuery);
while ($row = mysqli_fetch_assoc($yearResult)) {
	$year = (int)$row['year_of_study'];
	if (isset($yearCounts[$year])) {
		$yearCounts[$year] = (int)$row['total'];
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>STUDENT DASHBOARD</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<style>
		body {
			margin: 0;
			font-family: 'Poppins', sans-serif;
			background-color: #e6f0ff;
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

		.nav {
			height: 100%;
			width: 170px;
			position: fixed;
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
		}

		.nav a.active,
		.nav a:hover {
			background-color: #0264c2;
			color: white;
		}

		.sub-menu {
			background: #044e95;
			display: none;
		}

		.sub-menu a {
			padding-left: 30px;
			font-size: 12px;
		}

		.logo {
			height: 40px;
			margin: 10px;
		}

		.logo2 {
			height: 35px;
			margin: 10px;
		}

		.content {
			margin-left: 160px;
			padding: 20px;
		}

		.events-container {
			display: flex;
			flex-wrap: wrap;
			gap: 30px;
			margin-top: 30px;
		}

		.event {
			width: 300px;
			background: white;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			margin: 20px;
			border-radius: 8px;
			transition: 0.3s;
			overflow: hidden;
		}

		.event:hover {
			transform: scale(1.03);
		}

		.event-content {
			padding: 15px;
		}

		.event-content h3 {
			font-size: 18px;
			color: #0074e4;
			margin-bottom: 10px;
		}

		.event-content p {
			font-size: 14px;
			margin: 5px 0;
		}

		.content h2 {
			margin: 0px 40px;
			font-size: 25px;
		}

		.content p {
			margin: 0px 40px;
			font-size: 16px;
			margin-bottom: 20px;
		}
	</style>
</head>

<body>
	<div class="header1">
		<img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo">
		<img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
		<div class="header-center">
			<h2>Dashboard</h2>
			<p>Student: <?php echo htmlspecialchars($loggedInUser); ?></p>
		</div>
		<div class="header-right">
			<a href="logout_button.php" class="logout">Logout</a>
			<a href="s_displayProfile.php"><img src="images/profile.png" class="logo2"></a>
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
		<h2>Hi <?php echo htmlspecialchars($loggedInUser); ?></h2>
		<p>Welcome to MyPetakom's home.</p>

		<h2 style="font-size: 18px;">Overview</h2>
		<div style="
		background-color: #ffffff;
		border-left: 6px solid #0074e4;
		box-shadow: 0 4px 8px rgba(0,0,0,0.1);
		border-radius: 10px;
		padding: 10px 20px;
		margin: 10px 0 30px 0;
		width: fit-content;
		display: flex;
		align-items: center;
		gap: 10px;
	">
			<i class="fas fa-users" style="font-size: 24px; color: #0074e4;"></i>
			<div>
				<div style="font-size: 13px; color: #555;">Total Registered Users</div>
				<div style="font-size: 20px; font-weight: bold;"><?php echo $totalUsers; ?></div>
			</div>
		</div>

		<div style="display: flex; justify-content: center; gap: 40px; flex-wrap: wrap; margin-top: 20px;">
			<div style="width: 45%; max-width: 500px;">
				<h3 style="text-align: center; font-size: 16px;">Total Students by Course</h3>
				<canvas id="courseChart" height="250"></canvas>
			</div>
			<div style="width: 45%; max-width: 500px;">
				<h3 style="text-align: center; font-size: 16px;">Total Students by Year of Study</h3>
				<canvas id="yearChart" height="250"></canvas>
			</div>
		</div>

		<script>
			const ctx = document.getElementById('courseChart').getContext('2d');
			new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['Software Engineering', 'Multimedia Software', 'Computer Systems & Networking', 'Cyber Security'],
					datasets: [{
						label: 'Number of Students',
						data: [
							<?php echo $courseCounts['Software Engineering']; ?>,
							<?php echo $courseCounts['Multimedia Software']; ?>,
							<?php echo $courseCounts['Computer Systems & Networking']; ?>,
							<?php echo $courseCounts['Cyber Security']; ?>
						],
						backgroundColor: ['#0074e4', '#339966', '#ff9933', '#cc3333']
					}]
				},
				options: {
					responsive: true,
					scales: {
						y: {
							beginAtZero: true
						}
					},
					plugins: {
						tooltip: {
							callbacks: {
								label: function(context) {
									let course = context.label;
									let count = context.raw;
									return course + ': ' + count + ' student' + (count !== 1 ? 's' : '');
								}
							}
						}
					}
				}
			});

			const yearCtx = document.getElementById('yearChart').getContext('2d');
			new Chart(yearCtx, {
				type: 'pie',
				data: {
					labels: ['Year 1', 'Year 2', 'Year 3', 'Year 4'],
					datasets: [{
						data: [
							<?php echo $yearCounts[1]; ?>,
							<?php echo $yearCounts[2]; ?>,
							<?php echo $yearCounts[3]; ?>,
							<?php echo $yearCounts[4]; ?>
						],
						backgroundColor: ['#ff9999', '#66b3ff', '#99ff99', '#ffcc99']
					}]
				},
				options: {
					responsive: true,
					plugins: {
						tooltip: {
							callbacks: {
								label: function(context) {
									let label = context.label;
									let value = context.raw;
									let total = context.dataset.data.reduce((a, b) => a + b, 0);
									let percent = ((value / total) * 100).toFixed(1);
									return `${label}: ${value} students (${percent}%)`;
								}
							}
						},
						legend: {
							position: 'bottom',
							labels: {
								font: {
									size: 12
								}
							}
						}
					}
				}
			});
		</script>

		<h2 style="margin-top: 40px;">Upcoming Events</h2>
		<div class="events-container">
			<?php
			$query = "SELECT eventName, eventDesc, eventDate, eventTime, eventLocation FROM event ORDER BY eventDate ASC";
			$result = mysqli_query($link, $query);

			if (mysqli_num_rows($result) > 0) {
				while ($event = mysqli_fetch_assoc($result)) {
					echo '<div class="event">';
					echo '<div class="event-content">';
					echo '<h3>' . htmlspecialchars($event["eventName"]) . '</h3>';
					echo '<p>' . htmlspecialchars($event["eventDesc"]) . '</p>';
					echo '<p><strong>Date:</strong> ' . htmlspecialchars($event["eventDate"]) . '</p>';
					echo '<p><strong>Time:</strong> ' . htmlspecialchars($event["eventTime"]) . '</p>';
					echo '<p><strong>Location:</strong> ' . htmlspecialchars($event["eventLocation"]) . '</p>';
					echo '</div></div>';
				}
			} else {
				echo "<p style='margin-left:30px;'>No events available.</p>";
			}
			?>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('.sub-button').click(function() {
				$(this).next('.sub-menu').slideToggle();
			});
		});
	</script>
</body>

</html>