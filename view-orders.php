<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("Order ID is missing.");
}

$order_id = intval($_GET['id']);

$conn = new mysqli("localhost", "root", "", "rajeswari_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT orders.*, customers.name AS customer_name, customers.email AS customer_email 
        FROM orders 
        JOIN customers ON orders.customer_id = customers.id
        WHERE orders.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Order not found.");
}

$order = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>View Order #<?= htmlspecialchars($order['id']) ?> - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">
    <!-- Sidebar (reuse from your admin layout) -->
    <?php include 'sidebar.php'; ?>

    <main class="flex-1 p-8">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-red-800 mb-6">Order Details — #<?= htmlspecialchars($order['id']) ?></h2>

            <div class="mb-6">
                <h3 class="text-lg font-semibold">Customer Info</h3>
                <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($order['customer_email']) ?></p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold">Order Info</h3>
                <p><strong>Order Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
                <p><strong>Total Amount:</strong> ₹<?= number_format($order['total_amount'], 2) ?></p>
            </div>

            <a href="orders.php" class="text-red-700 hover:underline">← Back to Orders</a>
        </div>
    </main>
</body>
</html>
