<?php
session_start();
include 'db.php';

if ($_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $location = $_POST['location'];
    $event_date = $_POST['event_date'];
    $event_type = $_POST['event_type'];

    $sql = "INSERT INTO events (title, description, location, event_date, event_type)
            VALUES ('$title', '$desc', '$location', '$event_date', '$event_type')";

    if ($conn->query($sql)) {
        header("Location: {$event_type}.php?success=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
