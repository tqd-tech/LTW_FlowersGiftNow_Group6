<?php
session_start();
require '../includes/db.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$order_id = $_GET['id'] ?? 0;

// Lấy thông tin đơn hàng
$stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ? AND user_id = ? AND status NOT IN ("completed","cancelled")');
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: orders.php');
    exit;
}

// Xử lý cập nhật đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name']);
    $customer_phone = trim($_POST['customer_phone']);
    $customer_address = trim($_POST['customer_address']);
    $notes = trim($_POST['notes'] ?? '');
    
    if ($customer_name && $customer_phone && $customer_address) {
        $stmt = $pdo->prepare('UPDATE orders SET customer_name = ?, customer_phone = ?, customer_address = ?, notes = ? WHERE id = ? AND user_id = ?');
        if ($stmt->execute([$customer_name, $customer_phone, $customer_address, $notes, $order_id, $user_id])) {
            $_SESSION['success'] = 'Cập nhật đơn hàng thành công!';
            header('Location: orders.php');
            exit;
        } else {
            $error = 'Có lỗi xảy ra khi cập nhật đơn hàng.';
        }
    } else {
        $error = 'Vui lòng điền đầy đủ thông tin bắt buộc.';
    }
}

// Lấy danh sách sản phẩm trong đơn hàng
function getOrderItems($pdo, $order_id) {
    $stmt = $pdo->prepare('SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?');
    $stmt->execute([$order_id]);
    return $stmt->fetchAll();
}

$items = getOrderItems($pdo, $order_id);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sửa đơn hàng #<?= $order['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .order-card {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .btn-custom {
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card order-card">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Sửa đơn hàng #<?= $order['id'] ?>
                    </h4>
                    <small>Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></small>
                </div>
                
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Thông tin sản phẩm (chỉ xem) -->
                    <div class="mb-4">
                        <h5 class="text-primary">
                            <i class="fas fa-shopping-bag me-2"></i>
                            Sản phẩm trong đơn hàng
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>Ảnh</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                    <tr class="text-center align-middle">
                                        <td>
                                            <img src="../assets/images/<?= htmlspecialchars($item['image']) ?>" 
                                                 alt="<?= htmlspecialchars($item['name']) ?>" 
                                                 class="product-img">
                                        </td>
                                        <td class="fw-bold"><?= htmlspecialchars($item['name']) ?></td>
                                        <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                                        <td>
                                            <span class="badge bg-secondary"><?= $item['quantity'] ?></span>
                                        </td>
                                        <td class="fw-bold text-primary">
                                            <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                                        <td class="text-center fw-bold text-danger fs-5">
                                            <?= number_format($order['total_price'], 0, ',', '.') ?> VND
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Form sửa thông tin giao hàng -->
                    <form method="post">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-truck me-2"></i>
                            Thông tin giao hàng
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">
                                    <i class="fas fa-user me-1"></i>
                                    Tên người nhận <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                       value="<?= htmlspecialchars($order['customer_name']) ?>" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" class="form-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Số điện thoại <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control" id="customer_phone" name="customer_phone" 
                                       value="<?= htmlspecialchars($order['customer_phone']) ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="customer_address" class="form-label">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                Địa chỉ giao hàng <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="customer_address" name="customer_address" 
                                      rows="3" required><?= htmlspecialchars($order['customer_address']) ?></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="form-label">
                                <i class="fas fa-sticky-note me-1"></i>
                                Ghi chú thêm
                            </label>
                            <textarea class="form-control" id="notes" name="notes" 
                                      rows="2" placeholder="Thời gian giao hàng mong muốn, yêu cầu đặc biệt..."><?= htmlspecialchars($order['notes'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="d-flex gap-3 justify-content-center">
                            <button type="submit" class="btn btn-success btn-custom">
                                <i class="fas fa-save me-2"></i>
                                Cập nhật đơn hàng
                            </button>
                            <a href="orders.php" class="btn btn-secondary btn-custom">
                                <i class="fas fa-arrow-left me-2"></i>
                                Quay lại
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
