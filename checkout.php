<?php
session_start();
require 'includes/db.php';

$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    // Will show empty cart message with modern design below
    $empty_cart = true;
} else {
    $empty_cart = false;
    
    // Lấy sản phẩm trong giỏ
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute(array_keys($cart));
    $products = $stmt->fetchAll();

    // Tính tổng
    $subtotal = 0;
    foreach ($products as $p) {
        $subtotal += $p['price'] * $cart[$p['id']];
    }
    $shipping = ($subtotal >= 500000) ? 0 : 30000;

    // Áp dụng mã giảm giá nếu có trong session
    $coupon_discount = 0;
    $coupon_code = null;
    $coupon_id = null;
    if (!empty($_SESSION['coupon']['discount'])) {
        $coupon_discount = round($subtotal * ($_SESSION['coupon']['discount'] / 100));
        $coupon_code = $_SESSION['coupon']['code'];
        $coupon_id = $_SESSION['coupon']['id'];
    }

    $total = $subtotal + $shipping - $coupon_discount;

    // Xử lý đặt hàng
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $user_id = $_SESSION['user_id'] ?? null;

        if ($name && $phone && $address) {
            $stmt = $pdo->prepare("
                INSERT INTO orders (user_id, customer_name, customer_phone, customer_address, total_price, status, coupon_id) 
                VALUES (?, ?, ?, ?, ?, 'pending', ?)
            ");
            $stmt->execute([$user_id, $name, $phone, $address, $total, $coupon_id]);

            $order_id = $pdo->lastInsertId();

            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($products as $p) {
                $stmt->execute([$order_id, $p['id'], $cart[$p['id']], $p['price']]);
            }

            // Clear cart & redirect
            $_SESSION['cart'] = [];
            $_SESSION['last_order_id'] = $order_id;
            unset($_SESSION['coupon']); // Xóa coupon sau khi đặt hàng thành công
            header("Location: track.php");
            exit;
        } else {
            $error = "Vui lòng điền đầy đủ thông tin.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Flowers Gift</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #EC4899;
            --primary-dark: #DB2777;
            --primary-light: #F472B6;
            --secondary: #6366F1;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-500: #6B7280;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 50%, #FBCFE8 100%);
            min-height: 100vh;
            color: var(--gray-700);
        }

        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Header */
        .checkout-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .checkout-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .checkout-header h1 i {
            color: var(--primary);
        }

        .checkout-header p {
            color: var(--gray-500);
            margin-top: 0.5rem;
        }

        /* Progress Steps */
        .checkout-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            background: white;
            border-radius: 50px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }

        .step.completed {
            background: var(--success);
            color: white;
        }

        .step.active {
            background: var(--primary);
            color: white;
        }

        .step-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            background: var(--gray-100);
        }

        .step.completed .step-number,
        .step.active .step-number {
            background: rgba(255,255,255,0.25);
        }

        .step-connector {
            width: 40px;
            height: 2px;
            background: var(--gray-200);
        }

        /* Main Layout */
        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 2rem;
        }

        @media (max-width: 992px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Cards */
        .checkout-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header i {
            font-size: 1.25rem;
        }

        .card-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Product Items */
        .product-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            border-radius: 12px;
            background: var(--gray-50);
            margin-bottom: 0.75rem;
            transition: all 0.2s ease;
        }

        .product-item:hover {
            background: var(--gray-100);
        }

        .product-item:last-child {
            margin-bottom: 0;
        }

        .product-image {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            background: var(--gray-200);
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }

        .product-price {
            color: var(--gray-500);
            font-size: 0.85rem;
        }

        .product-qty {
            background: var(--primary-light);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .product-total {
            font-weight: 700;
            color: var(--primary);
            font-size: 1rem;
            min-width: 110px;
            text-align: right;
        }

        /* Order Summary */
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-row.total {
            border-top: 2px solid var(--gray-200);
            margin-top: 0.5rem;
            padding-top: 1rem;
        }

        .summary-label {
            color: var(--gray-500);
            font-size: 0.95rem;
        }

        .summary-value {
            font-weight: 600;
            color: var(--gray-700);
        }

        .summary-row.discount .summary-value {
            color: var(--success);
        }

        .summary-row.shipping .summary-value.free {
            color: var(--success);
        }

        .summary-row.total .summary-label {
            font-weight: 700;
            color: var(--gray-900);
            font-size: 1.1rem;
        }

        .summary-row.total .summary-value {
            font-size: 1.5rem;
            color: var(--primary);
            font-weight: 700;
        }

        /* Coupon Badge */
        .coupon-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
            color: #065F46;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .coupon-badge i {
            color: var(--success);
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-label i {
            color: var(--primary);
            margin-right: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.1);
        }

        .form-control::placeholder {
            color: var(--gray-300);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Error Alert */
        .alert-error {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            border: 1px solid #FECACA;
            color: #991B1B;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .alert-error i {
            font-size: 1.25rem;
            color: var(--danger);
        }

        /* Buttons */
        .btn-group {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            border: none;
        }

        .btn-back {
            background: var(--gray-100);
            color: var(--gray-700);
            flex: 1;
        }

        .btn-back:hover {
            background: var(--gray-200);
            color: var(--gray-900);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            flex: 2;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-cart-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .empty-cart-icon i {
            font-size: 3rem;
            color: var(--primary);
        }

        .empty-cart h2 {
            font-size: 1.5rem;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .empty-cart p {
            color: var(--gray-500);
            margin-bottom: 1.5rem;
        }

        .btn-shop {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-shop:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.4);
            color: white;
        }

        /* Security Badge */
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: var(--gray-500);
            font-size: 0.85rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-100);
        }

        .security-badge i {
            color: var(--success);
        }

        /* Sticky Summary on Mobile */
        @media (max-width: 992px) {
            .order-summary-card {
                position: sticky;
                top: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="checkout-container">
    <?php if ($empty_cart): ?>
        <!-- Empty Cart State -->
        <div class="checkout-card">
            <div class="empty-cart">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h2>Giỏ hàng trống!</h2>
                <p>Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                <a href="index.php" class="btn-shop">
                    <i class="fas fa-arrow-left"></i>
                    Quay lại mua hàng
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Header -->
        <div class="checkout-header">
            <h1><i class="fas fa-credit-card"></i> Thanh toán đơn hàng</h1>
            <p>Vui lòng kiểm tra thông tin và xác nhận đặt hàng</p>
        </div>

        <!-- Progress Steps -->
        <div class="checkout-steps">
            <div class="step completed">
                <span class="step-number"><i class="fas fa-check"></i></span>
                <span>Giỏ hàng</span>
            </div>
            <div class="step-connector"></div>
            <div class="step active">
                <span class="step-number">2</span>
                <span>Thanh toán</span>
            </div>
            <div class="step-connector"></div>
            <div class="step">
                <span class="step-number">3</span>
                <span>Hoàn tất</span>
            </div>
        </div>

        <div class="checkout-grid">
            <!-- Left Column - Form -->
            <div>
                <!-- Products Card -->
                <div class="checkout-card" style="margin-bottom: 1.5rem;">
                    <div class="card-header">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>Sản phẩm đặt mua (<?= count($products) ?>)</h3>
                    </div>
                    <div class="card-body">
                        <?php foreach ($products as $p): ?>
                            <div class="product-item">
                                <img src="assets/images/<?= htmlspecialchars($p['image']) ?>" 
                                     alt="<?= htmlspecialchars($p['name']) ?>" 
                                     class="product-image"
                                     onerror="this.src='assets/images/flowers/default.jpg'">
                                <div class="product-info">
                                    <div class="product-name"><?= htmlspecialchars($p['name']) ?></div>
                                    <div class="product-price"><?= number_format($p['price'], 0, ',', '.') ?>đ</div>
                                </div>
                                <span class="product-qty">x<?= $cart[$p['id']] ?></span>
                                <div class="product-total"><?= number_format($p['price'] * $cart[$p['id']], 0, ',', '.') ?>đ</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Shipping Form Card -->
                <div class="checkout-card">
                    <div class="card-header">
                        <i class="fas fa-truck"></i>
                        <h3>Thông tin giao hàng</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert-error">
                                <i class="fas fa-exclamation-circle"></i>
                                <span><?= $error ?></span>
                            </div>
                        <?php endif; ?>

                        <form method="post" id="checkout-form">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user"></i>Họ và tên người nhận
                                </label>
                                <input type="text" name="name" class="form-control" 
                                       placeholder="Nhập họ và tên đầy đủ" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-phone"></i>Số điện thoại
                                </label>
                                <input type="tel" name="phone" class="form-control" 
                                       placeholder="Nhập số điện thoại liên hệ" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>Địa chỉ giao hàng
                                </label>
                                <textarea name="address" class="form-control" 
                                          placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required></textarea>
                            </div>

                            <div class="btn-group">
                                <a href="cart.php" class="btn btn-back">
                                    <i class="fas fa-arrow-left"></i>
                                    Quay lại
                                </a>
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-check-circle"></i>
                                    Xác nhận đặt hàng
                                </button>
                            </div>
                        </form>

                        <div class="security-badge">
                            <i class="fas fa-shield-alt"></i>
                            <span>Thông tin của bạn được bảo mật an toàn</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div>
                <div class="checkout-card order-summary-card">
                    <div class="card-header">
                        <i class="fas fa-receipt"></i>
                        <h3>Tóm tắt đơn hàng</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($coupon_discount > 0): ?>
                            <div class="coupon-badge">
                                <i class="fas fa-ticket-alt"></i>
                                <span>Mã giảm giá: <?= htmlspecialchars($coupon_code) ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="summary-row">
                            <span class="summary-label">Tạm tính (<?= array_sum($cart) ?> sản phẩm)</span>
                            <span class="summary-value"><?= number_format($subtotal, 0, ',', '.') ?>đ</span>
                        </div>

                        <?php if ($coupon_discount > 0): ?>
                            <div class="summary-row discount">
                                <span class="summary-label">Giảm giá</span>
                                <span class="summary-value">-<?= number_format($coupon_discount, 0, ',', '.') ?>đ</span>
                            </div>
                        <?php endif; ?>

                        <div class="summary-row shipping">
                            <span class="summary-label">Phí vận chuyển</span>
                            <span class="summary-value <?= $shipping == 0 ? 'free' : '' ?>">
                                <?= $shipping == 0 ? 'Miễn phí' : number_format($shipping, 0, ',', '.') . 'đ' ?>
                            </span>
                        </div>

                        <?php if ($shipping > 0): ?>
                            <div style="background: #FEF3C7; padding: 0.75rem; border-radius: 8px; margin: 0.5rem 0;">
                                <small style="color: #92400E;">
                                    <i class="fas fa-info-circle"></i>
                                    Miễn phí ship cho đơn từ 500.000đ
                                </small>
                            </div>
                        <?php endif; ?>

                        <div class="summary-row total">
                            <span class="summary-label">Tổng thanh toán</span>
                            <span class="summary-value"><?= number_format($total, 0, ',', '.') ?>đ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
