<!DOCTYPE html>
<html>
<head>
  <title>STUDENT ATTENDANCE VERIFICATION 3</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MyPetakom Coordinator Homepage</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <style>
	body{
		  margin: 0;
		  font-family: 'Poppins', sans-serif;
		  overflow: hidden;
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

	.logo-left {
	  max-height: 40px;
	  max-width: 60px;
	  object-fit: contain;
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
		
	.sub-menu{
		background: #044e95;
		display: none;
	}
	
	.sub-menu a{
		padding-left: 30px;
		font-size: 12px;
	}
    .sub-menu a.active {
      background-color: #0264c2; /* darker shade for nested active */
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

	.logo{
	  height: 40px;
	
	}
	
	.logo2{
	  height: 35px;
	  border-radius: 50%;
	}
	
	
    .register-btn, .back-btn {
      background: #e6e6e6;
      padding: 10px 20px;
      border: 2px solid #999;
      font-weight: bold;
      cursor: pointer;
      margin-bottom: 20px;
    }

    .back-btn {
      margin-top: 30px;
      background: #fff;
      border: 2px solid #000;
    }

    .event-table {
      width: 100%;
      border-collapse: collapse;
      background: #d0e6ff;
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
    }
 
    .submit-button:hover {
    background-color: #005bb5;
    }
    .scan-button{
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
 
    .scan-button:hover {
    background-color: #005bb5;
    }
    .desc{
        padding: 20px; 
        font-weight: bold;
    }
    .event_name{
        text-align: center; 
        padding: 20px;
        background-color: white; 
        border: 2px solid #aaa; 
        border-radius: 8px;
        font-weight: bold;
        left: 180px;
		margin: 10px 200px 0px;
    }
    .qr{
        text-align: center; 
        background-color: #d0e6ff; 
        display: inline-block; 
        padding: 5px 20px; 
        border-radius: 6px;
    }
 

 /* td .QRButton{
    border-style: none;
    background-color: #6666f0ff; 

 } */
	
	
  </style>
</head>

<body>

  <div class="header1">
  <div class="header-left">
  <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo logo-left">
  <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo logo-left">
</div>

  
  <div class="header-center">
    <h2>Attendance</h2>
    <p>Student : Alif</p>
  </div>

  <div class="header-right">
			<a href="logout_button.php" class="logout">Logout</a>
			<a href="s_edit_profile.php">
				<img src="images/profile.png" alt="Profile" class="logo2">
			</a>
 </div>  
		

  
 <div class="nav">
	<div class="menu">
		<div class="item"><a href="s_homepage.html">Dashboard</a></div>
		<div class="item">
			<a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="s_membership.html" class="sub-item">Membership Application</a>
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
				<a class="active" href="s_attendanceSlot.html" class="sub-item">Attendance Slot</a>
			</div>
		</div>
		
	</div>
  </div>
  
  
  <div class="content">
  <br>

     <div class="event_name">
        <h2>HACKATON FUN RUN</h2>
        <div class="desc">
            <p>DATE: 25 APRIL 2025</p>
            <p>TIME: 9AM - 12PM</p>
        </div>
        
    <div class="qr">
        <h3 >ATTENDANCE QR CODE</h3>
        <img src="images/hackatonAttendanceQR.jpg" alt="QR Code" style="width: 150px; height: 150px; margin-top: 10px;" />
    </div>
    <div>
        <button class="scan-button">SCAN QR</button>
    </div>
    <br><br>

    <button class="submit-button">Back</button>

	</div>
  </div>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.sub-button').click(function(){
			$(this).next('.sub-menu').slideToggle();
		});

         // Automatically open sub-menu if it contains an active item
        $('.sub-menu').each(function(){
            if($(this).find('.active').length > 0){
            $(this).show();
            $(this).prev('.sub-button').addClass('active-parent');
            }
        });
	});
  // Show popup when scan button clicked
document.querySelector('.scan-button').addEventListener('click', function() {
    document.getElementById('qrPopup').style.display = 'block';
});

// Close popup function
function closePopup() {
    document.getElementById('qrPopup').style.display = 'none';
}

// Handle form submission
document.getElementById('verifyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const studentID = document.getElementById('studentID').value;
    const password = document.getElementById('password').value;

    // TODO: Send these to server via AJAX or form post
    console.log("Submitted:", studentID, password);

    // Example only: close the popup
    closePopup();

    alert("Attendance submitted for " + studentID);
});
	</script>

  <!-- Popup Modal -->
<div id="qrPopup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000;">
  <div style="background: white; width: 300px; margin: 100px auto; padding: 20px; border-radius: 10px; text-align: center;">
    <h3>Verify Attendance</h3>
    <form id="verifyForm">
      <input type="text" id="studentID" placeholder="Student ID" required style="width: 90%; margin-bottom: 10px;"><br>
      <input type="password" id="password" placeholder="Password" required style="width: 90%; margin-bottom: 20px;"><br>
      <button type="button" onclick="closePopup()" class="submit-button" style="background-color: #ccc;">Cancel</button>
      <button type="submit" class="submit-button">Submit</button>
    </form>
  </div>
</div>

</body>
</html>