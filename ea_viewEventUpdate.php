<?php
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

$idURL = $_GET['id'];

$query = "SELECT * FROM event WHERE eventID = '$idURL'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

$eventID = htmlspecialchars($row["eventID"]);
$eventName = htmlspecialchars($row["eventName"]);
$date = htmlspecialchars($row["eventDate"]);
$status = htmlspecialchars($row["status"]);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Update Event Status</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f8ff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    form {
      background-color: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.15);
      width: 400px;
    }

    h2 {
      text-align: center;
      color: #0074e4;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
    }

    select, input[type="submit"], input[type="reset"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    input[type="submit"] {
      background-color: #0074e4;
      color: white;
      font-weight: bold;
      cursor: pointer;
      border: none;
    }

    input[type="submit"]:hover {
      background-color: #005bb5;
    }

    input[type="reset"] {
      background-color: #ccc;
      font-weight: bold;
    }

    input[type="reset"]:hover {
      background-color: #aaa;
    }
  </style>
</head>
<body>

<form method="post" action="ea_viewEventUpdate2.php">
  <h2>Update Event Status</h2>

  <label for="status">Status:</label>
  <select name="status" id="status" required>
    <option value="ACTIVE" <?php if($status == 'ACTIVE') echo 'selected'; ?>>ACTIVE</option>
    <option value="CANCELED" <?php if($status == 'CANCELED') echo 'selected'; ?>>CANCELED</option>
    <option value="POSTPONE" <?php if($status == 'POSTPONE') echo 'selected'; ?>>POSTPONE</option>
  </select>

  <input type="hidden" name="id2" value="<?php echo $eventID; ?>">

  <input type="submit" value="Update">
  <input type="reset" value="Cancel">
</form>

</body>
</html>
