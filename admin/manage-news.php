<?php
include("db.php");

// Fetch all news
$result = $conn->query("SELECT * FROM news ORDER BY id DESC");

if (!$result) {
    die("Error fetching news: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>News List</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
 <div class="max-w-6xl mx-auto mt-6 text-center">
  <a href="admin-dashboard.php" class=" bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded">
    🔙 Back to Admin Dashboard
  </a>
</div>
<body class="bg-gray-100 p-6 text-gray-800">
  <div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">All News</h1>
      <a href="add-news.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Add News</a>
    </div>

    <table class="w-full border-collapse bg-white shadow-md text-sm">
      <thead class="bg-gray-200">
        <tr>
          <th class="border p-2 text-left">ID</th>
          <th class="border p-2 text-left">Title</th>
          <th class="border p-2 text-left">Description</th>
          <th class="border p-2 text-left">Image</th>
          <th class="border p-2 text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr class="border-t hover:bg-gray-50">
            <td class="p-2"><?= htmlspecialchars($row['id']) ?></td>
            <td class="p-2"><?= htmlspecialchars($row['title']) ?></td>
            <td class="p-2"><?= htmlspecialchars($row['description']) ?></td>
            <td class="p-2">
              <?php if (!empty($row['image_url'])): ?>
                <img src="<?= htmlspecialchars($row['image_url']) ?>" width="100" class="rounded">
              <?php else: ?>
                <span class="text-gray-400 italic">No image</span>
              <?php endif; ?>
            </td>
            <td class="p-2">
              <a href="edit-news.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
              <a href="delete-news.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this news?')" class="text-red-600 hover:underline">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
