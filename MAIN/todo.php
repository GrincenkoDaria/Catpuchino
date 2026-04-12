<!DOCTYPE html>
<html lang="en">
<?php include 'modules/parts/head.php'; ?>
<body>

<?php include 'modules/parts/header.php'; ?>

<main class="todo-main">
    <section class="todo-section page-container section-spacing">
        <p class="todo-kicker">To Be Done</p>
        <h1>This part is not implemented yet.</h1>
        <p class="todo-copy">
            This feature/page still needs to be built. You can update this message in
            <strong>todo.php</strong> anytime.
        </p>

        <?php
        $feature = trim((string)($_GET['feature'] ?? ''));
        if ($feature !== ''):
        ?>
            <p class="todo-feature">Requested feature: <?php echo htmlspecialchars($feature); ?></p>
        <?php endif; ?>

        <div class="todo-actions">
            <a class="todo-btn" href="index.php">Back Home</a>
            <a class="todo-btn todo-btn-secondary" href="javascript:history.back()">Go Back</a>
        </div>
    </section>
</main>

<?php include 'modules/parts/footer.php'; ?>

</body>
</html>
