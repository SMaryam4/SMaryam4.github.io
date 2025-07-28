<?php
include 'admin/db.php';

$query = $_GET['query'] ?? '';

$stmt = $conn->prepare("SELECT id, name, image FROM players WHERE name LIKE CONCAT('%', ?, '%')");
$stmt->bind_param("s", $query);
$stmt->execute();
$result = $stmt->get_result();

$players = [];

while ($row = $result->fetch_assoc()) {
    $players[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        // ✅ Make sure the path matches your actual folder (admin/image/)
        'image_url' => 'images/' . $row['image']
    ];
}

// Set header to JSON
header('Content-Type: application/json');
echo json_encode($players);
