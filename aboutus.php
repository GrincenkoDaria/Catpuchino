<!DOCTYPE html>
<html lang="en">
    <?php include 'modules/parts/head.php'; ?>
<body>
    <?php include 'modules/parts/header.php'; ?>

    <?php
    $storeLatitude = 40.7128;
    $storeLongitude = -74.0060;
    $mapSpan = 0.012;
    $minLongitude = $storeLongitude - $mapSpan;
    $maxLongitude = $storeLongitude + $mapSpan;
    $minLatitude = $storeLatitude - $mapSpan;
    $maxLatitude = $storeLatitude + $mapSpan;
    $mapEmbedUrl = 'https://www.openstreetmap.org/export/embed.html?bbox=' .
        rawurlencode($minLongitude . ',' . $minLatitude . ',' . $maxLongitude . ',' . $maxLatitude) .
        '&layer=mapnik&marker=' . rawurlencode($storeLatitude . ',' . $storeLongitude);
    ?>

    <main class="about-main">
        <section class="about-hero about-band about-band-dark">
            <div class="page-container about-band-content about-hero-content">
                <p class="about-eyebrow">About Catppuccino</p>
                <h1>A cat café built around comfort, community, and second chances.</h1>
                <p>We bring together specialty coffee, a calm café atmosphere, and adoption awareness so every visit supports cats looking for a home.</p>
            </div>
        </section>

        <section class="about-band about-band-light">
            <div class="page-container about-band-content">
                <div class="about-panel-heading">
                    <p class="about-kicker">What We Do</p>
                    <h2>We create a welcoming space for guests and adoptable cats.</h2>
                </div>
                <div class="about-grid">
                    <article class="about-card">
                        <h3>Café Experience</h3>
                        <p>We serve handcrafted drinks and desserts in a relaxed environment designed for cozy visits and meaningful downtime.</p>
                    </article>
                    <article class="about-card">
                        <h3>Adoption Support</h3>
                        <p>Our team works with local shelter partners to introduce guests to adoptable cats and encourage informed, responsible adoptions.</p>
                    </article>
                    <article class="about-card">
                        <h3>Daily Enrichment</h3>
                        <p>Each cat has a structured routine with rest areas, play sessions, and spaces that support safe, low-stress interactions.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="about-band about-band-caramel">
            <div class="page-container about-band-content">
                <div class="about-panel-heading">
                    <p class="about-kicker">Our Supporters</p>
                    <h2>The café runs because a wider community believes in the mission.</h2>
                </div>
                <div class="about-grid supporters-grid">
                    <article class="about-card">
                        <h3>Local Shelters</h3>
                        <p>They help us match cats with guests, coordinate care plans, and keep adoption standards strong.</p>
                    </article>
                    <article class="about-card">
                        <h3>Regular Guests</h3>
                        <p>Every coffee, dessert, and return visit helps fund enrichment supplies, foster transitions, and shelter support.</p>
                    </article>
                    <article class="about-card">
                        <h3>Independent Makers</h3>
                        <p>Merch collaborators, event hosts, and neighborhood partners help us build a stronger cat-loving community.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="about-band about-band-light location-band">
            <div class="page-container about-band-content">
                <div class="about-panel-heading">
                    <p class="about-kicker">Our Location</p>
                    <h2>Find the café and view the store location below.</h2>
                </div>

                <div class="location-summary-card">
                    <h3>Catppuccino Café</h3>
                    <p class="location-coordinates">Coordinates: <?= htmlspecialchars(number_format($storeLatitude, 4)) ?>, <?= htmlspecialchars(number_format($storeLongitude, 4)) ?></p>
                </div>

                <div class="map-frame-wrap">
                    <iframe
                        class="location-map"
                        title="Catppuccino Café location map"
                        src="<?= htmlspecialchars($mapEmbedUrl) ?>"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </div>
        </section>
    </main>

    <?php include 'modules/parts/footer.php'; ?>
</body>
</html>