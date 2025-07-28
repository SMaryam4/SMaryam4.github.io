<?php
$conn = new mysqli("localhost", "root", "", "pak_cricket");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $sql = "INSERT INTO blog_posts (title, content) VALUES ('$title', '$content')";
    $conn->query($sql);

    header("Location: admin-manage-blog.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add New Blog Post</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <a href="admin-manage-blog.php" class="inline-block mt-6 text-blue-600 hover:underline">← Back to manage blogs</a>
</div>


<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-3xl font-bold mb-6">Add New Blog Post</h1>

  <form method="POST" class="bg-white p-6 rounded shadow">
    <label class="block mb-2 font-semibold">Title</label>
    <input type="text" name="title" required class="w-full p-2 border border-gray-300 rounded mb-4">

    <label class="block mb-2 font-semibold">Content</label>
    <textarea name="content" rows="10" required class="w-full p-2 border border-gray-300 rounded mb-4"></textarea>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Post</button>
    <a href="admin-manage-blog.php" class="ml-4 text-gray-600 hover:underline">Cancel</a>
  </form>
</div>

</body>
</html>
