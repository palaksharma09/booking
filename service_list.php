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
            ['name' => 'Rajesh Gupta', 'rating' => 4.7, 'experience' => 7, 'price' => 550, 'image' => '62', 'desc' => 'Specialist in home wiring and repairs.', 'jobs' => 876]
        ],
        'Cooking' => [
            ['name' => 'Anita Desai', 'rating' => 4.9, 'experience' => 12, 'price' => 700, 'image' => '37', 'desc' => 'Expert in North Indian and Chinese cuisine.', 'jobs' => 1567],
            ['name' => 'Kavita Sharma', 'rating' => 4.8, 'experience' => 8, 'price' => 650, 'image' => '41', 'desc' => 'Specialist in South Indian and Gujarati food.', 'jobs' => 982]
        ]
    ],
    'salon' => [
        'Haircut' => [
            ['name' => 'Arjun Kapoor', 'rating' => 4.9, 'experience' => 8, 'price' => 400, 'image' => '55', 'desc' => 'Expert hairstylist for men and women.', 'jobs' => 2341],
            ['name' => 'Meera Nair', 'rating' => 4.8, 'experience' => 6, 'price' => 450, 'image' => '49', 'desc' => 'Specialist in modern haircuts and styling.', 'jobs' => 1876]
        ],
        'Facial' => [
            ['name' => 'Pooja Malhotra', 'rating' => 4.9, 'experience' => 7, 'price' => 800, 'image' => '33', 'desc' => 'Premium facial and skincare treatments.', 'jobs' => 1456],
            ['name' => 'Riya Kapoor', 'rating' => 4.7, 'experience' => 5, 'price' => 600, 'image' => '42', 'desc' => 'Specialist in organic and natural facials.', 'jobs' => 987]
        ]
    ],
    'garage' => [
        'Car Wash' => [
            ['name' => 'Mohan Singh', 'rating' => 4.8, 'experience' => 9, 'price' => 400, 'image' => '71', 'desc' => 'Expert in professional car washing and detailing.', 'jobs' => 2345],
            ['name' => 'Ravi Kumar', 'rating' => 4.7, 'experience' => 6, 'price' => 350, 'image' => '68', 'desc' => 'Specialist in eco-friendly car wash.', 'jobs' => 1678]
        ],
        'Repair' => [
            ['name' => 'Dinesh Yadav', 'rating' => 4.9, 'experience' => 12, 'price' => 800, 'image' => '57', 'desc' => 'Master mechanic for all car repairs.', 'jobs' => 3456],
            ['name' => 'Sanjay Gupta', 'rating' => 4.8, 'experience' => 10, 'price' => 700, 'image' => '63', 'desc' => 'Specialist in engine and transmission repair.', 'jobs' => 2789]
        ]
    ]
];

$currentProviders = $providers[$category][$service] ?? $providers[$category]['Cleaning'];
$serviceTitle = $service . ' Professionals';
?>

<!-- Page Header with Breadcrumb -->
<section class="page-header">
    <div class="breadcrumb">
        <a href="Dashboard.php">Home</a> > 
        <a href="services.php?category=<?php echo $category; ?>"><?php echo ucfirst($category); ?> Services</a> > 
        <span><?php echo $service; ?></span>
    </div>
    <h1><?php echo $serviceTitle; ?></h1>
    <p>Find the best <?php echo strtolower($service); ?> professionals near you</p>
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
            <span class="filter-tag active">All</span>
            <span class="filter-tag">4.5+ Rating</span>
            <span class="filter-tag">5+ Years</span>
            <span class="filter-tag">Under ₹500</span>
        </div>
    </div>
    <div class="results-count"><?php echo count($currentProviders); ?> professionals available</div>
</section>

<!-- Providers Grid -->
<section class="providers-container" id="providers-grid">
    <?php foreach ($currentProviders as $provider): ?>
        <div class="provider-card" 
             data-rating="<?php echo $provider['rating']; ?>" 
             data-experience="<?php echo $provider['experience']; ?>" 
             data-price="<?php echo $provider['price']; ?>">
            
            <div class="provider-badge">⭐ Top Rated</div>
            
            <img src="https://randomuser.me/api/portraits/men/<?php echo $provider['image']; ?>.jpg" 
                 alt="<?php echo $provider['name']; ?>" 
                 class="provider-img"
                 onerror="this.src='https://randomuser.me/api/portraits/women/<?php echo $provider['image']; ?>.jpg'">
            
            <h3><?php echo $provider['name']; ?></h3>
            
            <div class="provider-stats">
                <span class="rating">⭐ <?php echo $provider['rating']; ?></span>
                <span class="jobs"><?php echo $provider['jobs']; ?> jobs</span>
            </div>
            
            <p class="experience"><?php echo $provider['experience']; ?> Years Experience</p>
            
            <p class="desc"><?php echo $provider['desc']; ?></p>
            
            <div class="price-section">
                <span class="price">₹<?php echo $provider['price']; ?></span>
                <span class="per">per service</span>
            </div>
            
            <div class="provider-actions">
                <button class="btn-primary book-btn" onclick="bookProvider('<?php echo $provider['name']; ?>')">Book Now</button>
                <button class="btn-secondary" onclick="viewProfile('<?php echo $provider['name']; ?>')">View Profile</button>
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
// Simple JavaScript for sorting (you can enhance this)
function sortProviders(criteria) {
    const grid = document.getElementById('providers-grid');
    const cards = Array.from(grid.getElementsByClassName('provider-card'));
    
    cards.sort((a, b) => {
        const aVal = parseFloat(a.dataset[criteria.split('_')[0]]);
        const bVal = parseFloat(b.dataset[criteria.split('_')[0]]);
        
        if (criteria.includes('_low')) {
            return aVal - bVal;
        }
        return bVal - aVal;
    });
    
    grid.innerHTML = '';
    cards.forEach(card => grid.appendChild(card));
}

function bookProvider(name) {
    alert(`Booking confirmation for ${name}. This will be integrated with payment gateway.`);
}

function viewProfile(name) {
    alert(`Viewing profile of ${name}`);
}

function contactSupport() {
    alert('Our support team will contact you shortly!');
}

// Filter tags functionality
document.querySelectorAll('.filter-tag').forEach(tag => {
    tag.addEventListener('click', function() {
        document.querySelectorAll('.filter-tag').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        // Add filter logic here
    });
});
</script>

<?php include 'footer.php'; ?>