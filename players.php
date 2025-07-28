<?php
include 'admin/db.php';

// Show some players by default
$result = $conn->query("SELECT * FROM players ORDER BY id DESC LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Players</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

<!-- ✅ Navbar -->
<header class="sticky top-0 bg-green-700 text-white p-4">
  <div class="container mx-auto flex justify-between items-center">
    <h1 class="text-2xl font-bold">🏏 Pakistan Cricket</h1>
    <nav class="space-x-4">
      <a href="home.php" class="hover:underline">Home</a>
      <a href="schedule.php" class="hover:underline">Schedule</a>
      <a href="players.php" class="hover:underline ">Players</a>
      <a href="psl.php" class="hover:underline">Psl</a>
      <a href="news.php" class="hover:underline">News</a>
      <a href="admin/blog.php" class="hover:underline">Blog</a>
    </nav>
  </div>
</header>

<!-- ✅ Main Section -->
<section class="py-12 px-4">
  <h2 class="text-3xl font-bold text-center mb-6">Team Players</h2>

  <!-- 🔍 Search Form -->
  <form id="searchForm" class="flex justify-center mb-6">
    <input
      type="text"
      id="searchInput"
      name="query"
      placeholder="Search player..."
      class="border px-4 py-2 rounded w-64"
    />
    <button type="submit" class="ml-2 bg-green-600 text-white px-4 py-2 rounded">
      Search
    </button>
  </form>

  <!-- 👥 Player Cards -->
  <div id="playerCards" class="grid md:grid-cols-3 gap-6 max-w-6xl mx-auto">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="bg-white shadow-md rounded-lg p-4 text-center">
        <img src="images/<?= htmlspecialchars($row['image']) ?>" class="w-24 h-24 mx-auto rounded-full mb-2" alt="<?= htmlspecialchars($row['name']) ?>">
        <h3 class="font-semibold"><?= htmlspecialchars($row['name']) ?></h3>
        <a href="player_profile.php?id=<?= $row['id'] ?>" class="mt-3 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
          View Profile
        </a>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<!-- ✅ JS for search -->
<script>
const input = document.getElementById('searchInput');
const searchForm = document.getElementById('searchForm');
const playerCards = document.getElementById('playerCards');

function fetchPlayers(query) {
  fetch('search_players.php?query=' + encodeURIComponent(query))
    .then(res => res.json())
    .then(data => {
      playerCards.innerHTML = '';

      if (data.length === 0) {
        playerCards.innerHTML = '<p class="text-red-600 text-center col-span-3">No players found.</p>';
        return;
      }

      data.forEach(player => {
        const card = document.createElement('div');
        card.className = 'bg-white shadow-md rounded-lg p-4 text-center';
        card.innerHTML = `
          <img src="${player.image_url}" class="w-24 h-24 mx-auto rounded-full mb-2" alt="${player.name}">
          <h3 class="font-semibold">${player.name}</h3>
          <a href="player_profile.php?id=${player.id}" class="mt-3 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            View Profile
          </a>
        `;
        playerCards.appendChild(card);
      });
    });
}

searchForm.addEventListener('submit', function(e) {
  e.preventDefault();
  const query = input.value.trim();
  if (query !== '') {
    fetchPlayers(query);
  }
});
</script>

</body>
</html>
