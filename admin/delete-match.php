<?php
include('db.php');
$id = $_GET['id'];
$conn->query("DELETE FROM schedule WHERE id = $id");
header("Location: match-list.php");
exit();
?>
