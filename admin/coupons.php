<?php
// coupons.php
// Quản lý mã khuyến mãi (hiển thị danh sách, cho sửa/xóa)

require_once '../includes/db.php';

// Lấy danh sách mã khuyến mãi
$coupons = $pdo->query("SELECT * FROM coupons ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý Mã khuyến mãi - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        .page-header h2 {
            font-size: 2.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .table-modern { 
            background: white; 
            border-radius: var(--radius-xl); 
            overflow: hidden; 
            box-shadow: 0 4px 20px rgba(236, 72, 153, 0.1);
            border: 1px solid rgba(236, 72, 153, 0.1);
        }
        .table-modern thead { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; }
        .table-modern th { padding: 1rem; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; border: none; }
        .table-modern td { padding: 1rem; vertical-align: middle; border-bottom: 1px solid var(--gray-100); }
        .table-modern tbody tr:hover { background: #FDF2F8; }
        .coupon-code { 
            font-family: 'Courier New', monospace; 
            font-weight: 700; 
            font-size: 1.1rem; 
            color: var(--primary); 
            padding: 0.5rem 1rem;
            background: #FCE7F3;
            border-radius: var(--radius-lg);
            display: inline-block;
        }
        .discount-badge {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-full);
            font-weight: 700;
            font-size: 1.25rem;
            display: inline-block;
        }
        .date-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .date-label {
            font-size: 0.7rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            font-weight: 600;
        }
        .date-value {
            font-size: 0.9rem;
            color: var(--text-primary);
            font-weight: 500;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: var(--radius-full);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-active { background: #D1FAE5; color: #065F46; }
        .status-expired { background: #FEE2E2; color: #991B1B; }
        .status-upcoming { background: #FCE7F3; color: #9D174D; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="page-header" style="text-align: center; margin-bottom: 2rem; display:flex; flex-direction: column; justify-content: center; align-items: center; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);">
        <h2 class="margin-bottom: 5px !important;">
            <i class="zmdi zmdi-card-giftcard"></i> Quản lý Mã khuyến mãi
        </h2>
        <p style="color: var(--text-secondary); margin: 0; font-weight: 700;">Tạo và quản lý các mã giảm giá cho khách hàng</p>
    </div>

    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; justify-content: center; flex-wrap: wrap;">
        <a href="add_coupon.php" class="btn-modern btn-primary">
            <i class="zmdi zmdi-plus-circle"></i> Thêm mã khuyến mãi
        </a>
        <a href="dashboard.php" class="btn-modern btn-ghost">
            <i class="zmdi zmdi-view-dashboard"></i> Dashboard
        </a>
        <a href="../index.php" class="btn-modern btn-ghost">
            <i class="zmdi zmdi-home"></i> Trang chủ
        </a>
    </div>

    <?php if (empty($coupons)): ?>
        <div class="card-modern" style="padding: 3rem; text-align: center;">
            <i class="zmdi zmdi-card-giftcard" style="font-size: 4rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
            <h4 style="color: var(--text-primary); margin-bottom: 0.5rem;">Chưa có mã khuyến mãi nào</h4>
            <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Bắt đầu tạo mã khuyến mãi để thu hút khách hàng</p>
            <a href="add_coupon.php" class="btn-modern btn-primary">
                <i class="zmdi zmdi-plus-circle"></i> Tạo mã khuyến mãi đầu tiên
            </a>
        </div>
    <?php else: ?>
    <div class="table-responsive table-modern">
        <table class="table mb-0">
            <thead>
                <tr class="text-center">
                    <th style="width: 60px;">ID</th>
                    <th>Mã khuyến mãi</th>
                    <th>Chiết khấu</th>
                    <th>Thời gian hiệu lực</th>
                    <th>Trạng thái</th>
                    <th style="width: 150px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($coupons as $coupon): 
                // Xác định trạng thái coupon
                $today = date('Y-m-d');
                $status = '';
                $status_text = '';
                if ($today < $coupon['start_date']) {
                    $status = 'status-upcoming';
                    $status_text = 'Sắp diễn ra';
                } elseif ($today > $coupon['end_date']) {
                    $status = 'status-expired';
                    $status_text = 'Đã hết hạn';
                } else {
                    $status = 'status-active';
                    $status_text = 'Đang hoạt động';
                }
            ?>
                <tr class="text-center">
                    <td><strong style="color: var(--text-secondary);">#<?= $coupon['id'] ?></strong></td>
                    <td>
                        <div class="coupon-code">
                            <i class="zmdi zmdi-label"></i> <?= htmlspecialchars($coupon['code']) ?>
                        </div>
                    </td>
                    <td>
                        <span class="discount-badge">
                            <?= $coupon['discount_percent'] ?>%
                        </span>
                    </td>
                    <td>
                        <div class="date-info">
                            <div>
                                <span class="date-label">Bắt đầu:</span>
                                <span class="date-value"><?= date('d/m/Y', strtotime($coupon['start_date'])) ?></span>
                            </div>
                            <div>
                                <span class="date-label">Kết thúc:</span>
                                <span class="date-value"><?= date('d/m/Y', strtotime($coupon['end_date'])) ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge <?= $status ?>">
                            <?= $status_text ?>
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; justify-content: center; gap: 0.5rem;">
                            <a href="edit_coupon.php?id=<?= $coupon['id'] ?>" class="btn-modern btn btn-warning btn-sm p-2 rounded-circle" title="Sửa">
                                <i class="zmdi zmdi-edit"></i>
                            </a>
                            <a href="delete_coupon.php?id=<?= $coupon['id'] ?>" 
                               class="btn-modern btn btn-danger btn-sm p-2 rounded-circle" 
                               onclick="return confirm('Xác nhận xóa mã khuyến mãi <?= htmlspecialchars($coupon['code']) ?>?')"
                               title="Xóa">
                                <i class="zmdi zmdi-delete"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>