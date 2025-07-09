<?php
// File: apply_coupon.php

session_start();
require 'includes/db.php';  // trong file này phải khởi tạo $pdo (PDO connection)

// Xóa thông báo cũ
unset($_SESSION['coupon_message'], $_SESSION['coupon_success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['coupon_code'])) {
    $code = trim($_POST['coupon_code']);

    // Chuẩn bị query kiểm tra coupon
    $stmt = $pdo->prepare("
        SELECT id, discount_percent, start_date, end_date
        FROM coupons
        WHERE code = :code
        LIMIT 1
    ");
    $stmt->execute(['code' => $code]);
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($coupon) {
        $today = new DateTime();
        $start = new DateTime($coupon['start_date']);
        $end   = new DateTime($coupon['end_date']);

        if ($today >= $start && $today <= $end) {
            // Lưu coupon vào SESSION
            $_SESSION['coupon'] = [
                'id'       => $coupon['id'],
                'code'     => $coupon['code'],
                'discount' => (float)$coupon['discount_percent']
            ];
            $_SESSION['coupon_message'] = "Áp dụng thành công mã «{$code}» giảm {$coupon['discount_percent']}%";
            $_SESSION['coupon_success'] = true;
        } else {
            // Coupon đã hết hạn hoặc chưa đến ngày hiệu lực
            $_SESSION['coupon_message'] = "Mã «{$code}» không còn hiệu lực.";
            $_SESSION['coupon_success'] = false;
            unset($_SESSION['coupon']);
        }
    } else {
        // Không tìm thấy coupon
        $_SESSION['coupon_message'] = "Mã «{$code}» không hợp lệ.";
        $_SESSION['coupon_success'] = false;
        unset($_SESSION['coupon']);
    }
}

// Quay trở lại trang cart
header('Location: cart.php');
exit;