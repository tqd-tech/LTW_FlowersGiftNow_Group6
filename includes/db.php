<?php
$host = 'sql305.infinityfree.com';
$db   = 'if0_39416227_flower_shop';
$user = 'if0_39416227';
$pass = 'le0GhQVuTo7vpvR'; // Nếu XAMPP mặc định

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}
?>
