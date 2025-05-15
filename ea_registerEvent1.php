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
		margin-left: 50px;
		margin-right: 40px;
		width: calc(100% - 40px); /* Adjust for small screens */
		padding: 10px; /* Less padding on small screens */
	  }

	  .identity-row input,
	  .event-details input {
		font-size: 14px; /* Smaller text for smaller screens */
	  }
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
      border-top: 1px solid #d9d9d9;
      border-bottom: 1px solid #d9d9d9;
    }

    /* Form Grid */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 10px;
      padding: 20px;
	  margin-left: 30px;
    }

    .form-grid label {
      background: #f0f0f0; 
      font-weight: bold;
      padding: 10px;
      text-align: center;
	  border: 1px solid #d9d9d9;
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
	   margin: 20px 15px;
	   cursor: pointer;
	   transition: 0.3s;
	   margin-right: auto;
	 }
 
	 .submit-button:hover {
	   background-color: #005bb5;
	 }
	
	.reset-button{
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
	   margin: 20px 25px;
	   cursor: pointer;
	   transition: 0.3s;
	   margin-left: auto;
	   pointer-events: auto; 
	 }
 
	 .reset-button:hover {
	   background-color: #005bb5;
	 }

	  .merit{
	  margin-left:25px;
	  margin-right:450px;
	  
	  }
		
	.popUp {
	   display: none;
	   position: fixed;
	   z-index: 999;
	   left: 50%;
	   top: 50%;
	   transform: translate(-50%, -50%);
	   background: white;
	   padding: 30px;
	   border-radius: 10px;
	   box-shadow: 0 5px 15px rgba(0,0,0,0.3);
	   text-align: center;
	   width: 300px;
	 }

	 .modal h2 {
	   margin-top: 0;
	   color: green;
	 }

	 .modal-buttons {
	   margin-top: 20px;
	 }

	 .modal-buttons button {
	   margin: 5px;
	   padding: 8px 15px;
	   font-family: 'Poppins', sans-serif;
	   background-color: #0074e4;
	   border: none;
	   border-radius: 5px;
	   color: white;
	   cursor: pointer;
	 }

	 .modal-buttons button:hover {
	   background-color: #005bb5;
	 }

	input:focus, textarea:focus {
	  outline: none;
	  border-color: #0074e4;
	  box-shadow: 0 0 3px #0074e4;
	}
	
	.content{ 
	  background-color: #e6f0ff; 
	  margin-left: 140px;
	  height: auto;
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
          <a href="ea_viewEvent.php">View Event</a>
          <a class="active" href="ea_registerEvent.html">Register New Event</a>
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
  <div class="table-container">
    <h2 class="section-title">REGISTER NEW EVENT</h2>

    <form action="ea_processRegisterEvent.php" method="POST" enctype="multipart/form-data">
      <div class="form-grid">
        <label for="name">EVENT NAME</label>
        <input type="text" id="name" name="name" placeholder="CYBERSECURITY FUN RUN 2025" required>

        <label for="date">DATE</label>
        <input type="text" id="date" name="date" placeholder="15 MAY 2025" required>

        <label for="time">TIME</label>
        <input type="text" id="time" name="time" placeholder="9AM – 12PM" required>

        <label for="geolocation">GEOLOCATION</label>
        <input type="text" id="geolocation" name="geolocation" placeholder="2.9285,101.7715 (Faculty of Computing)" required>

        <label for="venue">VENUE</label>
        <input type="text" id="venue" name="venue" placeholder="Astaka Hall" required>

        <label for="description">DESCRIPTION</label>
        <textarea id="description" name="description" placeholder="Brief description about the event..." required></textarea>

        <label for="approvalLetter">UPLOAD APPROVAL LETTER</label>
        <input type="file" id="approvalLetter" name="approvalLetter" accept=".pdf,.jpg,.png,.jpeg" required>
      </div>

      <div class="actions">
        <button type="submit" class="submit-button">Submit</button>
        <button type="reset" class="reset-button">Reset</button>
      </div>
    </form>
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
