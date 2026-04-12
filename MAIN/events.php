<!DOCTYPE html>
<html lang="en">
<?php require_once 'modules/parts/head.php'; ?>
<body>

    <?php require_once 'modules/parts/header.php'; ?>

    <main class="events-main">
        <div class="page-container">
            <?php require_once 'modules/parts/events-data.php'; ?>

            <section class="events-section">
                <div class="events-heading">
                    <h1>Upcoming Events</h1>
                </div>
                <div class="events-grid">
                    <?php renderEventCards($upcoming_events ?? []); ?>
                </div>
            </section>

            <section class="events-section">
                <div class="events-heading">
                    <h1>Previous Events</h1>
                </div>
                <div class="events-grid">
                    <?php renderEventCards($previous_events ?? []); ?>
                </div>
            </section>
        </div>
    </main>

    <?php require_once 'modules/parts/footer.php'; ?>

</body>
</html>