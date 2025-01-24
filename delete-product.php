<?php
// Include database connection file
require_once 'database.php';

// Check if the form is submitted via POST methid and the product ID is provided
if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Create an instance of the database class
    $conn = new Database();
    $conn->delete("DELETE FROM products WHERE id = ?", [$product_id]);
    header("Location: index.php");
} else {
    echo "No product ID provided.";
}
?>
