<?php
require 'includes/db.php';
$order_id = $_GET['id'] ?? null;

if (!$order_id) {
    echo "<div class='container mt-5 text-center'><h3>Không tìm thấy đơn hàng!</h3><a href='index.php' class='btn btn-primary mt-3'>Về trang chủ</a></div>";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    echo "<div class='container mt-5 text-center'><h3>Đơn hàng không tồn tại.</h3><a href='index.php' class='btn btn-primary mt-3'>Về trang chủ</a></div>";
    exit;
}

$stmt = $pdo->prepare("
    SELECT p.name, oi.quantity, oi.price 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();

$statusBadge = match($order['status']) {
    'pending' => 'secondary',
    'processing' => 'warning',
    'completed' => 'success',
    'cancelled' => 'danger',
    default => 'light'
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
        <h2 class="text-center text-primary mb-4">🧾 Chi tiết đơn hàng #<?= $order_id ?></h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Trạng thái:</strong> <span class="badge bg-<?= $statusBadge ?>"><?= ucfirst($order['status']) ?></span></p>
                <p><strong>Ngày đặt:</strong> <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Người nhận:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                <p><strong>SĐT:</strong> <?= htmlspecialchars($order['customer_phone']) ?></p>
                <p><strong>Địa chỉ:</strong> <?= nl2br(htmlspecialchars($order['customer_address'])) ?></p>
            </div>
        </div>

        <div class="table-responsive mt-4">
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
                    $shipping = ($order['total_price'] > $subtotal) ? $order['total_price'] - $subtotal : 0;
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
                        <td class="text-danger fw-bold"><?= number_format($order['total_price'], 0, ',', '.') ?> VND</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="track.php" class="btn btn-outline-secondary">← Quay lại tra cứu</a>
        </div>
    </div>
</div>

</body>
</html>
