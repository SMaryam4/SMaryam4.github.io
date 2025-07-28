<?php
include 'admin/db.php';
$player_id = $_GET['id'];
$formats = ['T20', 'ODI', 'Test'];
$player = $conn->query("SELECT * FROM players WHERE id=$player_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $player['name'] ?> Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function showStats(format) {
      document.querySelectorAll('.stat-section').forEach(section => section.classList.add('hidden'));
      document.getElementById(format).classList.remove('hidden');

      document.querySelectorAll('.format-btn').forEach(btn => btn.classList.remove('bg-green-700', 'text-white'));
      document.getElementById('btn-' + format).classList.add('bg-green-700', 'text-white');
    }
  </script>
</head>
<body class="bg-gray-100">
  <!-- Navigation Bar -->
<header class="sticky top-0 bg-green-700 text-white p-4 z-50">
  <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-2xl font-bold">🏏 Pakistan Cricket</h1>
    <nav class="space-x-4">
      <a href="home.php" class="hover:underline">Home</a>
      <a href="schedule.php" class="hover:underline">Schedule</a>
      <a href="players.php" class="hover:underline">Players</a>
      <a href="psl.php" class="hover:underline font-semibold underline">PSL</a>
      <a href="news.php" class="hover:underline">News</a>
      <a href="admin/blog.php" class="hover:underline">Blog</a>
     
    </nav>
  </div>
</header>

<!-- Player Info Card -->
<section class="max-w-6xl mx-auto mt-10 px-4">
  <div class="bg-white shadow-lg rounded-xl p-6 grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
    <div class="flex justify-center">
      <img src="images/<?= $player['image'] ?>" alt="<?= $player['name'] ?>" class="w-60 h-auto object-cover rounded-lg border-4 border-green-600 shadow-md">
    </div>
    <div class="md:col-span-2">
      <h1 class="text-3xl font-bold text-green-700 mb-4"><?= $player['name'] ?></h1>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700">
        <div><span class="font-semibold">Nationality:</span> <?= $player['nationality'] ?></div>
        <div><span class="font-semibold">Born:</span> <?= $player['born'] ?></div>
        <div><span class="font-semibold">Batting Style:</span> <?= $player['batting_style'] ?></div>
        <div><span class="font-semibold">Bowling Style:</span> <?= $player['bowling_style'] ?></div>
        <div><span class="font-semibold">Matches:</span> <?= $player['matches'] ?></div>
        <div><span class="font-semibold">Runs:</span> <?= $player['runs'] ?></div>
      </div>
    </div>
  </div>
</section>

<!-- Format Switch Buttons -->
<div class="max-w-6xl mx-auto mt-10 px-4 text-center">
  <?php foreach ($formats as $format): ?>
    <button id="btn-<?= $format ?>" onclick="showStats('<?= $format ?>')" class="format-btn inline-block mx-2 px-6 py-2 border border-green-700 rounded-full font-semibold text-green-700 hover:bg-green-700 hover:text-white transition">
      <?= $format ?>
    </button>
  <?php endforeach; ?>
</div>

<!-- Stats Sections -->
<?php foreach ($formats as $format): 
  $stat = $conn->query("SELECT * FROM player_stats WHERE player_id = $player_id AND format = '$format'")->fetch_assoc();
  if (!$stat) continue;
?>
  <div id="<?= $format ?>" class="stat-section <?= $format !== 'T20' ? 'hidden' : '' ?> bg-white text-green-800 mt-6 p-6 rounded-lg shadow-lg max-w-6xl mx-auto">
    <h3 class="text-2xl font-bold mb-6 text-green-700 text-center"><?= $format ?> Career Statistics</h3>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 text-center text-sm">
      <div><div class="text-green-600 text-2xl font-bold"><?= $stat['matches'] ?></div><div>Matches</div></div>
      <div><div class="text-green-600 text-2xl font-bold"><?= $stat['runs'] ?></div><div>Runs</div></div>
      <div><div class="text-green-600 text-2xl font-bold"><?= $stat['wickets'] ?></div><div>Wickets</div></div>
      <div><div class="text-green-600 text-2xl font-bold"><?= $stat['strike_rate'] ?></div><div>Strike Rate</div></div>
      <div><div class="text-green-600 text-2xl font-bold"><?= $stat['average'] ?></div><div>Average</div></div>
      <div><div class="text-green-600 text-2xl font-bold"><?= $stat['highest_score'] ?></div><div>Highest Score</div></div>
      <div><div class="text-green-600 text-2xl font-bold"><?= $stat['fifties'] ?></div><div>Fifties</div></div>
      <div><div class="text-green-600 text-2xl font-bold"><?= $stat['hundreds'] ?></div><div>Hundreds</div></div>
      <div><div class="text-green-600 text-2xl font-bold"><?= $stat['sixes'] ?></div><div>Sixes</div></div>
      <div><div class="text-green-600 text-2xl font-bold"><?= $stat['fours'] ?></div><div>Fours</div></div>
    </div>
  </div>
<?php endforeach; ?>

<!-- Player Overview -->
<section class="max-w-6xl mx-auto mt-10 px-4 mb-10">
  <div class="bg-green-600 text-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-4">Player Overview</h2>
    <p class="leading-relaxed whitespace-pre-line text-lg">
      <?= nl2br($player['overview']) ?>
    </p>
  </div>
</section>

<!-- Back Button -->
<div class="max-w-6xl mx-auto text-center mb-10">
  <a href="players.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 text-white font-semibold px-6 py-3 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 ease-in-out">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Back to Players
  </a>
</div>

</body>
</html>
