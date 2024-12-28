<?php

include 'database.php';

// Handle bill submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_bill'])) {
    $customer_name = $_POST['customer_name'];
    $products = $_POST['products'];
    $quantities = $_POST['quantities'];
    $total = $_POST['total'];

    // Insert bill
    $stmt = $conn->prepare("INSERT INTO bills (customer_name, total) VALUES (?, ?)");
    $stmt->bind_param("sd", $customer_name, $total);
    $stmt->execute();
    $bill_id = $stmt->insert_id;

    // Insert bill items
    foreach ($products as $index => $product_id) {
        $quantity = $quantities[$index];
        $product = $conn->query("SELECT price FROM products WHERE id = $product_id")->fetch_assoc();
        $subtotal = $product['price'] * $quantity;

        $stmt = $conn->prepare("INSERT INTO bill_items (bill_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $bill_id, $product_id, $quantity, $subtotal);
        $stmt->execute();

        // Update stock
        $conn->query("UPDATE products SET stock = stock - $quantity WHERE id = $product_id");
    }

    header("Location: billing.php?bill_id=$bill_id");
    exit;
}

// Fetch all products
$products = $conn->query("SELECT id, name, price, stock, barcode FROM products WHERE stock > 0 ORDER BY name");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Billing</title>
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Billing Process</h2>
    <form method="POST" id="billingForm">
        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
        </div>

        <div class="mb-3">
            <label for="product_search" class="form-label">Search Products</label>
            <input type="text" class="form-control" id="product_search" placeholder="Search by name or barcode">
        </div>

        <table class="table table-bordered" id="productsTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = $products->fetch_assoc()): ?>
                    <tr data-id="<?= $product['id']; ?>" data-name="<?= htmlspecialchars($product['name']); ?>" data-price="<?= $product['price']; ?>" data-stock="<?= $product['stock']; ?>" data-barcode="<?= htmlspecialchars($product['barcode']); ?>">
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td><?= number_format($product['price'], 2); ?></td>
                        <td><?= $product['stock']; ?></td>
                        <td><input type="number" class="form-control quantity" min="1" max="<?= $product['stock']; ?>"></td>
                        <td class="subtotal">0.00</td>
                        <td><button type="button" class="btn btn-primary add-to-bill">Add</button></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Bill Summary</h3>
        <table class="table table-bordered" id="billSummary">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="mb-3">
            <label for="total" class="form-label">Total (LKR)</label>
            <input type="text" class="form-control" id="total" name="total" readonly>
        </div>

        <button type="submit" name="create_bill" class="btn btn-success">Generate Bill</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const productSearch = document.getElementById('product_search');
    const productsTable = document.getElementById('productsTable');
    const billSummary = document.getElementById('billSummary').querySelector('tbody');
    const totalInput = document.getElementById('total');

    let total = 0;

    // Search functionality
    productSearch.addEventListener('input', () => {
        const query = productSearch.value.toLowerCase();
        document.querySelectorAll('#productsTable tbody tr').forEach(row => {
            const name = row.dataset.name.toLowerCase();
            const barcode = row.dataset.barcode.toLowerCase(); // Using barcode in data attribute
            row.style.display = name.includes(query) || barcode.includes(query) ? '' : 'none';
        });
    });

    // Add to bill functionality
    productsTable.addEventListener('click', e => {
        if (e.target.classList.contains('add-to-bill')) {
            const row = e.target.closest('tr');
            const id = row.dataset.id;
            const name = row.dataset.name;
            const price = parseFloat(row.dataset.price);
            const stock = parseInt(row.dataset.stock);
            const quantity = parseInt(row.querySelector('.quantity').value);

            if (!quantity || quantity < 1 || quantity > stock) {
                alert('Invalid quantity');
                return;
            }

            const subtotal = price * quantity;
            total += subtotal;

            // Add to bill summary
            const newRow = document.createElement('tr');
            newRow.innerHTML = `<td><input type="hidden" name="products[]" value="${id}">${name}</td>
                                <td>${price.toFixed(2)}</td>
                                <td><input type="hidden" name="quantities[]" value="${quantity}">${quantity}</td>
                                <td>${subtotal.toFixed(2)}</td>`;
            billSummary.appendChild(newRow);

            totalInput.value = total.toFixed(2);

            // Disable product row
            row.querySelector('.quantity').disabled = true;
            e.target.disabled = true;
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
