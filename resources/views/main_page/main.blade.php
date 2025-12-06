@extends('entry')
@section('content')
<body>


    <section class="hero" id="home">
        <div class="hero-bg"></div>
        <div class="hero-container">
            <div class="hero-left">
                <div class="hero-badge">New Collection 2025</div>
                <h1 class="hero-title">
                    <span class="line"><span>Learn</span></span>
                    <span class="line"><span>Way <span class="accent">New</span></span></span>
                    <span class="line"><span>Opportunity</span></span>
                </h1>
                <p class="hero-description">
                    Discover the way brilliant mind learn and archive there live.
                    Each piece tells a story of win, lost, and innovation.
                </p>
                <div class="hero-stats">
                    <div class="stat">
                        <span class="stat-number">30+</span>
                        <span class="stat-label">Inclusive Courses</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">12H</span>
                        <span class="stat-label">Easy to Find</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">100%</span>
                        <span class="stat-label">Sustainable</span>
                    </div>
                </div>
                <div class="cta-group">
                    <a href="#collections" class="cta-button primary">Explore Courses</a>
                    <a href="#featured" class="cta-button outline">Watch Runway</a>
                </div>
            </div>
            <div class="hero-right">
                <div class="hero-image-wrapper">
                    <div class="hero-carousel">
                        <div class="carousel-slide active">
                            <img src="images/noir-fashion-hero-01.avif" alt="Fashion Model 1">
                        </div>
                        <div class="carousel-slide">
                            <img src="images/noir-fashion-hero-02.avif" alt="Fashion Model 2">
                        </div>
                        <div class="carousel-slide">
                            <img src="images/noir-fashion-hero-03.avif" alt="Fashion Model 3">
                        </div>
                        <div class="carousel-overlay"></div>
                        <div class="carousel-indicators">
                            <span class="indicator active" data-slide="0"></span>
                            <span class="indicator" data-slide="1"></span>
                            <span class="indicator" data-slide="2"></span>
                        </div>
                    </div>
                    <div class="floating-tags">
                        <div class="tag">Limited Edition</div>
                        <div class="tag">Handcrafted</div>
                        <div class="tag">Premium Quality</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <span></span>
        </div>
    </section>

    <section class="collections" id="collections">
        <div class="section-header">
            <h2 class="section-title">Latest Courses</h2>
            <p class="section-subtitle">Discover our newest selection</p>
        </div>


        <div class="grid" id="collectionsGrid">
            <div class="collection-card">
                <div class="collection-thumbnail">
                    <img src="images/urban-edge.avif" alt="Urban Edge Women's Collection">
                </div>
                <div class="card-content">
                    <span class="card-badge">New Arrival</span>
                    <h3 class="card-title">Urban Edge</h3>
                    <p class="card-subtitle">Women's Collection</p>
                    <p class="card-price">From $299</p>
                </div>
            </div>

        </div>
    </section>

    <section class="featured" id="featured">
        <div class="featured-container">
            <div class="featured-hero">
                <div class="featured-content">
                    <span class="label">Crafted with Passion</span>
                    <h2>The Art of Learning</h2>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Incidunt aperiam quo dolorum facilis eaque alias neque, reprehenderit, natus ex recusandae tempore minima consequuntur porro hic blanditiis facere amet beatae a.
                        Soluta eum at aperiam, cum dicta consectetur. Deserunt velit modi sit unde blanditiis cumque repellat necessitatibus aspernatur minus! Deserunt unde, cumque consectetur veniam laboriosam eligendi? Quasi cumque incidunt dolorem soluta.
                        Dolorum cupiditate dolorem provident numquam sit praesentium ex, impedit aspernatur facilis cumque! Sed, eaque. Iure ex voluptatibus eligendi iusto, esse porro voluptas id nisi obcaecati vero? Cupiditate minima voluptatibus distinctio.
                        Animi exercitationem eos maiores aperiam, dignissimos blanditiis ratione architecto quam perferendis quia itaque nesciunt aliquam. Ex autem doloremque aliquam a voluptates minima veritatis, placeat dignissimos, dolores ullam cumque cum illo?
                        Sequi iure, excepturi, ullam culpa nostrum maxime provident quaerat, possimus enim voluptates tenetur beatae! Obcaecati sunt quam nostrum quod mollitia eaque placeat ad excepturi eveniet? Impedit rem repudiandae vel delectus..</p>


                    <a href="#collections" class="feature-cta">Discover Our Craft</a>
                </div>

                <div class="featured-image-section">
                    <div class="featured-image-grid">
                        <div class="featured-img">
                            <img src="images/art-of-fashion-01.avif" alt="Fashion Collection Showcase">
                        </div>
                        <div class="featured-img">
                            <img src="images/art-of-fashion-02.avif" alt="Luxury Fashion Details">
                        </div>
                        <div class="featured-img">
                            <img src="images/art-of-fashion-03.avif" alt="Artisan Craftsmanship">
                        </div>
                    </div>
                </div>
            </div>

            <div class="testimonials">
                <div class="testimonials-header">
                    <h3>What Our Customers Say</h3>
                    <p class="section-subtitle">Real stories from fashion enthusiasts</p>
                </div>

                <div class="testimonials-grid">
                    <div class="testimonial-card">
                        <div class="testimonial-rating">★★★★★</div>
                        <div class="testimonial-quote">
                            "NOIR has completely transformed my wardrobe. The quality and attention to detail is unmatched. Every piece feels like a work of art."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">S</div>
                            <div class="author-info">
                                <h4>Sarah Chen</h4>
                                <p>Fashion Blogger</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-rating">★★★★★</div>
                        <div class="testimonial-quote">
                            "The sustainable approach combined with luxury design is exactly what I was looking for. NOIR proves you don't have to compromise."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">M</div>
                            <div class="author-info">
                                <h4>Marcus Rodriguez</h4>
                                <p>Creative Director</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card">
                        <div class="testimonial-rating">★★★★★</div>
                        <div class="testimonial-quote">
                            "I've been a customer for three years now, and each collection keeps exceeding my expectations. The fit and quality are consistently outstanding."
                        </div>
                        <div class="testimonial-author">
                            <div class="author-avatar">A</div>
                            <div class="author-info">
                                <h4>Alexandra Kim</h4>
                                <p>Entrepreneur</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact" id="contact">
        <div class="contact-container">
            <div class="contact-header">
                <h2 class="section-title">Get In Touch</h2>
                <p class="section-subtitle">We'd love to hear from you</p>
            </div>

            <div class="contact-content">
                <div class="contact-form-wrapper">
                    <form id="contactForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" id="firstName" name="firstName" placeholder="John" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="lastName" placeholder="Doe" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="john@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" placeholder="How can we help?" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" placeholder="Tell us more about your inquiry..." required></textarea>
                        </div>
                        <button type="submit" class="form-submit">Send Message</button>
                    </form>
                </div>

                <div class="contact-info">
                    <div class="info-item">
                        <div class="info-icon">📍</div>
                        <div class="info-content">
                            <h3>Visit Our Flagship Store</h3>
                            <p>123 Fashion Avenue<br>
                                Bangkok, Thailand 10110<br>
                                Siam District</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📞</div>
                        <div class="info-content">
                            <h3>Call Us</h3>
                            <p>Main: <a href="tel:+66021234567">+66 02 123 4567</a><br>
                                Support: <a href="tel:+66021234568">+66 02 123 4568</a><br>
                                Mon-Fri, 9AM-6PM ICT</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">✉️</div>
                        <div class="info-content">
                            <h3>Email Us</h3>
                            <p>General: <a href="mailto:hello@noir.fashion">hello@noir.fashion</a><br>
                                Support: <a href="mailto:support@noir.fashion">support@noir.fashion</a><br>
                                Press: <a href="mailto:press@noir.fashion">press@noir.fashion</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map-section">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3875.551370220076!2d100.53515!3d13.730314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2993fa2f8c6d9%3A0x92cf0e47c4c2ed08!2sSilom%20MRT%20Station!5e0!3m2!1sen!2sth!4v1697000000000" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
        </div>
    </section>



    <script src="templatemo-noir-scripts.js"></script>
</body>
@endsection