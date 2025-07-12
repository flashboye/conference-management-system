<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $event_date = $_POST['event_date'];

    $conn->query("UPDATE events SET 
        title = '$title', 
        description = '$description', 
        location = '$location', 
        event_date = '$event_date' 
        WHERE id = $id");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Events</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="dashboard">
    <h2>Update Events</h2>

    <?php
    $result = $conn->query("SELECT * FROM events ORDER BY event_date DESC");
    while ($row = $result->fetch_assoc()) {
        ?>
        <form method="POST" style="margin-bottom: 30px;">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <input type="text" name="title" value="<?php echo htmlspecialchars($row['title']); ?>" required><br>
            <textarea name="description"><?php echo htmlspecialchars($row['description']); ?></textarea><br>
            <input type="text" name="location" value="<?php echo htmlspecialchars($row['location']); ?>" required><br>
            <input type="date" name="event_date" value="<?php echo $row['event_date']; ?>" required><br>
            <button type="submit">Update</button>
        </form>
        <hr>
        <?php
    }
    $conn->close();
    ?>
</div>
</body>
</html>
