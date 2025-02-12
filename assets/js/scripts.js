
document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM Loaded");
    loadProducts();

    // This is a back button that will redirect to the previous page and this code is executed after the DOM is loaded (page is loaded)
    document.querySelector('.btn-back').addEventListener('click', function() {
        if (document.referrer) {
            window.location.href = document.referrer;
        } else {
            window.location.href = '/index.php';
        }
    });
});

function storeProduct(e) {
    e.preventDefault();
    let formData = {
        product_name: document.getElementById("product_name").value,
        product_description: document.getElementById("product_description").value,
        product_price: document.getElementById("product_price").value
    };

    fetch('action/create-product.php', {
        method: 'POST',
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message); // Show success message
            document.getElementById("create-product-form").reset(); // Clear form
            // window.location.href = "index.php"; // Redirect after success
        } else {
            alert("Error: " + data.message); // Show error message
        }
    })
    .catch(error => { console.error(error);});
}

function loadProducts() {
    console.log("Loading products...");
    fetch('action/fetch-product.php')
    .then(response => response.json())
    .then(data => {
        let tableBody = document.getElementById("product-table");
        tableBody.innerHTML = "";
        let i = 1;
        data.forEach(product => {
            let row = document.createElement("tr");
            row.innerHTML = `
                <td>${i++}</td>
                <td>${product.title}</td>
                <td>${product.price}</td>
                <td>
                    <a href="edit-product.php?id=${product.id}" class="btn btn-primary btn-sm">Update</a>
                    <button onclick="deleteProduct(${product.id})" class="btn btn-danger btn-sm" >Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    });
}

function deleteProduct(id) {
    if (confirm("Are you sure you want to delete this product?")) {
        fetch("action/delete-product.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ product_id: id })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            loadProducts();
        });
    }
}