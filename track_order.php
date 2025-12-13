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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tra cứu đơn hàng - FlowerGiftNow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/modern-design.css">
    <style>
        body {
            background: var(--bg-secondary);
            font-family: 'Inter', sans-serif;
        }
        .search-card {
            max-width: 600px;
            margin: 0 auto;
        }
        .search-input {
            padding: 1rem 1.5rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
        }
        .search-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .info-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: var(--radius-lg);
            margin-bottom: 0.75rem;
        }
        .info-icon {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .info-icon i {
            font-size: 1.5rem;
            color: var(--primary);
        }
        .info-content {
            flex: 1;
        }
        .info-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .info-value {
            font-size: 1rem;
            color: var(--text-primary);
            font-weight: 600;
        }
        .status-card {
            background: linear-gradient(135deg, var(--primary) 0%, #5b5fc7 100%);
            color: white;
            padding: 2rem;
            border-radius: var(--radius-xl);
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .status-icon-large {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <h2 style="font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.5rem;">
            <i class="zmdi zmdi-search"></i> Tra cứu đơn hàng
        </h2>
        <p style="color: var(--text-secondary);">Nhập mã đơn hàng để kiểm tra trạng thái</p>
    </div>

    <!-- Form tra cứu -->
    <div class="search-card card-modern" style="padding: 2rem; margin-bottom: 2rem;">
        <form method="post">
            <div style="margin-bottom: 1rem;">
                <label for="order_id" style="display: block; font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem;">
                    <i class="zmdi zmdi-label"></i> Mã đơn hàng
                </label>
                <input type="number" 
                       id="order_id" 
                       name="order_id" 
                       class="search-input" 
                       placeholder="Ví dụ: 123" 
                       required 
                       autofocus
                       value="<?= isset($_POST['order_id']) ? htmlspecialchars($_POST['order_id']) : '' ?>">
            </div>
            <button type="submit" class="btn-modern btn-primary btn-lg" style="width: 100%;">
                <i class="zmdi zmdi-search"></i> Tra cứu đơn hàng
            </button>
        </form>
    </div>

    <!-- Kết quả -->
    <?php if ($order): ?>
        <?php
        $status_text = '';
        $status_badge = '';
        $status_icon = '';
        switch ($order['status']) {
            case 'pending':
                $status_badge = 'badge-warning';
                $status_text = 'Chờ xử lý';
                $status_icon = 'zmdi-time';
                break;
            case 'processing':
                $status_badge = 'badge-info';
                $status_text = 'Đang xử lý';
                $status_icon = 'zmdi-refresh';
                break;
            case 'completed':
                $status_badge = 'badge-success';
                $status_text = 'Hoàn thành';
                $status_icon = 'zmdi-check-circle';
                break;
            case 'cancelled':
                $status_badge = 'badge-danger';
                $status_text = 'Đã hủy';
                $status_icon = 'zmdi-close-circle';
                break;
            default:
                $status_badge = 'badge-secondary';
                $status_text = ucfirst($order['status']);
                $status_icon = 'zmdi-circle';
        }
        ?>
        
        <div style="max-width: 800px; margin: 0 auto;">
            <!-- Trạng thái nổi bật -->
            <div class="status-card">
                <i class="zmdi <?= $status_icon ?> status-icon-large"></i>
                <h3 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">
                    Đơn hàng #<?= $order['id'] ?>
                </h3>
                <div style="font-size: 1.25rem; font-weight: 600;">
                    <?= $status_text ?>
                </div>
            </div>

            <!-- Thông tin chi tiết -->
            <div class="card-modern" style="padding: 2rem;">
                <h5 style="font-weight: 700; color: var(--text-primary); margin-bottom: 1.5rem; font-size: 1.25rem;">
                    <i class="zmdi zmdi-info"></i> Thông tin đơn hàng
                </h5>

                <div class="info-row">
                    <div class="info-icon">
                        <i class="zmdi zmdi-account"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Người nhận</div>
                        <div class="info-value"><?= htmlspecialchars($order['customer_name']) ?></div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">
                        <i class="zmdi zmdi-phone"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Số điện thoại</div>
                        <div class="info-value"><?= htmlspecialchars($order['customer_phone']) ?></div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">
                        <i class="zmdi zmdi-pin"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Địa chỉ giao hàng</div>
                        <div class="info-value"><?= htmlspecialchars($order['customer_address']) ?></div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">
                        <i class="zmdi zmdi-calendar"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Ngày đặt hàng</div>
                        <div class="info-value"><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></div>
                    </div>
                </div>

                <div class="info-row" style="background: var(--primary); color: white;">
                    <div class="info-icon" style="background: white;">
                        <i class="zmdi zmdi-money"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label" style="color: rgba(255,255,255,0.8);">Tổng tiền</div>
                        <div class="info-value" style="color: white; font-size: 1.5rem;">
                            <?= number_format($order['total_price'], 0, ',', '.') ?>₫
                        </div>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="order_detail.php?id=<?= $order['id'] ?>" class="btn-modern btn-primary">
                        <i class="zmdi zmdi-file-text"></i> Xem chi tiết đơn hàng
                    </a>
                    <a href="track_order.php" class="btn-modern btn-ghost">
                        <i class="zmdi zmdi-search"></i> Tra cứu đơn khác
                    </a>
                </div>
            </div>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div style="max-width: 600px; margin: 0 auto;">
            <div class="alert-modern alert-danger" style="text-align: center;">
                <i class="zmdi zmdi-alert-circle" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                <h5 style="font-weight: 700; margin-bottom: 0.5rem;">Không tìm thấy đơn hàng</h5>
                <p style="margin-bottom: 0;">
                    Không tìm thấy đơn hàng với mã <strong>#<?= htmlspecialchars($_POST['order_id']) ?></strong>
                </p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Quay lại -->
    <div style="text-align: center; margin-top: 2rem;">
        <a href="index.php" class="btn-modern btn-ghost">
            <i class="zmdi zmdi-arrow-left"></i> Quay lại trang chủ
        </a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
