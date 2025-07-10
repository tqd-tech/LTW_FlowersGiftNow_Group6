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
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Đăng nhập</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($_GET['registered'])): ?>
                        <div class="alert alert-success">Đăng ký thành công! Vui lòng đăng nhập.</div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <form method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email hoặc tên đăng nhập</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Đăng nhập</button>
                    </form>
                    <div class="mt-3 text-center">
                        Chưa có tài khoản? <a href="register.php">Đăng ký</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
