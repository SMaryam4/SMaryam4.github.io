<?php
$conn = new mysqli("localhost", "root", "", "pak_cricket");

$post_id = $_POST['post_id'];
$comment = $_POST['comment'];

$conn->query("INSERT INTO comments (post_id, comment) VALUES ($post_id, '$comment')");
header("Location: post.php?id=$post_id");
exit;
