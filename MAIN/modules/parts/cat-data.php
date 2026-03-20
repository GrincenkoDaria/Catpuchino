<?php
$adoptableCats = [
    [
        'name' => 'Luna',
        'age' => '2 years',
        'description' => 'Playful and curious, loves windows and soft blankets.',
        'personality' => 'Curious and playful',
        'photo' => 'assets/img/luna.jpg',
    ],
    [
        'name' => 'Milo',
        'age' => '1.5 years',
        'description' => 'Gentle lap cat who purrs at first touch.',
        'personality' => 'Gentle and sleepy',
        'photo' => 'assets/img/milo.jpg',
    ],
    [
        'name' => 'Oliver',
        'age' => '3 years',
        'description' => 'Adventurous explorer who enjoys climbing and treats.',
        'personality' => 'Adventurous',
        'photo' => 'assets/img/oliver.jpg',
    ],
    [
        'name' => 'Willow',
        'age' => '2 years',
        'description' => 'Calm companion who is great with kids and quiet mornings.',
        'personality' => 'Calm and affectionate',
        'photo' => 'assets/img/willow.jpg',
    ],
    [
        'name' => 'Leo',
        'age' => '1 year',
        'description' => 'Energetic and playful, loves laser pointers and tunnels.',
        'personality' => 'Energetic',
        'photo' => 'assets/img/leo.jpg',
    ],
    [
        'name' => 'Sasha',
        'age' => '4 years',
        'description' => 'Friendly paper-reading companion with a comforting purr.',
        'personality' => 'Steady and loving',
        'photo' => 'assets/img/sasha.jpg',
    ],
    [
        'name' => 'Maple',
        'age' => '2 years',
        'description' => 'Bright and social, always ready to play with string toys.',
        'personality' => 'Social and curious',
        'photo' => 'assets/img/maple.jpg',
    ],
    [
        'name' => 'Pepper',
        'age' => '3 years',
        'description' => 'Loves naps in cozy corners and gentle ear scratches.',
        'personality' => 'Chill',
        'photo' => 'assets/img/pepper.jpg',
    ],
    [
        'name' => 'Nico',
        'age' => '1 year',
        'description' => 'Spunky, with a love for feather wands and playful zooms.',
        'personality' => 'Spunky',
        'photo' => 'assets/img/nico.jpg',
    ],
    [
        'name' => 'Mango',
        'age' => '5 years',
        'description' => 'A laid-back and loyal friend who follows you around.',
        'personality' => 'Loyal',
        'photo' => 'assets/img/mango.jpg',
    ],
];

$adoptedCats = [
    [
        'name' => 'Clover',
        'note' => 'Adopted',
    ],
    [
        'name' => 'Biscuit',
        'note' => 'Adopted',
    ],
    [
        'name' => 'Toffee',
        'note' => 'Adopted',
    ],
    [
        'name' => 'Mocha',
        'note' => 'Adopted',
    ],
];

function renderCatCards($cats, $buttonText = 'Adopt me') {
    echo '<div class="cat-cards">';
    foreach ($cats as $cat) {
        echo '<div class="cat-card">';
        echo '<div class="cat-photo-placeholder" role="img" aria-label="Placeholder for ' . htmlspecialchars($cat['name']) . '">' . htmlspecialchars($cat['name']) . ' photo</div>';
        echo '<h3>' . htmlspecialchars($cat['name']) . '</h3>';
        echo '<p class="subtitle">' . htmlspecialchars($cat['personality']) . '</p>';
        echo '<p class="cat-age">Age: ' . htmlspecialchars($cat['age']) . '</p>';
        echo '<p class="cat-description">' . htmlspecialchars($cat['description']) . '</p>';
        echo '<a class="btn-adopt" href="#" aria-label="Adopt ' . htmlspecialchars($cat['name']) . '">' . htmlspecialchars($buttonText) . '</a>';
        echo '</div>';
    }
    echo '</div>';
}

function renderAdoptedCatCards($cats) {
    echo '<div class="cat-cards">';
    foreach ($cats as $cat) {
        echo '<div class="cat-card">';
        echo '<div class="cat-photo-placeholder" role="img" aria-label="Photo placeholder for ' . htmlspecialchars($cat['name']) . '">' . htmlspecialchars($cat['name']) . ' photo</div>';
        echo '<h3>' . htmlspecialchars($cat['name']) . '</h3>';
        echo '<p class="cat-description">' . htmlspecialchars($cat['note']) . '</p>';
        echo '</div>';
    }
    echo '</div>';
}
