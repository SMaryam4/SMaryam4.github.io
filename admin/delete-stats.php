<?php
include 'db.php';
session_start();

$stat_id = $_GET['id'];
$player_id = $_GET['player_id'];

$conn->query("DELETE FROM player_stats WHERE id = $stat_id");

header("Location: manage-player-stats.php?player_id=$player_id");
exit;
