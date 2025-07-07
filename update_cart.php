<?php
session_start();

$id = $_POST['id'] ?? null;
$qty = $_POST['qty'] ?? null;

if ($id && is_numeric($qty) && $qty > 0) {
    $_SESSION['cart'][$id] = $qty;
}

header("Location: cart.php");
exit;
