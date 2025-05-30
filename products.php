<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../index.php");
    exit();
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "rajeswari_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-red-800">📦 All Products</h2>
                <a href="add-product.php" class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">+ Add Product</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-gray-300">
                    <thead class="bg-red-100">
                        <tr>
                            <th class="p-3 text-left border">Image</th>
                            <th class="p-3 text-left border">Name</th>
                            <th class="p-3 text-left border">Category</th>
                            <th class="p-3 text-left border">Price</th>
                            <th class="p-3 text-left border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($products->num_rows > 0): ?>
                            <?php while ($row = $products->fetch_assoc()): ?>
                                <tr class="hover:bg-gray-100">
                                    <td class="p-3 border">
                                        <img src="/Rajeswari-handloom/image/<?= htmlspecialchars($row['image']) ?>" alt="Product Image" class="w-20 h-20 object-cover rounded">
                                    </td>
                                    <td class="p-3 border"><?= htmlspecialchars($row['name']) ?></td>
                                    <td class="p-3 border"><?= htmlspecialchars($row['category']) ?></td>
                                    <td class="p-3 border">₹<?= number_format($row['price'], 2) ?></td>
                                    <td class="p-3 border">
    <div class="flex space-x-4 items-center">
        <!-- Edit Icon -->
        <a href="edit-products.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800" title="Edit">
            <i class="fas fa-edit"></i>
        </a>
        <!-- Delete Icon -->
        <a href="delete-products.php?id=<?= $row['id'] ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')" title="Delete">
            <i class="fas fa-trash-alt"></i>
        </a>
    </div>
</td>

                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">No products found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

</body>
</html>
