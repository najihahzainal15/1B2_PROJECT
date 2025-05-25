
<?php

include 'db_connection.php';

$sql = "SELECT 
    committee.committeeRole, 
    event.eventName, 
    event.eventDate, 
    event.eventLocation, 
    event.status
FROM event
JOIN committee ON event.eventID = committee.eventID
JOIN student ON student.studentID = committee.studentID";

       

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>4</title>
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
	  overflow: hidden;
	  background-color: #0074e4;
	  padding: 0px 10px;
	  margin-left: 160px;
	}
	
	.header-right {
	  float: right;
	   display: flex;
      align-items: center;
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
	color:white;
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
	
	.content {
	  margin-left: 150px;
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



	.logo{
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

    .actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      padding: 0 20px 30px;
    }





	table {
		width: 100%;
		border-collapse: collapse;
	}

	table th, table td {
		padding: 10px;
		border: 1px solid #ddd;
		text-align: center;
	}

	table th {
		background-color: #0096D6;
		color: white;
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

    .identity-row {
      display: flex;
      justify-content: center;
      gap: 10px;
      padding: 20px;
    }

    .identity-row input {
      text-align: center;
      font-weight: bold;
      font-size: 14px;
      padding: 10px;
      border: 2px solid black;
      background: white;
      border-radius: 5px;
    }

    .event-details {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 10px;
      background: #b3d9ff;
      padding: 20px;
    }

    .event-details label {
      background: #d3d3d3;
      font-weight: bold;
      padding: 10px;
      text-align: center;
      border: 2px solid black;
    }

    .event-details input {
      padding: 10px;
      font-weight: bold;
      background: white;
      border: 2px solid black;
    }

    
      .btn-group {
  display: flex;
  justify-content: space-between; /* Ensures buttons are at opposite ends */
  padding: 0 20px 30px;
}

    

    .btn {
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      background: white;
      border: 2px solid black;
      border-radius: 8px;
      cursor: pointer;
    }

    .btn:hover {
      background: #f0f0f0;
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
	
.back-button{
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
  
 }
 
 .back-button:hover {
   background-color: #005bb5;
 }
 
 .download-button{
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
   
 }
 
 .download-button:hover {
   background-color: #005bb5;
 }
	
.tbody{
background-color:white;}
	
	
		
  </style>
</head>

<body>
  <div class="header1">
	<img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
		
		<div class="header-center">
    <h2>View Event</h2>
    <p>Student : Siti Nur Hidayah</p>
  </div>
		<div class="header-right">
			<a href="logout_button.php" class="logout">Logout</a>
			<a href="s_displayProfile.php">
				<img src="images/profile.png" alt="Profile" class="logo2">
			</a>
		</div> 
  </div>
  
 <div class="nav">
	<div class="menu">
		
		<div class="item"><a class="active" href="#membership">Dashboard</a></div>
		<div class="item">
			<a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="s_membershipApp.html" class="sub-item">Membership Application</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="#events" class="sub-item">View Event</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="#events" class="sub-item">Verify Attendance</a>
			</div>
		</div>
	</div>
  </div>
  
  <div class="content">
    <div class="table-container">
        <div class="section-header">EVENT DETAILS</div>


      
<table>
  <thead>
    <tr>
      <th>Committee Role</th>
      <th>Event Name</th>
      <th>Event Date</th>
      <th>Event Location</th>
      <th>Event Status</th>
    </tr>
  </thead>
  <tbody class='tbody'>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['committeeRole']); ?></td>
                <td><?php echo htmlspecialchars($row['eventName']); ?></td>
                <td><?php echo htmlspecialchars($row['eventDate']); ?></td>
                <td><?php echo htmlspecialchars($row['eventLocation']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="5">No records found.</td></tr>
    <?php endif; ?>
  </tbody>
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
</body>
</html>                                    
