<!DOCTYPE html>
<html>
<head>
  <title>EVENT ADVISOR REGISTER NEW EVENT</title>
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
	  overflow-y: auto;
	  margin-left: 165px;
	  padding: 10px;
	  
	}

	.logo {
	  height: 40px;
	  margin: 10px;
	}
	
	.logo2{
	  height: 35px;
	  margin: 10px;
	}
	
	.section-title {
      background: #f0f0f0;
      padding: 12px;
      margin: 0;
      text-align: center;
      font-size: 20px;
      font-weight: bold;
      border-top: 2px solid #000;
      border-bottom: 2px solid #000;
    }

    /* Form Grid */
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

    

    .actions {
      display: flex;
      justify-content: space-between; 
      gap: 15px;
      padding: 0 20px 30px;
    }

	.qr-code-generator {
		margin: 20px;
		padding: 20px;
		background-color: #F2F2F2;
	}

	.qr-code-generator h2 {
		text-align: center;
		margin-bottom: 20px;
	}

	.qr-container {
		display: flex;
		justify-content: space-between;
	}

	.qr-code {
		width: 40%;
		padding: 10px;
		background-color: #fff;
		border: 1px solid #ddd;
		border-radius: 8px;
		text-align: center;
	}

	.qr-code img {
		width: 100%;
		height: auto;
		max-width: 250px;
	}

	.event-details {
		width: 55%;
		padding: 10px;
		background-color: #fff;
		border: 1px solid #ddd;
		border-radius: 8px;
	}



	.event-details p {
		margin: 10px 0;
		font-size: 16px;
	}

	.event-details .buttons {
		display: flex;
		justify-content: space-between;
		margin-top: 20px;
	}

	button.save-btn, button.download-btn {
		padding: 10px 20px;
		background-color: #0096D6;
		color: white;
		border: none;
		cursor: pointer;
		font-size: 16px;
	}

	button.save-btn:hover, button.download-btn:hover {
		background-color: #0264c2;
	}

	.submit-button{
	   background-color: #0074e4; 
	   font-family: 'Poppins', sans-serif;
	   border: none;
	   border-radius: 10px;
	   color: white;
	   padding: 8px 10px;
	   margin-bottom:20px;
	   text-decoration: none;
	   display: inline-block;
	   font-size: 14px;
	  
	   cursor: pointer;
	   transition: 0.3s;
	   
	 }
	 
	 .submit-button:hover {
	   background-color: #005bb5;
	 }
	
	
  </style>
</head>

<body>
  <div class="header1">
	<img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
		<div class="header-center">
			<h2>Register New Event</h2>
			<p>Event Advisor: Prof. Hakeem</p>
		</div>
		<div class="header-right">
			<a href="logout_button.php" class="logout">Logout</a>
			<a href="s_edit_profile.html">
				<img src="images/profile.png" alt="Profile" class="logo2">
			</a>
		</div>  
  </div>
  
 <div class="nav">
    <div class="menu">
      
      <div class="item"><a href="ea_homepage.php">Dashboard</a></div>

      <div class="item">
        <a href="#events" class="sub-button">Events <i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="ea_viewEvent.html">View Event</a>
          <a class="active" href="ea_registerEvent1.php">Register New Event</a>
          <a href="ea_eventCommittee.php">Event Committee</a>
		  <a href="ea_committeeReg.php">Register Committee Member</a>
        </div>
      </div>

      <div class="item">
        <a href="#attendance" class="sub-button">Attendance <i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="ea_attendanceSlot.php">Attendance Slot</a>
        </div>
      </div>

      
    </div>
  </div>
  
  <div class="content">
	 <div class="qr-code-generator">
        <h2>EVENT DETAILS QR CODE GENERATOR</h2>
        
        <div class="qr-container">
            <div class="qr-code">
                <h3>QR CODE</h3>
                <!-- Insert your QR code image here -->
                <img src="images/QR.webp" alt="QR Code">
            </div>

            <div class="event-details">
                <p><strong>Event Name:</strong> HACKATON FUN RUN</p>
                <p><strong>Date:</strong> 25 MAY 2025</p>
                <p><strong>Geolocation:</strong> 2.9285, 101.7715 (Faculty of Computing)</p>
                
                    <button class="submit-button">Save</button>
                    <button class="submit-button">Download</button>
                
            </div>
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
