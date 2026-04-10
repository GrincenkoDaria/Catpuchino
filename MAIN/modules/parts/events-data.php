<?php
include_once __DIR__ . '/../../db.php';

$upcoming_events = [];
$previous_events = [];

function renderEventCards(array $events): void
{
    if (empty($events)) {
        echo '<p>No events available right now.</p>';
        return;
    }

    foreach ($events as $event) {
        echo '<article class="event-card">';
        echo '<div class="event-image-frame">';
        echo '<img class="event-image" src="' . htmlspecialchars($event['image']) . '" alt="' . htmlspecialchars($event['title']) . '">';
        echo '</div>';
        echo '<div class="event-card-body">';
        echo '<p class="event-date">' . htmlspecialchars($event['formatted_date']) . '</p>';
        echo '<h3 class="event-title">' . htmlspecialchars($event['title']) . '</h3>';
        echo '<p class="event-description">' . htmlspecialchars($event['description']) . '</p>';
        echo '<a class="event-arrow-btn" href="' . htmlspecialchars($event['link']) . '" aria-label="Open ' . htmlspecialchars($event['title']) . '">';
        echo '<span aria-hidden="true">→</span>';
        echo '</a>';
        echo '</div>';
        echo '</article>';
    }
}

$sql = "SELECT id, title, event_date, description, image, link FROM events ORDER BY event_date ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $today = date('Y-m-d');

    while ($row = $result->fetch_assoc()) {
        $event = [
            'title' => $row['title'],
            'date' => $row['event_date'],
            'formatted_date' => date('F d, Y', strtotime($row['event_date'])),
            'description' => $row['description'],
            'image' => $row['image'],
            'link' => $row['link'],
        ];

        if ($row['event_date'] >= $today) {
            $upcoming_events[] = $event;
        } else {
            $previous_events[] = $event;
        }
    }

    $previous_events = array_reverse($previous_events);
}
?>