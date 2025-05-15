<?php
// Initialize the session
session_start();
require_once "config.php";

// 1) Must be logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login_page.php");
    exit;
}

// 2) Redirect based on exact role strings (lowercase)
switch ($_SESSION["role"]) {
    case "Student":
        header("Location: s_homepage.php");
        exit;
    case "Coordinator":
        header("Location: c_homepage.php");
        exit;
    case "Event Advisor":
        header("Location: ea_homepage.php");
        exit;
    default:
        // Unexpected role → logout or back to login
        session_destroy();
        header("Location: login_page.php");
        exit;
}
?>
