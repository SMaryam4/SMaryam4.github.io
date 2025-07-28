<?php
// You can add session checks here if needed
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto p-6">
  <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

<div class="grid grid-cols-2 gap-6">
    <a href="admin-manage-blog.php" class="bg-blue-600 text-white p-6 rounded shadow hover:bg-blue-700">
      Manage Posts
    </a>
    <a href="match-list.php" class="bg-green-600 text-white p-6 rounded shadow hover:bg-green-700">
      Manage Matches
    </a>
    <a href="users.php" class="bg-purple-600 text-white p-6 rounded shadow hover:bg-purple-700">
      Manage Users
    </a>
    <a href="manage-news.php" class="bg-yellow-600 text-white p-6 rounded shadow hover:bg-yellow-700">
      Manage News
    </a>
    <a href="players.php" class="bg-indigo-600 text-white p-6 rounded shadow hover:bg-indigo-700">
      Manage Players
    </a>
    <a href="manage-player-stats.php?player_id=1" class="bg-pink-600 text-white p-6 rounded shadow hover:bg-pink-700">
      Manage Player Stats
    </a>
     <a href="manage-psl-teams.php?player_id=1" class="bg-pink-600 text-white p-6 rounded shadow hover:bg-pink-700">
      Manage Psl teams
    </a>
     <a href="manage-psl-matches.php?player_id=1" class="bg-pink-600 text-white p-6 rounded shadow hover:bg-pink-700">
      Manage Psl matches
    </a>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
  <a href="manage-psl-players.php" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow text-center">
    🧑‍💼 Manage PSL Players
  </a>
  <a href="manage-psl-stats.php" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg shadow text-center">
    📊 Manage PSL Player Stats
  </a>
</div>


  </div>

  <a href="logout.php" class="inline-block mt-6 text-red-600 hover:underline">Logout</a>
</div>
</body>
</html>
