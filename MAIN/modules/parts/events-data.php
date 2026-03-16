<?php
$upcoming_events = [
    [
        'title' => 'Cat Yoga Evening',
        'date' => 'May 18, 2026',
        'description' => 'Relaxing yoga session with our café cats in a calm candlelit setup.',
        'image' => 'assets/img/events/cat-yoga.jpg',
        'link' => 'event-cat-yoga.php',
    ],
    [
        'title' => 'Latte Art & Purrs',
        'date' => 'June 02, 2026',
        'description' => 'Hands-on latte art workshop while spending time with our adoptable cats.',
        'image' => 'assets/img/events/latte-art.jpg',
        'link' => 'event-latte-art.php',
    ],
    [
        'title' => 'Shelter Support Night',
        'date' => 'June 21, 2026',
        'description' => 'Fundraising evening with themed drinks and stories from our shelter partner.',
        'image' => 'assets/img/events/shelter-night.jpg',
        'link' => 'event-shelter-support.php',
    ],
];

$previous_events = [
    [
        'title' => 'Kitten Adoption Day',
        'date' => 'March 10, 2026',
        'description' => 'Special adoption day that helped several kittens find their forever homes.',
        'image' => 'assets/img/events/adoption-day.jpg',
        'link' => 'event-adoption-day.php',
    ],
    [
        'title' => 'Paint with Cats',
        'date' => 'February 14, 2026',
        'description' => 'Creative evening of painting, coffee, and playful cat companions.',
        'image' => 'assets/img/events/paint-with-cats.jpg',
        'link' => 'event-paint-with-cats.php',
    ],
    [
        'title' => 'Holiday Cat Market',
        'date' => 'December 20, 2025',
        'description' => 'Seasonal market featuring local makers, desserts, and cat-themed gifts.',
        'image' => 'assets/img/events/holiday-market.jpg',
        'link' => 'event-holiday-market.php',
    ],
];

function renderEventCards($events)
{
    foreach ($events as $event) {
        echo '<article class="event-card">';
        echo '<div class="event-image-frame">';
        echo '<img class="event-image" src="' . htmlspecialchars($event['image']) . '" alt="' . htmlspecialchars($event['title']) . '">';
        echo '</div>';
        echo '<div class="event-card-body">';
        echo '<p class="event-date">' . htmlspecialchars($event['date']) . '</p>';
        echo '<h3 class="event-title">' . htmlspecialchars($event['title']) . '</h3>';
        echo '<p class="event-description">' . htmlspecialchars($event['description']) . '</p>';
        echo '<a class="event-arrow-btn" href="' . htmlspecialchars($event['link']) . '" aria-label="Open ' . htmlspecialchars($event['title']) . '">';
        echo '<span aria-hidden="true">→</span>';
        echo '</a>';
        echo '</div>';
        echo '</article>';
    }
}
