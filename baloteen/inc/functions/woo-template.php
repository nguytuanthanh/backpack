<?php

add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
  add_theme_support( 'post-thumbnails' );
  add_image_size( 'index-size', 270, 405, array('class' => 'lazy')  ); // (cropped)
  add_image_size( 'index-size-acc', 270, 270, array('class' => 'lazy')  );
  add_image_size( 'zoom', 75, 93 , array('class' => 'lazy') );
}
/*
global $_wp_additional_image_sizes;
foreach ( $_wp_additional_image_sizes as $name => $image_size ){
    update_option( $name."_size_w", $image_size['width'] );
    update_option( $name."_size_h", $image_size['height'] );
    update_option( $name."_crop", $image_size['crop'] );
}
 
add_filter( 'intermediate_image_sizes', 'regenerate_custom_image_sizes' );
function regenerate_custom_image_sizes( $sizes ){
    global $_wp_additional_image_sizes;
    foreach ( $_wp_additional_image_sizes as $name => $size ){
        $sizes[] = $name;
    }
    return $sizes;
}
*/

add_filter( 'post_thumbnail_html', 'remove_thumbnail_width_height', 10, 5 );
function remove_thumbnail_width_height( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_place_order_button_text' );
function woo_custom_place_order_button_text(){
    return __( 'Thêm vào giỏ hàng', 'woocommerce' );
}

add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' ); 
function woo_custom_order_button_text() {
    return __( 'Thanh toán', 'woocommerce' ); 
}

add_filter( 'woocommerce_checkout_fields' , 'woo_custom_order_checkout_fields' );
function woo_custom_order_checkout_fields( $fields ) {
     $fields['order']['order_comments']['label'] = 'Ghi chú';
     $fields['order']['order_comments']['placeholder'] = 'Thêm thông tin chi tiết hơn.';
     return $fields;
}

function get_color(){
  $attributes =$product->get_attributes();
  foreach ( $attributes as $attribute ) : 
    $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'ids' ) );
    foreach ($values as $val) {
      $att = get_term_meta($val, $attribute['name'].'_yith_wccl_value');
      echo '<span class="related-color" style="background:'.$att[0].'"></span>';
    }
  endforeach;
}

function wsis_wpseo_breadcrumb_output( $output ){

    if( is_product() ){

        $from = '<a href="'.site_url().'/shop/" rel="v:url">Products</a> /';   

        $to     = '';

        $output = str_replace( $from, $to, $output );

    }

    return $output;
}
add_filter( 'wpseo_breadcrumb_output', 'wsis_wpseo_breadcrumb_output' );

/*add_filter( 'woocommerce_cart_shipping_method_full_label', 'bbloomer_remove_shipping_label', 10, 2 );
function bbloomer_remove_shipping_label($label, $method) {
$new_label = preg_replace( '/^.+:/', '', $label );
return $new_label;
}*/

add_action( 'template_redirect', 'wc_custom_redirect_after_purchase' );
function wc_custom_redirect_after_purchase() {
    global $wp;
    if ( is_checkout() && ! empty( $wp->query_vars['order-received'] ) ) {
        $page_slug = 'hoan-tat-don-hang';
        $page = get_page_by_path($page_slug);
        $page_id = $page->ID;
        //$ty_id = 52;
        $order_id  = absint( $wp->query_vars['order-received'] );
        $order_key = wc_clean( $_GET['key'] );
        $redirect  = get_permalink($page_id);
        $redirect .= get_option( 'permalink_structure' ) === '' ? '&' : '?';
        $redirect .= 'order=' . $order_id . '&key=' . $order_key;
        wp_redirect( $redirect );
        exit;
    }
}

// Số sản phẩm trên 1 trang
add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );
function new_loop_shop_per_page( $cols ) {
  $cols = 20;
  return $cols;
}

add_filter( 'the_content', 'wc_custom_thankyou' );
function wc_custom_thankyou( $content ) {
  $page_slug = 'hoan-tat-don-hang';
  $page = get_page_by_path($page_slug);
  $page_id = $page->ID;
  if ( ! is_page($page_id) ) {
    return $content;
  }
  // check if the order ID exists
  if ( ! isset( $_GET['order'] ) ) {
    return $content;
  }

  // intval() ensures that we use an integer value for the order ID
  $order = wc_get_order( intval( $_GET['order'] ) );

  ob_start();

  // Check that the order is valid
  if ( ! $order ) {
    // The order can't be returned by WooCommerce - Just say thank you
    ?><p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p><?php
  } else {
    if ( $order->has_status( 'failed' ) ) {
      // Order failed - Print error messages and ask to pay again
      /**
       * @hooked wc_custom_thankyou_failed - 10
       */
      do_action( 'wc_custom_thankyou_failed', $order );
    } else {
      // The order is successfull - print the complete order review
      /**
       * @hooked wc_custom_thankyou_header - 10
       * @hooked wc_custom_thankyou_table - 20
       * @hooked wc_custom_thankyou_customer_details - 30
       */
      do_action( 'wc_custom_thankyou_successful', $order );
    }
  }
  $content .= ob_get_contents();
  ob_end_clean();
  return $content;
}

add_action( 'wc_custom_thankyou_failed', 'wc_custom_thankyou_failed', 10 );
function wc_custom_thankyou_failed( $order ) {
  wc_get_template( 'custom-thankyou/failed.php', array( 'order' => $order ) );
}

add_action( 'wc_custom_thankyou_successful', 'wc_custom_thankyou_header', 10 );
function wc_custom_thankyou_header( $order ) {
  wc_get_template( 'custom-thankyou/header.php',           array( 'order' => $order ) );
}

function sb_admin_style_and_script() {
    wp_enqueue_script('sb-admin', get_template_directory_uri().'/js/functions.js', array('jquery'), false, true);
    wp_localize_script('sb-admin', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php'), 'noposts' => __('No older posts found', 'twentyfifteen'),));
}
add_action('init', 'sb_admin_style_and_script');

function more_post_ajax(){
    $ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 8;
    $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
    header("Content-Type: text/html");
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $ppp,
        'tax_query'     => array(
          'meta_query'  => array(
             'relation'   => 'AND',
            array(
              'key'   => '_stock_status',
              'value'   => 'outofstock',
              'compare' => 'NOT IN',
            )
          )
        ),
        'paged'    => $page,
    );

    $loop = new WP_Query($args);
    if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();
      global $product;
      $width = 270;
          $height = 320;
          $url = get_featured_img( $product->ID );
          $crop = true;
          $img = theme_thumb($url, $width, $height, $crop);
          $terms = get_the_terms( $post->ID, 'product_cat' );
          $cat_name = $terms[0]->name;
          $cat_link = esc_url( get_category_link( $terms[0]->term_id ) );
          $price = $product->get_price();
          if($product->is_on_sale() && $product->get_regular_price()) :
          $price = wc_price($product->get_sale_price());
        else:
          $price = wc_price($product->get_regular_price());
        endif;
      $out .= '
      <article class="column column-block item">
          <div class="item-thumb">
          <a href="'.get_the_permalink().'">
            <img class="lazy" src="data:image/gif;base64,R0lGODlhAQABAPAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-original="'.$img.'" alt="'.get_the_title().'">
          </a>
        </div>
        <div class="item-meta">
          <div class="item-cat">
            <a href="'.$cat_link.'">'.$cat_name.'</a>
          </div>
        </div>
        <div class="item-text">
          <header>
            <h3 class="item-title">
              <a href="'.get_the_permalink().'">'.get_the_title().'</a>
            </h3>
            <span class="item-price">
              <span>'.$price.'</span>
            </span>
          </header>
        </div>
      </article>
      ';
    endwhile;
    else:
      $out .= 'No post';
    endif;
    wp_reset_postdata();
    die($out);
}
add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
add_action('wp_ajax_more_post_ajax', 'more_post_ajax');

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
 /*
function my_header_add_to_cart_fragment( $fragments ) {

    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?>
    <a class="mini-cart-link cart-totals" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>">
      <span class="mini-cart-icon"><i class="la la-shopping-cart"></i></span>
      <span class="show-for-large">Giỏ hàng</span> <span class="count__number"><?php echo '('.WC()->cart->get_cart_contents_count().')';?></span>
    </a>

        <?php
 
    $fragments['a.cart-totals'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );*/

add_filter('wpseo_breadcrumb_single_link' ,'timersys_remove_companies', 10 ,2);
function timersys_remove_companies($link_output, $link ){
 
    if( $link['text'] == 'Products' ) {
        $link_output = '';
    }
    return $link_output;
}

/* Fix 404 after Remove Category */
add_filter('request', function( $vars ) {
  global $wpdb;
  if( ! empty( $vars['pagename'] ) || ! empty( $vars['category_name'] ) || ! empty( $vars['name'] ) || ! empty( $vars['attachment'] ) ) {
    $slug = ! empty( $vars['pagename'] ) ? $vars['pagename'] : ( ! empty( $vars['name'] ) ? $vars['name'] : ( !empty( $vars['category_name'] ) ? $vars['category_name'] : $vars['attachment'] ) );
    $exists = $wpdb->get_var( $wpdb->prepare( "SELECT t.term_id FROM $wpdb->terms t LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id WHERE tt.taxonomy = 'product_cat' AND t.slug = %s" ,array( $slug )));
    if( $exists ){
      $old_vars = $vars;
      $vars = array('product_cat' => $slug );
      if ( !empty( $old_vars['paged'] ) || !empty( $old_vars['page'] ) )
        $vars['paged'] = ! empty( $old_vars['paged'] ) ? $old_vars['paged'] : $old_vars['page'];
      if ( !empty( $old_vars['orderby'] ) )
              $vars['orderby'] = $old_vars['orderby'];
            if ( !empty( $old_vars['order'] ) )
              $vars['order'] = $old_vars['order'];  
    }
  }
  return $vars;
});

/* Remove shop/product in urls */
function devvn_remove_slug( $post_link, $post ) {
    if ( !in_array( get_post_type($post), array( 'product' ) ) || 'publish' != $post->post_status ) {
        return $post_link;
    }
    if('product' == $post->post_type){
        $post_link = str_replace( '/shop/', '/', $post_link ); 
    }else{
        $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    }
    return $post_link;
}
add_filter( 'post_type_link', 'devvn_remove_slug', 10, 2 );

/*Fix 404 after Remove*/
function fix_woo_product_rewrite_rules($flash = false) {
    global $wp_post_types, $wpdb;
    $siteLink = esc_url(home_url('/'));
    foreach ($wp_post_types as $type=>$custom_post) {
        if($type == 'product'){
            if ($custom_post->_builtin == false) {
                $querystr = "SELECT {$wpdb->posts}.post_name, {$wpdb->posts}.ID
                            FROM {$wpdb->posts} 
                            WHERE {$wpdb->posts}.post_status = 'publish' 
                            AND {$wpdb->posts}.post_type = '{$type}'";
                $posts = $wpdb->get_results($querystr, OBJECT);
                foreach ($posts as $post) {
                    $current_slug = get_permalink($post->ID);
                    $base_product = str_replace($siteLink,'',$current_slug);
                    add_rewrite_rule($base_product.'?$', "index.php?{$custom_post->query_var}={$post->post_name}", 'top');
                }
            }
        }
    }
    if ($flash == true)
        flush_rewrite_rules(false);
}
add_action('init', 'fix_woo_product_rewrite_rules');
/* Fix 404 when create a new product after Remove */
function fix_woo_new_product_add($post_id){
    global $wp_post_types;
    $post_type = get_post_type($post_id);
    foreach ($wp_post_types as $type=>$custom_post) {
        if ($custom_post->_builtin == false && $type == $post_type) {
            fix_woo_product_rewrite_rules(true);
        }
    }
}
add_action('wp_insert_post', 'fix_woo_new_product_add');


add_filter ('add_to_cart_redirect', 'redirect_to_checkout');
function redirect_to_checkout() {
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    return $checkout_url;
}

function ntt_shop_scripts() {
  if (is_singular('product')) {
    wp_enqueue_script( 'ntt_shop-single', get_template_directory_uri() . '/js/ntt_shop-single.js', array('jquery'), '1.0.0', true );
    wp_localize_script( 'ntt_shop-single', 'ntt_shop_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
  }elseif(is_product_category()){
     wp_enqueue_script( 'ntt_shop-category', get_template_directory_uri() . '/js/ntt_shop-category.js', array('jquery'), '1.0.0', true );
    wp_localize_script( 'ntt_shop-category', 'ntt_shop_ajax_category', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
  }
}
add_action( 'wp_enqueue_scripts', 'ntt_shop_scripts' );

function add_cart_ajax() {
  $product_id = $_POST['product_id'];
  $variation_id = $_POST['variation_id'];
  $quantity = $_POST['quantity'];
  $variation  = $_POST['variation'];
  $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
  
  //if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation  ) ) {

  if ($variation_id) {
   WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation) ;
  } else {
    WC()->cart->add_to_cart( $product_id, $quantity);
  }

  $items = WC()->cart->get_cart();
  global $woocommerce;
  $item_count = $woocommerce->cart->cart_contents_count; ?>
  <span class="item-count"><?php echo $item_count; ?></span>

  <div class="dropdown-cart-wrap dropdown-cart-subtotal">
    <div>
      <p>Có <strong><?php echo $item_count; ?></strong> sản phẩm trong giỏ hàng</p>
      <p>
        <strong>Tạm tính: </strong><span><?php echo WC()->cart->get_cart_total(); ?></span>
      </p>
      
    </div>
    <div class="clear"></div>
  </div>

  <?php $cart_url = $woocommerce->cart->get_cart_url();
  $checkout_url = $woocommerce->cart->get_checkout_url(); ?>

  <div class="dropdown-cart-wrap dropdown-cart-links">
    <div class="dropdown-cart-link">
      <a class="dropdown-view-cart" href="<?php echo $cart_url; ?>">Xem giỏ hàng</a>
      <a class="dropdown-check-out" href="<?php echo $checkout_url; ?>">Thanh toán</a>
    </div>
    <div class="clear"></div>
  </div>

  <?php die();
}

add_action('wp_ajax_add_cart_ajax', 'add_cart_ajax');
add_action('wp_ajax_nopriv_add_cart_ajax', 'add_cart_ajax');

function category_ajax() {
  
  $price = $_POST['price'];
  $category_id = $_POST['cat_id'];
  switch($price){
    case('lvl_price1'):
      $ranges = 500000;
      $method = '<';
      break;
    case('lvl_price2'):
      $ranges = array(500000,1000000);
      $method = 'BETWEEN';
      break;
    case('lvl_price3'):
      $ranges = array(1000000,3000000);
      $method = 'BETWEEN';
      break;
    case('lvl_price4'):
      $ranges = array(3000000,5000000);
      $method = 'BETWEEN';
      break;
    case('lvl_price5'):
      $ranges = 5000000;
      $method = '>';
      break;
    default:
      $ranges = 0;
      $method = '>';
      break;
  }

  $colors = $_POST['color'];  
  $colors = implode(",",$colors);

  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
  $args = array(
        'posts_per_page'=> 10,
        'post_type' => 'product',
              'tax_query'     => array(
                'relation'    => 'AND',
                
                array(
                  'taxonomy'      => 'product_cat',
                  'field' => 'term_id',
                  'terms'         => $category_id,
                  'operator'      => 'IN' 
                ),
                array(
                  'taxonomy'     => 'pa_mau-sac',
                  'field'     => 'slug', 
                  'terms'     => $colors,
                  'operator' => 'OR',
                ),
              ),
              'meta_query'  => array(
                'relation'    => 'AND',
                array(
                  'key'   => '_stock_status',
                  'value'   => 'outofstock',
                  'compare' => 'NOT IN',
                ),
                array(
                  'key' => '_price',
                  'value' => $ranges,
                  'compare' => $method,
                  'type' => 'NUMERIC'
                )
              )
    );
    $cate = new WP_Query($args);
    global $wp_query;
    if( $cate->have_posts() ) : ;
      echo '<div class="row small-up-1 medium-up-4 large-up-4">';
      while( $cate->have_posts() ) : $cate->the_post();

  global $product;
    ?>
    <div class="column column-block">
      <div class="item-box">
        <div class="item-thumb">
          <a href="<?php the_permalink()?>">
            <?=get_the_post_thumbnail(  $product->ID, 'medium');?>
          </a>
        </div>                    
        <article class="item-text">
          <h3 class="item-title">
            <a href="<?php the_permalink()?>"><?php the_title()?></a>
          </h3>
          <span class="item-price">
              <span class="price"><?php echo $product->get_price_html(); ?></span>
          </span>
        </article>
        <?php if($product->is_on_sale() && $product->get_regular_price()):?>
          <span class="percent-down">
            <?='-'. round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 ).'%';?>
          </span>
        <?php endif;?>
      </div>
    </div>
    <?php endwhile;
    echo '</div>';
    else:
      echo '<div class="column"><p>Sản phẩm đang được cập nhật.</p></div>';
    endif;
    wp_reset_query();
    die();
    
}

add_action('wp_ajax_category_ajax', 'category_ajax');
add_action('wp_ajax_nopriv_category_ajax', 'category_ajax');

function my_hide_shipping_when_free_is_available( $rates ) {
  $free = array();
  foreach ( $rates as $rate_id => $rate ) {
    if ( 'free_shipping' === $rate->method_id ) {
      $free[ $rate_id ] = $rate;
      break;
    }
  }
  return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );

add_filter( 'woocommerce_variable_sale_price_html', 'wpglorify_variation_price_format', 10, 2 );
add_filter( 'woocommerce_variable_price_html', 'wpglorify_variation_price_format', 10, 2 );
 
function wpglorify_variation_price_format( $price, $product ) {
 
// Main Price
$prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
$price = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
// Sale Price
$prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
sort( $prices );
$saleprice = $prices[0] !== $prices[1] ? sprintf( __( '%1$s', 'woocommerce' ), wc_price( $prices[0] ) ) : wc_price( $prices[0] );
 
if ( $price !== $saleprice ) {
$price = '<del>' . $saleprice . $product->get_price_suffix() . '</del> <ins>' . $price . $product->get_price_suffix() . '</ins>';
}
return $price;
}
if ( ! function_exists( 'storefront_comment' ) ) {
  function storefront_comment( $comment, $args, $depth ) {
    if ( 'div' == $args['style'] ) {
      $tag = 'div';
      $add_below = 'comment';
    } else {
      $tag = 'li';
      $add_below = 'div-comment';
    }
    ?>
    <<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <div class="comment-body">
    <div class="comment-meta commentmetadata">
      <div class="comment-author vcard">
      <?php echo get_avatar( $comment, 128 ); ?>
      <?php printf( wp_kses_post( '<cite class="fn">%s</cite>', 'storefront' ), get_comment_author_link() ); ?>
      </div>
      <?php if ( '0' == $comment->comment_approved ) : ?>
        <em class="comment-awaiting-moderation"><?php esc_attr_e( 'Your comment is awaiting moderation.', 'storefront' ); ?></em>
        <br />
      <?php endif; ?>

      <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>" class="comment-date">
        <?php echo '<time datetime="' . get_comment_date( 'c' ) . '">' . get_comment_date() . '</time>'; ?>
      </a>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-content">
    <?php endif; ?>
    <div class="comment-text">
    <?php comment_text(); ?>
    </div>
    <div class="reply">
    <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    <?php edit_comment_link( __( 'Edit', 'storefront' ), '  ', '' ); ?>
    </div>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
  <?php
  }
}
/*
function woocommerce_new_products() {
  global $woocommerce;

}

function rc_woocommerce_recently_viewed_products( $atts, $content = null ) {

  // Get shortcode parameters
  extract(shortcode_atts(array(
    "per_page" => '5'
  ), $atts));

  // Get WooCommerce Global
  global $woocommerce;

  // Get recently viewed product cookies data
  $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
  $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );
  var_dump($viewed_products);

  // If no data, quit
  if ( empty( $viewed_products ) )
    return __( 'You have not viewed any product yet!', 'rc_wc_rvp' );

  // Create the object
  ob_start();

  // Get products per page
  if( !isset( $per_page ) ? $number = 5 : $number = $per_page )

  // Create query arguments array
    $query_args = array(
            'posts_per_page' => $number, 
            'no_found_rows'  => 1, 
            'post_status'    => 'publish', 
            'post_type'      => 'product', 
            'post__in'       => $viewed_products, 
            'orderby'        => 'rand'
            );

  // Add meta_query to query args
  $query_args['meta_query'] = array();

    // Check products stock status
    $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();

  // Create a new query
  $r = new WP_Query($query_args);

  // If query return results
  if ( $r->have_posts() ) {

    $content = '<ul class="rc_wc_rvp_product_list_widget">';

    // Start the loop
    while ( $r->have_posts()) {
      $r->the_post();
      global $product;

      $content .= '<li>
        <a href="' . get_permalink() . '">
          ' . ( has_post_thumbnail() ? get_the_post_thumbnail( $r->post->ID, 'shop_thumbnail' ) : woocommerce_placeholder_img( 'shop_thumbnail' ) ) . ' ' . get_the_title() . '
        </a> ' . $product->get_price_html() . '
      </li>';
    }

    $content .= '</ul>';

  }

  // Get clean object
  $content .= ob_get_clean();
  
  // Return whole content
  return $content;
}
*/

//Bỏ cột ship trang giỏ hàng
function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        return false;
    }
    return $show_shipping;
}
add_filter( 'woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99 );

// Đổi text giá ship checkout
add_filter( 'woocommerce_shipping_package_name', 'custom_shipping_package_name' );
function custom_shipping_package_name( $name ) {
  return 'Phí giao hàng';
}

add_filter( 'woocommerce_get_availability', 'wcs_custom_get_availability', 1, 2);
function wcs_custom_get_availability( $availability, $_product ) {
        // Change Out of Stock Text
    if ( ! $_product->is_in_stock() ) {
        $availability['availability'] = __('Tạm hết hàng', 'woocommerce');
    }
    return $availability;
}

add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_styles_scripts', 99 );

function dequeue_woocommerce_styles_scripts() {
    if ( function_exists( 'is_woocommerce' ) ) {
        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
            # Styles
            wp_dequeue_style( 'woocommerce-general' );
            wp_dequeue_style( 'woocommerce-layout' );
            wp_dequeue_style( 'woocommerce-smallscreen' );
            wp_dequeue_style( 'woocommerce_frontend_styles' );
            wp_dequeue_style( 'woocommerce_fancybox_styles' );
            wp_dequeue_style( 'woocommerce_chosen_styles' );
            wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
            # Scripts
            wp_dequeue_script( 'wc_price_slider' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-add-to-cart' );
            wp_dequeue_script( 'wc-cart-fragments' );
            wp_dequeue_script( 'wc-checkout' );
            wp_dequeue_script( 'wc-add-to-cart-variation' );
            wp_dequeue_script( 'wc-single-product' );
            wp_dequeue_script( 'wc-cart' );
            wp_dequeue_script( 'wc-chosen' );
            wp_dequeue_script( 'woocommerce' );
            wp_dequeue_script( 'prettyPhoto' );
            wp_dequeue_script( 'prettyPhoto-init' );
            wp_dequeue_script( 'jquery-blockui' );
            wp_dequeue_script( 'jquery-placeholder' );
            wp_dequeue_script( 'fancybox' );
            wp_dequeue_script( 'jqueryui' );
            wp_dequeue_script( 'cookie' );
        }
    }
}

function get_name_city($id = ''){
  global $tinh_thanhpho;
  if(!is_array($tinh_thanhpho) || empty($tinh_thanhpho)){
    include NTT_THEME_DIR.'inc/cities/tinh_thanhpho.php';
  }
  $id_tinh = sprintf("%02d", intval($id));    
  $tinh_thanhpho = (isset($tinh_thanhpho[$id_tinh]))?$tinh_thanhpho[$id_tinh]:'';
  return $tinh_thanhpho;
}

function get_name_district($id = ''){
  global $quan_huyen;
  include NTT_THEME_DIR.'inc/cities/quan_huyen.php';
  $id_quan = sprintf("%03d", intval($id));
  if(is_array($quan_huyen) && !empty($quan_huyen)){
    $found_key = array_search($id_quan, array_column($quan_huyen, 'maqh'));
  }
  $name = $quan_huyen[$found_key]['name'];
  return $name;
}

function get_name_village($id = ''){
  global $xa_phuong_thitran;
  include NTT_THEME_DIR.'inc/cities/xa_phuong_thitran.php';
  $id_xa = sprintf("%05d", intval($id));
  if(is_array($xa_phuong_thitran) && !empty($xa_phuong_thitran)){
    $found_key = array_search($id_xa, array_column($xa_phuong_thitran, 'xaid'));
  }
  $name = $xa_phuong_thitran[$found_key]['name'];
  return $name;
}

add_theme_support( 'woocommerce' ); 