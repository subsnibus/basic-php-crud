<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'database.php'; // Include your database connection file
require 'partial/header.php'; // Include your header file
?>
<div class="container">
    <h1>Product Management</h1>
    <div class="d-flex justify-content-center align-items-center">
        <!-- <h2 class="mr-3">Product List</h2> -->
        <a href="create-product.php" class="btn btn-primary btn-sm">Add Product</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>S.N.</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="product-table">
                    <!-- Product list will be displayed here using AJAX -->
                </tbody>
            </table>
            <div class="user-info">
                <p class="d-inline">Logged in as: <?= $_SESSION['user_name'] ?? 'N/A'; ?></p>
                <a href="logout.php" class="btn btn-secondary btn-sm d-inline">Logout</a>
            </div>
        </div>
    </div>
</div>

<?php require 'partial/footer.php'; // Include your footer file ?>