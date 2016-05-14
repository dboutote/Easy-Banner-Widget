<?php
/**
 * Easy Banners Widget Uninstall actions
 *
 * Removes all options set by the plugin.
 *
 * @package Easy_Banners_Widget
 * @subpackage Admin
 *
 * @since 1.0
 */


if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// remove our options
delete_option( 'ectabw_use_css' );