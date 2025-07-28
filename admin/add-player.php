<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../images/$image");

    $matches = $_POST['matches'];
    $runs = $_POST['runs'];
    $nationality = $_POST['nationality'];
    $role = $_POST['role'];
    $team = $_POST['team'];
    $featured = isset($_POST['featured']) ? 1 : 0;
    $star_player = isset($_POST['star_player']) ? 1 : 0;
    $born = $_POST['born'];
    $major_teams = $_POST['major_teams'];
    $batting_style = $_POST['batting_style'];
    $bowling_style = $_POST['bowling_style'];
    $overview = $_POST['overview'];

    $stmt = $conn->prepare("INSERT INTO players (name, image, matches, runs, nationality, role, team, featured, star_player, born, major_teams, batting_style, bowling_style, overview) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiissiiissss", $name, $image, $matches, $runs, $nationality, $role, $team, $featured, $star_player, $born, $major_teams, $batting_style, $bowling_style, $overview);
    $stmt->execute();

    header("Location: players.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Player</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <h1 class="text-2xl font-bold mb-4">Add New Player</h1>
  <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-4 bg-white p-4 rounded shadow w-full md:w-1/2">
    <input type="text" name="name" placeholder="Player Name" required class="border p-2 rounded" />
    <input type="file" name="image" required class="border p-2 rounded" />
    <input type="number" name="matches" placeholder="Matches" class="border p-2 rounded" />
    <input type="number" name="runs" placeholder="Runs" class="border p-2 rounded" />
    <input type="text" name="nationality" placeholder="Nationality" class="border p-2 rounded" />
    <input type="text" name="role" placeholder="Role (e.g. Batsman)" class="border p-2 rounded" />
    <input type="text" name="team" placeholder="Team" class="border p-2 rounded" />
    <input type="text" name="born" placeholder="Born (e.g. 1995-08-25)" class="border p-2 rounded" />
    <input type="text" name="major_teams" placeholder="Major Teams" class="border p-2 rounded" />
    <input type="text" name="batting_style" placeholder="Batting Style" class="border p-2 rounded" />
    <input type="text" name="bowling_style" placeholder="Bowling Style" class="border p-2 rounded" />
    <textarea name="overview" placeholder="Overview" class="border p-2 rounded"></textarea>

    <label><input type="checkbox" name="featured" /> Featured</label>
    <label><input type="checkbox" name="star_player" /> Star Player</label>

    <button class="bg-green-600 text-white px-4 py-2 rounded">Add Player</button>
  </form>
</body>
</html>
