<?php
include_once __DIR__ . '/../../db.php';

$merch_items = [];

$sql = "SELECT name, price, image, description FROM products";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $merch_items[] = [
            'name' => $row['name'],
            'price' => number_format((float)$row['price'], 2) . '€',
            'image' => $row['image'],
            'description' => $row['description'],
        ];
    }
}
?>