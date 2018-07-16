<?php 
function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'mobile-menu' => __( 'Mobile Menu' ),
      'magazine-menu' => __( 'Magazine Menu' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

class ND_Walker_Nav_Menus extends Walker_Nav_Menu{
  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"menu\">\n";
  }
  public function end_lvl( &$output, $depth = 0, $args = array() ) {
      $indent = str_repeat("\t", $depth);
      $output .= "$indent</ul>\n";
  }

   function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
       $item_html = '';
       parent::start_el($item_html, $item, $depth, $args);

       if ( $item->is_dropdown && $depth === 0 ) {
           $item_html = str_replace( '<a', '<a class="dropdown-toggle" data-toggle="dropdown"', $item_html );
           $item_html = str_replace( '</a>', ' <b class="caret"></b></a>', $item_html );
       }

       $output .= $item_html;
    }

}
class Magazine_Walker_Nav_Menus extends Walker_Nav_Menu{
  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"menu vertical\">\n";
  }
  public function end_lvl( &$output, $depth = 0, $args = array() ) {
      $indent = str_repeat("\t", $depth);
      $output .= "$indent</ul>\n";
  }

   /*function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
       $item_html = '';
       parent::start_el($item_html, $item, $depth, $args);

       if ( $item->is_dropdown && $depth === 0 ) {
           $item_html = str_replace( '<a', '<a class="dropdown-toggle" data-toggle="dropdown"', $item_html );
           $item_html = str_replace( '</a>', ' <b class="caret"></b></a>', $item_html );
       }

       $output .= $item_html;
    }*/

}
class M_Walker_Nav_Menus extends Walker_Nav_Menu{
  public function start_lvl( &$output, $depth = 0, $args = array() ) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"menu vertical nested\">\n";
  }
  public function end_lvl( &$output, $depth = 0, $args = array() ) {
      $indent = str_repeat("\t", $depth);
      $output .= "$indent</ul>\n";
  }
}

function m_topbar_menu_fallback($args)
{
    $walker_page = new Walker_Page();
    $fallback = $walker_page->walk(get_pages(), 0);
    echo '<ul class="vertical menu" data-accordion-menu>'.$fallback.'</ul>';
}

function header_menu_fallback($args)
{
    $walker_page = new Walker_Page();
    $fallback = $walker_page->walk(get_pages(), 0);
    $fallback = str_replace("<ul class='children'>", '<ul class="children submenu menu vertical" data-submenu>', $fallback);
    
    echo '<ul class="dropdown menu" data-dropdown-menu>'.$fallback.'</ul>';
}
function mag_menu_fallback($args)
{
    $walker_page = new Walker_Page();
    $fallback = $walker_page->walk(get_pages(), 0);
    $fallback = str_replace("<ul class='vertical menu'>", '<ul class="dropdown menu">', $fallback);
    
    echo '<ul class="dropdown menu">'.$fallback.'</ul>';
}

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class ($classes, $item) {
    $obj = array('current-menu-item','current-menu-parent','current-category-ancestor','current-post-ancestor','current-page-ancestor'); 
     if(count(array_intersect($obj, $classes)) > 0){
       $classes[] = 'active ';
     }
    return $classes;
}