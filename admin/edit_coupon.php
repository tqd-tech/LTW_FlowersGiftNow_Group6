<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/login.php');
    exit;
}
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: coupons.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM coupons WHERE id = ?');
$stmt->execute([$id]);
$coupon = $stmt->fetch();
if (!$coupon) {
    header('Location: coupons.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');
    $discount = (int)($_POST['discount_percent'] ?? 0);
    $start = $_POST['start_date'] ?? '';
    $end = $_POST['end_date'] ?? '';
    if (!$code || !$discount || !$start || !$end) {
        $error = 'Vui lòng nhập đầy đủ thông tin.';
    } else {
        $stmt = $pdo->prepare('UPDATE coupons SET code=?, discount_percent=?, start_date=?, end_date=? WHERE id=?');
        $stmt->execute([$code, $discount, $start, $end, $id]);
        header('Location: coupons.php?updated=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa mã khuyến mãi - Admin</title>
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
            color: var(--gray-700);
        }

        .admin-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-title h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0;
        }

        .page-title i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            border: none;
        }

        .btn-back {
            background: white;
            color: var(--gray-700);
            border: 2px solid var(--gray-200);
        }

        .btn-back:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-home {
            background: var(--primary);
            color: white;
        }

        .btn-home:hover {
            background: var(--primary-dark);
            color: white;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-header i { font-size: 1.25rem; }
        .card-header h3 { font-size: 1.1rem; font-weight: 600; margin: 0; }

        .card-body { padding: 1.5rem; }

        .form-group { margin-bottom: 1.25rem; }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-label .required {
            color: var(--danger);
            margin-left: 2px;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        @media (max-width: 576px) {
            .form-row { grid-template-columns: 1fr; }
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

        .btn-group-form {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-100);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: white;
            flex: 1;
            justify-content: center;
            padding: 0.875rem 1.5rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
            color: white;
        }

        .btn-cancel {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .btn-cancel:hover {
            background: var(--gray-200);
        }

        .discount-preview {
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 100%);
            border: 2px dashed var(--primary-light);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            margin-top: 1rem;
        }

        .discount-preview .code {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: 2px;
        }

        .discount-preview .percent {
            font-size: 2rem;
            font-weight: 800;
            color: var(--danger);
        }

        .coupon-id-badge {
            background: rgba(255,255,255,0.2);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-left: auto;
        }

        .form-hint {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>

<div class="admin-container">
    <div class="page-header">
        <div class="page-title">
            <i class="fas fa-edit"></i>
            <h1>Sửa mã khuyến mãi</h1>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="coupons.php" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="../index.php" class="btn btn-home">
                <i class="fas fa-home"></i> Trang chủ
            </a>
        </div>
    </div>

    <div class="form-card">
        <div class="card-header">
            <i class="fas fa-ticket-alt"></i>
            <h3>Thông tin mã giảm giá</h3>
            <span class="coupon-id-badge">ID: #<?= $id ?></span>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-code" style="color: var(--primary); margin-right: 0.5rem;"></i>
                        Mã khuyến mãi <span class="required">*</span>
                    </label>
                    <input type="text" name="code" id="codeInput" class="form-control" 
                           value="<?= htmlspecialchars($coupon['code']) ?>" required style="text-transform: uppercase;">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-percent" style="color: var(--primary); margin-right: 0.5rem;"></i>
                        Chiết khấu (%) <span class="required">*</span>
                    </label>
                    <input type="number" name="discount_percent" id="discountInput" class="form-control" 
                           min="1" max="100" value="<?= $coupon['discount_percent'] ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt" style="color: var(--primary); margin-right: 0.5rem;"></i>
                            Ngày bắt đầu <span class="required">*</span>
                        </label>
                        <input type="date" name="start_date" class="form-control" value="<?= $coupon['start_date'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-check" style="color: var(--primary); margin-right: 0.5rem;"></i>
                            Ngày kết thúc <span class="required">*</span>
                        </label>
                        <input type="date" name="end_date" class="form-control" value="<?= $coupon['end_date'] ?>" required>
                    </div>
                </div>

                <div class="discount-preview">
                    <div class="code" id="previewCode"><?= htmlspecialchars($coupon['code']) ?></div>
                    <div class="percent">Giảm <span id="previewPercent"><?= $coupon['discount_percent'] ?></span>%</div>
                </div>

                <div class="btn-group-form">
                    <a href="coupons.php" class="btn btn-cancel">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const codeInput = document.getElementById('codeInput');
const discountInput = document.getElementById('discountInput');
const previewCode = document.getElementById('previewCode');
const previewPercent = document.getElementById('previewPercent');

codeInput.addEventListener('input', function() {
    this.value = this.value.toUpperCase();
    previewCode.textContent = this.value || 'CODE';
});

discountInput.addEventListener('input', function() {
    previewPercent.textContent = this.value || '0';
});
</script>

</body>
</html>
