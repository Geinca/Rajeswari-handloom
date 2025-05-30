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

// Get product ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get image filename before deleting the product
$stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($image);
$stmt->fetch();
$stmt->close();

// Delete product
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();

// Delete the image file (optional)
if ($image && file_exists("../uploads/" . $image)) {
    unlink("../uploads/" . $image);
}

// Redirect back to products page
header("Location: products.php");
exit();
