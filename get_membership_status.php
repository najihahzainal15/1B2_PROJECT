<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "web_project") or die(mysqli_connect_error());

if (!isset($_SESSION['userID'])) {
    echo json_encode(["status" => "Error"]);
    exit();
}

$userID = $_SESSION['userID'];

// Get student ID
$queryStudent = "SELECT studentID FROM student WHERE userID = ?";
$stmtStudent = mysqli_prepare($link, $queryStudent);
mysqli_stmt_bind_param($stmtStudent, "i", $userID);
mysqli_stmt_execute($stmtStudent);
$resultStudent = mysqli_stmt_get_result($stmtStudent);
$studentData = mysqli_fetch_assoc($resultStudent);
$studentID = $studentData["studentID"] ?? null;

$status = "PENDING"; // Default status

if ($studentID) {
    $queryMembership = "SELECT verification_status FROM membership WHERE studentID = ?";
    $stmtMembership = mysqli_prepare($link, $queryMembership);
    mysqli_stmt_bind_param($stmtMembership, "s", $studentID);
    mysqli_stmt_execute($stmtMembership);
    $resultMembership = mysqli_stmt_get_result($stmtMembership);

    if ($membershipData = mysqli_fetch_assoc($resultMembership)) {
        $status = $membershipData["verification_status"];
    }
}

echo json_encode(["status" => $status]);
