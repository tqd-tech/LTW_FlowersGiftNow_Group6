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
    <style>
        body {
            background-image: linear-gradient(120deg, #a6c0fe 0%, #f68084 100%);
            min-height: 100vh;
        }
        .shadow-2xl {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .card-body {
            background-image: linear-gradient(to top, #f3e7e9 0%, #e3eeff 99%, #e3eeff 100%);
        }
    </style>
</head>
<body>
<div class="container py-5" style="height: 100vh;">
    <div class="d-flex justify-content-center align-items-center h-100"  >
        <div class="col-md-6">
            <div class="card shadow-2xl rounded-4 " style="box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);">
                <div class="card-header  text-black text-center fw-bold d-flex justify-content-center align-items-center gap-2 py-3 rounded-4 rounded-bottom-0 border-0" style="background-image: linear-gradient(to top, #e6e9f0 0%, #eef1f5 100%);">
                    <img src="../assets/images/icons/flower.png" alt="Logo" style="height: 40px; ">
                    <h4 class="fw-bold">Đăng nhập</h4>
                </div>
                <div class="card-body rounded-4 rounded-top-0">
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
                        <button type="submit" class="btn btn-success w-100 shadow-2xl">Đăng nhập</button>
                    </form>
                    <div class="mt-3 text-center">
                        Chưa có tài khoản? <a href="register.php" class="fw-bold">Đăng ký</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
