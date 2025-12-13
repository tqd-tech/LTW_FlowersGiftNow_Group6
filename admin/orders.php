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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý Đơn hàng - Admin</title>
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
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 50%, #FBCFE8 100%); 
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        .page-header h2 {
            font-size: 2.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .table-modern { 
            background: white; 
            border-radius: var(--radius-xl); 
            overflow: hidden; 
            box-shadow: 0 4px 20px rgba(236, 72, 153, 0.1);
            border: 1px solid rgba(236, 72, 153, 0.1);
        }
        .table-modern thead { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; }
        .table-modern th { padding: 1rem; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; }
        .table-modern td { padding: 1rem; vertical-align: middle; border-bottom: 1px solid var(--gray-100); }
        .table-modern tbody tr:hover { background: #FDF2F8; }
        .status-select { padding: 0.5rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); font-size: 0.85rem; min-width: 130px; }
        .status-select:focus { border-color: var(--primary); outline: none; }
        .product-list { list-style: none; padding: 0; margin: 0; font-size: 0.85rem; }
        .product-list li { padding: 0.25rem 0; color: var(--text-secondary); }
        .product-list li strong { color: var(--text-primary); }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="page-header" style="text-align: center; margin-bottom: 2rem;">
        <h2>
            <i class="zmdi zmdi-assignment"></i> Quản lý Đơn hàng
        </h2>
        <p style="color: var(--text-secondary);">Theo dõi và cập nhật trạng thái đơn hàng</p>
    </div>

    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; justify-content: center;">
        <a href="dashboard.php" class="btn-modern btn-ghost"><i class="zmdi zmdi-view-dashboard"></i> Dashboard</a>
        <a href="../index.php" class="btn-modern btn-ghost"><i class="zmdi zmdi-home"></i> Trang chủ</a>
    </div>

    <?php if (empty($orders)): ?>
        <div class="card-modern" style="padding: 3rem; text-align: center;">
            <i class="zmdi zmdi-shopping-cart" style="font-size: 4rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
            <h4 style="color: var(--text-primary);">Chưa có đơn hàng nào</h4>
            <p style="color: var(--text-secondary);">Các đơn hàng mới sẽ xuất hiện tại đây</p>
        </div>
    <?php else: ?>
    <div class="table-responsive table-modern">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Sản phẩm</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th style="width: 100px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): 
                $status_badge = '';
                $status_text = '';
                switch ($order['status']) {
                    case 'pending': $status_badge = 'badge-warning'; $status_text = 'Chờ xử lý'; break;
                    case 'processing': $status_badge = 'badge-info'; $status_text = 'Đang xử lý'; break;
                    case 'completed': $status_badge = 'badge-success'; $status_text = 'Hoàn thành'; break;
                    case 'cancelled': $status_badge = 'badge-danger'; $status_text = 'Đã hủy'; break;
                    default: $status_badge = 'badge-secondary'; $status_text = ucfirst($order['status']);
                }
            ?>
                <tr>
                    <td><strong style="color: var(--primary);">#<?= $order['id'] ?></strong></td>
                    <td>
                        <div style="font-weight: 600; color: var(--text-primary);"><?= htmlspecialchars($order['customer_name']) ?></div>
                        <div style="font-size: 0.8rem; color: var(--text-secondary);"><i class="zmdi zmdi-phone"></i> <?= $order['customer_phone'] ?></div>
                        <?php if ($order['coupon_code']): ?>
                            <span class="badge-modern badge-secondary" style="font-size: 0.7rem; margin-top: 0.25rem;"><i class="zmdi zmdi-card-giftcard"></i> <?= $order['coupon_code'] ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="font-weight: 500;"><?= date('d/m/Y', strtotime($order['order_date'])) ?></div>
                        <div style="font-size: 0.8rem; color: var(--text-secondary);"><?= date('H:i', strtotime($order['order_date'])) ?></div>
                    </td>
                    <td>
                        <?php if (isset($order_items_map[$order['id']])): ?>
                            <ul class="product-list">
                                <?php foreach ($order_items_map[$order['id']] as $item): ?>
                                    <li><strong><?= htmlspecialchars($item['name']) ?></strong> × <?= $item['quantity'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <span style="color: var(--text-secondary);">---</span>
                        <?php endif; ?>
                    </td>
                    <td><strong style="color: var(--primary); font-size: 1.1rem;"><?= number_format($order['total_price'], 0, ',', '.') ?>₫</strong></td>
                    <td>
                        <form method="post" style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <select name="status" class="status-select">
                                <?php 
                                $statuses = ['pending' => 'Chờ xử lý', 'processing' => 'Đang xử lý', 'completed' => 'Hoàn thành', 'cancelled' => 'Đã hủy'];
                                foreach ($statuses as $st => $label): ?>
                                    <option value="<?= $st ?>" <?= $order['status']===$st?'selected':'' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" name="update_status" class="btn-modern btn-primary btn-sm">
                                <i class="zmdi zmdi-check"></i> Lưu
                            </button>
                        </form>
                    </td>
                    <td>
                        <?php if ($order['status'] !== 'cancelled' && $order['status'] !== 'completed'): ?>
                            <form method="post" onsubmit="return confirm('Xác nhận hủy đơn #<?= $order['id'] ?>?');">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" name="update_status" class="btn-modern btn-danger btn-sm">
                                    <i class="zmdi zmdi-close"></i> Hủy
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="badge-modern <?= $status_badge ?>"><?= $status_text ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>