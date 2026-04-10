<?php include_once __DIR__ . '/../cat-data.php'; ?>

<section class="featured-cats-home page-container section-spacing">
    <div class="featured-cats-home-header">
        <div>
            <h2>Featured Cats</h2>
            <p>Meet just a few of our playful café cats before you head to the full adoption list.</p>
        </div>
        <a class="btn-view-all" href="adopt.php">View all cats</a>
    </div>

    <?php
    $catsToShow = $adoptableCats;
    shuffle($catsToShow);
    $catsToShow = array_slice($catsToShow, 0, 3);
    ?>

    <div class="featured-cats-track" aria-label="Featured cats">
        <?php foreach ($catsToShow as $cat): ?>
            <article class="featured-cat-item">
                <div class="featured-cat-avatar-wrap">
                    <img
    class="featured-cat-avatar"
    src="assets/img/mini/<?= htmlspecialchars($cat['photo']) ?>"
    alt="<?= htmlspecialchars($cat['name']) ?>"
>
                </div>
                <h3><?= htmlspecialchars($cat['name']) ?></h3>
                <p class="cat-age"><?= htmlspecialchars($cat['age']) ?></p>
                <p class="cat-brief"><?= htmlspecialchars($cat['description']) ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>