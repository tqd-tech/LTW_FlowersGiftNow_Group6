<?php
// coupons.php
// Quản lý mã khuyến mãi (hiển thị danh sách, cho sửa/xóa)

require_once 'config.php';

// Lấy danh sách mã khuyến mãi
$coupons = $pdo->query("SELECT * FROM coupons ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách mã khuyến mãi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Danh sách mã khuyến mãi</h1>
    <a href="add_coupon.php" class="btn btn-success mb-3">Thêm mã khuyến mãi</a>
    <table class="table table-striped table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Mã</th>
                <th>Chiết khấu (%)</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($coupons as $coupon): ?>
            <tr>
                <td><?= $coupon['id'] ?></td>
                <td><?= htmlspecialchars($coupon['code']) ?></td>
                <td><?= $coupon['discount_percent'] ?>%</td>
                <td><?= $coupon['start_date'] ?></td>
                <td><?= $coupon['end_date'] ?></td>
                <td>
                    <a href="edit_coupon.php?id=<?= $coupon['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="delete_coupon.php?id=<?= $coupon['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>