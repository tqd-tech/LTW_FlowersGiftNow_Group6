<?php
session_start();
require 'includes/db.php';

$order = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if ($order_id && $phone) {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND customer_phone = ?");
        $stmt->execute([$order_id, $phone]);
        $order = $stmt->fetch();

        if ($order) {
            $_SESSION['last_order_id'] = $order_id;
            header("Location: track.php");
            exit;
        } else {
            $error = "Không tìm thấy đơn hàng với mã và số điện thoại đã nhập.";
        }
    } else {
        $error = "Vui lòng nhập đầy đủ thông tin.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu đơn hàng - Flowers Gift</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #EC4899;
            --primary-dark: #DB2777;
            --primary-light: #F472B6;
            --secondary: #6366F1;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-500: #6B7280;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 50%, #FBCFE8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .track-container {
            width: 100%;
            max-width: 480px;
        }

        .track-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .card-header .icon {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .card-header .icon i {
            font-size: 2rem;
        }

        .card-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .card-header p {
            opacity: 0.9;
            font-size: 0.9rem;
            margin: 0;
        }

        .card-body {
            padding: 2rem;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            border: 1px solid #FECACA;
            color: #991B1B;
        }

        .alert-danger i {
            color: var(--danger);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-label i {
            color: var(--primary);
            margin-right: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.1);
        }

        .form-control::placeholder {
            color: var(--gray-300);
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: var(--gray-500);
            text-decoration: none;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-100);
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: var(--primary);
        }

        .help-text {
            background: var(--gray-50);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1.5rem;
        }

        .help-text h4 {
            font-size: 0.85rem;
            color: var(--gray-700);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .help-text p {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin: 0;
            line-height: 1.5;
        }
    </style>
</head>
<body>

<div class="track-container">
    <div class="track-card">
        <div class="card-header">
            <div class="icon">
                <i class="fas fa-search"></i>
            </div>
            <h1>Tra cứu đơn hàng</h1>
            <p>Nhập thông tin để kiểm tra trạng thái đơn hàng</p>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= $error ?></span>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-hashtag"></i>Mã đơn hàng
                    </label>
                    <input type="text" name="order_id" class="form-control" 
                           placeholder="Nhập mã đơn hàng (VD: 12345)" required>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-phone"></i>Số điện thoại
                    </label>
                    <input type="tel" name="phone" class="form-control" 
                           placeholder="Nhập SĐT khi đặt hàng" required>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-search"></i>
                    Tra cứu ngay
                </button>
            </form>

            <div class="help-text">
                <h4><i class="fas fa-info-circle"></i> Hướng dẫn</h4>
                <p>Mã đơn hàng được gửi qua email hoặc hiển thị khi bạn hoàn tất đặt hàng. Số điện thoại là số bạn đã nhập khi đặt hàng.</p>
            </div>

            <a href="index.php" class="back-link">
                <i class="fas fa-arrow-left"></i>
                Quay lại trang chủ
            </a>
        </div>
    </div>
</div>

</body>
</html>
