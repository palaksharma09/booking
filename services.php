<?php
// services.php
$category = $_GET['category'] ?? 'home';
include 'header.php';
require_once 'db_conn.php'; // Using your existing database connection

// Fetch category and services from database
$currentCategory = null;
$services = [];

// Check if database connection exists
if (isset($conn) && $conn->connect_error === null) {
    try {
        // Fetch category details using MySQLi prepared statement
        $stmt = $conn->prepare("SELECT * FROM categories WHERE slug = ?");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
        $currentCategory = $result->fetch_assoc();
        
        // If category not found, fallback to default (home)
        if (!$currentCategory) {
            $stmt = $conn->prepare("SELECT * FROM categories WHERE slug = 'home'");
            $stmt->execute();
            $result = $stmt->get_result();
            $currentCategory = $result->fetch_assoc();
            $category = 'home'; // Update category for URL consistency
        }
        
        // Fetch services for this category
        if ($currentCategory) {
            $stmt = $conn->prepare("SELECT * FROM services WHERE category_id = ? ORDER BY is_popular DESC, name ASC");
            $stmt->bind_param("i", $currentCategory['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $services = $result->fetch_all(MYSQLI_ASSOC);
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage());
        // Fallback to hardcoded data if database query fails
        $currentCategory = getFallbackCategory($category);
        $services = getFallbackServices($category);
    }
} else {
    // Fallback to hardcoded data if database connection fails
    $currentCategory = getFallbackCategory($category);
    $services = getFallbackServices($category);
}

// Helper function to get fallback category data
function getFallbackCategory($category) {
    $fallbackCategories = [
        'home' => [
            'title' => 'Home Services',
            'subtitle' => 'Professional home maintenance and cleaning services',
            'description' => 'From deep cleaning to electrical repairs, our home service professionals are here to make your life easier. Book trusted experts for all your home needs.',
            'image' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
        ],
        'salon' => [
            'title' => 'Salon Services',
            'subtitle' => 'Beauty and wellness services at your doorstep',
            'description' => 'Pamper yourself with premium beauty services delivered to your home. Our expert stylists and beauticians use top-quality products.',
            'image' => 'https://images.pexels.com/photos/3993449/pexels-photo-3993449.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2'
        ],
        'garage' => [
            'title' => 'Garage Services',
            'subtitle' => 'Expert car care and maintenance',
            'description' => 'Keep your vehicle in top condition with our professional garage services. From regular maintenance to emergency repairs, we\'ve got you covered.',
            'image' => 'https://images.unsplash.com/photo-1530046339160-ce3e530c7d2f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
        ]
    ];
    
    return $fallbackCategories[$category] ?? $fallbackCategories['home'];
}

// Helper function to get fallback services data
function getFallbackServices($category) {
    $fallbackServices = [
        'home' => [
            ['icon' => 'fa-solid fa-broom', 'icon_type' => 'fontawesome', 'name' => 'Cleaning', 'description' => 'Deep cleaning, regular maintenance', 'professional_count' => 24, 'is_popular' => true],
            ['icon' => 'fa-solid fa-bolt', 'icon_type' => 'fontawesome', 'name' => 'Electrician', 'description' => 'Repairs, installation, wiring', 'professional_count' => 18, 'is_popular' => true],
            ['icon' => 'fa-solid fa-utensils', 'icon_type' => 'fontawesome', 'name' => 'Cooking', 'description' => 'Home chefs, meal preparation', 'professional_count' => 15, 'is_popular' => false],
            ['icon' => 'fa-solid fa-wrench', 'icon_type' => 'fontawesome', 'name' => 'Plumbing', 'description' => 'Pipe repair, fixture installation', 'professional_count' => 20, 'is_popular' => true],
            ['icon' => 'fa-solid fa-paint-roller', 'icon_type' => 'fontawesome', 'name' => 'Painting', 'description' => 'Interior & exterior painting', 'professional_count' => 12, 'is_popular' => false],
            ['icon' => 'fa-solid fa-couch', 'icon_type' => 'fontawesome', 'name' => 'Furniture Assembly', 'description' => 'Assembly & repair', 'professional_count' => 10, 'is_popular' => false],
            ['icon' => 'fa-solid fa-snowflake', 'icon_type' => 'fontawesome', 'name' => 'AC Service', 'description' => 'Repair & maintenance', 'professional_count' => 14, 'is_popular' => true],
            ['icon' => 'fa-solid fa-key', 'icon_type' => 'fontawesome', 'name' => 'Locksmith', 'description' => 'Lock repair, installation', 'professional_count' => 8, 'is_popular' => false],
            ['icon' => 'fa-solid fa-boxes', 'icon_type' => 'fontawesome', 'name' => 'Packing & Moving', 'description' => 'Home shifting services', 'professional_count' => 12, 'is_popular' => false]
        ],
        'salon' => [
            ['icon' => 'fa-solid fa-scissors', 'icon_type' => 'fontawesome', 'name' => 'Haircut', 'description' => 'Men & women haircut, styling', 'professional_count' => 32, 'is_popular' => true],
            ['icon' => 'fa-solid fa-spa', 'icon_type' => 'fontawesome', 'name' => 'Facial', 'description' => 'Premium skincare treatments', 'professional_count' => 28, 'is_popular' => true],
            ['icon' => 'fa-solid fa-brush', 'icon_type' => 'fontawesome', 'name' => 'Make-up', 'description' => 'Party, bridal makeup', 'professional_count' => 25, 'is_popular' => true],
            ['icon' => 'fa-solid fa-hand-sparkles', 'icon_type' => 'fontawesome', 'name' => 'Manicure/Pedicure', 'description' => 'Nail care services', 'professional_count' => 22, 'is_popular' => true],
            ['icon' => 'fa-solid fa-hot-tub', 'icon_type' => 'fontawesome', 'name' => 'Spa', 'description' => 'Massage, relaxation therapy', 'professional_count' => 16, 'is_popular' => false],
            ['icon' => 'fa-solid fa-rings-wedding', 'icon_type' => 'fontawesome', 'name' => 'Bridal Package', 'description' => 'Complete bridal makeover', 'professional_count' => 12, 'is_popular' => false],
            ['icon' => 'fa-solid fa-palette', 'icon_type' => 'fontawesome', 'name' => 'Hair Color', 'description' => 'Professional coloring', 'professional_count' => 18, 'is_popular' => true],
            ['icon' => 'fa-solid fa-hot-tub-person', 'icon_type' => 'fontawesome', 'name' => 'Steam & Sauna', 'description' => 'Relaxation therapies', 'professional_count' => 10, 'is_popular' => false]
        ],
        'garage' => [
            ['icon' => 'fa-solid fa-car-wash', 'icon_type' => 'fontawesome', 'name' => 'Car Wash', 'description' => 'Professional cleaning, waxing', 'professional_count' => 30, 'is_popular' => true],
            ['icon' => 'fa-solid fa-screwdriver-wrench', 'icon_type' => 'fontawesome', 'name' => 'Repair', 'description' => 'Engine, transmission repair', 'professional_count' => 25, 'is_popular' => true],
            ['icon' => 'fa-solid fa-oil-can', 'icon_type' => 'fontawesome', 'name' => 'Oil Change', 'description' => 'Engine oil, filter change', 'professional_count' => 28, 'is_popular' => true],
            ['icon' => 'fa-solid fa-car-battery', 'icon_type' => 'fontawesome', 'name' => 'Battery Service', 'description' => 'Battery check, replacement', 'professional_count' => 20, 'is_popular' => false],
            ['icon' => 'fa-solid fa-tire', 'icon_type' => 'fontawesome', 'name' => 'Tire Service', 'description' => 'Tire rotation, alignment', 'professional_count' => 22, 'is_popular' => true],
            ['icon' => 'fa-solid fa-microchip', 'icon_type' => 'fontawesome', 'name' => 'Diagnostics', 'description' => 'Computer diagnostics', 'professional_count' => 15, 'is_popular' => false],
            ['icon' => 'fa-solid fa-wind', 'icon_type' => 'fontawesome', 'name' => 'AC Service', 'description' => 'Car AC repair', 'professional_count' => 12, 'is_popular' => true],
            ['icon' => 'fa-solid fa-spray-can-sparkles', 'icon_type' => 'fontawesome', 'name' => 'Detailing', 'description' => 'Complete car detailing', 'professional_count' => 10, 'is_popular' => false]
        ]
    ];
    
    return $fallbackServices[$category] ?? $fallbackServices['home'];
}

// Convert fallback services array to match database structure if needed
if (!isset($services[0]['icon_type'])) {
    $services = array_map(function($service) {
        return array_merge($service, ['icon_type' => 'fontawesome']);
    }, $services);
}

// Separate services into popular and regular
$popularServices = array_filter($services, function($service) {
    return $service['is_popular'] == 1;
});

$regularServices = array_filter($services, function($service) {
    return $service['is_popular'] == 0;
});

// Function to render icon based on type
function renderIcon($icon, $iconType = 'fontawesome') {
    if ($iconType === 'fontawesome') {
        return '<i class="' . htmlspecialchars($icon) . '"></i>';
    } else {
        return '<img src="' . htmlspecialchars($icon) . '" alt="service icon" class="service-svg-icon">';
    }
}
?>

<!-- Enhanced Category Banner -->
<section class="category-banner" style="background: linear-gradient(135deg, var(--secondary-color), var(--secondary-dark));">
    <div class="category-banner-container">
        <div class="category-banner-content">
            <div class="category-breadcrumb">
                <a href="dashboard.php">Home</a> > <span><?php echo htmlspecialchars($currentCategory['title']); ?></span>
            </div>
            <h1><?php echo htmlspecialchars($currentCategory['title']); ?></h1>
            <p class="category-description"><?php echo htmlspecialchars($currentCategory['description']); ?></p>
            <div class="category-banner-stats">
                <div class="banner-stat">
                    <span class="banner-stat-number"><?php echo count($services); ?>+</span>
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
            <img src="<?php echo htmlspecialchars($currentCategory['image']); ?>" alt="<?php echo htmlspecialchars($currentCategory['title']); ?>">
        </div>
    </div>
</section>

<!-- Popular Services Section (if there are popular services) -->
<?php if (!empty($popularServices)): ?>
<section class="popular-services-section">
    <div class="section-header">
        <h2>Popular <?php echo htmlspecialchars($currentCategory['title']); ?></h2>
        <p>Most booked services by our customers</p>
    </div>

    <div class="popular-services-grid">
        <?php foreach ($popularServices as $service): ?>
            <div class="popular-service-card" 
                 onclick="window.location.href='provider_list.php?category=<?php echo urlencode($category); ?>&service=<?php echo urlencode($service['name']); ?>'">
                <div class="popular-service-icon">
                    <?php 
                    $iconType = isset($service['icon_type']) ? $service['icon_type'] : 'fontawesome';
                    echo renderIcon($service['icon'], $iconType); 
                    ?>
                </div>
                <div class="popular-service-info">
                    <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                    <span class="popular-service-count icon-inline">
                        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M16 20a4 4 0 0 0-8 0"></path><circle cx="12" cy="10" r="3"></circle><path d="M21 20a4 4 0 0 0-5-3.9"></path><path d="M16.5 4.8a3 3 0 0 1 0 5.4"></path><path d="M3 20a4 4 0 0 1 5-3.9"></path><path d="M7.5 4.8a3 3 0 0 0 0 5.4"></path></svg>
                        <span><?php echo $service['professional_count']; ?> professionals</span>
                    </span>
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
        <h2>All <?php echo htmlspecialchars($currentCategory['title']); ?></h2>
        <p>Browse our complete range of services</p>
    </div>

    <div class="enhanced-services-grid">
        <?php foreach ($services as $service): ?>
            <div class="enhanced-service-card" 
                 onclick="window.location.href='provider_list.php?category=<?php echo urlencode($category); ?>&service=<?php echo urlencode($service['name']); ?>'">
                <div class="enhanced-service-icon-wrapper">
                    <div class="enhanced-service-icon">
                        <?php 
                        $iconType = isset($service['icon_type']) ? $service['icon_type'] : 'fontawesome';
                        echo renderIcon($service['icon'], $iconType); 
                        ?>
                    </div>
                    <?php if ($service['is_popular']): ?>
                        <span class="enhanced-service-badge">Popular</span>
                    <?php endif; ?>
                </div>
                <div class="enhanced-service-content">
                    <h3><?php echo htmlspecialchars($service['name']); ?></h3>
                    <p class="enhanced-service-desc"><?php echo htmlspecialchars($service['description']); ?></p>
                    <div class="enhanced-service-footer">
                        <span class="enhanced-service-count icon-inline">
                            <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M16 20a4 4 0 0 0-8 0"></path><circle cx="12" cy="10" r="3"></circle><path d="M21 20a4 4 0 0 0-5-3.9"></path><path d="M16.5 4.8a3 3 0 0 1 0 5.4"></path><path d="M3 20a4 4 0 0 1 5-3.9"></path><path d="M7.5 4.8a3 3 0 0 0 0 5.4"></path></svg>
                            <span><?php echo $service['professional_count']; ?> professionals</span>
                        </span>
                        <span class="enhanced-service-link icon-inline">
                            <span>View Professionals</span>
                            <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14"></path><path d="m13 6 6 6-6 6"></path></svg>
                        </span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- How It Works - Service Page Version -->
<section class="service-process-section">
    <div class="section-header">
        <h2>How It Works</h2>
        <p>Book your service in four simple steps</p>
    </div>

    <div class="service-process-steps">
        <div class="service-process-step">
            <div class="service-process-number">1</div>
            <div class="service-process-icon" aria-hidden="true">
                <svg class="icon-svg" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6"></circle><path d="m20 20-4.2-4.2"></path></svg>
            </div>
            <h3>Browse Services</h3>
            <p>Choose from our wide range of professional services</p>
        </div>
        <div class="service-process-step">
            <div class="service-process-number">2</div>
            <div class="service-process-icon" aria-hidden="true">
                <svg class="icon-svg" viewBox="0 0 24 24"><path d="M16 20a4 4 0 0 0-8 0"></path><circle cx="12" cy="10" r="3"></circle><path d="M21 20a4 4 0 0 0-5-3.9"></path><path d="M16.5 4.8a3 3 0 0 1 0 5.4"></path><path d="M3 20a4 4 0 0 1 5-3.9"></path><path d="M7.5 4.8a3 3 0 0 0 0 5.4"></path></svg>
            </div>
            <h3>Select Professional</h3>
            <p>Compare profiles, ratings, and prices</p>
        </div>
        <div class="service-process-step">
            <div class="service-process-number">3</div>
            <div class="service-process-icon" aria-hidden="true">
                <svg class="icon-svg" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"></rect><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M3 10h18"></path></svg>
            </div>
            <h3>Schedule</h3>
            <p>Pick a date and time that works for you</p>
        </div>
        <div class="service-process-step">
            <div class="service-process-number">4</div>
            <div class="service-process-icon" aria-hidden="true">
                <svg class="icon-svg" viewBox="0 0 24 24"><path d="m12 3 1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8L12 3Z"></path></svg>
            </div>
            <h3>Get Service</h3>
            <p>Professional arrives and completes the job</p>
        </div>
    </div>
</section>

<!-- Customer Reviews Section -->
<section class="service-reviews-section">
    <div class="section-header">
        <h2>What Customers Say</h2>
        <p>Real reviews from people who booked <?php echo strtolower(htmlspecialchars($currentCategory['title'])); ?></p>
    </div>

    <div class="service-reviews-grid">
        <div class="service-review-card">
            <div class="reviewer-info">
                <div class="reviewer-avatar" aria-hidden="true"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M18 20a6 6 0 0 0-12 0"></path><circle cx="12" cy="8" r="4"></circle></svg></div>
                <div class="reviewer-details">
                    <h4>Priya Sharma</h4>
                    <div class="review-rating icon-inline" aria-label="5 out of 5 stars"><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg></div>
                </div>
            </div>
            <p class="review-text">"Excellent service! The professional was thorough and fixed everything quickly."</p>
            <span class="review-service">Quality Service</span>
        </div>
        <div class="service-review-card">
            <div class="reviewer-info">
                <div class="reviewer-avatar" aria-hidden="true"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M18 20a6 6 0 0 0-12 0"></path><circle cx="12" cy="8" r="4"></circle></svg></div>
                <div class="reviewer-details">
                    <h4>Rajesh Kumar</h4>
                    <div class="review-rating icon-inline" aria-label="5 out of 5 stars"><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg></div>
                </div>
            </div>
            <p class="review-text">"Very professional and punctual. Will definitely book again!"</p>
            <span class="review-service">Excellent Experience</span>
        </div>
        <div class="service-review-card">
            <div class="reviewer-info">
                <div class="reviewer-avatar" aria-hidden="true"><svg class="icon-svg" viewBox="0 0 24 24"><path d="M18 20a6 6 0 0 0-12 0"></path><circle cx="12" cy="8" r="4"></circle></svg></div>
                <div class="reviewer-details">
                    <h4>Anita Desai</h4>
                    <div class="review-rating icon-inline" aria-label="5 out of 5 stars"><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg><svg class="icon-svg icon-svg-fill" viewBox="0 0 24 24" aria-hidden="true"><path d="m12 2.8 2.8 5.7 6.3.9-4.6 4.5 1.1 6.3L12 17.3 6.4 20.2l1.1-6.3-4.6-4.5 6.3-.9L12 2.8Z"></path></svg></div>
                </div>
            </div>
            <p class="review-text">"Great value for money. Highly recommended for all home services."</p>
            <span class="review-service">Great Value</span>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="service-faq-section">
    <div class="section-header">
        <h2>Frequently Asked Questions</h2>
        <p>Everything you need to know about our <?php echo strtolower(htmlspecialchars($currentCategory['title'])); ?></p>
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
