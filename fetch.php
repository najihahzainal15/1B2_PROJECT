<?php
// fetch.php
include 'db_connection.php';

$sql = "SELECT 
    committee.committeeRole, 
    event.eventName, 
    event.eventDate, 
    event.eventLocation, 
    event.status
FROM event
JOIN committee ON event.eventID = committee.eventID
JOIN student ON student.studentID = committee.studentID";

       

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Event Committee</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #666;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Registered Users and Events</h2>
    <table>
        <tr>
            <th>Role</th>
            <th>Event</th>
            <th>Date</th>
            <th>Location</th>
            <th>Status</th>
        </tr>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['committeeRole']); ?></td>
                    <td><?php echo htmlspecialchars($row['eventName']); ?></td>
                    <td><?php echo htmlspecialchars($row['eventDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['eventLocation']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">No records found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
