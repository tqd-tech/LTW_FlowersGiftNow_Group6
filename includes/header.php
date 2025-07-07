<?php
session_start();  // <-- Luôn nằm ở dòng đầu tiên
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="icon" type="image/png" href="assets/images/icons/favicon.png"/>

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&family=Wallpoet&display=swap" rel="stylesheet">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Bootstrap Bundle JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="animsition">

	
	<!-- Header -->
	<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						Miễn phí vẫn chuyển cho đơn từ 500k
					</div>

					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m trans-04 p-lr-25 text-decoration-none">
							Trợ giúp & FAQs
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25 text-decoration-none">
							Tài khoản của tôi
						</a>

						
						<a href="track_order.php" class="flex-c-m trans-04 p-lr-25 text-decoration-none">
							Theo dõi đơn hàng
						</a>
						<a href="#" class="flex-c-m trans-04 p-lr-25 text-decoration-none">
							EN
						</a>
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->		
					<a href="#" class="logo">
						<img src="assets/images/icons/logo-01.png" alt="IMG-LOGO">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="index.php" class="text-decoration-none" >Trang chủ</a>
								<ul class="sub-menu">
									<li><a href="index.html" class="text-decoration-none">Hoa tươi</a></li>
									<li><a href="home-02.html" class="text-decoration-none">Quà tặng</a></li>
								</ul>
							</li>

							<li class="label1" data-label1="hot">
								<a href="l" class="text-decoration-none">Giảm giá</a>
							</li>

							<li>
								<a href="" class="text-decoration-none	">Blog</a>
							</li>

							<li>
								<a href="" class="text-decoration-none">Về chúng tôi</a>
							</li>

							<li>
								<a href="" class="text-decoration-none">Liên hệ</a>
							</li>
						</ul>
					</div>	

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

						<?php
						$cart = $_SESSION['cart'] ?? [];
						$cartCount = array_sum($cart);
						?>
						<a href="cart.php" class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="<?= $cartCount ?>">
						    <i class="zmdi zmdi-shopping-cart"></i>
						</a>

						<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="0">
							<i class="zmdi zmdi-favorite-outline"></i>
						</a>
					</div>
				</nav>
			</div>	
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<a href="index.html"><img src="assets/images/icons/logo-01.png" alt="IMG-LOGO"></a>
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
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile hidden-mobile">
				<li>
					<div class="left-top-bar">
						Miễn phí vẫn chuyển cho đơn từ 500k
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Help & FAQs
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Tài khoản của tôi
						</a>

						
						<a href="track_order.php" class="flex-c-m trans-04 p-lr-25 text-decoration-none">
								Theo dõi đơn hàng
							</a>
							<a href="#" class="flex-c-m p-lr-10 trans-04">
								EN
							</a>
						</div>
				</li>
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="index.html">Trang chủ</a>
					<ul class="sub-menu-m">
						<li><a href="index.html">Hoa tươi</a></li>
						<li><a href="home-02.html">Quà tặng</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>


				<li>
					<a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Giảm giá</a>
				</li>

				<li>
					<a href="blog.html">Blog</a>
				</li>

				<li>
					<a href="about.html">Về chúng tôi</a>
				</li>

				<li>
					<a href="contact.html">Liên hệ</a>
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
