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
      <a href="psl.php" class="hover:underline">PSL</a>
      <a href="news.php" class="hover:underline">News</a>
      <a href="admin/blog.php" class="hover:underline">Blog</a>
      <a href="#" onclick="toggleChat()" class="hover:underline text-yellow-300 font-semibold">💬 Live Chat</a>
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


<!-- Live Chat Modal -->
<div id="chat-container" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
  <div class="bg-white text-black rounded shadow-lg p-4 max-w-xl w-full relative">
  <div class="bg-white text-black rounded shadow-lg p-4 max-w-xl w-full relative">
    <button onclick="toggleChat()" class="absolute top-2 right-2 text-red-600 font-bold text-xl">&times;</button>
    <h2 class="text-xl font-bold text-green-700 mb-2">Live Chat</h2>
    <div id="chat-box" class="h-64 overflow-y-auto border border-gray-300 p-2 bg-gray-50 rounded mb-2"></div>
    <div class="flex gap-2">
      <input id="username" type="text" value="<?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : '' ?>" placeholder="Your name" class="border rounded px-2 py-1 w-1/4" />
      <input id="message" type="text" placeholder="Type your message" class="border rounded px-2 py-1 flex-grow" />
      <button onclick="sendMessage()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Send</button>
    </div>
  </div>
</div>

<!-- Firebase Scripts -->
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-database.js"></script>

<script>
  // Firebase Config
  const firebaseConfig = {
    apiKey: "AIzaSyDLisYU4oAzbSdD5-ZMG1hhZYAit6Tfc6w",
    authDomain: "cricket-23d46.firebaseapp.com",
    databaseURL: "https://cricket-23d46-default-rtdb.firebaseio.com",
    projectId: "cricket-23d46",
    storageBucket: "cricket-23d46.appspot.com",
    messagingSenderId: "532462884236",
    appId: "1:532462884236:web:07d7bf83780cf5254e32a9",
    measurementId: "G-27PR888Q3Q"
  };

  firebase.initializeApp(firebaseConfig);
  const db = firebase.database();

  // Toggle Chat
  function toggleChat() {
    const chat = document.getElementById('chat-container');
    chat.classList.toggle('hidden');
  }

  // Send Message
  function sendMessage() {
    const username = document.getElementById('username').value.trim();
    const message = document.getElementById('message').value.trim();

    if (username && message) {
      db.ref("messages").push({
        username: username,
        message: message,
        timestamp: Date.now()
      });
      document.getElementById('message').value = "";
    }
  }

  // Listen to messages
  db.ref("messages").on("child_added", function(snapshot) {
    const data = snapshot.val();
    const chatBox = document.getElementById('chat-box');
    const msg = document.createElement('div');
    msg.className = "mb-1";
    msg.innerHTML = `<strong>${data.username}:</strong> ${data.message}`;
    chatBox.appendChild(msg);
    chatBox.scrollTop = chatBox.scrollHeight;
  });
</script>

</body>
</html>
