<?php
session_start();

if (!isset($_SESSION['userID'])) {
    header("Location: login_page.php");
    exit();
}

$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());

$userID = $_SESSION['userID'];

// Sanitize input
$cID = trim($_POST['coordinatorID']);
$phone = trim($_POST['phone_No']);
$cYearService = $_POST["year_of_service"] ?? '';
$currpass = $_POST['currpass'] ?? '';
$newpass = $_POST['npass'] ?? '';
$conpass = $_POST['conpass'] ?? '';


// Update phone number
$updateUserQuery = "UPDATE user SET phone_No = ? WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $updateUserQuery);
mysqli_stmt_bind_param($stmtUser, "si", $phone, $userID);
mysqli_stmt_execute($stmtUser);

// Update coordinatorID and year_of_service in coordinator table
$updateCoordinatorQuery = "UPDATE petakomcoordinator SET coordinatorID = ?, year_of_service = ? WHERE userID = ?";
$stmtCoordinator = mysqli_prepare($link, $updateCoordinatorQuery);
mysqli_stmt_bind_param($stmtCoordinator, "sii", $cID, $cYearService, $userID);
mysqli_stmt_execute($stmtCoordinator);

// Handle password change securely
if (!empty($currpass) && !empty($newpass) && !empty($conpass)) {
    // Get hashed password from database
    $getPasswordQuery = "SELECT password FROM user WHERE userID = ?";
    $stmtPass = mysqli_prepare($link, $getPasswordQuery);
    mysqli_stmt_bind_param($stmtPass, "i", $userID);
    mysqli_stmt_execute($stmtPass);
    $result = mysqli_stmt_get_result($stmtPass);
    $row = mysqli_fetch_assoc($result);
    $storedPass = $row['password'];

    // Verify current password against hashed password in database
    if (!password_verify($currpass, $storedPass)) {
        echo "<script>alert('Current password is incorrect.'); window.history.back();</script>";
        exit();
    } elseif ($newpass !== $conpass) {
        echo "<script>alert('New password and confirm password do not match.'); window.history.back();</script>";
        exit();
    } else {
        // Hash the new password before storing it
        $hashedPassword = password_hash($newpass, PASSWORD_DEFAULT);

        $updatePassQuery = "UPDATE user SET password = ? WHERE userID = ?";
        $stmtUpdatePass = mysqli_prepare($link, $updatePassQuery);
        mysqli_stmt_bind_param($stmtUpdatePass, "si", $hashedPassword, $userID);
        mysqli_stmt_execute($stmtUpdatePass);
    }
}


echo "<script>alert('Profile updated successfully.'); window.location.href = 'c_displayProfile.php';</script>";
exit();
