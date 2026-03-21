<?php
$category = $_GET['category'] ?? 'home';
$service = $_GET['service'] ?? 'Cleaning';

include 'header.php';
require_once 'db_conn.php';

$providers = [];
$serviceData = null;
$serviceTitle = $service . ' Professionals';
$errorMessage = '';

$sql = "SELECT s.id AS service_id, s.name AS service_name, c.slug AS category_slug
        FROM services s
        INNER JOIN categories c ON c.id = s.category_id
        WHERE c.slug = ? AND s.name = ?
        LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $category, $service);
$stmt->execute();
$serviceResult = $stmt->get_result();
$serviceData = $serviceResult->fetch_assoc();
$stmt->close();

if ($serviceData) {
    $serviceTitle = $serviceData['service_name'] . ' Professionals';
    $providerSql = "SELECT provider_id, provider_name, city, experience_years, rating, completed_jobs, price, image_url, bio
                    FROM provider
                    WHERE service_id = ? AND availability = 'yes'
                    ORDER BY rating DESC, experience_years DESC, price ASC";
    $providerStmt = $conn->prepare($providerSql);
    $providerStmt->bind_param("i", $serviceData['service_id']);
    $providerStmt->execute();
    $providerResult = $providerStmt->get_result();
    $providers = $providerResult->fetch_all(MYSQLI_ASSOC);
    $providerStmt->close();
} else {
    $errorMessage = "No providers found for the selected service yet.";
}

$conn->close();
?>

<section class="page-header">
    <div class="breadcrumb">
        <a href="dashboard.php">Home</a> >
        <a href="services.php?category=<?php echo urlencode($category); ?>"><?php echo htmlspecialchars(ucfirst($category)); ?> Services</a> >
        <span><?php echo htmlspecialchars($service); ?></span>
    </div>
    <h1><?php echo htmlspecialchars($serviceTitle); ?></h1>
    <p>Find the best <?php echo strtolower(htmlspecialchars($service)); ?> professionals near you</p>
</section>

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
            <span class="filter-tag" data-filter="price_low">Under &#8377;500</span>
        </div>
    </div>
    <div class="results-count" id="results-count"><?php echo count($providers); ?> professionals available</div>
</section>

<?php if ($errorMessage): ?>
    <section class="providers-container">
        <div class="booking-form-card" style="max-width: 900px; margin: 0 auto;">
            <h2 class="booking-form-title">Providers Unavailable</h2>
            <p class="booking-form-subtitle"><?php echo htmlspecialchars($errorMessage); ?></p>
            <a href="services.php?category=<?php echo urlencode($category); ?>" class="service-modern-btn">Back to Services</a>
        </div>
    </section>
<?php else: ?>
    <section class="providers-container" id="providers-grid">
        <?php foreach ($providers as $provider): ?>
            <div class="provider-card"
                 data-rating="<?php echo htmlspecialchars($provider['rating']); ?>"
                 data-experience="<?php echo htmlspecialchars($provider['experience_years']); ?>"
                 data-price="<?php echo htmlspecialchars($provider['price']); ?>"
                 data-name="<?php echo htmlspecialchars($provider['provider_name']); ?>"
                 data-city="<?php echo htmlspecialchars($provider['city']); ?>"
                 data-bio="<?php echo htmlspecialchars($provider['bio']); ?>">
                <div class="provider-badge"><i class="fa-solid fa-star"></i> Top Rated</div>
                <img src="<?php echo htmlspecialchars($provider['image_url']); ?>"
                     alt="<?php echo htmlspecialchars($provider['provider_name']); ?>"
                     class="provider-img"
                     onerror="this.src='https://via.placeholder.com/300x300?text=Provider'">
                <h3><?php echo htmlspecialchars($provider['provider_name']); ?></h3>
                <div class="provider-stats">
                    <span class="rating"><i class="fa-solid fa-star"></i> <?php echo htmlspecialchars($provider['rating']); ?></span>
                    <span class="jobs"><?php echo (int) $provider['completed_jobs']; ?> jobs</span>
                </div>
                <p class="experience"><?php echo (int) $provider['experience_years']; ?> Years Experience</p>
                <p class="desc"><?php echo htmlspecialchars($provider['bio']); ?></p>
                <div class="price-section">
                    <span class="price">&#8377;<?php echo number_format((float) $provider['price'], 0); ?></span>
                    <span class="per">per service</span>
                </div>
                <div class="provider-actions">
                    <button class="btn-primary book-btn" onclick="bookProvider(<?php echo (int) $provider['provider_id']; ?>)">Book Now</button>
                    <button class="btn-secondary" type="button" onclick="viewProfile(this)">View Profile</button>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<section class="booking-cta">
    <div class="cta-content">
        <h2>Not sure which professional to choose?</h2>
        <p>Our customer support team can help you find the perfect match for your needs</p>
        <button class="btn-primary btn-large" onclick="contactSupport()">Talk to Our Expert</button>
    </div>
</section>

<script>
const currentCategory = '<?php echo addslashes($category); ?>';
const currentService = '<?php echo addslashes($service); ?>';

function bookProvider(providerId) {
    const params = new URLSearchParams({
        category: currentCategory,
        service: currentService,
        provider_id: providerId
    });
    window.location.href = 'booking.php?' + params.toString();
}

function sortProviders(criteria) {
    const grid = document.getElementById('providers-grid');
    if (!grid) return;
    const cards = Array.from(grid.getElementsByClassName('provider-card'));
    cards.sort((a, b) => {
        let aVal;
        let bVal;
        switch (criteria) {
            case 'rating':
                aVal = parseFloat(a.dataset.rating);
                bVal = parseFloat(b.dataset.rating);
                return bVal - aVal;
            case 'experience':
                aVal = parseInt(a.dataset.experience, 10);
                bVal = parseInt(b.dataset.experience, 10);
                return bVal - aVal;
            case 'price_low':
                aVal = parseFloat(a.dataset.price);
                bVal = parseFloat(b.dataset.price);
                return aVal - bVal;
            case 'price_high':
                aVal = parseFloat(a.dataset.price);
                bVal = parseFloat(b.dataset.price);
                return bVal - aVal;
            default:
                return 0;
        }
    });
    grid.innerHTML = '';
    cards.forEach(card => grid.appendChild(card));
    updateResultsCount();
}

function filterProviders(filterType) {
    const grid = document.getElementById('providers-grid');
    if (!grid) return;
    const cards = Array.from(grid.getElementsByClassName('provider-card'));
    let visibleCount = 0;
    cards.forEach(card => {
        let show = true;
        const rating = parseFloat(card.dataset.rating);
        const experience = parseInt(card.dataset.experience, 10);
        const price = parseFloat(card.dataset.price);
        switch (filterType) {
            case 'rating':
                show = rating >= 4.5;
                break;
            case 'experience':
                show = experience >= 5;
                break;
            case 'price_low':
                show = price <= 500;
                break;
            default:
                show = true;
        }
        card.style.display = show ? '' : 'none';
        if (show) visibleCount++;
    });
    updateResultsCount(visibleCount);
}

function updateResultsCount(visibleCount = null) {
    const countElement = document.getElementById('results-count');
    if (!countElement) return;
    const cards = Array.from(document.getElementsByClassName('provider-card'));
    const totalVisible = visibleCount === null ? cards.filter(card => card.style.display !== 'none').length : visibleCount;
    countElement.textContent = `${totalVisible} professional${totalVisible !== 1 ? 's' : ''} available`;
}

function viewProfile(button) {
    const card = button.closest('.provider-card');
    alert(`${card.dataset.name}\n${card.dataset.city}\nRating: ${card.dataset.rating}\nExperience: ${card.dataset.experience} years\n\n${card.dataset.bio}`);
}

function contactSupport() {
    alert('Our customer support team will contact you shortly.\n\nYou can also call us at: 1800-123-4567');
}

document.querySelectorAll('.filter-tag').forEach(tag => {
    tag.addEventListener('click', function() {
        document.querySelectorAll('.filter-tag').forEach(item => item.classList.remove('active'));
        this.classList.add('active');
        filterProviders(this.getAttribute('data-filter'));
    });
});

document.addEventListener('DOMContentLoaded', function() {
    filterProviders('all');
});
</script>

<?php include 'footer.php'; ?>
