<?php
session_start();
require_once "config.php";

// Initialize variables
$eventName = $eventDate = $qrData = $qrUrl = '';
$eventID = '';
$successMessage = $errorMessage = '';

// Handle QR code storage if this is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eventID']) && isset($_POST['qrData'])) {
    $eventID = mysqli_real_escape_string($link, $_POST['eventID']);
    $qrData = mysqli_real_escape_string($link, $_POST['qrData']);
    
    // Validate input
    if (empty($eventID) || empty($qrData)) {
        die("ERROR: Missing required data");
    }

    // Check if slot already exists for this event
    $checkSql = "SELECT slot_ID FROM attendanceslot WHERE eventID = '$eventID'";
    $checkResult = mysqli_query($link, $checkSql);

    if (!$checkResult) {
        die("Database error: " . mysqli_error($link));
    }

    if (mysqli_num_rows($checkResult) > 0) {
        die("ERROR: QR code already exists for this event");
    }

    // Insert into attendanceslot table
    $insertSql = "INSERT INTO attendanceslot (attendance_QRcode, eventID) VALUES ('$qrData', '$eventID')";

    if (mysqli_query($link, $insertSql)) {
        echo "success";
        exit;
    } else {
        echo "ERROR: Could not create QR code slot: " . mysqli_error($link);
        exit;
    }
}

// Get event details from URL (for GET requests)
if (isset($_GET['event']) && isset($_GET['date']) && isset($_GET['event_id'])) {
    $eventName = mysqli_real_escape_string($link, $_GET['event']);
    $eventDate = mysqli_real_escape_string($link, $_GET['date']);
    $eventID = mysqli_real_escape_string($link, $_GET['event_id']);
    
    // Generate unique QR code data
    $qrData = "EVENT_ID:" . $eventID . "_" . uniqid();
    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qrData);
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
      color: white;
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
    
    .content {
      padding: 20px;
      max-width: 800px;
      margin: 0 auto;
      text-align: center;
    }
    
    .qr-container {
      background-color: white;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      margin-top: 30px;
    }
    
    .qr-code {
      margin: 20px auto;
      max-width: 300px;
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
    
    .back-btn {
      background-color: #0074e4;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      display: inline-block;
      margin-top: 20px;
      cursor: pointer;
      font-family: 'Poppins', sans-serif;
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
    .release-btn {
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
    .download-btn:hover {
      background-color: #3e8e41;
    }
  </style>
</head>
<body>
  <div class="header1">
    <div class="header-center">
      <h2>Attendance QR Code</h2>
      <p>Event Advisor: Prof. Hakeem</p>
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
        <div class="event-date">Date: <?php echo htmlspecialchars($eventDate); ?></div>
      </div>
      
      <?php if(!empty($qrUrl)): ?>
        <img src="<?php echo $qrUrl; ?>" alt="Event QR Code" class="qr-code">
        <br>
        <button id="releaseBtn" class="release-btn">Release QR Code</button>
        <a href="<?php echo $qrUrl; ?>&download=1" class="download-btn">Download QR Code</a>
      <?php else: ?>
        <p>No event data provided. Please go back and select an event.</p>
      <?php endif; ?>
    </div>
    
    <button onclick="window.history.back()" class="back-btn">Back to Events</button>
  </div>

  <!-- Success Modal -->
  <div id="successModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Success</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>QR Code released successfully!</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function() {
      // Release QR Code button click handler
      $('#releaseBtn').click(function() {
        // Show loading state
        var $btn = $(this);
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Releasing...').prop('disabled', true);
        
        // AJAX call to store QR code
        $.ajax({
          url: window.location.href, // Post to the same file
          type: 'POST',
          data: {
            eventID: '<?php echo $eventID; ?>',
            qrData: '<?php echo $qrData; ?>'
          },
          success: function(response) {
            if(response === "success") {
              $('#successModal').modal('show');
            } else {
              alert('Error: ' + response);
            }
            $btn.html('Release QR Code').prop('disabled', false);
          },
          error: function(xhr, status, error) {
            alert('Error: ' + error);
            $btn.html('Release QR Code').prop('disabled', false);
          }
        });
      });
    });
  </script>
</body>
</html>
