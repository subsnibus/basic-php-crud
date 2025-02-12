<?php
// Include database connection file
require_once '../database.php';

// Check if the form is submitted via POST methid and the product ID is provided
if($_SERVER['REQUEST_METHOD'] === "POST") {
    // $product_id = $_POST['product_id'];
    $data = json_decode(file_get_contents("php://input"), true);
    $product_id = $data['product_id'] ?? null;
    // Create an instance of the database class
    $conn = new Database();
    $conn->delete("DELETE FROM products WHERE id = ?", [$product_id]);
    echo json_encode(["success" => true, "message" => "Product deleted successfully"]);
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Product could not be deleted"]);
    exit;

}
?>
