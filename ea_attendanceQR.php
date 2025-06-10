<?php
require_once "config.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login_page.php");
    exit;
}
$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());

$userID = $_SESSION["userID"];
$role = $_SESSION["role"];

// Fetch username from database
$queryUser = "SELECT username FROM user WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $queryUser);
mysqli_stmt_bind_param($stmtUser, "i", $userID);//bind_param;send to db, i;integer (data type)
mysqli_stmt_execute($stmtUser);
$resultUser = mysqli_stmt_get_result($stmtUser);
$userData = mysqli_fetch_assoc($resultUser);

// Assign username after database query
$loggedInUser = !empty($userData["username"]) ? ucwords(strtolower($userData["username"])) : "User";

// Initialize variables
$eventName = $eventDate = $eventLocation = $qrData = $qrUrl = '';
$eventID = '';
$successMessage = $errorMessage = '';
$hasQrCode = false;

// Handle all POST requests (QR code operations only)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    try {
        $eventID = mysqli_real_escape_string($link, $_POST['event_id']);
        //safety function that makes sure user input (like from a form) doesn’t break SQL queries
        
        // DELETE QR code from attendanceslot
        if (isset($_POST['delete_qr'])) {
            $deleteSql = "DELETE FROM attendanceslot WHERE eventID = '$eventID'";
            
            if (mysqli_query($link, $deleteSql)) {
                echo json_encode(['status' => 'success', 'message' => 'QR Code deleted']);
                // PHP function that converts a PHP value (like an array or object) into a JSON (JavaScript Object Notation) string. 
                // JSON is a lightweight data format that's easy for humans to read and for machines to parse.
              } else {
                throw new Exception("Delete failed: " . mysqli_error($link));
            }
            exit;
        }
        
        // GENERATE new QR code
        if (isset($_POST['generate_qr'])) {
            // Get current event details
            $eventSql = "SELECT eventLocation FROM event WHERE eventID = '$eventID'";
            $eventResult = mysqli_query($link, $eventSql);
            $eventData = mysqli_fetch_assoc($eventResult);
            
            if (!$eventData) {
                throw new Exception("Event not found");
                //An exception is a way to handle unexpected errors or events that occur during program execution.
            }
            
            $currentVenue = $eventData['eventLocation'];
            
            // Generate new QR data (include venue in the data)
            $newQrData = "EVENT_ID:" . $eventID . "_VENUE:" . $currentVenue . "_" . uniqid();
            
            // Check if QR exists
            $checkSql = "SELECT slot_ID FROM attendanceslot WHERE eventID = '$eventID'";
            $checkResult = mysqli_query($link, $checkSql);
            
            if (mysqli_num_rows($checkResult) > 0) {
                // Update existing
                $sql = "UPDATE attendanceslot SET attendance_QRcode = '$newQrData' WHERE eventID = '$eventID'";
            } else {
                // Insert new
                $sql = "INSERT INTO attendanceslot (attendance_QRcode, eventID) VALUES ('$newQrData', '$eventID')";
            }
            
            if (mysqli_query($link, $sql)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'QR Code generated!',
                    'qr_url' => "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($newQrData)
                ]);
            } else {
                throw new Exception("QR generation failed: " . mysqli_error($link));
            }
            exit;
        }
        
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }
}

// GET request - load event and QR data
if (isset($_GET['event_id'])) {
    $eventID = mysqli_real_escape_string($link, $_GET['event_id']);
    
    // Get current event details
    $eventSql = "SELECT eventName, eventDate, eventLocation FROM event WHERE eventID = '$eventID'";
    $eventResult = mysqli_query($link, $eventSql);
    
    if ($eventResult && mysqli_num_rows($eventResult) > 0) {
        $eventData = mysqli_fetch_assoc($eventResult);
        $eventName = $eventData['eventName'];
        $eventDate = $eventData['eventDate'];
        $eventLocation = $eventData['eventLocation'];
        
        // Check for existing QR code
        $qrSql = "SELECT attendance_QRcode FROM attendanceslot WHERE eventID = '$eventID'";
        $qrResult = mysqli_query($link, $qrSql);
        
        if ($qrResult && mysqli_num_rows($qrResult) > 0) {
            $qrData = mysqli_fetch_assoc($qrResult)['attendance_QRcode'];
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrData);
            // Uses an external API from api.qrserver.com
            // Simply pass the data as a URL parameter to generate the QR image
            //The QR data contains event ID, venue, and a unique identifier

            $hasQrCode = true;
        }
    } else {
        $errorMessage = "Event not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>EVENT ADVISOR ATTENDANCE QR</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/f52cf35b07.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #e6f0ff;
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
      padding-left: 30px;
      width: 100%;
      box-sizing: border-box;
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
    
    .sub-menu a.active {
      background-color: #0264c2;
      font-weight: bold;
    }
    
    .nav a.active-parent {
      background-color: #0264c2;
      color: white;
    }
    
    .content {
      margin-left: 170px;
      padding: 20px;
      background-color: #e6f0ff;
      width: calc(100% - 170px);
      min-height: 100vh;
      box-sizing: border-box;
    }
    
    .qr-code {
      margin: 20px auto;
      max-width: 300px;
      text-align: center;
    }

    .qr-container {
      background-color: white;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      margin: 30px auto;
      max-width: 800px;
      text-align: center;
    }
    
    .event-info {
      margin-bottom: 20px;
    }
    
    .event-name {
      font-size: 24px;
      color: #0074e4;
      margin-bottom: 10px;
    }
    
    .event-date {
      font-size: 18px;
      color: #666;
    }
    
    .event-venue {
      font-size: 18px;
      color: #666;
      margin-bottom: 15px;
    }
    
    .back-btn {
      background-color: #0074e4;
      font-family: 'Poppins', sans-serif;
      border: none;
      border-radius: 10px;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      display: inline-block;
      margin-top: 20px;
      cursor: pointer;
      transition: 0.3s;
    }
    
    .back-btn:hover {
      background-color: #005bb5;
    }
    
    .download-btn {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      margin-top: 15px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
    }
    
    .delete-btn {
      background-color: #f44336;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      margin-top: 15px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
    }
    
    .generate-btn {
      background-color: #2196F3;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      margin-top: 15px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
    }
    
    .action-buttons {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }
    
    .download-btn:hover {
      background-color: #3e8e41;
    }
    
    .delete-btn:hover {
      background-color: #da190b;
    }
    
    .generate-btn:hover {
      background-color: #0b7dda;
    }
    
    .logo {
      height: 40px;
      margin: 10px;
    }
    
    .logo2 {
      height: 35px;
      margin: 10px;
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
    }
    
    .submit-button:hover {
      background-color: #005bb5;
    }
    
    @media (max-width: 768px) {
      .header1 {
        margin-left: 0;
        flex-direction: column;
        text-align: center;
      }
      
      .nav {
        width: 100%;
        height: auto;
        position: relative;
        padding-top: 0;
      }
      
      .content {
        margin-left: 0;
        width: 100%;
        padding: 10px;
      }
      
      .action-buttons {
        flex-direction: column;
        align-items: center;
      }
      
      .header-left, .header-right {
        justify-content: center;
      }
    }
  </style>
</head>

<body>
  <div class="header1">
  <div class="header-left">
    <img src="images/UMPSALogo.png" alt="UMPSA Logo" class="logo">
    <img src="images/PetakomLogo.png" alt="PETAKOM Logo" class="logo">
  </div>
  
  <div class="header-center">
    <h2>Attendance QR Code</h2>
    <p>Event Advisor: <?php echo htmlspecialchars($loggedInUser); ?></p>
  </div>
  
  <div class="header-right">
    <a href="logout_button.php" class="logout">Logout</a>
    <a href="ea_displayProfile.php">
      <img src="images/profile.png" alt="Profile" class="logo2">
    </a>
  </div>
</div>

  <div class="nav">
  <div class="menu">
    <div class="item"><a href="ea_homepage.php">Dashboard</a></div>

    <div class="item">
      <a href="#events" class="sub-button">Events<i class="fa-solid fa-caret-down"></i></a>
      <div class="sub-menu">
        <a href="ea_viewEvent.php" class="sub-item">View Event</a>
        <a href="ea_registerEvent1.php" class="sub-item">Register New Event</a>
        <a href="ea_eventCommittee.php" class="sub-item">Event Committee</a>
        <a href="ea_committeeReg.php" class="sub-item">Register Committee Event</a>
      </div>
    </div>

    <div class="item">
      <a href="#attendance" class="sub-button">Attendance<i class="fa-solid fa-caret-down"></i></a>
      <div class="sub-menu">
        <a href="ea_attendanceSlot.php" class="sub-item">Attendance Slot</a>
      </div>
    </div>
  </div>
</div>

  <div class="content">
    <?php if(!empty($errorMessage)): ?>
      <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    
    <?php if(!empty($successMessage)): ?>
      <div class="alert alert-success"><?php echo $successMessage; ?></div>
    <?php endif; ?>
    
    <div class="qr-container">
      <div class="event-info">
        <div class="event-name"><?php echo htmlspecialchars($eventName); ?></div> 
        <!-- htmlspecialchars() method is used to convert special characters to HTML entities -->
        
        <div class="event-date">Date: <?php echo htmlspecialchars($eventDate); ?></div>
        <div class="event-venue">Venue: <?php echo htmlspecialchars($eventLocation); ?></div>
      </div>
      
      <!-- if qr not empty -->
      <?php if(!empty($qrUrl)): ?> 
        <img src="<?php echo $qrUrl; ?>" alt="Event QR Code" class="qr-code" id="qrImage">
        <div class="action-buttons">
          <button id="deleteQrBtn" class="delete-btn">
            <i class="fas fa-trash"></i> Delete QR Code
          </button>
          <button id="generateQrBtn" class="generate-btn">
            <i class="fas fa-sync-alt"></i> Regenerate QR Code
          </button>
          <a href="<?php echo $qrUrl; ?>&download=1" class="download-btn">
            <i class="fas fa-download"></i> Download QR Code
          </a>
        </div>
      <?php else: ?>
        <p>No QR code exists for this event</p>
        <button id="generateQrBtn" class="generate-btn">
          <i class="fas fa-qrcode"></i> Generate QR Code
        </button>
      <?php endif; ?>
    </div>
    
    <button onclick="window.history.back()" class="back-btn">
      <i class="fas fa-arrow-left"></i> Back to Events
    </button>
  </div>

  <!-- Confirmation Modal -->
  <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Action</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="modalMessage">Are you sure you want to delete this QR code?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmAction">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Modal -->
  <div class="modal fade" id="successModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Success</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="successMessage">Operation completed successfully!</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <!-- Popper.js: Helps with positioning popups and tooltips -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
  <!-- Bootstrap.js: Provides ready-made components like modals, buttons, etc. -->

  <script>
    // when the webpage has fully loaded, run this code
    $(document).ready(function() {
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

      // Delete QR Code
      $('#deleteQrBtn').click(function() {
        $('#modalMessage').text('Are you sure you want to delete this QR code?');
        $('#confirmAction').text('Delete').off('click').on('click', function() {
          //when confirm is clicked
          var $btn = $(this);
          $btn.html('<i class="fas fa-spinner fa-spin"></i> Deleting...').prop('disabled', true);
          
          $.ajax({
            url: window.location.href, //Send to current page
            type: 'POST', //Using POST method
            data: { delete_qr: true, event_id: '<?php echo $eventID; ?>' }, //Sending data: instruction to delete QR and the event ID

            success: function(response) {
              try {
                response = typeof response === 'string' ? JSON.parse(response) : response;
                if(response.status === 'success') {
                  $('#successMessage').text(response.message);
                  $('#successModal').modal('show');
                  setTimeout(function() {
                    location.reload();
                  }, 1500); //After 1.5 seconds, refresh the page

                } else {
                  alert('Error: ' + (response.message || 'Operation failed'));
                }
                //handle error
              } catch(e) { // If any error happens in the success block, this part catches error
                console.error('Error:', e, response);
                alert('Error processing response');
              }
              $btn.html('Delete').prop('disabled', false);
              $('#confirmModal').modal('hide');
            },
            error: function(xhr, status, error) {
              // xhr - The XMLHttpRequest object itself. used to interact with servers. You can retrieve data from a URL without having to do a full page refresh
              // status - A string describing the type of error ("timeout", "error", "abort", etc.)
              // error - The error message text
              alert('Request failed: ' + error);
              $btn.html('Delete').prop('disabled', false);
              $('#confirmModal').modal('hide');
            }
          });
        });
        $('#confirmModal').modal('show');
      });

      // Generate/Regenerate QR Code
      $('#generateQrBtn').click(function() {
        $('#modalMessage').text('Generate new QR code for this event?');
        $('#confirmAction').text('Generate').off('click').on('click', function() {
          var $btn = $(this);
          $btn.html('<i class="fas fa-spinner fa-spin"></i> Generating...').prop('disabled', true);
          
          $.ajax({
            url: window.location.href,
            type: 'POST',
            data: { generate_qr: true, event_id: '<?php echo $eventID; ?>' },
            success: function(response) {
              try {
                response = typeof response === 'string' ? JSON.parse(response) : response;
                if(response.status === 'success') {
                  $('#successMessage').text(response.message);
                  $('#successModal').modal('show');
                  if(response.qr_url) {
                    setTimeout(function() {
                      location.reload();
                    }, 1500);
                  }
                } else {
                  alert('Error: ' + (response.message || 'Operation failed'));
                }
              } catch(e) {
                console.error('Error:', e, response);
                alert('Error processing response');
              }
              $btn.html('Generate').prop('disabled', false);
              $('#confirmModal').modal('hide');
            },
            error: function(xhr, status, error) {
              alert('Request failed: ' + error);
              $btn.html('Generate').prop('disabled', false);
              $('#confirmModal').modal('hide');
            }
          });
        });
        $('#confirmModal').modal('show');
      });
    });
  </script>
</body>
</html>