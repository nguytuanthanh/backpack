<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title()?></title>
  <link href="<?php bloginfo('template_directory'); ?>/images/favicon.png" rel="shortcut icon" type="image/x-icon" />
  <?php //require_once( dirname( __FILE__ ) . '/css/foundation.php' );?>
  <?php //require_once( dirname( __FILE__ ) . '/css/lineawesome.php' );?>
  <?php wp_head()?>
  <?php //require_once( dirname( __FILE__ ) . '/css/style.php' );?>

</head>
<body <?php body_class(); ?>>
<div class="off-canvas-wrapper">
  <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
    <div class="off-canvas position-left" id="offCanvas" data-off-canvas>
      <div class="menu-wrapper">
        <button class="close-button" aria-label="Close menu" type="button" data-close>
          <i class="la la-arrow-left"></i>
        </button>
        <div class="off-canvas-logo">
        	<?php 
        	global $redux_demo; 
        	$logo = $redux_demo['logo']['url'];
        	?>
        	<a href="<?php bloginfo('url') ?>/"><img src="<?=$logo?>" alt="Logo"></a>
        </div> 
        <nav class="mobile-menu">
        	<?php
            if (has_nav_menu ( 'header-menu' )) {
              $main_menu_args = array (
                'container' => '',
                'menu_class' => 'vertical menu',
                'items_wrap'      => '<ul id="%1$s" class="%2$s" data-accordion-menu>%3$s</ul>',
                'fallback_cb' => 'm_topbar_menu_fallback',
                'walker' => new M_Walker_Nav_Menus(),
                'theme_location' => 'header-menu' 
              );
              wp_nav_menu ( $main_menu_args);
            }
            ?>
            <?php wp_reset_postdata(); ?>
        </nav>
        <div class="off-canvas-social">
        	<div class="oc-social-inner">
        		<a href=""><i class="la la-facebook"></i></a>
				<a href=""><i class="la la-youtube-play"></i></a>
				<a href=""><i class="la la-google-plus"></i></a>
        	</div>
        </div>
        <div class="menu-footer">
          <p></p>      
        </div>
      </div>
    </div>
    <div class="off-canvas-content" data-off-canvas-content>
	    <header id="header">
	    	<div class="row">
	    		<div class="column">
		    		<div class="header_top">
              <button class="menu-icon" type="button" data-open="offCanvas"></button>
		            <div class="logo">
                  <?php 
                  global $redux_demo; 
                  $logo = $redux_demo['logo']['url'];
                  ?>
		            	<a href="<?php bloginfo('url') ?>/"><img src="http://elessi.nasatheme.com/wp-content/uploads/2017/11/logo.png" alt="Logo"></a>
		            </div> 
				        <div class="header-right">
			            <a data-toggle="search" class="right-icon"><i class="la la-search"></i></a>
			          	<?php get_template_part('inc/mini-cart-box'); ?>
		            	<?php get_template_part('inc/search-form'); ?>
			          </div>
			        </div>
              <div id="menu">
                <nav class="primary-menu" id="wrapper-menu-top">
                  <?php
                  if (has_nav_menu ( 'header-menu' )) {
                    $main_menu_args = array (
                      'menu' => 'nav',
                      'container' => '',
                      'menu_class' => 'dropdown menu',
                      'items_wrap'      => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>',
                      'fallback_cb' => 'header_menu_fallback',
                      'walker' => new ND_Walker_Nav_Menus(),
                      'theme_location' => 'header-menu' 
                    );
                    wp_nav_menu ( $main_menu_args);
                  }
                  ?>
                  <?php wp_reset_postdata(); ?>
                </nav>
              </div>
				</div>
			</div>
	    </header>