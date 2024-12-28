<?php


// Include database connection
include 'database.php';

// Fetch updates and featured products
$updates = $conn->query("SELECT * FROM updates ORDER BY created_at DESC LIMIT 5");
$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 4");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>RANGIRI GRANITE & CERAMIC PVT(LTD)</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(180deg, #f7f9fc, #e9ecef);
            color: #333;
        }

        .navbar {
            background: linear-gradient(135deg, #35495e, #22313f);
            color: #fff;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
            text-transform: uppercase;
            color: #fff !important;
        }

        .hero {
            background: linear-gradient(135deg, #283c86, #45a247);
            color: #fff;
            padding: 60px 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .hero p {
            font-size: 1.3rem;
            margin: 20px auto;
            max-width: 600px;
        }

        .product-card {
            background: #fff;
            border: 1px solid #e3e3e3;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .product-card img {
            width: 100%;
            border-radius: 10px 10px 0 0;
            height: 200px;
            object-fit: cover;
        }

        .product-card .card-body {
            padding: 20px;
            text-align: center;
        }

        .footer {
            background: #1f2833;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            margin-top: 40px;
            border-radius: 10px;
        }

        .footer a {
            color: #66fcf1;
            text-decoration: none;
            font-weight: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">RANGIRI GRANITE & CERAMIC</a>
            <div class="navbar-nav">
                <a class="nav-link text-light" href="dashboard.php">Dashboard</a>
                <a class="nav-link text-light" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <h1>Welcome to RANGIRI GRANITE & CERAMIC PVT(LTD)</h1>
        <p>Your one-stop destination for premium granite and ceramic products.</p>
    </div>

    <!-- Shop Details -->
    <div class="container text-center">
        <h2>About Us</h2>
        <p>RANGIRI GRANITE & CERAMIC PVT(LTD) is a leading supplier of high-quality granite and ceramic products. With years of expertise, we ensure our customers receive the best products and services in the industry.</p>
        <p><strong>Contact Us:</strong> +94 76 123 4567 | Email: info@rangiri.com</p>
    </div>

    <!-- Updates Section -->
    <div class="container mt-4">
        <h2>Latest Updates</h2>
        <ul class="list-group">
            <?php while ($update = $updates->fetch_assoc()): ?>
                <li class="list-group-item"><?= htmlspecialchars($update['message']); ?> <small class="text-muted">(<?= $update['created_at']; ?>)</small></li>
            <?php endwhile; ?>
        </ul>
    </div>

    <!-- Featured Products Section -->
    <div class="container mt-5">
        <h2>Featured Products</h2>
        <div class="row">
            <?php while ($product = $products->fetch_assoc()): ?>
                <div class="col-md-3">
                    <div class="product-card">
                        <img src="<?= htmlspecialchars($product['image_url']); ?>" alt="<?= htmlspecialchars($product['name']); ?>">
                        <div class="card-body">
                            <h5><?= htmlspecialchars($product['name']); ?></h5>
                            <p>Price: LKR <?= number_format($product['price'], 2); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?= date('Y'); ?> RANGIRI GRANITE & CERAMIC PVT(LTD). All Rights Reserved. | <a href="contact.php">Contact Us</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
