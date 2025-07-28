<?php
include('admin/db.php'); // adjust if path is different
$sql = "SELECT * FROM news ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>News</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

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

<section class="py-12 px-4 bg-gray-50">
  <h2 class="text-3xl font-bold text-center mb-6">Latest Cricket News</h2>
  <div class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto">
    <?php while($row = $result->fetch_assoc()) { ?>
      <div class="bg-white p-4 shadow rounded">
        <img src="<?= $row['image_url'] ?>" class="w-full h-40 object-cover rounded mb-3" />
        <h3 class="font-semibold text-lg"><?= $row['title'] ?></h3>
        <p class="text-sm mb-2"><?= $row['description'] ?></p>
        <a href="news-details.php?id=<?= $row['id'] ?>" class="text-green-700 font-semibold">Read More</a>
      </div>
    <?php } ?>
  </div>
</section>

</body>
</html>
