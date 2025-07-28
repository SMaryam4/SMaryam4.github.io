<?php
include 'db.php';
$teams = $conn->query("SELECT * FROM psl_teams");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Manage PSL Teams</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">

<!-- Back to Dashboard Button -->
<a href="admin-dashboard.php" class="mb-4 inline-block text-sm bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded">
  🔙 Back to Admin Dashboard
</a>

<!-- Add Team Button -->
<a href="add-psl-team.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded inline-block mb-4 ml-4">
  ➕ Add Team
</a>

<!-- Alerts -->
<?php if (isset($_GET['success'])): ?>
  <div class="bg-green-100 text-green-800 p-2 rounded mb-4">✅ Team added successfully!</div>
<?php elseif (isset($_GET['deleted'])): ?>
  <div class="bg-red-100 text-red-800 p-2 rounded mb-4">🗑️ Team deleted successfully!</div>
<?php endif; ?>

<h1 class="text-2xl font-bold mb-4">PSL Teams</h1>

<!-- Teams Table -->
<table class="w-full bg-white shadow-md rounded border border-gray-300">
  <thead class="bg-gray-100">
    <tr class="text-left text-gray-700 font-semibold">
      <th class="p-3">Logo</th>
      <th class="p-3">Team Name</th>
      <th class="p-3">Page Link</th>
      <th class="p-3">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while($row = $teams->fetch_assoc()): ?>
    <tr class="border-t hover:bg-gray-50">
      <td class="p-3">
        <?php if (!empty($row['logo']) && file_exists("images/" . $row['logo'])): ?>
          <img src="images/<?= $row['logo'] ?>" alt="logo" class="h-10 w-auto">
        <?php else: ?>
          <span class="text-gray-400 italic">No logo</span>
        <?php endif; ?>
      </td>
      <td class="p-3 font-medium"><?= htmlspecialchars($row['name']) ?></td>
      <td class="p-3 text-blue-600 hover:underline">
        <a href="<?= htmlspecialchars($row['page_link']) ?>" target="_blank"><?= htmlspecialchars($row['page_link']) ?></a>
      </td>
      <td class="p-3 space-x-2">
        <a href="edit-psl-team.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
        <a href="delete-psl-team.php?id=<?= $row['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this team?')">Delete</a>
      </td>
      
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>

</body>
</html>
