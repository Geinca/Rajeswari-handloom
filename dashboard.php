<?php
session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Rajeswari Handloom</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-10">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Welcome, Admin</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h3 class="text-gray-500">Total Orders</h3>
                <p class="text-3xl font-bold text-red-800">120</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h3 class="text-gray-500">Revenue This Month</h3>
                <p class="text-3xl font-bold text-red-800">₹2,45,000</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h3 class="text-gray-500">New Customers</h3>
                <p class="text-3xl font-bold text-red-800">35</p>
            </div>
        </div>

        <div class="mt-10">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Quick Actions</h3>
            <div class="flex flex-wrap gap-4">
                <a href="products/add-product.php" class="bg-red-700 text-white px-6 py-3 rounded-lg hover:bg-red-800">➕ Add Product</a>
                <a href="orders/orders.php" class="bg-blue-700 text-white px-6 py-3 rounded-lg hover:bg-blue-800">📦 View Orders</a>
                <a href="reports/sales-report.php" class="bg-green-700 text-white px-6 py-3 rounded-lg hover:bg-green-800">📊 Sales Report</a>
            </div>
        </div>
    </main>

</body>
</html>
