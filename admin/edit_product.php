<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/login.php');
    exit;
}
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo 'Thiếu ID sản phẩm!';
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) {
    echo 'Không tìm thấy sản phẩm!';
    exit;
}

// Lấy danh mục
$categories = $pdo->query('SELECT * FROM categories')->fetchAll();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $price = (int)($_POST['price'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    $category_id = (int)($_POST['category_id'] ?? 0);
    $tags = trim($_POST['tags'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if (!$name || !$price || !$category_id) {
        $error = 'Vui lòng nhập đầy đủ thông tin bắt buộc.';
    } else {
        $stmt = $pdo->prepare('UPDATE products SET name=?, price=?, stock=?, category_id=?, tags=?, description=? WHERE id=?');
        $stmt->execute([$name, $price, $stock, $category_id, $tags, $description, $id]);
        header('Location: products.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
    <h1 class="mb-4">Sửa sản phẩm</h1>
            <button class="btn btn-secondary mb-3" onclick="window.location.href='../index.php'">Về trang chủ</button>
</div>
    <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tồn kho</label>
            <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id']==$product['category_id']?'selected':'' ?>><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tags</label>
            <input type="text" name="tags" class="form-control" value="<?= htmlspecialchars($product['tags']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Tên file ảnh (ví dụ: assets/images/your_image.png)</label>
            <input type="text" name="image" id="imageInput" class="form-control" value="<?= htmlspecialchars($product['image']) ?>" placeholder="vd: product-01.jpg">
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="products.php" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Tự động đổi prefix ảnh theo danh mục
const categorySelect = document.querySelector('select[name="category_id"]');
const imageInput = document.getElementById('imageInput');
const categories = {};
<?php foreach ($categories as $cat): ?>
    categories[<?= $cat['id'] ?>] = "<?= addslashes(strtolower($cat['name'])) ?>";
<?php endforeach; ?>
categorySelect.addEventListener('change', function() {
    const val = this.value;
    let prefix = '';
    if (categories[val] === 'hoa') prefix = 'assets/images/flowers/';
    else if (categories[val] === 'quà' || categories[val] === 'qua' || categories[val] === 'gift' || categories[val] === 'gifts') prefix = 'assets/images/gifts/';
    if (prefix) {
        let imgVal = imageInput.value.trim();
        // Nếu chưa có prefix đúng thì thêm
        if (!imgVal.startsWith(prefix)) {
            // Nếu đã có prefix cũ thì loại bỏ
            imgVal = imgVal.replace(/^assets\/images\/(flowers|gifts)\//, '');
            imageInput.value = prefix + imgVal;
        }
    }
});
</script>
</body>
</html>
