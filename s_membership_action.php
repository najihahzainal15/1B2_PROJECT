<?php
session_start();

if (!isset($_SESSION['userID'])) {
	header("Location: login_page.php");
	exit();
}

$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());
$userID = $_SESSION['userID'];

// Get studentID from student table
$queryStudent = "SELECT studentID FROM student WHERE userID = ?";
$stmtStudent = mysqli_prepare($link, $queryStudent);
mysqli_stmt_bind_param($stmtStudent, "i", $userID);
mysqli_stmt_execute($stmtStudent);
$resultStudent = mysqli_stmt_get_result($stmtStudent);
$studentData = mysqli_fetch_assoc($resultStudent);
$studentID = $studentData['studentID'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['student_card_upload'])) {
	$file = $_FILES['student_card_upload'];
	$fileName = basename($file['name']);
	$fileTmp = $file['tmp_name'];
	$fileSize = $file['size'];
	$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
	$allowed = ['jpg', 'jpeg', 'png'];

	if (!in_array($fileExt, $allowed)) {
		echo "Invalid file type. Only JPG, JPEG, or PNG allowed.";
		exit();
	}

	if ($fileSize > 5 * 1024 * 1024) {
		echo "File too large. Max 5MB allowed.";
		exit();
	}

	$uploadDir = "uploads/";
	if (!is_dir($uploadDir)) {
		mkdir($uploadDir, 0755, true);
	}

	$newFileName = "student_card_upload" . $studentID . "." . $fileExt;
	$uploadPath = $uploadDir . $newFileName;

	if (move_uploaded_file($fileTmp, $uploadPath)) {
		// Update student table with student card path
		$updateQuery = "UPDATE student SET student_card_upload = ? WHERE studentID = ?";
		$stmtUpdate = mysqli_prepare($link, $updateQuery);
		mysqli_stmt_bind_param($stmtUpdate, "ss", $uploadPath, $studentID);
		mysqli_stmt_execute($stmtUpdate);

		// Check if membership record exists for this studentID
		$checkQuery = "SELECT membership_ID FROM membership WHERE studentID = ?";
		$stmtCheck = mysqli_prepare($link, $checkQuery);
		mysqli_stmt_bind_param($stmtCheck, "s", $studentID);
		mysqli_stmt_execute($stmtCheck);
		$resultCheck = mysqli_stmt_get_result($stmtCheck);

		if (mysqli_num_rows($resultCheck) === 0) {
			// Insert into membership table with studentID and set status as 'Pending'
			$insertQuery = "INSERT INTO membership (studentID, verification_status) VALUES (?, 'PENDING')";
			$stmtInsert = mysqli_prepare($link, $insertQuery);
			mysqli_stmt_bind_param($stmtInsert, "s", $studentID);
			mysqli_stmt_execute($stmtInsert);
		} else {
			// If membership record exists, ensure status updates to 'Pending'
			$updateMembershipQuery = "UPDATE membership SET verification_status = 'PENDING' WHERE studentID = ?";
			$stmtMembershipUpdate = mysqli_prepare($link, $updateMembershipQuery);
			mysqli_stmt_bind_param($stmtMembershipUpdate, "s", $studentID);
			mysqli_stmt_execute($stmtMembershipUpdate);
		}

		// Redirect with a success message
		header("Location: s_membership.php?upload=success");
		exit();
	} else {
		header("Location: s_membership.php?upload=failed");
		exit();
	}
} else {
	echo "No file uploaded.";
}
