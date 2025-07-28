<?php
include 'db.php';
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$players = $conn->query("SELECT * FROM players ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Players</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto mt-6 text-right">
  <a href="admin-dashboard.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded">
    🔙 Back to Admin Dashboard
  </a>
</div>

  <h1 class="text-3xl font-bold mb-6">Manage Players</h1>


  <a href="add-player.php" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Add Player</a>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <?php while($player = $players->fetch_assoc()): ?>
      <div class="bg-white p-4 rounded shadow">
        <div class="flex items-center space-x-4">
          <img src="../images/<?= $player['image'] ?>" class="w-16 h-16 rounded-full" />
          <div>
            <h2 class="font-bold text-lg"><?= htmlspecialchars($player['name']) ?></h2>
            <p><?= $player['role'] ?> - <?= $player['team'] ?></p>
          </div>
        </div>
        <div class="mt-4 space-x-2">
          <a href="edit-player.php?id=<?= $player['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
          <a href="delete-player.php?id=<?= $player['id'] ?>" onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline">Delete</a>
          <a href="manage-player-stats.php?player_id=<?= $player['id'] ?>" class="text-green-600 hover:underline">Manage Stats</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
