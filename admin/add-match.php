<?php
include('db.php'); // DB connection

$message = '';

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

    $stmt = $conn->prepare("INSERT INTO schedule (match_date, time, team1, team1_flag, team2, team2_flag, venue, series_name, result, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    // Bind parameters (all are strings)
    $stmt->bind_param("ssssssssss", $match_date, $time, $team1, $team1_flag, $team2, $team2_flag, $venue, $series_name, $result, $status);

    if ($stmt->execute()) {
    header("Location: match-list.php");
    exit;
} else {
    $message = "❌ Error: " . $stmt->error;
}


    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Match</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">
  <div class="max-w-xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-xl font-bold mb-4">Add Match</h2>

    <?php if (!empty($message)): ?>
      <div class="mb-4 text-white px-4 py-2 rounded <?= str_contains($message, '✅') ? 'bg-green-600' : 'bg-red-600' ?>">
        <?= $message ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <input type="date" name="match_date" required class="w-full p-2 border mb-2" placeholder="Date">
      <input type="text" name="time" required class="w-full p-2 border mb-2" placeholder="Time">
      <input type="text" name="team1" required class="w-full p-2 border mb-2" placeholder="Team 1">
      <input type="text" name="team1_flag" class="w-full p-2 border mb-2" placeholder="Team 1 Flag URL (optional)">
      <input type="text" name="team2" required class="w-full p-2 border mb-2" placeholder="Team 2">
      <input type="text" name="team2_flag" class="w-full p-2 border mb-2" placeholder="Team 2 Flag URL (optional)">
      <input type="text" name="venue" required class="w-full p-2 border mb-2" placeholder="Venue">
      <input type="text" name="series_name" class="w-full p-2 border mb-2" placeholder="Series Name (optional)">
      <input type="text" name="result" class="w-full p-2 border mb-2" placeholder="Result (optional)">
      <select name="status" required class="w-full p-2 border mb-4">
        <option value="upcoming">Upcoming</option>
        <option value="completed">Completed</option>
      </select>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add Match</button>
    </form>
  </div>
</body>
</html>
