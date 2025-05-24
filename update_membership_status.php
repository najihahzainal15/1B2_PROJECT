<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['action'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'] == 'approve' ? 'approved' : 'rejected';

    $sql = "UPDATE memberships SET status = ? WHERE studentID = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $action, $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: c_membership.php");
            exit;
        } else {
            echo "Something went wrong. Try again later.";
        }
        mysqli_stmt_close($stmt);
    }
}
mysqli_close($link);
?>
