<?php
	session_start();

	if (!isset($_SESSION['userID'])) {
		header("Location: login_page.php");
		exit();
	}

	$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());

	$userID = $_SESSION['userID'];

	// Sanitize input
	$advisorID = trim($_POST['eventAdvisorID']);
	$phone = trim($_POST['phone_No']);
	$expertise = trim($_POST['expertiseArea']);
	$currpass = $_POST['currpass'] ?? '';
	$newpass = $_POST['npass'] ?? '';
	$conpass = $_POST['conpass'] ?? '';

	// Update phone number
	$updateUserQuery = "UPDATE user SET phone_No = ? WHERE userID = ?";
	$stmtUser = mysqli_prepare($link, $updateUserQuery);
	mysqli_stmt_bind_param($stmtUser, "si", $phone, $userID);
	mysqli_stmt_execute($stmtUser);

	// Update programme and year_of_study in student table
	$updateAdvisorQuery = "UPDATE eventadvisor SET eventAdvisorID = ?, expertiseArea = ? WHERE userID = ?";
	$stmtAdvisor = mysqli_prepare($link, $updateAdvisorQuery);
	mysqli_stmt_bind_param($stmtAdvisor, "ssi", $advisorID, $expertise, $userID);
	mysqli_stmt_execute($stmtAdvisor);

	// Handle password change
	if (!empty($currpass) && !empty($newpass) && !empty($conpass)) {
		// Get current password from database
		$getPasswordQuery = "SELECT password FROM user WHERE userID = ?";
		$stmtPass = mysqli_prepare($link, $getPasswordQuery);
		mysqli_stmt_bind_param($stmtPass, "i", $userID);
		mysqli_stmt_execute($stmtPass);
		$result = mysqli_stmt_get_result($stmtPass);
		$row = mysqli_fetch_assoc($result);
		$storedPass = $row['password'];

		if ($currpass !== $storedPass) {
			echo "<script>alert('Current password is incorrect.'); window.history.back();</script>";
			exit();
		} elseif ($newpass !== $conpass) {
			echo "<script>alert('New password and confirm password do not match.'); window.history.back();</script>";
			exit();
		} else {
			$updatePassQuery = "UPDATE user SET password = ? WHERE userID = ?";
			$stmtUpdatePass = mysqli_prepare($link, $updatePassQuery);
			mysqli_stmt_bind_param($stmtUpdatePass, "si", $newpass, $userID);
			mysqli_stmt_execute($stmtUpdatePass);
		}
	}

	echo "<script>alert('Profile updated successfully.'); window.location.href = 'ea_displayProfile.php';</script>";
	exit();
?>
