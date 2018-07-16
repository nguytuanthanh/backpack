<?php get_header()?>
<?php get_template_part('inc/breadcrumb'); ?>
<div id="main-content">
	<div class="row">
		<div class="column">
			<div class="pnf">
	            <p>Không tìm thấy nội dung hay bài viết bạn cần tìm.</p>
	            <p>Vui lòng thử lại với nội dung khác.</p>
	            <h1>404</h1>
	            <div class="columns small-12 medium-6 medium-offset-3 float-left">
	                <div class="adv-search">
	                    <form id="adv-searchform" action="<?php bloginfo('url') ?>/" method="get"> 
	                    	<input type="text" name="s" value="<?php echo esc_html($s)?>" placeholder="Nhập nội dung cần tìm...">
	                    </form>
	                </div>
	            </div>
	            <div class="clearfix"></div>
	            <a href="<?=get_home_url();?>" class="button bh">Về trang chủ</a>
	        </div>
		</div>
	</div>
</div>
<?php get_footer()?>