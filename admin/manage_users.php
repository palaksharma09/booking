<?php
include 'auth.php';
include 'header.php';

// Handle Delete User
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_user') {
    $userId = (int)$_POST['user_id'];
    
    // Prevent admin from deleting themselves
    if ($userId !== $_SESSION['user_id']) {
        $deleteSql = "DELETE FROM users WHERE user_id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $userId);
        
        if ($deleteStmt->execute()) {
            $deleteStmt->close();
            header("Location: manage_users.php?message=User deleted successfully");
            exit();
        }
        $deleteStmt->close();
    }
}

// Handle Change Role
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'change_role') {
    $userId = (int)$_POST['user_id'];
    $newRole = in_array($_POST['role'], ['user', 'admin']) ? $_POST['role'] : 'user';
    
    // Prevent self-role change
    if ($userId !== $_SESSION['user_id']) {
        $updateSql = "UPDATE users SET role = ? WHERE user_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $newRole, $userId);
        
        if ($updateStmt->execute()) {
            $updateStmt->close();
            header("Location: manage_users.php?message=User role updated");
            exit();
        }
        $updateStmt->close();
    }
}

// Fetch all users
$usersSql = "SELECT user_id, user_name, user_email_id, role, phone, created_at FROM users ORDER BY created_at DESC";
$usersStmt = $conn->prepare($usersSql);
$usersStmt->execute();
$usersResult = $usersStmt->get_result();
$users = $usersResult->fetch_all(MYSQLI_ASSOC);
$usersStmt->close();

// Count users by role
$adminCount = array_sum(array_map(function($u) { return $u['role'] === 'admin' ? 1 : 0; }, $users));
$userCount = count($users) - $adminCount;
?>

<div class="admin-container">
    <!-- Page Header -->
    <div class="admin-page-header">
        <div class="header-content">
            <h1>Manage Users</h1>
            <p>Total Users: <strong><?php echo count($users); ?></strong> (<?php echo $adminCount; ?> Admins, <?php echo $userCount; ?> Regular Users)</p>
        </div>
    </div>

    <!-- Success Message -->
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle"></i>
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Users Table -->
    <div class="dashboard-card">
        <div class="card-header">
            <h2>All Users</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($users)): ?>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Member Since</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <div class="user-cell">
                                            <div class="user-avatar">
                                                <i class="fa-regular fa-user"></i>
                                            </div>
                                            <span><?php echo htmlspecialchars($user['user_name']); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['user_email_id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="role-badge role-<?php echo htmlspecialchars($user['role']); ?>">
                                            <?php echo ucfirst($user['role']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <?php if ($user['user_id'] !== $_SESSION['user_id']): ?>
                                                <button class="btn-icon btn-role" title="Change Role" onclick="toggleRoleForm(<?php echo $user['user_id']; ?>)">
                                                    <i class="fa-solid fa-shield"></i>
                                                </button>
                                                <button class="btn-icon btn-delete" title="Delete User" onclick="deleteUser(<?php echo $user['user_id']; ?>, '<?php echo htmlspecialchars(addslashes($user['user_name'])); ?>')">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            <?php else: ?>
                                                <span class="badge-current">Current User</span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Role Change Form -->
                                        <div class="role-form" id="role-form-<?php echo $user['user_id']; ?>" style="display:none;">
                                            <form method="POST" style="display:flex; gap:8px;">
                                                <input type="hidden" name="action" value="change_role">
                                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                                <select name="role" class="form-control" style="width:120px;">
                                                    <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                                                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                </select>
                                                <button type="submit" class="btn-small btn-primary">Update</button>
                                                <button type="button" class="btn-small btn-secondary" onclick="toggleRoleForm(<?php echo $user['user_id']; ?>)">Cancel</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No users found</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleRoleForm(userId) {
    const form = document.getElementById('role-form-' + userId);
    if (form) {
        form.style.display = form.style.display === 'none' ? 'flex' : 'none';
    }
}

function deleteUser(userId, userName) {
    if (confirmAction('Are you sure you want to delete ' + userName + '? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete_user">
            <input type="hidden" name="user_id" value="${userId}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php include 'footer.php'; ?>
