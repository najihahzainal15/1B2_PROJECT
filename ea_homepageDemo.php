<!DOCTYPE html>
<html>
<head>
  <title>EVENT ADVISOR HOMEPAGE</title>
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
	  overflow: hidden;
	  background-color: #0074e4;
	  padding: 0px 10px;
	  margin-left: 160px;
	}
	
	.header-right {
	  float: right;
	}
	
	h2{
	margin: 0px 40px;
	font-size: 25px;
	color:black;
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
	

	.logo{
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
	
	.icons{
		background: white;
		border: 0.1 rem solid black;
		padding: 2rem;
		display: flex;
		align-items: center;
		flex: 1 1 25rem;
	}
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
      color: white;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo {
      height: 40px;
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

    .header-right {
      display: flex;
      align-items: center;
    }

    .logo2 {
      height: 35px;
      border-radius: 50%;
    }

    .nav {
      height: 100%;
      width: 170px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #0074e4;
      padding-top: 20px;
      z-index: 1;
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

    .nav a:hover {
      background-color: #0264c2;
      transition: all 0.4s ease;
    }

    .nav a.active {
      background-color: #0264c2;
      color: white;
    }

   .content {
	  margin-left: 120px;
	  padding: 20px;
	  background-color: #e6f0ff;
	  display: flex;
	  justify-content: center;
	  width: calc(100% - 170px);  /* Use available space */
	  flex-direction: column; /* Stack items vertically */
	}



@media (max-width: 800px) {
  .table-container {
    margin-left: 20px;
    margin-right: 20px;
    width: calc(100% - 40px); /* Adjust for small screens */
    padding: 10px; /* Less padding on small screens */
  }

  .identity-row input,
  .event-details input {
    font-size: 14px; /* Smaller text for smaller screens */
  }
}

    .section-header {
      background: #f0f0f0;
      padding: 12px;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      border-top: 2px solid black;
      border-bottom: 2px solid black;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 10px;
      padding: 20px;
    }

    .form-grid label {
      background: #d9d9d9;
      font-weight: bold;
      padding: 10px;
      text-align: center;
    }

    input[type="text"], textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #666;
      background: white;
      font-size: 14px;
    }

    textarea {
      resize: none;
      height: 60px;
    }

    .merit-buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
      padding: 20px;
    }

    .form-btn {
      padding: 12px 20px;
      font-size: 14px;
      cursor: pointer;
      border: 2px solid #999;
      background: #f2f2f2;
      font-weight: bold;
    }

    .actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      padding: 0 20px 30px;
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
	
	.button{
	  background-color: #D2D2D2; 
	  border: 2px solid black;
	  color: black;
	  padding: 10px 20px;
	  text-align: left;
	  text-decoration: none;
	  display: inline-block;
	  font-size: 16px;
	  margin: 4px 20px;
	  cursor: pointer;
	}
	
	.logo3{
	width:350px;
	height:250px;
	
	}
	
  </style>
</head>
<body>
  <div class="header1">
    
	<div class="header-left">
  <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo logo-left">
  <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo logo-left">
	</div>

		<div class="header-center">
    <h2>Dashboard</h2>
    <p>Advisor Event : Prof. Hakeem</p>
  </div>
		
		
		<div class="header-right">
			<a href="ea_edit_profile.html">
				<img src="images/profile.png" alt="Profile" class="logo2">
			</a>
		</div>  
  </div>
  
  <div class="nav">
    <div class="menu">
      
      <div class="item"><a class="active" href="ea_homepage.html">Dashboard</a></div>

      <div class="item">
        <a href="#events" class="sub-button">Events <i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="ea_viewEvent.html">View Event</a>
          <a href="ea_registerEvent.html">Register New Event</a>
          <a href="ea_eventCommittee.html">Event Committee</a>
		  <a href="ea_committeeReg.html">Register Committee Member</a>
        </div>
      </div>

      <div class="item">
        <a href="#attendance" class="sub-button">Attendance <i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="#attendance">Attendance Slot</a>
        </div>
      </div>

      
    </div>
  </div>
  
  <div class="content">
	<h2>Hi Prof. Hakeem</h2>
	<p>Welcome to MyPetakom's home.</p>
	<br>
	<h2>My Managed Events</h2>
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
 
    <div class="content">
    <div class="table-container">
	
       <div class="navbar">
        <button class="button">Total Event Created: 10</button>
        <button class="button">Active Events: 7</button>
        <button class="button">Cancelled Events: 2</button>
        <button class="button">Postponed Events: 1</button>
    </div>

    <div class="dashboard">
        <div class="event-status">
            <h2>EVENT STATUS</h2>
            <!-- Add pie chart as an image -->
            <img src="images/pie2.jpg" alt="Event Status Pie Chart" class="logo3">
        </div>

        <div class="recent-activities">
            <h2>RECENT ACTIVITIES</h2>
            <ul>
                <li>Created Event “Tech Talk 2025”</li>
                <li>Postponed Event “Workshop AI”</li>
				<li>Registered a new commitee</li>
            </ul>
        </div>

        
    </div>

    <div class="back">
        <button class="submit-button">Back</button>
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
