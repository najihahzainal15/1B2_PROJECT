<?php
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

$roleID = $_POST["roleID"];  // from <select name="roleID">
$committeeID = $_POST["id2"];  // from hidden input

// Update the committee's role
$query = "UPDATE committee SET roleID = '$roleID' WHERE committeeID = '$committeeID'";

$result = mysqli_query($link, $query) or die("Could not execute query in update.");

if ($result) {
    header("Location: ea_eventCommittee.php");
    exit();
}
?>
