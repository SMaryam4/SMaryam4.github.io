<?php
include 'admin/db.php';
$id = $_GET['id'];
$player = $conn->query("SELECT * FROM psl_players WHERE id = $id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $player['name'] ?> - Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-yellow-50 text-gray-900 min-h-screen">

<!-- Navbar -->
<header class="sticky top-0 bg-black text-yellow-400 z-50">
  <div class="container mx-auto flex justify-between items-center px-4 py-4">
    <h1 class="text-2xl font-bold flex items-center gap-2">
      <img src="images/peshawar zalmi.jpg" alt="Zalmi Logo" class="h-10"> Peshawar Zalmi Squad
    </h1>
    <nav class="space-x-4">
      <a href="home.php" class="hover:underline">Home</a>
      <a href="schedule.php" class="hover:underline">Schedule</a>
      <a href="players.php" class="hover:underline">Players</a>
      <a href="psl.php" class="hover:underline">Psl</a>
      <a href="news.php" class="hover:underline">News</a>
      <a href="admin/blog.php" class="hover:underline">Blog</a>
    </nav>
  </div>
</header>

<!-- Player Header -->
<section class="max-w-6xl mx-auto bg-yellow-500 text-black mt-6 rounded-lg shadow-lg overflow-hidden">
  <div class="flex flex-col md:flex-row items-center p-6 gap-6">
    <img src="images/<?= $player['image'] ?>" alt="<?= $player['name'] ?>" class="w-40 h-40 rounded-full border-4 border-white shadow">
    <div class="text-center md:text-left">
      <h1 class="text-4xl font-extrabold uppercase"><?= $player['name'] ?></h1>
      <p class="mt-2"><strong>Role:</strong> <?= $player['role'] ?></p>
      <p><strong>Nationality:</strong> <?= $player['nationality'] ?></p>
      <p><strong>Age:</strong> <?= $player['age'] ?> years</p>
      <p><strong>Batting Style:</strong> <?= $player['batting_style'] ?></p>
      <p><strong>Bowling Style:</strong> <?= $player['bowling_style'] ?></p>
    </div>
  </div>
</section>

<!-- Player Stats -->
<section class="max-w-6xl mx-auto mt-6 bg-white p-6 rounded-lg shadow">
  <h2 class="text-2xl font-bold text-yellow-600 mb-4">Performance Stats</h2>
  <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 text-center">
    <div><div class="text-xl font-bold text-yellow-700"><?= $player['matches'] ?></div><div>Matches</div></div>
    <div><div class="text-xl font-bold text-yellow-700"><?= $player['runs'] ?></div><div>Runs</div></div>
    <div><div class="text-xl font-bold text-yellow-700"><?= $player['wickets'] ?></div><div>Wickets</div></div>
    <div><div class="text-xl font-bold text-yellow-700"><?= $player['strike_rate'] ?></div><div>Strike Rate</div></div>
    <div><div class="text-xl font-bold text-yellow-700"><?= $player['average'] ?></div><div>Average</div></div>
    <div><div class="text-xl font-bold text-yellow-700"><?= $player['fifties'] ?></div><div>50s</div></div>
    <div><div class="text-xl font-bold text-yellow-700"><?= $player['hundreds'] ?></div><div>100s</div></div>
    <div><div class="text-xl font-bold text-yellow-700"><?= $player['sixes'] ?></div><div>Sixes</div></div>
    <div><div class="text-xl font-bold text-yellow-700"><?= $player['fours'] ?></div><div>Fours</div></div>
    <div><div class="text-xl font-bold text-yellow-700"><?= $player['highest_score'] ?></div><div>High Score</div></div>
  </div>
</section>

<!-- Back Button -->
<div class="max-w-6xl mx-auto my-10 text-center">
  <a href="zalmi.php" class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold px-6 py-3 rounded-full shadow-md transition-all duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back to Zalmi Squad
  </a>
</div>

</body>
</html>
