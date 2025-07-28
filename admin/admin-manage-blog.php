<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "pak_cricket"); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $conn->query("DELETE FROM blog_posts WHERE id = $deleteId");
    header("Location: admin-manage-blog.php");
    exit();
}

$result = $conn->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Blog Posts</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-5xl mx-auto p-6">
  <h1 class="text-3xl font-bold mb-6">Manage Blog Posts</h1>

  <a href="add-post.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">+ Add New Post</a>

  <?php while($row = $result->fetch_assoc()): ?>
    <div class="bg-white p-4 mb-4 rounded shadow">
      <h2 class="text-xl font-bold"><?= htmlspecialchars($row['title']) ?></h2>
      <p class="text-gray-600 text-sm mb-2"><?= htmlspecialchars($row['created_at']) ?></p>
      <p><?= nl2br(htmlspecialchars(substr($row['content'], 0, 150))) ?>...</p>
      <div class="mt-3">
        <a href="edit-post.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline mr-4">Edit</a>
        <a href="admin-manage-blog.php?delete=<?= $row['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Are you sure to delete this post?');">Delete</a>
      </div>
    </div>
  <?php endwhile; ?>

  <a href="admin-dashboard.php" class="inline-block mt-6 text-blue-600 hover:underline">← Back to Dashboard</a>
</div>

</body>
</html>
