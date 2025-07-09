<?php
// add_product.php
// Thêm sản phẩm mới cho trang admin

require_once '../includes/db.php';

// Lấy danh mục để hiển thị trong select
$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

// Xử lý form khi submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = (float)$_POST['price'];
    $category_id = (int)$_POST['category_id'];
    $description = trim($_POST['description']);
    $stock = (int)$_POST['stock'];
    $tags = trim($_POST['tags']);

    // Xử lý upload ảnh (nếu có)
    if (!empty($_FILES['image']['name'])) {
        $targetDir = 'uploads/';
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        $imagePath = $targetFile;
    } else {
        $imagePath = null;
    }

    // Thêm vào database
    $stmt = $pdo->prepare("INSERT INTO products (name, price, category_id, description, image, stock, tags) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $price, $category_id, $description, $imagePath, $stock, $tags]);

    // Redirect về danh sách
    header('Location: products.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Thêm sản phẩm mới</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" step="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Danh mục</label>
            <select name="category_id" class="form-select" required>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Ảnh sản phẩm</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Tồn kho</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tags (ngăn cách dấu phẩy)</label>
            <input type="text" name="tags" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="products.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
