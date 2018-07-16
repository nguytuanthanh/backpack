<div class="mini-cart-box pull-right">
  <?php $items = WC()->cart->get_cart();
  global $woocommerce;
  $item_count = $woocommerce->cart->cart_contents_count; ?>
  <a class="mini-cart-link cart-totals" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>">
    <span class="mini-cart-icon"><i class="la la-shopping-cart"></i></span>
    <span class="show-for-large">Giỏ hàng </span><span class="count__number"><?php echo WC()->cart->get_cart_contents_count();?></span>
  </a>
  <div class="cart-dropdown">
    <div class="cart-dropdown-inner">
    </div>
  </div>
</div>