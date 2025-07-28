<?php
include 'db.php';

$query = "SELECT ps.*, pp.name AS player_name FROM player_stats ps JOIN psl_players pp ON ps.player_id = pp.id";
$stats = $conn->query($query);

if (!$stats) {
    die("Query Failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage PSL Player Stats</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

  <a href="admin-dashboard.php" class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded">🔙 Back to Dashboard</a>
  <a href="add-psl-stats.php" class="mb-4 inline-block bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded float-right">➕ Add Stat</a>

  <h1 class="text-2xl font-bold mb-6 clear-both">Manage PSL Player Stats</h1>

  <table class="w-full bg-white shadow-md rounded border text-sm">
    <thead class="bg-gray-200">
      <tr>
        <th class="p-2 border">Player</th>
        <th class="p-2 border">Matches</th>
        <th class="p-2 border">Runs</th>
        <th class="p-2 border">Wickets</th>
        <th class="p-2 border">SR</th>
        <th class="p-2 border">Avg</th>
        <th class="p-2 border">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $stats->fetch_assoc()): ?>
      <tr class="text-center border">
        <td class="p-2 border"><?= htmlspecialchars($row['player_name']) ?></td>
        <td class="p-2 border"><?= htmlspecialchars($row['matches']) ?></td>
        <td class="p-2 border"><?= htmlspecialchars($row['runs']) ?></td>
        <td class="p-2 border"><?= htmlspecialchars($row['wickets']) ?></td>
        <td class="p-2 border"><?= htmlspecialchars($row['strike_rate']) ?></td>
        <td class="p-2 border"><?= htmlspecialchars($row['average']) ?></td>
        <td class="p-2 border">
          <a href="edit-psl-stats.php?id=<?= $row['id'] ?>" class="text-blue-600 font-medium hover:underline">Edit</a> |
          <a href="delete-psl-stats.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="text-red-600 font-medium hover:underline">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
