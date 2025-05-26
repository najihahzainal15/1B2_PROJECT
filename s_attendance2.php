<?php
require_once "config.php";

// Initialize variables
$eventName = $eventDate = $eventTime = $eventLocation = $eventDescription = $qrCode = '';
$errorMessage = '';
$eventID = isset($_GET['event_id']) ? $_GET['event_id'] : null;

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
    
    h2{
    margin: 0px 40px;
    font-size: 25px;
    color: white;
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
    
    .logo{
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
    
    .icons{
        background: white;
        border: 0.1 rem solid black;
        padding: 2rem;
        display: flex;
        align-items: center;
        flex: 1 1 25rem;
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
    }

   .content {
      margin-left: 148px;
      padding: 20px;
      background-color: #e6f0ff;
      display: flex;
      justify-content: center;
      width: calc(100% - 170px);  /* Use available space */
      flex-direction: column; /* Stack items vertically */
    }

    @media (max-width: 800px) {
      .table-container {
        margin-left: 20px;
        margin-right: 20px;
        width: calc(100% - 40px); /* Adjust for small screens */
        padding: 10px; /* Less padding on small screens */
      }

      .identity-row input,
      .event-details input {
        font-size: 14px; /* Smaller text for smaller screens */
      }
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
    }

    .form-grid label {
      background: #d9d9d9;
      font-weight: bold;
      padding: 10px;
      text-align: center;
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
      margin: 4px 25px;
      cursor: pointer;
      transition: 0.3s;
      float: left;
    }

    .submit-button:hover {
      background-color: #005bb5;
    }
    
    .scan-button {
      text-align: center;
      background-color: #0074e4;
      font-family: 'Poppins', sans-serif;
      border: none;
      border-radius: 10px;
      color: white;
      padding: 8px 14px;
      text-decoration: none;
      display: inline-block;
      font-size: 14px;
      margin: 4px 25px;
      cursor: pointer;
      transition: 0.3s;
    }
    
    .scan{
        text-align: center;
    }

    .scan-button:hover {
      background-color: #005bb5;
    }
    
    .error-message {
      color: red;
      text-align: center;
      padding: 20px;
      font-weight: bold;
    }
    
    .qr-scanner-container {
      display: none;
      margin-top: 20px;
      text-align: center;
    }
    
    #qr-video {
      width: 100%;
      max-width: 500px;
      border: 2px solid #0074e4;
      border-radius: 5px;
    }
    
    .qr-result {
      margin-top: 10px;
      font-weight: bold;
    }

    .qr-display-container {
      background: #f0f0f0;
      padding: 20px;
      border-radius: 10px;
      margin: 20px auto;
      max-width: 600px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .qr-display-container h3 {
        color: #0074e4;
        margin-top: 0;
    }

    .qr-display-container ol {
        padding-left: 20px;
    }

    .qr-display-container li {
        margin-bottom: 8px;
    }
    
    #qr-video {
      width: 100%;
      max-width: 500px;
      border: 2px solid #0074e4;
      border-radius: 5px;
      transform: scaleX(-1); /* This flips the video horizontally */
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
      <p>Student: <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?></p>
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
      <div class="item"><a href="#membership">Dashboard</a></div>
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
          <a href="#c_meritApp.html" class="sub-item">Merit Application</a>
        </div>
      </div>
      
      <div class="item">
        <a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
        <div class="sub-menu">
          <a class="active" href="#events" class="sub-item">Attendance Slot</a>
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
                <h3 style="text-align: center;">Attendance QR Code</h3>
                <p style="text-align: center;">Please take a photo of this QR code:</p>
                
                <!-- This div will contain the generated QR code -->
                <div id="qrcode-image" style="margin: 20px auto; padding: 20px; background: white; display: inline-block;"></div>
                
                <div style="margin-top: 10px; font-size: 14px; color: #666;">
                    Event: <?php echo htmlspecialchars($eventName); ?>
                </div>
                
                <div style="background: #f8f8f8; padding: 15px; margin: 20px auto; max-width: 500px;">
                    <h4 style="margin-top: 0; text-align: center;">How to use this code:</h4>
                    <ol style="padding-left: 20px;">
                        <li>Take a clear photo of the QR code</li>
                        <li>Click the 'SCAN QR' button</li>
                        <li>Show the QR into your device camera</li>
                        <li>Keep the screenshot until attendance is verified</li>
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
                <h3 style="text-align: center;">Scan Attendance QR Code</h3>
                <div style="text-align: center;">
                    <video id="qr-video" playsinline></video>
                </div>
                <div class="qr-result" id="qr-result"></div>
                
                <!-- Add this authentication form -->
                <div id="auth-form" style="display: none; margin: 20px auto; max-width: 400px; padding: 20px; background: #f5f5f5; border-radius: 8px;">
                    <h3 style="text-align: center;">Verify Your Identity</h3>
                    <div style="margin-bottom: 15px;">
                        <label for="student-id" style="display: block; margin-bottom: 5px;">Student ID:</label>
                        <input type="text" id="student-id" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label for="student-password" style="display: block; margin-bottom: 5px;">Password:</label>
                        <input type="password" id="student-password" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <button id="verify-btn" style="width: 100%; padding: 10px; background-color: #0074e4; color: white; border: none; border-radius: 4px; cursor: pointer;">Verify</button>
                </div>
                
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
                alert('No QR code available for this event.');
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
        const authForm = document.getElementById('auth-form');
        let scanner = null;
        let currentScannedData = null;
        
        $('#scan-qr-btn').click(function() {
            startScanner();
            $(this).hide();
            qrScanner.style.display = 'block';
            authForm.style.display = 'none';
        });
        
        $('#stop-scan-btn').click(function() {
            stopScanner();
            qrScanner.style.display = 'none';
            $('#scan-qr-btn').show();
            authForm.style.display = 'none';
        });
        
        // Modify the verify-btn click handler
$('#verify-btn').click(function() {
    const studentId = $('#student-id').val();
    const password = $('#student-password').val();
    
    if(!studentId || !password) {
        Swal.fire({
            title: 'Error!',
            text: 'Please enter both Student ID and Password',
            icon: 'error'
        });
        return;
    }
    
    // Show loading indicator
    Swal.fire({
        title: 'Verifying Attendance',
        text: 'Please wait while we verify your attendance...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Verify student credentials and record attendance
    $.ajax({
        url: 'verify_attendance.php',
        type: 'POST',
        data: {
            studentId: studentId,
            password: password,
            eventId: <?php echo $eventID; ?>,
            qrCode: currentScannedData
        },
        success: function(response) {
            Swal.close();
            const result = JSON.parse(response);
            if(result.success) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Attendance recorded successfully',
                    icon: 'success'
                });
                authForm.style.display = 'none';
                stopScanner();
                qrScanner.style.display = 'none';
                $('#scan-qr-btn').show();
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: result.message,
                    icon: 'error'
                });
            }
        },
        error: function() {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to verify attendance',
                icon: 'error'
            });
        }
    });
});

// Updated QR scanner function
function startScanner() {
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
        .then(function(stream) {
            qrVideo.srcObject = stream;
            qrVideo.play();
            
            scanner = setInterval(function() {
                if (qrVideo.readyState === qrVideo.HAVE_ENOUGH_DATA) {
                    try {
                        const canvas = document.createElement('canvas');
                        canvas.width = qrVideo.videoWidth;
                        canvas.height = qrVideo.videoHeight;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(qrVideo, 0, 0, canvas.width, canvas.height);
                        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                        const code = jsQR(imageData.data, imageData.width, imageData.height);
                        
                        if (code) {
                            currentScannedData = code.data;
                            stopScanner();
                            
                            // Extract event ID from QR code
                            let qrEventId;
                            if (code.data.startsWith("EVENT_ID:")) {
                                qrEventId = code.data.split(':')[1].split('_')[0];
                            } else {
                                qrEventId = code.data.split('_')[0];
                            }
                            
                            const currentEventId = "<?php echo $eventID; ?>";
                            
                            if (qrEventId == currentEventId) {
                                qrResult.innerHTML = 'Valid QR code for this event';
                                authForm.style.display = 'block';
                            } else {
                                // Fetch event details for the scanned QR code
                                $.ajax({
                                    url: 'get_event_location.php',
                                    type: 'POST',
                                    data: { eventId: qrEventId },
                                    success: function(response) {
                                        const eventData = JSON.parse(response);
                                        if (eventData.success) {
                                            Swal.fire({
                                                title: 'Wrong Location',
                                                html: `This QR code is for:<br><br>
                                                       <strong>Event:</strong> ${eventData.eventName}<br>
                                                       <strong>Location:</strong> ${eventData.eventLocation}`,
                                                icon: 'error'
                                            });
                                        } else {
                                            Swal.fire({
                                                title: 'Invalid QR Code',
                                                text: 'This QR code is not recognized by the system',
                                                icon: 'error'
                                            });
                                        }
                                        qrScanner.style.display = 'none';
                                        $('#scan-qr-btn').show();
                                    },
                                    error: function() {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'Could not verify QR code location',
                                            icon: 'error'
                                        });
                                        qrScanner.style.display = 'none';
                                        $('#scan-qr-btn').show();
                                    }
                                });
                            }
                        }
                    } catch (e) {
                        console.error("Error scanning QR:", e);
                    }
                }
            }, 100);
        })
        .catch(function(err) {
            console.error("Camera access error:", err);
            Swal.fire({
                title: 'Camera Error',
                text: 'Could not access camera. Please ensure you\'ve granted camera permissions.',
                icon: 'error'
            });
            qrResult.innerHTML = "Could not access camera. Please ensure you've granted camera permissions.";
        });
}
        
        function stopScanner() {
            if (scanner) {
                clearInterval(scanner);
                scanner = null;
            }
            if (qrVideo.srcObject) {
                qrVideo.srcObject.getTracks().forEach(track => track.stop());
                qrVideo.srcObject = null;
            }
            qrResult.innerHTML = "";
        }
    });
</script>
</body>
</html>
