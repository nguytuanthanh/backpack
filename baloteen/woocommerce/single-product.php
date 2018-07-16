<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header()?>
<?php get_template_part('inc/breadcrumb'); ?>
<div id="main-content">
	<div class="product-detail-wrapper">
	    <div class="row">
			<div class="large-5 medium-6 columns left-detail">
				<?php get_template_part('inc/product-images'); ?>
			</div>
			<div class="large-7 medium-6 columns right-detail">
				<?php get_template_part('inc/product-detail'); ?>
			</div>
      	</div>
    </div>
    <aside class="gap"></aside>
	<?php get_template_part('inc/product-content'); ?>
	<?php get_template_part('inc/related-item'); ?>
</div>
<?php get_footer()?>
