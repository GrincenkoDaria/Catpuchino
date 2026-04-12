<!DOCTYPE html>
<html lang="en">
<?php include 'modules/parts/head.php'; ?>
<body>

<?php include 'modules/parts/header.php'; ?>

<main class="menu-main">
    <div class="page-container">
        <?php require_once 'modules/parts/menu-data.php'; ?>

        <section class="menu-section">
            <div class="menu-heading">
                <h1>Drinks</h1>
                <p>Discover café favorites made fresh daily.</p>
            </div>

            <div class="menu-grid">
                <?php renderMenuCards($drinks ?? []); ?>
            </div>
        </section>

        <section class="menu-section">
            <div class="menu-heading">
                <h1>Desserts</h1>
                <p>Sweet treats that pair perfectly with your coffee.</p>
            </div>

            <div class="menu-grid">
                <?php renderMenuCards($desserts ?? []); ?>
            </div>
        </section>
    </div>
</main>

<?php include 'modules/parts/footer.php'; ?>

</body>
</html>