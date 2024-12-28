<?php

include 'database.php';

// Fetch the bill details
if (!isset($_GET['bill_id'])) {
    header("Location: billing.php");
    exit;
}

$bill_id = intval($_GET['bill_id']);

// Fetch bill information
$bill = $conn->query("SELECT * FROM bills WHERE id = $bill_id")->fetch_assoc();
if (!$bill) {
    die("Bill not found.");
}

// Fetch bill items
$bill_items = $conn->query("
    SELECT bi.*, p.name, p.price 
    FROM bill_items bi 
    JOIN products p ON bi.product_id = p.id 
    WHERE bi.bill_id = $bill_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>View Bill</title>
</head>
<body>
<div class="container mt-5">
    <h2>Bill Details</h2>
    <p><strong>Customer Name:</strong> <?= htmlspecialchars($bill['customer_name']); ?></p>
    <p><strong>Date:</strong> <?= $bill['created_at']; ?></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price (LKR)</th>
                <th>Quantity</th>
                <th>Subtotal (LKR)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = $bill_items->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td><?= number_format($item['price'], 2); ?></td>
                    <td><?= $item['quantity']; ?></td>
                    <td><?= number_format($item['subtotal'], 2); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <h4 class="text-end">Total: LKR <?= number_format($bill['total'], 2); ?></h4>
    <div class="text-end">
        <button onclick="window.print()" class="btn btn-primary">Print Bill</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
