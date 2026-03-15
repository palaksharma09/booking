<?php
$category = $_GET['category'] ?? 'home';
include 'header.php';

// Define service details based on category
$serviceDetails = [
    'home' => [
        'title' => 'Home Services',
        'subtitle' => 'Professional home maintenance and cleaning services',
        'description' => 'From deep cleaning to electrical repairs, our home service professionals are here to make your life easier. Book trusted experts for all your home needs.',
        'image' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        'services' => [
            ['icon' => '🧹', 'name' => 'Cleaning', 'desc' => 'Deep cleaning, regular maintenance', 'count' => '24 professionals', 'popular' => true],
            ['icon' => '💡', 'name' => 'Electrician', 'desc' => 'Repairs, installation, wiring', 'count' => '18 professionals', 'popular' => true],
            ['icon' => '👨‍🍳', 'name' => 'Cooking', 'desc' => 'Home chefs, meal preparation', 'count' => '15 professionals', 'popular' => false],
            ['icon' => '🔧', 'name' => 'Plumbing', 'desc' => 'Pipe repair, fixture installation', 'count' => '20 professionals', 'popular' => true],
            ['icon' => '🎨', 'name' => 'Painting', 'desc' => 'Interior & exterior painting', 'count' => '12 professionals', 'popular' => false],
            ['icon' => '🛋️', 'name' => 'Furniture Assembly', 'desc' => 'Assembly & repair', 'count' => '10 professionals', 'popular' => false],
            ['icon' => '❄️', 'name' => 'AC Service', 'desc' => 'Repair & maintenance', 'count' => '14 professionals', 'popular' => true],
            ['icon' => '🔒', 'name' => 'Locksmith', 'desc' => 'Lock repair, installation', 'count' => '8 professionals', 'popular' => false],
            ['icon' => '📦', 'name' => 'Packing & Moving', 'desc' => 'Home shifting services', 'count' => '12 professionals', 'popular' => false]
        ]
    ],
    'salon' => [
        'title' => 'Salon Services',
        'subtitle' => 'Beauty and wellness services at your doorstep',
        'description' => 'Pamper yourself with premium beauty services delivered to your home. Our expert stylists and beauticians use top-quality products.',
        'image' => 'https://images.pexels.com/photos/3993449/pexels-photo-3993449.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2',
        'services' => [
            ['icon' => '✂️', 'name' => 'Haircut', 'desc' => 'Men & women haircut, styling', 'count' => '32 professionals', 'popular' => true],
            ['icon' => '🧴', 'name' => 'Facial', 'desc' => 'Premium skincare treatments', 'count' => '28 professionals', 'popular' => true],
            ['icon' => '💄', 'name' => 'Make-up', 'desc' => 'Party, bridal makeup', 'count' => '25 professionals', 'popular' => true],
            ['icon' => '💅', 'name' => 'Manicure/Pedicure', 'desc' => 'Nail care services', 'count' => '22 professionals', 'popular' => true],
            ['icon' => '🌸', 'name' => 'Spa', 'desc' => 'Massage, relaxation therapy', 'count' => '16 professionals', 'popular' => false],
            ['icon' => '👰', 'name' => 'Bridal Package', 'desc' => 'Complete bridal makeover', 'count' => '12 professionals', 'popular' => false],
            ['icon' => '💇', 'name' => ' Hair Color', 'desc' => 'Professional coloring', 'count' => '18 professionals', 'popular' => true],
            ['icon' => '🧖', 'name' => 'Steam & Sauna', 'desc' => 'Relaxation therapies', 'count' => '10 professionals', 'popular' => false]
        ]
    ],
    'garage' => [
        'title' => 'Garage Services',
        'subtitle' => 'Expert car care and maintenance',
        'description' => 'Keep your vehicle in top condition with our professional garage services. From regular maintenance to emergency repairs, we\'ve got you covered.',
        'image' => 'https://images.unsplash.com/photo-1530046339160-ce3e530c7d2f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        'services' => [
            ['icon' => '🚿', 'name' => 'Car Wash', 'desc' => 'Professional cleaning, waxing', 'count' => '30 professionals', 'popular' => true],
            ['icon' => '🔧', 'name' => 'Repair', 'desc' => 'Engine, transmission repair', 'count' => '25 professionals', 'popular' => true],
            ['icon' => '🛢️', 'name' => 'Oil Change', 'desc' => 'Engine oil, filter change', 'count' => '28 professionals', 'popular' => true],
            ['icon' => '⚡', 'name' => 'Battery Service', 'desc' => 'Battery check, replacement', 'count' => '20 professionals', 'popular' => false],
            ['icon' => '🛞', 'name' => 'Tire Service', 'desc' => 'Tire rotation, alignment', 'count' => '22 professionals', 'popular' => true],
            ['icon' => '🔍', 'name' => 'Diagnostics', 'desc' => 'Computer diagnostics', 'count' => '15 professionals', 'popular' => false],
            ['icon' => '❄️', 'name' => 'AC Service', 'desc' => 'Car AC repair', 'count' => '12 professionals', 'popular' => true],
            ['icon' => '🚘', 'name' => 'Detailing', 'desc' => 'Complete car detailing', 'count' => '10 professionals', 'popular' => false]
        ]
    ]
];

$currentCategory = $serviceDetails[$category];

// Split services into popular and regular for better organization
$popularServices = array_filter($currentCategory['services'], function($service) {
    return $service['popular'] === true;
});

$regularServices = array_filter($currentCategory['services'], function($service) {
    return $service['popular'] !== true;
});
?>

<!-- Enhanced Category Banner -->
<section class="category-banner" style="background: linear-gradient(135deg, var(--secondary-color), var(--secondary-dark));">
    <div class="category-banner-container">
        <div class="category-banner-content">
            <div class="category-breadcrumb">
                <a href="Dashboard.php">Home</a> > <span><?php echo $currentCategory['title']; ?></span>
            </div>
            <h1><?php echo $currentCategory['title']; ?></h1>
            <p class="category-description"><?php echo $currentCategory['description']; ?></p>
            <div class="category-banner-stats">
                <div class="banner-stat">
                    <span class="banner-stat-number"><?php echo count($currentCategory['services']); ?>+</span>
                    <span class="banner-stat-label">Services</span>
                </div>
                <div class="banner-stat">
                    <span class="banner-stat-number">150+</span>
                    <span class="banner-stat-label">Professionals</span>
                </div>
                <div class="banner-stat">
                    <span class="banner-stat-number">4.8</span>
                    <span class="banner-stat-label">Rating</span>
                </div>
            </div>
        </div>
        <div class="category-banner-image">
            <img src="<?php echo $currentCategory['image']; ?>" alt="<?php echo $currentCategory['title']; ?>">
        </div>
    </div>
</section>

<!-- Quick Stats (removed - now integrated into banner) -->

<!-- Popular Services Section (if there are popular services) -->
<?php if (!empty($popularServices)): ?>
<section class="popular-services-section">
    <div class="section-header">
        <h2>Popular <?php echo $currentCategory['title']; ?></h2>
        <p>Most booked services by our customers</p>
    </div>

    <div class="popular-services-grid">
        <?php foreach ($popularServices as $service): ?>
            <div class="popular-service-card" 
                 onclick="window.location.href='service_list.php?category=<?php echo $category; ?>&service=<?php echo urlencode($service['name']); ?>'">
                <div class="popular-service-icon"><?php echo $service['icon']; ?></div>
                <div class="popular-service-info">
                    <h3><?php echo $service['name']; ?></h3>
                    <p><?php echo $service['desc']; ?></p>
                    <span class="popular-service-count"><?php echo $service['count']; ?></span>
                </div>
                <div class="popular-service-arrow">→</div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- All Services Section - Enhanced Grid -->
<section class="all-services-section">
    <div class="section-header">
        <h2>All <?php echo $currentCategory['title']; ?></h2>
        <p>Browse our complete range of services</p>
    </div>

    <div class="enhanced-services-grid">
        <?php foreach ($currentCategory['services'] as $service): ?>
            <div class="enhanced-service-card" 
                 onclick="window.location.href='service_list.php?category=<?php echo $category; ?>&service=<?php echo urlencode($service['name']); ?>'">
                <div class="enhanced-service-icon-wrapper">
                    <div class="enhanced-service-icon"><?php echo $service['icon']; ?></div>
                    <?php if ($service['popular']): ?>
                        <span class="enhanced-service-badge">Popular</span>
                    <?php endif; ?>
                </div>
                <div class="enhanced-service-content">
                    <h3><?php echo $service['name']; ?></h3>
                    <p class="enhanced-service-desc"><?php echo $service['desc']; ?></p>
                    <div class="enhanced-service-footer">
                        <span class="enhanced-service-count">👥 <?php echo $service['count']; ?></span>
                        <span class="enhanced-service-link">View Professionals →</span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- New: How It Works - Service Page Version (different from dashboard) -->
<section class="service-process-section">
    <div class="section-header">
        <h2>How It Works</h2>
        <p>Book your service in four simple steps</p>
    </div>

    <div class="service-process-steps">
        <div class="service-process-step">
            <div class="service-process-number">1</div>
            <div class="service-process-icon">🔍</div>
            <h3>Browse Services</h3>
            <p>Choose from our wide range of professional services</p>
        </div>
        <div class="service-process-step">
            <div class="service-process-number">2</div>
            <div class="service-process-icon">👥</div>
            <h3>Select Professional</h3>
            <p>Compare profiles, ratings, and prices</p>
        </div>
        <div class="service-process-step">
            <div class="service-process-number">3</div>
            <div class="service-process-icon">📅</div>
            <h3>Schedule</h3>
            <p>Pick a date and time that works for you</p>
        </div>
        <div class="service-process-step">
            <div class="service-process-number">4</div>
            <div class="service-process-icon">✨</div>
            <h3>Get Service</h3>
            <p>Professional arrives and completes the job</p>
        </div>
    </div>
</section>

<!-- New: Customer Reviews Section -->
<section class="service-reviews-section">
    <div class="section-header">
        <h2>What Customers Say</h2>
        <p>Real reviews from people who booked <?php echo strtolower($currentCategory['title']); ?></p>
    </div>

    <div class="service-reviews-grid">
        <div class="service-review-card">
            <div class="reviewer-info">
                <div class="reviewer-avatar">👤</div>
                <div class="reviewer-details">
                    <h4>Priya Sharma</h4>
                    <div class="review-rating">⭐⭐⭐⭐⭐</div>
                </div>
            </div>
            <p class="review-text">"Excellent service! The plumber was professional and fixed the issue quickly. Very reasonable prices."</p>
            <span class="review-service">Plumbing Service</span>
        </div>
        <div class="service-review-card">
            <div class="reviewer-info">
                <div class="reviewer-avatar">👤</div>
                <div class="reviewer-details">
                    <h4>Rajesh Kumar</h4>
                    <div class="review-rating">⭐⭐⭐⭐⭐</div>
                </div>
            </div>
            <p class="review-text">"The cleaning team was thorough and punctual. My house has never looked better. Will book again!"</p>
            <span class="review-service">Cleaning Service</span>
        </div>
        <div class="service-review-card">
            <div class="reviewer-info">
                <div class="reviewer-avatar">👤</div>
                <div class="reviewer-details">
                    <h4>Anita Desai</h4>
                    <div class="review-rating">⭐⭐⭐⭐⭐</div>
                </div>
            </div>
            <p class="review-text">"Great experience with the electrician. He was knowledgeable and fixed all the wiring issues."</p>
            <span class="review-service">Electrical Service</span>
        </div>
    </div>
</section>

<!-- New: FAQ Section -->
<section class="service-faq-section">
    <div class="section-header">
        <h2>Frequently Asked Questions</h2>
        <p>Everything you need to know about our <?php echo strtolower($currentCategory['title']); ?></p>
    </div>

    <div class="faq-grid">
        <div class="faq-item">
            <div class="faq-question">
                <span class="faq-icon">?</span>
                <h3>How do I book a service?</h3>
            </div>
            <p class="faq-answer">Simply browse through our services, select the one you need, choose a professional based on ratings and experience, and pick a convenient time slot. It's that easy!</p>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <span class="faq-icon">?</span>
                <h3>Are the professionals verified?</h3>
            </div>
            <p class="faq-answer">Yes, all our professionals undergo thorough background verification, identity checks, and skill assessments before they can offer services on our platform.</p>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <span class="faq-icon">?</span>
                <h3>What if I'm not satisfied?</h3>
            </div>
            <p class="faq-answer">We offer a 100% satisfaction guarantee. If you're not happy with the service, we'll work to resolve the issue or provide a refund.</p>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <span class="faq-icon">?</span>
                <h3>How do I pay?</h3>
            </div>
            <p class="faq-answer">You can pay online through our secure payment gateway or directly to the professional after service completion. Both options are available.</p>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>