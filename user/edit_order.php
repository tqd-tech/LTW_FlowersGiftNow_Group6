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
    <title>Sửa đơn hàng #<?= $order['id'] ?> - FlowerGiftNow</title>
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
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 50%, #FBCFE8 100%);
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
        .product-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: var(--radius-lg);
        }
        .section-header {
            background: #FCE7F3;
            padding: 1rem 1.5rem;
            border-radius: var(--radius-lg);
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
        }
        .card-modern {
            box-shadow: 0 4px 20px rgba(236, 72, 153, 0.1);
            border: 1px solid rgba(236, 72, 153, 0.1);
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="page-header" style="text-align: center; margin-bottom: 2rem;">
        <h2>
            <i class="zmdi zmdi-edit"></i> Sửa đơn hàng #<?= $order['id'] ?>
        </h2>
        <p style="color: var(--text-secondary);">Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-modern" style="padding: 2rem;">
                    <?php if (isset($error)): ?>
                        <div class="alert-modern alert-danger" style="margin-bottom: 1.5rem;">
                            <i class="zmdi zmdi-alert-triangle"></i>
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Thông tin sản phẩm (chỉ xem) -->
                    <div style="margin-bottom: 2rem;">
                        <div class="section-header">
                            <h5 style="margin: 0; font-weight: 600; color: var(--text-primary);">
                                <img src="../assets/images/icons/products.png" width="24" height="24" alt=""> Sản phẩm trong đơn hàng
                            </h5>
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
                                    <?php foreach ($items as $item): ?>
                                    <tr style="border-bottom: 1px solid var(--gray-200);">
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
                                            <span class="badge-modern badge-secondary"><?= $item['quantity'] ?></span>
                                        </td>
                                        <td style="padding: 1rem; text-align: right; font-weight: 700; color: var(--primary);">
                                            <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>₫
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot style="background: var(--gray-50); border-top: 2px solid var(--gray-300);">
                                    <tr>
                                        <td colspan="3" style="padding: 1.25rem; text-align: right; font-weight: 700; color: var(--text-primary); font-size: 1.1rem;">Tổng cộng:</td>
                                        <td style="padding: 1.25rem; text-align: right; font-weight: 700; color: var(--primary); font-size: 1.25rem;">
                                            <?= number_format($order['total_price'], 0, ',', '.') ?>₫
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Form sửa thông tin giao hàng -->
                    <form method="post">
                        <div class="section-header">
                            <h5 style="margin: 0; font-weight: 600; color: var(--text-primary);">
                                <img src="../assets/images/icons/delivery-car.png" width="24" height="24" alt=""> Thông tin giao hàng
                            </h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem; display: block;">
                                    <i class="zmdi zmdi-account"></i> Tên người nhận <span style="color: var(--danger);">*</span>
                                </label>
                                <input type="text" id="customer_name" name="customer_name" 
                                       style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.3s ease;"
                                       value="<?= htmlspecialchars($order['customer_name']) ?>" 
                                       onfocus="this.style.borderColor='var(--primary)'"
                                       onblur="this.style.borderColor='var(--gray-200)'"
                                       required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="customer_phone" style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem; display: block;">
                                    <i class="zmdi zmdi-phone"></i> Số điện thoại <span style="color: var(--danger);">*</span>
                                </label>
                                <input type="tel" id="customer_phone" name="customer_phone" 
                                       style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.3s ease;"
                                       value="<?= htmlspecialchars($order['customer_phone']) ?>" 
                                       onfocus="this.style.borderColor='var(--primary)'"
                                       onblur="this.style.borderColor='var(--gray-200)'"
                                       required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="customer_address" style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem; display: block;">
                                <i class="zmdi zmdi-pin"></i> Địa chỉ giao hàng <span style="color: var(--danger);">*</span>
                            </label>
                            <textarea id="customer_address" name="customer_address" rows="3"
                                      style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.3s ease; resize: vertical;"
                                      onfocus="this.style.borderColor='var(--primary)'"
                                      onblur="this.style.borderColor='var(--gray-200)'"
                                      required><?= htmlspecialchars($order['customer_address']) ?></textarea>
                        </div>
                        
                        <div style="margin-bottom: 2rem;">
                            <label for="notes" style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.5rem; display: block;">
                                <i class="zmdi zmdi-comment-text"></i> Ghi chú thêm
                            </label>
                            <textarea id="notes" name="notes" rows="2"
                                      style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.3s ease; resize: vertical;"
                                      placeholder="Thời gian giao hàng mong muốn, yêu cầu đặc biệt..."
                                      onfocus="this.style.borderColor='var(--primary)'"
                                      onblur="this.style.borderColor='var(--gray-200)'"><?= htmlspecialchars($order['notes'] ?? '') ?></textarea>
                        </div>
                        
                        <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                            <button type="submit" class="btn-modern btn btn-success btn-lg">
                                <i class="zmdi zmdi-check"></i> Cập nhật đơn hàng
                            </button>
                            <a href="orders.php" class="btn-modern btn-ghost btn-lg">
                                <i class="zmdi zmdi-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
