<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login_page.php");
    exit;
}

// Database connection
$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());
$userID = $_SESSION["userID"];
$role = $_SESSION["role"];

// Fetch username from database
$queryUser = "SELECT username FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

// Assign username after database query
$loggedInUser = !empty($userData["username"]) ? ucwords(strtolower($userData["username"])) : "User";

// Function to get attendance data by active events
function getAttendanceByActiveEvents($link) {
    $data = [];

    $sql = "SELECT e.eventID, e.eventName, COUNT(a.attendanceID) as attendance_count 
            FROM attendance a
            JOIN attendanceslot s ON a.slot_ID = s.slot_ID
            JOIN event e ON s.eventID = e.eventID
            WHERE e.status = 'ACTIVE'
            GROUP BY e.eventID, e.eventName
            ORDER BY attendance_count DESC";
    
    $result = mysqli_query($link, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'event' => $row['eventName'],
                'count' => $row['attendance_count']
            ];
        }
    }
    
    return $data;
}

// Function to get attendance data by course
function getAttendanceByCourse($link) {
    $data = [];
    
    // Query to get attendance count by course prefix
    $sql = "SELECT 
                CASE 
                    WHEN LEFT(a.StudentID, 2) = 'CA' THEN 'BCN'
                    WHEN LEFT(a.StudentID, 2) = 'CB' THEN 'BCS'
                    WHEN LEFT(a.StudentID, 2) = 'RC' THEN 'DRC'
                    WHEN LEFT(a.StudentID, 2) = 'CF' THEN 'BCY'
                    WHEN LEFT(a.StudentID, 2) = 'CD' THEN 'BCG'
                    ELSE 'Other'
                END AS course,
                COUNT(*) AS count
            FROM attendance a
            JOIN attendanceslot s ON a.slot_ID = s.slot_ID
            JOIN event e ON s.eventID = e.eventID
            WHERE e.status = 'ACTIVE'
            GROUP BY course
            ORDER BY count DESC";
    
    $result = mysqli_query($link, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'course' => $row['course'],
                'count' => $row['count']
            ];
        }
    }
    
    return $data;
}

$attendanceData = getAttendanceByActiveEvents($link);
$chartLabels = [];
$chartValues = [];

foreach ($attendanceData as $item) {
    $chartLabels[] = $item['event'];
    $chartValues[] = $item['count'];
}

$attendanceByCourse = getAttendanceByCourse($link);
$courseLabels = [];
$courseValues = [];

foreach ($attendanceByCourse as $item) {
    $courseLabels[] = $item['course'];
    $courseValues[] = $item['count'];
}

// Generate colors for pie chart
$pieColors = [
    'rgba(255, 99, 132, 0.8)',
    'rgba(54, 162, 235, 0.8)', 
    'rgba(255, 205, 86, 0.8)',
    'rgba(75, 192, 192, 0.8)',
    'rgba(153, 102, 255, 0.8)',
    'rgba(255, 159, 64, 0.8)',
    'rgba(199, 199, 199, 0.8)',
    'rgba(83, 102, 255, 0.8)'
];

$pieBorderColors = [
    'rgba(255, 99, 132, 1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 205, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)',
    'rgba(199, 199, 199, 1)',
    'rgba(83, 102, 255, 1)'
];
?>

<!DOCTYPE html>
<html>

<head>
    <title>COORDINATOR DASHBOARD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <style>
        body {
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
            margin-right: 15px;
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

        h2 {
            margin: 0px 40px;
            font-size: 25px;
        }

        p {
            margin: 0px 40px;
            font-size: 16px;
        }

        .p1 {
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

        .sub-menu {
            background: #044e95;
            display: none;
        }

        .sub-menu a {
            padding-left: 30px;
            font-size: 12px;
        }

        .button {
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
            background-color: #e6f0ff;
            margin-left: 160px;
            height: auto;
        }

        .logo {
            height: 40px;
            margin: 10px;
        }

        .logo2 {
            height: 35px;
            margin: 10px;
        }

        .events-container {
            height: auto;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 30px;
            margin-left: 30px;
        }

        .event {
            width: 300px;
            height: 330px;
            background: white;
            margin: 20px;
            box-sizing: border-box;
            font-size: 14px;
            box-shadow: 0px 0px 10px 2px grey;
            transition: 1s;
        }

        .event:hover {
            transform: scale(1.05);
            z-index: 2;
        }

        .eventImage {
            height: 260px;
            width: 300px;
            justify-content: center;
            align-items: center;
        }

        .dashboard-content h3 {
            margin-top: 0;
            font-size: 20px;
            color: #333;
        }

        .stats-grid {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            flex: 1 1 200px;
            padding: 10px;
            border-radius: 8px;
            margin-left: 50px;
            margin-right: 50px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-card h3 {
            margin: 0 0 10px;
            font-size: 18px;
            font-weight: 600;
        }

        .stat-card p {
            margin: 0;
            font-size: 24px;
            color: #0074e4;
            font-weight: bold;
        }

        .charts-container {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .bar-chart,
        .pie-chart {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-left: 50px;
            margin-right: 25px;
            flex: 1;
            min-width: 400px;
        }

        .bar-chart h3,
        .pie-chart h3 {
            margin: 0 0 15px;
            font-size: 18px;
            color: #333;
            text-align: center;
        }

        .chart-container {
            width: 100%;
            height: 400px;
            margin: 0 auto;
            position: relative;
        }

        .pie-chart-container {
            width: 100%;
            height: 400px;
            margin: 0 auto;
            position: relative;
        }

        #attendanceChart,
        #attendanceByCourseChart {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
</head>

<body>
    <div class="header1">
        <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo">
        <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
        <div class="header-center">
            <h2>Dashboard</h2>
            <p>Petakom Coordinator: <?php echo htmlspecialchars($loggedInUser); ?></p>
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
            <div class="item"><a class="active" href="c_homepage.php">Dashboard</a></div>

            <div class="item">
                <a href="#" class="sub-button">Users<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="c_manageProfile.php" class="sub-item">Manage Profile</a>
                    <a href="c_addNewUser.php" class="sub-item">Add New User</a>
                </div>
            </div>

            <div class="item">
                <a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="c_membership.php" class="sub-item">Membership Approval</a>
                </div>
            </div>

            <div class="item">
                <a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="c_viewEvent.php" class="sub-item">View Event</a>
                    <a href="c_meritApp.php" class="sub-item">Merit Application</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <br>
        <h2>Hi <?php echo htmlspecialchars($loggedInUser); ?></h2>
        <p>Welcome to MyPetakom's home.</p>
        <br>

        <div class="dashboard-content">

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Users</h3>
                    <p>2,430</p>
                </div>
            </div>

            <!-- Charts Container -->
            <div class="charts-container">
                <!-- Bar Chart -->
                <div class="bar-chart">
                    <h3>Student Attendance by Active Event (Bar Chart)</h3>
                    <div class="chart-container">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                </div>

                <!-- Pie Chart -->
                <div class="pie-chart">
                    <h3>Student Attendance by Course</h3>
                    <div class="pie-chart-container">
                        <canvas id="attendanceByCourseChart"></canvas>
                    </div>
                </div>
            </div>

            <br>
            <h2>Upcoming Events</h2>
            <div class="events-container">
                <div class="event">
                    <img src="images/larian_amal.jpg" class="eventImage">
                    <div class="event-content">
                        <p align="center" class="p1">Larian Amal UMPSA 2025</p><br>
                        <p align="center" class="p1">31 May 2025</p>
                    </div>
                </div>

                <div class="event">
                    <img src="images/hackaton.jpg" class="eventImage">
                    <div class="event-content">
                        <p align="center" class="p1">Hackaton X: Smart City 2025</p><br>
                        <p align="center" class="p1">28 May 2025</p>
                    </div>
                </div>

                <div class="event">
                    <img src="images/combat.jpg" class="eventImage">
                    <div class="event-content">
                        <p align="center" class="p1">COMBAT 2025</p><br>
                        <p align="center" class="p1">9 May-23 May 2025</p>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(document).ready(function() {
                    $('.sub-button').click(function() {
                        $(this).next('.sub-menu').slideToggle();
                    });

                    // Create the attendance bar chart
                    const ctx = document.getElementById('attendanceChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode($chartLabels); ?>,
                            datasets: [{
                                label: 'Number of Students Attended',
                                data: <?php echo json_encode($chartValues); ?>,
                                backgroundColor: 'rgba(0, 116, 228, 0.7)',
                                borderColor: 'rgba(0, 116, 228, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.parsed.y + ' students attended';
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Students',
                                        font: {
                                            weight: 'bold',
                                            size: 14
                                        }
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        precision: 0
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Event Name',
                                        font: {
                                            weight: 'bold',
                                            size: 14
                                        }
                                    },
                                    ticks: {
                                        autoSkip: false,
                                        maxRotation: 45,
                                        minRotation: 45
                                    }
                                }
                            }
                        }
                    });

                    // Create the attendance by course pie chart
                    const courseCtx = document.getElementById('attendanceByCourseChart').getContext('2d');
                    new Chart(courseCtx, {
                        type: 'pie',
                        data: {
                            labels: <?php echo json_encode($courseLabels); ?>,
                            datasets: [{
                                label: 'Students Attended by Course',
                                data: <?php echo json_encode($courseValues); ?>,
                                backgroundColor: <?php echo json_encode(array_slice($pieColors, 0, count($courseLabels))); ?>,
                                borderColor: <?php echo json_encode(array_slice($pieBorderColors, 0, count($courseLabels))); ?>,
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        font: {
                                            size: 12
                                        }
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                                            return context.label + ': ' + context.parsed + ' students (' + percentage + '%)';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            </script>
        </div>
    </div>
</body>

</html>