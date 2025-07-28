<?php
include("db.php");

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'] ?? '';
    $detail = $_POST['detail'];

    $stmt = $conn->prepare("INSERT INTO news (title, description, image_url, detail) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $image_url, $detail);

    if ($stmt->execute()) {
        header("Location: manage-news.php");
        exit;
    } else {
        $message = "❌ Failed to add news: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add News</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 text-gray-800">
  <div class="max-w-2xl mx-auto bg-white p-6 shadow rounded">
    <h2 class="text-xl font-bold mb-4">Add News</h2>

    <?php if (!empty($message)): ?>
      <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input type="text" name="title" placeholder="News Title" required class="w-full p-2 border rounded">
      <textarea name="description" placeholder="Short Description" required class="w-full p-2 border rounded"></textarea>
      <input type="text" name="image_url" placeholder="Image URL" class="w-full p-2 border rounded">
      <textarea name="detail" placeholder="Full Detail" required class="w-full p-2 border rounded"></textarea>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add News</button>
    </form>
  </div>
</body>
</html>
