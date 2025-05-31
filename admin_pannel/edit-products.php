<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../index.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "rajeswari_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'] ?? 0;
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    
    if ($_FILES["image"]["name"]) {
        $imageName = $_FILES["image"]["name"];
        $imageTmp = $_FILES["image"]["tmp_name"];
        $targetDir = "../uploads/";
        move_uploaded_file($imageTmp, $targetDir . $imageName);
    } else {
        $imageName = $product["image"];
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, category=?, price=?, description=?, image=? WHERE id=?");
    $stmt->bind_param("ssdssi", $name, $category, $price, $description, $imageName, $id);
    $stmt->execute();

    header("Location: products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-red-800 mb-6">✏️ Edit Product</h2>

            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required class="w-full mt-1 p-2 border rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category" required class="w-full mt-1 p-2 border rounded">
                        <option value="Bomkai Silk" <?= $product['category'] == 'Bomkai Silk' ? 'selected' : '' ?>>Bomkai Silk</option>
                        <option value="Kotpad Cotton" <?= $product['category'] == 'Kotpad Cotton' ? 'selected' : '' ?>>Kotpad Cotton</option>
                        <option value="Tissue Silk" <?= $product['category'] == 'Tissue Silk' ? 'selected' : '' ?>>Tissue Silk</option>
                        <option value="Tusser Silk" <?= $product['category'] == 'Tusser Silk' ? 'selected' : '' ?>>Tusser Silk</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Price (INR)</label>
                    <input type="number" name="price" step="0.01" value="<?= $product['price'] ?>" required class="w-full mt-1 p-2 border rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="4" class="w-full mt-1 p-2 border rounded"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Current Image</label>
                    <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" alt="Product Image" class="w-32 h-32 object-cover rounded mb-2">
                    <input type="file" name="image" accept="image/*" onchange="previewImage(event)" class="w-full">
                    <img id="imagePreview" class="mt-4 w-32 h-32 object-cover rounded hidden" />
                </div>

                <div class="flex justify-between">
                    <a href="products.php" class="text-gray-600 hover:underline">← Back to Products</a>
                    <button type="submit" class="bg-red-700 text-white px-6 py-2 rounded hover:bg-red-800">Update Product</button>
                </div>
            </form>
        </div>
    </main>

    <script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById("imagePreview");

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove("hidden");
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

</body>
</html>
