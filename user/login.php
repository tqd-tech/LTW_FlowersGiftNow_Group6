<?php
session_start();
require_once '../includes/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$email || !$password) {
        $error = 'Vui lòng nhập đầy đủ thông tin.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? OR username = ?');
        $stmt->execute([$email, $email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            header('Location: ../index.php');
            exit;
        } else {
            $error = 'Email/Tên đăng nhập hoặc mật khẩu không đúng.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - FlowerGiftNow</title>
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
            max-width: 450px;
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
    </style>
</head>
<body>
<div class="auth-container">
    <div class="auth-card">
        <div class="card-modern" style="padding: 2rem;">
            <div class="auth-header">
                <div class="d-flex justify-content-center align-items-center gap-2 ">
                <img src="../assets/images/icons/sign-in-pink.png"  alt="FlowerGiftNow Logo">
                <h2 style="font-size: 1.75rem; font-weight: 700; color: var(--text-primary); ">Đăng nhập</h2>
                </div>
            <p style="color: var(--text-secondary); margin: 0; font-weight: 700;">Đăng nhập để mở rộng nhiều tính năng</p>
            </div>

            <?php if (isset($_GET['registered'])): ?>
                <div class="alert-modern alert-success" style="margin-bottom: 1.5rem;">
                    <i class="zmdi zmdi-check-circle"></i>
                    Đăng ký thành công! Vui lòng đăng nhập.
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert-modern alert-danger" style="margin-bottom: 1.5rem;">
                    <i class="zmdi zmdi-alert-circle"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label d-flex align-items-center gap-2" style="font-weight: 700; color: var(--text-primary);">
                        <i class="zmdi zmdi-account"></i> Email hoặc username
                    </label>
                    <input type="text" class="form-control " id="email" name="email" placeholder="Nhập email hoặc username" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label d-flex align-items-center gap-2" style="font-weight: 700; color: var(--text-primary);">
                        <i class="zmdi zmdi-lock"></i> Mật khẩu
                    </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>
                <button type="submit" class="btn-modern btn btn-primary btn-lg" style="width: 100%;">
                    <i class="zmdi zmdi-lock-open"></i> Đăng nhập
                </button>
            </form>

            <div style="margin-top: 1.25rem; text-align: center; padding-top: 1.25rem; border-top: 1px solid var(--gray-200);">
                <p style="color: var(--text-secondary); margin: 0;">
                    Chưa có tài khoản? 
                    <a href="register.php" style="color: var(--primary); font-weight: 600; text-decoration: none;">
                        Đăng ký ngay
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
