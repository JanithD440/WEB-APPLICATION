<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>RANGIRI GRANITE & CERAMIC</title>

    <style>
    /* Base Body Style */
    body {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background: linear-gradient(180deg, #e9edf0, #f9fbfd);
        color: #333;
    }

    /* Navbar */
    .navbar {
        background: linear-gradient(135deg, #5a5a5a, #333333);
        padding: 15px 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .navbar-brand {
        font-size: 1.8rem;
        font-weight: 600;
        color: #f9f9f9 !important;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .navbar-nav .nav-link {
        color: #cccccc !important;
        font-size: 1rem;
        padding: 5px 15px;
        margin-right: 10px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
        background: #505050;
        color: #ffffff !important;
    }

    /* Hero Section */
    .hero {
        background: linear-gradient(120deg, #4e54c8, #8f94fb);
        color: #fff;
        text-align: center;
        padding: 50px 20px;
        border-radius: 15px;
        margin-bottom: 30px;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: 700;
        letter-spacing: 2px;
        margin-bottom: 15px;
    }

    .hero p {
        font-size: 1.2rem;
        line-height: 1.8;
        margin: 0;
    }

    /* Main Container */
    .container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 25px 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Tables */
    table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        background: linear-gradient(135deg, #ffffff, #f6f8fc);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
    }

    table th {
        background: linear-gradient(135deg, #6c63ff, #483d8b);
        color: #ffffff;
        text-align: left;
        padding: 12px 15px;
        font-size: 1rem;
        text-transform: uppercase;
    }

    table td {
        padding: 15px;
        font-size: 0.95rem;
        color: #666666;
    }

    table tr:nth-child(even) {
        background: #f8f9fb;
    }

    table tr:hover {
        background: rgba(76, 132, 255, 0.1);
        cursor: pointer;
        transform: scale(1.01);
        transition: all 0.2s ease;
    }

    /* Buttons */
    .btn {
        display: inline-block;
        padding: 10px 20px;
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        color: #ffffff;
        background: linear-gradient(135deg, #6c63ff, #483d8b);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.4s ease;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25);
        background: linear-gradient(135deg, #483d8b, #6c63ff);
    }

    /* Input Fields */
    input, select, textarea {
        display: block;
        width: 100%;
        margin: 10px 0 20px;
        padding: 12px 15px;
        font-size: 1rem;
        border: 1px solid #dfe4ea;
        border-radius: 8px;
        background: #f9fbfd;
        color: #333;
        box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    input:focus, select:focus, textarea:focus {
        border-color: #6c63ff;
        box-shadow: 0 0 8px rgba(108, 99, 255, 0.3);
    }

    /* Floating Button */
    .floating-button {
        position: fixed;
        bottom: 25px;
        right: 25px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #ff6b6b, #e74c3c);
        color: #ffffff;
        font-size: 1.5rem;
        border-radius: 50%;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.4s ease;
    }

    .floating-button:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    }

    /* Footer */
    footer {
        background: #2c3e50;
        color: #ffffff;
        text-align: center;
        padding: 15px 0;
        margin-top: 40px;
        border-radius: 0 0 10px 10px;
    }

    footer a {
        color: #1abc9c;
        text-decoration: none;
        font-weight: bold;
    }

    footer a:hover {
        color: #16a085;
        text-decoration: underline;
    }
</style>




</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Inventory System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
    <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li> <!-- Added Categories Link -->
    <li class="nav-item"><a class="nav-link" href="suppliers.php">Suppliers</a></li>
    <li class="nav-item"><a class="nav-link" href="billing.php">Billing</a></li>
    <li class="nav-item"><a class="nav-link" href="transactions.php">Transactions</a></li>
    <li class="nav-item"><a class="nav-link" href="sales_reports.php">Sales Report</a></li>
    <li class="nav-item"><a class="nav-link" href="stock_report.php">Stock Report</a></li>
    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
</ul>

        </div>
    </div>
</nav>
<div class="container">
