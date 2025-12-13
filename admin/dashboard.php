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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Quản Trị - FlowerGiftNow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../assets/css/modern-design.css">
    <style>
        :root {
            --primary: #EC4899;
            --primary-dark: #DB2777;
            --primary-light: #F472B6;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 50%, #FBCFE8 100%);
            min-height: 100vh;
        }
        .page-header{
            /* nền đẹp */
            background-color: #ffffffff;
            padding: 16px;
            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
            border-radius: var(--radius-md);
        }
        .page-header h1 {
            font-size: 2.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.1rem;
        }
        .stat-card {
            background: white;
            border-radius: var(--radius-xl);
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(236, 72, 153, 0.1);
            border: 1px solid rgba(236, 72, 153, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(236, 72, 153, 0.2);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        .stat-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="page-header" style="text-align: center; margin-bottom: 3rem;">
        <h1 class="d-flex justify-content-center align-item-center gap-3">
            <img src="../assets/images/icons/dashboard.png" width="50" alt=""> DASHBOARD
        </h1>
        <p style="color: var(--text-secondary); font-size: 1.125rem; margin: 0; font-weight: 700;">Tổng quan hoạt động kinh doanh</p>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 mb-3">
            <div class="stat-card">
                <div class="stat-icon" style=" color: var(--primary);">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>
                <div class="stat-value" style="color: var(--text-primary);">
                    <?= number_format($summary['total_orders'] ?? 0, 0, ',', '.') ?>
                </div>
                <div class="stat-label">Tổng đơn hàng</div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--success-light); color: var(--success);">
                    <i class="zmdi zmdi-money-box"></i>
                </div>
                <div class="stat-value" style="color: var(--text-primary);">
                    <?= number_format($summary['total_revenue'] ?? 0, 0, ',', '.') ?>₫
                </div>
                <div class="stat-label">Tổng doanh thu</div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--info-light); color: var(--info);">
                    <i class="zmdi zmdi-balance-wallet"></i>
                </div>
                <div class="stat-value" style="color: var(--text-primary);">
                    <?= number_format($summary['avg_order_value'] ?? 0, 0, ',', '.') ?>₫
                </div>
                <div class="stat-label">Giá trị đơn trung bình</div>
            </div>
        </div>
    </div>

    <!-- Daily Revenue Table -->
    <div class="card-modern" style="padding: 2rem; margin-bottom: 2rem;">
        <h5 style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="zmdi zmdi-trending-up" style="color: var(--primary);"></i>
            Doanh thu 7 ngày gần nhất
        </h5>
        <?php if (!empty($daily)): ?>
            <div class="table-responsive">
                <table class="table align-middle" style="margin-bottom: 0;">
                    <thead style="background: var(--gray-100); border-bottom: 2px solid var(--gray-600);">
                        <tr>
                            <th style="padding: 1rem; font-weight: 600; color: var(--gray-400);">Ngày</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--gray-400);">Số đơn</th>
                            <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--gray-400);">Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($daily as $d): ?>
                        <tr style="border-bottom: 1px solid var(--gray-300);">
                            <td style="padding: 1rem; display: flex; align-items: center; gap: 0.5rem; border: none; font-weight: 800; color: var(--text-primary);">
                                <i class="zmdi zmdi-calendar" style="color: var(--text-secondary);"></i>
                                <?= date('d/m/Y', strtotime($d['day'])) ?>
                            </td>
                            <td style="padding: 1rem; text-align: center;">
                                <span class="badge-modern badge-primary"><?= $d['orders_count'] ?></span>
                            </td>
                            <td style="padding: 1rem; text-align: right; font-weight: 700; color: var(--success);">
                                <?= number_format($d['revenue'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem 2rem; color: var(--text-secondary);">
                <i class="zmdi zmdi-chart" style="font-size: 3rem; opacity: 0.3; margin-bottom: 1rem;"></i>
                <p style="margin: 0;">Chưa có dữ liệu doanh thu trong 7 ngày gần nhất</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Top Products -->
    <div class="card-modern" style="padding: 2rem; margin-bottom: 2rem;">
        <h5 style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <i class="zmdi zmdi-fire" style="color: var(--danger);"></i>
            Top 5 Sản phẩm bán chạy
        </h5>
        <?php if (!empty($top_products)): ?>
            <div class="table-responsive">
                <table class="table align-middle" style="margin-bottom: 0;">
                    <thead style="background: var(--gray-100); border-bottom: 2px solid var(--gray-200);">
                        <tr>
                            <th style="padding: 1rem; font-weight: 600; color: var(--gray-400);">Sản phẩm</th>
                            <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--gray-400);">Đã bán</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($top_products as $p): ?>
                        <tr style="border-bottom: 1px solid var(--gray-300);">
                            <td style="padding: 1rem; font-weight: 500; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem; border: none; font-weight: 800; ">
                                <i class="zmdi zmdi-flower-alt" style="color: var(--primary);"></i>
                                <?= htmlspecialchars($p['name']) ?>
                            </td>
                            <td style="padding: 1rem; text-align: right;">
                                <span class="badge-modern badge-success" style="font-size: 0.875rem;">
                                    <?= $p['total_sold'] ?> sản phẩm
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem 2rem; color: var(--text-secondary);">
                <i class="zmdi zmdi-shopping-basket" style="font-size: 3rem; opacity: 0.3; margin-bottom: 1rem;"></i>
                <p style="margin: 0;">Chưa có sản phẩm nào được bán</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Coupon Usage -->
    <div class="card-modern" style="padding: 2rem;">
        <h5 style="font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
            <img src="../assets/images/icons/tap.png" alt="Coupon Icon" width="20" height="20" >
            Tần suất sử dụng mã khuyến mãi
        </h5>
        <?php if (!empty($coupon_usage)): ?>
            <div class="table-responsive">
                <table class="table align-middle" style="margin-bottom: 0;">
                    <thead style="background: var(--gray-100); border-bottom: 2px solid var(--gray-200);">
                        <tr>
                            <th style="padding: 1rem; font-weight: 600; color: var(--gray-400);">Mã khuyến mãi</th>
                            <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--gray-400);">Lần sử dụng</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($coupon_usage as $c): ?>
                        <tr style="border-bottom: 1px solid var(--gray-200);">
                            <td style="padding: 1rem;">
                                <span class="badge-modern badge-warning" style="font-size: 0.875rem; font-family: 'Courier New', monospace; ">
                                    <?= htmlspecialchars($c['code']) ?>
                                </span>
                            </td>
                            <td style="padding: 1rem; text-align: right; font-weight: 600; color: var(--text-primary);">
                                <?= $c['used_count'] ?> lần
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem 2rem; color: var(--text-secondary);">
                <i class="zmdi zmdi-card-giftcard" style="font-size: 3rem; opacity: 0.3; margin-bottom: 1rem;"></i>
                <p style="margin: 0;">Chưa có mã khuyến mãi nào được tạo</p>
            </div>
        <?php endif; ?>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
