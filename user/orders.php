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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php if (!$user_id): ?>Tra cứu đơn hàng<?php else: ?>Đơn hàng đã mua<?php endif; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .order-card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .order-card:hover {
            transform: translateY(-2px);
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .status-badge {
            font-size: 0.9rem;
            padding: 5px 12px;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4 text-primary text-center">
        <?php if (!$user_id): ?>
            <i class="fas fa-search me-2"></i>Tra cứu đơn hàng
        <?php else: ?>
            <i class="fas fa-shopping-bag me-2"></i>Đơn hàng đã mua
        <?php endif; ?>
    </h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!$user_id): ?>
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="get">
                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                <i class="fas fa-phone me-1"></i>
                                Số điện thoại
                            </label>
                            <input type="text" id="phone" name="phone" class="form-control" 
                                   placeholder="Nhập số điện thoại để tra cứu đơn hàng" 
                                   value="<?= htmlspecialchars($phone) ?>" required>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success btn-lg">
                                <i class="fas fa-search me-2"></i>
                                Tra cứu đơn hàng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (($user_id || $phone) && $orders): ?>
        <?php foreach ($orders as $order): 
            $status_class = '';
            $status_icon = '';
            switch($order['status']) {
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
            <div class="card mb-4 order-card">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="row align-items-center text-white">
                        <div class="col-md-4">
                            <h6 class="mb-0">
                                <i class="fas fa-receipt me-2"></i>
                                Mã đơn: <strong>#<?= $order['id'] ?></strong>
                            </h6>
                        </div>
                        <div class="col-md-4 text-center">
                            <small>
                                <i class="fas fa-calendar me-1"></i>
                                <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?>
                            </small>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge status-badge <?= $status_class ?>">
                                <i class="<?= $status_icon ?> me-1"></i>
                                <?= $status_text ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-light border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong><i class="fas fa-user me-1"></i> Người nhận:</strong><br>
                                        <?= htmlspecialchars($order['customer_name'] ?? '') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <strong><i class="fas fa-phone me-1"></i> Điện thoại:</strong><br>
                                        <?= htmlspecialchars($order['customer_phone'] ?? '') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <strong><i class="fas fa-map-marker-alt me-1"></i> Địa chỉ:</strong><br>
                                        <?= htmlspecialchars($order['customer_address'] ?? '') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                <tr class="text-center">
                                    <th><i class="fas fa-image me-1"></i> Ảnh</th>
                                    <th><i class="fas fa-tag me-1"></i> Tên sản phẩm</th>
                                    <th><i class="fas fa-money-bill me-1"></i> Đơn giá</th>
                                    <th><i class="fas fa-sort-numeric-up me-1"></i> Số lượng</th>
                                    <th><i class="fas fa-calculator me-1"></i> Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $items = getOrderItems($pdo, $order['id']);
                            foreach ($items as $item): ?>
                                <tr class="text-center">
                                    <td>
                                        <img src="../assets/images/<?= htmlspecialchars($item['image']) ?>" 
                                             alt="<?= htmlspecialchars($item['name']) ?>" 
                                             class="product-img shadow-sm">
                                    </td>
                                    <td class="fw-bold"><?= htmlspecialchars($item['name']) ?></td>
                                    <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                                    <td>
                                        <span class="badge bg-primary"><?= $item['quantity'] ?></span>
                                    </td>
                                    <td class="fw-bold text-success">
                                        <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <?php if ($user_id && $order['user_id'] == $user_id && !in_array($order['status'], ['completed','cancelled'])): ?>
                                <div class="d-flex gap-2">
                                    <a href="edit_order.php?id=<?= $order['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit me-1"></i> Sửa đơn hàng
                                    </a>
                                    <form method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này? Hành động này không thể hoàn tác!');" class="d-inline">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                        <button type="submit" name="delete_order" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash me-1"></i> Xóa đơn hàng
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="alert alert-success mb-0">
                                <strong>Tổng cộng: 
                                    <span class="text-danger fs-5">
                                        <?= number_format($order['total_price'], 0, ',', '.') ?> VND
                                    </span>
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php elseif (($user_id || $phone) && !$orders): ?>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h5>Không tìm thấy đơn hàng nào</h5>
                    <p class="mb-0">Chưa có đơn hàng nào được tìm thấy với thông tin này.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="text-center mt-5">
        <a href="../index.php" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left me-2"></i>
            Quay lại trang chủ
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
