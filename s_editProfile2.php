<?php
session_start();

if (!isset($_SESSION['userID'])) {
	header("Location: login_page.php");
	exit();
}

$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());

$userID = $_SESSION['userID'];

// Sanitize input
$sID = trim($_POST['studentID']);
$phone = trim($_POST['phone_No']);
$programme = trim($_POST['programme']);
$year = trim($_POST['year_of_study']);
$currpass = $_POST['currpass'] ?? '';
$newpass = $_POST['npass'] ?? '';
$conpass = $_POST['conpass'] ?? '';

// Update phone number
$updateUserQuery = "UPDATE user SET phone_No = ? WHERE userID = ?";
$stmtUser = mysqli_prepare($link, $updateUserQuery);
mysqli_stmt_bind_param($stmtUser, "si", $phone, $userID);
mysqli_stmt_execute($stmtUser);

// Update programme and year_of_study in student table
$updateStudentQuery = "UPDATE student SET studentID = ?, programme = ?, year_of_study = ? WHERE userID = ?";
$stmtStudent = mysqli_prepare($link, $updateStudentQuery);
mysqli_stmt_bind_param($stmtStudent, "ssii", $sID, $programme, $year, $userID);
mysqli_stmt_execute($stmtStudent);

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


echo "<script>alert('Profile updated successfully.'); window.location.href = 's_displayProfile.php';</script>";
exit();
