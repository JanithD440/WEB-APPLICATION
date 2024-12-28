<?php



include 'database.php';
include 'includes/header.php';

// Fetch metrics from the database
$total_sales = $conn->query("SELECT SUM(total_amount) AS total FROM transactions")->fetch_assoc()['total'] ?? 0;
$total_products = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc()['total'] ?? 0;
$total_stock = $conn->query("SELECT SUM(stock) AS total FROM products")->fetch_assoc()['total'] ?? 0;
$total_transactions = $conn->query("SELECT COUNT(*) AS total FROM transactions")->fetch_assoc()['total'] ?? 0;

?>
<div class="container mt-5">
    <h1>Dashboard</h1>
    <div class="row mt-4">
        <!-- Total Sales -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text">LKR <?= number_format($total_sales, 2); ?></p>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text"><?= $total_products; ?> Products</p>
                </div>
            </div>
        </div>

        <!-- Total Stock -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Stock</h5>
                    <p class="card-text"><?= $total_stock; ?> Items</p>
                </div>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Transactions</h5>
                    <p class="card-text"><?= $total_transactions; ?> Transactions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add more widgets here -->
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
</div>
<?php include 'includes/footer.php'; ?>
