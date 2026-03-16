<!DOCTYPE html>
<html lang="en">
    <?php include 'modules/parts/head.php'; ?>
<body>
    <?php include 'modules/parts/header.php'; ?>

    <main>
        <section class="adopt-hero">
            <div class="adopt-hero-content">
                <p class="eyebrow">Shelter Partnership</p>
                <h1>Want to adopt a cat?</h1>
                <p>We work with a local animal shelter to bring adoptable cats to Catppuccino Café. Meet our cats, learn their personalities, and find the right companion.</p>
            </div>
        </section>

        <section id="cats" class="cats-section">
            <h2>Adoptable Cats</h2>
            <?php include 'modules/parts/cat-data.php'; renderCatCards($adoptableCats, 'Learn more'); ?>
        </section>
    </main>

    <?php include 'modules/parts/footer.php'; ?>
</body>
</html>