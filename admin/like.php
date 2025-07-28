<?php
$conn = new mysqli("localhost", "root", "", "pak_cricket");

$post_id = $_POST['post_id'];

$conn->query("INSERT INTO likes (post_id) VALUES ($post_id)");
header("Location: post.php?id=$post_id");
exit;
