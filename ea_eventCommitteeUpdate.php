 <?php
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

$idURL = $_GET['id'];  // Get committeeID from URL

// Get current committee info with role name
$query = "
    SELECT committee.*, committeerole.committeeRole, committee.roleID 
    FROM committee 
    JOIN committeerole ON committee.roleID = committeerole.roleID 
    WHERE committee.committeeID = '$idURL'
";

$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

$commID = htmlspecialchars($row["committeeID"]);
$eventID = htmlspecialchars($row["eventID"]);
$currentRoleID = htmlspecialchars($row["roleID"]);
$studentID = htmlspecialchars($row["studentID"]);

// Fetch all roles for dropdown
$rolesQuery = "SELECT * FROM committeerole";
$rolesResult = mysqli_query($link, $rolesQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Committee Role</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            min-width: 300px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        select, input[type="submit"], input[type="reset"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color:#0074e4; 
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="reset"] {
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #005bb5;
        }

        input[type="reset"]:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
<form method="post" action="ea_eventCommitteeUpdate2.php">
    <label for="roleID">Role:</label>
    <select name="roleID" id="roleID" required>
        <?php while ($roleRow = mysqli_fetch_assoc($rolesResult)) { ?>
            <option value="<?php echo $roleRow['roleID']; ?>" 
                <?php if ($roleRow['roleID'] == $currentRoleID) echo 'selected'; ?>>
                <?php echo htmlspecialchars($roleRow['committeeRole']); ?>
            </option>
        <?php } ?>
    </select>
    <input type="hidden" name="id2" value="<?php echo $commID; ?>">
    <input type="submit" value="Update">
    <input type="reset" value="Cancel">
</form>
</body>
</html>
