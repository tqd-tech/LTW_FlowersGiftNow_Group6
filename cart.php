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
        <title>Yêu cầu đăng nhập</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f8f8f8;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .alert-box {
                background: white;
                padding: 30px;
                box-shadow: 0 0 15px rgba(0,0,0,0.1);
                border-radius: 10px;
                text-align: center;
            }
            .alert-box h2 {
                color: #e74c3c;
            }
            .alert-box p {
                margin: 15px 0;
                font-size: 16px;
            }
            .alert-box a {
                display: inline-block;
                margin-top: 10px;
                padding: 10px 20px;
                background: #3498db;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                transition: 0.3s;
            }
            .alert-box a:hover {
                background: #2980b9;
            }
        </style>
    </head>
    <body>
        <div class="alert-box">
            <h2>Bạn chưa đăng nhập</h2>
            <p>Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.</p>
            <a href="user/login.php">Đăng nhập ngay</a>
            <br><br>
            <a href="index.php" style="background:#7f8c8d;">Quay lại trang chủ</a>
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
    <title>Giỏ hàng trống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .empty-cart {
            min-height: 70vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(145deg, #f3f4f6, #ffffff);
        }
        .empty-cart i {
            font-size: 4rem;
            color: #d63384;
        }
    </style>
</head>
<body>
<div class="empty-cart text-center p-5">
    <i class="fas fa-shopping-basket mb-3"></i>
    <h3>Giỏ hàng của bạn đang trống</h3>
    <p class="text-muted">Hãy chọn những sản phẩm yêu thích và thêm vào giỏ hàng nhé!</p>
    <a href="index.php" class="btn btn-primary mt-3 px-4 py-2">🛍️ Quay lại mua sắm</a>
</div>
</body>
</html>
<?php exit; endif; ?>

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
    <title>Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="bg-white p-5 rounded shadow-sm">
    <h2 class="mb-4 text-center text-uppercase text-primary fw-bold">
        <i class="fas fa-shopping-basket me-2"></i>Giỏ hàng của bạn
    </h2>

    <div class="table-responsive rounded">
        <table class="table table-hover align-middle table-bordered text-center shadow-sm">
            <thead class="table-primary text-dark">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
                <tbody id="cart-body">
                <?php foreach ($products as $p): 
                    $qty = $cart[$p['id']];
                    $subtotal = $qty * $p['price'];
                ?>
                    <tr data-id="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>">
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td class="unit-price"><?= number_format($p['price'], 0, ',', '.') ?> VND</td>
                        <td>
                            <form action="update_cart.php" method="post" class="d-flex justify-content-center align-items-center gap-2">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <input 
                                    type="number" 
                                    name="qty"
                                    class="form-control form-control-sm qty-input" 
                                    style="width: 60px;" 
                                    value="<?= $qty ?>" 
                                    min="1">
                                <button class="btn btn-sm btn-outline-primary"><i class="fas fa-sync"></i></button>
                            </form>
                        </td>
                        <td class="subtotal"><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
                        <td>
                            <a href="remove_from_cart.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa sản phẩm này?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">Tạm tính:</td>
                        <td id="subtotal-cell"><?= number_format(array_sum(array_map(fn($p) => $p['price'] * $cart[$p['id']], $products)), 0, ',', '.') ?> VND</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Phí vận chuyển:</td>
                        <td id="shipping-cell"></td>
                        <td></td>
                    </tr>
                    <tr class="table-info fw-bold">
                        <td colspan="3" class="text-end">Tổng cộng:</td>
                        <td id="grand-total-cell" class="text-danger fw-bold"></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <!-- FORM NHẬP MÃ GIẢM GIÁ -->
<h5 class="text-center mt-4">🔖 Mã giảm giá</h5>
<form method="post" action="checkout.php" class="coupon-form mt-2 mb-4">
  <div class="input-group w-fit mx-auto">
    <input 
      type="text" 
      name="coupon_code" 
      class="form-control" 
      placeholder="Nhập mã giảm giá" 
      required>
    <button 
      class="btn btn-primary" 
      type="submit" 
      name="apply_coupon">
      Áp dụng và thanh toán
    </button>
  </div>
</form>


<?php if (!empty($_SESSION['coupon_message'])): ?>
  <div class="alert alert-<?= $_SESSION['coupon_success'] ? 'success' : 'danger' ?> text-center">
    <?= $_SESSION['coupon_message'] ?>
  </div>
  <?php unset($_SESSION['coupon_message'], $_SESSION['coupon_success']); ?>
<?php endif; ?>


<div class="text-end mt-4">
  <a href="index.php" class="btn btn-outline-secondary me-2">
    <i class="fas fa-arrow-left me-1"></i> Tiếp tục mua sắm
  </a>
  <a href="checkout.php" class="btn btn-success">
    <i class="fas fa-credit-card me-1"></i> Thanh toán
  </a>
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

        row.querySelector('.subtotal').textContent = subtotal.toLocaleString('vi-VN') + ' VND';
        total += subtotal;
    });

    // Cập nhật DOM
    document.getElementById('subtotal-cell').textContent = total.toLocaleString('vi-VN') + ' VND';

    let shipping = total >= 500000 ? 0 : 30000;
    document.getElementById('shipping-cell').innerHTML = shipping === 0
        ? '<span class="text-success">Miễn phí</span>'
        : shipping.toLocaleString('vi-VN') + ' VND';

    let grand = total + shipping;
    document.getElementById('grand-total-cell').textContent = grand.toLocaleString('vi-VN') + ' VND';
}

// Gọi khi load xong
document.addEventListener('DOMContentLoaded', function () {
    updateTotals();

    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('input', updateTotals);
    });
});
</script>

</body>
</html>
