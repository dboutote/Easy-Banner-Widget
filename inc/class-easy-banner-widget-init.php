<?php

/**
 * Easy_Banner_Widget_Init Class
 *
 * Initializes the plugin
 *
 * @package Easy_Banner_Widget
 *
 * @since 1.0
 *
 */

// No direct access
if( ! defined( 'ABSPATH' ) ){
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


class Easy_Banner_Widget_Init
{

	/**
	 * Full file path to plugin file
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	protected $file = '';


	/**
	 * URL to plugin
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	protected $url = '';


	/**
	 * Filesystem directory path to plugin
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	protected $path = '';


	/**
	 * Base name for plugin
	 *
	 * e.g. "easy-banner-widget/easy-banner-widget.php"
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	protected $basename = '';


	/**
	 * Constructor
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param string $file Full file path to calling plugin file
	 */
	public function __construct( $file )
	{
		$this->file	    = $file;
		$this->url	    = plugin_dir_url( $this->file );
		$this->path	    = plugin_dir_path( $this->file );
		$this->basename = plugin_basename( $this->file );
	}


	/**
	 * Loads the class
	 *
	 * @see Easy_Banner_Widget_Init::init_widget()
	 * @see Easy_Banner_Widget_Init::init_admin_scripts_and_styles()
	 * @see Easy_Banner_Widget_Init::store_css_option()
	 * @see Easy_Banner_Widget_Init::init_css_option()
	 *
	 * @access public
	 *
	 * @since 1.0
	 */
	public function init()
	{
		$this->init_widget();
		$this->init_admin_scripts_and_styles();
		$this->store_css_option();
		$this->init_css_option();
	}


	/**
	 * Loads the Comment Widget
	 *
	 * @see Easy_Banner_Widget_Init::register_widget()
	 *
	 * @access public
	 *
	 * @since 1.0
	 */
	public function init_widget()
	{
		add_action( 'widgets_init', array( $this, 'register_widget' ) );
	}


	/**
	 * Registers the Comment Widget
	 *
	 * @uses WordPress register_widget()
	 *
	 * @access public
	 *
	 * @since 1.0
	 */
	public function register_widget()
	{
		register_widget( 'Widget_Easy_CTA_Banner' );
	}


	/**
	 * Loads js/css admin scripts
	 *
	 * @see Easy_Banner_Widget_Init::admin_scripts()
	 * @see Easy_Banner_Widget_Init::admin_styles()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function init_admin_scripts_and_styles()
	{
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'admin_scripts' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'front_styles' ) );
	}


	/**
	 * Loads js admin scripts
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function admin_scripts( $hook )
	{
		global $pagenow;

		$enqueue = false;

		if( 'customize.php' == $pagenow || 'widgets.php' == $pagenow || 'widgets.php' == $hook ){
			$enqueue = true;
		};

		if( ! $enqueue ){
			return;
		};
		
		wp_register_script(
			'ectabw-spectrum',
			$this->url . 'js/spectrum.js',
			array(
				'jquery',
				),
			'',
			true
		);

		wp_enqueue_script(
			'ectabw-admin-scripts',
			$this->url . 'js/admin.js',
			array(
				'ectabw-spectrum'
				),
			'',
			true
		);
	}


	/**
	 * Prints out css styles in admin head
	 *
	 * Note: Only loads on customize.php or widgets.php
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function admin_styles()
	{
	
		wp_register_style(
			'ectabw-spectrum',
			$this->url . 'css/spectrum.css',
			array(),
			null
		);
		
		wp_enqueue_style(
			'ectabw-admin-styles',
			$this->url . 'css/admin.css',
			array(
				'ectabw-spectrum',
				),
			null
		);
	}


	/**
	 * Registers if a widget instance is using the default CSS
	 *
	 * @see Easy_Banner_Widget_Init::maybe_store_css()
	 *
	 * @access public
	 *
	 * @since 1.0
	 */
	public function store_css_option()
	{
		add_action( 'ectabw_update_widget', array( $this, 'maybe_store_css' ), 0, 4 );
		add_action( 'customize_save_widget_easy-banner-widget', array( $this, 'maybe_store_css' ), 0, 1 );
	}


	/**
	 * Stores if a widget instance is using the default CSS
	 *
	 * Note: update_option() (called by ::stick_css()) chokes the Customizer on widget->update(),
	 *       therefore, we have to update the option when the Customizer calls its save hook for this
	 *       widget: 'customize_save_widget_easy-banner-widget'
	 *
	 * @uses Easy_Banner_Widget_Utils::stick_css()
	 * @uses Easy_Banner_Widget_Utils::unstick_css()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param object $widget Widget|WP_Customize_Setting instance; depends on calling filter.
	 * @param array $instance Current widget settings pre-save
	 * @param array $new_instance New settings for instance input by the user via WP_Widget::form().
	 * @param array $old_instance Old settings for instance.
	 */
	public function maybe_store_css( $widget, $instance = array(), $new_instance = array(), $old_instance = array() )
	{
		$current_filter = current_filter();

		// The Customizer doesn't pass an $instance array like widgets.php does
		if( 'customize_save_widget_easy-banner-widget' === $current_filter ){
			$instance = $widget->post_value();
		}

		// see if any widget instance IDs are stored
		$widgets = get_option( 'ectabw_use_css' );

		// If no other widget instances are stored, and they didn't choose the default css, return
		if( ! $widgets &&  empty ( $instance['css_default'] ) ){
			return;
		}

		// update_option() (called by ::stick_css()) chokes the Customizer on widget update
		if( 'ectabw_update_widget' === $current_filter && is_customize_preview() ){
			return;
		}

		// if there's no widget instance
		if( empty( $instance['widget_id'] ) ){
			return;
		}

		// get the widget instance ID
		$widget_id = $instance['widget_id'];

		// if they've selected this widget instance to use default css, add it
		if( ! empty ( $instance['css_default'] ) ) {
			Easy_Banner_Widget_Utils::stick_css( $widget_id );
		} else {
			Easy_Banner_Widget_Utils::unstick_css( $widget_id );
		}
	}


	/**
	 * Calls to enqueue front end styles
	 *
	 * @see Easy_Banner_Widget_Init::enqueue_front_styles()
	 *
	 * @access public
	 *
	 * @since 1.0
	 */
	public function init_css_option()
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'front_styles' ) );
	}


	/**
	 * Prints out css styles in the front end
	 *
	 * Note: Only loads if widget instance calls default css option
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function front_styles()
	{
		$enqueue = false;
		$widgets = get_option( 'ectabw_use_css' );

		if ( ! is_array( $widgets ) ) {
			return;
		}

		foreach( $widgets as $widget_id ) {
			if( is_active_widget( '', $widget_id, 'easy-banner-widget', true ) ) {
				$enqueue = true;
			}
		}

		if( $enqueue ) {
			wp_enqueue_style( 'ectabw-css-defaults', $this->url . 'css/front.css', null, null );
		}

	}

}