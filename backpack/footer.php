<footer id="footer">
			<div class="footer-top">
				<div class="row">
					<div class="columns large-4 small-12">
						<section class="footer-img">
							 <?php 
			                  global $redux_demo; 
			                  $logo = $redux_demo['logo']['url'];
			                  ?>
							<img src="<?=$logo?>" alt="Logo">
						</section>
						<section class="footer-text">
							<p>
								<i class="la la-map-marker"></i> 935/25/4 Huỳnh Tấn Phát, P.Phú Thuận, Q.7
							</p>
							<p>
								<i class="la la-phone"></i> 090.744.9013
							</p>
							<p>
								<i class="la la-facebook"></i> facebook.com/thoitranglita
							</p>
						</section>
					</div>
					<div class="columns large-2 small-4 footer-nav">
						<ul>
							<li><a href="">Câu hỏi thường gặp</a></li>
							<li><a href="">Hướng dẫn mua hàng</a></li>
							<li><a href="https://lita.vn/gioi-thieu/">Giới thiệu</a></li>
						</ul>
					</div>
					<div class="columns large-2 small-4 footer-nav">
						<ul>
							<li><a href="">Chính sách đổi trả</a></li>
							<li><a href="">Giao hàng đảm bảo</a></li>
						</ul>
					</div>
					<div class="columns large-4 small-4">
						<section class="footer-top-right footer-text">
							<a href=""><i class="la la-facebook"></i></a>
							<a href=""><i class="la la-google-plus"></i></a>
							<a href=""><i class="la la-instagram"></i></a>
						</section>
					</div>
				</div>
			</div>
			<div class="footer-bottom">
				<div class="row row-fluid no-padding full-width-row">
			      	<div class="column">
						<p>
							Copyright © 2017 by lita.vn | All right Reserved
						</p>
						<p>
							Website trong quá trình thử nghiệm.
						</p>
			      	</div>
			    </div>
			</div>
		</footer>
		</div>
	</div>
</div>
<?php wp_footer()?>
<script>
(function($){
   $(document).foundation();
 })(jQuery);
</script>
<?php if(is_single() || is_page('tin-tuc') || is_singular('product')):?>
<script type="text/javascript">
	$('.blog-c-r').stick_in_parent();
</script>
<?php endif?>
</body>
</html>     