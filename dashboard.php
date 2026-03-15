<?php include 'header.php'; ?>

<!-- Hero Section with Image -->
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-content">
            <h1>Professional Services <span class="highlight">At Your Doorstep</span></h1>
            <p class="hero-description">Book trusted, verified professionals for home maintenance, salon services, and car care. Quality service, guaranteed satisfaction.</p>
            <div class="hero-stats">
                <div class="hero-stat-item">
                    <span class="hero-stat-number">5000+</span>
                    <span class="hero-stat-label">Happy Customers</span>
                </div>
                <div class="hero-stat-item">
                    <span class="hero-stat-number">150+</span>
                    <span class="hero-stat-label">Expert Professionals</span>
                </div>
                <div class="hero-stat-item">
                    <span class="hero-stat-number">4.8</span>
                    <span class="hero-stat-label">Average Rating</span>
                </div>
            </div>
            <div class="hero-cta">
                <a href="#our-services" class="btn-primary btn-large">Explore Services</a>
                <a href="#how-it-works" class="btn-secondary btn-large">How It Works</a>
            </div>
        </div>
        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                alt="Professional Service Provider"
                class="hero-img"
                onerror="this.src='https://via.placeholder.com/600x400?text=Professional+Services'">
            <div class="hero-image-badge">
                <span class="badge-icon">✓</span>
                <span>Verified Professionals</span>
            </div>
        </div>
    </div>
</section>

<!-- Our Services Section - Redesigned -->
<section id="our-services" class="our-services-section">
    <div class="section-header">
        <h2>Our Services</h2>
        <p>Choose from a wide range of professional services tailored to your needs</p>
    </div>

    <!-- New Modern Service Grid -->
    <div class="services-modern-grid">
        <!-- Home Service Card -->
        <div class="service-modern-card">
            <div class="service-modern-image">
                <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                    alt="Home Services"
                    onerror="this.src='https://via.placeholder.com/500x400?text=Home+Services'">
                <div class="service-modern-overlay">
                    <span class="service-tag">Popular</span>
                </div>
            </div>
            <div class="service-modern-content">
                <div class="service-modern-icon">🏠</div>
                <h3>Home Services</h3>
                <p class="service-modern-desc">Complete home maintenance solutions from cleaning to repairs</p>
                <div class="service-modern-features">
                    <div class="feature-pill">
                        <span>🧹 Cleaning</span>
                    </div>
                    <div class="feature-pill">
                        <span>💡 Electric</span>
                    </div>
                    <div class="feature-pill">
                        <span>🔧 Plumbing</span>
                    </div>
                    <div class="feature-pill">
                        <span>👨‍🍳 Cooking</span>
                    </div>
                </div>
                <div class="service-modern-footer">
                    <span class="service-price">Starting ₹499</span>
                    <a href="services.php?category=home" class="service-modern-btn">
                        Book Now
                        <span class="btn-arrow">→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Salon Service Card -->
        <div class="service-modern-card">
            <div class="service-modern-image">
                <img src="https://images.pexels.com/photos/3993449/pexels-photo-3993449.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                    alt="Salon Services"
                    onerror="this.src='https://via.placeholder.com/500x400?text=Salon+Services'">
                <div class="service-modern-overlay">
                    <span class="service-tag">Trending</span>
                </div>
            </div>
            <div class="service-modern-content">
                <div class="service-modern-icon">💇</div>
                <h3>Salon Services</h3>
                <p class="service-modern-desc">Premium beauty and wellness at your convenience</p>
                <div class="service-modern-features">
                    <div class="feature-pill">
                        <span>✂️ Haircut</span>
                    </div>
                    <div class="feature-pill">
                        <span>🧴 Facial</span>
                    </div>
                    <div class="feature-pill">
                        <span>💄 Make-up</span>
                    </div>
                    <div class="feature-pill">
                        <span>💅 Manicure</span>
                    </div>
                </div>
                <div class="service-modern-footer">
                    <span class="service-price">Starting ₹399</span>
                    <a href="services.php?category=salon" class="service-modern-btn">
                        Book Now
                        <span class="btn-arrow">→</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Garage Service Card -->
        <div class="service-modern-card">
            <div class="service-modern-image">
                <img src="https://images.unsplash.com/photo-1530046339160-ce3e530c7d2f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                    alt="Garage Services"
                    onerror="this.src='https://via.placeholder.com/500x400?text=Garage+Services'">
                <div class="service-modern-overlay">
                    <span class="service-tag">24/7 Support</span>
                </div>
            </div>
            <div class="service-modern-content">
                <div class="service-modern-icon">🚗</div>
                <h3>Garage Services</h3>
                <p class="service-modern-desc">Expert car care and maintenance at your doorstep</p>
                <div class="service-modern-features">
                    <div class="feature-pill">
                        <span>🚿 Car Wash</span>
                    </div>
                    <div class="feature-pill">
                        <span>🔧 Repair</span>
                    </div>
                    <div class="feature-pill">
                        <span>🛢️ Oil Change</span>
                    </div>
                    <div class="feature-pill">
                        <span>⚡ Battery</span>
                    </div>
                </div>
                <div class="service-modern-footer">
                    <span class="service-price">Starting ₹299</span>
                    <a href="services.php?category=garage" class="service-modern-btn">
                        Book Now
                        <span class="btn-arrow">→</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- View All Services CTA -->
    <div class="services-cta">
        <a href="services.php" class="btn-primary btn-large">View All Services</a>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="features-section">
    <div class="section-header">
        <h2>Why Choose ServiceHub?</h2>
        <p>We connect you with the best professionals in your area</p>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">✅</div>
            <h3>Verified Professionals</h3>
            <p>All service providers are background checked and verified</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">💰</div>
            <h3>Best Price Guarantee</h3>
            <p>Transparent pricing with no hidden charges</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">⭐</div>
            <h3>5-Star Service</h3>
            <p>Thousands of happy customers across India</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">🔒</div>
            <h3>Secure Payments</h3>
            <p>Pay only after service completion</p>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="how-it-works">
    <div class="section-header">
        <h2>How It Works</h2>
        <p>Book a professional in three simple steps</p>
    </div>

    <div class="steps-container">
        <div class="step-card">
            <div class="step-number">1</div>
            <h3>Choose a Service</h3>
            <p>Browse through our wide range of professional services</p>
        </div>

        <div class="step-card">
            <div class="step-number">2</div>
            <h3>Select a Professional</h3>
            <p>Compare ratings, experience, and prices</p>
        </div>

        <div class="step-card">
            <div class="step-number">3</div>
            <h3>Book & Relax</h3>
            <p>Schedule the service and we'll handle the rest</p>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials">
    <div class="section-header">
        <h2>What Our Customers Say</h2>
        <p>Real experiences from real people</p>
    </div>

    <div class="testimonials-grid">
        <div class="testimonial-card">
            <div class="stars">⭐⭐⭐⭐⭐</div>
            <p>"Excellent service! The plumber was professional and fixed everything quickly."</p>
            <div class="customer-info">
                <strong>Rajesh Kumar</strong>
                <span>Home Services</span>
            </div>
        </div>

        <div class="testimonial-card">
            <div class="stars">⭐⭐⭐⭐⭐</div>
            <p>"Best salon service at home. The makeup artist was amazing for my sister's wedding."</p>
            <div class="customer-info">
                <strong>Priya Sharma</strong>
                <span>Salon Services</span>
            </div>
        </div>

        <div class="testimonial-card">
            <div class="stars">⭐⭐⭐⭐⭐</div>
            <p>"Quick car repair service. Reasonable prices and quality work. Highly recommended!"</p>
            <div class="customer-info">
                <strong>Amit Patel</strong>
                <span>Garage Services</span>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>