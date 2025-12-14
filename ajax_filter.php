<?php
require_once 'includes/db.php';

$categoryMap = [
    'flowers' => 1,
    'gifts' => 2
];

$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$tag = $_GET['tag'] ?? '';
$price = $_GET['price'] ?? '';
$sort = $_GET['sort'] ?? '';

$where = [];
$params = [];

// Lọc theo tên sản phẩm
if ($search !== '') {
    $where[] = 'name LIKE ?';
    $params[] = "%$search%";
}

// Lọc theo danh mục
if ($category !== '' && isset($categoryMap[$category])) {
    $where[] = 'category_id = ?';
    $params[] = $categoryMap[$category];
}

// Lọc theo tag
if ($tag !== '') {
    $where[] = 'tags LIKE ?';
    $params[] = "%$tag%";
}

// Lọc theo khoảng giá
if ($price !== '') {
    if (preg_match('/^(\d+)-(\d+)$/', $price, $matches)) {
        $min = (int)$matches[1] * 1000;
        $max = (int)$matches[2] * 1000;
        $where[] = 'price BETWEEN ? AND ?';
        $params[] = $min;
        $params[] = $max;
    } elseif ($price === '500+') {
        $where[] = 'price >= ?';
        $params[] = 500000;
    }
}

// Base SQL
$sql = "SELECT * FROM products";

// Thêm WHERE nếu có điều kiện
if (!empty($where)) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

// Sắp xếp
switch ($sort) {
    case 'price_asc':
        $sql .= " ORDER BY price ASC";
        break;
    case 'price_desc':
        $sql .= " ORDER BY price DESC";
        break;
    case 'newest':
        $sql .= " ORDER BY created_at DESC";
        break;
    default:
        $sql .= " ORDER BY id DESC";
        break;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Trả về HTML
?>

<?php if (!empty($search)): ?>
<div class="col-12 mb-4">
    <div class="alert-modern alert-info " style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; border-radius: var(--radius-lg);">
        <div>
            <img src="./assets/images/icons/search.png" alt="Search Icon" width="20" height="20" style="margin-right: 0.25rem;">
            <strong>Kết quả tìm kiếm cho:</strong>
            <span class="badge-modern badge-primary" style="margin-left: 0.5rem;"><?= htmlspecialchars($search) ?></span>
        </div>
        <button onclick="clearSearch()" class="btn-modern btn-ghost btn-sm">
            <img src="./assets/images/icons/delete.png" alt="Clear Search" width="20" height="20" > Xóa tìm kiếm
        </button>
    </div>
</div>
<?php endif; ?>

<?php
if ($products):
    $productCount = count($products);
    
    // Tính toán class responsive dựa trên số lượng sản phẩm
    if ($productCount == 1) {
        $colClass = "col-12 col-sm-8 col-md-6 col-lg-4 mx-auto"; // Giữa màn hình
    } elseif ($productCount == 2) {
        $colClass = "col-12 col-sm-6 col-md-6 col-lg-4"; // 2 cột đều nhau
    } elseif ($productCount == 3) {
        $colClass = "col-12 col-sm-6 col-md-4 col-lg-4"; // 3 cột đều nhau
    } else {
        $colClass = "col-12 col-sm-6 col-md-4 col-lg-3"; // Layout bình thường
    }
    
    foreach ($products as $product): ?>
        <div class="<?= $colClass ?> p-b-12 animate-slide-up">
            <div class="card-modern" style="height: 100%;">
                <div style="position: relative; overflow: hidden;">
                    <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>"
                        class="card-modern-img"
                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                        style="transition: transform 0.3s ease;">
                    <!-- Quick View Overlay -->
                    <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); opacity: 0; transition: opacity 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.5rem;"
                        onmouseover="this.style.opacity='1'"
                        onmouseout="this.style.opacity='0'">
                        <a href="product.php?id=<?= $product['id'] ?>" class="btn-modern btn-ghost btn-sm" style="background: white; color: var(--primary);">
                            <img src="./assets/images/icons/eye.png" width="20" height="20" alt="Xem"> Xem
                        </a>
                        <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="btn-modern btn-primary btn-sm">
                            <img src="./assets/images/icons/add_cart.png" width="20" height="20" alt="Thêm"> Thêm
                        </a>
                    </div>
                    <!-- Category Badge -->
                    <?php if (!empty($product['tags'])): ?>
                        <span class="badge-modern badge-info" style="position: absolute; top: 1rem; right: 1rem;">
                            <?= htmlspecialchars(explode(',', $product['tags'])[0]) ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="card-modern-body">
                    <h3 class="card-modern-title" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                        title="<?php echo htmlspecialchars($product['name']); ?>">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </h3>
                    <p class="card-modern-text" style="font-size: 0.875rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        <?php echo htmlspecialchars($product['description']); ?>
                    </p>
                    <div style="display: flex; align-items: center; justify-content: space-around; margin-top: auto; width:100%" >
                        <div class="card-modern-price">
                            <?php echo number_format($product['price'], 0, ',', '.') ?>₫
                        </div>
                        <div style="color: var(--text-secondary); font-size: 0.75rem; font-weight: bold;">
                            <i class="fa fa-clock-o"></i>
                            <?php echo date('d/m/Y', strtotime($product['created_at'])); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php endforeach; ?>

<!-- Thông báo cuối danh sách -->
<div class="col-12 text-center mt-4 mb-3">
    <div class="alert-modern alert-info d-flex flex-column align-items-center justify-content-center" style="text-align: center;">
        <div class="d-flex align-items-center justify-content-center gap-2">
        <i class="zmdi zmdi-check-circle" style="font-size: 2rem; "></i>
            <strong>Không còn sản phẩm nào khác</strong>
        </div>
        <small style="color: var(--gray-500); font-weight: 600;">Bạn đã xem hết tất cả sản phẩm có sẵn</small>
    </div>
</div>

<?php else: ?>
    <div class="col-12 text-center ">
        <div class="card-modern" style="padding: 3rem 2rem; text-align: center;">
            <i class="zmdi zmdi-shopping-basket" style="font-size: 4rem; color: var(--gray-400); margin-bottom: 1rem;"></i>
            <h4 style="color: var(--text-primary); margin-bottom: 0.5rem;">Không tìm thấy sản phẩm</h4>
            <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
            <button onclick="clearAllFilters()" class="btn-modern btn-primary">
                <i class="fa fa-refresh"></i> Xóa bộ lọc
            </button>
        </div>
    </div>
<?php endif;
