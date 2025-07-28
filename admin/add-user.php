<?php
include('db.php');

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];
    $profile_image = '';

    if (!empty($_FILES['profile_image']['name'])) {
        $file_name = time() . '_' . $_FILES['profile_image']['name'];
        $target = '../uploads/' . $file_name;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);
        $profile_image = 'uploads/' . $file_name;
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, profile_image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, $email, $password, $role, $profile_image);

    if ($stmt->execute()) {
        header("Location: users.php"); // ✅ redirect after success
        exit();
    } else {
        $message = "❌ Error: " . $stmt->error;
    }
}
?>


<!-- ✅ HTML should come after PHP is closed -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="max-w-xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4 text-center">➕ Add New User</h1>

        <?php if (!empty($message)): ?>
            <div class="mb-4 text-white px-4 py-2 rounded <?= strpos($message, '✅') !== false ? 'bg-green-600' : 'bg-red-600' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold">Username</label>
                <input type="text" name="username" required class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-semibold">Email</label>
                <input type="email" name="email" required class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-semibold">Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-semibold">Role</label>
                <select name="role" required class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold">Profile Image</label>
                <input type="file" name="profile_image" class="w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2 rounded">
                    Add User
                </button>
            </div>
        </form>
    </div>

</body>
</html>
