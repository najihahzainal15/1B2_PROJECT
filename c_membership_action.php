<?php
session_start();
require_once "config.php"; // Database connection
$link = mysqli_connect("localhost", "root", "", "web_project");

// Get userID from session
$userID = $_SESSION["userID"];

// Retrieve the corresponding coordinatorID from the database
$queryCoordinator = "SELECT coordinatorID FROM petakomcoordinator WHERE userID = ?";
$stmtCoord = mysqli_prepare($link, $queryCoordinator);
mysqli_stmt_bind_param($stmtCoord, "i", $userID);
mysqli_stmt_execute($stmtCoord);
$resultCoord = mysqli_stmt_get_result($stmtCoord);
$rowCoord = mysqli_fetch_assoc($resultCoord);
$coordinatorID = $rowCoord["coordinatorID"] ?? null; // Ensure it's retrieved correctly

if (isset($_POST["approve"])) {
    $membershipID = $_POST["membership_ID"];

    if ($coordinatorID) { // Ensure we retrieved a valid coordinatorID
        $query = "UPDATE membership SET verification_status = 'Approved', coordinatorID = ? WHERE membership_ID = ?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "si", $coordinatorID, $membershipID);

        if ($stmt->execute()) {
            echo "<script>alert('Membership approved successfully'); window.location.href='c_membership.php';</script>";
        } else {
            echo "<script>alert('Error approving membership'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error: Coordinator ID not found'); window.history.back();</script>";
    }
}

if (isset($_POST["reject"])) {
    $membershipID = $_POST["membership_ID"];

    if ($coordinatorID) {
        $query = "UPDATE membership SET verification_status = 'Rejected', coordinatorID = ? WHERE membership_ID = ?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "si", $coordinatorID, $membershipID);

        if ($stmt->execute()) {
            echo "<script>alert('Membership rejected successfully'); window.location.href='c_membership.php';</script>";
        } else {
            echo "<script>alert('Error rejecting membership'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error: Coordinator ID not found'); window.history.back();</script>";
    }
}
