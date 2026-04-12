<?php
include_once __DIR__ . '/../cat-data.php';
include_once __DIR__ . '/../menu-data.php';
include_once __DIR__ . '/../events-data.php';
include_once __DIR__ . '/../merch-data.php';

function pickRandomItems(array $items, int $count = 3): array
{
    if (empty($items)) {
        return [];
    }

    $selection = $items;
    shuffle($selection);
    return array_slice($selection, 0, min($count, count($selection)));
}

function renderPreviewMedia(string $label): void
{
    echo '<div class="preview-card-media" aria-hidden="true">' . htmlspecialchars($label) . '</div>';
}

function renderHomePreviewSection(string $title, array $cards, string $buttonHref, string $buttonLabel = 'View More', string $sectionClass = ''): void
{
    $sectionClasses = trim('home-preview-section section-spacing ' . $sectionClass);

    echo '<section class="' . htmlspecialchars($sectionClasses) . '">';
    echo '<div class="home-preview-section-header">';
    echo '<h2>' . htmlspecialchars($title) . '</h2>';
    echo '</div>';
    echo '<div class="home-preview-grid">';

    foreach ($cards as $card) {
        echo '<article class="home-preview-card">';
        renderPreviewMedia($card['mediaLabel']);
        echo '<div class="home-preview-card-body">';
        echo '<h3>' . htmlspecialchars($card['title']) . '</h3>';
        echo '<p>' . htmlspecialchars($card['description']) . '</p>';
        echo '</div>';
        echo '</article>';
    }

    echo '</div>';
    echo '<div class="home-preview-section-footer">';
    echo '<a class="home-preview-button" href="' . htmlspecialchars($buttonHref) . '">' . htmlspecialchars($buttonLabel) . '</a>';
    echo '</div>';
    echo '</section>';
}

function renderHomeFeaturedCatsSection(array $cats, string $buttonHref): void
{
    echo '<section class="home-preview-section home-preview-section-featured section-spacing">';
    echo '<div class="home-preview-section-header">';
    echo '<h2>Featured Cats</h2>';
    echo '</div>';
    echo '<div class="home-featured-cats-row">';

    foreach ($cats as $cat) {
        echo '<article class="featured-cat-profile">';
        echo '<div class="featured-cat-avatar-wrap">';
        echo '<img class="featured-cat-avatar" src="assets/img/mini/' . htmlspecialchars($cat['photo']) . '" alt="' . htmlspecialchars($cat['name']) . '" loading="lazy" decoding="async">';
        echo '</div>';
        echo '<h3>' . htmlspecialchars($cat['name']) . '</h3>';
        echo '<p class="featured-cat-age">' . htmlspecialchars($cat['age']) . '</p>';

        echo '</article>';
    }

    echo '</div>';
    echo '<div class="home-preview-section-footer">';
    echo '<a class="home-preview-button" href="' . htmlspecialchars($buttonHref) . '">View More</a>';
    echo '</div>';
    echo '</section>';
}
function renderHomeMenuPreviewSection(array $items, string $buttonHref): void
{
    echo '<section class="home-preview-section home-preview-section-menu section-spacing">';
    echo '<div class="home-preview-section-header">';
    echo '<h2>Menu</h2>';
    echo '</div>';
    echo '<div class="home-menu-preview-row">';

    foreach ($items as $item) {
        echo '<article class="home-menu-preview-card">';
        echo '<div class="home-menu-preview-image-wrap">';
        echo '<img class="home-menu-preview-image" src="' . htmlspecialchars($item['image']) . '" alt="' . htmlspecialchars($item['name']) . '" loading="lazy" decoding="async">';
        echo '</div>';
        echo '<div class="home-menu-preview-body">';
        echo '<h3>' . htmlspecialchars($item['name']) . '</h3>';
        echo '<p class="home-menu-preview-price">' . htmlspecialchars($item['price']) . '</p>';
        echo '</div>';
        echo '</article>';
    }

    echo '</div>';
    echo '<div class="home-preview-section-footer">';
    echo '<a class="home-preview-button" href="' . htmlspecialchars($buttonHref) . '">View More</a>';
    echo '</div>';
    echo '</section>';
}

function renderHomeMerchStripSection(array $items, string $buttonHref): void
{
    echo '<section class="home-preview-section home-preview-section-merch section-spacing">';
    echo '<div class="home-preview-section-header">';
    echo '<h2>Merch</h2>';
    echo '</div>';
    echo '<div class="home-merch-scroll" aria-label="Merch photo preview">';

    foreach ($items as $item) {
        echo '<article class="home-merch-photo-item">';
        echo '<img class="home-merch-photo" src="' . htmlspecialchars($item['image']) . '" alt="' . htmlspecialchars($item['name']) . '" loading="lazy" decoding="async">';
        echo '<h3>' . htmlspecialchars($item['name']) . '</h3>';
        echo '<p>' . htmlspecialchars($item['price']) . '</p>';
        echo '</article>';
    }

    echo '</div>';
    echo '<div class="home-preview-section-footer">';
    echo '<a class="home-preview-button" href="' . htmlspecialchars($buttonHref) . '">View More</a>';
    echo '</div>';
    echo '</section>';
}

function renderHomeEventsImageSection(array $events, string $buttonHref): void
{
    echo '<section class="home-preview-section home-preview-section-events-image section-spacing">';
    echo '<div class="home-preview-section-header">';
    echo '<h2>Events</h2>';
    echo '</div>';
    echo '<div class="home-events-image-row">';

    foreach ($events as $event) {
        echo '<article class="home-event-image-card">';
        echo '<img class="home-event-image" src="' . htmlspecialchars($event['image']) . '" alt="' . htmlspecialchars($event['title']) . '" loading="lazy" decoding="async">';
        echo '</article>';
    }

    echo '</div>';
    echo '<div class="home-preview-section-footer">';
    echo '<a class="home-preview-button" href="' . htmlspecialchars($buttonHref) . '">View More</a>';
    echo '</div>';
    echo '</section>';
}

function renderHomeAboutLocationSection(string $buttonHref, string $mapEmbedUrl, float $latitude, float $longitude): void
{
    echo '<section class="home-preview-section home-preview-about-location section-spacing">';
    echo '<div class="home-preview-section-header">';
    echo '<h2>About Us</h2>';
    echo '<p class="home-preview-location-kicker">Our Location</p>';
    echo '</div>';
    echo '<div class="home-preview-location-wrap">';
    echo '<p class="home-preview-location-coordinates">Coordinates: ' . htmlspecialchars(number_format($latitude, 4)) . ', ' . htmlspecialchars(number_format($longitude, 4)) . '</p>';
    echo '<iframe class="home-preview-location-map" title="Catppuccino Café location preview map" src="' . htmlspecialchars($mapEmbedUrl) . '" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
    echo '</div>';
    echo '<div class="home-preview-section-footer">';
    echo '<a class="home-preview-button" href="' . htmlspecialchars($buttonHref) . '">View More</a>';
    echo '</div>';
    echo '</section>';
}

$allMenuItems = array_merge($drinks ?? [], $desserts ?? []);
$menuPreviewItems = pickRandomItems($allMenuItems, 3);

$eventsPreviewCards = pickRandomItems($upcoming_events ?? []);
$featuredCats = pickRandomItems($adoptableCats ?? []);
$merchPreviewItems = pickRandomItems($merch_items ?? [], 6);

$storeLatitude = 40.7128;
$storeLongitude = -74.0060;
$mapSpan = 0.012;
$minLongitude = $storeLongitude - $mapSpan;
$maxLongitude = $storeLongitude + $mapSpan;
$minLatitude = $storeLatitude - $mapSpan;
$maxLatitude = $storeLatitude + $mapSpan;

$aboutMapEmbedUrl = 'https://www.openstreetmap.org/export/embed.html?bbox=' .
    rawurlencode($minLongitude . ',' . $minLatitude . ',' . $maxLongitude . ',' . $maxLatitude) .
    '&layer=mapnik&marker=' . rawurlencode($storeLatitude . ',' . $storeLongitude);

renderHomeFeaturedCatsSection($featuredCats, 'adopt.php');
renderHomeMenuPreviewSection($menuPreviewItems, 'menu.php');
renderHomeEventsImageSection($eventsPreviewCards, 'events.php');
renderHomeMerchStripSection($merchPreviewItems, 'merch.php');
renderHomeAboutLocationSection('aboutus.php', $aboutMapEmbedUrl, $storeLatitude, $storeLongitude);
?>