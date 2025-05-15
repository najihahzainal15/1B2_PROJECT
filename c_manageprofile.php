<!DOCTYPE html>
<html>
<head>
  <title>COORDINATOR MEMBERSHIP APPLICATION</title>
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
	  color: white;
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

    .action-btn {
      margin: 0 5px;
      padding: 5px 10px;
      font-weight: bold;
      cursor: pointer;
    }
	   
	.tbody {
		background-color: white;
	}
	
	.table-header {
	  margin: 20px 30px;
	  text-align: right;
	}

	.add-btn {
	  background: #0074e4;
	  color: white;
	  padding: 6px 12px;
	  font-size: 14px;
	  border-radius: 6px;
	  text-decoration: none;
	  transition: background 0.3s;
	}

	.add-btn:hover {
	  background: #005bb5;
	}
  </style>
</head>
<body>
  <div class="header1">
	<img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo"/>
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo"/>
		 <div class="header-center">
			<h2>User Profile Management</h2>
			<p>Petakom Coordinator: Dr. Haneef</p>
		  </div>
		<div class="header-right">
			<a href="logout_button.php" class="logout">Logout</a>
			<a href="s_edit_profile.php">
				<img src="images/profile.png" alt="Profile" class="logo2">
			</a>
		</div>   
  </div>
  
  <div class="nav">
	<div class="menu">		
		<div class="item"><a class="active" href="c_homepage.php">Dashboard</a></div>
		
		<div class="item">
			<a href="#" class="sub-button">Users<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a class="active" href="c_manageProfile.php" class="sub-item">Manage Profile</a>
				<a href="c_addNewUser.php" class="sub-item">Add New User</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="c_membership" class="sub-item">Membership Approval</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="#events" class="sub-item">View Event</a>
				<a href="c_merit.php" class="sub-item">Merit Application</a>
			</div>
		</div>
	</div>
  </div>
  
  <div class="content">
  <br>
  
  <div class="table-header">
    <a href="c_addNewUser.php" class="add-btn">Add New User</a>
  </div>

  <table class="member-table">
      <thead>
        <tr>
          <th>NO.</th>
          <th>NAME</th>
          <th>ROLE</th>
          <th>EMAIL ADDRESS</th>
		  <th>ACTIONS</th>
        </tr>
      </thead>
      <tbody class="tbody"> 
        <tr>
          <td td align="center">1.</td>
          <td align="left">NURUL NAJIHA BINTI RAMZI</td>
          <td align="center">STUDENT</td>
          <td align="center">CD22081@adab.umpsa.edu.my</td>
		  <td align="center">
            <button class="action-btn">VIEW</button>
            <button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
          </td>
		</tr>
		
		<tr>
          <td td align="center">2.</td>
          <td align="left">MUHAMMAD FARIDZUAN BIN AHMAD</td>
          <td align="center">STUDENT</td>
          <td align="center">CD22081@adab.umpsa.edu.my</td>
		  <td align="center">
            <button class="action-btn">VIEW</button>
            <button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
          </td>
		</tr>
		
		<tr>
          <td td align="center">3.</td>
          <td align="left">MUHAMMAD AMIR HAZIQ BIN MOHD SYAHRUL</td>
          <td align="center">STUDENT</td>
          <td align="center">CD22081@adab.umpsa.edu.my</td>
		  <td align="center">
            <button class="action-btn">VIEW</button>
            <button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
          </td>
		</tr>
		
		<tr>
          <td td align="center">4.</td>
          <td align="left">SITI MASYITAH BINTI IBRAHIM</td>
          <td align="center">STUDENT</td>
          <td align="center">CD22081@adab.umpsa.edu.my</td>
		  <td align="center">
            <button class="action-btn">VIEW</button>
            <button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
          </td>
		</tr>
		
		<tr>
          <td td align="center">5.</td>
          <td align="left">NUR HUSNINA BINTI MUHANURUL</td>
          <td align="center">COORDINATOR</td>
          <td align="center">CD22081@adab.umpsa.edu.my</td>
		  <td align="center">
            <button class="action-btn">VIEW</button>
            <button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
          </td>
		</tr>
		
		<tr>
          <td td align="center">6.</td>
          <td align="left">MUHAMMAD AMIR FIRDAUS BIN AMRAN</td>
          <td align="center">EVENT ADVISOR</td>
          <td align="center">CD22081@adab.umpsa.edu.my</td>
		  <td align="center">
            <button class="action-btn">VIEW</button>
            <button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
          </td>
		</tr>
		
		<tr>
          <td td align="center">7.</td>
          <td align="left">NUR AISYAH SYAZANA BINTI MOHD FAHIM</td>
          <td align="center">EVENT ADVISOR</td>
          <td align="center">CD22081@adab.umpsa.edu.my</td>
		  <td align="center">
            <button class="action-btn">VIEW</button>
            <button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
          </td>
		</tr>
		
		<tr>
		  <td align="center">8.</td>
		  <td align="left">NUR IZZATI BINTI ALIAS</td>
		  <td align="center">STUDENT</td>
		  <td align="center">CB23001@adab.umpsa.edu.my</td>
		  <td align="center">
			<button class="action-btn">VIEW</button>
			<button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
		  </td>
		</tr>

		<tr>
		  <td align="center">9.</td>
		  <td align="left">MUHAMMAD HAFIZ BIN RAZAK</td>
		  <td align="center">STUDENT</td>
		  <td align="center">CD23045@adab.umpsa.edu.my</td>
		  <td align="center">
			<button class="action-btn">VIEW</button>
			<button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
		  </td>
		</tr>

		<tr>
		  <td align="center">10.</td>
		  <td align="left">LIM WEI JIE</td>
		  <td align="center">STUDENT</td>
		  <td align="center">CA23112@adab.umpsa.edu.my</td>
		  <td align="center">
			<button class="action-btn">VIEW</button>
			<button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
		  </td>
		</tr>

		<tr>
		  <td align="center">11.</td>
		  <td align="left">SITI AISYAH BINTI KAMAL</td>
		  <td align="center">STUDENT</td>
		  <td align="center">CF23078@adab.umpsa.edu.my</td>
		  <td align="center">
			<button class="action-btn">VIEW</button>
			<button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
		  </td>
		</tr>

		<tr>
		  <td align="center">12.</td>
		  <td align="left">AIMAN HAKIM BIN NORAZMI</td>
		  <td align="center">STUDENT</td>
		  <td align="center">CD23156@adab.umpsa.edu.my</td>
		  <td align="center">
			<button class="action-btn">VIEW</button>
			<button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
		  </td>
		</tr>

		<tr>
		  <td align="center">13.</td>
		  <td align="left">NUR SYAHIRAH BINTI SAHARUDIN</td>
		  <td align="center">STUDENT</td>
		  <td align="center">CB23234@adab.umpsa.edu.my</td>
		  <td align="center">
			<button class="action-btn">VIEW</button>
			<button class="action-btn">EDIT</button>
			<button class="action-btn">DELETE</button>
		  </td>
		</tr>
	  
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
