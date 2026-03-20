<?php
$category = $_GET['category'] ?? 'home';
$service = $_GET['service'] ?? 'Cleaning';
include 'header.php';

// Dynamic provider data based on category and service
$providers = [
    'home' => [
        'Cleaning' => [
            ['name' => 'Rahul Sharma', 'rating' => 4.7, 'experience' => 5, 'price' => 500, 'image' => '32', 'desc' => 'Expert in deep home cleaning and kitchen sanitation.', 'jobs' => 342],
            ['name' => 'Priya Patel', 'rating' => 4.8, 'experience' => 6, 'price' => 600, 'image' => '44', 'desc' => 'Specialist in apartment and office cleaning services.', 'jobs' => 567],
            ['name' => 'Amit Verma', 'rating' => 4.5, 'experience' => 3, 'price' => 450, 'image' => '67', 'desc' => 'Affordable and reliable cleaning professional.', 'jobs' => 234],
            ['name' => 'Neha Singh', 'rating' => 4.9, 'experience' => 8, 'price' => 750, 'image' => '28', 'desc' => 'Premium cleaning services with 100% satisfaction.', 'jobs' => 891],
            ['name' => 'Vikram Mehta', 'rating' => 4.6, 'experience' => 4, 'price' => 550, 'image' => '45', 'desc' => 'Eco-friendly cleaning solutions.', 'jobs' => 423]
        ],
        'Electrician' => [
            ['name' => 'Suresh Kumar', 'rating' => 4.8, 'experience' => 10, 'price' => 600, 'image' => '51', 'desc' => 'Master electrician for all electrical work.', 'jobs' => 1234],
            ['name' => 'Rajesh Gupta', 'rating' => 4.7, 'experience' => 7, 'price' => 550, 'image' => '62', 'desc' => 'Specialist in home wiring and repairs.', 'jobs' => 876],
            ['name' => 'Amit Singh', 'rating' => 4.9, 'experience' => 12, 'price' => 750, 'image' => '58', 'desc' => 'Expert in smart home installations.', 'jobs' => 1543],
            ['name' => 'Vikram Joshi', 'rating' => 4.6, 'experience' => 5, 'price' => 500, 'image' => '71', 'desc' => 'Affordable electrical repairs and maintenance.', 'jobs' => 654]
        ],
        'Plumbing' => [
            ['name' => 'Suresh Kumar', 'rating' => 4.8, 'experience' => 10, 'price' => 600, 'image' => '51', 'desc' => 'Expert plumber for all pipe and fixture repairs.', 'jobs' => 1234],
            ['name' => 'Rajesh Gupta', 'rating' => 4.7, 'experience' => 7, 'price' => 550, 'image' => '62', 'desc' => 'Specialist in bathroom and kitchen plumbing.', 'jobs' => 876],
            ['name' => 'Manoj Verma', 'rating' => 4.9, 'experience' => 15, 'price' => 800, 'image' => '73', 'desc' => 'Master plumber with 15+ years experience.', 'jobs' => 2341],
            ['name' => 'Ravi Shankar', 'rating' => 4.5, 'experience' => 4, 'price' => 450, 'image' => '69', 'desc' => 'Quick and reliable plumbing services.', 'jobs' => 543]
        ],
        'AC Service' => [
            ['name' => 'Rahul Mehta', 'rating' => 4.8, 'experience' => 8, 'price' => 700, 'image' => '47', 'desc' => 'AC repair and maintenance specialist.', 'jobs' => 987],
            ['name' => 'Ankit Sharma', 'rating' => 4.7, 'experience' => 6, 'price' => 650, 'image' => '52', 'desc' => 'Expert in all AC brands and models.', 'jobs' => 765]
        ]
    ],
    'salon' => [
        'Haircut' => [
            ['name' => 'Arjun Kapoor', 'rating' => 4.9, 'experience' => 8, 'price' => 400, 'image' => '55', 'desc' => 'Expert hairstylist for men and women.', 'jobs' => 2341],
            ['name' => 'Meera Nair', 'rating' => 4.8, 'experience' => 6, 'price' => 450, 'image' => '49', 'desc' => 'Specialist in modern haircuts and styling.', 'jobs' => 1876],
            ['name' => 'Rohan Das', 'rating' => 4.7, 'experience' => 5, 'price' => 350, 'image' => '64', 'desc' => 'Affordable haircuts for all ages.', 'jobs' => 1543],
            ['name' => 'Priya Kaur', 'rating' => 4.9, 'experience' => 9, 'price' => 500, 'image' => '38', 'desc' => 'Premium hairstyling and coloring services.', 'jobs' => 2678]
        ],
        'Facial' => [
            ['name' => 'Pooja Malhotra', 'rating' => 4.9, 'experience' => 7, 'price' => 800, 'image' => '33', 'desc' => 'Premium facial and skincare treatments.', 'jobs' => 1456],
            ['name' => 'Riya Kapoor', 'rating' => 4.7, 'experience' => 5, 'price' => 600, 'image' => '42', 'desc' => 'Specialist in organic and natural facials.', 'jobs' => 987],
            ['name' => 'Neha Gupta', 'rating' => 4.8, 'experience' => 6, 'price' => 750, 'image' => '46', 'desc' => 'Expert in anti-aging and glow facials.', 'jobs' => 1234]
        ],
        'Make-up' => [
            ['name' => 'Shreya Jain', 'rating' => 4.9, 'experience' => 8, 'price' => 1200, 'image' => '35', 'desc' => 'Bridal and party makeup specialist.', 'jobs' => 876],
            ['name' => 'Kavita Reddy', 'rating' => 4.8, 'experience' => 6, 'price' => 1000, 'image' => '39', 'desc' => 'Expert in airbrush and HD makeup.', 'jobs' => 654]
        ],
        'Manicure/Pedicure' => [
            ['name' => 'Sneha Sharma', 'rating' => 4.8, 'experience' => 5, 'price' => 500, 'image' => '43', 'desc' => 'Expert nail care and art specialist.', 'jobs' => 765],
            ['name' => 'Divya Patel', 'rating' => 4.7, 'experience' => 4, 'price' => 450, 'image' => '48', 'desc' => 'Affordable manicure and pedicure services.', 'jobs' => 543]
        ]
    ],
    'garage' => [
        'Car Wash' => [
            ['name' => 'Mohan Singh', 'rating' => 4.8, 'experience' => 9, 'price' => 400, 'image' => '71', 'desc' => 'Expert in professional car washing and detailing.', 'jobs' => 2345],
            ['name' => 'Ravi Kumar', 'rating' => 4.7, 'experience' => 6, 'price' => 350, 'image' => '68', 'desc' => 'Specialist in eco-friendly car wash.', 'jobs' => 1678],
            ['name' => 'Amit Patel', 'rating' => 4.9, 'experience' => 8, 'price' => 500, 'image' => '72', 'desc' => 'Premium car detailing and ceramic coating.', 'jobs' => 2890]
        ],
        'Repair' => [
            ['name' => 'Dinesh Yadav', 'rating' => 4.9, 'experience' => 12, 'price' => 800, 'image' => '57', 'desc' => 'Master mechanic for all car repairs.', 'jobs' => 3456],
            ['name' => 'Sanjay Gupta', 'rating' => 4.8, 'experience' => 10, 'price' => 700, 'image' => '63', 'desc' => 'Specialist in engine and transmission repair.', 'jobs' => 2789],
            ['name' => 'Rajesh Kumar', 'rating' => 4.7, 'experience' => 7, 'price' => 600, 'image' => '74', 'desc' => 'Affordable car repair and maintenance.', 'jobs' => 1987]
        ],
        'Oil Change' => [
            ['name' => 'Vikram Singh', 'rating' => 4.8, 'experience' => 8, 'price' => 500, 'image' => '66', 'desc' => 'Expert in oil change and engine maintenance.', 'jobs' => 1876],
            ['name' => 'Rohit Sharma', 'rating' => 4.7, 'experience' => 5, 'price' => 450, 'image' => '75', 'desc' => 'Quick and reliable oil change services.', 'jobs' => 1234]
        ],
        'Tire Service' => [
            ['name' => 'Nitin Mehta', 'rating' => 4.8, 'experience' => 9, 'price' => 600, 'image' => '59', 'desc' => 'Expert in tire rotation, alignment, and replacement.', 'jobs' => 1567],
            ['name' => 'Pankaj Gupta', 'rating' => 4.7, 'experience' => 6, 'price' => 550, 'image' => '76', 'desc' => 'Specialist in tire repair and balancing.', 'jobs' => 1098]
        ]
    ]
];

// Get providers for the selected service, or fallback to first service in category
$currentProviders = [];
if (isset($providers[$category][$service])) {
    $currentProviders = $providers[$category][$service];
} else {
    // Fallback: get the first service's providers in this category
    $firstService = array_keys($providers[$category])[0] ?? 'Cleaning';
    $currentProviders = $providers[$category][$firstService];
    $service = $firstService; // Update service name for display
}

$serviceTitle = $service . ' Professionals';
?>

<!-- Page Header with Breadcrumb -->
<section class="page-header">
    <div class="breadcrumb">
        <a href="Dashboard.php">Home</a> > 
        <a href="services.php?category=<?php echo urlencode($category); ?>"><?php echo ucfirst($category); ?> Services</a> > 
        <span><?php echo htmlspecialchars($service); ?></span>
    </div>
    <h1><?php echo htmlspecialchars($serviceTitle); ?></h1>
    <p>Find the best <?php echo strtolower(htmlspecialchars($service)); ?> professionals near you</p>
</section>

<!-- Filter and Sort Bar -->
<section class="filter-bar">
    <div class="filter-options">
        <div class="sort-dropdown">
            <label>Sort by:</label>
            <select id="sort" onchange="sortProviders(this.value)">
                <option value="rating">Rating: High to Low</option>
                <option value="experience">Experience: High to Low</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
            </select>
        </div>
        <div class="filter-tags">
            <span class="filter-tag active" data-filter="all">All</span>
            <span class="filter-tag" data-filter="rating">4.5+ Rating</span>
            <span class="filter-tag" data-filter="experience">5+ Years</span>
            <span class="filter-tag" data-filter="price_low">Under ₹500</span>
        </div>
    </div>
    <div class="results-count" id="results-count"><?php echo count($currentProviders); ?> professionals available</div>
</section>

<!-- Providers Grid -->
<section class="providers-container" id="providers-grid">
    <?php foreach ($currentProviders as $index => $provider): ?>
        <div class="provider-card" 
             data-rating="<?php echo $provider['rating']; ?>" 
             data-experience="<?php echo $provider['experience']; ?>" 
             data-price="<?php echo $provider['price']; ?>"
             data-name="<?php echo htmlspecialchars($provider['name']); ?>">
            
            <div class="provider-badge">⭐ Top Rated</div>
            
            <img src="https://randomuser.me/api/portraits/men/<?php echo $provider['image']; ?>.jpg" 
                 alt="<?php echo htmlspecialchars($provider['name']); ?>" 
                 class="provider-img"
                 onerror="this.src='https://randomuser.me/api/portraits/women/<?php echo $provider['image']; ?>.jpg'">
            
            <h3><?php echo htmlspecialchars($provider['name']); ?></h3>
            
            <div class="provider-stats">
                <span class="rating">⭐ <?php echo $provider['rating']; ?></span>
                <span class="jobs"><?php echo $provider['jobs']; ?> jobs</span>
            </div>
            
            <p class="experience"><?php echo $provider['experience']; ?> Years Experience</p>
            
            <p class="desc"><?php echo htmlspecialchars($provider['desc']); ?></p>
            
            <div class="price-section">
                <span class="price">₹<?php echo $provider['price']; ?></span>
                <span class="per">per service</span>
            </div>
            
            <div class="provider-actions">
                <button class="btn-primary book-btn" 
                        onclick="bookProvider('<?php echo htmlspecialchars($provider['name']); ?>', <?php echo $provider['price']; ?>)">
                    Book Now
                </button>
                <button class="btn-secondary" onclick="viewProfile('<?php echo htmlspecialchars($provider['name']); ?>')">View Profile</button>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<!-- Booking CTA Section -->
<section class="booking-cta">
    <div class="cta-content">
        <h2>Not sure which professional to choose?</h2>
        <p>Our customer support team can help you find the perfect match for your needs</p>
        <button class="btn-primary btn-large" onclick="contactSupport()">Talk to Our Expert</button>
    </div>
</section>

<script>
// Store current category and service for booking
const currentCategory = '<?php echo addslashes($category); ?>';
const currentService = '<?php echo addslashes($service); ?>';

// Function to redirect to booking page
function bookProvider(providerName, price) {
    // Encode parameters for URL
    const params = new URLSearchParams({
        service: currentService,
        provider: providerName,
        category: currentCategory,
        price: price
    });
    
    // Redirect to booking page with all parameters
    window.location.href = 'booking.php?' + params.toString();
}

// Enhanced sorting function
function sortProviders(criteria) {
    const grid = document.getElementById('providers-grid');
    const cards = Array.from(grid.getElementsByClassName('provider-card'));
    
    cards.sort((a, b) => {
        let aVal, bVal;
        
        switch(criteria) {
            case 'rating':
                aVal = parseFloat(a.dataset.rating);
                bVal = parseFloat(b.dataset.rating);
                return bVal - aVal;
            case 'experience':
                aVal = parseInt(a.dataset.experience);
                bVal = parseInt(b.dataset.experience);
                return bVal - aVal;
            case 'price_low':
                aVal = parseInt(a.dataset.price);
                bVal = parseInt(b.dataset.price);
                return aVal - bVal;
            case 'price_high':
                aVal = parseInt(a.dataset.price);
                bVal = parseInt(b.dataset.price);
                return bVal - aVal;
            default:
                return 0;
        }
    });
    
    grid.innerHTML = '';
    cards.forEach(card => grid.appendChild(card));
    updateResultsCount();
}

// Filter providers based on selected filter
function filterProviders(filterType) {
    const grid = document.getElementById('providers-grid');
    const cards = Array.from(grid.getElementsByClassName('provider-card'));
    let visibleCount = 0;
    
    cards.forEach(card => {
        let show = true;
        const rating = parseFloat(card.dataset.rating);
        const experience = parseInt(card.dataset.experience);
        const price = parseInt(card.dataset.price);
        
        switch(filterType) {
            case 'rating':
                show = rating >= 4.5;
                break;
            case 'experience':
                show = experience >= 5;
                break;
            case 'price_low':
                show = price <= 500;
                break;
            case 'all':
                show = true;
                break;
        }
        
        if (show) {
            card.style.display = '';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });
    
    updateResultsCount(visibleCount);
}

// Update results count display
function updateResultsCount(visibleCount = null) {
    const countElement = document.getElementById('results-count');
    const cards = Array.from(document.getElementsByClassName('provider-card'));
    
    if (visibleCount === null) {
        visibleCount = cards.filter(card => card.style.display !== 'none').length;
    }
    
    countElement.textContent = `${visibleCount} professional${visibleCount !== 1 ? 's' : ''} available`;
}

// View profile function
function viewProfile(providerName) {
    // Show a modal or redirect to profile page
    alert(`Viewing profile of ${providerName}\n\nFull profile details will be available soon.`);
}

// Contact support function
function contactSupport() {
    alert('Our customer support team will contact you shortly!\n\nYou can also call us at: 1800-123-4567');
}

// Filter tags functionality
document.querySelectorAll('.filter-tag').forEach(tag => {
    tag.addEventListener('click', function() {
        // Remove active class from all tags
        document.querySelectorAll('.filter-tag').forEach(t => t.classList.remove('active'));
        // Add active class to clicked tag
        this.classList.add('active');
        
        // Get filter type from data-filter attribute
        const filterType = this.getAttribute('data-filter');
        filterProviders(filterType);
    });
});

// Initialize with all providers visible
document.addEventListener('DOMContentLoaded', function() {
    filterProviders('all');
});
</script>

<?php include 'footer.php'; ?>