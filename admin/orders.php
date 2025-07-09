<?php
// orders.php
// Quản lý đơn hàng cho trang admin: hiển thị và cập nhật trạng thái

require_once '../includes/db.php';

// Xử lý cập nhật trạng thái đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderId = (int)$_POST['order_id'];
    $newStatus = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE orders SET status = :status WHERE id = :id");
    $stmt->execute(['status' => $newStatus, 'id' => $orderId]);
    header('Location: orders.php');
    exit;
}

// Lấy danh sách đơn hàng
$orders = $pdo->query("SELECT o.*, c.code AS coupon_code FROM orders o LEFT JOIN coupons c ON o.coupon_id = c.id ORDER BY o.order_date DESC")->fetchAll(PDO::FETCH_ASSOC);

// Lấy danh sách sản phẩm trong đơn
$order_items_map = [];
$items_stmt = $pdo->query("SELECT oi.*, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id");
foreach ($items_stmt as $item) {
    $order_items_map[$item['order_id']][] = $item;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đơn hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
    <h1 class="mb-4">Danh sách đơn hàng</h1>
        <button class="btn btn-secondary mb-3" onclick="window.location.href='../index.php'">Về trang chủ</button>
</div>
    <table class="table table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Số điện thoại</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Mã KM</th>
                <th>Chi tiết</th>
                <th>Tổng</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= htmlspecialchars($order['customer_name']) ?></td>
                <td><?= $order['customer_phone'] ?></td>
                <td><?= $order['order_date'] ?></td>
                <td>
                    <form method="post" class="d-flex">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <select name="status" class="form-select form-select-sm me-1">
                            <?php foreach (['pending','processing','completed','cancelled'] as $st): ?>
                                <option value="<?= $st ?>" <?= $order['status']===$st?'selected':'' ?>><?= ucfirst($st) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-sm btn-primary w-100">Cập nhật</button>
                    </form>
                </td>
                <td><?= $order['coupon_code'] ?? '---' ?></td>
                <td>
                    <?php if (isset($order_items_map[$order['id']])): ?>
                        <ul class="mb-0">
                            <?php foreach ($order_items_map[$order['id']] as $item): ?>
                                <li><?= htmlspecialchars($item['name']) ?> x <?= $item['quantity'] ?> (<?= number_format($item['price'], 0, ',', '.') ?> Đ)</li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        ---
                    <?php endif; ?>
                </td>
                <td><?= number_format($order['total_price'], 0, ',', '.') ?> Đ</td>
                <td>
                    <?php if ($order['status'] !== 'cancelled' && $order['status'] !== 'completed'): ?>
                    <form method="post" onsubmit="return confirm('Xác nhận hủy đơn?');">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" name="update_status" class="btn btn-sm btn-danger">Hủy</button>
                    </form>
                    <?php else: ?>
                        <span class="text-muted">Không thể hủy</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>