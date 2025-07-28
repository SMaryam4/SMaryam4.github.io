<?php
$conn = new mysqli("localhost", "root", "", "pak_cricket");
$posts = $conn->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Blog Posts</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Blog Posts</h1>
    <a href="create_post.php" class="bg-green-600 text-white px-4 py-2 rounded inline-block mb-4">➕ Create New Post</a>
    <table class="w-full border">
      <tr class="bg-gray-200">
        <th class="p-2">Title</th>
        <th class="p-2">Actions</th>
      </tr>
      <?php while ($post = $posts->fetch_assoc()): ?>
      <tr>
        <td class="p-2 border"><?= htmlspecialchars($post['title']) ?></td>
        <td class="p-2 border">
          <a href="edit_post.php?id=<?= $post['id'] ?>" class="text-blue-600">✏️ Edit</a> |
          <a href="delete_post.php?id=<?= $post['id'] ?>" onclick="return confirm('Are you sure?');" class="text-red-600">🗑️ Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </table>
  </div>
</body>
</html>
