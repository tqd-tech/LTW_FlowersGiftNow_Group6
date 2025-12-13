<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/login.php');
    exit;
}
require_once '../includes/db.php';

// Lấy danh mục
$categories = $pdo->query('SELECT * FROM categories')->fetchAll();

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = (int)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $category_id = (int)($_POST['category_id'] ?? 0);
    $tags = trim($_POST['tags'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = $_POST['image'] ?? '';
    if (!$name || !$price || !$category_id) {
        $error = 'Vui lòng nhập đầy đủ thông tin bắt buộc.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO products (name, price, stock, category_id, tags, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$name, $price, $stock, $category_id, $tags, $description, $image]);
        header('Location: products.php?added=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm mới - Admin</title>
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
            max-width: 800px;
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

        .form-control, .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
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
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            flex: 1;
            justify-content: center;
            padding: 0.875rem 1.5rem;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
            color: white;
        }

        .btn-cancel {
            background: var(--gray-100);
            color: var(--gray-700);
        }

        .btn-cancel:hover {
            background: var(--gray-200);
        }

        .image-preview {
            margin-top: 0.75rem;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 10px;
            text-align: center;
        }

        .image-preview img {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            object-fit: cover;
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
            <i class="fas fa-plus-circle"></i>
            <h1>Thêm sản phẩm mới</h1>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="products.php" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <a href="../index.php" class="btn btn-home">
                <i class="fas fa-home"></i> Trang chủ
            </a>
        </div>
    </div>

    <div class="form-card">
        <div class="card-header">
            <i class="fas fa-box"></i>
            <h3>Thông tin sản phẩm</h3>
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
                        <i class="fas fa-tag" style="color: var(--primary); margin-right: 0.5rem;"></i>
                        Tên sản phẩm <span class="required">*</span>
                    </label>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-dollar-sign" style="color: var(--primary); margin-right: 0.5rem;"></i>
                            Giá (VNĐ) <span class="required">*</span>
                        </label>
                        <input type="number" name="price" class="form-control" placeholder="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-warehouse" style="color: var(--primary); margin-right: 0.5rem;"></i>
                            Tồn kho
                        </label>
                        <input type="number" name="stock" class="form-control" placeholder="0" value="0">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-folder" style="color: var(--primary); margin-right: 0.5rem;"></i>
                            Danh mục <span class="required">*</span>
                        </label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Chọn danh mục --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-tags" style="color: var(--primary); margin-right: 0.5rem;"></i>
                            Tags
                        </label>
                        <input type="text" name="tags" class="form-control" placeholder="VD: Hoa Tặng Mẹ, Tình Yêu">
                        <div class="form-hint">Phân cách bằng dấu phẩy</div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-align-left" style="color: var(--primary); margin-right: 0.5rem;"></i>
                        Mô tả sản phẩm
                    </label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Nhập mô tả chi tiết về sản phẩm..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-image" style="color: var(--primary); margin-right: 0.5rem;"></i>
                        Đường dẫn ảnh
                    </label>
                    <input type="text" name="image" id="imageInput" class="form-control" placeholder="VD: flowers/product-01.jpg">
                    <div class="form-hint">Đường dẫn trong thư mục assets/images/</div>
                    <div class="image-preview" id="imagePreview" style="display: none;">
                        <img id="previewImg" src="" alt="Preview">
                    </div>
                </div>

                <div class="btn-group-form">
                    <a href="products.php" class="btn btn-cancel">
                        <i class="fas fa-times"></i> Hủy
                    </a>
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-plus"></i> Thêm sản phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto prefix image path based on category
const categorySelect = document.querySelector('select[name="category_id"]');
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');
const previewImg = document.getElementById('previewImg');

const categories = {};
<?php foreach ($categories as $cat): ?>
    categories[<?= $cat['id'] ?>] = "<?= addslashes(strtolower($cat['name'])) ?>";
<?php endforeach; ?>

categorySelect.addEventListener('change', function() {
    const val = this.value;
    let prefix = '';
    if (categories[val] && categories[val].includes('hoa')) prefix = 'flowers/';
    else if (categories[val] && (categories[val].includes('quà') || categories[val].includes('gift'))) prefix = 'gifts/';
    
    if (prefix) {
        let imgVal = imageInput.value.trim();
        imgVal = imgVal.replace(/^(flowers|gifts)\//, '');
        imageInput.value = prefix + imgVal;
    }
});

imageInput.addEventListener('input', function() {
    const val = this.value.trim();
    if (val) {
        previewImg.src = '../assets/images/' + val;
        imagePreview.style.display = 'block';
        previewImg.onerror = function() {
            imagePreview.style.display = 'none';
        };
    } else {
        imagePreview.style.display = 'none';
    }
});
</script>

</body>
</html>
