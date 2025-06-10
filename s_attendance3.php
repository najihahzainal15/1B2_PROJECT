<?php
require_once "config.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login_page.php");
    exit();
}
$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());

// Get user info
$userID = $_SESSION["userID"];
$role = $_SESSION["role"];
$queryUser = "SELECT username FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);
$loggedInUser = !empty($userData["username"]) ? ucwords(strtolower($userData["username"])) : "User";

// Initialize variables
$eventName = $eventDate = $eventTime = $eventLocation = $eventGeolocation = '';
$errorMessage = '';
$successMessage = '';

// Get slot_id from URL with proper validation
$slotID = 0;
if (isset($_GET['slot_id']) && is_numeric($_GET['slot_id'])) {
    $slotID = intval($_GET['slot_id']);
    
    // Verify slot exists in database
    $checkSlotSql = "SELECT slot_ID FROM attendanceslot WHERE slot_ID = ?";
    if ($checkStmt = mysqli_prepare($link, $checkSlotSql)) {
        mysqli_stmt_bind_param($checkStmt, "i", $slotID);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);
        
        if (mysqli_stmt_num_rows($checkStmt) == 0) {
            $errorMessage = "Invalid attendance slot ID (not found in database)";
            error_log("Slot ID $slotID not found in database");
        }
        mysqli_stmt_close($checkStmt);
    }
} else {
    $errorMessage = "No valid attendance slot ID provided";
}

// Function to calculate distance between two coordinates using Haversine formula
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $earthRadius = 6371000; // Earth's radius in meters
    
    $dLat = deg2rad($lat2 - $lat1); //convert degress to radian
    $dLon = deg2rad($lon2 - $lon1);
    
    //haversine calculation. The haversine formula determines the great-circle distance between two points on a sphere given their longitudes and latitudes.
    $a = sin($dLat/2) * sin($dLat/2) + 
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * 
         sin($dLon/2) * sin($dLon/2);
    //atan; angular distance
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    
    return $earthRadius * $c; // Distance in meters
}

// Only proceed if we have a valid slot ID
if ($slotID > 0) {
    // Fetch event details including geolocation
    $sql = "SELECT e.eventName, e.eventDate, e.eventTime, e.eventLocation, e.eventGeolocation 
            FROM event e
            JOIN attendanceslot a ON e.eventID = a.eventID
            WHERE a.slot_ID = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $slotID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $eventName, $eventDate, $eventTime, $eventLocation, $eventGeolocation);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
    }

    // Process attendance submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if this is the geolocation verification step
        if (isset($_POST['verify_geolocation'])) {
            $studentID = trim($_POST['student_id']);
            $password = trim($_POST['password']);
            $userLat = floatval($_POST['user_lat']);
            $userLng = floatval($_POST['user_lng']);
            
            // Parse event geolocation (format: "lat, lng")
            $eventCoords = explode(',', $eventGeolocation);
            $eventLat = floatval(trim($eventCoords[0]));
            $eventLng = floatval(trim($eventCoords[1]));
            
            // Calculate distance using Haversine formula
            $distance = calculateDistance($eventLat, $eventLng, $userLat, $userLng);
            
            // Allow 1000 meter radius (1 km) for more reasonable tolerance
            if ($distance > 1000) {
                $errorMessage = "You are too far from the event location (".round($distance)." meters away). Please be at the event venue to record attendance.";
                // Debug output - you can remove this after testing
                $errorMessage .= "<br>Event location: ".$eventGeolocation;
                $errorMessage .= "<br>Your location: ".$userLat.", ".$userLng;
                $errorMessage .= "<br>Calculated distance: ".round($distance, 2)." meters";
            } else {
                // Location verified - proceed with attendance recording
                try {
                    // Check if attendance already exists for this student and slot
                    $checkAttendanceSql = "SELECT attendanceID FROM attendance WHERE StudentID = ? AND slot_ID = ?";
                    if ($checkStmt = mysqli_prepare($link, $checkAttendanceSql)) {
                        mysqli_stmt_bind_param($checkStmt, "si", $studentID, $slotID);
                        mysqli_stmt_execute($checkStmt);
                        mysqli_stmt_store_result($checkStmt);
                        
                        if (mysqli_stmt_num_rows($checkStmt) > 0) {
                            $errorMessage = "Attendance already recorded for this student";
                        } else {
                            // Record attendance
                            $insertSql = "INSERT INTO attendance (StudentID, date, time, slot_ID) 
                                         VALUES (?, CURDATE(), CURTIME(), ?)";
                            
                            if ($insertStmt = mysqli_prepare($link, $insertSql)) {
                                $slotIDStr = strval($slotID);
                                mysqli_stmt_bind_param($insertStmt, "si", $studentID, $slotID);
                                if (mysqli_stmt_execute($insertStmt)) {
                                    $successMessage = "Attendance recorded successfully for ".htmlspecialchars($eventName)." (Distance: ".round($distance)." meters from venue)";
                                    error_log("Attendance recorded - Student: $studentID, Slot: $slotID, Time: " . date('Y-m-d H:i:s') . ", Distance: " . round($distance) . "m");
                                } else {
                                    $errorMessage = "Error recording attendance: ".mysqli_error($link);
                                    error_log("Failed to insert attendance - Student: $studentID, Slot: $slotID, Error: " . mysqli_error($link));
                                }
                                mysqli_stmt_close($insertStmt);
                            }
                        }
                        mysqli_stmt_close($checkStmt);
                    }
                } catch (Exception $e) {
                    $errorMessage = "System error: ".$e->getMessage();
                    error_log("Attendance error: ".$e->getMessage());
                }
            }
        }
        // Original credential verification step
        elseif (isset($_POST['submit_attendance'])) {
            $studentID = trim($_POST['student_id']);
            $password = trim($_POST['password']);

            if (empty($studentID)) {
                $errorMessage = "Student ID is required";
            } elseif (empty($password)) {
                $errorMessage = "Password is required";
            } else {
                try {
                    // Verify student credentials
                    $sql = "SELECT s.studentID, u.password 
                            FROM student s
                            JOIN user u ON s.userID = u.userID
                            WHERE UPPER(s.studentID) = UPPER(?) AND u.role = 'Student'";

                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "s", $studentID);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);
                        
                        if (mysqli_stmt_num_rows($stmt) == 1) {
                            mysqli_stmt_bind_result($stmt, $dbStudentID, $dbPassword);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);
                            
                            // Check password
                            if ($password === $dbPassword) {
                                // Credentials valid - now we need geolocation verification
                                // This will be handled by JavaScript
                            } else {
                                $errorMessage = "Invalid student ID or password";
                            }
                        } else {
                            $errorMessage = "Invalid student ID or password";
                            mysqli_stmt_close($stmt);
                        }
                    }
                } catch (Exception $e) {
                    $errorMessage = "System error: ".$e->getMessage();
                    error_log("Attendance error: ".$e->getMessage());
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
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

        .content {
            background-color: #e6f0ff;
            margin-left: 160px;
            padding: 20px;
            min-height: calc(100vh - 60px);
            box-sizing: border-box;
        }

        .logo {
            height: 40px;
            margin: 10px;
        }

        .logo2 {
            height: 35px;
            margin: 10px;
        }

        .back-btn {
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

        .event-info {
            background: #d0e6ff;
            padding: 20px;
            border-radius: 5px;
            margin: 20px auto;
            width: 90%;
            border: 2px solid #666;
        }

        .event-info h2 {
            color: #0074e4;
            margin-top: 0;
            text-align: center;
        }

        .event-info p {
            margin: 10px 0;
            text-align: center;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 80%;
            margin: 20px auto;
            max-width: 600px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            box-sizing: border-box;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #0074e4;
            outline: none;
        }

        .submit-button {
            background-color: #0074e4;
            font-family: 'Poppins', sans-serif;
            border: none;
            border-radius: 10px;
            color: white;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-button:hover {
            background-color: #005bb5;
        }

        .error { 
            color: #d32f2f;
            padding: 15px;
            background-color: #ffebee;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #d32f2f;
            width: 80%;
            margin: 20px auto;
        }

        .success { 
            color: #2e7d32;
            padding: 15px;
            background-color: #e8f5e8;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #2e7d32;
            width: 80%;
            margin: 20px auto;
        }

        .geolocation-container {
            display: none;
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background: #f5f9ff;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .geolocation-message {
            margin: 15px 0;
            font-size: 16px;
        }

        #location-status {
            font-weight: bold;
            margin: 15px 0;
            padding: 10px;
            border-radius: 5px;
            background: #f8f8f8;
        }

        .location-success {
            color: #2e7d32;
            background: #e8f5e9;
            border-left: 4px solid #2e7d32;
        }

        .location-error {
            color: #d32f2f;
            background: #ffebee;
            border-left: 4px solid #d32f2f;
        }

        #location-status i {
            margin-right: 8px;
        }

        #retry-location {
            cursor: pointer;
            transition: background 0.3s;
        }

        #retry-location:hover {
            background: #005bb5;
        }

        .distance-info {
            margin: 10px 0;
            padding: 10px;
            background: #f0f8ff;
            border-radius: 5px;
            border-left: 4px solid #0074e4;
        }
    </style>

<script>
function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
    const R = 6371; // Earth radius in km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLon/2) * Math.sin(dLon/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c;
}

function checkLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;

            const eventGeo = document.getElementById("eventGeolocation").value;
            const [eventLat, eventLng] = eventGeo.split(',').map(Number);

            const distance = getDistanceFromLatLonInKm(userLat, userLng, eventLat, eventLng);

            if (distance <= 1.0) {
                document.getElementById("status").innerHTML = "<span style='color:green;'>Successful register!</span>";
            } else {
                document.getElementById("status").innerHTML = "<span style='color:red;'>You are not at the event location.</span>";
            }
        }, function(error) {
            document.getElementById("status").innerHTML = "Error getting location: " + error.message;
        });
    } else {
        document.getElementById("status").innerHTML = "Geolocation not supported.";
    }
}
</script>

</head>
<body>

    <div class="header1">
        <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo">
        <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
        <div class="header-center">
            <h2>Attendance Verification</h2>
            <p>Student: <?php echo htmlspecialchars($loggedInUser); ?></p>
        </div>
        <div class="header-right">
            <a href="logout_button.php" class="logout">Logout</a>
            <a href="s_displayProfile.php">
                <img src="images/profile.png" alt="Profile" class="logo2">
            </a>
        </div>
    </div>

    <div class="nav">
        <div class="menu">
            <div class="item"><a href="s_homepage.php">Dashboard</a></div>
            
            <div class="item">
                <a href="#membership" class="sub-button">Membership<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="s_membership.php" class="sub-item">Membership Application</a>
                </div>
            </div>

            <div class="item">
                <a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="s_homepage.php" class="sub-item">View Event</a>
                </div>
            </div>

            <div class="item">
                <a href="#attendance" class="sub-button active-parent">Attendance<i class="fa-solid fa-caret-down"></i></a>
                <div class="sub-menu">
                    <a href="s_attendance1.php" class="sub-item active">Attendance Slot</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <?php if(!empty($errorMessage)): ?>
            <div class="error">
                <strong>Error:</strong> <?php echo $errorMessage; ?>
                <?php if(strpos($errorMessage, 'Invalid attendance slot') !== false): ?>
                    <p>Please ensure you scanned the correct QR code for this event.</p>
                <?php endif; ?>
            </div>
        <?php elseif(!empty($successMessage)): ?>
            <div class="success">
                <strong>Success!</strong> <?php echo $successMessage; ?>
                <p>Your attendance has been recorded in the system.</p>
            </div>
        <?php endif; ?>

        <?php if($slotID > 0): ?>
            <div class="event-info">
                <h2><?php echo htmlspecialchars($eventName); ?></h2>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($eventDate); ?></p>
                <p><strong>Time:</strong> <?php echo htmlspecialchars($eventTime); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($eventLocation); ?></p>
                <?php if(!empty($eventGeolocation)): ?>
                    <div class="distance-info">
                        <p><strong>GPS Coordinates:</strong> <?php echo htmlspecialchars($eventGeolocation); ?></p>
                        <p><small><i class="fas fa-info-circle"></i> You must be within 1000 meters (1 km) of this location to record attendance</small></p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if(empty($successMessage)): ?>
                <div class="form-container">
                    <form id="attendanceForm" method="post">
                        <input type="hidden" name="slot_id" value="<?php echo $slotID; ?>">
                        <input type="hidden" id="user_lat" name="user_lat" value="">
                        <input type="hidden" id="user_lng" name="user_lng" value="">
                        
                        <div id="credentialSection">
                            <div class="form-group">
                                <label for="student_id">Student ID:</label>
                                <input type="text" id="student_id" name="student_id" required 
                                       placeholder="Enter your student ID (e.g., CB23024)"
                                       value="<?php echo isset($_POST['student_id']) ? htmlspecialchars($_POST['student_id']) : ''; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" id="password" name="password" required 
                                       placeholder="Enter your password">
                            </div>
                            
                            <button type="submit" name="submit_attendance" class="submit-button">Submit Attendance</button>
                        </div>
                        
                        <div id="geolocationSection" class="geolocation-container">
                            <div class="geolocation-message">
                                <h3>Location Verification Required</h3>
                                <p>To prevent fraudulent attendance, we need to verify you're physically present at:</p>
                                <p><strong><?php echo htmlspecialchars($eventLocation); ?></strong></p>
                                <div id="location-status">Checking your location...</div>
                                <p class="p1"><i class="fas fa-info-circle"></i> Please ensure:</p>
                                <ul style="text-align: left; margin: 10px auto; max-width: 400px;">
                                    <li>Location/GPS is enabled on your device</li>
                                    <li>You're at the actual event venue (within 1 km)</li>
                                    <li>You're using a device with GPS capabilities</li>
                                </ul>
                            </div>
                            <button type="submit" name="verify_geolocation" class="submit-button" id="verifyButton" disabled>
                                <i class="fas fa-check-circle"></i> Verify Location and Record Attendance
                            </button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div style="text-align: center; margin-top: 30px;">
                    <p style="font-size: 18px;">Thank you for attending this event!</p>
                    <a href="s_attendance1.php" class="back-btn">Back to Attendance</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <a href="s_attendance1.php" class="back-btn">Back to Attendance</a>
        <?php endif; ?>
    </div>
    
    <script type="text/javascript">
        $(document).ready(function() {
            $('.sub-button').click(function() {
                $(this).next('.sub-menu').slideToggle();
            });

            // Automatically open sub-menu if it contains an active item
            $('.sub-menu').each(function() {
                if ($(this).find('.active').length > 0) {
                    $(this).show();
                    $(this).prev('.sub-button').addClass('active-parent');
                }
            });
            
            // Handle form submission
            $('#attendanceForm').on('submit', function(e) {
                if ($('button[name="submit_attendance"]').is(':focus')) {
                    e.preventDefault();
                    // First validate credentials on client side (simple check)
                    if ($('#student_id').val().trim() === '' || $('#password').val().trim() === '') {
                        //trim value if contains space in data value
                        return;
                    }
                    
                    // Show geolocation section
                    $('#credentialSection').hide();
                    $('#geolocationSection').show();
                    
                    // Get user's current location
                    if (navigator.geolocation) {
                        $('#location-status').html('<i class="fas fa-spinner fa-spin"></i> Detecting your location...').removeClass('location-error location-success');
                        
                        const options = {
                            enableHighAccuracy: true,  // Try to get the most accurate location
                            timeout: 15000,           // Maximum time to wait for location (15 seconds)
                            maximumAge: 30000         // Use cached location if it's less than 30 seconds old
                        };
                        
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                const userLat = position.coords.latitude;
                                const userLng = position.coords.longitude;
                                const accuracy = position.coords.accuracy; // Accuracy in meters
                                
                                // Store coordinates in hidden fields
                                $('#user_lat').val(userLat);
                                $('#user_lng').val(userLng);
                                
                                // Calculate distance for display (simplified calculation for display purposes)
                                const eventLat = <?php echo !empty($eventGeolocation) ? floatval(trim(explode(',', $eventGeolocation)[0])) : 0; ?>;
                                const eventLng = <?php echo !empty($eventGeolocation) ? floatval(trim(explode(',', $eventGeolocation)[1])) : 0; ?>;
                                
                                // Haversine formula for distance calculation
                                function calculateDistance(lat1, lon1, lat2, lon2) {
                                    const R = 6371000; // Earth's radius in meters
                                    const dLat = (lat2 - lat1) * Math.PI / 180;
                                    const dLon = (lon2 - lon1) * Math.PI / 180;
                                    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                                            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                                            Math.sin(dLon/2) * Math.sin(dLon/2);
                                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                                    return R * c;
                                }
                                
                                const distance = calculateDistance(eventLat, eventLng, userLat, userLng);
                                
                                // Show accuracy and distance information to user
                                let statusMessage = `<i class="fas fa-check-circle"></i> Location detected<br>`;
                                statusMessage += `<small>Accuracy: ${Math.round(accuracy)} meters | Distance from venue: ${Math.round(distance)} meters</small>`;
                                
                                // Warn if accuracy is poor
                                if (accuracy > 100) {
                                    statusMessage += `<br><i class="fas fa-exclamation-triangle"></i> <small>Warning: Location accuracy may be low</small>`;
                                }
                                
                                // Show if within range
                                if (distance <= 1000) {
                                    statusMessage += `<br><i class="fas fa-check"></i> <small style="color: green;">You are within the allowed range!</small>`;
                                } else {
                                    statusMessage += `<br><i class="fas fa-times"></i> <small style="color: red;">You are too far from the venue (${Math.round(distance)}m > 1000m)</small>`;
                                }
                                
                                $('#location-status').html(statusMessage).removeClass('location-error').addClass('location-success');
                                
                                // Enable verify button
                                $('#verifyButton').prop('disabled', false);
                            },
                            function(error) {
                                let errorMessage = "<i class='fas fa-exclamation-circle'></i> ";
                                switch(error.code) {
                                    case error.PERMISSION_DENIED:
                                        errorMessage += "Location access was denied. Please enable location services in your browser settings and reload the page.";
                                        break;
                                    case error.POSITION_UNAVAILABLE:
                                        errorMessage += "Your location could not be determined. Please check your internet/GPS connection.";
                                        break;
                                    case error.TIMEOUT:
                                        errorMessage += "The request to get your location timed out. Please try again in an area with better signal.";
                                        break;
                                    default:
                                        errorMessage += "An unknown error occurred while getting your location.";
                                }
                                
                                $('#location-status').html(errorMessage).removeClass('location-success').addClass('location-error');
                                $('#verifyButton').prop('disabled', true);
                                
                                // Show option to try again
                                $('#location-status').append('<br><button type="button" id="retry-location" style="margin-top: 10px; padding: 5px 10px; background: #0074e4; color: white; border: none; border-radius: 5px;">Try Again</button>');
                                
                                $('#retry-location').click(function() {
                                    $(this).remove();
                                    $('#attendanceForm').trigger('submit');
                                });
                            },
                            options
                        );
                    } else {
                        $('#location-status').html("<i class='fas fa-exclamation-circle'></i> Geolocation is not supported by your browser. Please use a modern browser that supports location services.").addClass('location-error');
                    }
                }
            });
            
            // Auto-focus on student ID field when page loads
            const studentIdField = document.getElementById('student_id');
            if (studentIdField && !studentIdField.value) {
                studentIdField.focus();
            }
        });
    </script>

<input type="hidden" id="eventGeolocation" value="<?php echo $eventGeolocation; ?>">
<button onclick="checkLocation()">Check In</button>
<p id="status"></p>

</body>
</html>