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
	<section class="section-slide hidden-mobile hidden_tablet">
		<div class="wrap-slick1">
			<div class="slick1">
				<div class="item-slick1" style="background-image: linear-gradient(rgba(251, 194, 235, 0.2), rgba(166, 193, 238, 0.2)), url(assets/images/flowers/slide1.png); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 20px; overflow: hidden; margin: 10px;">
					<div class="container h-full">
						<div class="flex-col-l-m h-75  p-b-30 respon5">		
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

				<div class="item-slick1" style="background-image: linear-gradient(rgba(251, 194, 235, 0.2), rgba(166, 193, 238, 0.2)), url(assets/images/flowers/slide2.png); background-size: cover; background-position: center; background-repeat: no-repeat; border-radius: 20px; overflow: hidden; margin: 10px;">
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

				<div class="item-slick1" style="background-image: linear-gradient(rgba(251, 194, 235, 0.2), rgba(166, 193, 238, 0.2)), url(assets/images/flowers/slide3.png); background-size: cover; background-position: center; background-repeat: no-repeat;">
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
                <li class="p-b-6"><a href="javascript:void(0)" onclick="applyFilter('sort', '')" class="filter-link <?= empty($sort) ? 'active' : '' ?>" style="<?= empty($sort) ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Mặc định</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="applyFilter('sort', 'price_asc')" class="filter-link <?= $sort === 'price_asc' ? 'active' : '' ?>" style="<?= $sort === 'price_asc' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Giá tăng dần</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="applyFilter('sort', 'price_desc')" class="filter-link <?= $sort === 'price_desc' ? 'active' : '' ?>" style="<?= $sort === 'price_desc' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Giá giảm dần</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="applyFilter('sort', 'newest')" class="filter-link <?= $sort === 'newest' ? 'active' : '' ?>" style="<?= $sort === 'newest' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Mới nhất</a></li>
            </ul>
        </div>

        <!-- Khoảng giá -->
        <div class="filter-col2 p-r-15 p-b-27">
            <div class="mtext-102 cl2 p-b-15">Khoảng giá</div>
             <ul class="p-0">
                <li class="p-b-6"><a href="javascript:void(0)" onclick="applyFilter('price', '0-200')" class="filter-link <?= $price === '0-200' ? 'active' : '' ?>" style="<?= $price === '0-200' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Dưới 200k</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="applyFilter('price', '200-400')" class="filter-link <?= $price === '200-400' ? 'active' : '' ?>" style="<?= $price === '200-400' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Từ 200k - 400k</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="applyFilter('price', '500+')" class="filter-link <?= $price === '500+' ? 'active' : '' ?>" style="<?= $price === '500+' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Trên 500k</a></li>
            </ul>
        </div>

        <!-- Danh mục -->
        <div class="filter-col3 p-r-15 p-b-27">
            <div class="mtext-102 cl2 p-b-15">Danh mục</div>
             <ul class="p-0">
                <li class="p-b-6"><a href="javascript:void(0)" onclick="applyFilter('category', 'flowers')" class="filter-link <?= $category === 'flowers' ? 'active' : '' ?>" style="<?= $category === 'flowers' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Hoa</a></li>
                <li class="p-b-6"><a href="javascript:void(0)" onclick="applyFilter('category', 'gifts')" class="filter-link <?= $category === 'gifts' ? 'active' : '' ?>" style="<?= $category === 'gifts' ? 'color: #007bff; font-weight: bold;' : 'color: #333;' ?>">Quà tặng</a></li>
            </ul>
        </div>

        <!-- Tags -->
        <div class="filter-col4 p-b-27">
            <div class="mtext-102 cl2 p-b-15">Chủ đề</div>
            <div class="flex-w p-t-4 m-r--5">
                <a href="javascript:void(0)" onclick="applyFilter('tag', 'Hoa Tặng Mẹ')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Hoa Tặng Mẹ' ? 'active' : '' ?>" style="<?= $tag === 'Hoa Tặng Mẹ' ? 'background-color: #007bff; color: white;' : '' ?>">Hoa Tặng Mẹ</a>
                <a href="javascript:void(0)" onclick="applyFilter('tag', 'Hoa Tiền')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Hoa Tiền' ? 'active' : '' ?>" style="<?= $tag === 'Hoa Tiền' ? 'background-color: #007bff; color: white;' : '' ?>">Hoa Tiền</a>
                <a href="javascript:void(0)" onclick="applyFilter('tag', 'Set Quà Tặng 8/3')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Set Quà Tặng 8/3' ? 'active' : '' ?>" style="<?= $tag === 'Set Quà Tặng 8/3' ? 'background-color: #007bff; color: white;' : '' ?>">Set Quà 8/3</a>
                <a href="javascript:void(0)" onclick="applyFilter('tag', 'Hoa Tặng Vợ')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Hoa Tặng Vợ' ? 'active' : '' ?>" style="<?= $tag === 'Hoa Tặng Vợ' ? 'background-color: #007bff; color: white;' : '' ?>">Hoa Tặng Vợ</a>
                <a href="javascript:void(0)" onclick="applyFilter('tag', 'Tình Yêu')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Tình Yêu' ? 'active' : '' ?>" style="<?= $tag === 'Tình Yêu' ? 'background-color: #007bff; color: white;' : '' ?>">Tình Yêu</a>
				<a href="javascript:void(0)" onclick="applyFilter('tag', 'Quà Tặng')" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 text-decoration-none <?= $tag === 'Quà Tặng' ? 'active' : '' ?>" style="<?= $tag === 'Quà Tặng' ? 'background-color: #007bff; color: white;' : '' ?>">Quà Tặng</a>
            </div>
        </div>
    </div>
</div>



			<div class="row" id="products-container">
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
});

// Function to apply filter using AJAX
function applyFilter(type, value) {
    // Update current filters
    currentFilters[type] = value;
    
    // Update active states
    updateActiveStates(type, value);
    
    // Load products with new filters
    loadProducts();
}

// Function to update active states
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

<?php include 'includes/footer.php'; ?>
