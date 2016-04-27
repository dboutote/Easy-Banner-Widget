<?php

/**
 * Easy_Banner_Widget_Utils Class
 *
 * All methods are static, this is basically a namespacing class wrapper.
 *
 * @package Easy_Banner_Widget
 * @subpackage Easy_Banner_Widget_Utils
 *
 * @since 1.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 * Easy_Banner_Widget_Utils Class
 *
 * Group of utility methods for use by Easy_Banner_Widget
 *
 * @since 1.0
 */
class Easy_Banner_Widget_Utils
{

	/**
	 * Plugin root file
	 *
	 * @since 0.1.1
	 *
	 * @var string
	 */
	public static $base_file = EASY_BANNER_WIDGET_FILE;


	/**
	 * Generates path to plugin root
	 *
	 * @uses WordPress plugin_dir_path()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return string $path Path to plugin root.
	 */
	public static function get_plugin_path()
	{
		$path = plugin_dir_path( self::$base_file );
		return $path;
	}


	/**
	 * Generates path to subdirectory of plugin root
	 *
	 * @see Easy_Banner_Widget_Utils::get_plugin_path()
	 *
	 * @uses WordPress trailingslashit()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param string $directory The name of the requested subdirectory.
	 *
	 * @return string $sub_path Path to requested sub directory.
	 */
	public static function get_plugin_sub_path( $directory )
	{
		if( ! $directory ){
			return false;
		}

		$path = self::get_plugin_path();

		$sub_path = $path . trailingslashit( $directory );

		return $sub_path;
	}


	/**
	 * Generates url to plugin root
	 *
	 * @uses WordPress plugin_dir_url()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return string $url URL of plugin root.
	 */
	public static function get_plugin_url()
	{
		$url = plugin_dir_url( self::$base_file );
		return $url;
	}


	/**
	 * Generates url to subdirectory of plugin root
	 *
	 * @see Easy_Banner_Widget_Utils::get_plugin_url()
	 *
	 * @uses WordPress trailingslashit()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param string $directory The name of the requested subdirectory.
	 *
	 * @return string $sub_url URL of requested sub directory.
	 */
	public static function get_plugin_sub_url( $directory )
	{
		if( ! $directory ){
			return false;
		}

		$url = self::get_plugin_url();

		$sub_url = $url . trailingslashit( $directory );

		return $sub_url;
	}


	/**
	 * Generates basename to plugin root
	 *
	 * @uses WordPress plugin_basename()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return string $basename Filename of plugin root.
	 */
	public static function get_plugin_basename()
	{
		$basename = plugin_basename( self::$base_file );
		return $basename;
	}


	/**
	 * Sets default parameters
	 *
	 * Use 'ectabw_instance_defaults' filter to modify accepted defaults.
	 *
	 * @uses WordPress current_theme_supports()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return array $defaults The default values for the widget.
	 */
	public static function instance_defaults()
	{
		$_defaults = array(
			'title'         => __( 'Call to Action' ),
			'banner_color'  => '#000000',
			'banner_text'   => '',
			'text_color'    => '#ffffff',
			'banner_linked' => 0,
			'banner_url'    => '',
			'css_default'   => 0,
		);

		$defaults = apply_filters( 'ectabw_instance_defaults', $_defaults );

		return $defaults;
	}



	/**
	 * Adds a widget to the ectabw_use_css option
	 *
	 * If css_default option is selected in the widget, this will add a reference to that
	 * widget instance in the ectabw_use_css option.  The 'ectabw_use_css' option determines if the
	 * default stylesheet is enqueued on the front end.
	 *
	 * @uses WordPress get_option()
	 * @uses WordPress update_option()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param string $widget_id Widget instance ID.
	 */
	public static function stick_css( $widget_id )
	{
		$widgets = get_option( 'ectabw_use_css' );

		if ( ! is_array( $widgets ) ) {
			$widgets = array( $widget_id );
		}

		if ( ! in_array( $widget_id, $widgets ) ) {
			$widgets[] = $widget_id;
		}

		update_option('ectabw_use_css', $widgets);
	}


	/**
	 * Removes a widget from the ectabw_use_css option
	 *
	 * If css_default option is unselected in the widget, this will remove (if applicable) a
	 * reference to that widget instance in the ectabw_use_css option. The 'ectabw_use_css' option
	 * determines if the default stylesheet is enqueued on the front end.
	 *
	 * @uses WordPress get_option()
	 * @uses WordPress update_option()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param string $widget_id Widget instance ID.
	 */
	public static function unstick_css( $widget_id )
	{
		$widgets = get_option( 'ectabw_use_css' );

		if ( ! is_array( $widgets ) ) {
			return;
		}

		if ( ! in_array( $widget_id, $widgets ) ) {
			return;
		}

		$offset = array_search($widget_id, $widgets);

		if ( false === $offset ) {
			return;
		}

		array_splice( $widgets, $offset, 1 );

		update_option( 'ectabw_use_css', $widgets );
	}


	/**
	 * Prints link to default widget stylesheet
	 *
	 * Actual stylesheet is enqueued if the user selects to use default styles
	 *
	 * @see Widget_APW_Recent_Categories::widget()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Current widget settings.
	 * @param object $widget   Widget Object.
	 * @param bool   $echo     Flag to echo|return output.
	 *
	 * @return string $css_url Stylesheet link.
	 */
	public static function css_preview( $instance, $widget, $echo = true )
	{
		$_css_url =  self::get_plugin_sub_url('css') . 'front.css' ;

		$css_url = sprintf('<link rel="stylesheet" href="%s" type="text/css" media="all" />',
			esc_url( $_css_url )
		);

		if( $echo ) {
			echo $css_url;
		} else {
			return $css_url;
		}
	}


	/**
	 * Generates unique list-item id based on widget instance
	 *
	 * Use 'ectabw_item_id' filter to modify item ID before output.
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @param array  $instance Widget instance.
	 *
	 * @return string $item_id Filtered item ID.
	 */
	public static function get_item_id( $instance = array() )
	{

		$_item_id = $instance['widget_id'];

		$item_id = sanitize_html_class( $_item_id );

		return apply_filters( 'ectabw_item_id', $item_id, $instance );
	}


	/**
	 * Generate item classes
	 *
	 * Use 'ectabw_item_class' filter to modify item classes before output.
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @param array  $instance Widget instance.
	 *
	 * @return string $class_str CSS classes.
	 */
	public static function get_item_class( $instance = array() )
	{

		$_classes = array();
		$_classes[] = 'ectabw-item';
		$_classes[] = 'ectabw-banner';
		$_classes[] = 'easy-cta-banner';

		$classes = apply_filters( 'ectabw_item_class', $_classes, $instance );
		$classes = ( ! is_array( $classes ) ) ? (array) $classes : $classes ;
		$classes = array_map( 'sanitize_html_class', $classes );

		$class_str = implode( ' ', $classes );

		return $class_str;
	}
	
	
	/**
	 * Generates unique item style widget instance
	 *
	 * Use 'ectabw_item_style' filter to modify item ID before output.
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @param array  $instance Widget instance.
	 *
	 * @return string $item_id Filtered item ID.
	 */
	public static function get_item_style( $instance = array() )
	{
		$banner_color = ( ! empty( $instance['banner_color'] ) ) ?  esc_attr( $instance['banner_color'] ) : '#ff0000' ;

		$_style = ' style="background-color:' . $banner_color . ';"';

		return apply_filters( 'ectabw_item_style', $_style, $instance );
	}	
	
	
	

}