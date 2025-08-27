<?php require_once 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<?php
// Lấy parameters từ URL để sử dụng trong toàn bộ trang
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$tag = $_GET['tag'] ?? '';
$price = $_GET['price'] ?? '';
$sort = $_GET['sort'] ?? '';
?>

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
	<section class="section-slide hidden-mobile hidden_tablet">
		<div class="wrap-slick1">
			<div class="slick1">
				<div class="item-slick1" style="background-image: linear-gradient(rgba(251, 194, 235, 0.2), rgba(166, 193, 238, 0.2)), url(assets/images/flowers/slide1.png); background-size: cover; background-position: center; background-repeat: no-repeat;  overflow: hidden; margin: 0;">
					<div class="container h-full">
						<div class="flex-col-l-m h-75 p-b-30 respon5">		
							<div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
								<span class="ltext-101 cl2 respon2" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
									Sắc màu hạnh phúc
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-20 p-b-20 respon1" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
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

				<div class="item-slick1" style="background-image: linear-gradient(rgba(251, 194, 235, 0.2), rgba(166, 193, 238, 0.2)), url(assets/images/flowers/slide2.png); background-size: cover; background-position: center; background-repeat: no-repeat;  overflow: hidden; margin: 0;">
					<div class="container h-full">
						<div class="flex-col-l-m h-75  p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
								<span class="ltext-101 cl2 respon2" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
									Biểu Tượng Tình Yêu Vĩnh Cửu
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-20 p-b-20 respon1" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
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

				<div class="item-slick1" style="background-image: linear-gradient(rgba(251, 194, 235, 0.2), rgba(166, 193, 238, 0.2)), url(assets/images/flowers/slide3.png); background-size: cover; background-position: center; background-repeat: no-repeat;  overflow: hidden; margin: 0;">
					<div class="container h-full">
						<div class="flex-col-l-m h-75  p-b-30 respon5">
							<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
								<span class="ltext-101 cl2 respon2" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
									Quan Tâm Từng Chi Tiết
								</span>
							</div>
								
							<div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
								<h2 class="ltext-201 cl2 p-t-20 p-b-20 respon1" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
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
	<section class="bg0 p-t-23">
		<div class="container">
			<div class="p-b-10">
				<h3 class="ltext-103 cl5">
					Sản phẩm mới nhất
				</h3>
			</div>

			<div class="flex-w flex-sb-m p-b-10">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<a href="#" class="stext-106 cl6 hov1 shadow-sm  p-lr-25 p-tb-10 rounded-2 trans-04 m-r-10 m-tb-5 text-decoration-none fw-bold <?= !isset($_GET['category']) ? 'how-active1' : '' ?>">
						Tất cả
					</a>

					<a href="#" class="stext-106 cl6 hov1 shadow-sm  p-lr-25 p-tb-10 rounded-2 trans-04 m-r-10 m-tb-5 text-decoration-none fw-bold <?= isset($_GET['category']) && $_GET['category'] === 'gift' ? 'how-active1' : '' ?>">
						Quà tặng
					</a>

					<a href="#" class="stext-106 cl6 hov1 shadow-sm  p-lr-25 p-tb-10 rounded-2 trans-04 m-r-10 m-tb-5 text-decoration-none fw-bold <?= isset($_GET['category']) && $_GET['category'] === 'other' ? 'how-active1' : '' ?>">
						Hoa
					</a>
				</div>

				<div class="flex-w flex-c-m m-tb-10">
					<div class="flex-c-m stext-106 cl6 size-104 bor4 rounded-3 shadow-sm pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter fw-bold" >
						<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
						<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						 Filter
					</div>

					<div class="flex-c-m stext-106 cl6 size-105 bor4 rounded-3 shadow-sm pointer hov-btn3 trans-04 m-tb-4 js-show-search fw-bold	">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Search
					</div>
				</div>
				
				<!-- Search product -->
				<div class="dis-none panel-search w-full p-t-10 border-bottom py-1	">
					<div class="bor8 dis-flex p-l-15 m-b-20 rounded-4 shadow-lg position-relative">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04" onclick="performSearch()">
							<i class="zmdi zmdi-search"></i>
						</button>

						<input id="search-input" class="mtext-107 cl2 size-114 plh2 p-r-15 rounded-4" type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?= htmlspecialchars($search) ?>">
						
						<?php if (!empty($search)): ?>
						<button class="position-absolute top-50 end-0 translate-middle-y bg-transparent border-0 p-2 me-2" onclick="clearSearch()" title="Xóa từ khóa">
							<i class="zmdi zmdi-close text-muted"></i>
						</button>
						<?php endif; ?>
					</div>	
				</div>

				<!-- Filter -->
				<div class="dis-none panel-filter w-full p-t-10 m-t-10">
    <div class="wrap-filter flex-w bg-white w-full p-lr-40 p-t-27 m-b-30 p-lr-15-sm rounded-4 shadow-lg">
        
        <!-- Clear All Filters Button -->
        <div class="w-full p-b-20 text-center ">
            <button onclick="clearAllFilters()" class="btn btn-danger ">
                <i class="fa fa-times"></i> Xóa tất cả bộ lọc
            </button>
        </div>
        
        <!-- Sắp xếp -->
        <div class="filter-col1 p-r-15 p-b-27">
            <div class="mtext-102 cl2 border-bottom py-1 fw-bold">Sắp xếp</div>
             <ul class="p-0">
                <li class="p-b-6 p-t-6"><a href="javascript:void(0)" onclick="toggleFilter('sort', '')" class="filter-link <?= empty($sort) ? 'active' : '' ?>" style="<?= empty($sort) ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Mặc định</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="toggleFilter('sort', 'price_asc')" class="filter-link <?= $sort === 'price_asc' ? 'active' : '' ?>" style="<?= $sort === 'price_asc' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Giá tăng dần</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="toggleFilter('sort', 'price_desc')" class="filter-link <?= $sort === 'price_desc' ? 'active' : '' ?>" style="<?= $sort === 'price_desc' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Giá giảm dần</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="toggleFilter('sort', 'newest')" class="filter-link <?= $sort === 'newest' ? 'active' : '' ?>" style="<?= $sort === 'newest' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Mới nhất</a></li>
            </ul>
        </div>

        <!-- Khoảng giá -->
        <div class="filter-col2 p-r-15 p-b-27">
            <div class="mtext-102 cl2 border-bottom py-1 fw-bold">Khoảng giá</div>
             <ul class="p-0">
                <li class="p-b-6 p-t-6"><a href="javascript:void(0)" onclick="toggleFilter('price', '0-200')" class="filter-link <?= $price === '0-200' ? 'active' : '' ?>" style="<?= $price === '0-200' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Dưới 200k</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="toggleFilter('price', '200-400')" class="filter-link <?= $price === '200-400' ? 'active' : '' ?>" style="<?= $price === '200-400' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Từ 200k - 400k</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="toggleFilter('price', '500+')" class="filter-link <?= $price === '500+' ? 'active' : '' ?>" style="<?= $price === '500+' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Trên 500k</a></li>
            </ul>
        </div>

        <!-- Danh mục -->
        <div class="filter-col3 p-r-15 p-b-27">
            <div class="mtext-102 cl2 border-bottom py-1 fw-bold">Danh mục</div>
             <ul class="p-0">
                <li class="p-b-6 p-t-6"><a href="javascript:void(0)" onclick="toggleFilter('category', 'flowers')" class="filter-link <?= $category === 'flowers' ? 'active' : '' ?>" style="<?= $category === 'flowers' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Hoa</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="toggleFilter('category', 'gifts')" class="filter-link <?= $category === 'gifts' ? 'active' : '' ?>" style="<?= $category === 'gifts' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Quà tặng</a></li>
            </ul>
        </div>

        <!-- Tags -->
        <div class="filter-col4 p-b-27">
            <div class="mtext-102 cl2 border-bottom py-1 fw-bold">Chủ đề</div>
            <div class="flex-w p-t-4 m-r--5 p-t-6">
                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Hoa Tặng Mẹ')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Hoa Tặng Mẹ' ? 'active' : '' ?>" style="<?= $tag === 'Hoa Tặng Mẹ' ? 'background-color: #007bff; color: white;' : '' ?>">Hoa Tặng Mẹ</a>
                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Hoa Tiền')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Hoa Tiền' ? 'active' : '' ?>" style="<?= $tag === 'Hoa Tiền' ? 'background-color: #007bff; color: white;' : '' ?>">Hoa Tiền</a>
                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Set Quà Tặng 8/3')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Set Quà Tặng 8/3' ? 'active' : '' ?>" style="<?= $tag === 'Set Quà Tặng 8/3' ? 'background-color: #007bff; color: white;' : '' ?>">Set Quà 8/3</a>
                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Hoa Tặng Vợ')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Hoa Tặng Vợ' ? 'active' : '' ?>" style="<?= $tag === 'Hoa Tặng Vợ' ? 'background-color: #007bff; color: white;' : '' ?>">Hoa Tặng Vợ</a>
                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Tình Yêu')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Tình Yêu' ? 'active' : '' ?>" style="<?= $tag === 'Tình Yêu' ? 'background-color: #007bff; color: white;' : '' ?>">Tình Yêu</a>
				<a href="javascript:void(0)" onclick="toggleFilter('tag', 'Quà Tặng')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Quà Tặng' ? 'active' : '' ?>" style="<?= $tag === 'Quà Tặng' ? 'background-color: #007bff; color: white;' : '' ?>">Quà Tặng</a>
            </div>
        </div>
    </div>
</div>



			<div class="row" id="products-container">
				<?php if (!empty($search)): ?>
				<div class="col-12 mb-3">
					<div class="search-highlight d-flex justify-content-between align-items-center">
						<div>
							<strong>Kết quả tìm kiếm cho:</strong> 
							<span class="badge bg-primary ms-2"><?= htmlspecialchars($search) ?></span>
						</div>
						<button onclick="clearSearch()" class="btn btn-sm btn-outline-secondary">
							<i class="zmdi zmdi-close"></i> Xóa tìm kiếm
						</button>
					</div>
				</div>
				<?php endif; ?>
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
            <div class="card h-100 shadow border-0 rounded-3 overflow-hidden">
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
                    <small class="text-secondary ">Ngày bán: <?php echo date('d/m/Y', strtotime($product['created_at'])); ?></small>
                </div>
            </div>
        </div>
<?php endforeach; ?>

<!-- Thông báo cuối danh sách -->
<div class="col-12 text-center mt-4 mb-3">
    <div class="alert alert-info border-0 shadow-sm rounded-3" style=" ">
        <i class="zmdi zmdi-info-outline "></i>
        <strong>Không còn sản phẩm nào khác</strong>
        <br>
        <small class="text-muted">Bạn đã xem hết tất cả sản phẩm có sẵn</small>
    </div>
</div>

<?php else: ?>
    <div class="col-12 text-center py-5">
        <div class="empty-state">
            <i class="zmdi zmdi-search zmdi-hc-5x text-muted mb-3"></i>
            <h4 class="text-muted">Không có sản phẩm nào</h4>
            <p class="text-muted">Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
            <button onclick="clearAllFilters()" class="btn btn-primary mt-2">
                <i class="fa fa-refresh"></i> Xóa bộ lọc
            </button>
        </div>
    </div>
<?php endif;
?>
</div>


		</div>
	</section>

<script>
// Global filter variables
var currentFilters = {
    sort: '<?= $sort ?>',
    price: '<?= $price ?>',
    category: '<?= $category ?>',
    tag: '<?= $tag ?>',
    search: '<?= $search ?>'
};

$(document).ready(function() {
    // Kiểm tra xem có filter nào đang được áp dụng không
    var hasActiveFilters = <?= (!empty($sort) || !empty($price) || !empty($category) || !empty($tag)) ? 'true' : 'false' ?>;
    
    // Nếu có filter active, tự động mở panel filter
    if (hasActiveFilters) {
        $('.panel-filter').show();
        $('.icon-filter').addClass('dis-none');
        $('.icon-close-filter').removeClass('dis-none');
    }
    
    // Nếu có từ khóa search, tự động mở panel search
    var hasSearch = '<?= $search ?>' !== '';
    if (hasSearch) {
        $('.panel-search').show();
        $('.icon-search').addClass('dis-none');
        $('.icon-close-search').removeClass('dis-none');
    }
    
    // Load products on page load
    loadProducts();
    
    // Handle Filter button click
    $('.js-show-filter').click(function() {
        $('.panel-filter').slideToggle();
        $('.icon-filter', this).toggleClass('dis-none');
        $('.icon-close-filter', this).toggleClass('dis-none');
    });
    
    // Handle Search button click
    $('.js-show-search').click(function() {
        $('.panel-search').slideToggle();
        $('.icon-search', this).toggleClass('dis-none');
        $('.icon-close-search', this).toggleClass('dis-none');
    });
    
    // Search khi nhấn Enter
    $('#search-input').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            performSearch();
        }
    });
    
    // Search real-time khi người dùng dừng gõ
    var searchTimeout;
    $('#search-input').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            performSearch();
        }, 500); // Delay 500ms sau khi dừng gõ
    });
});

// Function to perform search
function performSearch() {
    var searchValue = $('#search-input').val().trim();
    currentFilters.search = searchValue;
    
    // Update search field display
    updateSearchDisplay();
    
    // Load products with search
    loadProducts();
}

// Function to clear search
function clearSearch() {
    $('#search-input').val('');
    currentFilters.search = '';
    
    // Update search field display
    updateSearchDisplay();
    
    // Load products without search
    loadProducts();
}

// Function to update search display
function updateSearchDisplay() {
    // Tự động thêm/bỏ nút clear search
    var searchValue = currentFilters.search;
    if (searchValue) {
        if ($('.panel-search .zmdi-close').length === 0) {
            $('#search-input').after('<button class="position-absolute top-50 end-0 translate-middle-y bg-transparent border-0 p-2 me-2" onclick="clearSearch()" title="Xóa từ khóa"><i class="zmdi zmdi-close text-muted"></i></button>');
        }
    } else {
        $('.panel-search .zmdi-close').parent().remove();
    }
}

// Function to toggle filter - bật/tắt filter khi click
function toggleFilter(type, value) {
    // Nếu filter hiện tại đang active thì bỏ chọn (reset)
    if (currentFilters[type] === value) {
        currentFilters[type] = '';
    } else {
        // Ngược lại thì áp dụng filter mới
        currentFilters[type] = value;
    }
    
    // Update active states
    updateAllActiveStates();
    
    // Load products with new filters
    loadProducts();
}

// Function to apply filter using AJAX (giữ lại để tương thích)
function applyFilter(type, value) {
    // Update current filters
    currentFilters[type] = value;
    
    // Update active states
    updateActiveStates(type, value);
    
    // Load products with new filters
    loadProducts();
}

// Function to clear all filters
function clearAllFilters() {
    currentFilters = {
        sort: '',
        price: '',
        category: '',
        tag: '',
        search: ''
    };
    
    // Clear search input
    $('#search-input').val('');
    
    // Update all active states
    updateAllActiveStates();
    
    // Update search display
    updateSearchDisplay();
    
    // Load products
    loadProducts();
}

// Function to update all active states
function updateAllActiveStates() {
    // Reset tất cả active states
    $('.filter-col1 a, .filter-col2 a, .filter-col3 a').removeClass('active').css({'color': '#333', 'font-weight': 'normal'});
    $('.filter-col4 a').removeClass('active').css({'background-color': '', 'color': ''});
    
    // Update Sort
    if (!currentFilters.sort) {
        $('.filter-col1 a[onclick*="\'sort\', \'\'"]').addClass('active').css({'color': '#007bff', 'font-weight': 'bold'});
    } else {
        $('.filter-col1 a[onclick*="\'sort\', \'' + currentFilters.sort + '\'"]').addClass('active').css({'color': '#007bff', 'font-weight': 'bold'});
    }
    
    // Update Price
    if (currentFilters.price) {
        $('.filter-col2 a[onclick*="\'price\', \'' + currentFilters.price + '\'"]').addClass('active').css({'color': '#007bff', 'font-weight': 'bold'});
    }
    
    // Update Category
    if (currentFilters.category) {
        $('.filter-col3 a[onclick*="\'category\', \'' + currentFilters.category + '\'"]').addClass('active').css({'color': '#007bff', 'font-weight': 'bold'});
    }
    
    // Update Tag
    if (currentFilters.tag) {
        $('.filter-col4 a[onclick*="\'tag\', \'' + currentFilters.tag + '\'"]').addClass('active').css({'background-color': '#007bff', 'color': 'white'});
    }
}

// Function to update active states (giữ lại để tương thích)
function updateActiveStates(type, value) {
    // Remove all active states for this filter type
    if (type === 'sort') {
        $('.filter-col1 a').removeClass('active').css({'color': '#333', 'font-weight': 'normal'});
        if (value === '') {
            $('.filter-col1 a[onclick="applyFilter(\'sort\', \'\')"]').addClass('active').css({'color': '#007bff', 'font-weight': 'bold'});
        } else {
            $('.filter-col1 a[onclick="applyFilter(\'sort\', \'' + value + '\')"]').addClass('active').css({'color': '#007bff', 'font-weight': 'bold'});
        }
    } else if (type === 'price') {
        $('.filter-col2 a').removeClass('active').css({'color': '#333', 'font-weight': 'normal'});
        $('.filter-col2 a[onclick="applyFilter(\'price\', \'' + value + '\')"]').addClass('active').css({'color': '#007bff', 'font-weight': 'bold'});
    } else if (type === 'category') {
        $('.filter-col3 a').removeClass('active').css({'color': '#333', 'font-weight': 'normal'});
        $('.filter-col3 a[onclick="applyFilter(\'category\', \'' + value + '\')"]').addClass('active').css({'color': '#007bff', 'font-weight': 'bold'});
    } else if (type === 'tag') {
        $('.filter-col4 a').removeClass('active').css({'background-color': '', 'color': ''});
        $('.filter-col4 a[onclick="applyFilter(\'tag\', \'' + value + '\')"]').addClass('active').css({'background-color': '#007bff', 'color': 'white'});
    }
}

// Function to load products using AJAX
function loadProducts() {
    // Show loading
    $('#products-container').html('<div class="col-12 text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
    
    // Build query parameters
    var params = {};
    if (currentFilters.sort) params.sort = currentFilters.sort;
    if (currentFilters.price) params.price = currentFilters.price;
    if (currentFilters.category) params.category = currentFilters.category;
    if (currentFilters.tag) params.tag = currentFilters.tag;
    if (currentFilters.search) params.search = currentFilters.search;
    
    // Make AJAX request
    $.ajax({
        url: 'ajax_filter.php',
        method: 'GET',
        data: params,
        success: function(response) {
            $('#products-container').html(response);
        },
        error: function() {
            $('#products-container').html('<div class="col-12 text-center"><p class="text-danger">Có lỗi xảy ra khi tải sản phẩm.</p></div>');
        }
    });
}
</script>

<style>
.empty-state {
    padding: 40px 20px;
    background: #f8f9fa;
    border-radius: 10px;
    border: 2px dashed #dee2e6;
}

.empty-state i {
    display: block;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h4 {
    margin-bottom: 10px;
    font-weight: 600;
}

.empty-state p {
    margin-bottom: 20px;
    font-size: 0.9rem;
}

/* Responsive fixes cho ít sản phẩm */
@media (max-width: 576px) {
    .col-lg-4.mx-auto {
        max-width: 100% !important;
    }
}

@media (min-width: 576px) and (max-width: 768px) {
    .col-sm-6.col-md-6.col-lg-4 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (min-width: 768px) {
    .col-md-6.col-lg-4 {
        flex: 0 0 50%;
        max-width: 50%;
        margin: 0 auto;
    }
}

@media (min-width: 992px) {
    .col-lg-4.mx-auto {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
        margin: 0 auto;
    }
}

/* Bỏ gạch chân khi active */
.how-active1 {
    text-decoration: none !important;
}

.filter-tope-group a.how-active1 {
    text-decoration: none !important;
}

.filter-tope-group a:hover {
    text-decoration: none !important;
}

/* Hover effect cho product cards */
.card {
    transition: transform 0.8s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2) !important;  /*Bóng đen sáng */
}

/* Hover effect cho nút Mua ngay */
.card:hover .btn {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1.1);
}

.card .btn {
    opacity: 0.9;
    transition: all 0.3s ease;
}

/* Search styling */
.panel-search {
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#search-input {
    border: none;
    outline: none;
    padding-right: 40px;
}

#search-input:focus {
    box-shadow: none;
}

.panel-search .bor8 {
    border: 2px solid #e9ecef;
    transition: border-color 0.3s ease;
}

.panel-search .bor8:focus-within {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Search results highlight */
.search-highlight {
    background-color: #fff3cd;
    padding: 10px;
    border-left: 4px solid #ffc107;
    margin-bottom: 20px;
    border-radius: 4px;
}

.search-highlight .badge {
    font-size: 0.8rem;
}

/* End of products message styling */
.alert-info {
    border: none !important;
    /* background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%) !important; */
    color: #1976d2;
    animation: fadeInUp 0.6s ease;
}

.alert-info i {
    color: #2196f3;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<?php include 'includes/footer.php'; ?>
