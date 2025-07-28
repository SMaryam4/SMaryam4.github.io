<?php
include('db.php');

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search & Filter
$search = $_GET['search'] ?? '';
$role = $_GET['role'] ?? '';

// Build dynamic WHERE clause
$where = "WHERE 1=1";
if (!empty($search)) {
    $searchEscaped = $conn->real_escape_string($search);
    $where .= " AND (username LIKE '%$searchEscaped%' OR email LIKE '%$searchEscaped%')";
}
if (!empty($role)) {
    $roleEscaped = $conn->real_escape_string($role);
    $where .= " AND role = '$roleEscaped'";
}

// Count total records
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM users $where");
$totalResult = $totalQuery->fetch_assoc();
$totalUsers = $totalResult['total'];
$totalPages = ceil($totalUsers / $limit);

// Fetch paginated users
$users = $conn->query("SELECT * FROM users $where ORDER BY id DESC LIMIT $start, $limit");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6 text-gray-800">
  <div class="mb-4">
  <a href="admin-dashboard.php" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded inline-block">
    🔙 Back to Admin Dashboard
  </a>
</div>


<div class="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">All Users</h2>
        <a href="add-user.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Add New User</a>
    </div>

    <!-- Search + Filter -->
    <form method="GET" class="mb-4 flex flex-wrap gap-4 items-center">
        <input type="text" name="search" placeholder="Search by username or email" value="<?= htmlspecialchars($search) ?>"
               class="border border-gray-300 px-3 py-2 rounded w-60">
        <select name="role" class="border border-gray-300 px-3 py-2 rounded">
            <option value="">All Roles</option>
            <option value="admin" <?= $role == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?= $role == 'user' ? 'selected' : '' ?>>User</option>
        </select>
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Filter</button>

        <?php if (!empty($search) || !empty($role)): ?>
            <a href="users.php" class="text-sm text-blue-600 underline ml-4">All Users</a>
        <?php endif; ?>
    </form>

    <!-- Users Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 text-sm">
            <thead>
            <tr class="bg-gray-200 text-left">
                <th class="px-4 py-3 border">ID</th>
                <th class="px-4 py-3 border">Profile</th>
                <th class="px-4 py-3 border">Username</th>
                <th class="px-4 py-3 border">Email</th>
                <th class="px-4 py-3 border">Role</th>
                <th class="px-4 py-3 border">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($users->num_rows > 0): ?>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border"><?= $row['id'] ?></td>
                        <td class="px-4 py-2 border">
                            <?php if ($row['profile_image']): ?>
                                <img src="../<?= $row['profile_image'] ?>" class="w-10 h-10 rounded-full object-cover" alt="Profile">
                            <?php else: ?>
                                <span class="text-gray-400">No image</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-2 border"><?= htmlspecialchars($row['username']) ?></td>
                        <td class="px-4 py-2 border"><?= htmlspecialchars($row['email']) ?></td>
                        <td class="px-4 py-2 border">
                            <span class="px-2 py-1 rounded-full text-sm
                                  <?= $row['role'] == 'admin' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                                <?= ucfirst($row['role']) ?>
                            </span>
                        </td>
                        <td class="px-4 py-2 border">
                            <a href="update-user.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a> |
                            <a href="delete-user.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">No users found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <div class="mt-6 flex justify-center items-center gap-2">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?search=<?= urlencode($search) ?>&role=<?= urlencode($role) ?>&page=<?= $i ?>"
                   class="px-3 py-1 rounded border <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
