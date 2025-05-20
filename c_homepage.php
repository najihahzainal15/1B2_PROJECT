<!DOCTYPE html>

<!-- ji kejut aku pukul 8 kalau aku tak roger plith
 -->
<html>
<head>
  <title>COORDINATOR DASHBOARD</title>
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
	
	/* ---- dashboard cards ---- */
	.dashboard-content h3 {
	  margin-top: 0;
	  font-size: 20px;
	  color: #333;
	}

	/* stats grid */
	.stats-grid {
	  display: flex;
	  gap: 20px;
	  margin-bottom: 30px;
	}
	.stat-card {
	  background: white;
	  flex: 1 1 200px;
	  padding: 10px;
	  border-radius: 8px;
	  margin-left: 50px;
	  margin-right: 50px;
	  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
	  text-align: center;
	}
	.stat-card h3 {
	  margin: 0 0 10px;
	  font-size: 18px;
	  font-weight: 600;
	}
	.stat-card p {
	  margin: 0;
	  font-size: 24px;
	  color: #0074e4;
	  font-weight: bold;
	}

	.bar-chart {
	  background: white;
	  padding: 20px;
	  border-radius: 8px;
	  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
	  margin-bottom: 20px;
	  text-align: center;
	  margin-left: 50px;
	  margin-right: 50px;
	}

	.bar-chart h3 {
	  margin: 0 0 15px;
	  font-size: 18px;
	  color: #333;
	}

	.bar-chart .chart-img {
	  max-width: 100%;
	  height: 220px;
	}

	
  </style>
</head>
<body>
  <div class="header1">
	<img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
		<div class="header-center">
			<h2>Dashboard</h2>
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
		<div class="item"><a class="active" href="c_homepage.php">Dashboard</a></div>
		
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
				<a href="c_membership.html" class="sub-item">Membership Approval</a>
			</div>
		</div>

		<div class="item">
			<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="#events" class="sub-item">View Event</a>
				<a href="#events" class="sub-item">Merit Application</a>
			</div>
		</div>
	</div>
  </div>
  
  <div class="content">
	<br>
	<h2>Hi Dr. Haneef</h2>
	<p>Welcome to MyPetakom's home.</p>
	<br>
	
	<div class="dashboard-content">
		
	  <div class="stats-grid">
		<div class="stat-card">
		  <h3>Total Users</h3>
		  <p>2,430</p>
		</div>
	 </div>

	 <div class="bar-chart">
		<h3>Student Attendance by Course</h3>
		<img src="images/bar.png" alt="Attendance Bar Chart" class="chart-img">
	</div>
	
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
