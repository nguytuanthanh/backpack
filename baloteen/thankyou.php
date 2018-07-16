<?php
/*
Template Name: Thankyou
*/
?>
<?php get_header()?>
<?php get_template_part('inc/breadcrumb'); ?>
<div id="main-content">
    <div class="row">
        <div class="column">
        	<header class="page-title">
	    		<h1>Đặt hàng thành công</h1>
	    	</header>
            <?php the_content();?>
        </div>
    </div>
    <aside class="gap"></aside>
</div>
<?php get_footer('');?>