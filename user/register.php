<?php
require '../includes/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if (!$name || !$username || !$email || !$phone || !$password || !$confirm) {
        $error = 'Vui lòng điền đầy đủ thông tin.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username)) {
        $error = 'Tên người dùng chỉ được chứa chữ, số, dấu gạch dưới và từ 4-20 ký tự.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email không hợp lệ.';
    } elseif ($password !== $confirm) {
        $error = 'Mật khẩu xác nhận không khớp.';
    } else {
        // Kiểm tra email hoặc username đã tồn tại chưa
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? OR username = ?');
        $stmt->execute([$email, $username]);
        if ($stmt->fetch()) {
            $error = 'Email hoặc tên người dùng đã được đăng ký.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (name, username, email, phone, password) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$name, $username, $email, $phone, $hash]);
            header('Location: login.php?registered=1');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản - FlowerGiftNow</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../assets/css/modern-design.css">
    <style>
        :root {
            --primary: #EC4899;
            --primary-dark: #DB2777;
            --primary-light: #F472B6;
        }
        body {
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 50%, #FBCFE8 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .auth-card {
            width: 100%;
            max-width: 550px;
        }
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .auth-header img {
            width: 60px;
            height: 60px;
            margin-bottom: 1rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb), 0.1);
        }
        .form-label {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        @media (max-width: 576px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <div class="card-modern" style="padding: 2rem;">
            <div class="auth-header">
                <div class="d-flex justify-content-center align-items-center gap-2 ">
                <img src="../assets/images/icons/sign-up-color.png" alt="FlowerGiftNow Logo">
                <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary);">Tạo tài khoản mới</h2>
                </div>
                <p style="color: var(--text-secondary); margin: 0; font-weight: 700;">Đăng ký để trải nghiệm mua sắm tuyệt vời</p>
            </div>

            <?php if ($error): ?>
                <div class="alert-modern alert-danger" style="margin-bottom: 1.5rem;">
                    <i class="zmdi zmdi-alert-circle"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="name" class="form-label d-flex align-items-center gap-2" style="font-weight: 700; color: var(--text-primary);">
                        <i class="zmdi zmdi-account"></i> Họ và tên
                    </label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ và tên đầy đủ" required>
                </div>
                
                <div class="form-row mb-3">
                    <div>
                        <label for="username" class="form-label d-flex align-items-center gap-2" style="font-weight: 700; color: var(--text-primary);">
                            <i class="zmdi zmdi-account-box"></i> Tên đăng nhập
                        </label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="4-20 ký tự" required>
                    </div>
                    <div>
                        <label for="phone" class="form-label d-flex align-items-center gap-2" style="font-weight: 700; color: var(--text-primary);">
                            <i class="zmdi zmdi-phone"></i> Số điện thoại
                        </label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="0123456789" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label d-flex align-items-center gap-2" style="font-weight: 700; color: var(--text-primary);">
                        <i class="zmdi zmdi-email"></i> Email
                    </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com" required>
                </div>
                
                <div class="form-row mb-4">
                    <div>
                        <label for="password" class="form-label d-flex align-items-center gap-2" style="font-weight: 700; color: var(--text-primary);">
                            <i class="zmdi zmdi-lock"></i> Mật khẩu
                        </label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                    </div>
                    <div>
                        <label for="confirm" class="form-label d-flex align-items-center gap-2" style="font-weight: 700; color: var(--text-primary);">
                            <i class="zmdi zmdi-lock-outline"></i> Xác nhận
                        </label>
                        <input type="password" class="form-control" id="confirm" name="confirm" placeholder="Nhập lại mật khẩu" required>
                    </div>
                </div>

                <button type="submit" class="btn-modern btn-primary btn-lg" style="width: 100%;">
                    <i class="zmdi zmdi-account-add"></i> Đăng ký tài khoản
                </button>
            </form>

            <div style="margin-top: 1.25rem; text-align: center; padding-top: 1.25rem; border-top: 1px solid var(--gray-200);">
                <p style="color: var(--text-secondary); margin: 0;">
                    Đã có tài khoản? 
                    <a href="login.php" style="color: var(--primary); font-weight: 600; text-decoration: none;">
                        Đăng nhập ngay
                    </a>
                </p>
            </div>

            <div style="margin-top: 1rem; text-align: center;">
                <a href="../index.php" class="btn-modern btn-ghost btn-sm">
                    <i class="fa fa-arrow-left"></i> Quay về trang chủ
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
