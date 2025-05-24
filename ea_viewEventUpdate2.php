<?php
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

$status = $_POST["status"];
$pid2 = $_POST["id2"];

$query = "UPDATE event SET status = '$status' WHERE eventID = '$pid2'";

$result = mysqli_query($link, $query) or die("Could not execute query in update.");

if($result){
    header("Location: ea_viewEvent.php");  // redirect to your main committee page
    exit();
}
?>
