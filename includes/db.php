<?php
// $host = 'sql305.infinityfree.com';
// $db   = 'if0_39416227_flower_shop';
// $user = 'if0_39416227';
// $pass = 'le0GhQVuTo7vpvR'; 

$host = '127.0.0.1';      // hoặc 'localhost'
$db   = 'if0_39416227_flower_shop';    
$user = 'root';           // mặc định XAMPP là 'root'
$pass = '';               // mặc định XAMPP password trống
$charset = 'utf8mb4';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}
?>
