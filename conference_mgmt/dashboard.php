<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Conference Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="dashboard">
    <h2>Welcome, <?php echo ucfirst($user['username']); ?>!</h2>

    <div class="card-grid">
        <a href="conference.php" class="card">Conferences</a>
        <a href="seminar.php" class="card">Seminars</a>
        <a href="exhibition.php" class="card">Exhibitions</a>

        <?php if ($user['role'] === 'admin'): ?>
            <a href="manage_users.php" class="card">Manage Users</a>
            <a href="update_content.php" class="card">Update Content</a>
            <a href="track_applicants.php" class="card">Track Applicants</a>
        <?php endif; ?>
        

    </div>
</div>

</body>
</html>
