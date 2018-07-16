<div class="sub-head-message">
    <p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Cám ơn bạn đã mua hàng tại LITA.', 'woocommerce' ), $order ); ?></p>
    <p>
        <?php _e( 'Mã đơn hàng của bạn:', 'woocommerce' ); ?> <strong><?php echo '#'.$order->get_order_number(); ?></strong>
    </p>
</div>
<div class="order_details">
    <div class="clear"></div>
    <div class="customer_details">
        <div class="large-6 medium-6 small-12 columns">
            <h4 class="ty-title"><?php _e( 'Thông tin khách hàng', 'woocommerce' ); ?></h4>
            <ul>
                <?php 
                    $village = get_name_village($order->billing_address_2);
                    $district = get_name_district($order->billing_city);
                    $city = get_name_city($order->billing_state);
                    if ($order->billing_last_name ) echo '<li>' .$order->billing_last_name . '</li>';
                    if ( $order->billing_address_1 ) echo '<li>' .$order->billing_address_1.'&#44; '.$village.'&#44; '.$district.'&#44; '.$city.'</li>';
                    if ( $order->billing_email ) echo '<li>' .$order->billing_email . '</li>';
                    if ( $order->billing_phone ) echo '<li>' .$order->billing_phone . '</li>';
                    //do_action( 'woocommerce_order_details_after_customer_details', $order );
                ?>
            </ul>
        </div>
        <div class="large-6 medium-6 small-12 columns">
            <h4 class="ty-title"><?php _e( 'Chi tiết đơn hàng', 'woocommerce' ); ?></h4>
            <ul>
                <?php
                    echo '<li>Mã đơn hàng: <strong>'.$order->get_order_number(). '</strong></li>';
                    echo '<li>' .date("d/m/Y", strtotime( $order->order_date )). '</li>';
                    if ( $order->customer_message ) echo '<li>Ghi chú: <strong>'.$order->customer_message. '</strong></li>';
                ?>
            </ul>
        </div>
    </div>
    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <thead>
            <tr>
                <th class="product-thumbnail" style="width: 10%">&nbsp;</th>
                <th class="product-name"><?php _e( 'Sản phẩm', 'woocommerce' ); ?></th>
                <th class="product-subtotal"><?php _e( 'Tổng cộng', 'woocommerce' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ( sizeof( $order->get_items() ) > 0 ):
                foreach( $order->get_items() as $item ):
                    $_product     = apply_filters( 'woocommerce_order_item_product', $order->get_product_from_item( $item ), $item );
                    $item_meta    = new WC_Order_Item_Meta( $item['item_meta'], $_product );
           ?>
            <tr>
               <td class="product-thumbnail">
                <?php
                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                    if ( ! $product_permalink ) {
                        echo $thumbnail;
                    } else {
                        printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                    }
                ?>
                </td>
                <td class="product-name" data-title="">
                    <?php
                    if ( $_product && ! $_product->is_visible() )
                        echo apply_filters( 'woocommerce_order_item_name', $item['name'], $item );
                    else
                        echo apply_filters( 'woocommerce_order_item_name', sprintf( '<a href="%s"><strong>%s</strong></a>', get_permalink( $item['product_id'] ), $item['name'] ), $item );

                    echo apply_filters( 'woocommerce_order_item_quantity_html', sprintf( '&nbsp;&times; %s', $item['qty'] ), $item );

                    if ( $_product && $_product->exists() && $_product->is_downloadable() && $order->is_download_permitted() ) {

                        $download_files = $order->get_item_downloads( $item );
                        $i              = 0;
                        $links          = array();

                        foreach ( $download_files as $download_id => $file ) {
                            $i++;

                            $links[] = '<small><a href="' . esc_url( $file['download_url'] ) . '">' . sprintf( __( 'Download file%s', 'woocommerce' ), ( count( $download_files ) > 1 ? ' ' . $i . ': ' : ': ' ) ) . esc_html( $file['name'] ) . '</a></small>';
                        }

                        echo '<br/>' . implode( '<br/>', $links );
                    }
                    ?>
                </td>
                <td class="product-subtotal">
                    <?php echo $order->get_formatted_line_subtotal( $item ); ?>
                </td>
            </tr>
            <?php 
                 endforeach;
            endif;
                ?>
        </tbody>
        <tfoot>
            <tr class="shipping">
                <td></td>
                <td class="product-name">Phí vận chuyển</td>
                <td class="product-subtotal">
                    <span class="woocommerce-Price-amount amount"><?php echo  wc_price($order->get_total_shipping());?></span>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="ty-collaterals">
        <?="Tổng đơn hàng: ".$order->get_formatted_order_total(); ?>
    </div>
</div>
<aside class="gap"></aside>