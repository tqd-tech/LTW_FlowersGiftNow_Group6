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
        <div class="<?= $colClass ?> p-b-35">
            <div class="card h-100 shadow-lg border-0 rounded-3 overflow-hidden">
                <div class="position-relative text-center">
                    <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>" style="height: 350px; object-fit: cover;">
                    <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="btn bg-primary position-absolute top-50 start-50 translate-middle px-3 py-2 rounded-3">
                        Mua ngay
                    </a>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-truncate" title="<?php echo htmlspecialchars($product['name']); ?>">
                        <?php echo htmlspecialchars($product['name']); ?>
                    </h5>
                    <p class="card-text small mb-1 text-muted">
                        <?php echo htmlspecialchars(mb_strimwidth($product['description'], 0, 60, '...')); ?>
                    </p>
                    <p class="card-text fw-bold text-danger mb-1">
                        <?php echo number_format($product['price'], 0, ',', '.') ?> VND
                    </p>
                    <small class="text-secondary mt-auto">Ngày bán: <?php echo date('d/m/Y', strtotime($product['created_at'])); ?></small>
                </div>
            </div>
        </div>
<?php endforeach;
else: ?>
    <div class="col-12 text-center py-5">
        <div class="empty-state">
            <i class="zmdi zmdi-search zmdi-hc-5x text-muted mb-3"></i>
            <h4 class="text-muted">Không tìm thấy sản phẩm</h4>
            <p class="text-muted">Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
            <button onclick="clearAllFilters()" class="btn btn-primary mt-2">
                <i class="fa fa-refresh"></i> Xóa bộ lọc
            </button>
        </div>
    </div>
<?php endif;
