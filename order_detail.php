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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết đơn hàng #<?= $order_id ?> - FlowerGiftNow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/modern-design.css">
    <style>
        :root {
            --primary: #EC4899;
            --primary-dark: #DB2777;
            --primary-light: #F472B6;
        }
        body { 
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 50%, #FBCFE8 100%); 
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        .order-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            border-radius: var(--radius-xl);
            text-align: center;
            margin-bottom: 2rem;
        }
        .card-modern {
            box-shadow: 0 4px 20px rgba(236, 72, 153, 0.1);
            border: 1px solid rgba(236, 72, 153, 0.1);
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .info-item {
            background: var(--gray-50);
            padding: 1.25rem;
            border-radius: var(--radius-lg);
            border-left: 4px solid var(--primary);
        }
        .info-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .info-value {
            font-size: 1rem;
            color: var(--text-primary);
            font-weight: 600;
        }
        .product-table { background: white; border-radius: var(--radius-xl); overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .product-table thead { background: var(--gray-800); color: white; }
        .product-table th { padding: 1rem; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; border: none; }
        .product-table td { padding: 1rem; vertical-align: middle; border-bottom: 1px solid var(--gray-100); }
        .product-table tfoot td { background: var(--gray-50); font-weight: 600; border: none; padding: 1rem; }
        .total-row td { background: var(--primary) !important; color: white !important; font-size: 1.1rem; }
    </style>
</head>
<body>

<div class="container py-5">
    <?php
    $status_badge = '';
    $status_text = '';
    $status_icon = '';
    switch ($order['status']) {
        case 'pending': $status_badge = 'badge-warning'; $status_text = 'Chờ xử lý'; $status_icon = 'zmdi-time'; break;
        case 'processing': $status_badge = 'badge-info'; $status_text = 'Đang xử lý'; $status_icon = 'zmdi-refresh'; break;
        case 'completed': $status_badge = 'badge-success'; $status_text = 'Hoàn thành'; $status_icon = 'zmdi-check-circle'; break;
        case 'cancelled': $status_badge = 'badge-danger'; $status_text = 'Đã hủy'; $status_icon = 'zmdi-close-circle'; break;
        default: $status_badge = 'badge-secondary'; $status_text = ucfirst($order['status']); $status_icon = 'zmdi-circle';
    }
    ?>

    <!-- Header -->
    <div class="order-header">
        <i class="zmdi zmdi-receipt" style="font-size: 3rem; margin-bottom: 1rem;"></i>
        <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.75rem;">
            Đơn hàng #<?= $order_id ?>
        </h2>
        <span class="badge-modern <?= $status_badge ?>" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
            <i class="zmdi <?= $status_icon ?>"></i> <?= $status_text ?>
        </span>
    </div>

    <div style="max-width: 900px; margin: 0 auto;">
        <!-- Thông tin khách hàng -->
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label"><i class="zmdi zmdi-calendar"></i> Ngày đặt</div>
                <div class="info-value"><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="zmdi zmdi-account"></i> Người nhận</div>
                <div class="info-value"><?= htmlspecialchars($order['customer_name']) ?></div>
            </div>
            <div class="info-item">
                <div class="info-label"><i class="zmdi zmdi-phone"></i> Số điện thoại</div>
                <div class="info-value"><?= htmlspecialchars($order['customer_phone']) ?></div>
            </div>
            <div class="info-item" style="grid-column: 1 / -1;">
                <div class="info-label"><i class="zmdi zmdi-pin"></i> Địa chỉ giao hàng</div>
                <div class="info-value"><?= nl2br(htmlspecialchars($order['customer_address'])) ?></div>
            </div>
        </div>

        <!-- Bảng sản phẩm -->
        <div class="card-modern" style="padding: 1.5rem;">
            <h5 style="font-weight: 700; color: var(--text-primary); margin-bottom: 1.5rem;">
                <i class="zmdi zmdi-shopping-basket"></i> Chi tiết sản phẩm
            </h5>
            
            <div class="table-responsive product-table">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th style="text-align: center;">Số lượng</th>
                            <th style="text-align: right;">Đơn giá</th>
                            <th style="text-align: right;">Thành tiền</th>
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
                            <td style="font-weight: 600; color: var(--text-primary);"><?= htmlspecialchars($item['name']) ?></td>
                            <td style="text-align: center;"><span class="badge-modern badge-primary"><?= $item['quantity'] ?></span></td>
                            <td style="text-align: right; color: var(--text-secondary);"><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                            <td style="text-align: right; font-weight: 700; color: var(--primary);"><?= number_format($lineTotal, 0, ',', '.') ?>₫</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <?php $shipping = ($order['total_price'] > $subtotal) ? $order['total_price'] - $subtotal : 0; ?>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right;">Tạm tính:</td>
                            <td style="text-align: right;"><?= number_format($subtotal, 0, ',', '.') ?>₫</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: right;">Phí vận chuyển:</td>
                            <td style="text-align: right;"><?= $shipping == 0 ? '<span style="color: var(--success);">Miễn phí</span>' : number_format($shipping, 0, ',', '.') . '₫' ?></td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right;">Tổng cộng:</td>
                            <td style="text-align: right;"><?= number_format($order['total_price'], 0, ',', '.') ?>₫</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Navigation -->
        <div style="display: flex; gap: 1rem; margin-top: 2rem; justify-content: center; flex-wrap: wrap;">
            <a href="track_order.php" class="btn-modern btn-ghost">
                <i class="zmdi zmdi-arrow-left"></i> Quay lại tra cứu
            </a>
            <a href="index.php" class="btn-modern btn-ghost">
                <i class="zmdi zmdi-home"></i> Trang chủ
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
