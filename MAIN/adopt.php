<?php
include 'db.php';

$adoptableCats = [];
$adoptedCats = [];

// берём котов из базы
$result = $conn->query("SELECT * FROM cats");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        if ($row['adopted'] == 0) {
            $adoptableCats[] = $row;
        } else {
            $adoptedCats[] = $row;
        }
    }
}

// функции рендера (как у тебя было, только под БД)
function renderCatCards($cats, $buttonText = 'Adopt me') {
    echo '<div class="cat-cards">';
    foreach ($cats as $cat) {
        echo '<div class="cat-card">';
        echo '<img src="' . htmlspecialchars($cat['photo']) . '" alt="' . htmlspecialchars($cat['name']) . '" class="cat-photo">';
        echo '<h3>' . htmlspecialchars($cat['name']) . '</h3>';
        echo '<p class="subtitle">' . htmlspecialchars($cat['personality']) . '</p>';
        echo '<p class="cat-age">Age: ' . htmlspecialchars($cat['age']) . '</p>';
        echo '<p class="cat-description">' . htmlspecialchars($cat['description']) . '</p>';
        echo '<a class="btn-adopt" href="#">' . htmlspecialchars($buttonText) . '</a>';
        echo '</div>';
    }
    echo '</div>';
}

function renderAdoptedCatCards($cats) {
    echo '<div class="cat-cards">';
    foreach ($cats as $cat) {
        echo '<div class="cat-card">';
        echo '<img src="' . htmlspecialchars($cat['photo']) . '" alt="' . htmlspecialchars($cat['name']) . '" class="cat-photo">';
        echo '<h3>' . htmlspecialchars($cat['name']) . '</h3>';
        echo '<p class="cat-description">Adopted</p>';
        echo '</div>';
    }
    echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'modules/parts/head.php'; ?>
<body>

<?php include 'modules/parts/header.php'; ?>

<main>
    <section class="adopt-hero">
        <div class="adopt-hero-content page-container">
            <p class="eyebrow">Shelter Partnership</p>
            <h1>Want to adopt a cat?</h1>
            <p>We work with a local animal shelter to bring adoptable cats to Catppuccino Café. Meet our cats, learn their personalities, and find the right companion.</p>
        </div>
    </section>

    <section id="cats" class="cats-section page-container section-spacing">
        <h2>Adoptable Cats</h2>
        <?php renderCatCards($adoptableCats, 'Learn more'); ?>
    </section>

    <section class="cats-section page-container section-spacing adopted-cats-section">
        <h2>Adopted Cats</h2>
        <?php renderAdoptedCatCards($adoptedCats); ?>
    </section>
</main>

<?php include 'modules/parts/footer.php'; ?>

</body>
</html>