<?php
include 'db.php';

$total = 0;
$data = json_decode($_POST['order_data'], true);

if ($data) {
    foreach ($data as $item) {
        $total += $item['price'] * $item['qty'];
    }
}

$success = false;

if (isset($_POST['confirm'])) {
    if ($data) {
        foreach ($data as $item) {
            $id = (int)$item['id'];
            $qty = (int)$item['qty'];

            $conn->query("UPDATE products SET stock = stock - $qty WHERE id=$id AND stock >= $qty");
        }
    }

    $success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout</title>

<style>

body {
    margin: 0;
    font-family: Arial;
    background: #f5e6d3;
}

.checkout-container {
    max-width: 500px;
    margin: 40px auto;
    background: white;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

h1 {
    text-align: center;
    color: #5a3e2b;
}

.total-box {
    background: #f3e1cf;
    padding: 10px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 15px;
    font-weight: bold;
}

input, select {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    margin-bottom: 15px;
    border-radius: 10px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 12px;
    background: #5a3e2b;
    color: white;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-weight: bold;
}

.card-box {
    display: none;
    background: #fafafa;
    padding: 15px;
    border-radius: 12px;
    margin-top: 10px;
}

.success-modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.success-box {
    background: white;
    padding: 25px;
    border-radius: 16px;
    text-align: center;
    max-width: 300px;
}

.success-box a {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 15px;
    background: #5a3e2b;
    color: white;
    border-radius: 10px;
    text-decoration: none;
}

</style>
</head>

<body>

<div class="checkout-container">

<p class="total-box">
    Total: <?= number_format($total, 2) ?>€
</p>

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
    <input type="text" placeholder="1234 5678 9012 3456">

    <label>Expiry</label>
    <input type="text" placeholder="MM/YY">

    <label>CVV</label>
    <input type="text" placeholder="123">

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
    if (payment.value === 'card') {
        cardBox.style.display = 'block';
    } else {
        cardBox.style.display = 'none';
    }
});
</script>

</body>
</html>