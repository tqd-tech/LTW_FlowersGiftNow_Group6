<?php
// dashboard.php
// Trang tổng quan Admin cho Flower Shop

require_once '../includes/db.php';

// Lấy dữ liệu tổng quan
$summary = $pdo->query(
    "SELECT 
        COUNT(*) AS total_orders, 
        SUM(total_price) AS total_revenue, 
        AVG(total_price) AS avg_order_value 
     FROM orders"
)->fetch(PDO::FETCH_ASSOC);

// Doanh thu theo ngày (7 ngày gần nhất)
$daily = $pdo->query(
    "SELECT DATE(order_date) AS day, COUNT(*) AS orders_count, SUM(total_price) AS revenue 
     FROM orders 
     WHERE order_date >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
     GROUP BY day 
     ORDER BY day ASC"
)->fetchAll(PDO::FETCH_ASSOC);

// Top 5 sản phẩm bán chạy
$top_products = $pdo->query(
    "SELECT p.name, SUM(oi.quantity) AS total_sold 
     FROM order_items oi 
     JOIN products p ON oi.product_id = p.id 
     GROUP BY p.id 
     ORDER BY total_sold DESC 
     LIMIT 5"
)->fetchAll(PDO::FETCH_ASSOC);

// Coupon usage
$coupon_usage = $pdo->query(
    "SELECT c.code, COUNT(o.id) AS used_count 
     FROM coupons c 
     LEFT JOIN orders o ON o.coupon_id = c.id 
     GROUP BY c.id 
     ORDER BY used_count DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Quản Trị</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container py-4">
    <h1 class="mb-4">Dashboard Quản Trị</h1>

    <!-- Thẻ tổng quan -->
    <div class="row mb-4">
        <div class="col-lg-4 mb-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">Tổng đơn hàng</h5>
                    <p class="display-5"><?= number_format($summary['total_orders'], 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">Tổng doanh thu</h5>
                    <p class="display-5"><?= number_format($summary['total_revenue'], 0, ',', '.') ?> Đ</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card text-white bg-info h-100">
                <div class="card-body">
                    <h5 class="card-title">Giá trị đơn trung bình</h5>
                    <p class="display-5"><?= number_format($summary['avg_order_value'], 0, ',', '.') ?> Đ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ / Bảng doanh thu -->
    <div class="card mb-4">
        <div class="card-header">Doanh thu 7 ngày gần nhất</div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr><th>Ngày</th><th>Số đơn</th><th>Doanh thu (Đ)</th></tr>
                </thead>
                <tbody>
                <?php foreach ($daily as $d): ?>
                    <tr>
                        <td><?= $d['day'] ?></td>
                        <td><?= $d['orders_count'] ?></td>
                        <td><?= number_format($d['revenue'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div class="card mb-4">
        <div class="card-header">Top 5 Sản phẩm bán chạy</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr><th>Sản phẩm</th><th>Đã bán</th></tr>
                </thead>
                <tbody>
                <?php foreach ($top_products as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= $p['total_sold'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Coupon Usage -->
    <div class="card mb-4">
        <div class="card-header">Tần suất sử dụng mã khuyến mãi</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr><th>Mã</th><th>Lần sử dụng</th></tr>
                </thead>
                <tbody>
                <?php foreach ($coupon_usage as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['code']) ?></td>
                        <td><?= $c['used_count'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
