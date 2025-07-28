<?php
$conn = new mysqli("localhost", "root", "", "pak_cricket");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    $conn->query("DELETE FROM blog_posts WHERE id = $id");
}

header("Location: blog_admin.php");
exit;
