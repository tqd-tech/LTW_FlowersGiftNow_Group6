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



<!-- Modern Hero Section -->
<section class="hero-modern animate-fade-in">
    <div class="container-modern" style="padding: 4rem 2rem;">
        <div class="hero-modern-content">
            <div class="animate-slide-up">
                <span class="badge-modern badge-info d-inline-block " style="font-size: 0.875rem; margin-bottom: 1rem;">
                    <i class="fa fa-star"></i>
                    Uy tín • Chất lượng • Giao nhanh
                </span>
                <h1 class="hero-modern-title">
                    Hoa Tươi & Quà Tặng<br>
                    <span style="color: var(--primary);">Giao Nhanh & Uy Tín</span>
                </h1>
                <p class="hero-modern-subtitle ">
                    Gửi yêu thương qua từng cánh hoa tươi thắm. Miễn phí vận chuyển đơn từ 500k.
                </p>
                <div class="hero-modern-actions">
                    <a href="#products" class="btn-modern btn-primary btn-lg">
                        <i class="fa fa-shopping-cart"></i> Mua sắm ngay
                    </a>
                    <a href="#about" class="btn-modern btn btn-outline btn-lg">
                        <i class="fa fa-info-circle"></i> Tìm hiểu thêm
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-modern" style="margin-top: 3rem;">
            <input type="text" id="hero-search-input" class="search-modern-input" placeholder="Tìm kiếm hoa tươi, quà tặng..." value="<?= htmlspecialchars($search) ?>">
            <button class="search-modern-btn" onclick="performHeroSearch()">
                <i class="zmdi zmdi-search"></i>
            </button>
        </div>
    </div>
</section>

<!-- Quick Categories -->
<section style="background: var(--bg-primary); padding: 1rem 0; ">
    <div class="container-modern">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <a href="index.php?category=flowers" class="text-decoration-none">
                <div class="card-modern" style="text-align: center; padding: 2rem; cursor: pointer;">
                    <i class="zmdi zmdi-flower-alt" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem;"></i>
                    <h4 style="margin-bottom: 0.5rem;">Hoa Tươi</h4>
                    <p style="color: var(--text-secondary); margin: 0; font-size: 0.875rem;">Hoa tươi cao cấp, giao nhanh</p>
                </div>
            </a>
            <a href="index.php?category=gifts" class="text-decoration-none">
                <div class="card-modern" style="text-align: center; padding: 2rem; cursor: pointer;">
                    <i class="zmdi zmdi-card-giftcard" style="font-size: 3rem; color: var(--secondary); margin-bottom: 1rem;"></i>
                    <h4 style="margin-bottom: 0.5rem;">Quà Tặng</h4>
                    <p style="color: var(--text-secondary); margin: 0; font-size: 0.875rem;">Set quà độc đáo, ý nghĩa</p>
                </div>
            </a>
            <a href="#sale" class="text-decoration-none">
                <div class="card-modern" style="text-align: center; padding: 2rem; cursor: pointer; position: relative;">
                    <span class="badge-modern badge-danger" style="position: absolute; top: 1rem; right: 1rem;">HOT</span>
                    <i class="zmdi zmdi-fire" style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"></i>
                    <h4 style="margin-bottom: 0.5rem;">Giảm Giá</h4>
                    <p style="color: var(--text-secondary); margin: 0; font-size: 0.875rem;">Ưu đãi hấp dẫn mỗi ngày</p>
                </div>
            </a>
            <a href="#contact" class="text-decoration-none">
                <div class="card-modern" style="text-align: center; padding: 2rem; cursor: pointer;">
                    <i class="zmdi zmdi-phone" style="font-size: 3rem; color: var(--success); margin-bottom: 1rem;"></i>
                    <h4 style="margin-bottom: 0.5rem;">Liên Hệ</h4>
                    <p style="color: var(--text-secondary); margin: 0; font-size: 0.875rem;">Tư vấn 24/7 miễn phí</p>
                </div>
            </a>
        </div>
    </div>
</section>

<script>
    function performHeroSearch() {
        const searchInput = document.getElementById('hero-search-input');
        const searchValue = searchInput.value.trim();
        if (searchValue) {
            window.location.href = 'index.php?search=' + encodeURIComponent(searchValue);
        }
    }

    // Allow Enter key to trigger search
    document.getElementById('hero-search-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performHeroSearch();
        }
    });
</script>

<!-- Old Slider (Hidden) -->
<section class="section-slide hidden-mobile hidden_tablet" style="display: none;">
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
                        <div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">assets/images/icons/logo-01.png
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
<section id="products" style="padding: 1rem 0;">
    <div class="container-modern">
        <!-- Section Header -->
        <div style="text-align: center; margin-bottom: 1rem; background: var(--bg-primary); padding: 1.8rem 2rem; border-radius: 8px; box-shadow: 0 4px 12px 5px rgba(0,0,0,0.1);">
            <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem;">
                Sản Phẩm <span style="color: var(--primary);">Nổi Bật</span>
            </h2>
            <p style="color: var(--text-secondary); font-size: 1.125rem; margin: 0;">
                Khám phá bộ sưu tập hoa tươi và quà tặng cao cấp
            </p>
        </div>

        <!-- Modern Filter Bar -->
        <div class="filter-modern">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <!-- Category Filters -->
                <div class="filter-modern-group">
                    <a href="index.php" class="filter-modern-chip <?= !isset($_GET['category']) ? 'active' : '' ?>">
                        <img src="./assets/images/icons/all.png" width="20" height="20" alt=""> Tất cả
                    </a>
                    <a href="index.php?category=flowers" class="filter-modern-chip <?= isset($_GET['category']) && $_GET['category'] === 'flowers' ? 'active' : '' ?>">
                        <img src="./assets/images/icons/flower-bouquet.png" width="20" height="20" alt=""> Hoa tươi
                    </a>
                    <a href="index.php?category=gifts" class="filter-modern-chip <?= isset($_GET['category']) && $_GET['category'] === 'gifts' ? 'active' : '' ?>">
                        <img src="./assets/images/icons/gift.png" width="20" height="20" alt=""> Quà tặng
                    </a>
                </div>

                <!-- Filter & Search Buttons -->
                <div style="display: flex; gap: 0.5rem;">
                    <button class="btn-modern btn-ghost btn-sm js-show-filter">
                        <img src="./assets/images/icons/filter.png" alt="Filter Icon" width="20" height="20" style="margin-right: 0.25rem;" class="icon-filter">
                        <img src="./assets/images/icons/close-black.png" alt="Clear Filter" width="20" height="20" style="margin-right: 0.25rem;" class="icon-close-filter dis-none">
                        Lọc
                    </button>
                    <button class="btn-modern btn-ghost btn-sm js-show-search gap-0">
                        <img src="./assets/images/icons/search.png" alt="Search Icon" width="20" height="20" style="margin-right: 0.25rem;" class="icon-search">
                        <img src="./assets/images/icons/close-black.png" alt="Clear Search" width="20" height="20" style="margin-right: 0.25rem;" class="icon-close-search dis-none">
                        Tìm kiếm
                    </button>
                </div>
            </div>

            <!-- Search product -->
            <div class="dis-none panel-search w-full p-t-10 py-1">
                <div class="search-panel-modern">
                    <!-- Search Header -->
                    <div class="search-header">
                        <div class="search-header-left">
                            <img src="./assets/images/icons/search.png" alt="Search Icon" width="20" height="20" style="margin-right: 0.25rem;">
                            <span>Tìm kiếm sản phẩm</span>
                        </div>
                        <button onclick="clearSearch()" class="search-clear-btn">
                            <i class="fa fa-times"></i> Xóa
                        </button>
                    </div>
                    
                    <!-- Search Input Area -->
                    <div class="search-content">
                        <div class="search-input-wrapper">
                            <div class="search-icon">
                                <i class="zmdi zmdi-search"></i>
                            </div>
                            <input id="search-input" 
                                   type="text" 
                                   name="search" 
                                   class="search-input-modern" 
                                   placeholder="Nhập tên hoa, quà tặng bạn muốn tìm..." 
                                   value="<?= htmlspecialchars($search) ?>"
                                   autocomplete="off">
                            <button class="search-submit-btn" onclick="performSearch()">
                                <i class="fa fa-search"></i> Tìm kiếm
                            </button>
                        </div>
                        
                        <!-- Quick Search Tags -->
                        <div class="search-suggestions">
                            <span class="search-suggestions-label">Gợi ý:</span>
                            <a href="javascript:void(0)" onclick="quickSearch('Hoa hồng')" class="search-suggestion-tag">
                                <i class="fa fa-fire"></i> Hoa hồng
                            </a>
                            <a href="javascript:void(0)" onclick="quickSearch('Quà tặng')" class="search-suggestion-tag">
                                <i class="fa fa-gift"></i> Quà tặng
                            </a>
                            <a href="javascript:void(0)" onclick="quickSearch('Sinh nhật')" class="search-suggestion-tag">
                                <i class="fa fa-birthday-cake"></i> Sinh nhật
                            </a>
                            <a href="javascript:void(0)" onclick="quickSearch('Hoa lan')" class="search-suggestion-tag">
                                <i class="fa fa-leaf"></i> Hoa lan
                            </a>
                            <a href="javascript:void(0)" onclick="quickSearch('Valentine')" class="search-suggestion-tag">
                                <i class="fa fa-heart"></i> Valentine
                            </a>
                        </div>

                        <!-- Current Search Display -->
                        <?php if (!empty($search)): ?>
                        <div class="search-current">
                            <span class="search-current-label">
                                <i class="fa fa-search"></i> Đang tìm:
                            </span>
                            <span class="search-current-keyword"><?= htmlspecialchars($search) ?></span>
                            <button onclick="clearSearch()" class="search-current-clear">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="dis-none panel-filter w-full p-t-10 m-t-10">
                <div class="filter-panel-modern">
                    <!-- Filter Header -->
                    <div class="filter-header">
                        <div class="filter-header-left">
                            <i class="zmdi zmdi-filter-list"></i>
                            <span>Bộ lọc sản phẩm</span>
                        </div>
                        <button onclick="clearAllFilters()" class="filter-clear-btn">
                            <i class="fa fa-refresh"></i> Xóa tất cả
                        </button>
                    </div>

                    <!-- Filter Content -->
                    <div class="filter-content">
                        <!-- Sắp xếp -->
                        <div class="filter-section">
                            <div class="filter-section-title">
                                <i class="fa fa-sort-amount-asc"></i> Sắp xếp
                            </div>
                            <div class="filter-options">
                                <a href="javascript:void(0)" onclick="toggleFilter('sort', '')" class="filter-option <?= empty($sort) ? 'active' : '' ?>">
                                    <i class="fa fa-circle-o"></i> Mặc định
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('sort', 'price_asc')" class="filter-option <?= $sort === 'price_asc' ? 'active' : '' ?>">
                                    <i class="fa fa-arrow-up"></i> Giá tăng dần
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('sort', 'price_desc')" class="filter-option <?= $sort === 'price_desc' ? 'active' : '' ?>">
                                    <i class="fa fa-arrow-down"></i> Giá giảm dần
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('sort', 'newest')" class="filter-option <?= $sort === 'newest' ? 'active' : '' ?>">
                                    <i class="fa fa-clock-o"></i> Mới nhất
                                </a>
                            </div>
                        </div>

                        <!-- Khoảng giá -->
                        <div class="filter-section">
                            <div class="filter-section-title">
                                <i class="fa fa-money"></i> Khoảng giá
                            </div>
                            <div class="filter-options">
                                <a href="javascript:void(0)" onclick="toggleFilter('price', '0-200')" class="filter-option <?= $price === '0-200' ? 'active' : '' ?>">
                                    <i class="fa fa-tag"></i> Dưới 200k
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('price', '200-400')" class="filter-option <?= $price === '200-400' ? 'active' : '' ?>">
                                    <i class="fa fa-tag"></i> 200k - 400k
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('price', '400-500')" class="filter-option <?= $price === '400-500' ? 'active' : '' ?>">
                                    <i class="fa fa-tag"></i> 400k - 500k
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('price', '500+')" class="filter-option <?= $price === '500+' ? 'active' : '' ?>">
                                    <i class="fa fa-diamond"></i> Trên 500k
                                </a>
                            </div>
                        </div>

                        <!-- Danh mục -->
                        <div class="filter-section">
                            <div class="filter-section-title">
                                <i class="fa fa-folder-open"></i> Danh mục
                            </div>
                            <div class="filter-options filter-options-row">
                                <a href="javascript:void(0)" onclick="toggleFilter('category', 'flowers')" class="filter-card <?= $category === 'flowers' ? 'active' : '' ?>">
                                    <i class="zmdi zmdi-flower-alt"></i>
                                    <span>Hoa tươi</span>
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('category', 'gifts')" class="filter-card <?= $category === 'gifts' ? 'active' : '' ?>">
                                    <i class="zmdi zmdi-card-giftcard"></i>
                                    <span>Quà tặng</span>
                                </a>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="filter-section">
                            <div class="filter-section-title">
                                <i class="fa fa-hashtag"></i> Chủ đề
                            </div>
                            <div class="filter-tags">
                                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Hoa Tặng Mẹ')" class="filter-tag <?= $tag === 'Hoa Tặng Mẹ' ? 'active' : '' ?>">
                                    <i class="fa fa-heart"></i> Hoa Tặng Mẹ
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Hoa Tiền')" class="filter-tag <?= $tag === 'Hoa Tiền' ? 'active' : '' ?>">
                                    <i class="fa fa-dollar"></i> Hoa Tiền
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Set Quà Tặng 8/3')" class="filter-tag <?= $tag === 'Set Quà Tặng 8/3' ? 'active' : '' ?>">
                                    <i class="fa fa-gift"></i> Set Quà 8/3
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Hoa Tặng Vợ')" class="filter-tag <?= $tag === 'Hoa Tặng Vợ' ? 'active' : '' ?>">
                                    <i class="fa fa-female"></i> Hoa Tặng Vợ
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Tình Yêu')" class="filter-tag <?= $tag === 'Tình Yêu' ? 'active' : '' ?>">
                                    <i class="fa fa-heart-o"></i> Tình Yêu
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Quà Tặng')" class="filter-tag <?= $tag === 'Quà Tặng' ? 'active' : '' ?>">
                                    <i class="fa fa-cube"></i> Quà Tặng
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Sinh Nhật')" class="filter-tag <?= $tag === 'Sinh Nhật' ? 'active' : '' ?>">
                                    <i class="fa fa-birthday-cake"></i> Sinh Nhật
                                </a>
                                <a href="javascript:void(0)" onclick="toggleFilter('tag', 'Khai Trương')" class="filter-tag <?= $tag === 'Khai Trương' ? 'active' : '' ?>">
                                    <i class="fa fa-star"></i> Khai Trương
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Active Filters Display -->
                    <?php 
                    $activeFilters = [];
                    if (!empty($sort)) $activeFilters[] = ['type' => 'sort', 'label' => $sort === 'price_asc' ? 'Giá tăng' : ($sort === 'price_desc' ? 'Giá giảm' : 'Mới nhất')];
                    if (!empty($price)) $activeFilters[] = ['type' => 'price', 'label' => $price];
                    if (!empty($category)) $activeFilters[] = ['type' => 'category', 'label' => $category === 'flowers' ? 'Hoa tươi' : 'Quà tặng'];
                    if (!empty($tag)) $activeFilters[] = ['type' => 'tag', 'label' => $tag];
                    ?>
                    <?php if (!empty($activeFilters)): ?>
                    <div class="filter-active-bar">
                        <span class="filter-active-label"><i class="fa fa-check-circle"></i> Đang lọc:</span>
                        <?php foreach ($activeFilters as $filter): ?>
                            <span class="filter-active-tag" onclick="toggleFilter('<?= $filter['type'] ?>', '<?= $filter['type'] === 'sort' ? ($sort) : ($filter['type'] === 'price' ? $price : ($filter['type'] === 'category' ? $category : $tag)) ?>')">
                                <?= htmlspecialchars($filter['label']) ?>
                                <i class="fa fa-times"></i>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
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
                function buildQuery($overrides = [])
                {
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
                        <div class="<?= $colClass ?> p-b-35 animate-slide-up">
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
                                        <a href="product.php?id=<?= $product['id'] ?>" class="btn-modern btn-ghost btn-lg" style="background: white; color: var(--primary);">
                                            <i class="fa fa-eye"></i> Xem
                                        </a>
                                        <a href="add_to_cart.php?id=<?= $product['id'] ?>" class="btn-modern btn-primary btn-lg">
                                            <i class="fa fa-cart-plus"></i> Thêm
                                        </a>
                                    </div>
                                    <!-- Category Badge -->
                                    <?php if (!empty($product['tags'])): ?>
                                        <span class="badge-modern badge-info" style="position: absolute; top: 1rem; left: 1rem;">
                                            <?= htmlspecialchars(explode(',', $product['tags'])[0]) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="card-modern-body">
                                    <h3 class="card-modern-title" style="overflow: hidden; "
                                        title="<?php echo htmlspecialchars($product['name']); ?>">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </h3>
                                    <p class="card-modern-text" style="font-size: 0.875rem; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        <?php echo htmlspecialchars($product['description']); ?>
                                    </p>
                                    <div style="display: flex; align-items: center; justify-content: space-around; margin-top: auto; width: 100%;">
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
                        <div class="alert alert-info border-0 shadow-sm rounded-3" style=" ">
                            <i class="zmdi zmdi-info-outline "></i>
                            <strong>Không còn sản phẩm nào khác</strong>
                            <br>
                            <small class="text-muted ">Bạn đã xem hết tất cả sản phẩm có sẵn</small>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="col-12 text-center">
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

    // Function for quick search from suggestion tags
    function quickSearch(keyword) {
        $('#search-input').val(keyword);
        currentFilters.search = keyword;
        updateSearchDisplay();
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
        // Reset tất cả active states cho filter-option
        $('.filter-option').removeClass('active');
        $('.filter-card').removeClass('active');
        $('.filter-tag').removeClass('active');

        // Update Sort
        if (!currentFilters.sort || currentFilters.sort === '') {
            $('.filter-option[onclick*="toggleFilter(\'sort\', \'\')"]').addClass('active');
        } else {
            $('.filter-option[onclick*="toggleFilter(\'sort\', \'' + currentFilters.sort + '\')"]').addClass('active');
        }

        // Update Price
        if (currentFilters.price) {
            $('.filter-option[onclick*="toggleFilter(\'price\', \'' + currentFilters.price + '\')"]').addClass('active');
        }

        // Update Category
        if (currentFilters.category) {
            $('.filter-card[onclick*="toggleFilter(\'category\', \'' + currentFilters.category + '\')"]').addClass('active');
        }

        // Update Tag
        if (currentFilters.tag) {
            $('.filter-tag[onclick*="toggleFilter(\'tag\', \'' + currentFilters.tag + '\')"]').addClass('active');
        }

        // Update active filters bar
        updateActiveFiltersBar();
    }

    // Function to update the active filters bar dynamically
    function updateActiveFiltersBar() {
        var activeFiltersHtml = '';
        var hasActiveFilters = false;

        if (currentFilters.sort && currentFilters.sort !== '') {
            hasActiveFilters = true;
            var sortLabel = currentFilters.sort === 'price_asc' ? 'Giá tăng' : (currentFilters.sort === 'price_desc' ? 'Giá giảm' : 'Mới nhất');
            activeFiltersHtml += '<span class="filter-active-tag" onclick="toggleFilter(\'sort\', \'' + currentFilters.sort + '\')">' + sortLabel + ' <i class="fa fa-times"></i></span>';
        }
        if (currentFilters.price) {
            hasActiveFilters = true;
            activeFiltersHtml += '<span class="filter-active-tag" onclick="toggleFilter(\'price\', \'' + currentFilters.price + '\')">' + currentFilters.price + ' <i class="fa fa-times"></i></span>';
        }
        if (currentFilters.category) {
            hasActiveFilters = true;
            var categoryLabel = currentFilters.category === 'flowers' ? 'Hoa tươi' : 'Quà tặng';
            activeFiltersHtml += '<span class="filter-active-tag" onclick="toggleFilter(\'category\', \'' + currentFilters.category + '\')">' + categoryLabel + ' <i class="fa fa-times"></i></span>';
        }
        if (currentFilters.tag) {
            hasActiveFilters = true;
            activeFiltersHtml += '<span class="filter-active-tag" onclick="toggleFilter(\'tag\', \'' + currentFilters.tag + '\')">' + currentFilters.tag + ' <i class="fa fa-times"></i></span>';
        }

        if (hasActiveFilters) {
            var fullHtml = '<div class="filter-active-bar"><span class="filter-active-label"><i class="fa fa-check-circle"></i> Đang lọc:</span>' + activeFiltersHtml + '</div>';
            // Remove existing bar and add new one
            $('.filter-active-bar').remove();
            $('.filter-panel-modern').append(fullHtml);
        } else {
            $('.filter-active-bar').remove();
        }
    }

    // Function to update active states (giữ lại để tương thích)
    function updateActiveStates(type, value) {
        // Sử dụng updateAllActiveStates thay thế
        updateAllActiveStates();
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
    /* Modern Search Panel Styles */
    .search-panel-modern {
        background: linear-gradient(135deg, #ffffff 0%, #f0f9ff 100%);
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(59, 130, 246, 0.15);
        overflow: hidden;
        margin-bottom: 2rem;
        border: 1px solid rgba(59, 130, 246, 0.1);
    }

    .search-header {
        background: linear-gradient(135deg, #000000ff 0%, #525252ff 100%);
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .search-header-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .search-header-left i {
        font-size: 1.25rem;
    }

    .search-clear-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.5);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .search-clear-btn:hover {
        background: white;
        color: #3B82F6;
        transform: scale(1.05);
    }

    .search-content {
        padding: 1.5rem;
    }

    .search-input-wrapper {
        display: flex;
        align-items: center;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .search-input-wrapper:focus-within {
        border-color: #3B82F6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    }

    .search-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        color: #9ca3af;
        font-size: 1.25rem;
    }

    .search-input-modern {
        flex: 1;
        border: none;
        outline: none;
        font-size: 1rem;
        color: #1f2937;
        padding: 0.75rem 0.5rem;
        background: transparent;
    }

    .search-input-modern::placeholder {
        color: #9ca3af;
    }

    .search-submit-btn {
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .search-submit-btn:hover {
        background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    /* Search Suggestions */
    .search-suggestions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px dashed #e5e7eb;
    }

    .search-suggestions-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        margin-right: 0.5rem;
    }

    .search-suggestion-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.875rem;
        background: #f3f4f6;
        color: #4b5563;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
    }

    .search-suggestion-tag:hover {
        background: #dbeafe;
        color: #2563EB;
        border-color: #3B82F6;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .search-suggestion-tag i {
        font-size: 0.7rem;
        opacity: 0.7;
    }

    /* Current Search Display */
    .search-current {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 1rem;
        padding: 0.875rem 1rem;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 10px;
        border: 1px solid #fcd34d;
    }

    .search-current-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .search-current-keyword {
        background: #3B82F6;
        color: white;
        padding: 0.35rem 0.875rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .search-current-clear {
        margin-left: auto;
        background: #ef4444;
        color: white;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.75rem;
    }

    .search-current-clear:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    /* Responsive Search */
    @media (max-width: 640px) {
        .search-input-wrapper {
            flex-direction: column;
            gap: 0.75rem;
            padding: 1rem;
        }

        .search-icon {
            display: none;
        }

        .search-input-modern {
            width: 100%;
            text-align: center;
        }

        .search-submit-btn {
            width: 100%;
            justify-content: center;
        }

        .search-header {
            flex-direction: column;
            text-align: center;
        }
    }

    /* Modern Filter Panel Styles */
    .filter-panel-modern {
        background: linear-gradient(135deg, #ffffff 0%, #fdf2f8 100%);
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(236, 72, 153, 0.15);
        overflow: hidden;
        margin-bottom: 2rem;
        border: 1px solid rgba(236, 72, 153, 0.1);
    }

    .filter-header {
        background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%);
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .filter-header-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .filter-header-left i {
        font-size: 1.25rem;
    }

    .filter-clear-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.5);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-clear-btn:hover {
        background: white;
        color: #EC4899;
        transform: scale(1.05);
    }

    .filter-content {
        padding: 1.5rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .filter-section {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f4f6;
    }

    .filter-section-title {
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.75rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #fce7f3;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
    }

    .filter-section-title i {
        color: #EC4899;
    }

    .filter-options {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-options-row {
        flex-direction: row;
        flex-wrap: wrap;
    }

    .filter-option {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 0.75rem;
        border-radius: 8px;
        color: #4b5563;
        text-decoration: none;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .filter-option:hover {
        background: #fdf2f8;
        color: #EC4899;
        text-decoration: none;
    }

    .filter-option.active {
        background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%);
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
    }

    .filter-option.active i {
        color: white;
    }

    .filter-option i {
        font-size: 0.8rem;
        color: #9ca3af;
        transition: color 0.2s ease;
    }

    .filter-option:hover i {
        color: #EC4899;
    }

    /* Category Cards */
    .filter-card {
        flex: 1;
        min-width: 80px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 0.75rem;
        border-radius: 12px;
        background: #f9fafb;
        color: #4b5563;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        text-align: center;
    }

    .filter-card i {
        font-size: 1.5rem;
        color: #9ca3af;
        transition: all 0.3s ease;
    }

    .filter-card:hover {
        background: #fdf2f8;
        border-color: #EC4899;
        color: #EC4899;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .filter-card:hover i {
        color: #EC4899;
        transform: scale(1.1);
    }

    .filter-card.active {
        background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 6px 20px rgba(236, 72, 153, 0.35);
    }

    .filter-card.active i {
        color: white;
    }

    /* Filter Tags */
    .filter-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 0.875rem;
        border-radius: 50px;
        background: #f3f4f6;
        color: #4b5563;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
    }

    .filter-tag i {
        font-size: 0.75rem;
    }

    .filter-tag:hover {
        background: #fdf2f8;
        border-color: #EC4899;
        color: #EC4899;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .filter-tag.active {
        background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3);
    }

    /* Active Filters Bar */
    .filter-active-bar {
        background: #fef3c7;
        padding: 0.75rem 1.5rem;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        border-top: 1px solid #fcd34d;
    }

    .filter-active-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-active-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.75rem;
        background: #EC4899;
        color: white;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-active-tag:hover {
        background: #DB2777;
        transform: scale(1.05);
    }

    .filter-active-tag i {
        font-size: 0.65rem;
        opacity: 0.8;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .filter-content {
            grid-template-columns: 1fr;
        }

        .filter-header {
            flex-direction: column;
            text-align: center;
        }

        .filter-section:last-child {
            grid-column: 1;
        }
    }

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
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2) !important;
        /*Bóng đen sáng */
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
        border-color: #EC4899;
        box-shadow: 0 0 0 0.2rem rgba(236, 72, 153, 0.25);
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
        color: #EC4899;
        animation: fadeInUp 0.6s ease;
    }

    .alert-info i {
        color: #EC4899;
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