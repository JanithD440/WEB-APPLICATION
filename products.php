<?php

include 'database.php';

// Handle Add/Edit/Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $stock = $_POST['stock'];
        $price = $_POST['price'];
        $barcode = $_POST['barcode'];
        $stmt = $conn->prepare("INSERT INTO products (name, category_id, stock, price, barcode) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siids", $name, $category_id, $stock, $price, $barcode);
        $stmt->execute();
    }

    if (isset($_POST['edit_product'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $category_id = $_POST['category_id'];
        $stock = $_POST['stock'];
        $price = $_POST['price'];
        $stmt = $conn->prepare("UPDATE products SET name = ?, category_id = ?, stock = ?, price = ? WHERE id = ?");
        $stmt->bind_param("siidi", $name, $category_id, $stock, $price, $id);
        $stmt->execute();
    }

    if (isset($_POST['delete_product'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    header("Location: products.php");
    exit;
}

// Fetch products and categories
$products = $conn->query("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC");
$categories = $conn->query("SELECT * FROM categories ORDER BY name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Products Management</title>
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Products Management</h2>
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Add New Product</button>
    <input type="text" id="searchBar" class="form-control mb-3" placeholder="Search products...">
    <table class="table table-bordered" id="productsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Price (LKR)</th>
                <th>Barcode</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['category_name']); ?></td>
                    <td><?= $row['stock']; ?></td>
                    <td><?= number_format($row['price'], 2); ?></td>
                    <td><?= $row['barcode']; ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal<?= $row['id']; ?>">Edit</button>

                        <!-- Delete Button -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                            <button type="submit" name="delete_product" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Product Modal -->
                <div class="modal fade" id="editProductModal<?= $row['id']; ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Product</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($row['name']); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select class="form-control" name="category_id" required>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['id']; ?>" <?= $category['id'] == $row['category_id'] ? 'selected' : ''; ?>><?= htmlspecialchars($category['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stock</label>
                                        <input type="number" class="form-control" name="stock" value="<?= $row['stock']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price (LKR)</label>
                                        <input type="text" class="form-control" name="price" value="<?= $row['price']; ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="edit_product" class="btn btn-warning">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control" name="category_id" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id']; ?>"><?= htmlspecialchars($category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" name="stock" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price (LKR)</label>
                        <input type="text" class="form-control" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="barcode" class="form-label">Barcode</label>
                        <input type="text" class="form-control" name="barcode" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('searchBar').addEventListener('input', function () {
    const query = this.value.toLowerCase();
    document.querySelectorAll('#productsTable tbody tr').forEach(row => {
        const name = row.cells[1].innerText.toLowerCase();
        row.style.display = name.includes(query) ? '' : 'none';
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
