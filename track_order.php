<?php
require 'includes/db.php';

$order = null;
$statusBadge = 'light';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? null;

    if ($order_id) {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch();

        if ($order) {
            $status = $order['status'];
            $statusBadge = match($status) {
                'pending' => 'secondary',
                'processing' => 'warning',
                'completed' => 'success',
                'cancelled' => 'danger',
                default => 'light'
            };
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tra cứu đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="bg-white p-5 rounded shadow-sm">
        <h2 class="text-center text-primary mb-4">🔍 Tra cứu đơn hàng</h2>

        <!-- Form tra cứu -->
        <form method="post" class="mb-4 mx-auto" style="max-width: 500px;">
            <div class="input-group input-group-lg">
                <input type="number" name="order_id" class="form-control" placeholder="Nhập mã đơn hàng (VD: 123)" required autofocus>
                <button type="submit" class="btn btn-primary">Tra cứu</button>
            </div>
        </form>

        <!-- Kết quả -->
        <?php if ($order): ?>
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success">✅ Đơn hàng #<?= $order['id'] ?></h5>
                    <p><strong>Người nhận:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                    <p><strong>SĐT:</strong> <?= htmlspecialchars($order['customer_phone']) ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['customer_address']) ?></p>
                    <p><strong>Trạng thái:</strong> 
                        <span class="badge bg-<?= $statusBadge ?>"><?= ucfirst($order['status']) ?></span>
                    </p>
                    <p><strong>Tổng tiền:</strong> <?= number_format($order['total_price'], 0, ',', '.') ?> VND</p>
                    <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
                    <a href="order_detail.php?id=<?= $order['id'] ?>" class="btn btn-outline-primary btn-sm">
                        📄 Xem chi tiết đơn hàng
                    </a>
                </div>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="alert alert-warning text-center">
                ❌ Không tìm thấy đơn hàng với mã <strong>#<?= htmlspecialchars($_POST['order_id']) ?></strong>.
            </div>
        <?php endif; ?>

        <!-- Quay lại -->
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">
                ← Quay lại trang chủ
            </a>
        </div>
    </div>
</div>
</body>
</html>
