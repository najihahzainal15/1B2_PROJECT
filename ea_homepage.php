<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login_page.php");
    exit;
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
  <style>
  
	body{
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
	  margin-right: 15px;   /* space between Logout and profile icon */
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
	
	h2{
	margin: 0px 40px;
	font-size: 25px;
	}
	
	p{
	margin: 0px 40px;
	font-size: 16px;
	}
	
	.p1{
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
	
	
	.sub-menu{
		background: #044e95;
		display: none;
	}
	
	.sub-menu a{
		padding-left: 30px;
		font-size: 12px;
	}

	.button{
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
	
	.content{ 
	  background-color: #e6f0ff; 
	  margin-left: 160px;
	  height: auto;
	}
	
	
	.logo {
	  height: 40px;
	  margin: 10px;
	}
	
	.logo2{
	  height: 35px;
	  margin: 10px;
	}
	
	.events-container{
		height: auto;
		display: flex;
		flex-direction: row;
		flex-wrap: wrap;
		gap: 30px;
		margin-left: 30px;
	}
	
	.event{
		width: 300px;
		height: 330px;
		background: white;
		margin: 20px;
		box-sizing: border-box;
		font-size: 14px;
		box-shadow: 0px 0px 10px 2px grey;
		transition: 1s;
	}
	
	.event:hover{
		transform: scale(1.05);
		z-index: 2;
    }
	
	.eventImage{
	  height: 260px;
	  width: 300px;
	  justify-content: center;
	  align-items: center;
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
	  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
	  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
	  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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

  </style>
</head>
<body>
  <div class="header1">
	<img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
		<div class="header-center">
			<h2>Dashboard</h2>
			<p>Event Advisor: Prof. Hakeem</p>
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
		<div class="item"><a class="active" href="ea_homepage.php">Dashboard</a></div>
		
		<div class="item">
			<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="ea_viewEvent.php" class="sub-item">View Event</a>
				<a href="ea_registerEvent1.php" class="sub-item">Register New Event</a>
				<a href="ea_eventCommittee.php">Event Committee</a>
				<a href="ea_committeeReg.php" class="sub-item">Register Committee Event</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a  href="ea_attendanceSlot.php" class="sub-item">Attendance Slot</a>
			</div>
		</div>
	</div>
  </div>
  
  <div class="content">
	<br>
	<h2>Hi Prof. Hakeem</h2>
	<p>Welcome to MyPetakom's home.</p>
	<br>
	<h2>Upcoming Events</h2>
	<div class="events-container">
			<div class="event">
					<img src="images/larian_amal.jpg" class="eventImage">
						<div class="event-content">
							<p align="center" class="p1">Larian Amal UMPSA 2025</h3><br>
							<p align="center" class="p1">31 May 2025</p>
						</div>
			</div>
			
			<div class="event">
					<img src="images/hackaton.jpg" class="eventImage">
						<div class="event-content">
							<p align="center" class="p1">Hackaton X: Smart City 2025</h3><br>
							<p align="center" class="p1">28 May 2025</p>
						</div>
			</div>
			
			<div class="event">
					<img src="images/combat.jpg" class="eventImage">
						<div class="event-content">
							<p align="center" class="p1">COMBAT 2025</h3><br>
							<p align="center" class="p1">9 May-23 May 2025</p>
						</div>
			</div>
	</div>
	
	<div class="dashboard-content">
	  <div class="overview-cards">
		<div class="card">Total Events Created: 10</div>
		<div class="card">Active Events: 7</div>
		<div class="card">Cancelled Events: 2</div>
		<div class="card">Postponed Events: 1</div>
	  </div>

  <div class="analytics">
		<div class="event-status">
		  <h3>Event Status</h3>
		  <img src="images/pie2.jpg" alt="Event Status Pie Chart" class="chart">
		</div>

    <div class="recent-activities">
      <h3>Recent Activities</h3>
      <ul>
        <li>Created Event “Tech Talk 2025”</li>
        <li>Postponed Event “Workshop AI”</li>
        <li>Registered a new committee</li>
      </ul>
    </div>
  </div>
</div>

	<script type="text/javascript">
	$(document).ready(function(){
		$('.sub-button').click(function(){
			$(this).next('.sub-menu').slideToggle();
		});
	});
	</script>
</body>
</html>
