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
                                <span class="merch-price"><?= number_format((float)$item['price'], 2) ?>€</span>

                                <button
                                    class="add-cart-btn <?= ((int)$item['stock'] <= 0) ? 'out-of-stock' : '' ?>"
                                    type="button"
                                    data-id="<?= (int)$item['id'] ?>"
                                    data-name="<?= htmlspecialchars($item['name']) ?>"
                                    data-price="<?= (float)$item['price'] ?>"
                                    data-stock="<?= (int)$item['stock'] ?>"
                                >
                                    Add to Cart
                                </button>
                            </div>

                            <p class="stock-text">
                                <?php if ((int)$item['stock'] > 0): ?>
                                    In stock:
                                    <span class="stock-value"><?= (int)$item['stock'] ?></span>
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

<button id="cart-fab" class="cart-fab" type="button">
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

        <form method="POST" action="checkout.php" id="order-form">
            <input type="hidden" name="order_data" id="order_data">
            <button type="submit" name="order">Order</button>
        </form>
    </div>
</aside>

<?php include 'modules/parts/footer.php'; ?>

<div id="sad-modal" class="sad-modal">
    <div class="sad-modal-content">
        <h2>Sorry <span class="sorry-icon" aria-hidden="true"></span></h2>
        <p id="sad-text">This item is out of stock.</p>
        <button id="close-sad" type="button">OK</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const addButtons = document.querySelectorAll('.add-cart-btn');
    const cartFab = document.getElementById('cart-fab');
    const cartPanel = document.getElementById('cart-panel');
    const cartItems = document.getElementById('cart-items');
    const cartCount = document.getElementById('cart-count');
    const cartTotal = document.getElementById('cart-total');
    const orderDataInput = document.getElementById('order_data');
    const orderForm = document.getElementById('order-form');

    const sadModal = document.getElementById('sad-modal');
    const sadText = document.getElementById('sad-text');
    const closeSad = document.getElementById('close-sad');

    let cart = [];

    function showSadModal(message) {
        sadText.textContent = message;
        sadModal.classList.add('show');
    }

    function hideSadModal() {
        sadModal.classList.remove('show');
    }

    function findCartItem(id) {
        return cart.find(item => item.id === id);
    }

    function getQtyInCart(id) {
        const item = findCartItem(id);
        return item ? item.qty : 0;
    }

    function animateToCart(clickedButton) {
        if (!clickedButton || !cartFab) {
            return;
        }

        const startRect = clickedButton.getBoundingClientRect();
        const endRect = cartFab.getBoundingClientRect();

        const dot = document.createElement('div');
        dot.className = 'cart-fly-dot';

        const startX = startRect.left + startRect.width / 2;
        const startY = startRect.top + startRect.height / 2;
        const endX = endRect.left + endRect.width / 2;
        const endY = endRect.top + endRect.height / 2;

        dot.style.left = startX + 'px';
        dot.style.top = startY + 'px';
        dot.style.setProperty('--fly-x', (endX - startX) + 'px');
        dot.style.setProperty('--fly-y', (endY - startY) + 'px');

        document.body.appendChild(dot);

        requestAnimationFrame(() => {
            dot.classList.add('animate');
        });

        setTimeout(() => {
            dot.remove();
            cartFab.style.animation = 'cart-bump 300ms ease';
            setTimeout(() => {
                cartFab.style.animation = '';
            }, 300);
        }, 1100);
    }

    function updateButtons() {
        addButtons.forEach(button => {
            const id = Number(button.dataset.id);
            const stock = Number(button.dataset.stock);
            const qtyInCart = getQtyInCart(id);

            if (stock > 0 && qtyInCart >= stock) {
                button.disabled = true;
            } else {
                button.disabled = false;
            }
        });
    }

    function updateCartUI() {
        cartItems.innerHTML = '';

        if (cart.length === 0) {
            cartItems.innerHTML = '<li class="cart-empty">Your cart is empty.</li>';
            cartCount.textContent = '0';
            cartTotal.textContent = '0.00€';
            orderDataInput.value = JSON.stringify([]);
            updateButtons();
            return;
        }

        let totalQty = 0;
        let total = 0;

        cart.forEach(item => {
            totalQty += item.qty;
            total += item.qty * item.price;

            const li = document.createElement('li');
            li.className = 'cart-item';
            li.innerHTML = `
                <span><strong>${item.name}</strong> × ${item.qty}</span>
                <button type="button" class="remove-btn" data-id="${item.id}">-</button>
            `;
            cartItems.appendChild(li);
        });

        cartCount.textContent = String(totalQty);
        cartTotal.textContent = total.toFixed(2) + '€';
        orderDataInput.value = JSON.stringify(cart);
        updateButtons();
    }

    addButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = Number(this.dataset.id);
            const name = this.dataset.name;
            const price = Number(this.dataset.price);
            const stock = Number(this.dataset.stock);

            if (stock <= 0) {
                showSadModal('This item is out of stock.');
                return;
            }

            const existing = findCartItem(id);

            if (existing) {
                if (existing.qty >= stock) {
                    this.disabled = true;
                    return;
                }
                existing.qty += 1;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    qty: 1
                });
            }

            animateToCart(this);
            updateCartUI();
        });
    });

    cartItems.addEventListener('click', function (e) {
        if (!e.target.classList.contains('remove-btn')) {
            return;
        }

        const id = Number(e.target.dataset.id);
        const item = findCartItem(id);

        if (!item) {
            return;
        }

        item.qty -= 1;

        if (item.qty <= 0) {
            cart = cart.filter(cartItem => cartItem.id !== id);
        }

        updateCartUI();
    });

    cartFab.addEventListener('click', function () {
        cartPanel.classList.toggle('open');
    });

    orderForm.addEventListener('submit', function (e) {
        if (cart.length === 0) {
            e.preventDefault();
            return;
        }
    });

    closeSad.addEventListener('click', hideSadModal);

    sadModal.addEventListener('click', function (e) {
        if (e.target === sadModal) {
            hideSadModal();
        }
    });

    updateCartUI();
});
</script>

</body>
</html>