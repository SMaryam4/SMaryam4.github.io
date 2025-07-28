<?php
include 'db.php';
session_start();

$id = $_GET['id'];
$player = $conn->query("SELECT * FROM players WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
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

    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../images/$image");
    } else {
        $image = $player['image'];
    }

    $stmt = $conn->prepare("UPDATE players SET name=?, image=?, matches=?, runs=?, nationality=?, role=?, team=?, featured=?, star_player=?, born=?, major_teams=?, batting_style=?, bowling_style=?, overview=? WHERE id=?");
    $stmt->bind_param("ssiiissiiissssi", $name, $image, $matches, $runs, $nationality, $role, $team, $featured, $star_player, $born, $major_teams, $batting_style, $bowling_style, $overview, $id);
    $stmt->execute();

    header("Location: players.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Player</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <h1 class="text-2xl font-bold mb-4">Edit Player</h1>
  <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-4 bg-white p-4 rounded shadow w-full md:w-1/2">
    <input type="text" name="name" value="<?= $player['name'] ?>" required class="border p-2 rounded" />
    <input type="file" name="image" class="border p-2 rounded" />
    <img src="../images/<?= $player['image'] ?>" class="w-20 mt-1" />
    <input type="number" name="matches" value="<?= $player['matches'] ?>" class="border p-2 rounded" />
    <input type="number" name="runs" value="<?= $player['runs'] ?>" class="border p-2 rounded" />
    <input type="text" name="nationality" value="<?= $player['nationality'] ?>" class="border p-2 rounded" />
    <input type="text" name="role" value="<?= $player['role'] ?>" class="border p-2 rounded" />
    <input type="text" name="team" value="<?= $player['team'] ?>" class="border p-2 rounded" />
    <input type="text" name="born" value="<?= $player['born'] ?>" class="border p-2 rounded" />
    <input type="text" name="major_teams" value="<?= $player['major_teams'] ?>" class="border p-2 rounded" />
    <input type="text" name="batting_style" value="<?= $player['batting_style'] ?>" class="border p-2 rounded" />
    <input type="text" name="bowling_style" value="<?= $player['bowling_style'] ?>" class="border p-2 rounded" />
    <textarea name="overview" class="border p-2 rounded"><?= $player['overview'] ?></textarea>

    <label><input type="checkbox" name="featured" <?= $player['featured'] ? 'checked' : '' ?> /> Featured</label>
    <label><input type="checkbox" name="star_player" <?= $player['star_player'] ? 'checked' : '' ?> /> Star Player</label>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Update Player</button>
  </form>
</body>
</html>
