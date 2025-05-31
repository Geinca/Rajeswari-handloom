<?php
session_start();

if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

// Get total orders
$result_orders = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
$total_orders = $result_orders->fetch_assoc()['total_orders'];

// Get monthly revenue
$current_month = date('Y-m');
$result_revenue = $conn->query("SELECT SUM(total_amount) AS revenue FROM orders WHERE DATE_FORMAT(order_date, '%Y-%m') = '$current_month'");
$monthly_revenue = $result_revenue->fetch_assoc()['revenue'] ?? 0;

// Get new customers this month
$result_customers = $conn->query("SELECT COUNT(*) AS new_customers FROM customers WHERE DATE_FORMAT(created_at, '%Y-%m') = '$current_month'");
$new_customers = $result_customers->fetch_assoc()['new_customers'] ?? 0;

// Get recent orders
$recent_orders = $conn->query("SELECT o.id, c.name, o.total_amount, o.status, o.order_date 
                               FROM orders o 
                               JOIN customers c ON o.customer_id = c.id 
                               ORDER BY o.order_date DESC 
                               LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Rajeswari Handloom</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body class="bg-gray-100 min-h-screen flex">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-6 md:p-10">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">👋 Welcome, Admin</h2>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow text-center hover:shadow-lg transition">
                <h3 class="text-gray-500 text-lg mb-2">Total Orders</h3>
                <p class="text-4xl font-bold text-red-700"><?php echo $total_orders; ?></p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow text-center hover:shadow-lg transition">
                <h3 class="text-gray-500 text-lg mb-2">Revenue This Month</h3>
                <p class="text-4xl font-bold text-red-700">₹<?php echo number_format($monthly_revenue); ?></p>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow text-center hover:shadow-lg transition">
                <h3 class="text-gray-500 text-lg mb-2">New Customers</h3>
                <p class="text-4xl font-bold text-red-700"><?php echo $new_customers; ?></p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-12">
            <h3 class="text-2xl font-semibold mb-4 text-gray-700">⚡ Quick Actions</h3>
            <div class="flex flex-wrap gap-4">
                <a href="products/add-product.php" class="bg-red-600 text-white px-6 py-3 rounded-xl shadow hover:bg-red-700 transition">
                    ➕ Add Product
                </a>
                <a href="orders/orders.php" class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow hover:bg-blue-700 transition">
                    📦 View Orders
                </a>
                <a href="reports/sales-report.php" class="bg-green-600 text-white px-6 py-3 rounded-xl shadow hover:bg-green-700 transition">
                    📊 Sales Report
                </a>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="mt-12">
            <h3 class="text-2xl font-semibold mb-4 text-gray-700">🕒 Recent Orders</h3>
            <div class="bg-white rounded-xl shadow overflow-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100 text-gray-600 text-left">
                        <tr>
                            <th class="p-4">Order ID</th>
                            <th class="p-4">Customer</th>
                            <th class="p-4">Amount</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php while ($row = $recent_orders->fetch_assoc()): ?>
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="p-4"><?php echo $row['id']; ?></td>
                                <td class="p-4"><?php echo $row['name']; ?></td>
                                <td class="p-4">₹<?php echo number_format($row['total_amount']); ?></td>
                                <td class="p-4 capitalize"><?php echo $row['status']; ?></td>
                                <td class="p-4"><?php echo date('d M Y', strtotime($row['order_date'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>
