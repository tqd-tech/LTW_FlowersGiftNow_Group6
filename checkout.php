<?php
session_start();
require 'includes/db.php';

$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    echo "<div class='container mt-5 text-center'><h3>🛒 Giỏ hàng trống!</h3><a href='index.php' class='btn btn-primary mt-3'>Quay lại mua hàng</a></div>";
    exit;
}

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
$total = $subtotal + $shipping;

// Xử lý đặt hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';

    if ($name && $phone && $address) {
        // Lưu đơn hàng
        $pdo->prepare("
            INSERT INTO orders (user_id, customer_name, customer_phone, customer_address, total_price, status) 
            VALUES (NULL, ?, ?, ?, ?, 'pending')
        ")->execute([$name, $phone, $address, $total]);

        $order_id = $pdo->lastInsertId();

        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($products as $p) {
            $stmt->execute([$order_id, $p['id'], $cart[$p['id']], $p['price']]);
        }

        $_SESSION['cart'] = [];
        $_SESSION['last_order_id'] = $order_id;
        header("Location: track.php");
        exit;
    } else {
        $error = "Vui lòng điền đầy đủ thông tin.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="bg-white p-4 rounded shadow-sm">
        <h2 class="mb-4 text-primary text-center">🧾 Xác nhận đặt hàng</h2>

        <h5 class="mb-3">🛍️ Giỏ hàng của bạn</h5>
        <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= number_format($p['price'], 0, ',', '.') ?> VND</td>
                        <td><?= $cart[$p['id']] ?></td>
                        <td><?= number_format($p['price'] * $cart[$p['id']], 0, ',', '.') ?> VND</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">Tạm tính:</td>
                        <td><?= number_format($subtotal, 0, ',', '.') ?> VND</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Phí vận chuyển:</td>
                        <td>
                            <?= $shipping == 0 ? '<span class="text-success">Miễn phí</span>' : number_format($shipping, 0, ',', '.') . ' VND' ?>
                        </td>
                    </tr>
                    <tr class="table-info">
                        <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                        <td class="text-danger fw-bold"><?= number_format($total, 0, ',', '.') ?> VND</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <h5 class="mb-3">📦 Thông tin người nhận</h5>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Nguyễn Văn A">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" class="form-control" required placeholder="0123456789">
                </div>
                <div class="col-12 mb-3">
                    <label for="address" class="form-label">Địa chỉ nhận hàng</label>
                    <textarea name="address" id="address" class="form-control" rows="3" required placeholder="Số nhà, phường, quận, thành phố..."></textarea>
                </div>
            </div>
            <div class="text-end">
                <a href="cart.php" class="btn btn-secondary">← Quay lại giỏ hàng</a>
                <button type="submit" class="btn btn-success">✅ Xác nhận đặt hàng</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
