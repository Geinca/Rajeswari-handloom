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

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT * FROM customers WHERE name LIKE '%$search%' OR email LIKE '%$search%' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Customers - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body class="bg-gray-100 min-h-screen flex">

<?php include 'sidebar.php'; ?>

    <main class="flex-1 p-8">
        <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow">
            <h2 class="text-2xl font-bold text-red-800 mb-6">Customers</h2>

            <form method="GET" class="mb-6">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search by name or email..." 
                    value="<?= htmlspecialchars($search) ?>" 
                    class="border border-gray-300 rounded px-3 py-2 w-64"
                />
                <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded ml-2 hover:bg-red-800">
                    Search
                </button>
                <a href="customers.php" class="ml-4 text-gray-600 hover:underline">Reset</a>
            </form>

            <table class="w-full border-collapse border border-gray-300 text-left">
                <thead>
                    <tr class="bg-red-100">
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Phone</th>
                        <th class="border border-gray-300 px-4 py-2">Address</th>
                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>!
                            <tr>
                                <td class="border border-gray-300 px-4 py-2"><?= $row['id'] ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['name']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['email']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['phone']) ?></td>
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['address']) ?></td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="customer/edit-customer.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:underline">Edit</a>
                                    <a href="delete-customer.php?id=<?= $row['id'] ?>" class="text-red-600 hover:underline ml-4" onclick="return confirm('Delete this customer?')">Delete</a>
                                    <a href="view-customer.php?id=<?= $row['id'] ?>" class="text-green-600 hover:underline ml-4">View</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">No customers found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </main>

</body>
</html>

<?php
$conn->close();
?>
