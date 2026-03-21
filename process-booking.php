<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: services.php');
    exit();
}

require_once 'db_conn.php';

$requiredFields = [
    'service_id',
    'provider_id',
    'service_name',
    'provider_name',
    'price',
    'full_name',
    'phone',
    'email',
    'address',
    'city',
    'pincode',
    'booking_date',
    'booking_time',
    'payment_method'
];

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $conn->close();
        header('Location: booking.php?error=missing_fields');
        exit();
    }
}

$userId = (int) $_SESSION['user_id'];
$serviceId = (int) $_POST['service_id'];
$providerId = (int) $_POST['provider_id'];
$fullName = trim($_POST['full_name']);
$phone = trim($_POST['phone']);
$email = trim($_POST['email']);
$address = trim($_POST['address']);
$city = trim($_POST['city']);
$pincode = trim($_POST['pincode']);
$landmark = trim($_POST['landmark'] ?? '');
$bookingDate = $_POST['booking_date'];
$bookingTime = $_POST['booking_time'];
$paymentMethod = $_POST['payment_method'];
$specialInstructions = trim($_POST['special_instructions'] ?? '');
$servicePrice = (float) $_POST['price'];
$gstAmount = round($servicePrice * 0.18, 2);
$totalAmount = round($servicePrice + $gstAmount, 2);
$status = 'confirmed';

$checkSql = "SELECT p.provider_id
             FROM provider p
             INNER JOIN services s ON s.id = p.service_id
             WHERE p.provider_id = ? AND s.id = ?
             LIMIT 1";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ii", $providerId, $serviceId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();
$isValidProvider = (bool) $checkResult->fetch_assoc();
$checkStmt->close();

if (!$isValidProvider) {
    $conn->close();
    header('Location: services.php');
    exit();
}

$insertSql = "INSERT INTO bookings (
                user_id, service_id, provider_id, full_name, phone, email, address, city, pincode, landmark,
                booking_date, booking_time, payment_method, special_instructions, service_price, gst_amount,
                total_amount, status
             ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$insertStmt = $conn->prepare($insertSql);
$insertStmt->bind_param(
    "iiisssssssssssddds",
    $userId,
    $serviceId,
    $providerId,
    $fullName,
    $phone,
    $email,
    $address,
    $city,
    $pincode,
    $landmark,
    $bookingDate,
    $bookingTime,
    $paymentMethod,
    $specialInstructions,
    $servicePrice,
    $gstAmount,
    $totalAmount,
    $status
);

if (!$insertStmt->execute()) {
    $insertStmt->close();
    $conn->close();
    header('Location: booking.php?error=save_failed');
    exit();
}

$bookingId = $insertStmt->insert_id;
$insertStmt->close();
$conn->close();

header('Location: booking-details.php?id=' . urlencode((string) $bookingId) . '&booking=success');
exit();
