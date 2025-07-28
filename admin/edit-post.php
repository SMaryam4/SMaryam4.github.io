<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "pak_cricket"); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    echo "No post ID specified.";
    exit();
}

$postId = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    $conn->query("UPDATE blog_posts SET title = '$title', content = '$content' WHERE id = $postId");

    header("Location: admin-manage-blog.php");
    exit();
}

$result = $conn->query("SELECT * FROM blog_posts WHERE id = $postId");

if ($result->num_rows === 0) {
    echo "Post not found.";
    exit();
}

$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Post</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="max-w-3xl mx-auto p-6">
  <h1 class="text-3xl font-bold mb-6">Edit Post</h1>

  <form method="POST" class="bg-white p-6 rounded shadow">
    <label class="block mb-2 font-semibold">Title</label>
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required class="w-full p-2 border border-gray-300 rounded mb-4">

    <label class="block mb-2 font-semibold">Content</label>
    <textarea name="content" rows="10" required class="w-full p-2 border border-gray-300 rounded mb-4"><?= htmlspecialchars($post['content']) ?></textarea>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Post</button>
    <a href="admin-manage-blog.php" class="ml-4 text-gray-600 hover:underline">Cancel</a>
  </form>
</div>

</body>
</html>
