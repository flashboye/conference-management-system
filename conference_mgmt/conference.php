<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Conferences</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="dashboard">
    <h2>Conference Events</h2>

    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
        <form action="event_form.php" method="POST">
            <input type="hidden" name="event_type" value="conference">
            <input type="text" name="title" placeholder="Title" required><br>
            <textarea name="description" placeholder="Description"></textarea><br>
            <input type="text" name="location" placeholder="Location" required><br>
            <input type="date" name="event_date" required><br>
            <button type="submit">Add Conference</button>
        </form>
        <hr>
    <?php endif; ?>

    <h3>Upcoming Conferences</h3>
    <?php
    if (isset($_GET['apply_status']) && $_GET['apply_status'] === 'success') {
        echo "<p style='color: green;'>✔ Application submitted successfully.</p>";
    } elseif (isset($_GET['apply_status']) && $_GET['apply_status'] === 'failed') {
        echo "<p style='color: red;'>✖ You have already applied for this event.</p>";
    }
    ?>



    <?php
    $result = $conn->query("SELECT * FROM events WHERE event_type='conference' ORDER BY event_date ASC");

    while ($row = $result->fetch_assoc()) {
        echo "<div class='event-card'>";
        echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
        echo "<p><strong>Date:</strong> " . $row['event_date'] . "</p>";
        echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
        echo "<p>" . nl2br(htmlspecialchars($row['description'])) . "</p>";

        if ($_SESSION['user']['role'] === 'admin') {
            echo "<form action='delete_event.php' method='POST' onsubmit=\"return confirm('Are you sure you want to delete this event?')\">";
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<button type='submit' style='background:red;color:white;'>Delete</button>";
            echo "</form>";

            echo "<form action='edit_event.php' method='GET'>";
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "<button type='submit'>Edit</button>";
            echo "</form>";
        }
        if ($_SESSION['user']['role'] === 'user') {
            echo "<form action='apply_event.php' method='POST'>";
            echo "<input type='hidden' name='event_id' value='" . $row['id'] . "'>";
            echo "<button type='submit'>Apply</button>";
            echo "</form>";
        }


        echo "</div>";
    }

    $conn->close();
    ?>
</div>
</body>
</html>
