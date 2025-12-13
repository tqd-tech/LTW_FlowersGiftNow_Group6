<?php
// products.php
// Quản lý sản phẩm (hiển thị danh sách, cho sửa/xóa)

require_once '../includes/db.php';


// Lấy danh sách sản phẩm
$products = $pdo->query("SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Danh sách sản phẩm - Admin</title>
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
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FDF2F8 0%, #FCE7F3 50%, #FBCFE8 100%);
            min-height: 100vh;
        }
        .page-header h1 {
            font-size: 2.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        .product-img-small {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: var(--radius-lg);
        }
        .tag-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }
        .card-modern {
            box-shadow: 0 4px 20px rgba(236, 72, 153, 0.1);
            border: 1px solid rgba(236, 72, 153, 0.1);
        }
        thead {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%) !important;
        }
        /* thead th {
            color: white !important;
        } */
    </style>
</head>
<body>
<div class="container py-5">
    <div class="page-header" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05); display:flex; flex-direction: column; justify-content: space-between; align-items: center; ">
        <h1>
            <i class="zmdi zmdi-collection-item"></i> Danh sách sản phẩm
        </h1>
        <p style="color: var(--text-secondary); margin: 0; ">Quản lý tất cả sản phẩm trong cửa hàng</p>
    </div>

    <div style="display: flex; gap: 0.75rem; margin-bottom: 2rem; flex-wrap: wrap;">
        <a href="add_product.php" class="btn-modern btn-primary">
            <i class="zmdi zmdi-plus"></i> Thêm sản phẩm mới
        </a>
        <a href="dashboard.php" class="btn-modern btn-ghost">
            <i class="zmdi zmdi-chart"></i> Dashboard
        </a>
        <a href="../index.php" class="btn-modern btn-ghost">
            <i class="zmdi zmdi-home"></i> Về trang chủ
        </a>
    </div>
    <?php if (!empty($products)): ?>
    <div class="card-modern" style="padding: 0; overflow: hidden;">
        <div class="table-responsive">
            <table class="table align-middle" style="margin-bottom: 0;">
                <thead style="background: var(--gray-100); border-bottom: 2px solid var(--gray-200);">
                    <tr>
                        <th style="padding: 0.5rem 1.5rem ; font-weight: 600; color: var(--text-primary); width: 80px;">ID</th>
                        <th style="padding: 0.5rem 1.5rem; font-weight: 600; color: var(--text-primary);">Sản phẩm</th>
                        <th style="padding: 0.5rem 1.5rem; font-weight: 600; color: var(--text-primary); text-align: center;">Danh mục</th>
                        <th style="padding: 0.5rem 1.5rem; font-weight: 600; color: var(--text-primary); text-align: right;">Giá</th>
                        <th style="padding: 0.5rem 1.5rem; font-weight: 600; color: var(--text-primary); text-align: center;">Kho</th>
                        <th style="padding: 0.5rem 1.5rem; font-weight: 600; color: var(--text-primary);">Tags</th>
                        <th style="padding: 0.5rem 1.5rem; font-weight: 600; color: var(--text-primary); text-align: center; width: 150px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product): ?>
                    <tr style="border-bottom: 1px solid var(--gray-200);">
                        <td style="padding: 1rem; font-weight: 600; color: var(--text-secondary);">
                            #<?= $product['id'] ?>
                        </td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <?php if (!empty($product['image'])): ?>
                                    <img src="../assets/images/<?= htmlspecialchars($product['image']) ?>" 
                                         alt="<?= htmlspecialchars($product['name']) ?>" 
                                         class="product-img-small">
                                <?php else: ?>
                                    <div style="width: 60px; height: 60px; background: var(--gray-200); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center;">
                                        <i class="zmdi zmdi-image" style="color: var(--gray-400); font-size: 1.5rem;"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div style="font-weight: 600; color: var(--text-primary); margin-bottom: 0.2rem;">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </div>
                                    <?php if (!empty($product['description'])): ?>
                                        <div style="font-size: 0.75rem; color: var(--text-secondary); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 300px;">
                                            <?= htmlspecialchars($product['description']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <?php if ($product['category_name']): ?>
                                <span class="badge-modern badge-info shadow-sm">
                                    <?= htmlspecialchars($product['category_name']) ?>
                                </span>
                            <?php else: ?>
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 1rem; text-align: right; font-weight: 700; color: var(--primary);">
                            <?= number_format($product['price'], 0, ',', '.') ?>₫
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <?php 
                            $stock_class = 'badge-success';
                            if ($product['stock'] <= 0) {
                                $stock_class = 'badge-danger';
                            } elseif ($product['stock'] <= 10) {
                                $stock_class = 'badge-warning';
                            }
                            ?>
                            <span class="badge-modern <?= $stock_class ?>">
                                <?= $product['stock'] ?>
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <?php if (!empty($product['tags'])): 
                                $tags = explode(',', $product['tags']);
                            ?>
                                <div class="tag-list">
                                    <?php foreach (array_slice($tags, 0, 3) as $tag): ?>
                                        <span class="badge-modern badge-secondary" style="font-size: 0.75rem; padding: 0.25rem 0.5rem; background: #ff0073ff; color: #ffffffff;">
                                            <?= htmlspecialchars(trim($tag)) ?>
                                        </span>
                                    <?php endforeach; ?>
                                    <?php if (count($tags) > 3): ?>
                                        <span style="font-size: 0.75rem; color: var(--text-secondary);">+<?= count($tags) - 3 ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">-</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="edit_product.php?id=<?= $product['id'] ?>" 
                                   class="btn-modern btn btn-warning btn-sm rounded-circle p-2" 
                                   title="Sửa sản phẩm">
                                    <i class="zmdi zmdi-edit"></i>
                                </a>
                                <a href="delete_product.php?id=<?= $product['id'] ?>" 
                                   class="btn-modern btn btn-danger btn-sm rounded-circle p-2" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"
                                   title="Xóa sản phẩm">
                                    <i class="zmdi zmdi-delete"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="card-modern" style="padding: 3rem 2rem; text-align: center;">
        <i class="zmdi zmdi-shopping-basket" style="font-size: 4rem; color: var(--gray-400); margin-bottom: 1rem;"></i>
        <h4 style="color: var(--text-primary); margin-bottom: 0.5rem;">Chưa có sản phẩm nào</h4>
        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Hãy thêm sản phẩm đầu tiên vào cửa hàng của bạn</p>
        <a href="add_product.php" class="btn-modern btn-primary">
            <i class="zmdi zmdi-plus"></i> Thêm sản phẩm mới
        </a>
    </div>
    <?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
