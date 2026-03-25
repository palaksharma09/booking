<?php include 'header.php'; ?>

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
                <span class="badge-icon"><i class="fa-solid fa-check"></i></span>
                <span>Verified Professionals</span>
            </div>
        </div>
    </div>
</section>

<section id="our-services" class="our-services-section">
    <div class="section-header">
        <h2>Our Services</h2>
        <p>Choose from a wide range of professional services tailored to your needs</p>
    </div>

    <div class="services-modern-grid">
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
                <div class="service-modern-icon"><i class="fa-solid fa-house"></i></div>
                <h3>Home Services</h3>
                <p class="service-modern-desc">Complete home maintenance solutions from cleaning to repairs</p>
                <div class="service-modern-features">
                    <div class="feature-pill"><span><i class="fa-solid fa-broom"></i> Cleaning</span></div>
                    <div class="feature-pill"><span><i class="fa-solid fa-bolt"></i> Electric</span></div>
                    <div class="feature-pill"><span><i class="fa-solid fa-wrench"></i> Plumbing</span></div>
                    <div class="feature-pill"><span><i class="fa-solid fa-utensils"></i> Cooking</span></div>
                </div>
                <div class="service-modern-footer">
                    <span class="service-price">Starting &#8377;499</span>
                    <a href="services.php?category=home" class="service-modern-btn">
                        Book Now
                        <span class="btn-arrow">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>

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
                <div class="service-modern-icon"><i class="fa-solid fa-scissors"></i></div>
                <h3>Salon Services</h3>
                <p class="service-modern-desc">Premium beauty and wellness at your convenience</p>
                <div class="service-modern-features">
                    <div class="feature-pill"><span><i class="fa-solid fa-scissors"></i> Haircut</span></div>
                    <div class="feature-pill"><span><i class="fa-solid fa-spa"></i> Facial</span></div>
                    <div class="feature-pill"><span><i class="fa-solid fa-brush"></i> Make-up</span></div>
                    <div class="feature-pill"><span><i class="fa-solid fa-hand-sparkles"></i> Manicure</span></div>
                </div>
                <div class="service-modern-footer">
                    <span class="service-price">Starting &#8377;399</span>
                    <a href="services.php?category=salon" class="service-modern-btn">
                        Book Now
                        <span class="btn-arrow">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>

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
                <div class="service-modern-icon"><i class="fa-solid fa-car-side"></i></div>
                <h3>Garage Services</h3>
                <p class="service-modern-desc">Expert car care and maintenance at your doorstep</p>
                <div class="service-modern-features">
                    <div class="feature-pill"><span><i class="fa-solid fa-car"></i> Car Wash</span></div>
                    <div class="feature-pill"><span><i class="fa-solid fa-screwdriver-wrench"></i> Repair</span></div>
                    <div class="feature-pill"><span><i class="fa-solid fa-oil-can"></i> Oil Change</span></div>
                    <div class="feature-pill"><span><i class="fa-solid fa-car-battery"></i> Battery</span></div>
                </div>
                <div class="service-modern-footer">
                    <span class="service-price">Starting &#8377;299</span>
                    <a href="services.php?category=garage" class="service-modern-btn">
                        Book Now
                        <span class="btn-arrow">&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="services-cta">
        <a href="services.php" class="btn-primary btn-large">View All Services</a>
    </div>
</section>

<section class="features-section">
    <div class="section-header">
        <h2>Why Choose Fixora?</h2>
        <p>We connect you with the best professionals in your area</p>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-circle-check"></i></div>
            <h3>Verified Professionals</h3>
            <p>All service providers are background checked and verified</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-wallet"></i></div>
            <h3>Best Price Guarantee</h3>
            <p>Transparent pricing with no hidden charges</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-star"></i></div>
            <h3>5-Star Service</h3>
            <p>Thousands of happy customers across India</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-lock"></i></div>
            <h3>Secure Payments</h3>
            <p>Pay only after service completion</p>
        </div>
    </div>
</section>

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
            <h3>Book &amp; Relax</h3>
            <p>Schedule the service and we'll handle the rest</p>
        </div>
    </div>
</section>

<section class="testimonials">
    <div class="section-header">
        <h2>What Our Customers Say</h2>
        <p>Recent reviews from verified bookings across home, salon, and garage services</p>
    </div>

    <div class="testimonials-carousel" data-carousel>
        <button class="testimonial-nav prev" type="button" aria-label="Previous reviews" data-carousel-prev>
            <i class="fa-solid fa-arrow-left"></i>
        </button>

        <div class="testimonials-viewport">
            <div class="testimonials-track" data-carousel-track>
                <article class="testimonial-card">
                    <div class="testimonial-meta">
                        <span class="testimonial-badge">Plumbing</span>
                        <span class="testimonial-date">Booked on 14 Mar 2026</span>
                    </div>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p>"Booked a kitchen sink repair in the evening and the issue was fixed the next morning. The plumber explained the leak clearly and even cleaned the area before leaving."</p>
                    <div class="customer-info">
                        <strong>Rajesh Kumar</strong>
                        <span>Mumbai • Home Services</span>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-meta">
                        <span class="testimonial-badge">Bridal Make-up</span>
                        <span class="testimonial-date">Booked on 08 Mar 2026</span>
                    </div>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p>"The artist arrived on time, matched the look to my reference photos, and the makeup stayed intact through the full wedding ceremony. Very calm and professional experience."</p>
                    <div class="customer-info">
                        <strong>Priya Sharma</strong>
                        <span>Pune • Salon Services</span>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-meta">
                        <span class="testimonial-badge">Car Repair</span>
                        <span class="testimonial-date">Booked on 02 Mar 2026</span>
                    </div>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p>"I had a recurring starting issue with my i20. The mechanic diagnosed the battery terminal problem correctly, fixed it in one visit, and the pricing was transparent."</p>
                    <div class="customer-info">
                        <strong>Amit Patel</strong>
                        <span>Ahmedabad • Garage Services</span>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-meta">
                        <span class="testimonial-badge">Deep Cleaning</span>
                        <span class="testimonial-date">Booked on 18 Feb 2026</span>
                    </div>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></div>
                    <p>"Good attention to detail, especially in the kitchen and bathrooms. It took a bit longer than expected, but the team was polite and the result was worth it."</p>
                    <div class="customer-info">
                        <strong>Neha Sood</strong>
                        <span>Delhi • Home Services</span>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-meta">
                        <span class="testimonial-badge">Haircut at Home</span>
                        <span class="testimonial-date">Booked on 05 Mar 2026</span>
                    </div>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p>"I usually avoid trying new stylists, but this was genuinely good. The haircut was neat, the setup was hygienic, and the stylist listened to what I wanted."</p>
                    <div class="customer-info">
                        <strong>Megha Nair</strong>
                        <span>Bengaluru • Salon Services</span>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-meta">
                        <span class="testimonial-badge">AC Service</span>
                        <span class="testimonial-date">Booked on 11 Mar 2026</span>
                    </div>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p>"The technician checked the cooling, cleaned the indoor unit, and pointed out an airflow issue we had missed. The AC is cooling much better now."</p>
                    <div class="customer-info">
                        <strong>Vikram Rao</strong>
                        <span>Chennai • Home Services</span>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-meta">
                        <span class="testimonial-badge">Manicure/Pedicure</span>
                        <span class="testimonial-date">Booked on 27 Feb 2026</span>
                    </div>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></div>
                    <p>"The service was relaxing and clean, and the finish looked great. I’d book the same professional again, especially for a weekend appointment at home."</p>
                    <div class="customer-info">
                        <strong>Ritu Malhotra</strong>
                        <span>Gurugram • Salon Services</span>
                    </div>
                </article>

                <article class="testimonial-card">
                    <div class="testimonial-meta">
                        <span class="testimonial-badge">Car Detailing</span>
                        <span class="testimonial-date">Booked on 01 Mar 2026</span>
                    </div>
                    <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                    <p>"Interior cleaning was especially impressive. The dashboard, seats, and boot area looked refreshed, and the team did not rush through the smaller details."</p>
                    <div class="customer-info">
                        <strong>Sandeep Arora</strong>
                        <span>Noida • Garage Services</span>
                    </div>
                </article>
            </div>
        </div>

        <button class="testimonial-nav next" type="button" aria-label="Next reviews" data-carousel-next>
            <i class="fa-solid fa-arrow-right"></i>
        </button>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.querySelector('[data-carousel]');
    if (!carousel) return;

    const viewport = carousel.querySelector('.testimonials-viewport');
    const track = carousel.querySelector('[data-carousel-track]');
    const cards = Array.from(track.children);
    const prevButton = carousel.querySelector('[data-carousel-prev]');
    const nextButton = carousel.querySelector('[data-carousel-next]');
    let animationId = null;
    let paused = false;
    let pauseTimeout = null;

    cards.forEach((card) => {
        const clone = card.cloneNode(true);
        clone.setAttribute('aria-hidden', 'true');
        track.appendChild(clone);
    });

    function getStepSize() {
        const firstCard = track.querySelector('.testimonial-card');
        if (!firstCard) return 360;
        const gap = parseFloat(window.getComputedStyle(track).gap || 24);
        return firstCard.getBoundingClientRect().width + gap;
    }

    function animate() {
        if (!paused) {
            viewport.scrollLeft += window.innerWidth <= 720 ? 0.45 : 0.6;
            if (viewport.scrollLeft >= track.scrollWidth / 2) {
                viewport.scrollLeft = 0;
            }
        }
        animationId = window.requestAnimationFrame(animate);
    }

    function startCarousel() {
        if (animationId) {
            window.cancelAnimationFrame(animationId);
        }
        animationId = window.requestAnimationFrame(animate);
    }

    function pauseCarousel() {
        paused = true;
    }

    function resumeCarousel() {
        paused = false;
    }

    function nudge(direction) {
        pauseCarousel();
        window.clearTimeout(pauseTimeout);
        viewport.scrollBy({
            left: getStepSize() * direction,
            behavior: 'smooth'
        });
        pauseTimeout = window.setTimeout(resumeCarousel, 1200);
    }

    prevButton.addEventListener('click', function () {
        nudge(-1);
    });

    nextButton.addEventListener('click', function () {
        nudge(1);
    });

    carousel.addEventListener('mouseenter', pauseCarousel);
    carousel.addEventListener('mouseleave', resumeCarousel);
    carousel.addEventListener('focusin', pauseCarousel);
    carousel.addEventListener('focusout', resumeCarousel);

    startCarousel();
});
</script>

<?php include 'footer.php'; ?>
