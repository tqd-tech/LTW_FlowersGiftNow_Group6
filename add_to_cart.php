<?php
session_start();

$id = $_GET['id'] ?? null;

if ($id) {
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header('Location: cart.php');
    exit;
} else {
    echo "Thiếu ID sản phẩm!";
}
