<?php require_once 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

        <!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Giỏ hàng của bạn
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>
			
			
		</div>
	</div>

		

	<!-- Slider -->
	<section class="section-slide hidden-mobile">
		<div class="wrap-slick1">
			<div class="slick1">
				<div class="item-slick1" style="background-image: url(assets/images/flowers/slide1.png);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Sắc màu hạnh phúc
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									Bó hoa mix đa sắc
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
								<a href="" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 text-decoration-none">
									Mua ngay
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(assets/images/flowers/slide2.png);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Biểu Tượng Tình Yêu Vĩnh Cửu
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									Hoa Hồng Đỏ Rực 
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
								<a href="" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 text-decoration-none">
									Mua ngay
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="item-slick1" style="background-image: url(assets/images/flowers/slide3.png);">
					<div class="container h-full">
						<div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
								<span class="ltext-101 cl2 respon2">
									Quan Tâm Từng Chi Tiết
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
									Set quà tặng phụ nữ
								</h2>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
								<a href="" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 text-decoration-none">
									Mua ngay
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>




	<!-- Product -->
	<section class="bg0 p-t-23 p-b-140">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
					Sản phẩm mới nhất
				</h3>
			</div>

			<div class="flex-w flex-sb-m p-b-52">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<a href="index.php" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 text-decoration-none <?= !isset($_GET['category']) ? 'how-active1' : '' ?>">
						Tất cả
					</a>

					<a href="index.php?category=gift" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 text-decoration-none <?= isset($_GET['category']) && $_GET['category'] === 'gift' ? 'how-active1' : '' ?>">
						Quà tặng
					</a>

					<a href="index.php?category=other" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 text-decoration-none <?= isset($_GET['category']) && $_GET['category'] === 'other' ? 'how-active1' : '' ?>">
						Khác
					</a>
				</div>

				<div class="flex-w flex-c-m m-tb-10">
					<div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
						<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
						<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						 Filter
					</div>

					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Search
					</div>
				</div>
				
				<!-- Search product -->
				<div class="dis-none panel-search w-full p-t-10 p-b-15">
					<div class="bor8 dis-flex p-l-15">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>

						<input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search" placeholder="Search">
					</div>	
				</div>

				<!-- Filter -->
				<div class="dis-none panel-filter w-full p-t-10">
    <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
        
        <!-- Sắp xếp -->
        <div class="filter-col1 p-r-15 p-b-27">
            <div class="mtext-102 cl2 p-b-15">Sắp xếp</div>
             <ul class="p-0">
                <li class="p-b-6"><a href="index.php" class="filter-link" style="color: blue; font-weight: bold;">Mặc định</a></li>
                <li class="p-b-6"><a href="<?= buildQuery(['sort' => 'price_asc']) ?>" class="filter-link">Giá tăng dần</a></li>
                <li class="p-b-6"><a href="<?= buildQuery(['sort' => 'price_desc']) ?>" class="filter-link">Giá giảm dần</a></li>
                <li class="p-b-6"><a href="<?= buildQuery(['sort' => 'newest']) ?>" class="filter-link">Mới nhất</a></li>
            </ul>
        </div>

        <!-- Khoảng giá -->
        <div class="filter-col2 p-r-15 p-b-27">
            <div class="mtext-102 cl2 p-b-15">Khoảng giá</div>
             <ul class="p-0">
                <li class="p-b-6"><a href="<?= buildQuery(['price' => '0-200']) ?>" class="filter-link">200k</a></li>
                <li class="p-b-6"><a href="<?= buildQuery(['price' => '200-400']) ?>" class="filter-link">Từ 200k - 400k</a></li>
                <li class="p-b-6"><a href="<?= buildQuery(['price' => '500+']) ?>" class="filter-link">Trên 500k</a></li>
            </ul>
        </div>

        <!-- Danh mục -->
        <div class="filter-col3 p-r-15 p-b-27">
            <div class="mtext-102 cl2 p-b-15">Danh mục</div>
             <ul class="p-0">
                <li class="p-b-6"><a href="<?= buildQuery(['category' => 'flowers']) ?>" class="filter-link">Hoa</a></li>
                <li class="p-b-6"><a href="<?= buildQuery(['category' => 'gifts']) ?>" class="filter-link">Quà tặng</a></li>
            </ul>
        </div>

        <!-- Tags -->
        <div class="filter-col4 p-b-27">
            <div class="mtext-102 cl2 p-b-15">Chủ đề</div>
            <div class="flex-w p-t-4 m-r--5">
                <a href="<?= buildQuery(['tag' => 'Hoa Tặng Mẹ']) ?>" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none">Hoa Tặng Mẹ</a>
                <a href="<?= buildQuery(['tag' => 'Hoa Tiền']) ?>" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none">Hoa Tiền</a>
                <a href="<?= buildQuery(['tag' => 'Set Quà Tặng 8/3']) ?>" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none">Set Quà 8/3</a>
                <a href="<?= buildQuery(['tag' => 'Hoa Tặng Vợ']) ?>" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none">Hoa Tặng Vợ</a>
                <a href="<?= buildQuery(['tag' => 'Tình Yêu']) ?>" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none">Tình Yêu</a>
				<a href="<?= buildQuery(['tag' => 'Quà Tặng']) ?>" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none">Quà Tặng</a>
            </div>
        </div>
    </div>
</div>



			<div class="row">
<?php
$categoryMap = [
    'flowers' => 1,
    'gifts' => 2
];
function buildQuery($overrides = []) {
    $query = $_GET;
    foreach ($overrides as $key => $value) {
        $query[$key] = $value;
    }
    return '?' . http_build_query($query);
}

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

// Lọc theo danh mục (flowers/gifts)
if ($category !== '' && isset($categoryMap[$category])) {
    $where[] = 'category_id = ?';
    $params[] = $categoryMap[$category];
}


// Lọc theo tag (trong chuỗi tag của DB)
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

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();


if ($products):
    foreach ($products as $product): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 p-b-35">
            <div class="card h-100 shadow-sm border-0">
                <div class="position-relative text-center">
                    <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']); ?>" style="height: 350px; object-fit: cover;">
                    <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="btn bg-primary position-absolute top-50 start-50 translate-middle px-3 py-2 my-2">
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
else:
    echo "<p class='stext-104 cl6'>Chưa có sản phẩm nào.</p>";
endif;
?>
</div>


		</div>
	</section>

<?php include 'includes/footer.php'; ?>
