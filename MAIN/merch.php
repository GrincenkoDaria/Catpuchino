<?php
require_once 'db.php';

$merchItems = [];
$result = $conn->query("
    SELECT id, name, price, image, description, stock
    FROM products
");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $merchItems[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'modules/parts/head.php'; ?>
<body>

<?php include 'modules/parts/header.php'; ?>

<main class="merch-main">
    <div class="page-container">
        <section class="merch-section">
            <h1 class="merch-title">Merchandise</h1>

            <div class="merch-grid">
                <?php foreach ($merchItems as $item): ?>
                    <article class="merch-card">
                        <img
                            class="merch-image"
                            src="<?= htmlspecialchars($item['image']) ?>"
                            loading="lazy"
                            decoding="async"
                            alt="<?= htmlspecialchars($item['name']) ?>"
                        >

                        <div class="merch-content">
                            <h3 class="merch-name"><?= htmlspecialchars($item['name']) ?></h3>
                            <p class="merch-description"><?= htmlspecialchars($item['description']) ?></p>

                            <div class="merch-row">
                                <span class="merch-price"><?= htmlspecialchars($item['price']) ?>€</span>

                                <button
                                    class="add-cart-btn"
                                    type="button"
                                    data-id="<?= (int) $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['name']) ?>"
                                    data-price="<?= htmlspecialchars($item['price']) ?>"
                                    data-stock="<?= (int) $item['stock'] ?>"
                                >
                                    Add to Cart
                                </button>
                            </div>

                            <p class="stock-text">
                                <?php if ((int) $item['stock'] > 0): ?>
                                    In stock:
                                    <span class="stock-value"><?= (int) $item['stock'] ?></span>
                                <?php else: ?>
                                    <span class="stock-value stock-value-out">Out of stock</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<button id="cart-fab" class="cart-fab">
    <span class="cart-fab-icon" aria-hidden="true"></span>
    <span id="cart-count" class="cart-count">0</span>
</button>

<aside id="cart-panel" class="cart-panel">
    <div class="cart-header">Your Cart</div>

    <ul id="cart-items" class="cart-items">
        <li class="cart-empty">Your cart is empty.</li>
    </ul>

    <div class="cart-footer">
        <p class="cart-total">Total: <span id="cart-total">0.00€</span></p>

        <form method="POST" action="checkout.php">
            <input type="hidden" name="order_data" id="order_data">
            <button type="submit" name="order">Order</button>
        </form>
    </div>
</aside>

<?php include 'modules/parts/footer.php'; ?>

<div id="sad-modal" class="sad-modal">
    <div class="sad-modal-content">
        <h2>Sorry <span class="sorry-icon" aria-hidden="true"></span></h2>
        <p>This item is out of stock.</p>
        <button id="close-sad">OK</button>
    </div>
</div>

<script src="assets/js/merch.min.js" defer></script>

</body>
</html>