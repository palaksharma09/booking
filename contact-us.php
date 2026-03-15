<?php include 'header.php'; ?>

<!-- Hero Section -->
<section class="contact-hero">
    <div class="contact-hero-container">
        <h1>Contact <span class="hero-highlight">Us</span></h1>
        <p class="contact-hero-description">Have questions or need help booking a service? Our team is here to assist you.</p>
    </div>
</section>

<!-- Contact Information & Form Section -->
<section class="contact-section">
    <div class="contact-container">
        
        <!-- Left Column - Contact Information Cards -->
        <div class="contact-info-column">
            <h2 class="contact-info-title">Get in Touch</h2>
            <p class="contact-info-subtitle">We'd love to hear from you. Here's how you can reach us.</p>
            
            <div class="contact-cards-grid">
                <!-- Address Card -->
                <div class="contact-card">
                    <div class="contact-card-icon">📍</div>
                    <div class="contact-card-content">
                        <h3>Address</h3>
                        <p>ServiceHub Office<br>Ahmedabad, Gujarat, India</p>
                    </div>
                </div>
                
                <!-- Phone Card -->
                <div class="contact-card">
                    <div class="contact-card-icon">📞</div>
                    <div class="contact-card-content">
                        <h3>Phone</h3>
                        <p>+91 98765 43210</p>
                    </div>
                </div>
                
                <!-- Email Card -->
                <div class="contact-card">
                    <div class="contact-card-icon">✉️</div>
                    <div class="contact-card-content">
                        <h3>Email</h3>
                        <p>support@servicehub.com</p>
                    </div>
                </div>
                
                <!-- Working Hours Card -->
                <div class="contact-card">
                    <div class="contact-card-icon">🕒</div>
                    <div class="contact-card-content">
                        <h3>Working Hours</h3>
                        <p>Monday – Saturday<br>9:00 AM – 7:00 PM</p>
                    </div>
                </div>
            </div>
            
            <!-- Map/Additional Info -->
            <div class="contact-info-footer">
                <p>📱 Follow us on social media for updates and offers</p>
                <div class="contact-social-links">
                    <a href="#" class="contact-social-link">f</a>
                    <a href="#" class="contact-social-link">t</a>
                    <a href="#" class="contact-social-link">in</a>
                    <a href="#" class="contact-social-link">ig</a>
                </div>
            </div>
        </div>
        
        <!-- Right Column - Contact Form -->
        <div class="contact-form-column">
            <div class="contact-form-card">
                <h2 class="contact-form-title">Send us a Message</h2>
                <p class="contact-form-subtitle">Fill out the form below and we'll get back to you within 24 hours.</p>
                
                <form class="contact-form">
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="fullname">Full Name</label>
                            <input type="text" id="fullname" placeholder="Enter your full name" required>
                        </div>
                        
                        <div class="form-group half">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" placeholder="Enter your phone number" required>
                        </div>
                        
                        <div class="form-group half">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" placeholder="What is this about?" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" rows="5" placeholder="Write your message here..." required></textarea>
                    </div>
                    
                    <button type="submit" class="contact-submit-btn">Send Message</button>
                </form>
            </div>
        </div>
        
    </div>
</section>

<!-- FAQ Teaser Section (Optional - adds more content) -->
<section class="contact-faq-teaser">
    <div class="faq-teaser-container">
        <h2>Frequently Asked Questions</h2>
        <p>Visit our <a href="faq.php">FAQ page</a> for quick answers to common questions.</p>
    </div>
</section>

<?php include 'footer.php'; ?>