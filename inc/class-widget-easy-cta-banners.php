<?php
/**
 * Widget_Easy_CTA_Banners Class
 *
 * Adds a Posts widget with extended functionality
 *
 * @package Easy_Banners_Widget
 * @subpackage Widget_Easy_CTA_Banners
 *
 * @since 1.0.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 * Core class used to implement a Posts widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Widget_Easy_CTA_Banners extends WP_Widget
{


	/**
	 * Sets up a new widget instance.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 */
	public function __construct()
	{
		$widget_options = array(
			'classname'                   => 'widget_easy_banners easy-banners-widget',
			'description'                 => __( 'A customizable call-to-action banner.' ),
			'customize_selective_refresh' => true,
			);

		$control_options = array();

		parent::__construct(
			'easy-banners-widget', // $this->id_base
			__( 'Easy Banners' ),  // $this->name
			$widget_options,       // $this->widget_options
			$control_options       // $this->control_options
		);

		$this->alt_option_name = 'widget_easy_banners';
	}


	/**
	 * Outputs the content for the current widget instance.
	 *
	 * Use 'widget_title' to filter the widget title.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current widget instance.
	 */
	public function widget( $args, $instance )
	{
		if ( ! isset( $args['widget_id'] ) ){
			$args['widget_id'] = $this->id;
		}

		$_defaults = Easy_Banners_Widget_Utils::instance_defaults();
		$instance = wp_parse_args( (array) $instance, $_defaults );

		// build out the instance for devs
		$instance['id_base']       = $this->id_base;
		$instance['widget_number'] = $this->number;
		$instance['widget_id']     = $this->id;

		// widget title
		$_title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$_title = apply_filters( 'ectabw_widget_title', $_title, $instance, $this->id_base );

		echo $args['before_widget'];

		if( $_title ) {
			echo $args['before_title'] . $_title . $args['after_title'];
		};

		do_action( 'ectabw_widget_title_after', $instance );

		/**
		 * Prints out the css url only if in Customizer
		 *
		 * Actual stylesheet is enqueued if the user selects to use default styles
		 *
		 * @since 1.0.0
		 */
		if( ! empty( $instance['css_default'] ) && is_customize_preview() ) {
			echo Easy_Banners_Widget_Utils::css_preview( $instance, $this );
		}
		?>

		<div class="easy-banners-widget easy-cta-banners-wrap">

			<?php

			do_action( 'ectabw_banner_before', $instance );

			Easy_Banners_Widget_Views::banner( $instance );

			do_action( 'ectabw_banner_after', $instance );

			?>

		</div><!-- /.easy-cta-banners-wrap -->

		<?php Easy_Banners_Widget_Views::colophon(); ?>

		<?php echo $args['after_widget']; ?>


	<?php
	}


	/**
	 * Handles updating settings for the current widget instance.
	 *
	 * Use 'ectabw_update_instance' to filter updating/sanitizing the widget instance.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance )
	{
		$instance = $old_instance;

		// general
		$instance['title']     = sanitize_text_field( $new_instance['title'] );
		
		// banner
		$instance['banner_color'] = '';
		if( isset( $new_instance['banner_color'] ) ) {
			$data = $new_instance['banner_color'];
			$instance['banner_color'] = preg_match( '/#([a-fA-F0-9]{3}){1,2}\b/', $data ) ? $data : '';
		}
		$instance['banner_text']   = wp_kses_post( $new_instance['banner_text'] );
		$instance['text_color'] = '';
		if( isset( $new_instance['text_color'] ) ) {
			$data = $new_instance['text_color'];
			$instance['text_color'] = preg_match( '/#([a-fA-F0-9]{3}){1,2}\b/', $data ) ? $data : '';
		}		
		
		$instance['banner_linked'] = isset( $new_instance['banner_linked'] ) ? 1 : 0 ;
		$instance['banner_url']    = isset( $new_instance['banner_url'] ) ? esc_url( $new_instance['banner_url'] ) : '' ;

		// styles & layout
		$instance['css_default'] = isset( $new_instance['css_default'] ) ? 1 : 0 ;

		// build out the instance for devs
		$instance['id_base']       = $this->id_base;
		$instance['widget_number'] = $this->number;
		$instance['widget_id']     = $this->id;

		$instance = apply_filters('ectabw_update_instance', $instance, $new_instance, $old_instance, $this );

		do_action( 'ectabw_update_widget', $this, $instance, $new_instance, $old_instance );

		return $instance;
	}


	/**
	 * Outputs the settings form for the Posts widget.
	 *
	 * Applies 'ectabw_form_defaults' filter on form fields to allow extension by plugins.
	 *
	 * @access public
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance )
	{
		$defaults = Easy_Banners_Widget_Utils::instance_defaults();

		$instance = wp_parse_args( (array) $instance, $defaults );

		include( Easy_Banners_Widget_Utils::get_plugin_sub_path('inc') . 'widget-form.php' );
	}

}