<?php
include('db.php');

$message = '';

// Check if match ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid or missing match ID.");
}

$id = (int)$_GET['id'];

// Fetch existing match data
$stmt = $conn->prepare("SELECT * FROM schedule WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Match not found.");
}

$match = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $match_date   = $_POST['match_date'];
    $time         = $_POST['time'];
    $team1        = $_POST['team1'];
    $team1_flag   = $_POST['team1_flag'] ?? '';
    $team2        = $_POST['team2'];
    $team2_flag   = $_POST['team2_flag'] ?? '';
    $venue        = $_POST['venue'];
    $series_name  = $_POST['series_name'] ?? '';
    $result       = $_POST['result'] ?? '';
    $status       = $_POST['status'];

    $stmt = $conn->prepare("UPDATE schedule SET match_date=?, time=?, team1=?, team1_flag=?, team2=?, team2_flag=?, venue=?, series_name=?, result=?, status=? WHERE id=?");
    $stmt->bind_param("ssssssssssi", $match_date, $time, $team1, $team1_flag, $team2, $team2_flag, $venue, $series_name, $result, $status, $id);

    if ($stmt->execute()) {
        header("Location: match-list.php");
        exit;
    } else {
        $message = "❌ Update failed: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Match</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
  <div class="max-w-xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-xl font-bold mb-4">Edit Match</h2>

    <?php if (!empty($message)): ?>
      <div class="mb-4 text-white px-4 py-2 rounded <?= str_contains($message, '❌') ? 'bg-red-600' : 'bg-green-600' ?>">
        <?= $message ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <input type="date" name="match_date" value="<?= $match['match_date'] ?>" required class="w-full p-2 border mb-2">
      <input type="text" name="time" value="<?= $match['time'] ?>" required class="w-full p-2 border mb-2" placeholder="Time">
      <input type="text" name="team1" value="<?= $match['team1'] ?>" required class="w-full p-2 border mb-2" placeholder="Team 1">
      <input type="text" name="team1_flag" value="<?= $match['team1_flag'] ?>" class="w-full p-2 border mb-2" placeholder="Team 1 Flag URL">
      <input type="text" name="team2" value="<?= $match['team2'] ?>" required class="w-full p-2 border mb-2" placeholder="Team 2">
      <input type="text" name="team2_flag" value="<?= $match['team2_flag'] ?>" class="w-full p-2 border mb-2" placeholder="Team 2 Flag URL">
      <input type="text" name="venue" value="<?= $match['venue'] ?>" required class="w-full p-2 border mb-2" placeholder="Venue">
      <input type="text" name="series_name" value="<?= $match['series_name'] ?>" class="w-full p-2 border mb-2" placeholder="Series Name">
      <input type="text" name="result" value="<?= $match['result'] ?>" class="w-full p-2 border mb-2" placeholder="Result">
      <select name="status" required class="w-full p-2 border mb-4">
        <option value="upcoming" <?= $match['status'] == 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
        <option value="completed" <?= $match['status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
      </select>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Match</button>
    </form>
  </div>
</body>
</html>
