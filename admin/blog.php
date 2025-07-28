<?php
$conn = new mysqli("localhost", "root", "", "pak_cricket");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Cricket Blog</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navigation Bar -->
  <header class="sticky top-0 bg-green-700 text-white p-4 z-50 shadow">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold">🏏 Pakistan Cricket</h1>
      <nav class="space-x-4 text-sm sm:text-base">
        <a href="/cricket/home.php" class="hover:underline">Home</a>
        <a href="/cricket/schedule.php" class="hover:underline">Schedule</a>
        <a href="/cricket/players.php" class="hover:underline">Players</a>
        <a href="/cricket/psl.php" class="hover:underline font-semibold underline">PSL</a>
        <a href="/cricket/news.php" class="hover:underline">News</a>
        <a href="blog.php" class="hover:underline">Blog</a>
      </nav>
    </div>
  </header>

  <!-- Blog Section -->
  <main class="max-w-4xl mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">📝 Latest Blog Posts</h2>
    
    <div class="space-y-8">
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition duration-300 p-6">
          <h3 class="text-2xl font-semibold text-green-800 mb-3"><?= htmlspecialchars($row['title']) ?></h3>
          <p class="text-gray-700 text-base leading-relaxed mb-4 break-words">
            <?= nl2br(htmlspecialchars(substr($row['content'], 0, 500))) ?>...
          </p>
          <div class="flex justify-between items-center">
            <a href="post.php?id=<?= $row['id'] ?>" class="text-green-600 hover:text-green-800 font-medium">Read More →</a>
            <span class="text-sm text-gray-500"><?= date('M d, Y', strtotime($row['created_at'])) ?></span>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="text-center text-gray-500 text-sm py-6 mt-10">
    © <?= date('Y') ?> Pakistan Cricket Blog. All rights reserved.
  </footer>

</body>
</html>
