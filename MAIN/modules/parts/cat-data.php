<?php
include_once __DIR__ . '/../../db.php';

$adoptableCats = [];
$adoptedCats = [];

$sql = "SELECT * FROM cats";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        if ((int)$row['adopted'] === 0) {
            $adoptableCats[] = [
                'name' => $row['name'],
                'age' => $row['age'],
                'description' => $row['description'],
                'personality' => $row['personality'],
                'photo' => $row['photo']
            ];
        } else {
            $adoptedCats[] = [
                'name' => $row['name'],
                'photo' => $row['photo'],
                'note' => 'Adopted'
            ];
        }
    }
}

function renderCatCards($cats, $buttonText = 'Adopt me', $imagePath = 'assets/img/')
{
    echo '<div class="cat-cards">';

    foreach ($cats as $cat) {
        echo '<div class="cat-card">';
        echo '<img src="' . htmlspecialchars($imagePath . $cat['photo']) . '" alt="' . htmlspecialchars($cat['name']) . '" class="cat-photo" loading="lazy" decoding="async">';
        echo '<h3>' . htmlspecialchars($cat['name']) . '</h3>';
        echo '<p class="subtitle">' . htmlspecialchars($cat['personality']) . '</p>';
        echo '<p class="cat-age">Age: ' . htmlspecialchars($cat['age']) . '</p>';
        echo '<p class="cat-description">' . htmlspecialchars($cat['description']) . '</p>';
        echo '<a class="btn-adopt" href="todo.php?feature=adopt-cat" aria-label="Adopt ' . htmlspecialchars($cat['name']) . '">' . htmlspecialchars($buttonText) . '</a>';
        echo '</div>';
    }

    echo '</div>';
}

function renderAdoptedCatCards($cats, $imagePath = 'assets/img/')
{
    echo '<div class="cat-cards">';

    foreach ($cats as $cat) {
        echo '<div class="cat-card">';
        echo '<img src="' . htmlspecialchars($imagePath . $cat['photo']) . '" alt="' . htmlspecialchars($cat['name']) . '" class="cat-photo" loading="lazy" decoding="async">';
        echo '<h3>' . htmlspecialchars($cat['name']) . '</h3>';
        echo '<p class="cat-description">' . htmlspecialchars($cat['note']) . '</p>';
        echo '</div>';
    }

    echo '</div>';
}
?>