<?php
include 'auth.php';
include 'header.php';

$message = '';
$messageType = '';

// Handle Update Booking Status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $bookingId = (int)$_POST['booking_id'];
    $newStatus = in_array($_POST['status'], ['pending', 'confirmed', 'completed', 'cancelled']) ? $_POST['status'] : 'pending';

    $updateSql = "UPDATE bookings SET status = ? WHERE booking_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("si", $newStatus, $bookingId);

    if ($updateStmt->execute()) {
        $message = 'Booking status updated successfully';
        $messageType = 'success';
    } else {
        $message = 'Error updating booking status';
        $messageType = 'error';
    }
    $updateStmt->close();
}

// Fetch filter parameters
$statusFilter = $_GET['status'] ?? '';
$pageNum = (int)($_GET['page'] ?? 1);
$pageNum = max(1, $pageNum);
$itemsPerPage = 15;
$offset = ($pageNum - 1) * $itemsPerPage;

// Build query with optional filter
$whereClause = '';
if (!empty($statusFilter) && in_array($statusFilter, ['pending', 'confirmed', 'completed', 'cancelled'])) {
    $whereClause = " WHERE b.status = '" . $conn->real_escape_string($statusFilter) . "'";
}

// Count total bookings
$countSql = "SELECT COUNT(*) as count FROM bookings b" . $whereClause;
$countStmt = $conn->prepare("SELECT COUNT(*) as count FROM bookings b" . str_replace("'", "?", $whereClause === '' ? '' : ' WHERE b.status = ?'));

if (!empty($statusFilter)) {
    $countStmt = $conn->prepare("SELECT COUNT(*) as count FROM bookings b WHERE b.status = ?");
    $countStmt->bind_param("s", $statusFilter);
} else {
    $countStmt = $conn->prepare("SELECT COUNT(*) as count FROM bookings b");
}

$countStmt->execute();
$countResult = $countStmt->get_result();
$totalCount = $countResult->fetch_assoc()['count'];
$totalPages = ceil($totalCount / $itemsPerPage);
$countStmt->close();

// Fetch bookings
$bookingsSql = "SELECT b.booking_id, b.booking_date, b.booking_time, b.service_price, b.gst_amount, b.total_amount, b.status,
                       s.name AS service_name, u.user_name, u.user_email_id, p.provider_name, b.created_at
                FROM bookings b
                INNER JOIN services s ON s.id = b.service_id
                INNER JOIN users u ON u.user_id = b.user_id
                INNER JOIN provider p ON p.provider_id = b.provider_id";

if (!empty($statusFilter)) {
    $bookingsSql .= " WHERE b.status = ?";
}

$bookingsSql .= " ORDER BY b.created_at DESC LIMIT ? OFFSET ?";

$bookingsStmt = $conn->prepare($bookingsSql);

if (!empty($statusFilter)) {
    $bookingsStmt->bind_param("sii", $statusFilter, $itemsPerPage, $offset);
} else {
    $bookingsStmt->bind_param("ii", $itemsPerPage, $offset);
}

$bookingsStmt->execute();
$bookingsResult = $bookingsStmt->get_result();
$bookings = $bookingsResult->fetch_all(MYSQLI_ASSOC);
$bookingsStmt->close();

// Get status breakdown
$statusSql = "SELECT status, COUNT(*) as count FROM bookings GROUP BY status";
$statusStmt = $conn->prepare($statusSql);
$statusStmt->execute();
$statusResult = $statusStmt->get_result();
$statusBreakdown = [];
while ($row = $statusResult->fetch_assoc()) {
    $statusBreakdown[$row['status']] = $row['count'];
}
$statusStmt->close();
?>

<div class="admin-container">
    <!-- Page Header -->
    <div class="admin-page-header">
        <div class="header-content">
            <h1>Manage Bookings</h1>
            <p>Total Bookings: <strong><?php echo $totalCount; ?></strong></p>
        </div>
    </div>

    <!-- Messages -->
    <?php if ($message): ?>
        <div class="alert alert-<?php echo htmlspecialchars($messageType); ?>">
            <i class="fa-solid fa-<?php echo $messageType === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Status Filter -->
    <div class="filter-bar">
        <a href="manage_bookings.php" class="filter-btn <?php echo empty($statusFilter) ? 'active' : ''; ?>">
            All (<?php echo $totalCount; ?>)
        </a>
        <?php foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $status): ?>
            <a href="manage_bookings.php?status=<?php echo htmlspecialchars($status); ?>" 
               class="filter-btn <?php echo $statusFilter === $status ? 'active' : ''; ?>">
                <?php echo ucfirst($status); ?> (<?php echo $statusBreakdown[$status] ?? 0; ?>)
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Bookings Table -->
    <div class="dashboard-card">
        <div class="card-header">
            <h2><?php echo $statusFilter ? ucfirst($statusFilter) . ' Bookings' : 'All Bookings'; ?></h2>
        </div>
        <div class="card-body">
            <?php if (!empty($bookings)): ?>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Service</th>
                                <th>Customer</th>
                                <th>Provider</th>
                                <th>Date & Time</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td>
                                        <span class="booking-id">#<?php echo str_pad($booking['booking_id'], 6, '0', STR_PAD_LEFT); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($booking['service_name']); ?></td>
                                    <td>
                                        <div class="customer-info">
                                            <span class="customer-name"><?php echo htmlspecialchars($booking['user_name']); ?></span>
                                            <small><?php echo htmlspecialchars($booking['user_email_id']); ?></small>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($booking['provider_name']); ?></td>
                                    <td>
                                        <small>
                                            <?php echo date('d M Y', strtotime($booking['booking_date'])); ?><br>
                                            <?php echo htmlspecialchars($booking['booking_time']); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="amount-info">
                                            <strong>₹<?php echo number_format((float)$booking['total_amount'], 0); ?></strong>
                                            <small>(incl. ₹<?php echo number_format((float)$booking['gst_amount'], 0); ?> GST)</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo htmlspecialchars($booking['status']); ?>">
                                            <?php echo ucfirst($booking['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn-icon btn-edit" title="Update Status" onclick="toggleStatusForm(<?php echo $booking['booking_id']; ?>)">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>

                                        <!-- Status Update Form -->
                                        <div class="status-form" id="status-form-<?php echo $booking['booking_id']; ?>" style="display:none; margin-top:10px;">
                                            <form method="POST" style="display:flex; gap:5px; flex-wrap:wrap;">
                                                <input type="hidden" name="action" value="update_status">
                                                <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                                                <select name="status" class="form-control" style="flex:1; min-width:100px;">
                                                    <option value="pending" <?php echo $booking['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                    <option value="confirmed" <?php echo $booking['status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                                    <option value="completed" <?php echo $booking['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                    <option value="cancelled" <?php echo $booking['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                </select>
                                                <button type="submit" class="btn-small btn-primary">Update</button>
                                                <button type="button" class="btn-small btn-secondary" onclick="toggleStatusForm(<?php echo $booking['booking_id']; ?>)">Cancel</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="pagination">
                        <?php if ($pageNum > 1): ?>
                            <a href="manage_bookings.php?page=1<?php echo !empty($statusFilter) ? '&status=' . htmlspecialchars($statusFilter) : ''; ?>" class="page-link">First</a>
                            <a href="manage_bookings.php?page=<?php echo $pageNum - 1; ?><?php echo !empty($statusFilter) ? '&status=' . htmlspecialchars($statusFilter) : ''; ?>" class="page-link">Previous</a>
                        <?php endif; ?>

                        <span class="page-info">Page <?php echo $pageNum; ?> of <?php echo $totalPages; ?></span>

                        <?php if ($pageNum < $totalPages): ?>
                            <a href="manage_bookings.php?page=<?php echo $pageNum + 1; ?><?php echo !empty($statusFilter) ? '&status=' . htmlspecialchars($statusFilter) : ''; ?>" class="page-link">Next</a>
                            <a href="manage_bookings.php?page=<?php echo $totalPages; ?><?php echo !empty($statusFilter) ? '&status=' . htmlspecialchars($statusFilter) : ''; ?>" class="page-link">Last</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <p class="text-center text-muted">No bookings found</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleStatusForm(bookingId) {
    const form = document.getElementById('status-form-' + bookingId);
    if (form) {
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
}
</script>

<?php include 'footer.php'; ?>
