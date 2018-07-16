<!--<div class="order_details">
<ul>
    <li class="order">
        <?php _e( 'Mã số đơn hàng:', 'woocommerce' ); ?>
        <strong><?php echo $order->get_order_number(); ?></strong>
    </li>
    <li class="date">
        <?php _e( 'Ngày đặt hàng:', 'woocommerce' ); ?>
        <strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
    </li>
    
    <li class="total">
        <?php _e( 'Tổng tiền:', 'woocommerce' ); ?>
        <strong><?php echo $order->get_formatted_order_total(); ?></strong>
    </li>
    
    <?php if ( $order->payment_method_title ) : ?>
    <li class="method">
        <?php _e( 'Phương thức thanh toán:', 'woocommerce' ); ?>
        <strong><?php echo $order->payment_method_title; ?></strong>
    </li>
    <?php endif; ?>
    
</ul>
</div>
<div class="clear"></div>-->