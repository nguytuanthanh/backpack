<!--
<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" enctype='multipart/form-data'  data-product_id="<?php echo absint( $product->id ); ?>" data-product_variations="<?php echo htmlspecialchars( json_encode( $available_variations ) ) ?>">
	<?php get_template_part('inc/variable'); ?>
 	    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
	<div class="woocommerce-variation-add-to-cart variations_button">
 	    <?php do_action( 'woocommerce_before_add_to_cart_quantity' ); ?>
		<div class="quantity">
            <span class="input-group-btn">
                <button type="button" class="btn-minus btn-number"  data-type="minus" data-field="quantity">
                	<i class="fa fa-minus"></i>
                </button>
            </span>
            <input type="number" size="4" class="input-text qty text input-number" value="<?=$_POST['quantity'] ? $_POST['quantity']: 1;?>" min="1" max="<?=$product->backorders_allowed() ? $product->get_stock_quantity() : 100;?>" step="1" name="quantity">
          	
            <span class="input-group-btn">
                <button type="button" class="btn-plus btn-number" data-type="plus" data-field="quantity">
                    <i class="fa fa-plus"></i>
                </button>
            </span>
        </div>
    <?php do_action( 'woocommerce_after_add_to_cart_quantity' );?>
	<button type="submit" class="buy-product-btn quick-buy" value="<?php echo esc_attr( $product->get_id() ); ?>"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
		<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
		<input type="hidden" name="variation_id" class="variation_id" value="0" />
	</div>
	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>
<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>    
-->

<?php do_action( 'woocommerce_before_variations_form' ); ?>
<div class="shop_attributes">
<?php 
global $product;
foreach ( $product->attributes as $attribute ) : ?>
	<?php echo wc_attribute_label( $attribute->get_name() ); ?>
	<?php
		$values = array();
		/*if ( $attribute->is_taxonomy() ) {
			$attribute_taxonomy = $attribute->get_taxonomy_object();
			$attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );
			foreach ( $attribute_values as $attribute_value ) {
				$value_name = esc_html( $attribute_value->name );
				if ( $attribute_taxonomy->attribute_public ) {
					$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
				} else {
					$values[] = $value_name;
				}
			}
		} else {
			$values = $attribute->get_options();
			foreach ( $values as &$value ) {
				$value = make_clickable( esc_html( $value ) );
			}
		}*/

		/*if ( empty( $_POST ) )
            $selected_value = ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) ? $selected_attributes[ sanitize_title( $name ) ] : '';
        else
            $selected_value = isset( $_POST[ 'attribute_' . sanitize_title( $name ) ] ) ? $_POST[ 'attribute_' . sanitize_title( $name ) ] : '';
		*/
		$values = $attribute->get_options();
		foreach ( $values as &$value ) {
			$value = make_clickable( esc_html( $value ) );
		}
		$attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );
		$attributes_dropdown = '<select id="'.$attribute->get_name().'" name="attribute_'.$attribute->get_name().'" data-attribute_name="attribute_'.$attribute->get_name().'" data-type="colorpicker" >';
        $product_attributes = $attribute->get_options($product->get_id());
        $attributes_dropdown .= '<option value="">Chọn giá trị</option>';
        foreach ( $attribute_values as $value ) {
        	$val = get_woocommerce_term_meta($value->term_id, $attribute->get_name().'_yith_wccl_value',true);
            $attributes_dropdown .= '<option value="' . $value->slug . '"  data-value="' . $val. '" '.selected( $selected_value, $value->slug, false ).' class="attached enabled">' . esc_html( $value->name ) . '</option>';
        }
        $attributes_dropdown .= '</select>';
        echo $attributes_dropdown;
        //echo $attribute->get_price_html();
        //echo wc_wc20_variation_price_format( $product->get_regular_price(), $product);
	?>
<?php endforeach; ?>
</div>