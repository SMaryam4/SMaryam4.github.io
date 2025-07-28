<?php
include('admin/db.php');

// ✅ Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid news ID.");
}

$id = (int)$_GET['id'];

// ✅ Fetch the news article
$sql = "SELECT * FROM news WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    echo "News not found.";
    exit;
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title><?= htmlspecialchars($row['title']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

<!-- Header -->
<header class="bg-green-700 text-white p-4">
  <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-2xl font-bold">🏏 Pakistan Cricket</h1>
    <nav class="space-x-4">
      <a href="home.php" class="hover:underline">Home</a>
       <a href="schedule.php" class="hover:underline">Schedule</a>
      <a href="players.php" class="hover:underline">Players</a>
      <a href="psl.php" class="hover:underline">Psl</a>
      <a href="news.php" class="hover:underline ">News</a>
      <a href="admin/blog.php" class="hover:underline">Blog</a>
    </nav>
  </div>
</header>

<!-- News Content -->
<section class="py-12 px-4 bg-white max-w-4xl mx-auto">
  <img src="<?= htmlspecialchars($row['image_url']) ?>" class="w-full h-80 object-cover rounded mb-4" />
  <h2 class="text-3xl font-bold mb-2"><?= htmlspecialchars($row['title']) ?></h2>
  <p class="text-gray-600 mb-4"><?= htmlspecialchars($row['created_at']) ?></p>
  <div class="text-lg leading-7"><?= nl2br(htmlspecialchars($row['detail'])) ?></div>
</section>

</body>
</html>
