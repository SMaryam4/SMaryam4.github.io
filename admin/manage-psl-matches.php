<?php
include 'db.php';

$matches = $conn->query("SELECT m.*, t1.name AS team1_name, t2.name AS team2_name FROM psl_matches m 
JOIN psl_teams t1 ON m.team_1 = t1.id 
JOIN psl_teams t2 ON m.team_2 = t2.id 
ORDER BY match_date ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage PSL Matches</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">

<a href="add-psl-match.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded inline-block mb-4">➕ Add PSL Match</a>

<?php if (isset($_GET['success'])): ?>
<div class="bg-green-100 text-green-800 p-2 rounded mb-4">Match added successfully!</div>
<?php endif; ?>

<h1 class="text-xl font-bold mb-4">PSL Matches</h1>

<table class="w-full bg-white shadow-md rounded border border-gray-200">
    <thead class="bg-gray-100">
        <tr class="text-left">
            <th class="p-2">Team 1</th>
            <th class="p-2">Team 2</th>
            <th class="p-2">Date</th>
            <th class="p-2">Time</th>
            <th class="p-2">Stadium</th>
            <th class="p-2">Result</th>
            <th class="p-2">Status</th>
            <th class="p-2">Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $matches->fetch_assoc()): ?>
        <tr class="border-t">
            <td class="p-2"><?= $row['team1_name'] ?></td>
            <td class="p-2"><?= $row['team2_name'] ?></td>
            <td class="p-2"><?= $row['match_date'] ?></td>
            <td class="p-2"><?= $row['match_time'] ?></td>
            <td class="p-2"><?= $row['stadium'] ?></td>
            <td class="p-2"><?= $row['result'] ?></td>
            <td class="p-2">
                <span class="px-2 py-1 rounded text-white <?= $row['status'] == 'upcoming' ? 'bg-blue-500' : 'bg-green-600' ?>">
                    <?= ucfirst($row['status']) ?>
                </span>
            </td>
            <td class="p-2 space-x-2">
    <a href="edit-psl-match.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
    <a href="delete-psl-match.php?id=<?= $row['id'] ?>" 
       class="text-red-600 hover:underline" 
       onclick="return confirm('Are you sure you want to delete this match?');">
       Delete
    </a>
</td>

        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
