<?php
session_start();
include 'admin/db.php';

// Match Results
$matchResult = $conn->query("SELECT * FROM schedule ORDER BY match_date DESC LIMIT 3");

// Upcoming Matches
$upcoming = $conn->query("SELECT * FROM schedule ORDER BY match_date ASC LIMIT 3");

// Featured Player
$featuredPlayerQuery = $conn->query("SELECT * FROM players WHERE featured = 1 LIMIT 1");
$featuredPlayer = $featuredPlayerQuery ? $featuredPlayerQuery->fetch_assoc() : null;

// Star Players
$starPlayers = $conn->query("SELECT * FROM players WHERE star_player = 1 LIMIT 4");

// Latest News
$latestNews = $conn->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 3");
if (!$latestNews) {
    die("News Query Failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Pak Cricket - Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<!-- Navigation Bar -->
<header class="sticky top-0 bg-green-700 text-white p-4 z-50">
  <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-2xl font-bold">🏏 Pakistan Cricket</h1>
    <nav class="space-x-4">
      <a href="home.php" class="hover:underline">Home</a>
      <a href="schedule.php" class="hover:underline">Schedule</a>
      <a href="players.php" class="hover:underline">Players</a>
      <a href="psl.php" class="hover:underline ">PSL</a>
      <a href="news.php" class="hover:underline">News</a>
      <a href="admin/blog.php" class="hover:underline">Blog</a>

      <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
        <a href="admin/admin-dashboard.php" class="hover:underline text-yellow-300 font-semibold">Dashboard</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<!-- Hero Section -->
<section class="relative z-0 h-[500px] bg-cover bg-center" style="background-image: url('pak team.jpg');">
  <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
    <div class="text-center text-white px-4">
      <h1 class="text-4xl md:text-5xl font-bold mb-2">Pakistan Dominates Series!</h1>
      <p class="text-lg md:text-xl mb-4">Relive the thrilling moments of Pakistan's decisive victory in the latest series!</p>
    </div>
  </div>
</section>

<!-- Match Results -->
<section class="p-6">
  <h2 class="text-2xl font-bold text-green-700 mb-4">Recent Match Results</h2>
  <div class="grid md:grid-cols-3 gap-4">
    <?php while($match = $matchResult->fetch_assoc()): ?>
      <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold"><?= htmlspecialchars($match['team1']) ?> vs <?= htmlspecialchars($match['team2']) ?></h3>
        <p><?= htmlspecialchars($match['result']) ?></p>
        <p class="text-sm text-gray-500"><?= htmlspecialchars($match['venue']) ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Upcoming Matches -->
<section class="p-6 bg-green-50">
  <h2 class="text-2xl font-bold text-green-700 mb-4">Upcoming Matches</h2>
  <div class="grid md:grid-cols-3 gap-4">
    <?php while($up = $upcoming->fetch_assoc()): ?>
      <div class="bg-white p-4 rounded shadow">
        <h3 class="font-bold"><?= htmlspecialchars($up['team1']) ?> vs <?= htmlspecialchars($up['team2']) ?></h3>
        <p class="text-sm text-gray-600"><?= date("d M Y", strtotime($up['match_date'])) ?></p>
        <p class="text-sm text-gray-500"><?= htmlspecialchars($up['venue']) ?></p>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Featured Player -->
<section class="p-6">
  <h2 class="text-2xl font-bold text-green-700 mb-4">Featured Player</h2>
  <?php if ($featuredPlayer): ?>
    <div class="text-center bg-white p-6 rounded shadow w-72 mx-auto">
      <img src="images/<?= htmlspecialchars($featuredPlayer['image']) ?>" alt="<?= htmlspecialchars($featuredPlayer['name']) ?>" class="w-24 h-24 rounded-full mx-auto">
      <h3 class="mt-2 font-bold"><?= htmlspecialchars($featuredPlayer['name']) ?></h3>
      <p><?= htmlspecialchars($featuredPlayer['nationality']) ?> • Matches: <?= $featuredPlayer['matches'] ?> • Runs: <?= $featuredPlayer['runs'] ?></p>
      <a href="player_profile.php?id=<?= $featuredPlayer['id'] ?>" class="mt-3 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">View Profile</a>
    </div>
  <?php else: ?>
    <p class="text-center text-gray-500">No featured player yet.</p>
  <?php endif; ?>
</section>

<!-- Star Players -->
<section class="p-6 bg-green-50">
  <h2 class="text-2xl font-bold text-green-700 mb-4">Star Players</h2>
  <div class="grid md:grid-cols-4 gap-4">
    <?php while($player = $starPlayers->fetch_assoc()): ?>
      <div class="bg-white p-4 rounded shadow text-center">
        <img src="images/<?= htmlspecialchars($player['image']) ?>" alt="<?= htmlspecialchars($player['name']) ?>" class="w-20 h-20 rounded-full mx-auto">
        <h3 class="font-bold mt-2"><?= htmlspecialchars($player['name']) ?></h3>
        <p class="text-sm"><?= htmlspecialchars($player['nationality']) ?> | Matches: <?= $player['matches'] ?></p>
        <a href="player_profile.php?id=<?= $player['id'] ?>" class="mt-3 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">View Profile</a>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Latest News -->
<section class="p-6">
  <h2 class="text-2xl font-bold text-green-700 mb-4">Latest Cricket News</h2>
  <div class="grid md:grid-cols-3 gap-4">
    <?php while($news = $latestNews->fetch_assoc()): ?>
      <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold text-lg"><?= htmlspecialchars($news['title']) ?></h3>
        <p class="text-sm text-gray-700"><?= htmlspecialchars(substr($news['description'], 0, 100)) ?>...</p>
        <a href="news.php?id=<?= $news['id'] ?>" class="text-green-600 underline">Read More</a>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- Admin Dashboard Section -->
<?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
<section class="p-6">
  <h2 class="text-2xl font-bold text-green-700 mb-4">👨‍💼 Admin Dashboard</h2>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

    <a href="admin/add-post.php" class="bg-blue-600 text-white p-4 rounded shadow hover:bg-blue-700 text-center">
      Manage Posts
    </a>

    <a href="admin/match-list.php" class="bg-green-600 text-white p-4 rounded shadow hover:bg-green-700 text-center">
      Manage Matches
    </a>

    <a href="admin/users.php" class="bg-purple-600 text-white p-4 rounded shadow hover:bg-purple-700 text-center">
      Manage Users
    </a>

    <a href="admin/manage-news.php" class="bg-yellow-600 text-white p-4 rounded shadow hover:bg-yellow-700 text-center">
      Manage News
    </a>

  </div>

  <div class="mt-4">
    <a href="admin/logout.php" class="inline-block text-red-600 hover:underline">Logout</a>
  </div>
</section>
<?php endif; ?>

</body>
</html>
