<?php

include 'database.php';

// Fetch stock data
$stock_data = $conn->query("
    SELECT p.name AS product_name, c.name AS category_name, p.stock 
    FROM products p 
    JOIN categories c ON p.category_id = c.id 
    ORDER BY p.name
");

$product_names = [];
$stock_levels = [];
while ($row = $stock_data->fetch_assoc()) {
    $product_names[] = $row['product_name'];
    $stock_levels[] = $row['stock'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Stock Report</title>
    <style>
        /* Custom styles for the interface */
        body {
            background-color: #f9f9f9;
        }

        h2 {
            font-weight: bold;
            color: #343a40;
        }

        .table {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            margin-top: 30px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Stock Report</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Reset the query for display purposes
            $stock_data->data_seek(0);
            while ($row = $stock_data->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['product_name']); ?></td>
                    <td><?= htmlspecialchars($row['category_name']); ?></td>
                    <td><?= $row['stock']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="chart-container">
        <h3>Stock Levels</h3>
        <canvas id="stockChart" width="400" height="200"></canvas>
    </div>
</div>

<script>
    const productNames = <?= json_encode($product_names); ?>;
    const stockLevels = <?= json_encode($stock_levels); ?>;

    const ctx = document.getElementById('stockChart').getContext('2d');
    const stockChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Stock Levels',
                data: stockLevels,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Products'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Stock'
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
