<?php global $product;?>
<?php global $wp_query;?>
<header class="product-title">
	<h1><?php the_title();?></h1>
</header>
<div class="product-block">
	<div class="product-sku">
		Mã SKU: <?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?>
	</div>
	<?php if($product->get_average_rating()):?>
		<div class="average">
			<?php echo wc_get_rating_html( $product->get_average_rating() );?>
		</div>
	<?php endif;?>
</div>
<?php //do_action( 'woocommerce_before_single_product' );?>
<!-- <div class="area-price">
	<p><?php echo $product->get_price_html(); ?></p>
</div> -->
<?php 
remove_action( 'woocommerce_before_single_product', 'woocommerce_show_messages' );
add_action( 'woocommerce_after_single_product', 'woocommerce_show_messages', 15 );
?>
<?php
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	do_action( 'woocommerce_single_product_summary' );
?>	
<?php do_action( 'woocommerce_after_single_product' ); ?>
<div class="ctsp">
    <div class="ctsp-truck">
		<i class="la la-truck"></i>
		<p>Giao hàng <br/>toàn Quốc</p>
	</div>
	<div class="ctsp-refresh">
		<i class="la la-refresh"></i>
		<p>Đổi hàng 15 ngày <br/>miễn phí</p>
	</div>
	<div class="ctsp-check">
		<i class="la la-money"></i>
		<p>Thanh toán <br/>tại nhà</p>
	</div>
</div>