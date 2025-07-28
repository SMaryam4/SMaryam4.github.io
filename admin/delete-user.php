<?php
include('db.php');

// Check if ID is passed
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user record
    $stmt = $conn->prepare("SELECT profile_image FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($profile_image);
        $stmt->fetch();

        // Delete profile image file if exists
        if (!empty($profile_image) && file_exists('../' . $profile_image)) {
            unlink('../' . $profile_image);
        }

        // Delete user record from database
        $deleteStmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $deleteStmt->bind_param("i", $id);
        $deleteStmt->execute();
    }
}

// Redirect back to users list
header("Location: users.php");
exit;

