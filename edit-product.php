<?php
require_once 'Database.php'; // Include your database connection file
require_once 'partial/header.php'; // Include your header file
require_once 'Upload.php';
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
    $product_image = $_FILES['product_image'] ?? null;

    if ($product_image['name']) { // If a new image was uploaded, then this IF condition will run
        $upload = new Upload($product_image);
        $result = $upload->uploadFile();
        if ($result['status']) { // Check if the upload was successful
            // If the upload was successful, $result['file_name'] contains the new file name
            $fileName = $result['file_name'];
        } else {
            echo $result['message'];
            exit;
        }
    } else { // If no new image was uploaded, we will use the existing image filename
        $conn = new Database();
        // NOTE: We are again using the select query here when we had already fetched the product details above  in line no. 5, is because the above query is only executed if the product ID is provided in the URL (GET method). However, right now we are updating the product details using the POST method, so we need to fetch the existing image filename from the database again.
        $existing = $conn->select("SELECT image FROM products WHERE id = ?", [$product_id]);
        $fileName = $existing[0]['image'] ?? null;
    }

    $conn = new Database();
    $returnData = $conn->update("UPDATE products SET title = ?, description = ?, price = ?, image = ? WHERE id = ?", [$product_name, $product_description, $product_price, $fileName, $product_id]);
    header("Location: index.php"); //redirect the process to index.php
    exit;
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Update Product - <?= $pro['title'] ?? ''; ?></h1>
            <!-- NOTE: You need to add the "enctype="multipart/form-data" in the form in order to work with file uploads -->
            <form method="POST" action="edit-product.php" enctype="multipart/form-data">
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
                <!-- Display current image if it exists -->
                <?php if (!empty($pro['image'])) { ?>
                    <div class="form-group">
                        <img src="uploads/<?= $pro['image'] ?>" alt="<?= $pro['title'] ?>" style="max-width: 200px;">
                    </div>
                <?php } ?>
                <div class="form-group">
                    <!-- IMP: See the comment above the <form> tag -->
                    <label for="product_image">Product Image</label>
                    <input type="file" id="product_image" name="product_image" accept="image/*" class="form-control-file">
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
                <button type="button" class="btn btn-warning btn-back">Go Back</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'partial/footer.php'; ?>