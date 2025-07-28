<?php
include 'admin/db.php';
$team_id = 3; // Lahore Qalandars

// Get captain
$captain_result = $conn->query("SELECT * FROM psl_players WHERE team_id = $team_id AND role LIKE '%Captain%' LIMIT 1");
$captain = $captain_result->fetch_assoc();

// Get players
$players = $conn->query("SELECT * FROM psl_players WHERE team_id = $team_id");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Lahore Qalandars Squad PSL 10</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .player-card {
      position: relative;
      overflow: hidden;
      border-radius: 12px;
      transition: transform 0.3s ease;
    }
    .player-card:hover {
      transform: scale(1.05);
    }
    .player-name-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(0, 0, 0, 0.6);
      color: #fff;
      font-weight: bold;
      font-size: 1.25rem;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .player-card:hover .player-name-overlay {
      opacity: 1;
    }
    .bg-dark-red {
      background-color: #8B0000;
    }
    .text-dark-red {
      color: #8B0000;
    }
  </style>
</head>
<body class="bg-black text-white">

<!-- Navbar -->
<header class="bg-dark-red text-white p-4 shadow-md sticky top-0 z-50">
  <div class="max-w-6xl mx-auto flex justify-between items-center">
    <h1 class="text-2xl font-bold">🏏 Pakistan Cricket</h1>
    <nav class="space-x-4 text-sm">
      <a href="home.php" class="hover:underline">Home</a>
      <a href="schedule.php" class="hover:underline">Schedule</a>
      <a href="players.php" class="hover:underline">Players</a>
      <a href="psl.php" class="hover:underline font-bold underline">PSL</a>
      <a href="news.php" class="hover:underline">News</a>
      <a href="admin/blog.php" class="hover:underline">Blog</a>
    </nav>
  </div>
</header>

<!-- Captain Card -->
<section class="py-10 bg-black text-white text-center">
  <h2 class="text-3xl font-bold mb-4 text-dark-red">Lahore Qalandars Squad – PSL 10</h2>
  <p class="mb-8 text-gray-300">Representing passion, energy and youth – Qalandars are here!</p>

  <?php if ($captain): ?>
    <div class="max-w-xl mx-auto bg-dark-red text-white p-6 rounded-lg shadow-lg flex flex-col items-center">
      <img src="images/<?= $captain['image'] ?>" alt="<?= $captain['name'] ?>" class="w-32 h-32 rounded-full mb-4 object-cover border-4 border-white">
      <h3 class="text-xl font-bold"><?= $captain['name'] ?></h3>
      <p class="text-sm"><?= $captain['role'] ?></p>
    </div>
  <?php endif; ?>
</section>

<!-- Player Cards -->
<section class="py-12 px-4 bg-black">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
    <?php while ($player = $players->fetch_assoc()): ?>
      <?php if ($player['id'] != $captain['id']): ?>
        <a href="psl_players_profile.php?id=<?= $player['id'] ?>" class="player-card shadow-lg">
          <img src="images/<?= $player['image'] ?>" alt="<?= $player['name'] ?>" class="w-full h-[400px] object-cover rounded-lg">
          <div class="player-name-overlay">
            <?= $player['name'] ?>
          </div>
        </a>
      <?php endif; ?>
    <?php endwhile; ?>
  </div>
</section>

</body>
</html>
