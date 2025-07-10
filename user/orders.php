<?php
session_start();
require '../includes/db.php';

// Xử lý xoá đơn hàng (chỉ cho phép user xoá đơn của mình, chưa completed/cancelled)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order'])) {
    $order_id = (int)$_POST['order_id'];
    $user_id = $_SESSION['user_id'] ?? null;
    if ($user_id && $order_id) {
        // Kiểm tra quyền xoá
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ? AND user_id = ? AND status NOT IN ("completed","cancelled")');
        $stmt->execute([$order_id, $user_id]);
        if ($stmt->fetch()) {
            // Xoá order_items trước
            $pdo->prepare('DELETE FROM order_items WHERE order_id = ?')->execute([$order_id]);
            // Xoá order
            $pdo->prepare('DELETE FROM orders WHERE id = ?')->execute([$order_id]);
        }
    }
    header('Location: orders.php');
    exit;
}

// Nếu có đăng nhập, lấy user_id từ session
$user_id = $_SESSION['user_id'] ?? null;
// Nếu chưa đăng nhập, cho phép tra cứu bằng số điện thoại
$phone = $_GET['phone'] ?? '';

$where = [];
$params = [];
if ($user_id) {
    $where[] = 'user_id = ?';
    $params[] = $user_id;
} elseif ($phone) {
    $where[] = 'customer_phone = ?';
    $params[] = $phone;
}

$sql = 'SELECT * FROM orders';
if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
$sql .= ' ORDER BY order_date DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll();

function getOrderItems($pdo, $order_id) {
    $stmt = $pdo->prepare('SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?');
    $stmt->execute([$order_id]);
    return $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng đã mua</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4 text-primary text-center">
        <?php if (!$user_id): ?>Tra cứu đơn hàng<?php else: ?>🧾 Đơn hàng đã mua<?php endif; ?>
    </h2>
    <?php if (!$user_id): ?>
    <form class="mb-4" method="get">
        <div class="row g-2 justify-content-center">
            <div class="col-auto">
                <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại để tra cứu" value="<?= htmlspecialchars($phone) ?>" required>
            </div>
            <div class="col-auto">
                <button class="btn btn-success">Tra cứu</button>
            </div>
        </div>
    </form>
    <?php endif; ?>

    <?php if (($user_id || $phone) && $orders): ?>
        <?php foreach ($orders as $order): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Mã đơn: <b>#<?= $order['id'] ?></b></span>
                        <span>Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></span>
                        <span>Trạng thái: <span class="badge bg-warning text-dark"><?= ucfirst($order['status']) ?></span></span>
                    </div>
                </div>
                <div class="card-body">
                    <div><b>Người nhận:</b> <?= htmlspecialchars($order['customer_name'] ?? '') ?> | <b>ĐT:</b> <?= htmlspecialchars($order['customer_phone'] ?? '') ?> | <b>Địa chỉ:</b> <?= htmlspecialchars($order['customer_address'] ?? '') ?></div>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $items = getOrderItems($pdo, $order['id']);
                            foreach ($items as $item): ?>
                                <tr>
                                    <td><img src="../assets/images/<?= htmlspecialchars($item['image']) ?>" alt="" style="width:60px;height:60px;object-fit:cover"></td>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND</td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end fw-bold">Tổng cộng: <span class="text-danger"><?= number_format($order['total_price'], 0, ',', '.') ?> VND</span></div>
                    <?php if ($user_id && $order['user_id'] == $user_id && !in_array($order['status'], ['completed','cancelled'])): ?>
                        <div class="mt-3 d-flex gap-2 justify-content-end">
                            <a href="edit_order.php?id=<?= $order['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                            <form method="post" onsubmit="return confirm('Xác nhận xoá đơn hàng?');">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <button type="submit" name="delete_order" class="btn btn-danger btn-sm">Xoá</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php elseif (($user_id || $phone) && !$orders): ?>
        <div class="alert alert-info text-center">Không tìm thấy đơn hàng nào.</div>
    <?php endif; ?>
    <div class="text-center mt-4">
        <a href="../index.php" class="btn btn-secondary">← Quay lại trang chủ</a>
    </div>
</div>
</body>
</html>
