<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../index.php");
    exit();
}

// Connect to DB
$conn = new mysqli("localhost", "root", "", "rajeswari_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders with customer info
$sql = "SELECT o.id, o.order_date, o.status, o.total_amount, c.name AS customer_name, c.email 
        FROM orders o
        JOIN customers c ON o.customer_id = c.id
        ORDER BY o.order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Admin - Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-red-800 mb-6">📦 All Orders</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-red-100">
                        <tr>
                            <th class="p-3 text-left border">Order ID</th>
                            <th class="p-3 text-left border">Customer Name</th>
                            <th class="p-3 text-left border">Email</th>
                            <th class="p-3 text-left border">Order Date</th>
                            <th class="p-3 text-left border">Status</th>
                            <th class="p-3 text-left border">Total Amount (₹)</th>
                            <th class="p-3 text-left border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($order = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-100">
                                    <td class="p-3 border"><?= htmlspecialchars($order['id']) ?></td>
                                    <td class="p-3 border"><?= htmlspecialchars($order['customer_name']) ?></td>
                                    <td class="p-3 border"><?= htmlspecialchars($order['email']) ?></td>
                                    <td class="p-3 border"><?= htmlspecialchars($order['order_date']) ?></td>
                                    <td class="p-3 border"><?= htmlspecialchars(ucfirst($order['status'])) ?></td>
                                    <td class="p-3 border">₹<?= number_format($order['total_amount'], 2) ?></td>
                                    <td class="p-3 border space-x-2">
                                        <a href="view-order.php?id=<?= $order['id'] ?>" class="text-blue-600 hover:underline">View</a>
                                        <a href="edit-order.php?id=<?= $order['id'] ?>" class="text-green-600 hover:underline">Edit</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-500">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>
