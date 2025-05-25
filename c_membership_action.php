<?php
require_once "config.php"; // Database connection

$link = mysqli_connect("localhost", "root", "", "web_project");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["membership_ID"])) {
        $membership_ID = $_POST["membership_ID"];
        $new_status = isset($_POST["approve"]) ? "APPROVED" : "REJECTED";

        $query = "UPDATE membership SET verification_status = ? WHERE membership_ID = ?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "si", $new_status, $membership_ID);

        if (mysqli_stmt_execute($stmt)) {
            // Redirect back after successful update
            header("Location: c_membership.php");
            exit;
        } else {
            echo "Error updating status.";
        }
    } else {
        echo "Invalid membership ID.";
    }
}
