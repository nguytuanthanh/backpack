<?php
if ( ! function_exists('theme_enqueue') ) {
  function theme_enqueue() {

    // Enqueue style
    wp_enqueue_style( 'foundation', get_stylesheet_directory_uri() . '/css/foundation.min.css', array(), '' );
    wp_enqueue_style( 'line-awesome', get_stylesheet_directory_uri() . '/css/line-awesome.min.css', array(), '' );
    wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/css/slick.css', array(), '' );
    wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css', array(), '' );

    // Enqueue script
    wp_deregister_script('jquery');  
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/vendor/jquery.js', array(), '', true );
    wp_enqueue_script( 'foundation', get_template_directory_uri() . '/js/vendor/foundation.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'actual', get_template_directory_uri() . '/js/vendor/jquery.actual.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'lazyload', get_template_directory_uri() . '/js/vendor/lazyload.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'functions', get_template_directory_uri() . '/js/vendor/functions.js', array( 'jquery' ), '', true );
    wp_enqueue_script(array('jquery','foundation','actual', 'lazyload','functions'));

    if(is_singular('product') || is_single() || is_page('tin-tuc')){
      wp_enqueue_script( 'sticky', get_template_directory_uri() . '/js/vendor/sticky.kit.min.js', array( 'jquery' ), '', true );
      wp_enqueue_script(array('sticky'));
    }
    if(is_singular('product')){
      wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/vendor/slick.min.js', array( 'jquery' ), '', true );
      wp_enqueue_script( 'elevatezoom', get_template_directory_uri() . '/js/vendor/jquery.elevatezoom.min.js', array( 'jquery' ), '', true );
      wp_enqueue_script( 'product', get_template_directory_uri() . '/js/vendor/product.js', array( 'jquery' ), '', true );
      wp_enqueue_script(array('slick','elevatezoom','product'));
    }
    if(is_front_page() || is_home()){
      wp_enqueue_script( 'slick', get_template_directory_uri() . '/js/vendor/slick.min.js', array( 'jquery' ), '', true );
      wp_enqueue_script( 'home_slide', get_template_directory_uri() . '/js/vendor/home.js', array( 'jquery' ), '', true );
      wp_enqueue_script(array('slick','home_slide'));
    }
  }
}
add_action('wp_enqueue_scripts','theme_enqueue');

function theme_thumb($url, $width, $height=0, $crop) {
  $detect = new Mobile_Detect();
  $mobile = $detect->isMobile();
  $iphone = $detect->version('iPhone');
  $ipad = $detect->version('iPad');
  if($mobile && ($iphone || $ipad )){
    $retina= true;
  }else{
    $retina= false;
  }
  return mr_image_resize($url, $width, $height, true, $align, $retina);
}
add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );


function short_content($content, $chars_limit){
  $chars_text = strlen($content);
    $content = strip_tags($content);
    $content = strip_shortcodes($content);
    $content = $content." ";
    $content = substr($content,0,$chars_limit);
    $content = substr($content,0,strrpos($content,' '));
    if ($chars_text > $chars_limit)
      { $content = $content."..."; } // Ellipsis
    return $content;
}

add_theme_support( 'post-thumbnails' );
function get_featured_img($post_id){
  $error_img = get_stylesheet_directory_uri().'/images/noimage.png';
  $images = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail' );
  if ($images) {
      return $images[0];
  }else{
      return $error_img;
  }
}

function __search_by_title_only( $search, $wp_query ){ 
  global $wpdb;
  if ( empty( $search ) ) return $search; 
  $q = $wp_query->query_vars; 
  $n = ! empty( $q['exact'] ) ? '' : '%';
    $search = $searchand = ''; 
  foreach ( (array) $q['search_terms'] as $term ){ 
    $term = esc_sql( like_escape( $term ) ); 
    $search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
    $searchand = ' AND ';
  } 
  if ( ! empty( $search ) ) {
     $search = " AND ({$search}) ";
    if ( ! is_user_logged_in() ) $search .= " AND ($wpdb->posts.post_password = '') "; 
    } 
    return $search; 
} 
add_filter( 'posts_search', '__search_by_title_only', 500, 2 );

if(!is_admin()):
function nqd_search_filter($query) {
    if ($query->is_search) {
        $query->set('post_type','product');
        $query->set('posts_per_page',20);
    }
    return $query;
}
add_action('pre_get_posts','nqd_search_filter');
endif;


function vkstw_title_search_result($s){ 
    /* Search Count */
    $allsearch = new WP_Query("s=".$s."&showposts=-1");
    $key = wp_specialchars($s, 1);
    $count = $allsearch->post_count; _e('');
    _e('Tìm được ');
    echo $count; 
    _e(' bài viết với từ khóa: <strong>');
    echo $key; 
    _e('</strong>');
    wp_reset_query();
}

function pagination($pages = '', $range = 3){ 
    $showitems = ($range * 2)+1; 

    global $paged;
    if(empty($paged)) $paged = 1;

    if($pages == '')
    {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
    }  

    if(1 != $pages)
    {
         echo "<ul class=\"pagination\">";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li class=\"pagination-previous\"><a href=".get_pagenum_link(1).">&laquo;</a></li>";
         //if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Trang trước đó</a></li>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li class=\"active\"><a href='".get_pagenum_link($i)."'>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
             }
         }

         //if ($paged < $pages && $showitems < $pages) echo "<li><a href=\"".get_pagenum_link($paged + 1)."\">Trang tiếp theo &rsaquo;</a></li>"; 
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li class=\"pagination-next\"><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
         echo "</ul>\n";
    }
}


add_filter ('wpseo_breadcrumb_output','mc_microdata_breadcrumb');
function mc_microdata_breadcrumb ($link_output)
{
    $link_output = preg_replace(array('#<span xmlns:v="http://rdf.data-vocabulary.org/\#">#','#<span typeof="v:Breadcrumb"><a href="(.*?)" .*?'.'>(.*?)</a></span>#','#<span typeof="v:Breadcrumb">(.*?)</span>#','# property=".*?"#','#</span>$#'), array('','<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="$1" itemprop="url"><span itemprop="title">$2</span></a></span>','<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><span itemprop="title">$1</span></span>','',''), $link_output);
    return $link_output;
}

add_action('pre_get_posts', 'wpse74620_ignore_sticky');
function wpse74620_ignore_sticky($query)
{
  $query->set('ignore_sticky_posts', true);
}

/*function add_image_responsive_class($content) {
   global $post;
   $pattern ="/<img(.*?)class=\"(.*?)\"(.*?)>/i";
   $replacement = '<img$1class="lazy $2"$3>';
   $content = preg_replace($pattern, $replacement, $content);
   return $content;
}
add_filter('the_content', 'add_image_responsive_class');*/

function _remove_script_version( $src ){
$parts = explode( '?ver', $src );
return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

add_filter( 'amp_post_template_metadata', 'amp_modify_json_metadata', 10, 2 ); // Adding custom metadata
function amp_modify_json_metadata( $metadata, $post ) {

   if( 'post'=== $post->post_type  ){

    $metadata['@type'] = 'Article';

   $metadata['publisher']['name'] = ' TORBEN RICK ';

    $metadata['publisher']['logo'] = array(
        '@type' => 'ImageObject',
        'url' => get_stylesheet_directory_uri().'/imgs/logo.png',
        'height' => 60,
        'width' => 100,
    );

   return $metadata; 

  } 
}
add_filter( 'amp_post_template_metadata', 'override_schema_metadata', 10, 2 );
function override_schema_metadata( $metadata, $post ) {
  $metadata['image']['width'] = ($metadata['image']['width'] * 1.2);
  $metadata['image']['height'] = ($metadata['image']['height'] * 1.2);
  return $metadata;
}

function human_time_diff_vn( $from, $to = '' ) {
  if ( empty( $to ) ) {
    $to = time();
  }

  $diff = (int) abs( $to - $from );

  if ( $diff < HOUR_IN_SECONDS ) {
    $mins = round( $diff / MINUTE_IN_SECONDS );
    if ( $mins <= 1 )
        $mins = 1;
    /* translators: min=minute */
    $since = sprintf( _n( '%s phút', '%s phút', $mins ), $mins );
  } elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
      $hours = round( $diff / HOUR_IN_SECONDS );
      if ( $hours <= 1 )
          $hours = 1;
      $since = sprintf( _n( '%s giờ', '%s giờ', $hours ), $hours );
  } elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
      $days = round( $diff / DAY_IN_SECONDS );
      if ( $days <= 1 )
          $days = 1;
      $since = sprintf( _n( '%s ngày', '%s ngày', $days ), $days );
  } elseif ( $diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
      $weeks = round( $diff / WEEK_IN_SECONDS );
      if ( $weeks <= 1 )
          $weeks = 1;
      $since = sprintf( _n( '%s tuần', '%s tuần', $weeks ), $weeks );
  } elseif ( $diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS ) {
      $months = round( $diff / MONTH_IN_SECONDS );
      if ( $months <= 1 )
          $months = 1;
      $since = sprintf( _n( '%s tháng', '%s tháng', $months ), $months );
  } elseif ( $diff >= YEAR_IN_SECONDS ) {
      $years = round( $diff / YEAR_IN_SECONDS );
      if ( $years <= 1 )
          $years = 1;
      $since = sprintf( _n( '%s năm', '%s năm', $years ), $years );
  }
  $since = preg_split("/\s+/", $since);
  $since[0] = "<span class=\"timeCircle\">" . $since[0] . "</span>";
  $since = join(" ", $since).' trước';
  return apply_filters( 'human_time_diff_vn', $since, $diff, $from, $to );
}

add_filter( 'rwmb_meta_boxes', 'your_prefix_meta_boxes' );
function your_prefix_meta_boxes( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'      => __( 'Chi tiết', 'textdomain' ),
        'post_types' => 'post',
        'fields'     => array(
            array(
              'id'   => 'stick',
              'name' => __( 'Tiêu điểm', 'textdomain' ),
              'type' => 'checkbox',
            ),
            array(
                'id'   => 'intro',
                'name' => __( 'Giới thiệu', 'textdomain' ),
                'type' => 'textarea',
            ),
            array(
                'id'   => 'related_id',
                'name' => __( 'Bài liên quan', 'textdomain' ),
                'type' => 'text',
            ),
        ),
    );
    return $meta_boxes;
}