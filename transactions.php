<?php


include 'database.php';

// Fetch all transactions
$transactions = $conn->query("SELECT * FROM bills ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Transactions</title>
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>All Transactions</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bill ID</th>
                <th>Customer Name</th>
                <th>Total (LKR)</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $transactions->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['customer_name']); ?></td>
                    <td><?= number_format($row['total'], 2); ?></td>
                    <td><?= $row['created_at']; ?></td>
                    <td>
                        <a href="view_bill.php?bill_id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">View Bill</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
