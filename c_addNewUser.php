<!DOCTYPE html>
<html>
<head>
  <title>ADD NEW USER</title>
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
	
	.p1{
	margin: 0px 0px 20px 40px;
	font-size: 24px;
	padding-top: 20px;
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
	
	.cancel-button{
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
	  margin: 4px 1px;
	  cursor: pointer;
	  transition: 0.3s;
	  float: left;
	}
	
	.cancel-button:hover {
	  background-color: #005bb5;
	}
	
	
	.content{ 
	  background-color: #e6f0ff; 
	  margin-left: 160px;
	  height: 100vh;
	}
	
	.logo {
	  height: 40px;
	  margin: 10px;
	}
	
	.logo2{
	  height: 35px;
	  margin: 10px;
	}
	
	.details1{
		margin: 5px 0px 25px 0px;
		padding-left: 10px;
		height: 25px;
		font-family: 'Poppins', sans-serif;
		width: 25%;
		border: 1px solid #DCDCDC;
		border-radius: 4px;
		border-bottom-width: 2px;
		transition: 0.3s;
	}
	
	.details2{
		margin: 5px 0px 25px 0px;
		padding-left: 10px;
		height: 25px;
		font-family: 'Poppins', sans-serif;
		width: 30%;
		border: 1px solid #DCDCDC;
		border-radius: 4px;
		border-bottom-width: 2px;
		transition: 0.3s;
	}
	
	.details3{
		margin: 5px 0px 25px 0px;
		padding-left: 10px;
		height: 25px;
		font-family: 'Poppins', sans-serif;
		width: 15%;
		border: 1px solid #DCDCDC;
		border-radius: 4px;
		border-bottom-width: 2px;
		transition: 0.3s;
	}
	
	.select{
		font-family: 'Poppins', sans-serif;
		margin: 5px 0px 25px 0px;
		padding: 3px 100px;
		color: black;
		background-color: white;
		border: 1px solid #DCDCDC;
		border-radius: 4px;
		border-bottom-width: 2px;
		}
	
	form{
		margin-left: 40px;
	}
	
	#overlay {
	  position: fixed;
	  top: 0;
	  left: 0;
	  width: 100%;
	  height: 100%;
	  backdrop-filter: blur(5px);
	  background: rgba(0, 0, 0, 0.2);
	  z-index: 998;
	  display: none;
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


  </style>
</head>
<body>
  <div class="header1">
	<img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo"/>
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo"/>
		<div class="header-center">
			<h2>Add New User</h2>
			<p>Coordinator: Dr. Haneef</p>
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
		<div class="item"><a href="c_homepage.php">Dashboard</a></div>
		<div class="item">
			<a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="c_membership.php" class="sub-item">Membership Approval</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#" class="sub-button">Users<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="c_manageProfile.php" class="sub-item">Manage Profile</a>
				<a class="active" href="c_addNewUser.php" class="sub-item">Add New User</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="c_homepage.php" class="sub-item">View Event</a>
				<a href="c_merit.php" class="sub-item">Merit Application</a>
			</div>
		</div>
	</div>
  </div>
  
  <div class="content">
  <br>
  <form> 
		<label>Name</label><br>
			<input type="text" class="details1"><br>
			
		<label>Role</label><br>
			<select name = "role" class="select">
				<option selected = "selected">Select role</option>
				<option>Student</option>
				<option>Coordinator</option>
				<option>Event Advisor</option>
			</select><br>
			
		<label>Email Address</label><br>
			<input type="email" class="details2"><br>
			
		<label>Password</label><br>
			<input type="password" class="details3"><br>
			
		<label>Confirm Password</label><br>
			<input type="password" class="details3"><br>
			
		
		<br>
		<button type="button" class="cancel-button">Cancel</button>
		<button type="button" class="save-button" onclick="showSuccessModal()">Save</button>

	</form>
	
	<div id="overlay"></div>

	<!-- Success popup modal -->
	<div id="successModal" class="popUp">
	  <div class="modal-content">
		<h2>Success!</h2>
		<p>The new user has been added successfully.</p>
		<div class="modal-buttons">
		  <a href="c_manageProfile.php"><button>Back to the List</button></a>
		  <a href="c_addNewUser.php"><button>Add New User</button></a>
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
	
	<script>
	function showSuccessModal() {
	  document.getElementById("overlay").style.display = "block";
	  document.getElementById("successModal").style.display = "block";
	}
</script>
</body>
</html>
