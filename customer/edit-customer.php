<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: ../index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "rajeswari_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("Customer ID is missing.");
}

$id = intval($_GET['id']);

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);

    $update = "UPDATE customers SET name='$name', email='$email', phone='$phone', address='$address' WHERE id=$id";
    if ($conn->query($update)) {
        header("Location: customers.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch customer
$result = $conn->query("SELECT * FROM customers WHERE id=$id");
if ($result->num_rows === 0) {
    die("Customer not found.");
}
$customer = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main content -->
    <main class="flex-1 p-8">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-red-800 mb-6">Edit Customer</h2>

            <form method="POST">
                <label class="block mb-4">
                    <span class="block font-semibold mb-1">Name</span>
                    <input type="text" name="name" required value="<?= htmlspecialchars($customer['name']) ?>" class="w-full border border-gray-300 rounded px-4 py-2" />
                </label>

                <label class="block mb-4">
                    <span class="block font-semibold mb-1">Email</span>
                    <input type="email" name="email" required value="<?= htmlspecialchars($customer['email']) ?>" class="w-full border border-gray-300 rounded px-4 py-2" />
                </label>

                <label class="block mb-4">
                    <span class="block font-semibold mb-1">Phone</span>
                    <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>" class="w-full border border-gray-300 rounded px-4 py-2" />
                </label>

                <label class="block mb-6">
                    <span class="block font-semibold mb-1">Address</span>
                    <textarea name="address" rows="3" class="w-full border border-gray-300 rounded px-4 py-2"><?= htmlspecialchars($customer['address']) ?></textarea>
                </label>

                <div class="flex justify-between">
                    <a href="customers.php" class="text-gray-600 hover:underline">← Cancel</a>
                    <button type="submit" class="bg-red-700 text-white px-6 py-2 rounded hover:bg-red-800">Update</button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>

<?php $conn->close(); ?>
