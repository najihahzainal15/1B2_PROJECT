
<?php
$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());

if (isset($_GET['eventID'])) {
    $eventID = $_GET['eventID'];

    // Get event data
    $query = "SELECT * FROM event WHERE eventID = '$eventID'";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        die("Event not found.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newStatus = $_POST['meritStatus'];

    $updateQuery = "UPDATE event SET meritStatus = '$newStatus' WHERE eventID = '$eventID'";
    if (mysqli_query($link, $updateQuery)) {
        echo "<script>alert('Status updated successfully.');window.location.href='c_meritApp.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Merit Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Update Merit Application Status</h2>

        <label for="meritStatus">Status:</label>
        <select name="meritStatus" id="meritStatus" required>
            <option value="Pending" <?php if ($row['meritStatus'] == "Pending") echo "selected"; ?>>Pending</option>
            <option value="Approved" <?php if ($row['meritStatus'] == "Approved") echo "selected"; ?>>Approved</option>
            <option value="Rejected" <?php if ($row['meritStatus'] == "Rejected") echo "selected"; ?>>Rejected</option>
        </select>

        <input type="submit" value="Update Status">
    </form>
</body>
</html>
