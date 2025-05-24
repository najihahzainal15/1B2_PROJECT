<?php
// Connect to the database
$link = mysqli_connect("localhost", "root", "") or die(mysqli_connect_error());
mysqli_select_db($link, "web_project") or die(mysqli_error($link));

// Get the ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
	 echo "Deleting ID: $id"; 

    // Create the DELETE query
    $query = "DELETE FROM event WHERE eventID = '$id'";

    // Execute the query
    $result = mysqli_query($link, $query);

    if ($result) {
        echo "<script>alert('Record deleted successfully'); window.location='ea_viewEvent.php';</script>";
    } else {
        echo "Delete failed: " . mysqli_error($link);
    }
} else {
    echo "No ID provided to delete.";
}

// Close connection
mysqli_close($link);
?>
