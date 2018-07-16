<?php 
define ( 'NTT_PLUGIN_URI', trailingslashit (  get_template_directory_uri() ) );
define ( 'NTT_THEME_DIR', trailingslashit (  get_template_directory() ) );
define ( 'NTT_FUNCTION_DIR', trailingslashit ( NTT_THEME_DIR.  'inc') ); 
include_once(NTT_FUNCTION_DIR .'resizer.php'); 
require_once(NTT_FUNCTION_DIR . 'Mobile_Detect.php');
// if( !class_exists( 'ReduxFramework' ) ) {
// require_once( dirname( __FILE__ ) . '/framework/framework.php' );
// }
// if( !isset( $redux_demo ) ) {
// require_once( dirname( __FILE__ ) . '/framework/sample-config.php');
// }

// function load_admin_style() {
// 	if(is_admin()):
// 		wp_register_style( 'custom_css', dirname( __FILE__ ) .  '/framework/css/custom-redux.css', false, '1.0.0' );
// 		wp_enqueue_style( 'custom_css', dirname( __FILE__ ) . '/framework/css/custom-redux.css', false, '1.0.0' );
// 	endif;
// }
require NTT_THEME_DIR.'inc/functions/woo-template.php';
require NTT_THEME_DIR.'inc/functions/menu.php';
require NTT_THEME_DIR.'inc/functions/template.php';
require NTT_THEME_DIR . 'inc/functions/shortcode.php';