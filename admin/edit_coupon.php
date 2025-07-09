<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/login.php');
    exit;
}
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo 'Thiếu ID mã khuyến mãi!';
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM coupons WHERE id = ?');
$stmt->execute([$id]);
$coupon = $stmt->fetch();
if (!$coupon) {
    echo 'Không tìm thấy mã khuyến mãi!';
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');
    $discount = (int)($_POST['discount_percent'] ?? 0);
    $start = $_POST['start_date'] ?? '';
    $end = $_POST['end_date'] ?? '';
    if (!$code || !$discount || !$start || !$end) {
        $error = 'Vui lòng nhập đầy đủ thông tin.';
    } else {
        $stmt = $pdo->prepare('UPDATE coupons SET code=?, discount_percent=?, start_date=?, end_date=? WHERE id=?');
        $stmt->execute([$code, $discount, $start, $end, $id]);
        header('Location: coupons.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa mã khuyến mãi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Sửa mã khuyến mãi</h1>
    <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Mã khuyến mãi</label>
            <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($coupon['code']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Chiết khấu (%)</label>
            <input type="number" name="discount_percent" class="form-control" min="1" max="100" value="<?= $coupon['discount_percent'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="date" name="start_date" class="form-control" value="<?= $coupon['start_date'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ngày kết thúc</label>
            <input type="date" name="end_date" class="form-control" value="<?= $coupon['end_date'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="coupons.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
