<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/login.php');
    exit;
}
require_once '../includes/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');
    $discount = (int)($_POST['discount_percent'] ?? 0);
    $start = $_POST['start_date'] ?? '';
    $end = $_POST['end_date'] ?? '';
    if (!$code || !$discount || !$start || !$end) {
        $error = 'Vui lòng nhập đầy đủ thông tin.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO coupons (code, discount_percent, start_date, end_date) VALUES (?, ?, ?, ?)');
        $stmt->execute([$code, $discount, $start, $end]);
        header('Location: coupons.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm mã khuyến mãi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
    <h1 class="mb-4">Thêm mã khuyến mãi</h1>
            <button class="btn btn-secondary mb-3" onclick="window.location.href='../index.php'">Về trang chủ</button>
</div>
    <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Mã khuyến mãi</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Chiết khấu (%)</label>
            <input type="number" name="discount_percent" class="form-control" min="1" max="100" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm mã</button>
        <a href="coupons.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
