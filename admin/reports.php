<?php
// report.php
// Báo cáo tổng quan cho admin

require_once '../includes/db.php';

// Tổng doanh thu và đơn hàng
$summary = $pdo->query("SELECT COUNT(*) AS total_orders, SUM(total_price) AS total_revenue FROM orders")->fetch(PDO::FETCH_ASSOC);

// Doanh thu theo ngày
$daily = $pdo->query("SELECT DATE(order_date) AS day, COUNT(*) AS orders_count, SUM(total_price) AS revenue FROM orders GROUP BY day ORDER BY day DESC LIMIT 10")->fetchAll(PDO::FETCH_ASSOC);

// Sản phẩm bán chạy
$top_products = $pdo->query("SELECT p.name, SUM(oi.quantity) AS total_sold FROM order_items oi JOIN products p ON oi.product_id = p.id GROUP BY p.id ORDER BY total_sold DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

// Mã khuyến mãi được dùng
$used_coupons = $pdo->query("SELECT c.code, COUNT(o.id) AS usage_count FROM coupons c LEFT JOIN orders o ON o.coupon_id = c.id GROUP BY c.id ORDER BY usage_count DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo tổng quan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Báo cáo tổng quan</h1>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-body">
                    <h5 class="card-title">Tổng số đơn hàng</h5>
                    <p class="display-6"><?= $summary['total_orders'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-success">
                <div class="card-body">
                    <h5 class="card-title">Tổng doanh thu</h5>
                    <p class="display-6"><?= number_format($summary['total_revenue'], 0, ',', '.') ?> Đ</p>
                </div>
            </div>
        </div>
    </div>

    <h4>Doanh thu theo ngày (10 ngày gần nhất)</h4>
    <table class="table table-bordered">
        <thead><tr><th>Ngày</th><th>Số đơn</th><th>Doanh thu (Đ)</th></tr></thead>
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

    <h4 class="mt-5">Top 5 sản phẩm bán chạy</h4>
    <table class="table table-striped">
        <thead><tr><th>Tên sản phẩm</th><th>Số lượng bán</th></tr></thead>
        <tbody>
        <?php foreach ($top_products as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['name']) ?></td>
                <td><?= $p['total_sold'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h4 class="mt-5">Tần suất sử dụng mã khuyến mãi</h4>
    <table class="table table-hover">
        <thead><tr><th>Mã</th><th>Số lần sử dụng</th></tr></thead>
        <tbody>
        <?php foreach ($used_coupons as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['code']) ?></td>
                <td><?= $c['usage_count'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
