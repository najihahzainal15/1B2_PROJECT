<?php
// Connect to DB
$link = mysqli_connect("localhost", "root", "", "web_project");
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to get counts per status
$query = "SELECT status, COUNT(*) as count FROM event GROUP BY status";
$result = mysqli_query($link, $query);

// Initialize counts
$statusCounts = [
    'active' => 0,
    'postpone' => 0,
    'canceled' => 0,
];

// Fill counts from query result
while ($row = mysqli_fetch_assoc($result)) {
    $status = strtolower($row['status']);
    if (isset($statusCounts[$status])) {
        $statusCounts[$status] = (int)$row['count'];
    }
}

$totalEvents = array_sum($statusCounts);
$activeEvents = $statusCounts['active'];
$postponedEvents = $statusCounts['postpone'];
$cancelledEvents = $statusCounts['canceled'];

?>

<!DOCTYPE html>



<html>
<head>
  <title>EVENT ADVISOR DASHBOARD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
	font-size: 20px;
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
	
	.content{ 
	  background-color: #e6f0ff; 
	  margin-left: 160px;
	  height: auto;
	}
	
	
	.logo {
	  height: 40px;
	  margin: 10px;
	}
	
	.logo2{
	  height: 35px;
	  margin: 10px;
	}
	
	.events-container{
		height: auto;
		display: flex;
		flex-direction: row;
		flex-wrap: wrap;
		gap: 30px;
		margin-left: 30px;
	}
	
	.event{
		width: 300px;
		height: 330px;
		background: white;
		margin: 20px;
		box-sizing: border-box;
		font-size: 14px;
		box-shadow: 0px 0px 10px 2px grey;
		transition: 1s;
	}
	
	.event:hover{
		transform: scale(1.05);
		z-index: 2;
    }
	
	.eventImage{
	  height: 260px;
	  width: 300px;
	  justify-content: center;
	  align-items: center;
	}
	
	.overview-cards {
	  display: flex;
	  gap: 20px;
	  padding: 20px 30px;
	  flex-wrap: wrap;
	  margin-left: 19px;
	}

	.overview-cards .card {
	  background: white;
	  flex: 1 1 200px;
	  padding: 20px;
	  border-radius: 12px;
	  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
	  font-size: 16px;
	  font-weight: 600;
	  text-align: center;
	}

	/* -------- analytics/layout -------- */
	.analytics {
	  display: grid;
	  grid-template-columns: 2fr 1fr;
	  gap: 30px;
	  padding: 0 30px 30px;
	}

	/* Pie chart card */
	.event-status {
	  background: white;
	  padding: 20px;
	  border-radius: 12px;
	  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
	  margin-left: 19px;
	}

	.event-status h3 {
	  margin-top: 0;
	  font-size: 18px;
	}
	.event-status .chart {
	  display: block;
	  max-width: 100%;
	  height: 350px;
	  margin: 20px auto 0;
	}

	/* Recent activities card */
	.recent-activities {
	  background: white;
	  padding: 20px;
	  border-radius: 12px;
	  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
	}
	.recent-activities h3 {
	  margin-top: 0;
	  font-size: 18px;
	}
	.recent-activities ul {
	  list-style: none;
	  padding: 0;
	  margin: 15px 0 0;
	}
	.recent-activities li {
	  padding: 8px 0;
	  border-bottom: 1px solid #eee;
	  font-size: 14px;
	}
	.recent-activities li:last-child {
	  border-bottom: none;
	}
	
	.dashboard-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 30px 15px; /* horizontal gap between cells */
    margin-top: 20px;
  }
  .dashboard-table td {
    padding: 15px 40px;
    background-color: white;
    font-weight: bold;
    text-align: center;
    border-radius: 8px;
  }
  
  #chart-container {
  width: 350px;
  margin-left: 20px;
  
}

#eventStatusChart {
  width: 100% !important;
  height: auto !important;
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
		<div class="item"><a class="active" href="ea_homepage.php">Dashboard</a></div>
		
		<div class="item">
			<a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a href="ea_viewEvent.php" class="sub-item">View Event</a>
				<a href="ea_registerEvent1.php" class="sub-item">Register New Event</a>
				<a href="ea_eventCommittee.php">Event Committee</a>
				<a href="ea_committeeReg.php" class="sub-item">Register Committee Event</a>
			</div>
		</div>
		
		<div class="item">
			<a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
			<div class="sub-menu">
				<a  href="ea_attendanceSlot.php" class="sub-item">Attendance Slot</a>
			</div>
		</div>
	</div>
  </div>
  
  <div class="content">
	<br>
	<h2>Hi Prof. Hakeem</h2>
	<p>Welcome to MyPetakom's home.</p>
	<br>
	<h2>Upcoming Events</h2>
	<div class="events-container">
			<div class="event">
					<img src="images/larian_amal.jpg" class="eventImage">
						<div class="event-content">
							<p align="center" class="p1">Larian Amal UMPSA 2025</h3><br>
							<p align="center" class="p1">31 May 2025</p>
						</div>
			</div>
			
			<div class="event">
					<img src="images/hackaton.jpg" class="eventImage">
						<div class="event-content">
							<p align="center" class="p1">Hackaton X: Smart City 2025</h3><br>
							<p align="center" class="p1">28 May 2025</p>
						</div>
			</div>
			
			<div class="event">
					<img src="images/combat.jpg" class="eventImage">
						<div class="event-content">
							<p align="center" class="p1">COMBAT 2025</h3><br>
							<p align="center" class="p1">9 May-23 May 2025</p>
						</div>
			</div>
	</div>
	
	<div class="dashboard-content">
  <table class="dashboard-table">
    <tr>
      <td>Total Events Created: <?php echo $totalEvents; ?></td>
      <td>Active Events: <?php echo $activeEvents; ?></td>
      <td>Cancelled Events: <?php echo $cancelledEvents; ?></td>
      <td>Postponed Events: <?php echo $postponedEvents; ?></td>
    </tr>
  </table>
</div>

  <div id="chart-container">
    <h2>Event Status Distribution</h2>
    <canvas id="eventStatusChart" width="200" height="150"></canvas>

  </div>
  
  <div id="chart-container">
  <h2>Event Status Distribution (Pie Chart)</h2>
  <canvas id="eventStatusChart"></canvas>

  <h2 style="margin-top:40px;">Event Status Distribution (Bar Chart)</h2>
  <canvas id="eventStatusBarChart"></canvas>
</div>


<script>
  // First Pie Chart
  const ctx1 = document.getElementById('eventStatusChart').getContext('2d');
  new Chart(ctx1, {
    type: 'pie',
    data: {
      labels: ['Active', 'Postpone', 'Canceled'],
      datasets: [{
        data: [<?= $statusCounts['active'] ?>, <?= $statusCounts['postpone'] ?>, <?= $statusCounts['canceled'] ?>],
        backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'],
        borderColor: ['#36A2EB', '#FFCE56', '#FF6384'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  });
</script>

<script>
  // Second Chart (e.g., Bar)
  const ctx2 = document.getElementById('eventStatusBarChart').getContext('2d');
  new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['Active', 'Postpone', 'Canceled'],
      datasets: [{
        label: 'Event Count',
        data: [<?= $statusCounts['active'] ?>, <?= $statusCounts['postpone'] ?>, <?= $statusCounts['canceled'] ?>],
        backgroundColor: ['#36A2EB', '#FFCE56', '#FF6384'],
        borderColor: ['#36A2EB', '#FFCE56', '#FF6384'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        }
      }
    }
  });
</script>
</body>
</html>
