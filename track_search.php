<?php
session_start();
require 'includes/db.php';

$order = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if ($order_id && $phone) {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND customer_phone = ?");
        $stmt->execute([$order_id, $phone]);
        $order = $stmt->fetch();

        if ($order) {
            $_SESSION['last_order_id'] = $order_id;
            header("Location: track.php");
            exit;
        } else {
            $error = "❌ Không tìm thấy đơn hàng với mã và số điện thoại đã nhập.";
        }
    } else {
        $error = "⚠️ Vui lòng nhập đầy đủ thông tin.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tra cứu đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }
        .track-box {
            max-width: 500px;
            margin: auto;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="track-box bg-white p-4 shadow-sm rounded">
        <h3 class="text-center text-primary mb-4">🔍 Tra cứu đơn hàng</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post" class="needs-validation" novalidate>
            <div class="mb-3">
                <label class="form-label">Mã đơn hàng</label>
                <input type="text" name="order_id" class="form-control" required placeholder="Nhập mã đơn hàng">
            </div>
            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" required placeholder="Nhập SĐT khi đặt hàng">
            </div>
            <button type="submit" class="btn btn-primary w-100">Tra cứu ngay</button>
        </form>

        <div class="text-center mt-3">
            <a href="index.php" class="text-decoration-none">← Quay lại trang chủ</a>
        </div>
    </div>
</div>

</body>
</html>
