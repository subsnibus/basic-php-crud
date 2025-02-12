<?php
require_once '../database.php'; // Include your database connection file
header("Content-Type: application/json"); // Set JSON response

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /* `"php://input"` in PHP is a read-only stream that allows you to read raw data from the request body. In the
    provided code snippet, `file_get_contents("php://input")` is used to retrieve the raw JSON input data sent in the
    POST request. This data is then decoded using `json_decode` to extract the values of `product_name`, `product_description`, and `product_price` from the JSON payload. */
    $data = json_decode(file_get_contents("php://input"), true);

    $product_name = $data['product_name'] ?? null;
    $product_description = $data['product_description'] ?? null;
    $product_price = $data['product_price'] ?? null;

    if ($product_name && $product_description && $product_price) {
        $conn = new Database();
        $returnData = $conn->create("INSERT INTO products (title, description, price) VALUES (?, ?, ?)", [$product_name, $product_description, $product_price]);

        if ($returnData) {
            echo json_encode(["success" => true, "message" => "Product added successfully"]);
            exit;
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add product"]);
            exit;
        }
    } else {
        echo json_encode(["success" => false, "message" => "All fields are required!"]);
        exit;
    }
}
?>
