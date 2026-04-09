<?php
include 'db.php';

if (!isset($_POST['id'])) {
    echo "error";
    exit;
}

$id = (int)$_POST['id'];

$conn->query("UPDATE products SET stock = stock - 1 WHERE id = $id AND stock > 0");

if ($conn->affected_rows > 0) {
    $result = $conn->query("SELECT stock FROM products WHERE id = $id");
    $product = $result->fetch_assoc();
    echo $product['stock'];
} else {
    echo "out";
}
?>