<?php
include 'db.php';
session_start();

$stat_id = $_GET['id']; // player_stats table primary key
$stat = $conn->query("SELECT * FROM player_stats WHERE id = $stat_id")->fetch_assoc();

if (!$stat) {
  die("Player stats not found.");
}

$player_id = $stat['player_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $format = $_POST['format'];
    $matches = $_POST['matches'];
    $innings = $_POST['innings'];
    $runs = $_POST['runs'];
    $wickets = $_POST['wickets'];
    $strike_rate = $_POST['strike_rate'];
    $average = $_POST['average'];
    $hundreds = $_POST['hundreds'];
    $fifties = $_POST['fifties'];
    $duks = $_POST['ducks'];
    $sixes = $_POST['sixes'];
    $fours = $_POST['fours'];
    $highest_score = $_POST['highest_score'];

    $stmt = $conn->prepare("UPDATE player_stats SET format = ?, matches = ?, innings = ?, runs = ?, wickets = ?, strike_rate = ?, average = ?, hundreds = ?, fifties = ?, ducks = ?, sixes = ?, fours = ?, highest_score = ? WHERE id = ?");
    $stmt->bind_param("siiiiddiiiiiii", $format, $matches, $innings, $runs, $wickets, $strike_rate, $average, $hundreds, $fifties, $ducks, $sixes, $fours, $highest_score, $stat_id);
    $stmt->execute();

    header("Location: manage-player-stats.php?player_id=$player_id");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Player Stats</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
  <h1 class="text-2xl font-bold mb-4">Edit Stats (<?= htmlspecialchars($stat['format']) ?>)</h1>
  <a href="manage-player-stats.php?player_id=<?= $player_id ?>" class="inline-block mb-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
  ← Back to Player Stats
</a>

  

  <form method="POST" class="grid grid-cols-2 gap-4 bg-white p-4 rounded shadow">
    <input type="text" name="format" value="<?= $stat['format'] ?>" required class="border p-2 rounded" />
    <input type="number" name="matches" value="<?= $stat['matches'] ?>" class="border p-2 rounded" />
    <input type="number" name="innings" value="<?= $stat['innings'] ?>" class="border p-2 rounded" />
    <input type="number" name="runs" value="<?= $stat['runs'] ?>" class="border p-2 rounded" />
    <input type="number" name="wickets" value="<?= $stat['wickets'] ?>" class="border p-2 rounded" />
    <input type="number" step="0.01" name="strike_rate" value="<?= $stat['strike_rate'] ?>" class="border p-2 rounded" />
    <input type="number" step="0.01" name="average" value="<?= $stat['average'] ?>" class="border p-2 rounded" />
    <input type="number" name="hundreds" value="<?= $stat['hundreds'] ?>" class="border p-2 rounded" />
    <input type="number" name="fifties" value="<?= $stat['fifties'] ?>" class="border p-2 rounded" />
    <input type="number" name="ducks" value="<?= $stat['ducks'] ?>" class="border p-2 rounded" />
    <input type="number" name="sixes" value="<?= $stat['sixes'] ?>" class="border p-2 rounded" />
    <input type="number" name="fours" value="<?= $stat['fours'] ?>" class="border p-2 rounded" />
    <input type="number" name="highest_score" value="<?= $stat['highest_score'] ?>" class="border p-2 rounded" />

    <button class="col-span-2 bg-blue-600 text-white py-2 rounded">Update Stats</button>
  </form>
</body>
</html>
