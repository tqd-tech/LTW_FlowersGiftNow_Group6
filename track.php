<?php
session_start();
require 'includes/db.php';

$order_id = $_SESSION['last_order_id'] ?? null;

if (!$order_id) {
    echo "<div class='container mt-5'><h3>Không tìm thấy đơn hàng gần đây!</h3><a href='index.php' class='btn btn-primary mt-3'>Quay lại mua sắm</a></div>";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

$stmt = $pdo->prepare("
    SELECT p.name, oi.quantity, oi.price 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();

$status = $order['status'] ?? 'pending';
$statusBadge = match($status) {
    'pending' => 'secondary',
    'processing' => 'warning',
    'completed' => 'success',
    'cancelled' => 'danger',
    default => 'light text-dark'
};
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng #<?= $order_id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="bg-white p-4 rounded shadow-sm">
        <h2 class="mb-4 text-center text-primary">🧾 Chi tiết đơn hàng</h2>

        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Mã đơn hàng:</strong> #<?= $order_id ?></p>
                <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
                <p><strong>Trạng thái:</strong> <span class="badge bg-<?= $statusBadge ?>"><?= ucfirst($status) ?></span></p>
            </div>
            <div class="col-md-6">
                <p><strong>Người nhận:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                <p><strong>Điện thoại:</strong> <?= htmlspecialchars($order['customer_phone']) ?></p>
                <p><strong>Địa chỉ:</strong> <?= nl2br(htmlspecialchars($order['customer_address'])) ?></p>
            </div>
        </div>

        <h5 class="mb-3">📦 Danh sách sản phẩm:</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Đơn giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $subtotal = 0;
                    foreach ($items as $item): 
                        $lineTotal = $item['quantity'] * $item['price'];
                        $subtotal += $lineTotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                        <td><?= number_format($lineTotal, 0, ',', '.') ?> VND</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

                <?php
                    $shipping = ($subtotal >= 500000) ? 0 : 30000;
                    $total = $subtotal + $shipping;
                ?>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Tạm tính:</td>
                        <td><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Phí vận chuyển:</td>
                        <td>
                            <?= $shipping == 0 ? '<span class="text-success">Miễn phí</span>' : number_format($shipping, 0, ',', '.') . ' VND' ?>
                        </td>
                    </tr>
                    <tr class="table-info">
                        <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                        <td class="text-danger fw-bold"><?= number_format($total, 0, ',', '.') ?> VND</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    </div>
</div>

</body>
</html>
