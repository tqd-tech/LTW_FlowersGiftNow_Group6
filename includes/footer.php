    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="assets/js/main.js"></script> <!-- hoặc script chứa đoạn vừa gửi -->

	<!-- Modern Footer (clean, no gradients) -->
	<footer class="footer-modern">
		<div class="footer-modern-content">
			<!-- Newsletter sign-up -->
			<div style="background: var(--gray-800); border: 1px solid var(--gray-700); border-radius: var(--radius-xl); padding: 1.75rem; margin-bottom: 2rem; text-align: center;">
				<h3 style="color: white; font-weight: 700; margin-bottom: 0.5rem;">Đăng ký nhận ưu đãi</h3>
				<p style="color: var(--gray-400); margin-bottom: 1rem;">Nhận thông tin khuyến mãi và sản phẩm mới mỗi tuần</p>
				<div style="display: flex; gap: 0.5rem; max-width: 520px; margin: 0 auto;">
					<input type="email" placeholder="Email của bạn" style="flex: 1; padding: 0.75rem 1rem; border: 2px solid var(--gray-700); border-radius: var(--radius-lg); background: var(--gray-900); color: white;">
					<button class="btn-modern btn-primary" style="border-radius: var(--radius-lg);">Đăng ký</button>
				</div>
			</div>

			<div class="footer-modern-grid">
				<!-- About -->
				<div>
					<h3 class="footer-modern-title"> FlowerGiftNow</h3>
					<p style="color: var(--gray-400); line-height: 1.6; font-weight: 700;">Cửa hàng hoa tươi & quà tặng cao cấp, giao cấp tốc - chất lượng sốc.</p>
					<div style="display: flex; gap: 0.75rem;">
						<a href="#" class="modern-icon-btn" style="background: var(--gray-800); color: white;">
							<i class="fa fa-facebook"></i>
						</a>
						<a href="#" class="modern-icon-btn" style="background: var(--gray-800); color: white;">
							<i class="fa fa-instagram"></i>
						</a>
						<a href="#" class="modern-icon-btn" style="background: var(--gray-800); color: white;">
							<i class="fa fa-pinterest"></i>
						</a>
						<a href="#" class="modern-icon-btn" style="background: var(--gray-800); color: white;">
							<i class="fa fa-youtube-play"></i>
						</a>
					</div>
				</div>

				<!-- Products -->
				<div>
					<h3 class="footer-modern-title">Sản phẩm</h3>
					<a href="index.php?category=flowers" class="footer-modern-link"><i class="zmdi zmdi-flower"></i> Hoa tươi</a>
					<a href="index.php?category=gifts" class="footer-modern-link"><i class="zmdi zmdi-card-giftcard"></i> Quà tặng</a>
					<a href="#" class="footer-modern-link"><i class="zmdi zmdi-cake"></i> Hoa sự kiện</a>
					<a href="#" class="footer-modern-link"><i class="zmdi zmdi-favorite"></i> Hoa cưới</a>
				</div>

				<!-- Support -->
				<div>
					<h3 class="footer-modern-title">Hỗ trợ</h3>
					<a href="track_order.php" class="footer-modern-link"><i class="fa fa-truck"></i> Theo dõi đơn hàng</a>
					<a href="#" class="footer-modern-link"><i class="fa fa-refresh"></i> Chính sách đổi trả</a>
					<a href="#" class="footer-modern-link"><i class="fa fa-shield"></i> Bảo mật</a>
					<a href="#" class="footer-modern-link"><i class="fa fa-question-circle"></i> FAQs</a>
				</div>

				<!-- Contact -->
				<div>
					<h3 class="footer-modern-title">Liên hệ</h3>
					<div style="display: flex; flex-direction: column; gap: 0.75rem; color: var(--gray-400); font-weight: 700;">
						<div style="display: flex; align-items: start; gap: 0.5rem;">
							<i class="fa fa-map-marker" style="color: var(--primary);"></i>
							<span>02 Võ Oanh, Phường Thạnh Mỹ Tây, TP.HCM</span>
						</div>
						<div style="display: flex; align-items: center; gap: 0.5rem;">
							<i class="fa fa-phone" style="color: var(--primary);"></i>
							<a href="tel:19001234" style="color: var(--gray-400); text-decoration: none;">1900 1234</a>
						</div>
						<div style="display: flex; align-items: center; gap: 0.5rem;">
							<i class="fa fa-envelope" style="color: var(--primary);"></i>
							<a href="mailto:support@flowergiftnow.vn" style="color: var(--gray-400); text-decoration: none;">support@flowergiftnow.vn</a>
						</div>
						<div style="display: flex; align-items: center; gap: 0.5rem;">
							<i class="fa fa-clock-o" style="color: var(--primary);"></i>
							<span>24/7 - Luôn phục vụ</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Trust badges -->
			<!-- <div style="padding: 2rem 0; border-top: 1px solid var(--gray-700); border-bottom: 1px solid var(--gray-700); margin: 2rem 0;">
				<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
					<div style="text-align: center;">
						<div style="width: 56px; height: 56px; background: var(--gray-800); border-radius: var(--radius-full); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;">
							<i class="fa fa-shield" style="color: var(--success);"></i>
						</div>
						<p style="color: white; font-weight: 600; margin: 0;">Thanh toán an toàn</p>
						<small style="color: var(--gray-500);">Bảo mật SSL 256-bit</small>
					</div>
					<div style="text-align: center;">
						<div style="width: 56px; height: 56px; background: var(--gray-800); border-radius: var(--radius-full); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;">
							<i class="fa fa-truck" style="color: var(--info);"></i>
						</div>
						<p style="color: white; font-weight: 600; margin: 0;">Giao hàng nhanh</p>
						<small style="color: var(--gray-500);">Miễn phí từ 500k</small>
					</div>
					<div style="text-align: center;">
						<div style="width: 56px; height: 56px; background: var(--gray-800); border-radius: var(--radius-full); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;">
							<i class="fa fa-refresh" style="color: var(--warning);"></i>
						</div>
						<p style="color: white; font-weight: 600; margin: 0;">Đổi trả linh hoạt</p>
						<small style="color: var(--gray-500);">Trong 7 ngày</small>
					</div>
					<div style="text-align: center;">
						<div style="width: 56px; height: 56px; background: var(--gray-800); border-radius: var(--radius-full); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 0.5rem;">
							<i class="fa fa-headphones" style="color: var(--secondary);"></i>
						</div>
						<p style="color: white; font-weight: 600; margin: 0;">Hỗ trợ 24/7</p>
						<small style="color: var(--gray-500);">Tận tâm, nhiệt tình</small>
					</div>
				</div>
			</div> -->

			<!-- Payment Methods -->
			<div style="padding: 1rem;">
				<div style="text-align: center; margin-bottom: 1rem; color: var(--gray-400); font-weight: 900;">PHƯƠNG THỨC THANH TOÁN</div>
				<div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; align-items: center;">
					<img src="assets/images/icons/icon-pay-01.png" alt="Visa" style="height: 28px; opacity: 0.8;">
					<img src="assets/images/icons/icon-pay-02.png" alt="MasterCard" style="height: 28px; opacity: 0.8;">
					<img src="assets/images/icons/icon-pay-03.png" alt="PayPal" style="height: 28px; opacity: 0.8;">
					<img src="assets/images/icons/icon-pay-04.png" alt="COD" style="height: 28px; opacity: 0.8;">
					<img src="assets/images/icons/icon-pay-05.png" alt="Bank" style="height: 28px; opacity: 0.8;">
				</div>
			</div>

			<!-- Copyright -->
			<div class="footer-modern-bottom">
				<p style="margin: 0;">
					© <script>document.write(new Date().getFullYear());</script> FlowerGiftNow • All right reserved.
				</p>
			</div>
		</div>
	</footer>
<!--===============================================================================================-->
	<script src="assets/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="assets/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/slick/slick.min.js"></script>
	<script src="assets/js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/parallax100/parallax100.js"></script>
	<script>
        $('.parallax100').parallax100();
	</script>
<!--===============================================================================================-->
	<script src="assets/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<script>
		$('.gallery-lb').each(function() { // the containers for all your galleries
			$(this).magnificPopup({
		        delegate: 'a', // the selector for gallery item
		        type: 'image',
		        gallery: {
		        	enabled:true
		        },
		        mainClass: 'mfp-fade'
		    });
		});
	</script>
<!--===============================================================================================-->
	<script src="assets/vendor/isotope/isotope.pkgd.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/vendor/sweetalert/sweetalert.min.js"></script>
	<script>
		$('.js-addwish-b2').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		$('.js-addcart-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});
	
	</script>
<!--===============================================================================================-->
	<script src="assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});

		$('.js-show-filter').on('click', function(){
	$(this).toggleClass('show-filter');
	// $('.panel-filter').slideToggle(400);

	if($('.js-show-search').hasClass('show-search')) {
		$('.js-show-search').removeClass('show-search');
		// $('.panel-search').slideUp(400);
	}
});


	</script>

	
<!--===============================================================================================-->


<!-- Animsition -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/animsition.js/1.0.0/js/animsition.min.js"></script>

<!-- Popper & Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script>
	$(".js-select2").each(function(){
		$(this).select2({
			minimumResultsForSearch: 20,
			dropdownParent: $(this).next('.dropDownSelect2')
		});
	});
</script>

<!-- Daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Slick -->
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="assets/js/slick-custom.js"></script>

<!-- Parallax -->
<script src="https://cdn.jsdelivr.net/npm/parallax-js@3.1.0/dist/parallax.min.js"></script>
<script>
	$('.parallax100').parallax100?.(); // Check tồn tại để tránh lỗi
</script>

<!-- Magnific Popup -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script>
	$('.gallery-lb').each(function() {
		$(this).magnificPopup({
			delegate: 'a',
			type: 'image',
			gallery: { enabled: true },
			mainClass: 'mfp-fade'
		});
	});
</script>

<!-- Isotope -->
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	$('.js-addwish-b2').on('click', function(e){ e.preventDefault(); });

	$('.js-addwish-b2').each(function(){
		var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
		$(this).on('click', function(){
			Swal.fire(nameProduct, "Đã thêm vào yêu thích!", "success");
			$(this).addClass('js-addedwish-b2').off('click');
		});
	});

	$('.js-addcart-detail').each(function(){
		var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
		$(this).on('click', function(){
			Swal.fire(nameProduct, "Đã thêm vào giỏ hàng!", "success");
		});
	});
</script>

<!-- Perfect Scrollbar -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/perfect-scrollbar.min.js"></script>
<script>
	$('.js-pscroll').each(function(){
		$(this).css('position','relative').css('overflow','hidden');
		var ps = new PerfectScrollbar(this, {
			wheelSpeed: 1,
			scrollingThreshold: 1000,
			wheelPropagation: false,
		});
		$(window).on('resize', function(){ ps.update(); });
	});

	$('.js-show-filter').on('click', function(){
		$(this).toggleClass('show-filter');
		if($('.js-show-search').hasClass('show-search')) {
			$('.js-show-search').removeClass('show-search');
		}
	});
</script>

<!-- Main JS -->
<script src="assets/js/main.js"></script>

</body>
</html>
