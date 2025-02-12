<?php
require_once '../database.php';
header("Content-Type: application/json");
$conn = new Database();
$products = $conn->select("SELECT * FROM products");
echo json_encode($products);
exit;
?>