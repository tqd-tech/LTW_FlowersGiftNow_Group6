<?php
session_start();
require 'includes/db.php';

$order_id = $_SESSION['last_order_id'] ?? null;
$order = null;
$items = [];

if ($order_id) {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$order_id]);
    $order = $stmt->fetch();

    if ($order) {
        $stmt = $pdo->prepare("
            SELECT p.name, p.image, oi.quantity, oi.price 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$order_id]);
        $items = $stmt->fetchAll();
    }
}

$status = $order['status'] ?? 'pending';
$statusLabels = [
    'pending' => 'Chờ xác nhận',
    'processing' => 'Đang xử lý',
    'completed' => 'Hoàn thành',
    'cancelled' => 'Đã hủy'
];
$statusLabel = $statusLabels[$status] ?? $status;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - Flowers Gift</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

        .track-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Success Animation */
        .success-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: scaleIn 0.5s ease-out, pulse 2s infinite;
            box-shadow: 0 10px 40px rgba(16, 185, 129, 0.4);
        }

        .success-icon i {
            font-size: 3rem;
            color: white;
        }

        @keyframes scaleIn {
            0% { transform: scale(0); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 10px 40px rgba(16, 185, 129, 0.4); }
            50% { box-shadow: 0 10px 60px rgba(16, 185, 129, 0.6); }
        }

        .success-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .success-header p {
            color: var(--gray-500);
            font-size: 1rem;
        }

        /* Progress Steps */
        .checkout-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            background: white;
            border-radius: 50px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            font-size: 0.9rem;
        }

        .step.completed {
            background: var(--success);
            color: white;
        }

        .step-number {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.75rem;
            background: var(--gray-100);
        }

        .step.completed .step-number {
            background: rgba(255,255,255,0.25);
        }

        .step-connector {
            width: 30px;
            height: 2px;
            background: var(--success);
        }

        /* Cards */
        .track-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header-left {
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

        .order-id-badge {
            background: rgba(255,255,255,0.2);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Order Info Grid */
        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .order-info-grid {
                grid-template-columns: 1fr;
            }
        }

        .info-section h4 {
            font-size: 0.85rem;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-section h4 i {
            color: var(--primary);
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-item i {
            width: 20px;
            color: var(--gray-400);
            margin-top: 2px;
        }

        .info-item .label {
            color: var(--gray-500);
            font-size: 0.85rem;
        }

        .info-item .value {
            color: var(--gray-900);
            font-weight: 500;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-badge.pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-badge.processing {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-badge.completed {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-badge.cancelled {
            background: #FEE2E2;
            color: #991B1B;
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
        }

        .product-item:last-child {
            margin-bottom: 0;
        }

        .product-image {
            width: 60px;
            height: 60px;
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
            min-width: 100px;
            text-align: right;
        }

        /* Summary */
        .summary-divider {
            border-top: 2px dashed var(--gray-200);
            margin: 1.5rem 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }

        .summary-row .label {
            color: var(--gray-500);
        }

        .summary-row .value {
            font-weight: 600;
            color: var(--gray-700);
        }

        .summary-row.discount .value {
            color: var(--success);
        }

        .summary-row.shipping .value.free {
            color: var(--success);
        }

        .summary-row.total {
            border-top: 2px solid var(--gray-200);
            margin-top: 0.75rem;
            padding-top: 1rem;
        }

        .summary-row.total .label {
            font-weight: 700;
            color: var(--gray-900);
            font-size: 1.1rem;
        }

        .summary-row.total .value {
            font-size: 1.5rem;
            color: var(--primary);
            font-weight: 700;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.875rem 1.75rem;
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

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
            color: white;
        }

        .btn-outline {
            background: white;
            color: var(--gray-700);
            border: 2px solid var(--gray-200);
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Not Found State */
        .not-found {
            text-align: center;
            padding: 4rem 2rem;
        }

        .not-found-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .not-found-icon i {
            font-size: 2.5rem;
            color: var(--danger);
        }

        .not-found h2 {
            font-size: 1.5rem;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .not-found p {
            color: var(--gray-500);
            margin-bottom: 1.5rem;
        }

        /* Thank you message */
        .thank-you-box {
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 100%);
            border: 2px solid var(--primary-light);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            margin-top: 1.5rem;
        }

        .thank-you-box h4 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .thank-you-box p {
            color: var(--gray-600);
            font-size: 0.9rem;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="track-container">
    <?php if (!$order): ?>
        <!-- Not Found State -->
        <div class="track-card">
            <div class="not-found">
                <div class="not-found-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h2>Không tìm thấy đơn hàng</h2>
                <p>Không có đơn hàng gần đây hoặc đơn hàng không tồn tại</p>
                <a href="index.php" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Về trang chủ
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Success Header -->
        <div class="success-header">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h1>Đặt hàng thành công!</h1>
            <p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đang được xử lý.</p>
        </div>

        <!-- Progress Steps -->
        <div class="checkout-steps">
            <div class="step completed">
                <span class="step-number"><i class="fas fa-check"></i></span>
                <span>Giỏ hàng</span>
            </div>
            <div class="step-connector"></div>
            <div class="step completed">
                <span class="step-number"><i class="fas fa-check"></i></span>
                <span>Thanh toán</span>
            </div>
            <div class="step-connector"></div>
            <div class="step completed">
                <span class="step-number"><i class="fas fa-check"></i></span>
                <span>Hoàn tất</span>
            </div>
        </div>

        <!-- Order Details Card -->
        <div class="track-card">
            <div class="card-header">
                <div class="card-header-left">
                    <i class="fas fa-file-invoice"></i>
                    <h3>Chi tiết đơn hàng</h3>
                </div>
                <span class="order-id-badge">#<?= $order_id ?></span>
            </div>
            <div class="card-body">
                <div class="order-info-grid">
                    <div class="info-section">
                        <h4><i class="fas fa-info-circle"></i> Thông tin đơn hàng</h4>
                        <div class="info-item">
                            <div>
                                <div class="label">Ngày đặt hàng</div>
                                <div class="value"><?= date('d/m/Y - H:i', strtotime($order['order_date'])) ?></div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div>
                                <div class="label">Trạng thái</div>
                                <div class="value">
                                    <span class="status-badge <?= $status ?>">
                                        <?php if ($status === 'pending'): ?>
                                            <i class="fas fa-clock"></i>
                                        <?php elseif ($status === 'processing'): ?>
                                            <i class="fas fa-spinner fa-spin"></i>
                                        <?php elseif ($status === 'completed'): ?>
                                            <i class="fas fa-check-circle"></i>
                                        <?php else: ?>
                                            <i class="fas fa-times-circle"></i>
                                        <?php endif; ?>
                                        <?= $statusLabel ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info-section">
                        <h4><i class="fas fa-truck"></i> Thông tin giao hàng</h4>
                        <div class="info-item">
                            <div>
                                <div class="label">Người nhận</div>
                                <div class="value"><?= htmlspecialchars($order['customer_name']) ?></div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div>
                                <div class="label">Số điện thoại</div>
                                <div class="value"><?= htmlspecialchars($order['customer_phone']) ?></div>
                            </div>
                        </div>
                        <div class="info-item">
                            <div>
                                <div class="label">Địa chỉ</div>
                                <div class="value"><?= nl2br(htmlspecialchars($order['customer_address'])) ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="track-card">
            <div class="card-header">
                <div class="card-header-left">
                    <i class="fas fa-shopping-bag"></i>
                    <h3>Sản phẩm đã đặt (<?= count($items) ?>)</h3>
                </div>
            </div>
            <div class="card-body">
                <?php 
                $subtotal = 0;
                foreach ($items as $item): 
                    $lineTotal = $item['quantity'] * $item['price'];
                    $subtotal += $lineTotal;
                ?>
                    <div class="product-item">
                        <img src="assets/images/<?= htmlspecialchars($item['image'] ?? 'flowers/default.jpg') ?>" 
                             alt="<?= htmlspecialchars($item['name']) ?>" 
                             class="product-image"
                             onerror="this.src='assets/images/flowers/default.jpg'">
                        <div class="product-info">
                            <div class="product-name"><?= htmlspecialchars($item['name']) ?></div>
                            <div class="product-price"><?= number_format($item['price'], 0, ',', '.') ?>đ</div>
                        </div>
                        <span class="product-qty">x<?= $item['quantity'] ?></span>
                        <div class="product-total"><?= number_format($lineTotal, 0, ',', '.') ?>đ</div>
                    </div>
                <?php endforeach; ?>

                <div class="summary-divider"></div>

                <?php
                    $shipping = ($subtotal >= 500000) ? 0 : 30000;
                    $total = $subtotal + $shipping;
                ?>

                <div class="summary-row">
                    <span class="label">Tạm tính</span>
                    <span class="value"><?= number_format($subtotal, 0, ',', '.') ?>đ</span>
                </div>
                <div class="summary-row shipping">
                    <span class="label">Phí vận chuyển</span>
                    <span class="value <?= $shipping == 0 ? 'free' : '' ?>">
                        <?= $shipping == 0 ? 'Miễn phí' : number_format($shipping, 0, ',', '.') . 'đ' ?>
                    </span>
                </div>
                <div class="summary-row total">
                    <span class="label">Tổng thanh toán</span>
                    <span class="value"><?= number_format($order['total_price'], 0, ',', '.') ?>đ</span>
                </div>

                <div class="thank-you-box">
                    <h4>🌸 Cảm ơn bạn đã tin tưởng!</h4>
                    <p>Chúng tôi sẽ liên hệ với bạn sớm nhất để xác nhận đơn hàng.</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="track_order.php" class="btn btn-outline">
                <i class="fas fa-search"></i>
                Tra cứu đơn hàng
            </a>
            <a href="index.php" class="btn btn-primary">
                <i class="fas fa-shopping-bag"></i>
                Tiếp tục mua sắm
            </a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
