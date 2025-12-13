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

function getOrderItems($pdo, $order_id)
{
    $stmt = $pdo->prepare('SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?');
    $stmt->execute([$order_id]);
    return $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if (!$user_id): ?>Tra cứu đơn hàng<?php else: ?>Đơn hàng đã mua<?php endif; ?> - FlowerGiftNow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../assets/css/modern-design.css">
    <style>
        :root {
            --primary: #EC4899;
            --primary-dark: #DB2777;
            --primary-light: #F472B6;
            --secondary: #6366F1;
        }
        body {
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 50%, #FBCFE8 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        .page-header {
            text-align: center;
            /* margin-bottom: 2rem; */
            /* padding: 2rem 0; */
        }
        .page-header h2 {
            font-size: 2.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        .page-header p {
            color: #6B7280;
            font-size: 1rem;
        }
        .product-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: var(--radius-lg);
        }
        .order-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(236, 72, 153, 0.1);
            overflow: hidden;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(236, 72, 153, 0.1);
        }
        .order-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 1.25rem 1.5rem;
            color: white;
        }
        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            padding: 1.5rem;
            background: #FEFCE8;
            border-radius: var(--radius-lg);
            margin: 1rem 1.5rem;
            border: 1px dashed #FCD34D;
        }
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .info-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-size: 0.95rem;
            color: var(--text-primary);
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="page-header">
            <h2>
                <?php if (!$user_id): ?>
                    <i class="zmdi zmdi-search"></i> Tra cứu đơn hàng
                <?php else: ?>
                    <i class="zmdi zmdi-shopping-cart"></i> Đơn hàng đã mua
                <?php endif; ?>
            </h2>
            <p>Quản lý và theo dõi đơn hàng của bạn</p>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert-modern alert-success" style="margin-bottom: 1.5rem;">
                <i class="zmdi zmdi-check-circle"></i>
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (!$user_id): ?>
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="card-modern" style="padding: 2rem;">
                        <form method="get">
                            <div class="mb-3">
                                <label for="phone" class="form-label d-flex align-items-center gap-1" style="font-weight: 600; color: var(--text-primary);">
                                    <i class="zmdi zmdi-phone"></i> Số điện thoại
                                </label>
                                <input type="text" id="phone" name="phone" 
                                    style="padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); width: 100%; transition: all 0.3s ease;"
                                    placeholder="Nhập số điện thoại để tra cứu đơn hàng"
                                    value="<?= htmlspecialchars($phone) ?>" required
                                    onfocus="this.style.borderColor='var(--primary)'"
                                    onblur="this.style.borderColor='var(--gray-200)'">
                            </div>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn-modern btn-primary btn-lg">
                                    <i class="zmdi zmdi-search"></i> Tra cứu đơn hàng
                                </button>
                                <a href="../index.php" class="btn-modern btn-ghost btn-lg">
                                    <i class="fa fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (($user_id || $phone) && $orders): ?>
            <?php foreach ($orders as $order):
                $status_class = '';
                $status_icon = '';
                switch ($order['status']) {
                    case 'pending':
                        $status_class = 'bg-warning text-dark';
                        $status_icon = 'fas fa-clock';
                        $status_text = 'Chờ xử lý';
                        break;
                    case 'processing':
                        $status_class = 'bg-info text-white';
                        $status_icon = 'fas fa-cog';
                        $status_text = 'Đang xử lý';
                        break;
                    case 'completed':
                        $status_class = 'bg-success text-white';
                        $status_icon = 'fas fa-check';
                        $status_text = 'Hoàn thành';
                        break;
                    case 'cancelled':
                        $status_class = 'bg-danger text-white';
                        $status_icon = 'fas fa-times';
                        $status_text = 'Đã hủy';
                        break;
                    default:
                        $status_class = 'bg-secondary text-white';
                        $status_icon = 'fas fa-question';
                        $status_text = ucfirst($order['status']);
                }
            ?>
                <div class="card-modern mb-4">
                    <div class="order-header">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; ">
                            <div>
                                <div style="color: var(--gray-200); font-size: 0.875rem; margin-bottom: 0.25rem;">
                                    Mã đơn hàng: <strong style="color: white;">#<?= $order['id'] ?></strong>
                                </div>
                                <div style="color: var(--gray-200); font-size: 0.875rem;">
                                    <!-- In đậm -->
                                    Ngày đặt: <strong style="color: white;"><?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></strong>
                                </div>
                            </div>
                            <span class="badge-modern <?= str_replace(['bg-warning', 'bg-info', 'bg-success', 'bg-danger', 'bg-secondary'], ['badge-warning', 'badge-info', 'badge-success', 'badge-danger', 'badge-secondary'], $status_class) ?>" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
                                <i class="<?= $status_icon ?>"></i> <?= $status_text ?>
                            </span>
                        </div>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div class="order-info-grid">
                            <div class="info-item">
                                <span class="info-label"><i class="zmdi zmdi-account"></i> Người nhận</span>
                                <span class="info-value"><?= htmlspecialchars($order['customer_name'] ?? '') ?></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label"><i class="zmdi zmdi-phone"></i> Điện thoại</span>
                                <span class="info-value"><?= htmlspecialchars($order['customer_phone'] ?? '') ?></span>
                            </div>
                            <div class="info-item" style="grid-column: span 2;">
                                <span class="info-label"><i class="zmdi zmdi-pin"></i> Địa chỉ giao hàng</span>
                                <span class="info-value"><?= htmlspecialchars($order['customer_address'] ?? '') ?></span>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table align-middle" style="margin-bottom: 0;">
                                <thead style="background: var(--gray-100); border-bottom: 2px solid var(--gray-200);">
                                    <tr>
                                        <th style="padding: 1rem; font-weight: 600; color: var(--text-primary);">Sản phẩm</th>
                                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--text-primary);">Đơn giá</th>
                                        <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--text-primary);">Số lượng</th>
                                        <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--text-primary);">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $items = getOrderItems($pdo, $order['id']);
                                    foreach ($items as $item): ?>
                                        <tr style="border: none;">
                                            <td style="padding: 1rem;">
                                                <div style="display: flex; align-items: center; gap: 1rem;">
                                                    <img src="../assets/images/<?= htmlspecialchars($item['image']) ?>"
                                                        alt="<?= htmlspecialchars($item['name']) ?>"
                                                        class="product-img">
                                                    <span style="font-weight: 600; color: var(--text-primary);">
                                                        <?= htmlspecialchars($item['name']) ?>
                                                    </span>
                                                </div>
                                            </td>
                                            <td style="padding: 1rem; text-align: center; color: var(--text-secondary);">
                                                <?= number_format($item['price'], 0, ',', '.') ?>₫
                                            </td>
                                            <td style="padding: 1rem; text-align: center;">
                                                <span class="badge-modern badge-primary"><?= $item['quantity'] ?></span>
                                            </td>
                                            <td style="padding: 1rem; text-align: right; font-weight: 700; color: var(--primary);">
                                                <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>₫
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                            <div>
                                <?php if ($user_id && $order['user_id'] == $user_id && !in_array($order['status'], ['completed', 'cancelled'])): ?>
                                    <div class="d-flex gap-2">
                                        <a href="edit_order.php?id=<?= $order['id'] ?>" class="btn-modern btn btn-warning btn-sm">
                                            <i class="zmdi zmdi-edit"></i> Sửa đơn hàng
                                        </a>
                                        <form method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này? Hành động này không thể hoàn tác!');" class="d-inline">
                                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                            <button type="submit" name="delete_order" class="btn-modern btn-danger btn-sm">
                                                <i class="zmdi zmdi-delete"></i> Xóa đơn hàng
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 0.25rem;">
                                    Tổng cộng
                                </div>
                                <div style="font-size: 1.75rem; font-weight: 700; color: var(--primary);">
                                    <?= number_format($order['total_price'], 0, ',', '.') ?>₫
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php elseif (($user_id || $phone) && !$orders): ?>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card-modern" style="padding: 3rem 2rem; text-align: center;">
                        <i class="zmdi zmdi-shopping-cart" style="font-size: 4rem; color: var(--gray-400); margin-bottom: 1rem;"></i>
                        <h4 style="color: var(--text-primary); margin-bottom: 0.5rem;">Không tìm thấy đơn hàng nào</h4>
                        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Chưa có đơn hàng nào được tìm thấy với thông tin này.</p>
                        <a href="../index.php" class="btn-modern btn-primary">
                            <i class="zmdi zmdi-shopping-cart-plus"></i> Bắt đầu mua sắm
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($user_id || $phone): ?>
        <div style="text-align: center; margin-top: 2rem;">
            <a href="../index.php" class="btn-modern btn-ghost">
                <i class="fa fa-arrow-left"></i> Quay về trang chủ
            </a>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>