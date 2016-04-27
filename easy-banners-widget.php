<?php
/**
 * Easy Banners Widget
 *
 * @package Easy_Banners_Widget
 *
 * @license     http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @version     1.0
 *
 * Plugin Name: Easy Banners Widget
 * Plugin URI:  http://darrinb.com/plugins/easy-banners-widget
 * Description: Easily build call-to-action banners in your sidebars.
 * Version:     1.0
 * Author:      Darrin Boutote
 * Author URI:  http://darrinb.com
 * Text Domain: easy-banners-widget
 * Domain Path: /lang
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


define( 'EASY_BANNERS_WIDGET_FILE', __FILE__ );


/**
 * Instantiates the main Widget instance
 *
 * @since 1.0
 */
function _easy_banners_widget_init() {

	include dirname( __FILE__ ) . '/inc/class-easy-banners-widget-utils.php';
	include dirname( __FILE__ ) . '/inc/class-easy-banners-widget-fields.php';
	include dirname( __FILE__ ) . '/inc/class-widget-easy-cta-banners.php';
	include dirname( __FILE__ ) . '/inc/class-easy-banners-widget-views.php';
	include dirname( __FILE__ ) . '/inc/class-easy-banners-widget-init.php';
	
	$Easy_Banners_Widget_Init = new Easy_Banners_Widget_Init( __FILE__ );
	$Easy_Banners_Widget_Init->init();

}
add_action( 'plugins_loaded', '_easy_banners_widget_init', 99 );