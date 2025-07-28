<?php
include 'db.php';
session_start();

$id = $_GET['id'];
$conn->query("DELETE FROM player_stats WHERE player_id = $id");
$conn->query("DELETE FROM players WHERE id = $id");

header("Location: players.php");
exit;
