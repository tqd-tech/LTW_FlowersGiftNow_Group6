<?php
session_start();

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


$id = $_GET['id'] ?? null;

if ($id) {
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    header('Location: cart.php');
    exit;
} else {
    echo "Thiếu ID sản phẩm!";
}
