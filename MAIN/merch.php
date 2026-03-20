<!DOCTYPE html>
<html lang="en">
    <?php include 'modules/parts/head.php'; ?>
<body>
    <?php include 'modules/parts/header.php'; ?>

    <main class="merch-main">
        <div class="page-container">
            <?php include 'modules/parts/merch-data.php'; ?>

            <section class="merch-section">
                <h1 class="merch-title">Merchandise</h1>
                <div class="merch-grid">
                    <?php foreach ($merch_items as $item): ?>
                        <article class="merch-card">
                            <img class="merch-image" src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                            <div class="merch-content">
                                <h3 class="merch-name"><?= htmlspecialchars($item['name']) ?></h3>
                                <p class="merch-description"><?= htmlspecialchars($item['description']) ?></p>
                                <div class="merch-row">
                                    <span class="merch-price"><?= htmlspecialchars($item['price']) ?></span>
                                    <button
                                        class="add-cart-btn"
                                        type="button"
                                        data-name="<?= htmlspecialchars($item['name']) ?>"
                                        data-price="<?= htmlspecialchars($item['price']) ?>"
                                    >
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </main>

    <button id="cart-fab" class="cart-fab" type="button" aria-label="Open cart">
        🛒
        <span id="cart-count" class="cart-count">0</span>
    </button>

    <aside id="cart-panel" class="cart-panel" aria-label="Shopping cart">
        <div class="cart-header">Your Cart</div>
        <ul id="cart-items" class="cart-items">
            <li class="cart-empty">Your cart is empty.</li>
        </ul>
        <div class="cart-footer">
            <p class="cart-total">Total: <span id="cart-total">0.00€</span></p>
            <button class="checkout-btn" type="button">Choose Payment Method</button>
        </div>
    </aside>

    <?php include 'modules/parts/footer.php'; ?>

    <script>
        (function () {
            var cart = {};
            var cartFab = document.getElementById('cart-fab');
            var cartPanel = document.getElementById('cart-panel');
            var cartCount = document.getElementById('cart-count');
            var cartItems = document.getElementById('cart-items');
            var cartTotal = document.getElementById('cart-total');
            var addButtons = document.querySelectorAll('.add-cart-btn');

            function parsePrice(value) {
                var numeric = value.replace(/[^0-9.,]/g, '').replace(',', '.');
                return parseFloat(numeric) || 0;
            }

            function formatPrice(value) {
                return value.toFixed(2) + '€';
            }

            function getTotalCount() {
                var total = 0;
                Object.keys(cart).forEach(function (key) {
                    total += cart[key].qty;
                });
                return total;
            }

            function getTotalCost() {
                var total = 0;
                Object.keys(cart).forEach(function (key) {
                    total += cart[key].price * cart[key].qty;
                });
                return total;
            }

            function animateFlyToCart(fromElement) {
                if (!fromElement || !cartFab) {
                    return;
                }

                var fromRect = fromElement.getBoundingClientRect();
                var toRect = cartFab.getBoundingClientRect();
                var startX = fromRect.left + fromRect.width / 2;
                var startY = fromRect.top + fromRect.height / 2;
                var endX = toRect.left + toRect.width / 2;
                var endY = toRect.top + toRect.height / 2;
                var deltaX = endX - startX;
                var deltaY = endY - startY;

                var dot = document.createElement('span');
                dot.className = 'cart-fly-dot';
                dot.style.left = (startX - 10) + 'px';
                dot.style.top = (startY - 10) + 'px';
                dot.style.setProperty('--fly-x', deltaX + 'px');
                dot.style.setProperty('--fly-y', deltaY + 'px');
                document.body.appendChild(dot);

                function finishFlyAnimation() {
                    dot.remove();
                    cartFab.classList.remove('bump');
                    void cartFab.offsetWidth;
                    cartFab.classList.add('bump');
                }

                requestAnimationFrame(function () {
                    dot.classList.add('animate');
                });

                window.setTimeout(finishFlyAnimation, 790);
            }

            function renderCart() {
                cartItems.innerHTML = '';
                var keys = Object.keys(cart);

                if (!keys.length) {
                    var empty = document.createElement('li');
                    empty.className = 'cart-empty';
                    empty.textContent = 'Your cart is empty.';
                    cartItems.appendChild(empty);
                    cartCount.textContent = '0';
                    cartTotal.textContent = formatPrice(0);
                    return;
                }

                keys.forEach(function (key) {
                    var item = cart[key];
                    var li = document.createElement('li');
                    li.className = 'cart-item';

                    var top = document.createElement('div');
                    top.className = 'cart-item-top';

                    var left = document.createElement('div');
                    var name = document.createElement('p');
                    name.className = 'cart-item-name';
                    name.textContent = item.name;
                    var meta = document.createElement('p');
                    meta.className = 'cart-item-meta';
                    meta.textContent = 'Qty: ' + item.qty + ' · ' + formatPrice(item.price * item.qty);
                    left.appendChild(name);
                    left.appendChild(meta);

                    var removeBtn = document.createElement('button');
                    removeBtn.className = 'remove-btn';
                    removeBtn.type = 'button';
                    removeBtn.setAttribute('aria-label', 'Remove ' + item.name);
                    removeBtn.textContent = '✕';
                    removeBtn.addEventListener('click', function () {
                        delete cart[key];
                        renderCart();
                    });

                    top.appendChild(left);
                    top.appendChild(removeBtn);
                    li.appendChild(top);
                    cartItems.appendChild(li);
                });

                cartCount.textContent = String(getTotalCount());
                cartTotal.textContent = formatPrice(getTotalCost());
            }

            addButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var name = button.dataset.name;
                    var rawPrice = button.dataset.price;
                    var key = name + '|' + rawPrice;
                    if (!cart[key]) {
                        cart[key] = {
                            name: name,
                            price: parsePrice(rawPrice),
                            qty: 0
                        };
                    }
                    cart[key].qty += 1;
                    renderCart();
                    animateFlyToCart(button);
                });
            });

            cartFab.addEventListener('click', function () {
                cartPanel.classList.toggle('open');
            });

            document.addEventListener('click', function (event) {
                var clickedInsidePanel = cartPanel.contains(event.target);
                var clickedFab = cartFab.contains(event.target);

                if (!clickedInsidePanel && !clickedFab) {
                    cartPanel.classList.remove('open');
                }
            });

            renderCart();
        })();
    </script>
</body>
</html>
