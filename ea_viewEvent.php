<!DOCTYPE html>
<html>
<head>
  <title>EVENT ADVISOR VIEW EVENT</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MyPetakom Event Advisor Homepage</title>
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
	
    .back-btn {
      background: #e6e6e6;
      padding: 10px 20px;
      border: 2px solid #999;
      font-weight: bold;
      cursor: pointer;
      margin-bottom: 20px;
    }
	
	.register-btn-container {
    text-align: left;
    margin-left: 30px; /* Slight left alignment */
}
	
	.register-btn {
    background-color: #0074e4; /* Consistent blue */
    border: none;
    color: white;
    padding: 12px 20px;
    font-size: 16px;
    font-family: 'Poppins', sans-serif;
    text-align: left;
    display: block;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    margin: 10px 0;
    width: fit-content;
}


    .back-btn {
      margin-top: 30px;
      background: #fff;
      border: 2px solid #000;
    }

    .event-table {
      width: 95%;
      border-collapse: collapse;
	  margin-left: 30px;
      background: #.content {
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
};
    }

    .event-table th, .event-table td {
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

	hr.new4 {
	 border: 1px solid black;
	}
	   
	.tbody {
	background-color: white;}
	
	
	.submit-button{
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
 
 .register-btn:hover {
    background-color: #005bb5;
}

.thead{
	color:white;
	background-color:#0096D6;
}

.tbody{
	background-color:white;
	
}

	
  </style>
</head>

<body>
  <div class="header1">
	<img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
		<div class="header-center">
			<h2>View Event</h2>
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
          <a class="active" href="ea_viewEvent.html">View Event</a>
          <a href="ea_registerEvent1.php">Register New Event</a>
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
  
	<div class="register-btn-container">
    <button class="register-btn">REGISTER NEW EVENT +</button>
</div>
	
	
    <table class="event-table">
      <thead class="thead">
        <tr>
          <th>EVENT NAME</th>
          <th>DATE</th>
          <th>STATUS</th>
          <th>EDIT / DELETE / QR </th>
        </tr>
      </thead>
	  
	  <tbody class="tbody">
    <tr><td>AMAL  FUN RUN ZOMBIE</td><td>17 JUNE 2021</td><td>ACTIVE</td><td>
    <a href='ea_viewEventUpdate.php?id=3'>EDIT</a> || 
    <a href='ea_viewEventDelete.php?id=3' onclick="return confirm('Are you sure to delete this record?');">DELETE</a> ||
    <a href='ea_registerEvent2.php?id=3'>QR</a> 
</td><tr><td>FLUUTER PRO</td><td>30 JUNE 2025</td><td>CANCELED</td><td>
    <a href='ea_viewEventUpdate.php?id=8'>EDIT</a> || 
    <a href='ea_viewEventDelete.php?id=8' onclick="return confirm('Are you sure to delete this record?');">DELETE</a> ||
    <a href='ea_registerEvent2.php?id=8'>QR</a> 
</td><tr><td>FIGMA PRO TECH</td><td>17 JUNE 2025</td><td></td><td>
    <a href='ea_viewEventUpdate.php?id=9'>EDIT</a> || 
    <a href='ea_viewEventDelete.php?id=9' onclick="return confirm('Are you sure to delete this record?');">DELETE</a> ||
    <a href='ea_registerEvent2.php?id=9'>QR</a> 
</td>  </tbody>
  </table>
	 
    <button class="submit-button">Back</button>
  </main>
	</div>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.sub-button').click(function(){
			$(this).next('.sub-menu').slideToggle();
		});
	});
	</script>
</body>
