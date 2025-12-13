<?php
session_start();

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
            <i class="zmdi zmdi-shopping-cart" style="font-size: 4rem; color: var(--warning); margin-bottom: 1rem;"></i>
            <h2 style="color: var(--text-primary); margin-bottom: 0.75rem; font-size: 1.5rem;">Bạn chưa đăng nhập</h2>
            <p style="color: var(--text-secondary); margin-bottom: 2rem;">Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng và tiếp tục mua sắm.</p>
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


$id = $_GET['id'] ?? null;

if ($id) {
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header('Location: cart.php');
    exit;
} else {
    echo "Thiếu ID sản phẩm!";
}
