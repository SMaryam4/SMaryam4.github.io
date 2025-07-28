<?php
session_start();
include("db.php");

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // For now, assume passwords are stored in plain text (not secure)
        if ($password === $hashed_password) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user_id;
            header("Location: admin-dashboard.php");
            exit;
        } else {
            $error = "❌ Invalid password.";
        }
    } else {
        $error = "❌ User not found.";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <form method="POST" class="bg-white p-8 shadow-md rounded w-96">
    <h2 class="text-2xl font-bold mb-4 text-center">Admin Login</h2>
    
    <?php if (!empty($error)): ?>
      <p class="text-red-500 mb-4"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <input name="username" type="text" placeholder="Username" required class="w-full mb-4 px-4 py-2 border rounded" />
    <input name="password" type="password" placeholder="Password" required class="w-full mb-4 px-4 py-2 border rounded" />
    <button type="submit" class="bg-green-600 text-white w-full py-2 rounded">Login</button>
  </form>
</body>
</html>
