<!DOCTYPE html>
<html>
<head>
  <title>STUDENT ATTENDANCE VERIFICATION 1</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
	  height: auto;
	}

	.logo{
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

    .back-btn {
      margin-top: 30px;
      background: #fff;
      border: 2px solid #000;
    }

    .event-table {
      width: 95%;
      border-collapse: collapse;
      background: #d0e6ff;
	  margin-left: 30px;
	  margin-right: 30px;
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

	

 /* td .QRButton{
    border-style: none;
    background-color: #6666f0ff; 

 } */
	
  </style>
</head>

<body>

   <div class="header1">
	<img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo"/>
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo"/>
		<div class="header-center">
			<h2>Attendance Slot</h2>
			<p>Student: Alif</p>
		</div>
		<div class="header-right">
			<a href="logout_button.php" class="logout">Logout</a>
			<a href="c_edit_profile.php">
				<img src="images/profile.png" alt="Profile" class="logo2">
			</a>
		</div>   
  </div>

  
 <div class="nav">
	<div class="menu">
		<div class="item"><a href="s_homepage.html">Dashboard</a></div>
		<div class="item">
			<a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="c_membership.php" class="sub-item">Membership Approval</a>
			</div>
		</div>
		<div class="item">
			<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="#events" class="sub-item">View Event</a>
				<a href="#events" class="sub-item">Register New Event</a>
				<a href="#events" class="sub-item">Register Committee Event</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a class="active" href="s_attendance1.php" class="sub-item">Attendance Slot</a>
			</div>
		</div>
		
	</div>
  </div>
  
  
  <div class="content">
  <br>

    <table class="event-table">
      <thead>
        <tr>
          <th>EVENT NAME</th>
          <th>DATE</th>
          <th>STATUS</th>
          <th>ATTENDANCE VERIFICATION</th>

        </tr>
      </thead>
      <tbody class="tbody"> 
        <tr>
          <td>HACKATON FUN RUN</td>
          <td>26/4/25</td>
          <td class="status active">ACTIVE</td>
          <td class="QRButton">
              <button class="action-btn">VERIFY ATTENDANCE</button>
          </td>
        </tr>
        <tr>
          <td>CYBERSECURITY AWARENESS</td>
          <td>20/5/25</td>
          <td class="status cancelled">CANCELLED</td>
          <td class="attendance">
          <button class="action-btn">VERIFY ATTENDANCE</button>
          </td><!-- buat button tak boleh tekan -->
        </tr>
        <tr>
          <td>GRAPHICxNETWORKING</td>
          <td>25/5/25</td>
          <td class="status postpone">POSTPONED</td>
          <td class="QRButton">
              <button class="action-btn">VERIFY ATTENDANCE</button>
          </td>        
        </tr>
        <tr>
          <td>FLUTTER PRO</td>
          <td>27/6/25</td>
          <td class="status active">ACTIVE</td>
          <td class="QRButton">
              <button class="action-btn">VERIFY ATTENDANCE</button>
          </td>
        </tr>
      </tbody>
    </table>
    <br>
    <br>

    <button class="submit-button">Back</button>
  </main>
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
	</script>
</body>
</html>