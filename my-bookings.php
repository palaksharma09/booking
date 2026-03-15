<?php include 'header.php'; ?>

<!-- Improved Page Header Section -->
<section class="bookings-header">
    <div class="bookings-header-container">
        <div class="bookings-header-content">
            <div class="bookings-header-badge">
                <span class="header-badge-icon">📋</span>
                <span>Your Bookings</span>
            </div>
            <h1>My <span class="header-highlight">Bookings</span></h1>
            <p class="bookings-header-description">Track, manage, and review all your service appointments in one place</p>
            
            <div class="bookings-header-stats">
                <div class="header-stat-item">
                    <span class="header-stat-number">6</span>
                    <span class="header-stat-label">Total Bookings</span>
                </div>
                <div class="header-stat-divider"></div>
                <div class="header-stat-item">
                    <span class="header-stat-number">2</span>
                    <span class="header-stat-label">Active</span>
                </div>
                <div class="header-stat-divider"></div>
                <div class="header-stat-item">
                    <span class="header-stat-number">3</span>
                    <span class="header-stat-label">Completed</span>
                </div>
                <div class="header-stat-divider"></div>
                <div class="header-stat-item">
                    <span class="header-stat-number">1</span>
                    <span class="header-stat-label">Cancelled</span>
                </div>
            </div>
        </div>
        <div class="bookings-header-image">
            <img src="https://images.unsplash.com/photo-1556740714-a8395b3bf30f?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                 alt="Happy Customer"
                 onerror="this.src='https://via.placeholder.com/400x300?text=My+Bookings'">
        </div>
    </div>
    
    <!-- Decorative Elements -->
    <div class="header-decoration-1"></div>
    <div class="header-decoration-2"></div>
</section>

<!-- Filter Tabs Section (New) -->
<section class="bookings-filter-section">
    <div class="bookings-filter-container">
        <div class="filter-tabs">
            <button class="filter-tab active">All Bookings</button>
            <button class="filter-tab">Confirmed</button>
            <button class="filter-tab">Pending</button>
            <button class="filter-tab">Completed</button>
            <button class="filter-tab">Cancelled</button>
        </div>
        
        <div class="filter-search">
            <input type="text" placeholder="Search bookings..." class="filter-search-input">
            <button class="filter-search-btn">🔍</button>
        </div>
    </div>
</section>

<!-- Bookings Grid Section -->
<section class="bookings-section">
    <div class="bookings-container">
        
        <!-- Sample Booking Card 1 - Confirmed -->
        <div class="booking-card">
            <div class="booking-card-header">
                <div class="booking-icon">🧹</div>
                <div class="booking-title">
                    <h3>Cleaning Service</h3>
                    <span class="booking-status status-confirmed">Confirmed</span>
                </div>
            </div>
            
            <div class="booking-details">
                <div class="booking-detail-item">
                    <span class="detail-label">Provider:</span>
                    <span class="detail-value">Rahul Sharma</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">20 March 2026</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">10:00 AM</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Price:</span>
                    <span class="detail-value price">₹500</span>
                </div>
            </div>
            
            <div class="booking-card-footer">
                <a href="booking-details.php?id=1" class="booking-btn view-btn">View Details</a>
                <a href="#" class="booking-btn cancel-btn" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
            </div>
        </div>
        
        <!-- Sample Booking Card 2 - Pending -->
        <div class="booking-card">
            <div class="booking-card-header">
                <div class="booking-icon">✂️</div>
                <div class="booking-title">
                    <h3>Haircut Service</h3>
                    <span class="booking-status status-pending">Pending</span>
                </div>
            </div>
            
            <div class="booking-details">
                <div class="booking-detail-item">
                    <span class="detail-label">Provider:</span>
                    <span class="detail-value">Rohit Singh</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">22 March 2026</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">3:30 PM</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Price:</span>
                    <span class="detail-value price">₹300</span>
                </div>
            </div>
            
            <div class="booking-card-footer">
                <a href="booking-details.php?id=2" class="booking-btn view-btn">View Details</a>
                <a href="#" class="booking-btn cancel-btn" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
            </div>
        </div>
        
        <!-- Sample Booking Card 3 - Completed -->
        <div class="booking-card">
            <div class="booking-card-header">
                <div class="booking-icon">🚿</div>
                <div class="booking-title">
                    <h3>Car Wash</h3>
                    <span class="booking-status status-completed">Completed</span>
                </div>
            </div>
            
            <div class="booking-details">
                <div class="booking-detail-item">
                    <span class="detail-label">Provider:</span>
                    <span class="detail-value">Karan Mehta</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">25 March 2026</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">11:00 AM</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Price:</span>
                    <span class="detail-value price">₹400</span>
                </div>
            </div>
            
            <div class="booking-card-footer">
                <a href="booking-details.php?id=3" class="booking-btn view-btn">View Details</a>
                <a href="#" class="booking-btn cancel-btn disabled" onclick="return false;">Cancel</a>
            </div>
        </div>
        
        <!-- Sample Booking Card 4 - Cancelled -->
        <div class="booking-card">
            <div class="booking-card-header">
                <div class="booking-icon">🔧</div>
                <div class="booking-title">
                    <h3>Plumbing Service</h3>
                    <span class="booking-status status-cancelled">Cancelled</span>
                </div>
            </div>
            
            <div class="booking-details">
                <div class="booking-detail-item">
                    <span class="detail-label">Provider:</span>
                    <span class="detail-value">Suresh Kumar</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">15 March 2026</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">2:00 PM</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Price:</span>
                    <span class="detail-value price">₹600</span>
                </div>
            </div>
            
            <div class="booking-card-footer">
                <a href="booking-details.php?id=4" class="booking-btn view-btn">View Details</a>
                <a href="#" class="booking-btn cancel-btn disabled" onclick="return false;">Cancelled</a>
            </div>
        </div>
        
        <!-- Sample Booking Card 5 - Another Pending -->
        <div class="booking-card">
            <div class="booking-card-header">
                <div class="booking-icon">💡</div>
                <div class="booking-title">
                    <h3>Electrician Service</h3>
                    <span class="booking-status status-pending">Pending</span>
                </div>
            </div>
            
            <div class="booking-details">
                <div class="booking-detail-item">
                    <span class="detail-label">Provider:</span>
                    <span class="detail-value">Rajesh Gupta</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">28 March 2026</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">9:30 AM</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Price:</span>
                    <span class="detail-value price">₹550</span>
                </div>
            </div>
            
            <div class="booking-card-footer">
                <a href="booking-details.php?id=5" class="booking-btn view-btn">View Details</a>
                <a href="#" class="booking-btn cancel-btn" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
            </div>
        </div>
        
        <!-- Sample Booking Card 6 - Confirmed -->
        <div class="booking-card">
            <div class="booking-card-header">
                <div class="booking-icon">💇</div>
                <div class="booking-title">
                    <h3>Facial Service</h3>
                    <span class="booking-status status-confirmed">Confirmed</span>
                </div>
            </div>
            
            <div class="booking-details">
                <div class="booking-detail-item">
                    <span class="detail-label">Provider:</span>
                    <span class="detail-value">Pooja Malhotra</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">30 March 2026</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Time:</span>
                    <span class="detail-value">4:00 PM</span>
                </div>
                <div class="booking-detail-item">
                    <span class="detail-label">Price:</span>
                    <span class="detail-value price">₹800</span>
                </div>
            </div>
            
            <div class="booking-card-footer">
                <a href="booking-details.php?id=6" class="booking-btn view-btn">View Details</a>
                <a href="#" class="booking-btn cancel-btn" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</a>
            </div>
        </div>
        
    </div>
</section>

<!-- Optional: Empty State (if no bookings) -->
<!-- 
<section class="bookings-section">
    <div class="empty-state">
        <div class="empty-icon">📅</div>
        <h3>No Bookings Yet</h3>
        <p>You haven't booked any services yet. Browse our services and book your first service today!</p>
        <a href="services.php" class="btn-primary">Explore Services</a>
    </div>
</section> 
-->

<?php include 'footer.php'; ?>