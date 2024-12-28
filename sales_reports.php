<?php
include 'database.php';

// Default date range: Last 30 days
$start_date = date('Y-m-d', strtotime('-30 days'));
$end_date = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
}

// Fetch sales data
$stmt = $conn->prepare("
    SELECT COUNT(*) AS total_transactions, SUM(total) AS total_revenue 
    FROM bills 
    WHERE DATE(created_at) BETWEEN ? AND ?
");
$stmt->bind_param("ss", $start_date, $end_date);
$stmt->execute();
$sales_data = $stmt->get_result()->fetch_assoc();

// Fetch daily sales for chart
$chart_stmt = $conn->prepare("
    SELECT DATE(created_at) AS date, SUM(total) AS daily_sales 
    FROM bills 
    WHERE DATE(created_at) BETWEEN ? AND ?
    GROUP BY DATE(created_at)
    ORDER BY DATE(created_at)
");
$chart_stmt->bind_param("ss", $start_date, $end_date);
$chart_stmt->execute();
$chart_result = $chart_stmt->get_result();

$chart_dates = [];
$chart_sales = [];
while ($row = $chart_result->fetch_assoc()) {
    $chart_dates[] = $row['date'];
    $chart_sales[] = $row['daily_sales'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Sales Report</title>
</head>
<body>
<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Sales Report</h2>
    <form method="POST" class="mb-3">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="<?= $start_date; ?>" required>
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="<?= $end_date; ?>" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Generate Report</button>
            </div>
        </div>
    </form>

    <h3>Summary</h3>
    <p><strong>Total Transactions:</strong> <?= $sales_data['total_transactions']; ?></p>
    <p><strong>Total Revenue:</strong> LKR <?= number_format($sales_data['total_revenue'], 2); ?></p>

    <h3>Sales Chart</h3>
    <canvas id="salesChart" width="400" height="200"></canvas>
</div>

<script>
    const chartDates = <?= json_encode($chart_dates); ?>;
    const chartSales = <?= json_encode($chart_sales); ?>;

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartDates,
            datasets: [{
                label: 'Daily Sales (LKR)',
                data: chartSales,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
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
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Sales (LKR)'
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
