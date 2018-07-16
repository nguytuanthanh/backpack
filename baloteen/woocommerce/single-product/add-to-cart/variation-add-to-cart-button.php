<?php
/**
 * Single variation cart button
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<?php $crosssells = get_post_meta( $product->get_id(), '_crosssell_ids',true);
if (!empty($crosssells)):
$args = array( 
    'post_type' => 'product', 
    'posts_per_page' => -1, 
    'post__in' => $crosssells 
    );
$products = new WP_Query( $args );
if( $products->have_posts() ) :
?>
<table >
    <tbody>
        <tr>
            <td style="padding:0;width: 30%; text-transform: uppercase;">Màu sắc</td>
            <td style="padding:0;">
                <?php while ( $products->have_posts() ) : $products->the_post();?>
                <a href="<?php the_permalink();?>">
                    <?php the_post_thumbnail(array(50,50)); ?>
                </a>
                <?php endwhile;?>
            </td>
        </tr>
    </tbody>
</table>
<?php endif;?>
<?php wp_reset_query()?>
<?php endif;?>
<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_quantity' ); ?>
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
    <div class="product-btn-group">
<?php do_action( 'woocommerce_after_add_to_cart_quantity' );?>
    <button type="submit" class="buy-product-btn quick-buy" value="<?php echo esc_attr( $product->get_id() ); ?>"><i class="la la-check-square"></i> Mua nhanh</button>
    <button type="button" class="buy-product-btn add-to-cart single_add_to_cart_button" value="<?php echo esc_attr( $product->get_id() ); ?>"><i class="la la-cart-plus"></i> <span>Thêm vào giỏ hàng</span></button>
	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</div>