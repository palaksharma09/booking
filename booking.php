<?php
// booking.php
// This page will receive service and provider details via GET parameters
// Example URL: booking.php?service=Cleaning&provider=Rahul%20Sharma&category=home

$serviceName = $_GET['service'] ?? 'Service';
$providerName = $_GET['provider'] ?? 'Professional';
$category = $_GET['category'] ?? 'home';
$price = $_GET['price'] ?? '0';

include 'header.php';
?>

<!-- Booking Hero Section -->
<section class="booking-hero">
    <div class="booking-hero-container">
        <div class="booking-hero-content">
            <div class="booking-hero-badge">
                <span class="hero-badge-icon">📝</span>
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

<!-- Booking Main Section -->
<section class="booking-main-section">
    <div class="booking-container">
        <!-- Left Column - Booking Form -->
        <div class="booking-form-column">
            <div class="booking-form-card">
                <h2 class="booking-form-title">Service Details</h2>
                <p class="booking-form-subtitle">Please provide your information to schedule the service</p>

                <form action="process-booking.php" method="POST" class="booking-form">
                    <!-- Hidden Fields -->
                    <input type="hidden" name="service_name" value="<?php echo htmlspecialchars($serviceName); ?>">
                    <input type="hidden" name="provider_name" value="<?php echo htmlspecialchars($providerName); ?>">
                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">

                    <!-- Service Summary Card -->
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
                                <span class="summary-value price">₹<?php echo number_format($price); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="section-icon">👤</span>
                            Personal Information
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="full_name">Full Name *</label>
                                <input type="text" id="full_name" name="full_name" required 
                                       placeholder="Enter your full name" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" required 
                                       placeholder="10-digit mobile number" class="form-input">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required 
                                   placeholder="you@example.com" class="form-input">
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="section-icon">📍</span>
                            Service Address
                        </h3>
                        
                        <div class="form-group">
                            <label for="address">Full Address *</label>
                            <textarea id="address" name="address" rows="3" required 
                                      placeholder="House/Flat No., Building Name, Street, Area" 
                                      class="form-textarea"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City *</label>
                                <input type="text" id="city" name="city" required 
                                       placeholder="Your city" class="form-input">
                            </div>
                            <div class="form-group">
                                <label for="pincode">Pincode *</label>
                                <input type="text" id="pincode" name="pincode" required 
                                       placeholder="6-digit pincode" class="form-input" maxlength="6">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="landmark">Landmark (Optional)</label>
                            <input type="text" id="landmark" name="landmark" 
                                   placeholder="Nearby landmark for easy location" class="form-input">
                        </div>
                    </div>

                    <!-- Scheduling Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="section-icon">📅</span>
                            Schedule Appointment
                        </h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="booking_date">Preferred Date *</label>
                                <input type="date" id="booking_date" name="booking_date" required 
                                       class="form-input" min="<?php echo date('Y-m-d'); ?>">
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
                            <textarea id="special_instructions" name="special_instructions" rows="2" 
                                      placeholder="Any specific requirements or instructions for the service provider"
                                      class="form-textarea"></textarea>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="form-section">
                        <h3 class="form-section-title">
                            <span class="section-icon">💰</span>
                            Payment Method
                        </h3>
                        
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="online" checked>
                                <div class="payment-option-content">
                                    <span class="payment-icon">💳</span>
                                    <div class="payment-info">
                                        <strong>Pay Online</strong>
                                        <small>Credit/Debit Card, UPI, NetBanking</small>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash">
                                <div class="payment-option-content">
                                    <span class="payment-icon">💵</span>
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
                                <span>₹<?php echo number_format($price); ?></span>
                            </div>
                            <div class="price-row">
                                <span>GST (18%)</span>
                                <span>₹<?php echo number_format($price * 0.18); ?></span>
                            </div>
                            <div class="price-row total">
                                <span>Total Amount</span>
                                <span class="total-price">₹<?php echo number_format($price * 1.18); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="terms-group">
                        <label class="checkbox-container">
                            <input type="checkbox" name="terms" required>
                            <span class="checkmark"></span>
                            <span>I agree to the <a href="terms.php" class="terms-link">Terms & Conditions</a> and confirm that the information provided is accurate</span>
                        </label>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="history.back()">Cancel</button>
                        <button type="submit" class="btn-submit">Confirm Booking →</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column - Booking Info & Help -->
        <div class="booking-info-column">
            <div class="booking-info-card">
                <h3>What to Expect</h3>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-icon">✅</span>
                        <div>
                            <strong>Confirmation</strong>
                            <p>You'll receive booking confirmation via SMS/Email</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">👤</span>
                        <div>
                            <strong>Professional Arrival</strong>
                            <p>Professional will arrive at scheduled time</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">🔧</span>
                        <div>
                            <strong>Service Completion</strong>
                            <p>Service will be completed with quality assurance</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">⭐</span>
                        <div>
                            <strong>Review & Rate</strong>
                            <p>Share your experience after service completion</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="booking-info-card">
                <h3>Cancellation Policy</h3>
                <ul class="policy-list">
                    <li>✓ Free cancellation up to 24 hours before appointment</li>
                    <li>✓ 50% charge for cancellation within 12-24 hours</li>
                    <li>✓ No refund for cancellation within 12 hours</li>
                    <li>✓ Rescheduling is free up to 2 hours before appointment</li>
                </ul>
            </div>

            <div class="booking-info-card support-card">
                <h3>Need Help?</h3>
                <p>Our support team is here to assist you</p>
                <div class="support-contact">
                    <div class="support-item">
                        <span>📞</span>
                        <span>+91 1800 123 4567</span>
                    </div>
                    <div class="support-item">
                        <span>✉️</span>
                        <span>support@servicehub.com</span>
                    </div>
                    <div class="support-item">
                        <span>💬</span>
                        <span>Live Chat (9 AM - 8 PM)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Services Section -->
<section class="related-services-section">
    <div class="section-header">
        <h2>You Might Also Like</h2>
        <p>Explore other popular services in this category</p>
    </div>

    <div class="related-services-grid">
        <div class="related-service-card">
            <div class="related-icon">🔧</div>
            <h4>Plumbing Services</h4>
            <p>Expert plumbers for all repairs</p>
            <a href="services.php?category=home" class="related-link">View →</a>
        </div>
        <div class="related-service-card">
            <div class="related-icon">⚡</div>
            <h4>Electrical Services</h4>
            <p>Certified electricians available</p>
            <a href="services.php?category=home" class="related-link">View →</a>
        </div>
        <div class="related-service-card">
            <div class="related-icon">🧹</div>
            <h4>Deep Cleaning</h4>
            <p>Complete home sanitization</p>
            <a href="services.php?category=home" class="related-link">View →</a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>