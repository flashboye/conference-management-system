<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($id !== $_SESSION['user']['id']) { // Prevent deleting self
        $conn->query("DELETE FROM users WHERE id = $id");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="dashboard">
    <h2>Manage Users</h2>

    <table>
        <tr>
            <th>ID</th><th>Username</th><th>Role</th><th>Action</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM users");

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>{$row['role']}</td>";
            echo "<td>";
            if ($row['id'] !== $_SESSION['user']['id']) {
                echo "<a href='?delete={$row['id']}' style='color:red;'>Delete</a>";
            } else {
                echo "You";
            }
            echo "</td>";
            echo "</tr>";
        }

        $conn->close();
        ?>
    </table>
</div>
</body>
</html>
