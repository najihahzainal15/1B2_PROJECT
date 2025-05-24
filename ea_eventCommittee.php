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
      background-color: #0074e4;
    border: none;
    color: white;
    padding: 12px 20px;
    text-align: left; /* Aligns text to the left */
    text-decoration: none;
    display: block; /* Ensures it takes up full width */
    font-size: 16px;
    margin: 10px 0; /* Reduce vertical spacing */
    cursor: pointer;
    border-radius: 5px;
    width: fit-content; /* Adjust width dynamically */

    }
	
	.button:hover {
	background-color: #005bb5;

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
 
 .tbody{
	  background-color: white;
 }
 
 .button-container {
    text-align: left;
    margin-left: 1px; /* Push it slightly from the left */
}
 
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
       
          
          
      <div class="button-container">
   <a href="ea_registerEvent1.php" class="button">REGISTER NEW COMMITTEE MEMBER</a>

      </div>

          
        
      </table>

      <table>
	  
	  <?php
// Connect to the database server.
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());

// Select the database.
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

$query = "SELECT * FROM committee";

$result = mysqli_query($link, $query);

?>

<table>
  <thead>
    <tr>
      <th>COMMITTEE ID</th>
      <th>EVENT ID</th>
      <th>ROLE</th>
      <th>STUDENT ID</th>
      <th>EDIT/DELETE</th>
    </tr>
  </thead>
  <tbody class="tbody">
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $commID = htmlspecialchars($row["committeeID"]);
            $eventID = htmlspecialchars($row["eventID"]);
            $role = htmlspecialchars($row["committeeRole"]);
            $studentID = htmlspecialchars($row["studentID"]);
            echo "<tr>";
            echo "<td>$commID</td>";
            echo "<td>$eventID</td>";
            echo "<td>$role</td>";
            echo "<td>$studentID</td>";
           echo "<td>
        <a href='ea_eventCommitteeUpdate.php?id=$commID'>EDIT</a> || 
        <a href='ea_eventCommitteeDelete.php?id=$commID' onclick=\"return confirm('Are you sure to delete this record?');\">DELETE</a>
      </td>";

        }
    } else {
        echo "<tr><td colspan='5'>No committee records found.</td></tr>";
    }

    mysqli_close($link);
    ?>
  </tbody>
</table>


  <script>
    $(document).ready(function(){
      $('.sub-button').click(function(){
        $(this).next('.sub-menu').slideToggle();
      });
    });
  </script>
</body>
</html>
