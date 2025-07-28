<?php
include 'admin/db.php';
// Fetch Upcoming Matches
$upcoming_result = $conn->query("SELECT * FROM schedule WHERE status='upcoming' ORDER BY match_date ASC");

// Fetch Completed Matches
$completed_result = $conn->query("SELECT * FROM schedule WHERE status='completed' ORDER BY match_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Match Schedule</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">

 <!-- Navigation Bar -->
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

  <div class="container mx-auto px-4 py-6">
    <!-- Toggle Buttons -->
    <div class="flex space-x-4 mb-6">
      <button id="upcomingBtn" class="px-4 py-2 bg-green-700 text-white rounded-lg font-semibold">Upcoming</button>
      <button id="completedBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold">Completed</button>
    </div>

    <!-- Upcoming Matches -->
    <div id="upcomingMatches">
      <?php if ($upcoming_result->num_rows > 0): ?>
        <?php while($row = $upcoming_result->fetch_assoc()): ?>
          <div class="border rounded-lg p-4 mb-4 shadow-sm">
            <p class="text-sm text-gray-500">
              <?= date("D, M d, Y", strtotime($row['match_date'])) ?> · <?= htmlspecialchars($row['series_name']) ?>
            </p>
            <div class="flex justify-between items-center">
              <div class="flex items-center space-x-2 font-bold text-lg">
                <span><?= $row['team1'] ?></span>
                <img src="<?= htmlspecialchars($row['team1_flag']) ?>" alt="Flag1" class="w-6 h-4" />
                <span class="bg-gray-100 px-2 py-1 rounded text-sm"><?= $row['time'] ?> PKT</span>
                <img src="<?= htmlspecialchars($row['team2_flag']) ?>" alt="Flag2" class="w-6 h-4" />
                <span><?= $row['team2'] ?></span>
              </div>
              <span class="text-sm text-gray-600">At <?= htmlspecialchars($row['venue']) ?></span>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-gray-500">No upcoming matches available.</p>
      <?php endif; ?>
    </div>

    <!-- Completed Matches -->
    <div id="completedMatches" class="hidden">
      <?php if ($completed_result->num_rows > 0): ?>
        <?php while($row = $completed_result->fetch_assoc()): ?>
          <div class="border rounded-lg p-4 mb-4 shadow-sm bg-gray-50">
            <p class="text-sm text-gray-500">
              <?= date("D, M d, Y", strtotime($row['match_date'])) ?> · <?= htmlspecialchars($row['series_name']) ?>
            </p>
            <div class="flex justify-between items-center">
              <div class="flex items-center space-x-2 font-bold text-lg">
                <span><?= $row['team1'] ?></span>
                <img src="<?= htmlspecialchars($row['team1_flag']) ?>" alt="Flag1" class="w-6 h-4" />
                <span class="bg-gray-100 px-2 py-1 rounded text-sm"><?= htmlspecialchars($row['result']) ?></span>
                <img src="<?= htmlspecialchars($row['team2_flag']) ?>" alt="Flag2" class="w-6 h-4" />
                <span><?= $row['team2'] ?></span>
              </div>
              <span class="text-sm text-gray-600">At <?= htmlspecialchars($row['venue']) ?></span>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-gray-500">No completed matches available.</p>
      <?php endif; ?>
    </div>
  </div>

  <!-- JavaScript to toggle views -->
  <script>
    const upcomingBtn = document.getElementById("upcomingBtn");
    const completedBtn = document.getElementById("completedBtn");
    const upcomingMatches = document.getElementById("upcomingMatches");
    const completedMatches = document.getElementById("completedMatches");

    upcomingBtn.addEventListener("click", () => {
      upcomingMatches.classList.remove("hidden");
      completedMatches.classList.add("hidden");

      upcomingBtn.classList.add("bg-green-700", "text-white");
      upcomingBtn.classList.remove("bg-gray-200", "text-gray-700");

      completedBtn.classList.remove("bg-green-700", "text-white");
      completedBtn.classList.add("bg-gray-200", "text-gray-700");
    });

    completedBtn.addEventListener("click", () => {
      completedMatches.classList.remove("hidden");
      upcomingMatches.classList.add("hidden");

      completedBtn.classList.add("bg-green-700", "text-white");
      completedBtn.classList.remove("bg-gray-200", "text-gray-700");

      upcomingBtn.classList.remove("bg-green-700", "text-white");
      upcomingBtn.classList.add("bg-gray-200", "text-gray-700");
    });
  </script>
</body>
</html>