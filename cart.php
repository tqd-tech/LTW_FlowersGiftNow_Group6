<?php
session_start();
require 'includes/db.php';

$cart = $_SESSION['cart'] ?? [];

if (!isset($_SESSION['user_id'])) {
    echo '
    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Yêu cầu đăng nhập - FlowerGiftNow</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="assets/css/modern-design.css">
        <style>
            body {
                font-family: "Inter", sans-serif;
                background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 50%, #FBCFE8 100%);
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
                padding: 1rem;
            }
        </style>
    </head>
    <body>
        <div class="card-modern" style="max-width: 450px; padding: 3rem 2rem; text-align: center;">
            <i class="zmdi zmdi-lock" style="font-size: 4rem; color: var(--danger); margin-bottom: 1rem;"></i>
            <h2 style="color: var(--text-primary); margin-bottom: 0.75rem; font-size: 1.5rem;">Bạn chưa đăng nhập</h2>
            <p style="color: var(--text-secondary); margin-bottom: 2rem;">Vui lòng đăng nhập để xem và quản lý giỏ hàng của bạn.</p>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <a href="user/login.php" class="btn-modern btn-primary btn-lg">
                    <i class="zmdi zmdi-account"></i> Đăng nhập ngay
                </a>
                <a href="index.php" class="btn-modern btn-ghost">
                    <i class="zmdi zmdi-arrow-left"></i> Quay lại trang chủ
                </a>
            </div>
        </div>
    </body>
    </html>';
    exit;
}

if (!$cart):
?>
    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Giỏ hàng trống - FlowerGiftNow</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="assets/css/modern-design.css">
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 50%, #FBCFE8 100%);
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
                padding: 1rem;
            }
        </style>
    </head>

    <body>
        <div class="card-modern" style="max-width: 500px; padding: 3rem 2rem; text-align: center;">
            <i class="zmdi zmdi-shopping-cart" style="font-size: 5rem; color: var(--gray-400); margin-bottom: 1.5rem;"></i>
            <h3 style="color: var(--text-primary); margin-bottom: 0.75rem;">Giỏ hàng của bạn đang trống</h3>
            <p style="color: var(--text-secondary); margin-bottom: 2rem;">Hãy chọn những sản phẩm yêu thích và thêm vào giỏ hàng nhé!</p>
            <a href="index.php" class="btn-modern btn-primary btn-lg">
                <i class="zmdi zmdi-shopping-cart-plus"></i> Bắt đầu mua sắm
            </a>
        </div>
    </body>

    </html>
<?php exit;
endif; ?>

<?php
// Mã PHP tiếp tục ở đây sau endif
$placeholders = implode(',', array_fill(0, count($cart), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->execute(array_keys($cart));
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giỏ hàng - FlowerGiftNow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="assets/css/modern-design.css">
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
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--radius-lg);
        }
        .card-modern {
            box-shadow: 0 4px 20px rgba(236, 72, 153, 0.1);
            border: 1px solid rgba(236, 72, 153, 0.1);
        }

        /* ===== RESPONSIVE STYLES ===== */
        /* Mobile Layout - Card Style */
        @media (max-width: 768px) {
            .container {
                padding: 1rem !important;
            }
            .card-modern {
                padding: 1rem !important;
            }
            .page-header h2 {
                font-size: 1.5rem;
            }
            .page-header p {
                font-size: 0.875rem;
            }
            
            /* Hide table header on mobile */
            .table thead {
                display: none;
            }
            
            /* Transform table rows into cards */
            .table tbody tr {
                display: block;
                background: var(--gray-50);
                border-radius: var(--radius-lg);
                padding: 1rem;
                margin-bottom: 1rem;
                border: 1px solid var(--gray-200) !important;
            }
            
            .table tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.5rem 0 !important;
                border: none !important;
                text-align: right;
            }
            
            .table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--text-primary);
                text-align: left;
                flex-shrink: 0;
                margin-right: 1rem;
            }
            
            /* Product cell - special layout */
            .table tbody td:first-child {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
                padding-bottom: 0.75rem !important;
                border-bottom: 1px solid var(--gray-200) !important;
                margin-bottom: 0.5rem;
            }
            
            .table tbody td:first-child::before {
                display: none;
            }
            
            .table tbody td:first-child > div {
                width: 100%;
            }
            
            .product-img {
                width: 60px;
                height: 60px;
            }
            
            /* Quantity input */
            .qty-input {
                width: 60px !important;
            }
            
            /* Footer rows */
            .table tfoot tr {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0;
            }
            
            .table tfoot td {
                padding: 0 !important;
            }
            
            .table tfoot td[colspan="3"] {
                text-align: left !important;
            }
            
            .table tfoot td:last-child:empty {
                display: none;
            }
            
            /* Action buttons */
            .cart-actions {
                flex-direction: column;
            }
            
            .cart-actions a {
                width: 100%;
                justify-content: center;
            }
            
            /* Coupon section */
            .coupon-form {
                flex-direction: column;
            }
            
            .coupon-form input {
                width: 100%;
            }
            
            .coupon-form button {
                width: 100%;
            }
            
            .alert-modern {
                padding: 1rem !important;
                flex-direction: column;
                text-align: center;
            }
        }
        
        /* Tablet adjustments */
        @media (min-width: 769px) and (max-width: 991px) {
            .product-img {
                width: 60px;
                height: 60px;
            }
            
            .table th, .table td {
                padding: 0.75rem !important;
                font-size: 0.875rem;
            }
            
            .qty-input {
                width: 60px !important;
            }
        }
        
        /* Small phone adjustments */
        @media (max-width: 375px) {
            .page-header h2 {
                font-size: 1.25rem;
            }
            
            .product-img {
                width: 50px;
                height: 50px;
            }
            
            .btn-modern {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }
            
            .btn-lg {
                padding: 0.625rem 1rem !important;
                font-size: 0.9rem !important;
            }
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="page-header" style="text-align: center; margin-bottom: 2rem;">
            <h2>
                <i class="zmdi zmdi-shopping-cart"></i> Giỏ hàng của bạn
            </h2>
            <p style="color: var(--text-secondary); font-weight: 600; margin:0;">Quản lý sản phẩm trong giỏ hàng của bạn</p>
        </div>

        <div class="card-modern" style="padding: 2rem;">

            <div class="table-responsive">
                <table class="table align-middle" style="margin-bottom: 0;">
                    <thead style="background: var(--gray-100); border-bottom: 2px solid var(--gray-200);">
                        <tr>
                            <th style="padding: 1rem; font-weight: 600; color: var(--text-primary);">Sản phẩm</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--text-primary);">Đơn giá</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--text-primary);">Số lượng</th>
                            <th style="padding: 1rem; text-align: right; font-weight: 600; color: var(--text-primary);">Thành tiền</th>
                            <th style="padding: 1rem; text-align: center; font-weight: 600; color: var(--text-primary);">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="cart-body">
                        <?php foreach ($products as $p):
                            $qty = $cart[$p['id']];
                            $subtotal = $qty * $p['price'];
                        ?>
                            <tr data-id="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>" style="border-bottom: 1px solid var(--gray-200);">
                                <td data-label="Sản phẩm" style="padding: 1rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <img src="assets/images/<?= htmlspecialchars($p['image']) ?>"
                                            alt="<?= htmlspecialchars($p['name']) ?>"
                                            class="product-img">
                                        <span style="font-weight: 600; color: var(--text-primary);">
                                            <?= htmlspecialchars($p['name']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td data-label="Đơn giá" class="unit-price" style="padding: 1rem; text-align: center; color: var(--text-secondary);">
                                    <?= number_format($p['price'], 0, ',', '.') ?>₫
                                </td>
                                <td data-label="Số lượng" style="padding: 1rem;">
                                    <form action="update_cart.php" method="post" style="display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
                                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                        <input
                                            type="number"
                                            name="qty"
                                            class="qty-input"
                                            style="width: 70px; padding: 0.5rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); text-align: center;"
                                            value="<?= $qty ?>"
                                            min="1">
                                        <button class="btn-modern btn-primary btn-sm">
                                            <i class="zmdi zmdi-check"></i>
                                        </button>
                                    </form>
                                </td>
                                <td data-label="Thành tiền" class="subtotal" style="padding: 1rem; text-align: right; font-weight: 700; color: var(--primary);">
                                    <?= number_format($subtotal, 0, ',', '.') ?>₫
                                </td>
                                <td data-label="Xóa" style="padding: 1rem; text-align: center;">
                                    <a href="remove_from_cart.php?id=<?= $p['id'] ?>"
                                        class="btn-modern btn-danger btn-sm"
                                        onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                        <i class="zmdi zmdi-delete"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot style="background: var(--gray-50);">
                        <tr style="border-top: 2px solid var(--gray-200);">
                            <td colspan="3" style="padding: 1rem; text-align: right; font-weight: 600; color: var(--text-primary); background: none; border: none;">Tạm tính:</td>
                            <td id="subtotal-cell" style="padding: 1rem; text-align: right; font-weight: 600; color: var(--text-primary); background: none; border: none;"><?= number_format(array_sum(array_map(fn($p) => $p['price'] * $cart[$p['id']], $products)), 0, ',', '.') ?>₫</td>
                            <td></td>
                        </tr>
                        <?php if (!empty($_SESSION['coupon'])):
                            $subtotal_amount = array_sum(array_map(fn($p) => $p['price'] * $cart[$p['id']], $products));
                            $coupon_discount = round($subtotal_amount * ($_SESSION['coupon']['discount'] / 100));
                        ?>
                            <tr>
                                <td colspan="3" style="padding: 1rem; text-align: right; font-weight: 600; color: var(--text-primary);">
                                    Giảm giá
                                    <span class="badge-modern badge-success" style="margin-left: 0.5rem;"><?= htmlspecialchars($_SESSION['coupon']['code']) ?></span>:
                                </td>
                                <td class="text-success" id="coupon-discount-cell" style="padding: 1rem; text-align: right; font-weight: 600; color: var(--success);">-<?= number_format($coupon_discount, 0, ',', '.') ?>₫</td>
                                <td></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="3" style="padding: 1rem; text-align: right; font-weight: 600; color: var(--text-primary); background: none; border: none;">Phí vận chuyển:</td>
                            <td id="shipping-cell" style="padding: 1rem; text-align: right; font-weight: 600; background: none; border: none;"></td>
                            <td></td>
                        </tr>
                        <tr style="background: var(--gray-100); border-top: 2px solid var(--gray-700);">
                            <td colspan="3" style="padding: 1.25rem; text-align: right; font-weight: 700; color: var(--text-primary); font-size: 1.1rem; background: none; border: none;">Tổng cộng:</td>
                            <td id="grand-total-cell" style="padding: 1.25rem; text-align: right; font-weight: 700; color: var(--primary); font-size: 1.25rem; background: none; border: none;"></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- COUPON SECTION -->
                <div style="margin-top: 2rem; padding-top: 2rem; ">
                    <h5 style="text-align: center; color: var(--text-primary); margin-bottom: 1rem; font-weight: 600;">
                        <i class="zmdi zmdi-card-giftcard"></i> Mã giảm giá
                    </h5>

                    <?php if (!empty($_SESSION['coupon'])): ?>
                        <div class="alert-modern alert-success" style="text-align: center; margin-bottom: 1rem;">
                            <div style="margin-bottom: 0.5rem;">
                                <strong><i class="zmdi zmdi-check-circle"></i> Đã áp dụng mã: <?= htmlspecialchars($_SESSION['coupon']['code']) ?></strong>
                            </div>
                            <div style="color: var(--text-secondary); margin-bottom: 1rem;">
                                Giảm <?= $_SESSION['coupon']['discount'] ?>% trên tổng đơn hàng
                            </div>
                            <form method="post" action="apply_coupon.php" style="display: inline;">
                                <input type="hidden" name="remove_coupon" value="1">
                                <button type="submit" class="btn-modern btn-danger btn-sm">
                                    <i class="zmdi zmdi-close"></i> Hủy mã
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <form method="post" action="apply_coupon.php" class="coupon-form" style="max-width: 400px; margin: 0 auto 1rem;">
                            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                <input
                                    type="text"
                                    name="coupon_code"
                                    style="flex: 1; min-width: 200px; padding: 0.75rem 1rem; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); transition: all 0.3s ease;"
                                    placeholder="Nhập mã giảm giá"
                                    onfocus="this.style.borderColor='var(--primary)'"
                                    onblur="this.style.borderColor='var(--gray-200)'"
                                    required>
                                <button class="btn-modern btn-primary" type="submit">
                                    <i class="zmdi zmdi-check"></i> Áp dụng
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['coupon_message'])): ?>
                        <div class="alert-modern alert-<?= $_SESSION['coupon_success'] ? 'success' : 'danger' ?>" style="text-align: center; margin-top: 1rem;">
                            <?= $_SESSION['coupon_message'] ?>
                        </div>
                        <?php unset($_SESSION['coupon_message'], $_SESSION['coupon_success']); ?>
                    <?php endif; ?>
                </div>


                <div class="cart-actions" style="display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; padding-top: 2rem; border-top: 2px solid var(--gray-200); gap: 1rem; flex-wrap: wrap;">
                    <a href="index.php" class="btn-modern btn-ghost">
                        <i class="zmdi zmdi-arrow-left"></i> Tiếp tục mua sắm
                    </a>
                    <a href="checkout.php" class="btn-modern btn-primary btn-lg">
                        <i class="zmdi zmdi-card"></i> Thanh toán
                    </a>
                </div>
            </div>
        </div>

        <script>
            // Cập nhật tổng cộng và phí ship
            function updateTotals() {
                let total = 0;

                document.querySelectorAll('#cart-body tr').forEach(row => {
                    const price = parseInt(row.dataset.price);
                    const qtyInput = row.querySelector('.qty-input');
                    const qty = parseInt(qtyInput.value);
                    const subtotal = price * qty;

                    row.querySelector('.subtotal').textContent = subtotal.toLocaleString('vi-VN') + '₫';
                    total += subtotal;
                });

                // Cập nhật DOM
                document.getElementById('subtotal-cell').textContent = total.toLocaleString('vi-VN') + '₫';

                // Tính giảm giá nếu có coupon
                let coupon_discount = 0;
                const couponDiscountCell = document.getElementById('coupon-discount-cell');
                if (couponDiscountCell) {
                    // Lấy phần trăm giảm từ PHP session (được render sẵn)
                    <?php if (!empty($_SESSION['coupon']['discount'])): ?>
                        coupon_discount = Math.round(total * (<?= $_SESSION['coupon']['discount'] ?> / 100));
                        couponDiscountCell.textContent = '-' + coupon_discount.toLocaleString('vi-VN') + '₫';
                    <?php endif; ?>
                }

                let shipping = total >= 500000 ? 0 : 30000;
                document.getElementById('shipping-cell').innerHTML = shipping === 0 ?
                    '<span style="color: var(--success); font-weight: 600;">Miễn phí</span>' :
                    shipping.toLocaleString('vi-VN') + '₫';

                let grand = total + shipping - coupon_discount;
                document.getElementById('grand-total-cell').textContent = grand.toLocaleString('vi-VN') + '₫';
            }

            // Gọi khi load xong
            document.addEventListener('DOMContentLoaded', function() {
                updateTotals();

                document.querySelectorAll('.qty-input').forEach(input => {
                    input.addEventListener('input', updateTotals);
                });
            });
        </script>

</body>

</html>