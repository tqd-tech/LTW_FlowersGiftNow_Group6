<?php
$host = '127.0.0.1';
$db   = 'flower_shop';
$user = 'root';
$pass = ''; // Nếu XAMPP mặc định

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}
?>
