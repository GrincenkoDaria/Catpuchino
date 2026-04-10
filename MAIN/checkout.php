<?php
include 'db.php';

$total = 0;
$data = [];

if (isset($_POST['order_data'])) {
    $data = json_decode($_POST['order_data'], true);
}

if ($data) {
    foreach ($data as $item) {
        $total += $item['price'] * $item['qty'];
    }
}

$success = false;

if (isset($_POST['confirm'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    if ($data) {

        $stmt = $conn->prepare("
            INSERT INTO orders (name, email, address, total)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param("sssd", $name, $email, $address, $total);
        $stmt->execute();

        $order_id = $stmt->insert_id;

        foreach ($data as $item) {

            $id = (int)$item['id'];
            $qty = (int)$item['qty'];
            $price = (float)$item['price'];
            $name_item = $item['name'];

            $conn->query("
                INSERT INTO order_items
                (order_id, product_id, product_name, quantity, price)
                VALUES ($order_id, $id, '$name_item', $qty, $price)
            ");

            $conn->query("
                UPDATE products 
                SET stock = stock - $qty 
                WHERE id=$id AND stock >= $qty
            ");
        }
    }

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="assets/css/pages/checkout.css">
</head>

<body>

<div class="checkout-container">

<h1>Checkout</h1>

<p class="total-box">
    Total: <?= number_format($total, 2) ?>€
</p>

<?php if ($data): ?>
<div class="order-summary">
    <h3>Your order</h3>
    <ul>
        <?php foreach ($data as $item): ?>
            <li>
                <?= htmlspecialchars($item['name']) ?> × <?= $item['qty'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST">

<input type="hidden" name="order_data" value='<?= htmlspecialchars($_POST['order_data']) ?>'>

<label>Name</label>
<input type="text" name="name" required>

<label>Email</label>
<input type="email" name="email" required>

<label>Address</label>
<input type="text" name="address" required>

<label>Payment</label>
<select id="payment">
    <option value="cash">Cash</option>
    <option value="card">Card</option>
</select>

<div id="card-box" class="card-box">

    <label>Card Number</label>
    <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456">

    <label>Expiry</label>
    <input type="text" id="expiry" placeholder="MM/YY">

    <label>CVV</label>
    <input type="text" id="cvv" placeholder="123">

</div>

<button type="submit" name="confirm">Confirm Order</button>

</form>

</div>

<?php if ($success): ?>
<div class="success-modal">
    <div class="success-box">
        <h2>Thank you 😻</h2>
        <p>Your order was successful!</p>
        <a href="merch.php">Back to shop</a>
    </div>
</div>
<?php endif; ?>

<script>
var payment = document.getElementById('payment');
var cardBox = document.getElementById('card-box');

payment.addEventListener('change', function () {
    cardBox.style.display = payment.value === 'card' ? 'block' : 'none';
});

const expiryInput = document.getElementById('expiry');
const cardInput = document.getElementById('cardNumber');
const cvvInput = document.getElementById('cvv');

expiryInput.addEventListener('input', function () {
    let v = expiryInput.value.replace(/\D/g, '');
    if (v.length > 4) v = v.slice(0,4);
    if (v.length >= 2) v = v.slice(0,2) + '/' + v.slice(2);
    expiryInput.value = v;
});

cardInput.addEventListener('input', function () {
    let v = cardInput.value.replace(/\D/g, '');
    if (v.length > 16) v = v.slice(0,16);
    v = v.replace(/(.{4})/g, '$1 ').trim();
    cardInput.value = v;
});

cvvInput.addEventListener('input', function () {
    cvvInput.value = cvvInput.value.replace(/\D/g, '').slice(0,4);
});
</script>

</body>
</html>