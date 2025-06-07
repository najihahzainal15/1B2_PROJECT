<?php
// Handle AJAX requests first
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-cache, must-revalidate');
    
    require_once "config.php";
    
    // Handle QR code verification
    if (isset($_POST['qrCode']) && isset($_POST['eventId'])) {
        $response = array('success' => false, 'message' => '');
        $eventId = intval($_POST['eventId']);
        $qrCode = $_POST['qrCode'];
        
        try {
            // Verify QR code matches event
            $qrSql = "SELECT slot_ID, attendance_QRcode FROM attendanceslot WHERE eventID = ?";
            
            if ($qrStmt = mysqli_prepare($link, $qrSql)) {
                mysqli_stmt_bind_param($qrStmt, "i", $eventId);
                
                if (mysqli_stmt_execute($qrStmt)) {
                    mysqli_stmt_store_result($qrStmt);
                    
                    if (mysqli_stmt_num_rows($qrStmt) == 1) {
                        mysqli_stmt_bind_result($qrStmt, $slotId, $validQrCode);
                        mysqli_stmt_fetch($qrStmt);
                        mysqli_stmt_close($qrStmt);
                        
                        // Check if QR code matches
                        if ($qrCode === $validQrCode) {
                            $response['success'] = true;
                            $response['message'] = 'QR code verified successfully!';
                            $response['slotId'] = $slotId;
                            $response['redirect'] = "s_attendance3.php?slot_id=" . $slotId;
                            
                            error_log("QR code verified - Event: $eventId, Slot: $slotId");
                        } else {
                            $response['message'] = 'Invalid QR code for this event';
                        }
                    } else {
                        $response['message'] = 'No attendance slot found for this event';
                    }
                } else {
                    $response['message'] = 'Database error: Could not verify QR code';
                }
            } else {
                $response['message'] = 'Database error: Could not prepare QR verification statement';
            }
            
        } catch (Exception $e) {
            $response['message'] = 'System error: ' . $e->getMessage();
            error_log("QR verification error: " . $e->getMessage());
        }
        
        echo json_encode($response);
        exit;
    }
    
    // Handle event location lookup
    if (isset($_POST['eventId']) && !isset($_POST['qrCode'])) {
        $response = array('success' => false, 'eventName' => '', 'eventLocation' => '');
        $eventId = intval($_POST['eventId']);
        
        try {
            $sql = "SELECT eventName, eventLocation FROM event WHERE eventID = ?";
            
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "i", $eventId);
                
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $eventName, $eventLocation);
                        mysqli_stmt_fetch($stmt);
                        
                        $response['success'] = true;
                        $response['eventName'] = $eventName;
                        $response['eventLocation'] = $eventLocation;
                    } else {
                        $response['message'] = 'Event not found';
                    }
                } else {
                    $response['message'] = 'Database query failed';
                }
                mysqli_stmt_close($stmt);
            } else {
                $response['message'] = 'Database preparation failed';
            }
        } catch (Exception $e) {
            $response['message'] = 'Database error: ' . $e->getMessage();
            error_log("Get event location error: " . $e->getMessage());
        }
        
        echo json_encode($response);
        exit;
    }
}

// Main page logic
session_start();
require_once "config.php";

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login_page.php");
    exit();
}

// Get user's name from the database
$userID = $_SESSION["userID"];
$queryUser = "SELECT username FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

$loggedInUser = !empty($userData["username"]) ? ucwords(strtolower($userData["username"])) : "User";

// Initialize variables
$eventName = $eventDate = $eventTime = $eventLocation = $eventDescription = $qrCode = '';
$errorMessage = '';
$eventID = isset($_GET['event_id']) ? intval($_GET['event_id']) : null;

if($eventID) {
    // Fetch event details and QR code from database
    $sql = "SELECT e.eventName, e.eventDate, e.eventTime, e.eventLocation, e.eventDesc, a.attendance_QRcode 
            FROM event e
            LEFT JOIN attendanceslot a ON e.eventID = a.eventID
            WHERE e.eventID = ?";
    
    if($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $eventID);
        
        if(mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $eventName, $eventDate, $eventTime, $eventLocation, $eventDescription, $qrCode);
                mysqli_stmt_fetch($stmt);
                
                if(empty($qrCode)) {
                    $errorMessage = "No QR code available for this event.";
                }
            } else {
                $errorMessage = "No event found with that ID.";
            }
        } else {
            $errorMessage = "Error fetching event details.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $errorMessage = "Database error.";
    }
} else {
    $errorMessage = "No event ID provided.";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>STUDENT ATTENDANCE VERIFICATION</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    .logo {
      height: 40px;
      margin: 10px;
    }
    
    .logo2 {
      height: 35px;
      margin: 10px;
    }
    
    .header-left {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .content {
      margin-left: 170px;
      padding: 20px;
      background-color: #e6f0ff;
      display: flex;
      justify-content: center;
      width: calc(100% - 170px);
      min-height: 100vh;
      box-sizing: border-box;
    }

    .section-header {
      background: #f0f0f0;
      padding: 12px;
      font-size: 20px;
      font-weight: bold;
      text-align: center;
      border-top: 2px solid black;
      border-bottom: 2px solid black;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 2fr;
      gap: 10px;
      padding: 20px;
      background: white;
      width: 100%;
      box-sizing: border-box;
    }

    .form-grid label {
      background: #d9d9d9;
      font-weight: bold;
      padding: 10px;
      text-align: center;
    }

    input[type="text"], input[type="password"], textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #666;
      background: white;
      font-size: 14px;
      box-sizing: border-box;
    }

    textarea {
      resize: none;
      height: 60px;
    }

    .scan-button {
      text-align: center;
      background-color: #0074e4;
      font-family: 'Poppins', sans-serif;
      border: none;
      border-radius: 10px;
      color: white;
      padding: 12px 20px;
      text-decoration: none;
      display: inline-block;
      font-size: 14px;
      margin: 10px;
      cursor: pointer;
      transition: 0.3s;
    }
    
    .scan {
      text-align: center;
      padding: 20px;
    }

    .scan-button:hover {
      background-color: #005bb5;
    }
    
    .error-message {
      color: red;
      text-align: center;
      padding: 20px;
      font-weight: bold;
      background: #ffeeee;
      border-radius: 5px;
      margin: 20px;
    }
    
    .qr-scanner-container {
      display: none;
      margin-top: 20px;
      text-align: center;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    
    #qr-video {
      width: 100%;
      max-width: 500px;
      border: 2px solid #0074e4;
      border-radius: 5px;
      transform: scaleX(-1);
    }
    
    .qr-result {
      margin-top: 10px;
      font-weight: bold;
    }

    .qr-display-container {
      background: white;
      padding: 20px;
      border-radius: 10px;
      margin: 20px auto;
      max-width: 600px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .qr-display-container h3 {
      color: #0074e4;
      margin-top: 0;
      text-align: center;
    }

    .qr-display-container ol {
      padding-left: 20px;
      text-align: left;
    }

    .qr-display-container li {
      margin-bottom: 8px;
    }

    .submit-button {
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
      margin: 4px 10px;
      cursor: pointer;
      transition: 0.3s;
    }

    .submit-button:hover {
      background-color: #005bb5;
    }

    .fa-caret-down.rotate {
      transform: rotate(180deg);
      transition: transform 0.3s ease;
    }
    
    .fa-caret-down {
      transition: transform 0.3s ease;
    }

    .table-container {
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin: 20px 0;
      width: 100%;
      max-width: 1000px;
    }
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
    <div class="table-container">
        <?php if(!empty($errorMessage)): ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php else: ?>
            <div class="section-header">EVENT DETAILS</div>

            <div class="form-grid">
                <label>EVENT NAME</label>
                <input type="text" value="<?php echo htmlspecialchars($eventName); ?>" readonly>

                <label>DATE</label>
                <input type="text" value="<?php echo htmlspecialchars($eventDate); ?>" readonly>

                <label>TIME</label>
                <input type="text" value="<?php echo htmlspecialchars($eventTime); ?>" readonly>

                <label>LOCATION</label>
                <input type="text" value="<?php echo htmlspecialchars($eventLocation); ?>" readonly>

                <label>DESCRIPTION</label>
                <textarea readonly><?php echo htmlspecialchars($eventDescription); ?></textarea>
            </div>
            
            <div class="scan">
                <button class="scan-button" id="show-qr-btn">SHOW ATTENDANCE QR CODE</button>
            </div>
            
            <div class="qr-display-container" id="qr-display" style="display: none; text-align: center;">
                <h3>Attendance QR Code</h3>
                <p>Please take a photo of this QR code:</p>
                
                <div id="qrcode-image" style="margin: 20px auto; padding: 20px; background: white; display: inline-block;"></div>
                
                <div style="margin-top: 10px; font-size: 14px; color: #666;">
                    Event: <?php echo htmlspecialchars($eventName); ?>
                </div>
                
                <div style="background: #f8f8f8; padding: 15px; margin: 20px auto; max-width: 500px;">
                    <h4 style="margin-top: 0; text-align: center;">How to use this code:</h4>
                    <ol>
                        <li>Take a clear photo of the QR code</li>
                        <li>Click the 'SCAN QR' button</li>
                        <li>Show the QR code to your device camera</li>
                        <li>You'll be redirected to verification page</li>
                    </ol>
                </div>
                
                <div style="text-align: center; margin-top: 20px;">
                    <button class="submit-button" id="hide-qr-btn">HIDE QR CODE</button>
                </div>
            </div>

            <div class="scan" style="margin-top: 20px;">
                <button class="scan-button" id="scan-qr-btn">SCAN QR CODE</button>
            </div>

            <div class="qr-scanner-container" id="qr-scanner">
              <h3>Scan Attendance QR Code</h3>
              <div style="text-align: center;">
                <video id="qr-video" playsinline></video>
              </div>
              <div class="qr-result" id="qr-result"></div>
        
              <div style="text-align: center; margin-top: 20px;">
                  <button class="submit-button" id="stop-scan-btn">STOP SCANNING</button>
              </div>
            </div>
                
        <?php endif; ?>
    </div>
  </div>

<script type="text/javascript">
    $(document).ready(function(){
        // QR Code display functionality
        $('#show-qr-btn').click(function() {
            var qrCode = "<?php echo $qrCode; ?>";
            if(qrCode) {
                // Generate QR code using qrcode-generator library
                var qr = qrcode(0, 'M');
                qr.addData(qrCode);
                qr.make();
                
                // Display the QR code
                document.getElementById('qrcode-image').innerHTML = qr.createImgTag(4);
                $('#qr-display').show();
                $(this).hide();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'No QR Code',
                    text: 'No QR code available for this event.'
                });
            }
        });
        
        $('#hide-qr-btn').click(function() {
            $('#qr-display').hide();
            $('#show-qr-btn').show();
        });
        
        // QR Scanning functionality
        const qrScanner = document.getElementById('qr-scanner');
        const qrVideo = document.getElementById('qr-video');
        const qrResult = document.getElementById('qr-result');
        let scanner = null;
        
        $('#scan-qr-btn').click(function() {
            startScanner();
            $(this).hide();
            qrScanner.style.display = 'block';
        });
        
        $('#stop-scan-btn').click(function() {
            stopScanner();
            qrScanner.style.display = 'none';
            $('#scan-qr-btn').show();
        });

        // QR Scanner functions
        function startScanner() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ 
                    video: { 
                        facingMode: 'environment' 
                    } 
                })
                .then(function(stream) {
                    qrVideo.srcObject = stream;
                    qrVideo.setAttribute('playsinline', true);
                    qrVideo.play();
                    requestAnimationFrame(scanQRCode);
                })
                .catch(function(err) {
                    console.error('Error accessing camera:', err);
                    qrResult.innerHTML = '<span style="color: red;">Error accessing camera. Please ensure camera permissions are granted.</span>';
                });
            } else {
                qrResult.innerHTML = '<span style="color: red;">Camera not supported by this browser.</span>';
            }
        }

        function stopScanner() {
            if (qrVideo.srcObject) {
                const tracks = qrVideo.srcObject.getTracks();
                tracks.forEach(track => track.stop());
                qrVideo.srcObject = null;
            }
            qrResult.textContent = '';
        }

        function scanQRCode() {
            if (qrVideo.readyState === qrVideo.HAVE_ENOUGH_DATA) {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = qrVideo.videoWidth;
                canvas.height = qrVideo.videoHeight;
                context.drawImage(qrVideo, 0, 0, canvas.width, canvas.height);
                
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);
                
                if (code) {
                    qrResult.innerHTML = '<span style="color: green;">QR Code detected! Verifying...</span>';
                    
                    // Show loading
                    Swal.fire({
                        title: 'Verifying QR Code...',
                        text: 'Please wait while we verify your QR code',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Send QR verification request
                    $.ajax({
                        url: window.location.href,
                        method: 'POST',
                        data: {
                            eventId: <?php echo $eventID ? $eventID : 'null'; ?>,
                            qrCode: code.data
                        },
                        dataType: 'json',
                        success: function(response) {
                            Swal.close();
                            
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message,
                                    confirmButtonText: 'Continue'
                                }).then(() => {
                                    // Stop scanner after successful verification
                                    stopScanner();
                                    qrScanner.style.display = 'none';
                                    $('#scan-qr-btn').show();
                                    
                                    // Redirect to verification page
                                    if (response.redirect) {
                                        window.location.href = response.redirect;
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Verification Failed',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.close();
                            console.error('AJAX Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'System Error',
                                text: 'Unable to verify QR code. Please try again.'
                            });
                        }
                    });
                    
                    return;
                }
            }
            
            // Continue scanning if no QR code found
            if (qrScanner.style.display !== 'none') {
                requestAnimationFrame(scanQRCode);
            }
        }

        // Sub-menu functionality
        $('.sub-button').click(function(){
            $(this).next('.sub-menu').slideToggle();
            $(this).find('.fa-caret-down').toggleClass('rotate');
        });

        // Automatically open sub-menu if it contains an active item
        $('.sub-menu').each(function() {
            if ($(this).find('.active').length > 0) {
                $(this).show();
                $(this).prev('.sub-button').addClass('active-parent');
            }
        });
    });
</script>

</body>
</html>