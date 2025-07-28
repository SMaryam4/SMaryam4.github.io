<?php
session_start();
include("db.php");

// Redirect to login if admin is not logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Validate and sanitize ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: manage-news.php?error=invalid_id");
    exit;
}

$id = (int)$_GET['id'];

// Use prepared statement for security
$stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: manage-news.php?success=deleted");
    exit;
} else {
    $stmt->close();
    header("Location: manage-news.php?error=delete_failed");
    exit;
}
?>
