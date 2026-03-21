<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once 'db_conn.php';

$providerId = isset($_GET['provider_id']) ? (int) $_GET['provider_id'] : 0;
$serviceName = 'Service';
$providerName = 'Professional';
$category = 'home';
$price = 0;
$serviceId = 0;
$categoryId = 0;
$userData = [
    'user_name' => $_SESSION['username'] ?? '',
    'user_email_id' => $_SESSION['user_email'] ?? '',
    'phone' => '',
    'address' => ''
];

$providerSql = "SELECT p.provider_id, p.provider_name, p.price, s.id AS service_id, s.name AS service_name,
                       c.id AS category_id, c.slug AS category_slug
                FROM provider p
                INNER JOIN services s ON s.id = p.service_id
                INNER JOIN categories c ON c.id = s.category_id
                WHERE p.provider_id = ?
                LIMIT 1";
$providerStmt = $conn->prepare($providerSql);
$providerStmt->bind_param("i", $providerId);
$providerStmt->execute();
$providerResult = $providerStmt->get_result();
$providerData = $providerResult->fetch_assoc();
$providerStmt->close();

if (!$providerData) {
    $conn->close();
    include 'header.php';
    echo '<section class="booking-main-section"><div class="booking-form-card"><h2>Provider not found</h2><p>The selected provider could not be loaded.</p><a href="services.php" class="service-modern-btn">Back to Services</a></div></section>';
    include 'footer.php';
    exit();
}

$serviceId = (int) $providerData['service_id'];
$categoryId = (int) $providerData['category_id'];
$serviceName = $providerData['service_name'];
$providerName = $providerData['provider_name'];
$category = $providerData['category_slug'];
$price = (float) $providerData['price'];

$userSql = "SELECT user_name, user_email_id, phone, address FROM users WHERE user_id = ? LIMIT 1";
$userStmt = $conn->prepare($userSql);
$userStmt->bind_param("i", $_SESSION['user_id']);
$userStmt->execute();
$userResult = $userStmt->get_result();
$dbUser = $userResult->fetch_assoc();
$userStmt->close();

if ($dbUser) {
    $userData = $dbUser;
}

$conn->close();
include 'header.php';
?>

<section class="booking-hero">
    <div class="booking-hero-container">
        <div class="booking-hero-content">
            <div class="booking-hero-badge">
                <span class="hero-badge-icon"><i class="fa-solid fa-clipboard-check"></i></span>
                <span>Complete Your Booking</span>
            </div>
            <h1>Book Your <span class="hero-highlight">Service</span></h1>
            <p class="booking-hero-description">Fill in the details below to confirm your service appointment</p>
        </div>
        <div class="booking-hero-image">
            <img src="https://images.unsplash.com/photo-1556740714-a8395b3bf30f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                 alt="Booking Confirmation"
                 onerror="this.src='https://via.placeholder.com/400x300?text=Complete+Booking'">
        </div>
    </div>
    <div class="booking-decoration-1"></div>
    <div class="booking-decoration-2"></div>
</section>

<section class="booking-main-section">
    <div class="booking-container">
        <div class="booking-form-column">
            <div class="booking-form-card">
                <h2 class="booking-form-title">Service Details</h2>
                <p class="booking-form-subtitle">Please provide your information to schedule the service</p>

                <form action="process-booking.php" method="POST" class="booking-form">
                    <input type="hidden" name="service_id" value="<?php echo $serviceId; ?>">
                    <input type="hidden" name="provider_id" value="<?php echo $providerId; ?>">
                    <input type="hidden" name="service_name" value="<?php echo htmlspecialchars($serviceName); ?>">
                    <input type="hidden" name="provider_name" value="<?php echo htmlspecialchars($providerName); ?>">
                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars((string) $price); ?>">

                    <div class="service-summary-card">
                        <div class="summary-header">
                            <div class="summary-icon">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </div>
                            <h3>Service Summary</h3>
                        </div>
                        <div class="summary-details">
                            <div class="summary-row">
                                <span class="summary-label">Service:</span>
                                <span class="summary-value"><?php echo htmlspecialchars($serviceName); ?></span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Professional:</span>
                                <span class="summary-value"><?php echo htmlspecialchars($providerName); ?></span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Estimated Price:</span>
                                <span class="summary-value price">&#8377;<?php echo number_format($price, 0); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="section-icon"><i class="fa-regular fa-user"></i></span>
                            Personal Information
                        </h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="full_name">Full Name *</label>
                                <input type="text" id="full_name" name="full_name" required placeholder="Enter your full name" class="form-input" value="<?php echo htmlspecialchars($userData['user_name'] ?? ''); ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" required placeholder="10-digit mobile number" class="form-input" pattern="[0-9]{10}" value="<?php echo htmlspecialchars($userData['phone'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required placeholder="you@example.com" class="form-input" value="<?php echo htmlspecialchars($userData['user_email_id'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="section-icon"><i class="fa-solid fa-location-dot"></i></span>
                            Service Address
                        </h3>

                        <div class="form-group">
                            <label for="address">Full Address *</label>
                            <textarea id="address" name="address" rows="3" required placeholder="House/Flat No., Building Name, Street, Area" class="form-textarea"><?php echo htmlspecialchars($userData['address'] ?? ''); ?></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City *</label>
                                <input type="text" id="city" name="city" required placeholder="Your city" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="pincode">Pincode *</label>
                                <input type="text" id="pincode" name="pincode" required placeholder="6-digit pincode" class="form-input" maxlength="6" pattern="[0-9]{6}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="landmark">Landmark (Optional)</label>
                            <input type="text" id="landmark" name="landmark" placeholder="Nearby landmark for easy location" class="form-input">
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="section-icon"><i class="fa-regular fa-calendar"></i></span>
                            Schedule Appointment
                        </h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="booking_date">Preferred Date *</label>
                                <input type="date" id="booking_date" name="booking_date" required class="form-input" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="booking_time">Preferred Time *</label>
                                <select id="booking_time" name="booking_time" required class="form-select">
                                    <option value="">Select time slot</option>
                                    <option value="09:00">09:00 AM - 10:00 AM</option>
                                    <option value="10:00">10:00 AM - 11:00 AM</option>
                                    <option value="11:00">11:00 AM - 12:00 PM</option>
                                    <option value="12:00">12:00 PM - 01:00 PM</option>
                                    <option value="14:00">02:00 PM - 03:00 PM</option>
                                    <option value="15:00">03:00 PM - 04:00 PM</option>
                                    <option value="16:00">04:00 PM - 05:00 PM</option>
                                    <option value="17:00">05:00 PM - 06:00 PM</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="special_instructions">Special Instructions (Optional)</label>
                            <textarea id="special_instructions" name="special_instructions" rows="2" placeholder="Any specific requirements or instructions for the service provider" class="form-textarea"></textarea>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="section-icon"><i class="fa-solid fa-wallet"></i></span>
                            Payment Method
                        </h3>

                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="online" checked>
                                <div class="payment-option-content">
                                    <span class="payment-icon"><i class="fa-solid fa-credit-card"></i></span>
                                    <div class="payment-info">
                                        <strong>Pay Online</strong>
                                        <small>Credit/Debit Card, UPI, NetBanking</small>
                                    </div>
                                </div>
                            </label>

                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash">
                                <div class="payment-option-content">
                                    <span class="payment-icon"><i class="fa-solid fa-money-bill-wave"></i></span>
                                    <div class="payment-info">
                                        <strong>Pay at Service</strong>
                                        <small>Cash on completion of service</small>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="price-breakdown">
                            <div class="price-row">
                                <span>Service Charge</span>
                                <span>&#8377;<?php echo number_format($price, 0); ?></span>
                            </div>
                            <div class="price-row">
                                <span>GST (18%)</span>
                                <span>&#8377;<?php echo number_format($price * 0.18, 0); ?></span>
                            </div>
                            <div class="price-row total">
                                <span>Total Amount</span>
                                <span class="total-price">&#8377;<?php echo number_format($price * 1.18, 0); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="terms-group">
                        <label class="checkbox-container">
                            <input type="checkbox" name="terms" required>
                            <span class="checkmark"></span>
                            <span>I agree to the <a href="terms.php" class="terms-link">Terms &amp; Conditions</a> and confirm that the information provided is accurate</span>
                        </label>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="history.back()">Cancel</button>
                        <button type="submit" class="btn-submit">Confirm Booking &rarr;</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="booking-info-column">
            <div class="booking-info-card">
                <h3>What to Expect</h3>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-icon"><i class="fa-solid fa-circle-check"></i></span>
                        <div>
                            <strong>Confirmation</strong>
                            <p>You'll receive booking confirmation via SMS or email.</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <span class="info-icon"><i class="fa-regular fa-user"></i></span>
                        <div>
                            <strong>Professional Arrival</strong>
                            <p>Your selected professional will arrive at the scheduled time.</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <span class="info-icon"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                        <div>
                            <strong>Service Completion</strong>
                            <p>The service will be completed with quality assurance.</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <span class="info-icon"><i class="fa-solid fa-star"></i></span>
                        <div>
                            <strong>Review &amp; Rate</strong>
                            <p>Share your experience after service completion.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
