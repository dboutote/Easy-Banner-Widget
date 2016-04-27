<?php
/**
 * Widget Form
 *
 * Builds out the html for the widget settings form.
 *
 * @uses Easy_Banner_Widget_Fields::build_field_{name-of-field}() to generate the individual form fields.
 * @uses Easy_Banner_Widget_Fields::load_fieldset() to output the actual fieldsets.
 *
 * @package Easy_Banner_Widget
 *
 * @since 1.0
 */
?>
<div class="easy-banner-widget-form">

<div class="widgin-widget-form">

	<div class="widgin-section">

		<fieldset data-fieldset-id="general" class="widgin-settings widgin-fieldset settings-general">

			<legend class="screen-reader-text"><span><?php _e('General Settings') ?></span></legend>

			<?php
			$_general_fields =  array(
				'title'         => Easy_Banner_Widget_Fields::build_field_title( $instance, $this ),
				'banner_color'  => Easy_Banner_Widget_Fields::build_field_banner_color( $instance, $this ),
				'banner_text'   => Easy_Banner_Widget_Fields::build_field_banner_text( $instance, $this ),
				'text_color'    => Easy_Banner_Widget_Fields::build_field_text_color( $instance, $this ),
				'banner_linked' => Easy_Banner_Widget_Fields::build_field_banner_linked( $instance, $this ),
				'banner_url'    => Easy_Banner_Widget_Fields::build_field_banner_url( $instance, $this ),
			);
			$general_fields = apply_filters( 'ectabw_form_fields_general', $_general_fields, $instance, $this );

			Easy_Banner_Widget_Fields::load_fieldset( 'general', $general_fields, $instance, $this );
			?>

		</fieldset>

		<fieldset data-fieldset-id="layout" class="widgin-settings widgin-fieldset settings-layout">

			<legend class="screen-reader-text"><span><?php _e('Styles & Layout') ?></span></legend>

			<?php
			$_intro = __( 'Selecting the Default Styles option below will give you a quick start to styling your banner widget.  Additionally, the widget has a number of classes available to further customize its appearance to match your theme.' );
			$intro = apply_filters( 'ectabw_intro_text_layout', $_intro );
			?>

			<div class="description widgin-description">
				<?php echo wpautop( $intro ); ?>
			</div>

			<?php
			$_layout_fields =  array(
				'css_default' => Easy_Banner_Widget_Fields::build_field_css_default( $instance, $this ),
			);
			$layout_fields = apply_filters( 'ectabw_form_fields_layout', $_layout_fields, $instance, $this );

			Easy_Banner_Widget_Fields::load_fieldset( 'layout', $layout_fields, $instance, $this );
			?>
		</fieldset>

	</div><!-- /.widgin-section -->

</div>

</div>