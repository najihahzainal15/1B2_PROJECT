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
    // Update student table
    $updateQuery = "UPDATE student SET student_card_upload  = ? WHERE studentID = ?";
    $stmtUpdate = mysqli_prepare($link, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, "si", $uploadPath, $studentID);
    mysqli_stmt_execute($stmtUpdate);

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
?>
