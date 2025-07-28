<?php
include('db.php'); // DB connection

// Fetch matches
$result = $conn->query("SELECT * FROM schedule ORDER BY match_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Matches</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
 <div class="max-w-6xl mx-auto mt-6 text-center">
  <a href="admin-dashboard.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded">
    🔙 Back to Admin Dashboard
  </a>
</div>
<body class="bg-gray-100 text-gray-900 p-6">
 

  <div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Manage Matches</h1>
      <a href="add-match.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Add Match</a>
    </div>

    <table class="w-full border border-gray-300 bg-white shadow-md">
      <thead class="bg-gray-200">
        <tr>
          <th class="p-2 text-left">Date</th>
          <th class="p-2 text-left">Time</th>
          <th class="p-2 text-left">Teams</th>
          <th class="p-2 text-left">Venue</th>
          <th class="p-2 text-left">Series</th>
          <th class="p-2 text-left">Status</th>
          <th class="p-2 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr class="border-t">
              <td class="p-2"><?= $row['match_date'] ?></td>
              <td class="p-2"><?= $row['time'] ?></td>
              <td class="p-2 flex items-center gap-2">
                <?php if (!empty($row['team1_flag'])): ?>
                  <img src="<?= $row['team1_flag'] ?>" class="w-5 h-3">
                <?php endif; ?>
                <?= $row['team1'] ?>
                <span class="text-gray-500">vs</span>
                <?= $row['team2'] ?>
                <?php if (!empty($row['team2_flag'])): ?>
                  <img src="<?= $row['team2_flag'] ?>" class="w-5 h-3">
                <?php endif; ?>
              </td>
              <td class="p-2"><?= $row['venue'] ?></td>
              <td class="p-2"><?= $row['series_name'] ?></td>
              <td class="p-2"><?= ucfirst($row['status']) ?></td>
              <td class="p-2 space-x-2">
              <a href="/pak_cricket_website/admin/update-match.php?id=<?= $row['id'] ?>">Edit</a>

                <a href="delete-match.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this match?')" class="text-red-600 hover:underline">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="7" class="p-4 text-center text-gray-500">No matches found.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
