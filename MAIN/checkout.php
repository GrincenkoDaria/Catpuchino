<?php
include 'db.php';

$total = 0;
$data = [];
$error = '';
$success = false;

if (isset($_POST['order_data'])) {
    $data = json_decode($_POST['order_data'], true);
    if (!is_array($data)) {
        $data = [];
    }
}

if ($data) {
    foreach ($data as $item) {
        $qty = isset($item['qty']) ? (int)$item['qty'] : 0;
        $price = isset($item['price']) ? (float)$item['price'] : 0;
        $total += $price * $qty;
    }
}

if (isset($_POST['confirm'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');

    if (!$data) {
        $error = 'Your cart is empty.';
    } else {
        $conn->begin_transaction();

        try {
            foreach ($data as $item) {
                $id = (int)($item['id'] ?? 0);
                $qty = (int)($item['qty'] ?? 0);

                if ($id <= 0 || $qty <= 0) {
                    throw new Exception('Invalid order data.');
                }

                $stmtCheck = $conn->prepare("SELECT name, stock FROM products WHERE id = ? FOR UPDATE");
                $stmtCheck->bind_param("i", $id);
                $stmtCheck->execute();
                $productResult = $stmtCheck->get_result();
                $product = $productResult->fetch_assoc();
                $stmtCheck->close();

                if (!$product) {
                    throw new Exception('Product not found.');
                }

                if ((int)$product['stock'] < $qty) {
                    throw new Exception('Not enough stock for ' . $product['name'] . '.');
                }
            }

            $stmt = $conn->prepare("
                INSERT INTO orders (name, email, address, total)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("sssd", $name, $email, $address, $total);
            $stmt->execute();
            $order_id = $stmt->insert_id;
            $stmt->close();

            foreach ($data as $item) {
                $id = (int)$item['id'];
                $qty = (int)$item['qty'];
                $price = (float)$item['price'];
                $name_item = $item['name'];

                $stmtItem = $conn->prepare("
                    INSERT INTO order_items (order_id, product_id, product_name, quantity, price)
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmtItem->bind_param("iisid", $order_id, $id, $name_item, $qty, $price);
                $stmtItem->execute();
                $stmtItem->close();

                $stmtUpdate = $conn->prepare("
                    UPDATE products
                    SET stock = stock - ?
                    WHERE id = ?
                ");
                $stmtUpdate->bind_param("ii", $qty, $id);
                $stmtUpdate->execute();
                $stmtUpdate->close();
            }

            $conn->commit();
            $success = true;
        } catch (Exception $e) {
            $conn->rollback();
            $error = $e->getMessage();
        }
    }
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

<p class="total-box">
    Total: <?= number_format($total, 2) ?>€
</p>

<?php if ($error): ?>
    <p style="color: red; margin-bottom: 15px;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($data): ?>
<div class="order-summary">
    <h3>Your order</h3>
    <ul>
        <?php foreach ($data as $item): ?>
            <li>
                <?= htmlspecialchars($item['name']) ?> × <?= (int)$item['qty'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST">
<input type="hidden" name="order_data" value='<?= htmlspecialchars($_POST['order_data'] ?? "[]", ENT_QUOTES) ?>'>

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

<script src="assets/js/form-utils.min.js" defer></script>

</body>
</html>