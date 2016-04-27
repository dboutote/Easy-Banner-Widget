<?php

/**
* Easy_Banner_Widget_Fields Class
*
* Handles generation of widget form fields.
* All methods are static, this is basically a namespacing class wrapper.
*
* @package Easy_Banner_Widget
* @subpackage Easy_Banner_Widget_Fields
*
* @since 1.0
*/

class Easy_Banner_Widget_Fields
{

	public function __construct(){}


	/**
	 * Loads fields for a specific fieldset for widget form
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param string $fieldset Name (slug) of fieldset.
	 * @param array  $fields   Fields to load.
	 * @param array  $instance Current settings.
	 * @param object $widget   Widget object.
	 */
	public static function load_fieldset( $fieldset = 'general', $fields, $instance, $widget )
	{
		if( ! is_array( $fields ) ) {
			return;
		}

		$keys        = array_keys( $fields );
		$first_field = reset( $keys );
		$last_field  = end( $keys );

		ob_start();

		foreach ( $fields as $name => $field ) {

			if ( $first_field === $name ) {
				do_action( "ectabw_form_before_fields_{$fieldset}", $instance, $widget );
			}

			do_action( "ectabw_form_before_field_{$name}", $instance, $widget );

			// output the actual field
			echo apply_filters( "ectabw_form_field_{$name}", $field, $instance, $widget ) . "\n";

			do_action( "ectabw_form_after_field_{$name}", $instance, $widget );

			if ( $last_field === $name ) {
				do_action( "ectabw_form_after_fields_{$fieldset}", $instance, $widget );
			}

		}

		$fieldset = ob_get_clean();

		echo $fieldset;
	}



	/**
	 * Builds form field: title
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Current settings.
	 * @param object $widget   Widget object.
	 */
	public static function build_field_title( $instance, $widget )
	{
		ob_start();
		?>

		<p>
			<label for="<?php echo $widget->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'easy-banner-widget' ); ?></label>
			<input class="widefat" id="<?php echo $widget->get_field_id( 'title' ); ?>" name="<?php echo $widget->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<?php
		$field = ob_get_clean();

		return $field;
	}
	
	
	
	/**
	 * Builds form field: banner_color
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Current settings.
	 * @param object $widget   Widget object.
	 */
	public static function build_field_banner_color( $instance, $widget )
	{
		ob_start();
		?>

		<p>
			<label for="<?php echo $widget->get_field_id( 'banner_color' ); ?>"><?php _e( 'Banner Color:', 'easy-banner-widget' ); ?></label><br />
			<input class="widefat ectabw-color-picker" id="<?php echo $widget->get_field_id( 'banner_color' ); ?>" name="<?php echo $widget->get_field_name( 'banner_color' ); ?>" type="text" value="<?php echo esc_attr( $instance['banner_color'] ); ?>" />
		</p>

		<?php
		$field = ob_get_clean();

		return $field;
	}


	/**
	 * Builds form field: banner_text
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Current settings.
	 * @param object $widget   Widget object.
	 */
	public static function build_field_banner_text( $instance, $widget )
	{
		ob_start();
		?>

		<p>
			<label for="<?php echo $widget->get_field_id( 'banner_text' ); ?>"><?php _e( 'Banner Text:', 'easy-banner-widget' ); ?></label><br />
			<textarea class="widefat" rows="5" cols="20" id="<?php echo $widget->get_field_id('banner_text'); ?>" name="<?php echo $widget->get_field_name('banner_text'); ?>"><?php echo esc_textarea( $instance['banner_text'] ); ?></textarea>
		</p>

		<?php
		$field = ob_get_clean();

		return $field;
	}
	
	
	/**
	 * Builds form field: text_color
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Current settings.
	 * @param object $widget   Widget object.
	 */
	public static function build_field_text_color( $instance, $widget )
	{
		ob_start();
		?>

		<p>
			<label for="<?php echo $widget->get_field_id( 'text_color' ); ?>"><?php _e( 'Text Color:', 'easy-banner-widget' ); ?></label><br />
			<input class="widefat ectabw-color-picker" id="<?php echo $widget->get_field_id( 'text_color' ); ?>" name="<?php echo $widget->get_field_name( 'text_color' ); ?>" type="color" value="<?php echo esc_attr( $instance['text_color'] ); ?>" />
		</p>

		<?php
		$field = ob_get_clean();

		return $field;
	}



	/**
	 * Builds form field: banner_linked
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Current settings.
	 * @param object $widget   Widget object.
	 */
	public static function build_field_banner_linked( $instance, $widget )
	{
		ob_start();
		?>

		<p>
			<input id="<?php echo $widget->get_field_id( 'banner_linked' ); ?>" name="<?php echo $widget->get_field_name( 'banner_linked' ); ?>" type="checkbox" <?php checked( $instance['banner_linked'], 1 ); ?> />
			<label for="<?php echo $widget->get_field_id( 'banner_linked' ); ?>">
				<?php _e( 'Link Banner?', 'easy-banner-widget' ); ?>
			</label>
		</p>

		<?php
		$field = ob_get_clean();

		return $field;
	}


	/**
	 * Builds form field: banner_url
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Current settings.
	 * @param object $widget   Widget object.
	 */
	public static function build_field_banner_url( $instance, $widget )
	{
		ob_start();
		?>

		<p>
			<label for="<?php echo $widget->get_field_id( 'banner_url' ); ?>"><?php _e( 'Banner URL:', 'easy-banner-widget' ); ?></label>
			<input class="widefat" id="<?php echo $widget->get_field_id( 'banner_url' ); ?>" name="<?php echo $widget->get_field_name( 'banner_url' ); ?>" type="text" value="<?php echo esc_attr( $instance['banner_url'] ); ?>" />
		</p>

		<?php
		$field = ob_get_clean();

		return $field;
	}


	/**
	 * Builds form field: css_default
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Current settings.
	 * @param object $widget   Widget object.
	 */
	public static function build_field_css_default( $instance, $widget )
	{
		ob_start();
		?>

		<p>
			<input id="<?php echo $widget->get_field_id( 'css_default' ); ?>" name="<?php echo $widget->get_field_name( 'css_default' ); ?>" type="checkbox" <?php checked( $instance['css_default'], 1 ); ?> />
			<label for="<?php echo $widget->get_field_id( 'css_default' ); ?>">
				<?php _e( 'Use Default Styles?', 'easy-banner-widget' ); ?>
			</label>
		</p>

		<?php
		$field = ob_get_clean();

		return $field;
	}

}
