<div class="blog-contain">
	<div class="row">
		<div class="large-9 medium-8 small-12 columns blog-c-l">
			<ul class="tabs" data-tabs id="content-tabs">
			  	<li class="tabs-title is-active"><a href="#detail" aria-selected="true">Chi tiết</a></li>
				<li class="tabs-title"><a href="#commend">Nhận xét</a></li>
			</ul>
			<div class="tabs-content" data-tabs-content="content-tabs">
				<div class="tabs-panel is-active" id="detail">
					<?php the_content();?>
				</div>
				<div class="tabs-panel commend-tabs" id="commend">
					<?php comments_template(); ?>
				</div>
			</div>
		</div>
		<div class="large-3 medium-4 small-12 columns blog-c-r">
			<div class="floatingBlock">
				<div class="call-back">
					<h4>Đặt hàng ngay chỉ cần để lại SĐT</h4>
					<?php echo do_shortcode( '[get_phone_number]' );?>
				</div>
			</div>
		</div>
	</div>
</div>