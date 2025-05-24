<!DOCTYPE html>
<html>
<head>
  <title>	EVENT ADVISOR MERIT</title>
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
	
	p{
		margin: 0px 40px;
		font-size: 16px;
	}
	
	.p1{
		margin: 5px;
		font-size: 14px;
	}
	
	
	h2{
	margin: 0px 40px;
	font-size: 25px;
	color:black;
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



    
	.content {
	 margin-left: 150px; /* match nav width */
	  padding: 20px;
	  background-color: #e6f0ff;
	  display: flex;
	  justify-content: center;
	  overflow-x: auto; /* allow horizontal scroll if needed */
	}

	.table-container {
  padding: 40px;
  background-color: #F2F2F2;
  width: 150%; /* Increased from 80% */
  max-width: 1400px; /* Optional: limits max width on very large screens */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}


	table {
  width: 100%;
  border-collapse: collapse;
  table-layout: auto; 
  word-wrap: break-word; /* wrap long text */
  font-size: 13px; /* slightly smaller font */
}

	table th, table td {
		padding: 15px;
  border: 1px solid #ddd;
  text-align: center;
  vertical-align: middle;
  word-wrap: break-word; /* wrap long text */
  white-space: normal; /* allow wrapping */
	}

	table th {
		background-color: #0096D6;
		color: white;
	}
	
	th:nth-child(4), td:nth-child(4) { 
  width: 15%; /* Increase width */
}

th:nth-child(6), td:nth-child(6) { 
  width: 20%; 
  
}

th:nth-child(1), td:nth-child(1) { 
  width: 11%; 
  
}

th:nth-child(2), td:nth-child(2) { 
  width: 8%; 
  
}

th:nth-child(3), td:nth-child(3) { 
  width: 8%; 
  
}


th:nth-child(5), td:nth-child(5) { 
  width: 13%; 
  
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
	  float: right;
	   display: flex;
      align-items: center;
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

.header-left {
  display: flex;
  align-items: center;
  gap: 10px;
  min-width: 120px;
}


	.logo {
  height: 40px;
}

.logo2 {
  height: 35px;
  border-radius: 50%;
}


 
 table thead th {
  background-color: #0096D6;
  color: white;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

table tbody tr:nth-child(even) {
  background-color: #f9f9f9;
}

table tbody tr:hover {
  background-color: #e0f0ff;
  transition: background-color 0.2s ease;
}

table td, table th {
  padding: 12px 10px;
  text-align: center;
  vertical-align: middle;
  border: 1px solid #ddd;
}

a {
  color: #0066cc;
  text-decoration: none;
  font-weight: 600;
}

a:hover {
  text-decoration: underline;
}

td a {
  margin: 0 4px;
}
 
 
 
 .content {
  margin-left: 170px;
  padding: 10px;
  background-color: #e6f0ff;
  display: flex;
  justify-content: center;
}

    .table-container {
      padding: 20px;
      background-color: #F2F2F2;
      max-width: 100%;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
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

	@media (max-width: 768px) {
  .nav {
    width: 100px;
  }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table th, table td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
	  font-size: 11px;
    padding: 6px 4px;
    }

    table th {
      background-color: #0096D6;
      color: white;
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
      <h2>Merit Application</h2>
      <p>Petakom Coordinator: Dr. Haneef</p>
    </div>
		
		
		<div class="header-right">
			<a href="c_edit_profile.html">
				<img src="images/profile.png" alt="Profile" class="logo2">
			</a>
		</div>  
  </div>
 <div class="nav">
	<div class="menu">
		<div class="item"><a  href="c_homepage.html">Dashboard</a></div>
		<div class="item">
			<a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a  href="c_membership.html" class="sub-item">Membership Approval</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="#events" class="sub-item">View Event</a>
				<a class="active" href="c_merit.html" class="sub-item">Merit Application</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="c_attendance.html" class="sub-item">Verify Attendance</a>
			</div>
		</div>

	</div>
  </div>
  
  
<div class="content">
  <div class="table-container">
    <div class="section-header">MERIT APPLICATION</div>
    <table border="1" cellspacing="0" cellpadding="5">
  <thead>
    <tr>
      <th>EVENT NAME</th>
      <th>DATE</th>
      <th>TIME</th>
      <th>GEOLOCATION</th>
      <th>VENUE</th>
      <th>DESCRIPTION</th>
      <th>APPROVAL LETTER</th>
      <th>MERIT SCORE</th>
      <th>STATUS</th>
      <th>ACTIONS</th>
    </tr>
  </thead>
  <tbody>
    <tr><td>AMAL  FUN RUN ZOMBIE</td><td>17 JUNE 2021</td><td>9AM-10AM</td><td>2.555 </td><td>FACULTY  COMPUTING</td><td>LALALALA</td><td><a href='uploads/1747700157_STUDENT-4 (6).png' target='_blank'>View</a></td><td>3</td><td></td><td>
                    <a href='c_meritAppUpdate.php?id=3'>EDIT</a> 
                    
                  </td></tr><tr><td>FLUUTER PRO</td><td>30 JUNE 2025</td><td>8AM - 3PM</td><td>2.99887</td><td>BZ0R99 (FACULTY COMPUTING)</td><td>EXCELLENCE THE FLUTTER SKILL STUDENTS</td><td><a href='uploads/1747749530_STUDENT-4 (3).png' target='_blank'>View</a></td><td>3</td><td></td><td>
                    <a href='c_meritAppUpdate.php?id=8'>EDIT</a> 
                    
                  </td></tr><tr><td>FIGMA PRO TECH</td><td>17 JUNE 2025</td><td>10AM - 3PM</td><td>2.378498</td><td>DEWAN PEKAN</td><td>INCREASE FIGMA PRO SKILLS</td><td><a href='uploads/1747924668_PETAKOM COORDINATOR (2).png' target='_blank'>View</a></td><td>3</td><td>Approved</td><td>
                    <a href='c_meritAppUpdate.php?id=9'>EDIT</a> 
                    
                  </td></tr>  </tbody>
</table>

  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('.sub-button').click(function(){
      $(this).next('.sub-menu').slideToggle();
    });
  });
</script>
