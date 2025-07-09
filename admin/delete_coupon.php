<?php
// delete_coupon.php
require_once '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM coupons WHERE id = ?");
    $stmt->execute([$id]);
}
header('Location: coupons.php');
exit;
