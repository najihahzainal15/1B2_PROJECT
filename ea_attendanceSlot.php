<?php
require_once "config.php";

// // Check if user is logged in as event advisor
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'event_advisor') {
//     header("Location: login.php");
//     exit();
// }

// Fetch events from database
$events = [];
$sql = "SELECT eventID, eventName, eventDate, status FROM event";
$result = mysqli_query($link, $sql);

if ($result) {
	$events = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
	die("Database error: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>EVENT ADVISOR ATTENDANCE SLOT</title>
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
			padding-left: 30px;
			width: 100%;
			box-sizing: border-box;

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

		.sub-menu a.active {
			background-color: #0264c2;
			/* darker shade for nested active */
			font-weight: bold;
		}

		.nav a.active-parent {
			background-color: #0264c2;
			color: white;
		}

		/* .sub-menu1{
		background: #044e95;
		display: none;
	}
	
	.sub-menu1 a{
		padding-left: 30px;
		font-size: 12px;
	} */


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
			margin-left: 170px;
			width: calc(100% - 170px);
			min-height: 100vh;
			/* Ensure it fills the viewport */
			display: flex;
			flex-direction: column;
			justify-content: flex-start;
			/* Ensures content stays aligned */
			padding-bottom: 100px;
			/* Extra space beyond the last element */
			position: relative;
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

		.back-btn {
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

		.event-table {
			width: 90%;
			border-collapse: collapse;
			background: #d0e6ff;
			margin-top: 30px;
			margin-left: 40px;
			flex-grow: 1;
			margin-bottom: 50px;
		}

		.event-table th,
		.event-table td {
			border: 2px solid #666;
			padding: 10px;
			text-align: center;
		}

		.status.active {
			background-color: #c6f6c6;
			font-weight: bold;
		}

		.status.cancelled {
			background-color: #f6c6c6;
			font-weight: bold;
		}

		.status.postpone {
			background-color: #fff0b3;
			font-weight: bold;
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

		.submit-button {
			background-color: #0074e4;
			font-family: 'Poppins', sans-serif;
			border: none;
			border-radius: 10px;
			color: white;
			padding: 8px 14px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
			margin: 4px 25px;
			cursor: pointer;
			transition: 0.3s;
			float: left;
		}

		.submit-button:hover {
			background-color: #005bb5;
		}


		td .QRButton {
			border-style: none;
			background-color: #6666f0ff;
		}
	</style>
</head>

<body>
	<div class="header1">
		<img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
		<img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
		<div class="header-center">
			<h2>Attendance Slot</h2>
			<p>Event Advisor: Prof. Hakeem</p>
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
					<a href="ea_committeeReg.php" class="sub-item">Register Committee Event</a>
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
		<table class="event-table">
			<thead>
				<tr>
					<th>EVENT NAME</th>
					<th>DATE</th>
					<th>STATUS</th>
					<th>ATTENDANCE QR GENERATOR</th>
				</tr>
			</thead>
			<tbody class="tbody">
				<?php foreach ($events as $event): ?>
					<tr>
						<td><?php echo htmlspecialchars($event['eventName']); ?></td>
						<td><?php echo htmlspecialchars($event['eventDate']); ?></td>
						<td class="status <?php echo strtolower($event['status']); ?>">
							<?php echo htmlspecialchars($event['status']); ?>
						</td>

						<td class="QRButton">
							<?php if (strtoupper($event['status']) === 'ACTIVE'): ?>
								<a href="ea_attendanceQR.php?event=<?php echo urlencode($event['eventName']); ?>&date=<?php echo urlencode($event['eventDate']); ?>&event_id=<?php echo $event['eventID']; ?>">
									<button class="action-btn">GENERATE ATTENDANCE QR</button>
								</a>
							<?php else: ?>
								<span style="color: grey; font-weight: bold;">Unavailable</span>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>

		</table>
	</div>
	<br>
	<br>

	<button class="submit-button">Back</button>
	</main>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.sub-button').click(function() {
				$(this).next('.sub-menu').slideToggle();
			});

			// Automatically open sub-menu if it contains an active item
			$('.sub-menu').each(function() {
				if ($(this).find('.active').length > 0) {
					$(this).show();
					$(this).prev('.sub-button').addClass('active-parent');
				}
			});
		});
	</script>
</body>

</html>