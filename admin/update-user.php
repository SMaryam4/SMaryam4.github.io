<?php
include('db.php');

// Get user by ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();

if (!$user) {
    die("❌ User not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $profile_image = $user['profile_image'];

    // If new image is uploaded
    if (!empty($_FILES['profile_image']['name'])) {
        $file_name = time() . '_' . $_FILES['profile_image']['name'];
        $target = '../uploads/' . $file_name;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);
        $profile_image = 'uploads/' . $file_name;
    }

    // Update query
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ?, profile_image = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $username, $email, $role, $profile_image, $id);
    if ($stmt->execute()) {
        header("Location: users.php");
        exit;
    } else {
        die("❌ Update failed: " . $stmt->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-xl mx-auto bg-white p-8 shadow-md rounded">
        <h2 class="text-2xl font-bold mb-6 text-center text-green-700">Update User</h2>

        <form method="POST" enctype="multipart/form-data" class="space-y-5">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required class="w-full border border-gray-300 rounded px-4 py-2">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required class="w-full border border-gray-300 rounded px-4 py-2">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Role</label>
                <select name="role" required class="w-full border border-gray-300 rounded px-4 py-2">
                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-1">Profile Image</label>
                <input type="file" name="profile_image" class="w-full border border-gray-300 rounded px-4 py-2">
                <?php if (!empty($user['profile_image'])): ?>
                    <img src="../<?= $user['profile_image'] ?>" alt="Current Image" class="mt-3 w-20 h-20 object-cover rounded">
                <?php endif; ?>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">Update User</button>
                <a href="users.php" class="ml-4 text-sm text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
