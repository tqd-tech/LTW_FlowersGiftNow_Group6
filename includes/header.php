<?php
session_start();  // <-- Luôn nằm ở dòng đầu tiên
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>FLOWERGIFTNOW | SHOP HOA VÀ QUÀ CHẤT LƯỢNG</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" href="assets/images/icons/flower.png" />

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&family=Wallpoet&display=swap" rel="stylesheet">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Font Awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

	<!-- Material Design Iconic Font -->
	<link href="https://cdn.jsdelivr.net/npm/material-design-iconic-font@2.2.0/dist/css/material-design-iconic-font.min.css" rel="stylesheet">

	<!-- Linearicons (bạn có thể cần tự thêm nếu dùng font đặc biệt) -->
	<!-- <link href="PATH_TO_LINEARICONS/icon-font.min.css" rel="stylesheet"> -->

	<!-- Animate CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

	<!-- Hamburgers CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/hamburgers/1.1.3/hamburgers.min.css" rel="stylesheet">

	<!-- Animsition -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/animsition.js/1.0.0/css/animsition.min.css" rel="stylesheet">

	<!-- Select2 -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">

	<!-- Daterangepicker -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" rel="stylesheet">

	<!-- Slick -->
	<link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" rel="stylesheet">

	<!-- Magnific Popup -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet">

	<!-- Perfect Scrollbar -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/css/perfect-scrollbar.min.css" rel="stylesheet">

	<!-- Google Font Inter -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="assets/css/modern-design.css">

	<!-- Custom Dropdown Hover CSS -->
	<style>
		.dropdown-menu {
			background: linear-gradient(135deg, #ffffffff 0%, #ffeff8ff 50%, #fff0f9ff 100%);
			border: 2px solid #0048ffff;
			/* border-radius: var(--radius-lg); */
			/* animation */
			animation: fadeIn 0.8s ease-in-out;
			box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;
			padding: 4px;
		}

		@keyframes fadeIn {
			from {
				opacity: 0;
				/* transform: translateY(10px); */
			}

			to {
				opacity: 1;
				/* transform: translateY(0); */
			}
		}

		.dropdown-item {
			color: black !important;
			border-bottom: 1px solid #000000ff;
			/* padding: 12px 0; */
			transition: all 0.3s ease;
			/* border-radius: 4px; */
			display: flex;
			align-items: center;
			justify-content: flex-start;
			gap: 0.8rem;
		}

		.dropdown-item:hover,
		.dropdown-item:focus {
			background-color: #000000ff !important;
			color: white !important;
		}

		/* Mobile Menu Enhancements */
		.menu-mobile {
			display: none !important;
			z-index: 9999 !important;
			background-color: rgba(0, 0, 0, 0.95) !important;
			position: fixed !important;
			top: 0 !important;
			left: 0 !important;
			width: 100% !important;
			height: 100vh !important;
			overflow-y: auto !important;
			padding: 20px !important;
			color: white !important;
		}

		/* Force show when toggled */
		.menu-mobile[style*="block"] {
			display: block !important;
		}

		.btn-show-menu-mobile {
			z-index: 10000 !important;
			cursor: pointer !important;
			position: relative !important;
		}

		.btn-show-menu-mobile:hover {
			opacity: 0.8;
		}

		.main-menu-m {
			list-style: none !important;
			padding: 0 !important;
			margin: 20px 0 !important;
		}

		.main-menu-m li {
			border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
			padding: 15px 0 !important;
		}

		.main-menu-m li a {
			color: white !important;
			text-decoration: none !important;
			font-size: 18px !important;
			display: block !important;
			font-weight: 500;
		}

		.main-menu-m li a:hover {
			color: #ffc107 !important;
		}

		.topbar-mobile {
			list-style: none !important;
			padding: 0 !important;
			margin: 0 0 20px 0 !important;
			border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
			padding-bottom: 20px !important;
		}

		.topbar-mobile li {
			margin-bottom: 10px;
		}

		.topbar-mobile a {
			color: #ffc107 !important;
			text-decoration: none !important;
		}

		/* Sub menu styling */
		.sub-menu-m {
			list-style: none !important;
			padding-left: 20px !important;
			margin: 10px 0 !important;
			display: none;
		}

		.sub-menu-m li a {
			font-size: 16px !important;
			color: #ccc !important;
		}

		/* Arrow styling */
		.arrow-main-menu-m {
			float: right;
			color: white;
			transition: transform 0.3s ease;
		}

		.arrow-main-menu-m.turn-arrow-main-menu-m {
			transform: rotate(90deg);
		}

		/* Hamburger Animation */
		.hamburger.is-active .hamburger-inner,
		.hamburger.is-active .hamburger-inner::before,
		.hamburger.is-active .hamburger-inner::after {
			background-color: #fff !important;
		}
	</style>

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Bootstrap Bundle JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Additional JavaScript Libraries -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/animsition.js/1.0.0/js/animsition.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/js/perfect-scrollbar.min.js"></script>
</head>

<body class="animsition">


	<!-- Modern Header -->
	<header class="modern-header">
		<!-- Topbar -->
		<div style="background: var(--gray-800); color: white; padding: 0.5rem 0; font-size: 0.875rem;">
			<div class="container-modern" style="display: flex; justify-content: space-between; align-items: center;">
				<div class="fw-bold">
					<i class="fa fa-truck" style="margin-right: 0.5rem;"></i>
					Miễn phí vận chuyển cho đơn từ 500k
				</div>
				<div style="display: flex; gap: 1.5rem; align-items: center;">
					<?php if (isset($_SESSION['user_id'])): ?>
						<span style="display: flex; align-items: center; gap: 0.8rem; color: #ffb6edff; font-weight: 900;">
							<img src="./assets/images/icons/user.png" width="20" height="20" alt="">
							<div>
								Xin chào,<strong style="margin-left: 3px !important;"><?= htmlspecialchars($_SESSION['user_name']) ?></strong>
							</div>
						</span>
						<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
							<div class="dropdown">
								<a class="text-decoration-none" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" style="color: white; display: flex; align-items: center; gap: 0.5rem;">
									<img src="./assets/images/icons/admin-color.png" width="20" height="20" alt="">
									<span class="fw-bold">Quản trị hệ thống</span>
									<i class="fa fa-angle-down"></i>
								</a>
								<ul class="dropdown-menu dropdown-menu-end  fw-bold" aria-labelledby="adminDropdown">
									<li><a class="dropdown-item  fw-bold" href="admin/dashboard.php"><img src="./assets/images/icons/dashboard.png" width="20" height="20" alt=""> Dashboard</a></li>
									<li><a class="dropdown-item  fw-bold" href="admin/products.php"><img src="./assets/images/icons/products.png" width="20" height="20" alt=""> Sản phẩm</a></li>
									<li><a class="dropdown-item  fw-bold" href="admin/orders.php"><img src="./assets/images/icons/order.png" width="20" height="20" alt=""> Đơn hàng</a></li>
									<li><a class="dropdown-item  fw-bold border-0" href="admin/coupons.php"><img src="./assets/images/icons/coupons.png" width="20" height="20" alt=""> Giảm giá</a></li>
									<!-- <li><a class="dropdown-item" href="admin/reports.php"><i class="fa fa-bar-chart"></i> Báo cáo</a></li> -->
								</ul>
							</div>
						<?php else: ?>
							<a href="user/orders.php" class="text-decoration-none  fw-bold" style="color: white; display: flex; align-items: center; gap: 0.5rem;">
								<img src="./assets/images/icons/order.png" width="20" height="20" alt=""> Đơn hàng
							</a>
						<?php endif; ?>
						<a href="user/logout.php" class="text-decoration-none  fw-bold" style="color: white; display: flex; align-items: center; gap: 0.5rem;">
							<img src="./assets/images/icons/logout-color.png" width="20" height="20" alt=""> Đăng xuất
						</a>
					<?php else: ?>
						<a href="user/orders.php" class="text-decoration-none fw-bold" style="color: white; display: flex; align-items: center; gap: 0.5rem;">
							<img src="./assets/images/icons/search-cart.png" width="20" height="20" alt=""> Tra cứu đơn hàng
						</a>
						<a href="user/login.php" class="text-decoration-none  fw-bold" style="color: white; display: flex; align-items: center; gap: 0.5rem;">
							<img src="./assets/images/icons/sign-in-pink.png" width="20" height="20" alt=""> Đăng nhập
						</a>
						<a href="user/register.php" class="text-decoration-none  fw-bold" style="color: white; display: flex; align-items: center; gap: 0.5rem;">
							<img src="./assets/images/icons/sign-up-color.png" width="20" height="20" alt=""> Đăng ký
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<!-- Main Header -->
		<div class="container-menu-desktop">
			<div class="wrap-menu-desktop">
				<div style="width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 0 2rem;">
					<!-- Logo -->
					<a href="index.php" class="logo" style="display: flex; align-items: center; gap: 0.75rem; font-size: 1.5rem; font-weight: 800; color: var(--primary); text-decoration: none;">
						<!-- <img src="assets/images/icons/logo-01.png" alt="FlowerGiftNow" style="height: 50px;"> -->
						<span style="background: linear-gradient(135deg, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">FlowerGiftNow</span>
					</a>

					<!-- Navigation -->
					<nav class="modern-nav">
						<a href="index.php" class="modern-nav-link active">Trang chủ</a>
						<a href="index.php?category=flowers" class="modern-nav-link">Hoa tươi</a>
						<a href="index.php?category=gifts" class="modern-nav-link">Quà tặng</a>
						<a href="#sale" class="modern-nav-link" style="position: relative;">
							Giảm giá
							<span class="badge-modern badge-danger" style="position: absolute; top: -10px; right: -25px; font-size: 0.65rem;">HOT</span>
						</a>
						<a href="#about" class="modern-nav-link">Về chúng tôi</a>
						<a href="#contact" class="modern-nav-link">Liên hệ</a>
					</nav>

					<!-- Icons -->
					<div class="modern-header-icons">
						<?php
						$cart = $_SESSION['cart'] ?? [];
						$cartCount = array_sum($cart);
						?>
						<a href="cart.php" class="modern-icon-btn">
							<img src="./assets/images/icons/shopping-cart.png" width="20" height="20" alt="Giỏ hàng">
							<?php if ($cartCount > 0): ?>
								<span class="modern-badge"><?= $cartCount ?></span>
							<?php endif; ?>
						</a>
						<button class="modern-icon-btn">
							<img src="./assets/images/icons/love.png" width="20" height="20" alt="Tìm kiếm">
						</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->
			<div class="logo-mobile">
				<a href="index.php"><img src="assets/images/icons/logo-01.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<?php
				$cart = $_SESSION['cart'] ?? [];
				$cartCount = array_sum($cart);
				?>
				<a href="cart.php" class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="<?= $cartCount ?>">
					<i class="zmdi zmdi-shopping-cart"></i>
				</a>

				<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
					<i class="zmdi zmdi-favorite-outline"></i>
				</a>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze" onclick="toggleMobileMenu()" style="cursor: pointer; z-index: 10001;">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile ">
				<li>
					<div class="left-top-bar">
						Miễn phí vẫn chuyển cho đơn từ 500k
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<?php if (isset($_SESSION['user_id'])): ?>
							<span class="flex-c-m trans-04 p-lr-25 text-success" style="font-family: 'Roboto', sans-serif; font-weight: 500;">
								Xin chào, <b style="color: #28a745; font-weight: 700;"><?= htmlspecialchars($_SESSION['user_name']) ?></b>
							</span>
							<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
								<div class="dropdown d-inline-block">
									<a class="flex-c-m trans-04 p-lr-25 text-white text-decoration-none dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
										Quản trị hệ thống
									</a>
									<ul class="dropdown-menu" aria-labelledby="adminDropdown">
										<li><a class="dropdown-item text-primary" href="admin/dashboard.php">Dashboard quản trị</a></li>
										<li><a class="dropdown-item text-primary" href="admin/products.php">Quản lý sản phẩm</a></li>
										<li><a class="dropdown-item text-primary" href="admin/orders.php">Quản lý đơn hàng</a></li>
										<li><a class="dropdown-item text-primary" href="admin/coupons.php">Quản lý giảm giá</a></li>
										<li><a class="dropdown-item text-primary" href="admin/reports.php">Báo cáo thống kê</a></li>
									</ul>
								</div>
							<?php else: ?>
								<a href="user/orders.php" class="flex-c-m trans-04 p-lr-25 text-decoration-none">Đơn hàng</a>
							<?php endif; ?>
							<a href="user/logout.php" class="flex-c-m trans-04 p-lr-25 text-decoration-none">Đăng xuất</a>
						<?php else: ?>
							<a href="user/orders.php" class="flex-c-m trans-04 p-lr-25 text-decoration-none">Tra cứu đơn hàng</a>
							<a href="user/login.php" class="flex-c-m trans-04 p-lr-25 text-decoration-none">Đăng nhập</a>
							<a href="user/register.php" class="flex-c-m trans-04 p-lr-25 text-decoration-none">Đăng ký</a>
						<?php endif; ?>
					</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="index.php">Trang chủ</a>
					<ul class="sub-menu-m">
						<li><a href="index.php?category=flowers">Hoa tươi</a></li>
						<li><a href="index.php?category=gifts">Quà tặng</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="index.php?category=sale" class="label1 rs1" data-label1="hot">Giảm giá</a>
				</li>

				<li>
					<a href="#blog">Blog</a>
				</li>

				<li>
					<a href="#about">Về chúng tôi</a>
				</li>

				<li>
					<a href="#contact">Liên hệ</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="assets/images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>

	<!-- Main JavaScript Files -->
	<script src="assets/js/main.js"></script>

	<!-- Mobile Menu Debug Script -->
	<script>
		// Simple toggle function
		function toggleMobileMenu() {
			console.log('Toggle mobile menu called');
			var menu = document.querySelector('.menu-mobile');
			var button = document.querySelector('.btn-show-menu-mobile');

			if (menu.style.display === 'none' || menu.style.display === '') {
				menu.style.display = 'block';
				button.classList.add('is-active');
				document.body.style.overflow = 'hidden'; // Prevent background scroll
				console.log('Menu opened');
			} else {
				menu.style.display = 'none';
				button.classList.remove('is-active');
				document.body.style.overflow = 'auto'; // Restore background scroll
				console.log('Menu closed');
			}
		}

		// Close menu when clicking on menu background
		function closeMenuOnOverlay(event) {
			if (event.target.classList.contains('menu-mobile')) {
				toggleMobileMenu();
			}
		}

		$(document).ready(function() {
			console.log('Document ready, checking mobile menu...');
			console.log('jQuery version:', $.fn.jquery);
			console.log('Mobile menu button found:', $('.btn-show-menu-mobile').length);
			console.log('Mobile menu found:', $('.menu-mobile').length);

			// Add click event to menu background for closing
			$('.menu-mobile').on('click', closeMenuOnOverlay);

			// Handle sub-menu arrows
			$('.arrow-main-menu-m').on('click', function(e) {
				e.preventDefault();
				$(this).parent().find('.sub-menu-m').slideToggle();
				$(this).toggleClass('turn-arrow-main-menu-m');
			});

			// Close menu when window is resized to desktop
			$(window).resize(function() {
				if ($(window).width() >= 992) {
					if ($('.menu-mobile').css('display') === 'block') {
						toggleMobileMenu();
					}
				}
			});
		});
	</script>