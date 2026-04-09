<?php
include 'db.php';

if (isset($_POST['order'])) {
    $data = json_decode($_POST['order_data'], true);

    if ($data) {
        foreach ($data as $item) {
            $id = (int)$item['id'];
            $qty = (int)$item['qty'];

            $conn->query("UPDATE products SET stock = stock - $qty WHERE id=$id AND stock >= $qty");
        }
    }

    header("Location: merch.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'modules/parts/head.php'; ?>
<body>

<?php include 'modules/parts/header.php'; ?>

<main class="merch-main">
    <div class="page-container">
        <?php
        $result = $conn->query("SELECT * FROM products");
        $merch_items = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $merch_items[] = $row;
            }
        }
        ?>

        <section class="merch-section">
            <h1 class="merch-title">Merchandise</h1>

            <div class="merch-grid">
                <?php foreach ($merch_items as $item): ?>
                    <article class="merch-card">
                        <img class="merch-image"
                             src="<?= htmlspecialchars($item['image']) ?>"
                             alt="<?= htmlspecialchars($item['name']) ?>">

                        <div class="merch-content">
                            <h3 class="merch-name"><?= htmlspecialchars($item['name']) ?></h3>
                            <p class="merch-description"><?= htmlspecialchars($item['description']) ?></p>

                            <div class="merch-row">
                                <span class="merch-price"><?= htmlspecialchars($item['price']) ?>€</span>

                                <button
                                    class="add-cart-btn"
                                    type="button"
                                    data-id="<?= $item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['name']) ?>"
                                    data-price="<?= $item['price'] ?>"
                                    data-stock="<?= $item['stock'] ?>"
                                >
                                    Add to Cart
                                </button>
                            </div>

                            <p class="stock-text">
                                <?php if ((int)$item['stock'] > 0): ?>
                                    In stock:
                                    <span class="stock-value"><?= $item['stock'] ?></span>
                                <?php else: ?>
                                    <span class="stock-value" style="color:#BD0E0E;">
                                        Out of stock
                                    </span>
                                <?php endif; ?>
                            </p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<button id="cart-fab" class="cart-fab">🛒
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
        <h2>Prepáčte 😿</h2>
        <p>Tento tovar nie je na sklade.</p>
        <button id="close-sad">OK</button>
    </div>
</div>

<script>
(function () {

    var cart = {};

    var sadModal = document.getElementById('sad-modal');
    var closeSad = document.getElementById('close-sad');

    function showSadCat() {
        sadModal.classList.add('show');
    }

    closeSad.addEventListener('click', function () {
        sadModal.classList.remove('show');
    });

    var cartFab = document.getElementById('cart-fab');
    var cartPanel = document.getElementById('cart-panel');
    var cartCount = document.getElementById('cart-count');
    var cartItems = document.getElementById('cart-items');
    var cartTotal = document.getElementById('cart-total');
    var addButtons = document.querySelectorAll('.add-cart-btn');

    function parsePrice(value) {
        return parseFloat(value) || 0;
    }

    function formatPrice(value) {
        return value.toFixed(2) + '€';
    }

    function getTotalCost() {
        var total = 0;
        Object.values(cart).forEach(function (item) {
            total += item.price * item.qty;
        });
        return total;
    }

    function animateFlyToCart(fromElement) {
        if (!fromElement || !cartFab) return;

        var fromRect = fromElement.getBoundingClientRect();
        var toRect = cartFab.getBoundingClientRect();

        var dot = document.createElement('span');
        dot.className = 'cart-fly-dot';

        dot.style.left = (fromRect.left + fromRect.width / 2) + 'px';
        dot.style.top = (fromRect.top + fromRect.height / 2) + 'px';

        dot.style.setProperty('--fly-x',
            (toRect.left - fromRect.left) + 'px');
        dot.style.setProperty('--fly-y',
            (toRect.top - fromRect.top) + 'px');

        document.body.appendChild(dot);

        requestAnimationFrame(function () {
            dot.classList.add('animate');
        });

        setTimeout(function () {
            dot.remove();
        }, 1400);
    }

    function renderCart() {
    cartItems.innerHTML = '';

    var keys = Object.keys(cart);

    if (!keys.length) {
        cartItems.innerHTML =
            '<li class="cart-empty">Your cart is empty.</li>';
        cartCount.textContent = '0';
        cartTotal.textContent = formatPrice(0);
        return;
    }

    keys.forEach(function (key) {
        var item = cart[key];

        var li = document.createElement('li');
        li.className = 'cart-item';

        var name = document.createElement('span');
        name.textContent = item.name + ' x' + item.qty;

        var remove = document.createElement('button');
        remove.textContent = '✕';
        remove.className = 'remove-btn';

        remove.addEventListener('click', function () {
            delete cart[key];
            renderCart();
        });

        li.appendChild(name);
        li.appendChild(remove);

        cartItems.appendChild(li);
    });

    cartCount.textContent = keys.length;
    cartTotal.textContent = formatPrice(getTotalCost());
}

    addButtons.forEach(function (button) {
        button.addEventListener('click', function () {

            var stock = parseInt(button.dataset.stock);

            if (stock <= 0) {
                showSadCat();
                return;
            }

            var id = button.dataset.id;

            if (!cart[id]) {
                cart[id] = {
                    id: id,
                    name: button.dataset.name,
                    price: parsePrice(button.dataset.price),
                    qty: 0
                };
            }

            cart[id].qty++;

            renderCart();
            animateFlyToCart(button);
        });
    });

    document.querySelector('[name="order"]').addEventListener('click', function (e) {

        if (getTotalCost() <= 0) {
            e.preventDefault();
            return;
        }

        document.getElementById('order_data').value =
            JSON.stringify(cart);
    });

    cartFab.addEventListener('click', function () {
        cartPanel.classList.toggle('open');
    });

    renderCart();

})();
</script>

</body>
</html>