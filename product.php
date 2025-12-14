<?php require_once 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<?php
// Lấy ID sản phẩm từ URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Lấy thông tin sản phẩm
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: index.php');
    exit;
}

// Lấy danh mục
$categoryName = $product['category_id'] == 1 ? 'Hoa Tươi' : 'Quà Tặng';
$categorySlug = $product['category_id'] == 1 ? 'flowers' : 'gifts';

// Lấy sản phẩm liên quan (cùng danh mục, khác ID hiện tại)
$stmtRelated = $pdo->prepare("SELECT * FROM products WHERE category_id = ? AND id != ? ORDER BY RAND() LIMIT 4");
$stmtRelated->execute([$product['category_id'], $id]);
$relatedProducts = $stmtRelated->fetchAll();

// Xử lý tags
$tags = !empty($product['tags']) ? explode(',', $product['tags']) : [];
?>

<!-- Breadcrumb -->
<section style="background: var(--bg-secondary); padding: 1rem 0;">
    <div class="container-modern">
        <nav style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem;">
            <a href="index.php" style="color: var(--text-secondary); text-decoration: none;">
                <i class="fa fa-home"></i> Trang chủ
            </a>
            <span style="color: var(--text-muted);">/</span>
            <a href="index.php?category=<?= $categorySlug ?>" style="color: var(--text-secondary); text-decoration: none;">
                <?= $categoryName ?>
            </a>
            <span style="color: var(--text-muted);">/</span>
            <span style="color: var(--primary); font-weight: 500;"><?= htmlspecialchars($product['name']) ?></span>
        </nav>
    </div>
</section>

<!-- Product Detail Section -->
<section style="padding: 1rem 0;">
    <div class="container-modern">
        <div class="card-modern" style="padding: 2rem;">
            <div class="row">
                <!-- Product Image -->
                <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                    <div class="product-image-container" style="position: relative; border-radius: var(--radius-lg); overflow: hidden;">
                        <!-- Main Image -->
                        <img src="assets/images/<?= htmlspecialchars($product['image']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>"
                             id="main-product-image"
                             style="width: 100%; height: auto; max-height: 500px; object-fit: cover; border-radius: var(--radius-lg); cursor: zoom-in; transition: transform 0.3s ease;"
                             onclick="openImageModal()">
                        
                        <!-- Zoom hint -->
                        <div style="position: absolute; bottom: 1rem; right: 1rem; background: rgba(0,0,0,0.6); color: white; padding: 0.5rem 1rem; border-radius: var(--radius-md); font-size: 0.75rem;">
                            <i class="fa fa-search-plus"></i> Click để phóng to
                        </div>
                        
                        <!-- Category Badge -->
                        <?php if (!empty($tags)): ?>
                            <span class="badge-modern badge-info" style="position: absolute; top: 1rem; left: 1rem; font-size: 0.875rem;">
                                <?= htmlspecialchars(trim($tags[0])) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-6 col-md-6">
                    <div style="height: 100%; display: flex; flex-direction: column;">
                        <!-- Product Name -->
                        <h1 style="font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem; line-height: 1.3;">
                            <?= htmlspecialchars($product['name']) ?>
                        </h1>

                        <!-- Rating (placeholder) -->
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                            <div style="color: #ffc107;">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                            </div>
                            <span style="color: var(--text-secondary); font-size: 0.875rem;">(4.5/5 - 128 đánh giá)</span>
                        </div>

                        <!-- Price -->
                        <div style="background: linear-gradient(135deg, #fff0f5 0%, #fce7f3 100%); padding: 1rem; border-radius: var(--radius-lg); margin-bottom: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                                <span style="font-size: 2.5rem; font-weight: 800; color: var(--primary);">
                                    <?= number_format($product['price'], 0, ',', '.') ?>₫
                                </span>
                                <?php if ($product['price'] >= 500000): ?>
                                    <span class="badge-modern badge-success">
                                        <i class="fa fa-truck"></i> Freeship
                                    </span>
                                <?php endif; ?>
                            </div>
                            <p style=" color: var(--text-secondary); font-size: 0.875rem; margin: 0; font-weight: 700; ">
                                <i class="fa fa-check-circle" style="color: var(--success);"></i>
                                Còn hàng - Giao ngay trong 2-4 giờ
                            </p>
                        </div>

                        <!-- Description -->
                        <div style="">
                            <h4 style="font-weight: 600; margin-bottom: 0.75rem; color: var(--text-primary);">
                                <i class="fa fa-info-circle" style="color: var(--primary);"></i> Mô tả sản phẩm
                            </h4>
                            <p style="color: var(--text-secondary); line-height: 1.8; font-size: 1rem;">
                                <?= nl2br(htmlspecialchars($product['description'])) ?>
                            </p>
                        </div>

                        <!-- Tags -->
                        <?php if (!empty($tags)): ?>
                            <div style="margin-bottom: 1.5rem;">
                                <h4 style="font-weight: 600; margin-bottom: 0.75rem; color: var(--text-primary);">
                                    <i class="fa fa-tags" style="color: var(--secondary);"></i> Thẻ
                                </h4>
                                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                    <?php foreach ($tags as $tag): ?>
                                        <a href="index.php?tag=<?= urlencode(trim($tag)) ?>" 
                                           class="badge-modern badge-light" 
                                           style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.875rem;">
                                            <?= htmlspecialchars(trim($tag)) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Quantity Selector -->
                        <div style="margin-bottom: 1.5rem;">
                            <h4 style="font-weight: 600; margin-bottom: 0.75rem; color: var(--text-primary);">
                                <i class="fa fa-shopping-basket" style="color: var(--info);"></i> Số lượng
                            </h4>
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="display: flex; align-items: center; border: 2px solid var(--gray-200); border-radius: var(--radius-lg); overflow: hidden;">
                                    <button type="button" onclick="decreaseQty()" 
                                            style="width: 48px; height: 48px; border: none; background: var(--bg-secondary); cursor: pointer; font-size: 1.25rem; transition: background 0.2s;"
                                            onmouseover="this.style.background='var(--gray-200)'" 
                                            onmouseout="this.style.background='var(--bg-secondary)'">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1" max="99" 
                                           style="width: 60px; height: 48px; border: none; text-align: center; font-size: 1.125rem; font-weight: 600;">
                                    <button type="button" onclick="increaseQty()" 
                                            style="width: 48px; height: 48px; border: none; background: var(--bg-secondary); cursor: pointer; font-size: 1.25rem; transition: background 0.2s;"
                                            onmouseover="this.style.background='var(--gray-200)'" 
                                            onmouseout="this.style.background='var(--bg-secondary)'">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <span style="color: var(--text-muted); font-size: 0.875rem;">
                                    <i class="fa fa-cube"></i> Còn nhiều sản phẩm
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: auto;">
                            <button onclick="addToCart(<?= $product['id'] ?>)" 
                                    class="btn-modern btn-primary btn-lg" 
                                    style="flex: 1; min-width: 200px; padding: 1rem 2rem; font-size: 1rem;">
                                <i class="fa fa-cart-plus"></i> Thêm vào giỏ hàng
                            </button>
                            <button onclick="buyNow(<?= $product['id'] ?>)" 
                                    class="btn-modern btn-secondary btn-lg" 
                                    style="flex: 1; min-width: 200px; padding: 1rem 2rem; font-size: 1rem;">
                                <i class="fa fa-bolt"></i> Mua ngay
                            </button>
                        </div>

                        <!-- Quick Info -->
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200);">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 40px; height: 40px; background: var(--success-bg); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                                    <img src="assets/images/icons/delivery-car.png" alt="Giao hàng nhanh" style="width: 24px; height: 24px;">
                                </div>
                                <div>
                                    <p style="margin: 0; font-weight: 600; font-size: 0.875rem;">Giao hàng nhanh</p>
                                    <p style="margin: 0; color: var(--text-muted); font-size: 0.75rem;">2-4 giờ nội thành</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 40px; height: 40px; background: var(--info-bg); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                                    <img src="assets/images/icons/loop.png" alt="Đổi trả dễ dàng" style="width: 24px; height: 24px;">
                                </div>
                                <div>
                                    <p style="margin: 0; font-weight: 600; font-size: 0.875rem;">Đổi trả dễ dàng</p>
                                    <p style="margin: 0; color: var(--text-muted); font-size: 0.75rem;">Trong 24 giờ</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 40px; height: 40px; background: var(--warning-bg); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                                    <img src="assets/images/icons/shield.png" alt="Bảo hành" style="width: 24px; height: 24px;">
                                </div>
                                <div>
                                    <p style="margin: 0; font-weight: 600; font-size: 0.875rem;">Bảo hành</p>
                                    <p style="margin: 0; color: var(--text-muted); font-size: 0.75rem;">Hoa tươi 100%</p>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 40px; height: 40px; background: var(--primary-bg); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                                    <img src="assets/images/icons/quality.png" alt="Chất lượng" style="width: 24px; height: 24px;">
                                </div>
                                <div>
                                    <p style="margin: 0; font-weight: 600; font-size: 0.875rem;">Chất lượng</p>
                                    <p style="margin: 0; color: var(--text-muted); font-size: 0.75rem;">Cam kết hài lòng</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Details Tabs -->
<section style="padding: 0 0 3rem;">
    <div class="container-modern">
        <div class="card-modern" style="padding: 0; overflow: hidden;">
            <!-- Tab Headers -->
            <div style="display: flex; border-bottom: 2px solid var(--gray-200); background: var(--bg-secondary);">
                <button class="tab-btn active" onclick="switchTab('details')" id="tab-details"
                        style="flex: 1; padding: 1.25rem; border: none; background: none; font-weight: 600; cursor: pointer; position: relative; transition: all 0.3s;">
                    <i class="fa fa-list-alt"></i> Chi tiết sản phẩm
                </button>
                <button class="tab-btn" onclick="switchTab('shipping')" id="tab-shipping"
                        style="flex: 1; padding: 1.25rem; border: none; background: none; font-weight: 600; cursor: pointer; position: relative; transition: all 0.3s;">
                    <i class="fa fa-truck"></i> Vận chuyển
                </button>
                <button class="tab-btn" onclick="switchTab('reviews')" id="tab-reviews"
                        style="flex: 1; padding: 1.25rem; border: none; background: none; font-weight: 600; cursor: pointer; position: relative; transition: all 0.3s;">
                    <i class="fa fa-star"></i> Đánh giá
                </button>
            </div>

            <!-- Tab Contents -->
            <div style="padding: 2rem;">
                <!-- Details Tab -->
                <div id="content-details" class="tab-content active">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 style="font-weight: 600; margin-bottom: 1rem; color: var(--primary);">
                                <i class="fa fa-info-circle"></i> Thông tin sản phẩm
                            </h4>
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 500; width: 40%;">Mã sản phẩm:</td>
                                    <td style="padding: 0.75rem 0; color: var(--text-secondary); text-align: center;">SP<?= str_pad($product['id'], 5, '0', STR_PAD_LEFT) ?></td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 500;">Danh mục:</td>
                                    <td style="padding: 0.75rem 0; color: var(--text-secondary); text-align: center;"><?= $categoryName ?></td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 500;">Tình trạng:</td>
                                    <td style="padding: 0.75rem 0;"><span class="badge-modern badge-success">Còn hàng</span></td>
                                </tr>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <td style="padding: 0.75rem 0; font-weight: 500;">Ngày thêm:</td>
                                    <td style="padding: 0.75rem 0; color: var(--text-secondary); text-align: center;"><?= date('d/m/Y', strtotime($product['created_at'])) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4 style="font-weight: 600; margin-bottom: 1rem; color: var(--primary);">
                                <i class="fa fa-leaf"></i> Đặc điểm nổi bật
                            </h4>
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.75rem;">
                                    <i class="fa fa-check-circle" style="color: var(--success);"></i>
                                    <span>Hoa tươi được chọn lọc kỹ càng</span>
                                </li>
                                <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.75rem;">
                                    <i class="fa fa-check-circle" style="color: var(--success);"></i>
                                    <span>Thiết kế bởi florist chuyên nghiệp</span>
                                </li>
                                <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.75rem;">
                                    <i class="fa fa-check-circle" style="color: var(--success);"></i>
                                    <span>Đóng gói cẩn thận, an toàn</span>
                                </li>
                                <li style="padding: 0.5rem 0; display: flex; align-items: center; gap: 0.75rem;">
                                    <i class="fa fa-check-circle" style="color: var(--success);"></i>
                                    <span>Kèm thiệp chúc miễn phí</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Shipping Tab -->
                <div id="content-shipping" class="tab-content" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 style="font-weight: 600; margin-bottom: 1rem; color: var(--primary);">
                                <i class="fa fa-truck"></i> Phương thức vận chuyển
                            </h4>
                            <div style="background: var(--bg-secondary); padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <p style="margin: 0; font-weight: 600;">🚀 Giao siêu tốc (2-4 giờ)</p>
                                        <p style="margin: 0; color: var(--text-muted); font-size: 0.875rem;">Nội thành TP.HCM</p>
                                    </div>
                                    <span style="color: var(--primary); font-weight: 600;">30.000₫</span>
                                </div>
                            </div>
                            <div style="background: var(--bg-secondary); padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <p style="margin: 0; font-weight: 600;">📦 Giao tiêu chuẩn (1-2 ngày)</p>
                                        <p style="margin: 0; color: var(--text-muted); font-size: 0.875rem;">Toàn quốc</p>
                                    </div>
                                    <span style="color: var(--primary); font-weight: 600;">50.000₫</span>
                                </div>
                            </div>
                            <div style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); padding: 1rem; border-radius: var(--radius-md);">
                                <p style="margin: 0; font-weight: 600; color: var(--success);">
                                    <i class="fa fa-gift"></i> Miễn phí vận chuyển cho đơn từ 500.000₫
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 style="font-weight: 600; margin-bottom: 1rem; color: var(--primary);">
                                <i class="fa fa-clock-o"></i> Thời gian giao hàng
                            </h4>
                            <p style="color: var(--text-secondary); line-height: 1.8;">
                                • Đặt hàng trước 14h: Giao trong ngày<br>
                                • Đặt hàng sau 14h: Giao ngày hôm sau<br>
                                • Có thể chọn khung giờ giao cụ thể<br>
                                • Hỗ trợ giao vào ngày lễ, cuối tuần
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div id="content-reviews" class="tab-content" style="display: none;">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div style="font-size: 4rem; font-weight: 800; color: var(--primary);">4.5</div>
                            <div style="color: #ffc107; font-size: 1.5rem; margin-bottom: 0.5rem;">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                            </div>
                            <p style="color: var(--text-muted);">128 đánh giá</p>
                        </div>
                        <div class="col-md-8">
                            <!-- Sample Reviews -->
                            <div style="border-bottom: 1px solid var(--gray-200); padding-bottom: 1rem; margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <strong>Nguyễn Văn A</strong>
                                    <span style="color: #ffc107;">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </span>
                                </div>
                                <p style="color: var(--text-secondary); margin: 0;">Hoa rất đẹp, giao hàng nhanh chóng. Sẽ ủng hộ tiếp!</p>
                                <small style="color: var(--text-muted);">2 ngày trước</small>
                            </div>
                            <div style="border-bottom: 1px solid var(--gray-200); padding-bottom: 1rem; margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                    <strong>Trần Thị B</strong>
                                    <span style="color: #ffc107;">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-o"></i>
                                    </span>
                                </div>
                                <p style="color: var(--text-secondary); margin: 0;">Đóng gói cẩn thận, hoa tươi và đẹp như hình.</p>
                                <small style="color: var(--text-muted);">1 tuần trước</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php if (!empty($relatedProducts)): ?>
<section style="padding: 0 0 3rem;">
    <div class="container-modern">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h2 style="font-size: 2rem; font-weight: 700;">
                Sản phẩm <span style="color: var(--primary);">liên quan</span>
            </h2>
            <p style="color: var(--text-secondary);">Có thể bạn cũng thích những sản phẩm này</p>
        </div>
        
        <div class="row">
            <?php foreach ($relatedProducts as $related): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
                    <div class="card-modern" style="height: 100%;">
                        <div style="position: relative; overflow: hidden;">
                            <a href="product.php?id=<?= $related['id'] ?>">
                                <img src="assets/images/<?= htmlspecialchars($related['image']) ?>"
                                     class="card-modern-img"
                                     alt="<?= htmlspecialchars($related['name']) ?>"
                                     style="transition: transform 0.3s ease;">
                            </a>
                            <!-- Quick View Overlay -->
                            <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.4); opacity: 0; transition: opacity 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 0.5rem;"
                                 onmouseover="this.style.opacity='1'"
                                 onmouseout="this.style.opacity='0'">
                                <a href="product.php?id=<?= $related['id'] ?>" class="btn-modern btn-ghost" style="background: white; color: var(--primary);">
                                    <img src="assets/images/icons/eye.png" alt="Xem" style="width: 24px; height: 24px;"> Xem
                                </a>
                            </div>
                        </div>
                        <div class="card-modern-body">
                            <h3 class="card-modern-title" style="font-size: 1rem;">
                                <a href="product.php?id=<?= $related['id'] ?>" style="color: inherit; text-decoration: none;">
                                    <?= htmlspecialchars($related['name']) ?>
                                </a>
                            </h3>
                            <div class="card-modern-price" style="font-size: 1.125rem;">
                                <?= number_format($related['price'], 0, ',', '.') ?>₫
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Image Modal -->
<div id="imageModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.9); z-index: 9999; align-items: center; justify-content: center; cursor: zoom-out;" onclick="closeImageModal()">
    <button onclick="closeImageModal()" style="position: absolute; top: 1rem; right: 1rem; background: white; border: none; width: 48px; height: 48px; border-radius: 50%; cursor: pointer; font-size: 1.5rem; z-index: 10000;">
        <i class="fa fa-times"></i>
    </button>
    <img src="assets/images/<?= htmlspecialchars($product['image']) ?>" 
         style="max-width: 90%; max-height: 90%; object-fit: contain; border-radius: var(--radius-lg);"
         onclick="event.stopPropagation()">
</div>

<!-- Toast Notification -->
<div id="toast" style="display: none; position: fixed; bottom: 2rem; right: 2rem; background: var(--success); color: white; padding: 1rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg); z-index: 9999; animation: slideInRight 0.3s ease;">
    <i class="fa fa-check-circle"></i> <span id="toast-message">Đã thêm vào giỏ hàng!</span>
</div>

<style>
    /* Tab Styles */
    .tab-btn {
        color: var(--text-secondary);
    }
    .tab-btn:hover {
        color: var(--primary);
        background: var(--bg-primary);
    }
    .tab-btn.active {
        color: var(--primary);
        background: white;
    }
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--primary);
    }
    
    /* Animations */
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    /* Image hover effect */
    #main-product-image:hover {
        transform: scale(1.02);
    }
    
    /* Quantity input */
    #quantity::-webkit-outer-spin-button,
    #quantity::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    #quantity[type=number] {
        -moz-appearance: textfield;
    }
    
    /* Badge light style */
    .badge-light {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--gray-200);
    }
    .badge-light:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }
    
    /* Card hover effect */
    .card-modern:hover .card-modern-img {
        transform: scale(1.05);
    }
    
    /* Success/Warning/Info backgrounds */
    :root {
        --success-bg: #dcfce7;
        --warning-bg: #fef3c7;
        --info-bg: #dbeafe;
        --primary-bg: #fce7f3;
    }
</style>

<script>
    // Quantity functions
    function increaseQty() {
        const input = document.getElementById('quantity');
        const currentVal = parseInt(input.value) || 1;
        if (currentVal < 99) {
            input.value = currentVal + 1;
        }
    }
    
    function decreaseQty() {
        const input = document.getElementById('quantity');
        const currentVal = parseInt(input.value) || 1;
        if (currentVal > 1) {
            input.value = currentVal - 1;
        }
    }
    
    // Add to cart function
    function addToCart(productId) {
        const quantity = document.getElementById('quantity').value;
        
        // AJAX request to add to cart
        fetch('add_to_cart.php?id=' + productId + '&qty=' + quantity)
            .then(response => response.text())
            .then(data => {
                showToast('Đã thêm ' + quantity + ' sản phẩm vào giỏ hàng!');
            })
            .catch(error => {
                // Fallback: redirect to add_to_cart.php
                window.location.href = 'add_to_cart.php?id=' + productId + '&qty=' + quantity;
            });
    }
    
    // Buy now function
    function buyNow(productId) {
        const quantity = document.getElementById('quantity').value;
        window.location.href = 'add_to_cart.php?id=' + productId + '&qty=' + quantity + '&redirect=checkout';
    }
    
    // Toast notification
    function showToast(message) {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');
        toastMessage.textContent = message;
        toast.style.display = 'block';
        
        setTimeout(() => {
            toast.style.display = 'none';
        }, 3000);
    }
    
    // Tab switching
    function switchTab(tabName) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(el => {
            el.style.display = 'none';
        });
        
        // Remove active from all tabs
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('active');
        });
        
        // Show selected content
        document.getElementById('content-' + tabName).style.display = 'block';
        
        // Add active to selected tab
        document.getElementById('tab-' + tabName).classList.add('active');
    }
    
    // Image modal functions
    function openImageModal() {
        const modal = document.getElementById('imageModal');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
