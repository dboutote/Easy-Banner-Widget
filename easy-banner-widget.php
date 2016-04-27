<?php
/**
 * Easy Banner Widget
 *
 * @package Easy_Banner_Widget
 *
 * @license     http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @version     1.0
 *
 * Plugin Name: Easy Banner Widget
 * Plugin URI:  http://darrinb.com/plugins/easy-banner-widget
 * Description: An easy-to-use, customizable, call-to-action banner widget.
 * Version:     1.0
 * Author:      Darrin Boutote
 * Author URI:  http://darrinb.com
 * Text Domain: easy-banner-widget
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


define( 'EASY_BANNER_WIDGET_FILE', __FILE__ );


/**
 * Instantiates the main Widget instance
 *
 * @since 1.0
 */
function _easy_banner_widget_init() {

	include dirname( __FILE__ ) . '/inc/class-easy-banner-widget-utils.php';
	include dirname( __FILE__ ) . '/inc/class-easy-banner-widget-fields.php';
	include dirname( __FILE__ ) . '/inc/class-widget-easy-cta-banner.php';
	include dirname( __FILE__ ) . '/inc/class-easy-banner-widget-views.php';
	include dirname( __FILE__ ) . '/inc/class-easy-banner-widget-init.php';
	
	$Easy_Banner_Widget_Init = new Easy_Banner_Widget_Init( __FILE__ );
	$Easy_Banner_Widget_Init->init();

}
add_action( 'plugins_loaded', '_easy_banner_widget_init', 99 );