<!DOCTYPE html>
<html>
<head>
  <title>EVENT ADVISOR EVENT COMMITTEE</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
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
    }

    .nav a:hover {
      background-color: #0264c2;
      transition: all 0.4s ease;
    }

    .sub-menu {
      background: #044e95;
      display: none;
    }

    .sub-menu a {
      padding-left: 30px;
      font-size: 12px;
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

    .header-left {
      display: flex;
      align-items: center;
      gap: 10px;
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
    }

    .header-right img.logo2 {
      height: 35px;
      border-radius: 50%;
    }

    .logo {
      height: 40px;
    }

    .content {
      margin-left: 170px;
      padding: 20px;
      background-color: #e6f0ff;
      min-height: 100vh;
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

    button.edit-btn, button.delete-btn {
      padding: 5px 10px;
      margin: 0 5px;
      border: none;
      cursor: pointer;
    }

    button.edit-btn {
      background-color: #4CAF50;
      color: white;
    }

    button.delete-btn {
      background-color: #f44336;
      color: white;
    }

    .data {
      background-color: white;
    }

    .button {
      background-color: #e6e6e6;
      border: 2px solid #999;
      color: black;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin: 4px 2px;
      cursor: pointer;
    }
	
	.button:hover {
	background-color:#C5C7C4;
	}
	
	.edit-btn:hover {
	background-color:#C5C7C4;
	}
	
	.delete-btn:hover {
	background-color:#C5C7C4;
	}

    .back {
      text-align: left;
      margin-top: 30px;
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
   margin: 4px 25px;
   cursor: pointer;
   transition: 0.3s;
   margin-left: auto;
 }
 
 .submit-button:hover {
   background-color: #005bb5;
 }
 
 .h2{ color:black;}
 
  </style>
</head>
<body>
  <div class="header1">
	<img src="images/UMPSALogo.png" alt="UMPSA Logo000nn" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
		<div class="header-center">
			<h2>Dashboard</h2>
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
      
      <div class="item"><a href="ea_homepage.html">Dashboard</a></div>

      <div class="item">
        <a href="#events" class="sub-button">Events <i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="ea_viewEvent.php">View Event</a>
          <a href="ea_registerEvent1.php">Register New Event</a>
          <a class="active" href="ea_eventCommittee.php">Event Committee</a>
		  <a href="ea_committeeReg.php">Register Committee Member</a>
        </div>
      </div>

      <div class="item">
        <a href="#attendance" class="sub-button">Attendance <i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a href="#attendance">Attendance Slot</a>
        </div>
      </div>

      
    </div>
  </div>

  <div class="content">
    <div class="table-container">
      <table>
        <tr>
          <td>
            SELECT EVENT
            <form action="/action_page.php">
              <select name="event_" class="event_">
                <option value="larian_amal">LARIAN AMAL</option>
                <option value="combat">COMBAT</option>
                <option value="hackaton">HACKATON</option>
              </select>
            </form>
          </td>
          <td>
            <button type="button" class="button">REGISTER COMMITTEE MEMBER +</button>
          </td>
        </tr>
      </table>

      <table>
        <thead>
          <tr>
            <th>COMMITTEE MEMBER NAME</th>
            <th>POSITION</th>
            <th>STUDENT ID</th>
            <th>ACTION</th>
          </tr>
        </thead>
        <tbody>
          <tr class="data">
            <td>HIDAYAH</td>
            <td>CHAIRMAN</td>
            <td>CB23020</td>
            <td><button class="edit-btn">EDIT</button><button class="delete-btn">DELETE</button></td>
          </tr>
          <tr class="data">
            <td>NAJIHAH</td>
            <td>EDITOR</td>
            <td>CB23027</td>
            <td><button class="edit-btn">EDIT</button><button class="delete-btn">DELETE</button></td>
          </tr>
          <tr class="data">
            <td>WAHIDAH</td>
            <td>FINANCE</td>
            <td>CB23024</td>
            <td><button class="edit-btn">EDIT</button><button class="delete-btn">DELETE</button></td>
          </tr>
          <tr class="data">
            <td>QISTINA</td>
            <td>DATA ANALYST</td>
            <td>CB23099</td>
            <td><button class="edit-btn">EDIT</button><button class="delete-btn">DELETE</button></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="back">
      <button class="submit-button" onclick="history.back()">Back</button>
    </div>
  </div>

  <script>
    $(document).ready(function(){
      $('.sub-button').click(function(){
        $(this).next('.sub-menu').slideToggle();
      });
    });
  </script>
</body>
</html>
