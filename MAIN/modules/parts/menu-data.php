<?php
include_once __DIR__ . '/../../db.php';

$drinks = [];
$desserts = [];

function renderMenuCards(array $items): void
{
    if (empty($items)) {
        echo '<p>No items available right now.</p>';
        return;
    }

    foreach ($items as $item) {
        echo '<article class="menu-card">';

        echo '<div class="card-front">';

        if (!empty($item['image'])) {
            echo '<div class="menu-image-frame">';
            echo '<img class="menu-item-image" src="' . htmlspecialchars($item['image']) . '" alt="' . htmlspecialchars($item['name']) . '" loading="lazy" decoding="async">';
            echo '</div>';
        } else {
            echo '<div class="menu-image-placeholder">No Image</div>';
        }

        echo '<div class="menu-card-body">';
        echo '<h3 class="item-name">' . htmlspecialchars($item['name']) . '</h3>';
        echo '<p class="menu-price">' . htmlspecialchars($item['price']) . '</p>';
        echo '</div>';

        echo '</div>';

        echo '<div class="card-description">';
        echo '<p>' . htmlspecialchars($item['description']) . '</p>';
        echo '</div>';

        echo '</article>';
    }
}

$sql = "SELECT name, description, price, image, category FROM menu_items ORDER BY id ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $item = [
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => number_format((float)$row['price'], 2) . '€',
            'image' => $row['image'] ?? '',
        ];

        if ($row['category'] === 'drink') {
            $drinks[] = $item;
        } elseif ($row['category'] === 'dessert') {
            $desserts[] = $item;
        }
    }
}
?>