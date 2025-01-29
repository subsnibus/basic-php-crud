<?php
require_once 'database.php'; // Include your database connection file
require_once 'partial/header.php'; // Include your header file
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $conn = new Database();
    $product = $conn->select("SELECT * FROM products WHERE id = ?", [$id]);
    $pro = $product[0]; // get only the first element of the array
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'] ?? null;
    $product_description = $_POST['product_description'] ?? null;
    $product_price = $_POST['product_price'] ?? null;
    $product_id = $_POST['product_id'] ?? null;

    if ($product_name && $product_description && $product_price) {
        $conn = new Database();
        $returnData = $conn->update("UPDATE products SET title = ?, description = ?, price = ? WHERE id = ?", [$product_name, $product_description, $product_price, $product_id]);
        header("Location: index.php"); //redirect the process to index.php
        exit;
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Update Product - <?= $pro['title'] ?? ''; ?></h1>
            <form method="POST" action="edit-product.php">
                <input type="hidden" name="product_id" value="<?= $pro['id'] ?? ''; ?>">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" value="<?= $pro['title'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="product_description">Product Description</label>
                    <textarea class="form-control" id="product_description" name="product_description" rows="3" required><?= $pro['description'] ?? ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="product_price">Product Price</label>
                    <input type="number" step="0.01" class="form-control" id="product_price" name="product_price" value="<?= $pro['price'] ?? ''; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
                <button type="button" class="btn btn-warning btn-back">Go Back</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'partial/footer.php'; ?>