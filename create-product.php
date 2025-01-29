<?php
require_once 'database.php'; // Include your database connection file
require_once 'partial/header.php'; // Include your header file
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'] ?? null;
    $product_description = $_POST['product_description'] ?? null;
    $product_price = $_POST['product_price'] ?? null;

    if ($product_name && $product_description && $product_price) {
        $conn = new Database();
        $conn->create("INSERT INTO products (title, description, price) VALUES (?, ?, ?)", [$product_name, $product_description, $product_price]);
        header("Location: index.php"); //redirect the process to index.php
        exit;
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Create Product</h1>
            <form method="POST" action="create-product.php">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" required>
                </div>
                <div class="form-group">
                    <label for="product_description">Product Description</label>
                    <textarea class="form-control" id="product_description" name="product_description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="product_price">Product Price</label>
                    <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Product</button>
                <button type="button" class="btn btn-warning btn-back">Go Back</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'partial/footer.php'; ?>