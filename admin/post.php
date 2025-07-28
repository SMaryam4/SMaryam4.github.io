<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "pak_cricket");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_ip = $_SERVER['REMOTE_ADDR'];

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid post ID.");
}

$post_id = (int) $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reaction'])) {
    $reaction = $conn->real_escape_string($_POST['reaction']);
    $check = $conn->query("SELECT * FROM blog_likes WHERE post_id = $post_id AND user_ip = '$user_ip'");
    if ($check->num_rows === 0) {
        $conn->query("INSERT INTO blog_likes (post_id, user_ip, reaction) VALUES ($post_id, '$user_ip', '$reaction')");
    } else {
        $conn->query("UPDATE blog_likes SET reaction = '$reaction' WHERE post_id = $post_id AND user_ip = '$user_ip'");
    }
    header("Location: post.php?id=$post_id");
    exit;
}

$post_result = $conn->query("SELECT * FROM blog_posts WHERE id = $post_id");
if ($post_result->num_rows === 0) {
    die("Post not found.");
}
$post = $post_result->fetch_assoc();

$reaction_types = ['like' => '👍', 'love' => '❤️', 'funny' => '😆', 'wow' => '😮', 'sad' => '😢', 'angry' => '😡'];
$reaction_counts = [];
foreach ($reaction_types as $key => $emoji) {
    $count_result = $conn->query("SELECT COUNT(*) AS count FROM blog_likes WHERE post_id = $post_id AND reaction = '$key'");
    $reaction_counts[$key] = $count_result->fetch_assoc()['count'] ?? 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = $conn->real_escape_string($_POST['comment']);
    $conn->query("INSERT INTO blog_comments (post_id, comment) VALUES ($post_id, '$comment')");
}

$comments = $conn->query("SELECT * FROM blog_comments WHERE post_id = $post_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <header class="bg-green-700 text-white py-4 shadow sticky top-0 z-50">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">🏏 Pakistan Cricket</h1>
            <nav class="space-x-4">
                <a href="/cricket/home.php" class="hover:underline">Home</a>
                <a href="/cricket/schedule.php" class="hover:underline">Schedule</a>
                <a href="/cricket/players.php" class="hover:underline">Players</a>
                <a href="/cricket/psl.php" class="hover:underline">PSL</a>
                <a href="cricket/news.php" class="hover:underline">News</a>
                <a href="cricket/blog.php" class="hover:underline font-semibold underline">Blog</a>
            </nav>
        </div>
    </header>

    <!-- Blog Content -->
    <main class="max-w-3xl mx-auto mt-10 px-4">
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-3xl font-bold text-green-700 mb-4"><?= htmlspecialchars($post['title']) ?></h2>
            <p class="text-gray-700 leading-relaxed mb-6 whitespace-pre-line"><?= nl2br(htmlspecialchars($post['content'])) ?></p>

            <!-- Reactions -->
            <div class="mb-6">
                <form method="POST" class="flex flex-wrap gap-3">
                    <?php foreach ($reaction_types as $key => $emoji): ?>
                        <button name="reaction" value="<?= $key ?>" class="flex items-center gap-1 px-3 py-1 bg-gray-100 hover:bg-blue-100 rounded-full text-sm shadow-sm transition">
                            <span><?= $emoji ?></span>
                            <span class="font-medium">(<?= $reaction_counts[$key] ?>)</span>
                        </button>
                    <?php endforeach; ?>
                </form>
            </div>

            <!-- Comment Form -->
            <form method="POST" class="mb-6">
                <label class="block font-semibold mb-1">Add a Comment</label>
                <textarea name="comment" rows="3" required class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-green-500 resize-none" placeholder="Write your comment..."></textarea>
                <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-sm">Post Comment</button>
            </form>

            <!-- Comment List -->
            <h3 class="text-xl font-semibold mb-3">Comments</h3>
            <div class="space-y-4">
                <?php if ($comments->num_rows > 0): ?>
                    <?php while ($row = $comments->fetch_assoc()): ?>
                        <div class="bg-gray-50 p-3 rounded shadow-sm border border-gray-200">
                            <?= htmlspecialchars($row['comment']) ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-gray-500 italic">No comments yet. Be the first!</p>
                <?php endif; ?>
            </div>

            <a href="blog.php" class="inline-block mt-6 text-blue-600 hover:underline">← Back to Blog</a>
        </div>
    </main>

    <footer class="text-center text-sm text-gray-500 py-6 mt-10">
        © <?= date('Y') ?> Pakistan Cricket Blog
    </footer>
</body>
</html>
