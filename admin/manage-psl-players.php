<?php
include 'db.php';

// Handle delete
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $conn->query("DELETE FROM psl_players WHERE id = $id");
  header("Location: manage-psl-players.php");
  exit();
}

// Get players
$players = $conn->query("
  SELECT p.*, t.name AS team_name 
  FROM psl_players p 
  LEFT JOIN psl_teams t ON p.team_id = t.id
  ORDER BY p.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Manage PSL Players</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Manage PSL Players</h1>
    <a href="add-psl-player.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-4 inline-block">➕ Add New Player</a>
    <table class="w-full table-auto bg-white shadow rounded overflow-hidden">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-2">#</th>
          <th class="p-2">Name</th>
          <th class="p-2">Team</th>
          <th class="p-2">Role</th>
          <th class="p-2">Nationality</th>
          <th class="p-2">Image</th>
          <th class="p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $players->fetch_assoc()): ?>
          <tr class="border-t">
            <td class="p-2"><?= $row['id'] ?></td>
            <td class="p-2"><?= $row['name'] ?></td>
            <td class="p-2"><?= $row['team_name'] ?></td>
            <td class="p-2"><?= $row['role'] ?></td>
            <td class="p-2"><?= $row['nationality'] ?></td>
            <td class="p-2"><img src="../images/<?= $row['image'] ?>" alt="" class="h-12 w-12 rounded-full object-cover"></td>
            <td class="p-2">
              <a href="edit-psl-player.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
              <a href="?delete=<?= $row['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Delete this player?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <a href="admin-dashboard.php" class="inline-block mt-6 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">🔙 Back to Dashboard</a>
  </div>
</body>
</html>
