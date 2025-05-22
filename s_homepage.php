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
  <title>STUDENT DASHBOARD</title>
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
	  height: 100vh;
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

  </style>
</head>
<body>
  <div class="header1">
	<img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
		<div class="header-center">
			<h2>Dashboard</h2>
			<p>Student: Alif</p>
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
		<div class="item"><a class="active" href="s_homepage.php">Dashboard</a></div>
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
	<h2>Hi Alif</h2>
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
	
	<script type="text/javascript">
	$(document).ready(function(){
		$('.sub-button').click(function(){
			$(this).next('.sub-menu').slideToggle();
		});
	});
	</script>
</body>
</html>
