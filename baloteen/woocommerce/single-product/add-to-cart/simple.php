<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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
 * @version     3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product );

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>
		<?php
			/**
			 * @since 2.1.0.
			 */
			do_action( 'woocommerce_before_add_to_cart_button' );

			/**
			 * @since 3.0.0.
			 */
			do_action( 'woocommerce_before_add_to_cart_quantity' );

			/*woocommerce_quantity_input( array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : $product->get_min_purchase_quantity(),
			) );*/
			?>
		<div class="quantity">
	        <span class="input-group-btn">
	            <button type="button" class="btn-minus btn-number" data-type="minus" data-field="quantity">
	            	<i class="la la-minus"></i>
	            </button>
	        </span>
	        <input type="number" size="4" class="input-text qty text input-number" value="<?=$_POST['quantity'] ? $_POST['quantity']: 1;?>" min="1" max="<?=$product->backorders_allowed() ? $product->get_stock_quantity() : 20;?>" step="1" name="quantity">
	      	
	        <span class="input-group-btn">
	            <button type="button" class="btn-plus btn-number" data-type="plus" data-field="quantity">
	                <i class="la la-plus"></i>
	            </button>
	        </span>
	    </div>
		<?php
			/**
			 * @since 3.0.0.
			 */
			do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>
		<div class="product-btn-group">
			<button type="submit" class="buy-product-btn quick-buy" value="<?php echo esc_attr( $product->get_id() ); ?>"><i class="la la-check-square"></i> Mua nhanh</button>
			<button type="button" class="buy-product-btn add-to-cart simple_add_to_cart_button" value="<?php echo esc_attr( $product->get_id() ); ?>"><i class="la la-cart-plus"></i> <span>Thêm vào giỏ hàng</span></button>
			<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
			<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
			<?php
				/**
				 * @since 2.1.0.
				 */
				do_action( 'woocommerce_after_add_to_cart_button' );
			?>
		</div>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
