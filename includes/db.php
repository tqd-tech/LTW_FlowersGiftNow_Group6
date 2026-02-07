<?php


$host = '127.0.0.1';      // hoặc 'localhost'
$db   = 'if0_39978038_flowersgiftnow';    
$user = 'tqd0105';           // mặc định XAMPP là 'root'
$pass = '171512';               // mặc định XAMPP password trống
$charset = 'utf8mb4';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Lỗi kết nối: " . $e->getMessage());
}
?>
