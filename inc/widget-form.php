<?php
/**
 * Widget Form
 *
 * Builds out the html for the widget settings form.
 *
 * @uses Easy_Banners_Widget_Fields::build_field_{name-of-field}() to generate the individual form fields.
 * @uses Easy_Banners_Widget_Fields::load_fieldset() to output the actual fieldsets.
 *
 * @package Easy_Banners_Widget
 *
 * @since 1.0.0
 */

// No direct access
if( ! defined( 'ABSPATH' ) ){
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
?>
<div class="easy-banners-widget-form">

	<div class="widgin-widget-form">

		<div class="widgin-section">

			<fieldset data-fieldset-id="general" class="widgin-settings widgin-fieldset settings-general">

				<legend class="screen-reader-text"><span><?php _e( 'General Settings', 'easy-banners-widget' ) ?></span></legend>

				<?php
				$_general_fields =  array(
					'title'         => Easy_Banners_Widget_Fields::build_field_title( $instance, $this ),
					'banner_color'  => Easy_Banners_Widget_Fields::build_field_banner_color( $instance, $this ),
					'banner_text'   => Easy_Banners_Widget_Fields::build_field_banner_text( $instance, $this ),
					'text_color'    => Easy_Banners_Widget_Fields::build_field_text_color( $instance, $this ),
					'banner_linked' => Easy_Banners_Widget_Fields::build_field_banner_linked( $instance, $this ),
					'banner_url'    => Easy_Banners_Widget_Fields::build_field_banner_url( $instance, $this ),
				);
				$general_fields = apply_filters( 'ectabw_form_fields_general', $_general_fields, $instance, $this );

				Easy_Banners_Widget_Fields::load_fieldset( 'general', $general_fields, $instance, $this );
				?>
				
				<?php  if( ! is_customize_preview() ) : ?>
				
					<div class="ectabw-banner-preview">
					
						<h5><?php _e( 'Preview:', 'easy-banners-widget' );?></h5>
						
						<div class="easy-cta-banner">
							<div class="easy-cta-banner-inside">
								<div class="easy-cta-banner-text"></div>
							</div>
						</div>
						
					</div>	
					
				<?php endif; ?>			

			</fieldset>

			<fieldset data-fieldset-id="layout" class="widgin-settings widgin-fieldset settings-layout">

				<legend class="screen-reader-text"><span><?php _e( 'Styles & Layout', 'easy-banners-widget' ) ?></span></legend>

				<?php
				$_intro = __( 'Selecting the Default Styles option below will give you a quick start to styling your banner.  Additionally, the widget has a number of classes available to further customize its appearance to match your theme.' );
				$intro = apply_filters( 'ectabw_intro_text_layout', $_intro );
				?>

				<div class="description widgin-description">
					<?php echo wpautop( $intro ); ?>
				</div>

				<?php
				$_layout_fields =  array(
					'css_default' => Easy_Banners_Widget_Fields::build_field_css_default( $instance, $this ),
				);
				$layout_fields = apply_filters( 'ectabw_form_fields_layout', $_layout_fields, $instance, $this );

				Easy_Banners_Widget_Fields::load_fieldset( 'layout', $layout_fields, $instance, $this );
				?>
			</fieldset>

		</div><!-- /.widgin-section -->

	</div>

</div>