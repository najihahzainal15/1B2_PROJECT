<?php
	// Initialize the session
	session_start();
	require_once "config.php"; // your DB config
	 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: login_page.php");
		exit;
	}

	// Get role
	$role = $_SESSION["role"];
?>

<!DOCTYPE html>
<html>
<head>
  <title>COORDINATOR MEMBERSHIP APPROVAL</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <style>
	
	body{
		  margin: 0;
		  font-family: 'Poppins', sans-serif;
		  overflow: auto;
		  background-color: #e6f0ff;
		  background-attachment: fixed;
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

	.save-button{
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
	  margin: 4px 25px;
	  cursor: pointer;
	  transition: 0.3s;
	  float: right;
	}
	
	.save-button:hover {
	  background-color: #005bb5;
	}
	
	
	.content{ 
	   
	  margin-left: 160px;
	  min-height: 100vh;
	  background-color: transparent;
	}

	.logo {
	  height: 40px;
	  margin: 10px;
	}
	
	.logo2{
	  height: 35px;
	  margin: 10px;
	}
	
	.register-btn, .back-btn {
      background: #e6e6e6;
      padding: 10px 20px;
      border: 2px solid #999;
      font-weight: bold;
      cursor: pointer;
      margin-bottom: 20px;
    }

    .back-button{
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
	
	.back-button:hover {
	  background-color: #005bb5;
	}

    .member-table {
	  margin-left: 30px;
      width: 95%;
      border-collapse: collapse;
      background: #d0e6ff;
    }

    .member-table th, .member-table td {
      border: 2px solid #666;
      padding: 10px;
    }

    .status-approve {
      background-color: #c6f6c6;
      font-weight: bold;
    }

    .status-reject {
      background-color: #f6c6c6;
      font-weight: bold;
    }

    .status-pending {
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
	
	.header-right a{
		cursor: pointer;
	}

  </style>
</head>
<body>
  <div class="header1">
	<img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo"/>
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo"/>
		 <div class="header-center">
			<h2>Membership Approval</h2>
			<p>Petakom Coordinator: Dr. Haneef</p>
		  </div>
		 
		<div class="header-right">
			<a href="logout_button.php" class="logout">Logout</a>
			<a href="c_displayProfile.php">
				<img src="images/profile.png" alt="Profile" class="logo2">
			</a>
		</div>  
  </div>
  
  <div class="nav">
	<div class="menu">
		<div class="item"><a  href="c_homepage.php">Dashboard</a></div>
		<div class="item">
			<a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a class="active" href="c_membership.php" class="sub-item">Membership Approval</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="#events" class="sub-item">View Event</a>
				<a href="c_meritApp.php" class="sub-item">Merit Application</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="c_attendance.php" class="sub-item">Verify Attendance</a>
			</div>
		</div>

	</div>
  </div>
  
  <div class="content">
  <br>
  <table class="member-table">
      <thead>
        <tr>
          <th>NO.</th>
          <th>NAME</th>
          <th>STUDENT ID</th>
          <th>STUDENT CARD</th>
		  <th>STATUS</th>
		  <th>ACTIONS</th>
        </tr>
      </thead>
      <tbody class="tbody">
	  <?php
		$sql = "SELECT m.membership_ID, m.studentID, s.username, m.verification_status, m.student_card
				FROM membership m
				JOIN student s ON m.studentID = s.studentID";

		$result = $conn->query($sql);
		$no = 1;

	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			echo "<tr>";
			echo "<td>" . $no++ . "</td>";
			echo "<td>" . htmlspecialchars($row['username']) . "</td>";
			echo "<td>" . htmlspecialchars($row['studentID']) . "</td>";

        // Student Card column
        if($row['student_card_upload']){
            echo "<td><a href='" . $row['student_card_upload'] . "' target='_blank'>View</a></td>";
        } else {
            echo "<td>No file</td>";
        }

        // Status with class
        $status = $row['verification_status'];
        $status_class = strtolower($status) == 'approved' ? 'status-approve' : (strtolower($status) == 'rejected' ? 'status-reject' : 'status-pending');
        echo "<td class='$status_class'>" . $status . "</td>";

        // Actions (approve/reject buttons)
        echo "<td>
                <form action='approve_reject.php' method='POST' style='display:inline'>
                    <input type='hidden' name='membership_ID' value='" . $row['membership_ID'] . "'>
                    <button class='action-btn' name='action' value='approve'>Approve</button>
                    <button class='action-btn' name='action' value='reject'>Reject</button>
                </form>
              </td>";

        echo "</tr>";
		}
	}
	?>
	</tbody>
    </table>

    <button class="back-button">Back</button>
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
