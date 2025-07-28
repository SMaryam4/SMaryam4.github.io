<?php
include("db.php");

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $image_url = trim($_POST['image_url'] ?? '');
    $detail = trim($_POST['detail']);

    $stmt = $conn->prepare("INSERT INTO news (title, description, image_url, detail) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $title, $description, $image_url, $detail);
        if ($stmt->execute()) {
            // ✅ Redirect to manage-news.php after successful insertion
            header("Location: manage-news.php");
            exit;
        } else {
            $message = "❌ Failed to add news: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "❌ SQL Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add News</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 text-gray-800">
  <div class="max-w-2xl mx-auto bg-white p-6 shadow rounded">
    <h2 class="text-xl font-bold mb-4">Add News</h2>

    <?php if (!empty($message)): ?>
      <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input type="text" name="title" placeholder="News Title" required class="w-full p-2 border rounded">
      <textarea name="description" placeholder="Short Description" required class="w-full p-2 border rounded"></textarea>
      <input type="text" name="image_url" placeholder="Image URL (optional)" class="w-full p-2 border rounded">
      <textarea name="detail" placeholder="Full Detail" required class="w-full p-2 border rounded"></textarea>

      <div class="flex justify-end">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          ➕ Add News
        </button>
      </div>
    </form>
  </div>
</body>
</html>
