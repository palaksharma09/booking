<?php
include 'auth.php';
include 'header.php';

$message = '';
$messageType = '';
$categories = [];
$services = [];

// Handle Add Service
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_service') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $categoryId = (int)($_POST['category_id'] ?? 1);
    $icon = trim($_POST['icon'] ?? 'fa-solid fa-wrench');
    $isPopular = isset($_POST['is_popular']) ? 1 : 0;

    if (!empty($name)) {
        $addSql = "INSERT INTO services (name, description, category_id, icon, is_popular) VALUES (?, ?, ?, ?, ?)";
        $addStmt = $conn->prepare($addSql);
        $addStmt->bind_param("ssisi", $name, $description, $categoryId, $icon, $isPopular);

        if ($addStmt->execute()) {
            $message = 'Service added successfully';
            $messageType = 'success';
        } else {
            $message = 'Error adding service';
            $messageType = 'error';
        }
        $addStmt->close();
    } else {
        $message = 'Service name is required';
        $messageType = 'error';
    }
}

// Handle Edit Service
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_service') {
    $serviceId = (int)$_POST['service_id'];
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $categoryId = (int)($_POST['category_id'] ?? 1);
    $icon = trim($_POST['icon'] ?? 'fa-solid fa-wrench');
    $isPopular = isset($_POST['is_popular']) ? 1 : 0;

    if (!empty($name)) {
        $editSql = "UPDATE services SET name = ?, description = ?, category_id = ?, icon = ?, is_popular = ? WHERE id = ?";
        $editStmt = $conn->prepare($editSql);
        $editStmt->bind_param("ssissi", $name, $description, $categoryId, $icon, $isPopular, $serviceId);

        if ($editStmt->execute()) {
            $message = 'Service updated successfully';
            $messageType = 'success';
        } else {
            $message = 'Error updating service';
            $messageType = 'error';
        }
        $editStmt->close();
    } else {
        $message = 'Service name is required';
        $messageType = 'error';
    }
}

// Handle Delete Service
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_service') {
    $serviceId = (int)$_POST['service_id'];
    
    $deleteSql = "DELETE FROM services WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $serviceId);

    if ($deleteStmt->execute()) {
        $message = 'Service deleted successfully';
        $messageType = 'success';
    } else {
        $message = 'Error deleting service (may be in use)';
        $messageType = 'error';
    }
    $deleteStmt->close();
}

// Fetch categories
$categoriesSql = "SELECT id, title AS name, slug FROM categories ORDER BY title";
$categoriesStmt = $conn->prepare($categoriesSql);

if ($categoriesStmt) {
    $categoriesStmt->execute();
    $categoriesResult = $categoriesStmt->get_result();
    $categories = $categoriesResult->fetch_all(MYSQLI_ASSOC);
    $categoriesStmt->close();
} else {
    $message = 'Unable to load categories';
    $messageType = 'error';
    error_log('manage_services.php categories query failed: ' . $conn->error);
}

// Fetch services
$servicesSql = "SELECT s.id, s.name, s.description, s.category_id, s.icon, s.is_popular, c.title AS category_name
                FROM services s
                LEFT JOIN categories c ON c.id = s.category_id
                ORDER BY s.is_popular DESC, s.name";
$servicesStmt = $conn->prepare($servicesSql);

if ($servicesStmt) {
    $servicesStmt->execute();
    $servicesResult = $servicesStmt->get_result();
    $services = $servicesResult->fetch_all(MYSQLI_ASSOC);
    $servicesStmt->close();
} else {
    $message = 'Unable to load services';
    $messageType = 'error';
    error_log('manage_services.php services query failed: ' . $conn->error);
}
?>

<div class="admin-container">
    <!-- Page Header -->
    <div class="admin-page-header">
        <div class="header-content">
            <h1>Manage Services</h1>
            <p>Total Services: <strong><?php echo count($services); ?></strong></p>
        </div>
    </div>

    <!-- Messages -->
    <?php if ($message): ?>
        <div class="alert alert-<?php echo htmlspecialchars($messageType); ?>">
            <i class="fa-solid fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Add Service Form -->
    <div class="dashboard-card">
        <div class="card-header">
            <h2>Add New Service</h2>
        </div>
        <div class="card-body">
            <form method="POST" class="form-grid">
                <input type="hidden" name="action" value="add_service">

                <div class="form-group">
                    <label for="name">Service Name *</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="icon">Icon Class</label>
                    <input type="text" id="icon" name="icon" class="form-control" placeholder="e.g., fa-solid fa-wrench" value="fa-solid fa-wrench">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group checkbox">
                    <input type="checkbox" id="is_popular" name="is_popular" value="1">
                    <label for="is_popular">Mark as Popular</label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add Service
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Services List -->
    <div class="dashboard-card">
        <div class="card-header">
            <h2>All Services</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($services)): ?>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Icon</th>
                                <th>Popular</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($service['name']); ?></td>
                                    <td><?php echo htmlspecialchars($service['category_name'] ?? 'N/A'); ?></td>
                                    <td>
                                        <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                                    </td>
                                    <td>
                                        <?php if ($service['is_popular']): ?>
                                            <span class="badge badge-success">Yes</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon btn-edit" title="Edit Service" onclick="toggleEditForm(<?php echo $service['id']; ?>)">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-delete" title="Delete Service" onclick="deleteService(<?php echo $service['id']; ?>, '<?php echo htmlspecialchars(addslashes($service['name'])); ?>')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Edit Form -->
                                        <div class="edit-form" id="edit-form-<?php echo $service['id']; ?>" style="display:none; margin-top:15px; padding:15px; border:1px solid var(--border-light); border-radius:8px;">
                                            <form method="POST">
                                                <input type="hidden" name="action" value="edit_service">
                                                <input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">

                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($service['name']); ?>" required>
                                                </div>

                                                <div class="form-group">
                                                    <label>Category</label>
                                                    <select name="category_id" class="form-control">
                                                        <?php foreach ($categories as $cat): ?>
                                                            <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $service['category_id']) ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($cat['name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Icon</label>
                                                    <input type="text" name="icon" class="form-control" value="<?php echo htmlspecialchars($service['icon']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($service['description'] ?? ''); ?></textarea>
                                                </div>

                                                <div class="form-group checkbox">
                                                    <input type="checkbox" name="is_popular" value="1" <?php echo $service['is_popular'] ? 'checked' : ''; ?>>
                                                    <label>Mark as Popular</label>
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" class="btn-small btn-primary">Update</button>
                                                    <button type="button" class="btn-small btn-secondary" onclick="toggleEditForm(<?php echo $service['id']; ?>)">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No services found</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleEditForm(serviceId) {
    const form = document.getElementById('edit-form-' + serviceId);
    if (form) {
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
}

function deleteService(serviceId, serviceName) {
    if (confirmAction('Are you sure you want to delete ' + serviceName + '?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete_service">
            <input type="hidden" name="service_id" value="${serviceId}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php include 'footer.php'; ?>
