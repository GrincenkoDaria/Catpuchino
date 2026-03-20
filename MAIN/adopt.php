<!DOCTYPE html>
<html lang="en">
    <?php include 'modules/parts/head.php'; ?>
<body>
    <?php include 'modules/parts/header.php'; ?>

    <?php include 'modules/parts/cat-data.php'; ?>

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