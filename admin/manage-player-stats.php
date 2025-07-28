<?php
include 'db.php';
session_start();

$player_id = isset($_GET['player_id']) ? (int) $_GET['player_id'] : 0;

if (!$player_id) {
    die("Invalid player ID.");
}

// Fetch player name
$player = $conn->query("SELECT name FROM players WHERE id = $player_id")->fetch_assoc();
if (!$player) {
    die("Player not found.");
}

// ✅ Handle Delete Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_stat_id'])) {
    $stat_id = (int) $_POST['delete_stat_id'];
    $conn->query("DELETE FROM player_stats WHERE id = $stat_id AND player_id = $player_id");
    header("Location: manage-player-stats.php?player_id=$player_id");
    exit;
}

// ✅ Handle Add Stat Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['format'])) {
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

    $stmt = $conn->prepare("INSERT INTO player_stats (
        player_id, format, matches, innings, runs, wickets, strike_rate, average,
        hundreds, fifties, ducks, sixes, fours, highest_score
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("isiiiiddiiiiii",
        $player_id, $format, $matches, $innings, $runs, $wickets,
        $strike_rate, $average, $hundreds, $fifties, $duks, $sixes, $fours, $highest_score
    );

    $stmt->execute();
    $stmt->close();

    header("Location: manage-player-stats.php?player_id=$player_id");
    exit;
}

// ✅ Fetch existing stats
$stats = $conn->query("SELECT * FROM player_stats WHERE player_id = $player_id ORDER BY format");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Player Stats</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
  <h1 class="text-2xl font-bold mb-4">Stats for <?= htmlspecialchars($player['name']) ?></h1>
  <a href="admin-dashboard.php" class="inline-block mb-4 bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">
  ← Back to admin dashboard
</a>


  <!-- Add Stat Form -->
  <form method="POST" class="grid grid-cols-2 gap-4 bg-white p-4 rounded shadow mb-6">
    <input type="text" name="format" placeholder="Format (ODI, Test, T20)" required class="border p-2 rounded" />
    <input type="number" name="matches" placeholder="Matches" required class="border p-2 rounded" />
    <input type="number" name="innings" placeholder="Innings" required class="border p-2 rounded" />
    <input type="number" name="runs" placeholder="Runs" required class="border p-2 rounded" />
    <input type="number" name="wickets" placeholder="Wickets" class="border p-2 rounded" />
    <input type="number" step="0.01" name="strike_rate" placeholder="Strike Rate" class="border p-2 rounded" />
    <input type="number" step="0.01" name="average" placeholder="Average" class="border p-2 rounded" />
    <input type="number" name="hundreds" placeholder="100s" class="border p-2 rounded" />
    <input type="number" name="fifties" placeholder="50s" class="border p-2 rounded" />
    <input type="number" name="ducks" placeholder="Ducks" class="border p-2 rounded" />
    <input type="number" name="sixes" placeholder="Sixes" class="border p-2 rounded" />
    <input type="number" name="fours" placeholder="Fours" class="border p-2 rounded" />
    <input type="number" name="highest_score" placeholder="Highest Score" class="border p-2 rounded" />
    <button class="col-span-2 bg-blue-600 text-white py-2 rounded">Add Stats</button>
  </form>

  <!-- Stats Table -->
  <h2 class="text-xl font-bold mb-2">Existing Stats</h2>
  <table class="w-full bg-white rounded shadow overflow-hidden text-sm">
    <thead class="bg-gray-200">
      <tr>
        <th class="p-2">Format</th>
        <th>Matches</th>
        <th>Innings</th>
        <th>Runs</th>
        <th>Wickets</th>
        <th>SR</th>
        <th>Avg</th>
        <th>100s</th>
        <th>50s</th>
        <th>HS</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($s = $stats->fetch_assoc()): ?>
      <tr class="text-center border-t">
        <td class="p-2"><?= htmlspecialchars($s['format']) ?></td>
        <td><?= $s['matches'] ?></td>
        <td><?= $s['innings'] ?></td>
        <td><?= $s['runs'] ?></td>
        <td><?= $s['wickets'] ?></td>
        <td><?= $s['strike_rate'] ?></td>
        <td><?= $s['average'] ?></td>
        <td><?= $s['hundreds'] ?></td>
        <td><?= $s['fifties'] ?></td>
        <td><?= $s['highest_score'] ?></td>
        <td class="space-x-2">
          <!-- Edit Button -->
          <a href="edit-player-stats.php?id=<?= $s['id'] ?>" class="text-blue-600 underline">Edit</a>
          
          <!-- Delete Form -->
          <form method="POST" onsubmit="return confirm('Are you sure?')" style="display:inline;">
            <input type="hidden" name="delete_stat_id" value="<?= $s['id'] ?>">
            <button class="text-red-600 underline" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
