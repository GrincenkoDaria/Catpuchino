<?php
$drinks = [
    [
        'name' => 'Catppuccino Latte',
        'price' => '$4.90',
        'image' => 'assets/img/drinks/menu-latte.jpg',
        'description' => 'Smooth espresso, steamed milk, and a light foam crown.',
    ],
    [
        'name' => 'Matcha Frap',
        'price' => '$5.30',
        'image' => 'assets/img/drinks/menu-matcha.jpg',
        'description' => 'Creamy matcha with milk, a touch of honey, and ice.',
    ],
    [
        'name' => 'Iced Cold Brew',
        'price' => '$4.20',
        'image' => 'assets/img/drinks/menu-coldbrew.jpg',
        'description' => 'Slow-steeped cold brew served over ice with caramel notes.',
    ],
    [
        'name' => 'Vanilla Chai',
        'price' => '$4.70',
        'image' => 'assets/img/drinks/menu-chai.jpg',
        'description' => 'Spiced chai with steamed milk and vanilla aroma.',
    ],
];

$desserts = [
    [
        'name' => 'Chocolate Fudge Cake',
        'price' => '$6.50',
        'image' => 'assets/img/desserts/menu-cake.jpg',
        'description' => 'Rich chocolate layers with creamy ganache.',
    ],
    [
        'name' => 'Berry Tart',
        'price' => '$5.50',
        'image' => 'assets/img/desserts/menu-tart.jpg',
        'description' => 'A crisp crust with fresh berries and custard.',
    ],
    [
        'name' => 'Lavender Macarons',
        'price' => '$4.10',
        'image' => 'assets/img/desserts/menu-macarons.jpg',
        'description' => 'Delicate almond cookies with lavender ganache.',
    ],
    [
        'name' => 'Cinnamon Roll',
        'price' => '$4.80',
        'image' => 'assets/img/desserts/menu-roll.jpg',
        'description' => 'Warm cinnamon swirl topped with cream cheese icing.',
    ],
];

function renderMenuCards($items) {
    foreach ($items as $item) {
        echo '<article class="menu-card">';
        echo '<div class="card-front">';
        echo '<div class="menu-image-frame">';
        echo '<img class="menu-item-image" src="' . htmlspecialchars($item['image']) . '" alt="' . htmlspecialchars($item['name']) . '">';
        echo '</div>';
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
