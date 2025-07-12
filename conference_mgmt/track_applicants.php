<?php
session_start();
include 'db.php';

if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Registrations</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="dashboard">
    <h2>Event Applications</h2>
    <table>
        <tr><th>Event</th><th>Applicants</th></tr>
        <?php
        $sql = "SELECT e.title, COUNT(r.id) AS total
                FROM events e
                LEFT JOIN event_registrations r ON e.id = r.event_id
                GROUP BY e.id";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>" . $row['total'] . "</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
