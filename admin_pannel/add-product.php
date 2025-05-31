<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form inputs
    $name = $_POST["name"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $description = $_POST["description"];

    // Validate category
    $allowedCategories = ['Bomkai Silk', 'Kotpad Cotton', 'Tissue Silk', 'Tusser Silk'];
    if (!in_array($category, $allowedCategories)) {
        die("Invalid category selected.");
    }

    // Handle uploaded image
    $imageName = $_FILES["image"]["name"];
    $imageTmp = $_FILES["image"]["tmp_name"];
    $targetDir = "../uploads/";
    $targetFile = $targetDir . basename($imageName);
    move_uploaded_file($imageTmp, $targetFile);

    // Insert into DB
    $conn = new mysqli("localhost", "root", "", "rajeswari_db");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO products (name, category, price, description, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $name, $category, $price, $description, $imageName);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg p-6">
        <h1 class="text-2xl font-bold text-red-800 mb-8">Rajeswari Admin</h1>
        <nav class="flex flex-col gap-4">
            <a href="dashboard.php" class="hover:text-red-600">🏠 Dashboard</a>
            <a href="products.php" class="text-red-800 font-semibold">🛍️ Products</a>
            <a href="orders/orders.php" class="hover:text-red-600">📦 Orders</a>
            <a href="customers/customers.php" class="hover:text-red-600">👤 Customers</a>
            <a href="reports/sales-report.php" class="hover:text-red-600">📈 Reports</a>
            <a href="settings/general-settings.php" class="hover:text-red-600">⚙️ Settings</a>
            <a href="logout.php" class="text-red-600 mt-8">🚪 Logout</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-red-800 mb-6">➕ Add New Product</h2>

            <form action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="name" required class="w-full mt-1 p-2 border rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category" required class="w-full mt-1 p-2 border rounded">
                        <option value="" disabled selected>Select Category</option>
                        <option value="Bomkai Silk">Bomkai Silk</option>
                        <option value="Kotpad Cotton">Kotpad Cotton</option>
                        <option value="Tissue Silk">Tissue Silk</option>
                        <option value="Tusser Silk">Tusser Silk</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price (INR)</label>
                    <input type="number" name="price" step="0.01" required class="w-full mt-1 p-2 border rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="4" class="w-full mt-1 p-2 border rounded"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Image</label>
                    <input type="file" name="image" accept="image/*" required class="mt-1">
                </div>

                <div class="flex justify-between">
                    <a href="products.php" class="text-gray-600 hover:underline">← Back to Products</a>
                    <button type="submit" class="bg-red-700 text-white px-6 py-2 rounded hover:bg-red-800">Save Product</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
