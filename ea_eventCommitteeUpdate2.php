<?php
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

$role = $_POST["role"];
$pid2 = $_POST["id2"];

$query = "UPDATE committee SET committeeRole = '$role' WHERE committeeID = '$pid2'";

$result = mysqli_query($link, $query) or die("Could not execute query in update.");

if($result){
    header("Location: ea_eventCommittee.php");  // redirect to your main committee page
    exit();
}
?>
