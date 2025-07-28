<?php include 'admin/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PSL - Pakistan Cricket</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

<!-- Navbar -->
<header class="sticky top-0 bg-green-700 text-white p-4 z-50">
  <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-2xl font-bold">🏏 Pakistan Cricket</h1>
    <nav class="space-x-4">
      <a href="home.php" class="hover:underline">Home</a>
      <a href="schedule.php" class="hover:underline">Schedule</a>
      <a href="players.php" class="hover:underline">Players</a>
      <a href="psl.php" class="hover:underline ">Psl</a>
      <a href="news.php" class="hover:underline">News</a>
      <a href="admin/blog.php" class="hover:underline">Blog</a>
    </nav>
  </div>
</header>

<!-- PSL Team Cards -->
<section class="py-12 px-4">
  <h2 class="text-3xl font-bold text-center text-green-700 mb-10">Pakistan Super League Teams</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
    <?php
    $teams = $conn->query("SELECT * FROM psl_teams");
    while ($team = $teams->fetch_assoc()):
    ?>
    <a href="<?= $team['page_link'] ?>" class="bg-white p-6 rounded-lg shadow hover:scale-105 transition text-center">
  <img src="images/<?= $team['logo'] ?>" alt="<?= $team['name'] ?>" class="w-24 h-24 mx-auto mb-3 rounded-full">
  <h3 class="text-xl font-semibold"><?= $team['name'] ?></h3>
  <p class="text-gray-600">PSL Team</p>
</a>

    <?php endwhile; ?>
  </div>
</section>

<!-- Points Table -->
<?php
$points = $conn->query("
  SELECT psl_points.*, psl_teams.name 
  FROM psl_points 
  JOIN psl_teams ON psl_points.team_id = psl_teams.id
");
?>
<section class="py-12 px-4 bg-white">
  <h2 class="text-3xl font-bold text-center text-green-700 mb-8">PSL Points Table</h2>
  <div class="overflow-x-auto">
    <table class="w-full table-auto border border-collapse border-green-700 text-sm text-center">
      <thead class="bg-green-700 text-white">
        <tr>
          <th class="p-2 border">Team</th>
          <th class="p-2 border">Matches</th>
          <th class="p-2 border">Wins</th>
          <th class="p-2 border">Losses</th>
          <th class="p-2 border">Ties</th>
          <th class="p-2 border">No Result</th>
          <th class="p-2 border">Points</th>
          <th class="p-2 border">NRR</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $points->fetch_assoc()): ?>
        <tr class="hover:bg-gray-100">
          <td class="p-2 border font-semibold"><?= $row['name'] ?></td>
          <td class="p-2 border"><?= $row['matches'] ?></td>
          <td class="p-2 border"><?= $row['wins'] ?></td>
          <td class="p-2 border"><?= $row['losses'] ?></td>
          <td class="p-2 border"><?= $row['ties'] ?></td>
          <td class="p-2 border"><?= $row['no_result'] ?></td>
          <td class="p-2 border"><?= $row['points'] ?></td>
          <td class="p-2 border"><?= $row['nrr'] ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>


<!-- Upcoming & Completed Match Toggle -->
<section class="py-12 px-4">
  <div class="text-center mb-6">
    <button id="upcomingBtn" class="bg-green-700 text-white px-4 py-2 rounded-l">Upcoming</button>
    <button id="completedBtn" class="bg-white text-gray-700 px-4 py-2 rounded-r border border-green-700">Completed</button>
  </div>

  <!-- Upcoming Matches -->
  <div id="upcomingSection">
    <h2 class="text-2xl font-bold text-green-700 text-center mb-6">Upcoming Matches</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
      <?php
      $upcoming = $conn->query("
        SELECT m.*, t1.name AS team1_name, t2.name AS team2_name 
        FROM psl_matches m
        JOIN psl_teams t1 ON m.team_1 = t1.id
        JOIN psl_teams t2 ON m.team_2 = t2.id
        WHERE m.status='upcoming'
        ORDER BY m.match_date ASC
      ");
      while($match = $upcoming->fetch_assoc()):
      ?>
      <div class="bg-white p-4 rounded shadow text-center">
        <div class="text-lg font-semibold"><?= $match['team1_name'] ?></div>
        <div class="text-sm text-gray-600">vs</div>
        <div class="text-lg font-semibold"><?= $match['team2_name'] ?></div>
        <div class="my-2 text-green-700 font-bold"><?= date('g:i A', strtotime($match['match_time'])) ?> PKT</div>
        <div class="text-gray-500">At <?= $match['stadium'] ?></div>
        <div class="text-sm text-gray-400"><?= date('D, M d, Y', strtotime($match['match_date'])) ?></div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

  <!-- Completed Matches -->
  <div id="completedSection" class="hidden">
    <h2 class="text-2xl font-bold text-green-700 text-center mb-6">Completed Matches</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
      <?php
      $completed = $conn->query("
        SELECT m.*, t1.name AS team1_name, t2.name AS team2_name 
        FROM psl_matches m
        JOIN psl_teams t1 ON m.team_1 = t1.id
        JOIN psl_teams t2 ON m.team_2 = t2.id
        WHERE m.status='completed'
        ORDER BY m.match_date DESC
      ");
      while($match = $completed->fetch_assoc()):
      ?>
      <div class="bg-white p-4 rounded shadow text-center">
        <div class="text-lg font-semibold"><?= $match['team1_name'] ?></div>
        <div class="text-sm text-gray-600">vs</div>
        <div class="text-lg font-semibold"><?= $match['team2_name'] ?></div>
        <div class="text-gray-500">At <?= $match['stadium'] ?></div>
        <div class="text-sm text-gray-400"><?= date('D, M d, Y', strtotime($match['match_date'])) ?></div>
        <?php if (!empty($match['result'])): ?>
          <div class="text-green-600 font-semibold mt-2"><?= $match['result'] ?></div>
        <?php endif; ?>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- Toggle Script -->
<script>
  const upcomingBtn = document.getElementById("upcomingBtn");
  const completedBtn = document.getElementById("completedBtn");
  const upcomingSection = document.getElementById("upcomingSection");
  const completedSection = document.getElementById("completedSection");

  upcomingBtn.onclick = () => {
    upcomingSection.classList.remove("hidden");
    completedSection.classList.add("hidden");
    upcomingBtn.classList.add("bg-green-700", "text-white");
    upcomingBtn.classList.remove("bg-white", "text-gray-700");
    completedBtn.classList.remove("bg-green-700", "text-white");
    completedBtn.classList.add("bg-white", "text-gray-700");
  };

  completedBtn.onclick = () => {
    completedSection.classList.remove("hidden");
    upcomingSection.classList.add("hidden");
    completedBtn.classList.add("bg-green-700", "text-white");
    completedBtn.classList.remove("bg-white", "text-gray-700");
    upcomingBtn.classList.remove("bg-green-700", "text-white");
    upcomingBtn.classList.add("bg-white", "text-gray-700");
  };
</script>


</body>
</html>
