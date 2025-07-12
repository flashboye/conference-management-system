<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$event_id = intval($_POST['event_id']);

$sql = "INSERT IGNORE INTO event_registrations (user_id, event_id) VALUES ($user_id, $event_id)";
if ($conn->query($sql)) {
    $status = "success";
} else {
    $status = "failed";
}
$referer = $_SERVER['HTTP_REFERER'];
header("Location: {$referer}?apply_status={$status}");
exit;

