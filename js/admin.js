/**
 * Plugin functions file.
 *
 */
if( "undefined" == typeof jQuery )throw new Error( "Easy Banners Widget's JavaScript requires jQuery" );

(function ( $ ) {

    'use strict';

	
	/**
	 * Add spectrum color picker to color fields
	 *
	 * @since 1.0.0
	 */
	function ectabw_init_spectrum( widget ) {
		widget.find( '.ectabw-color-picker' ).spectrum({
			preferredFormat: "hex",
			showInput: true,
		});
	}
	
	
	/**
	 * Invokes spectrum color picker when widget form is saved
	 *
	 * @since 1.0.0
	 */
	function ectabw_spectrum_form_update( event, widget ) {
		ectabw_init_spectrum( widget );
	}

	
	/**
	 * Updates banner preview
	 *
	 * @since 1.0.0
	 */
	function ectabw_preview_update( widget ) {
		var preview_div = widget.find( '.ectabw-banner-preview' );

		if( ! preview_div.length ) {
			return;
		}

		var banner_div = widget.find( '.easy-cta-banner' );
		var text_div = $('.easy-cta-banner-text', preview_div );

		var text_field = widget.find( '.ectabw-banner-text' );
		var banner_text = $.trim( text_field.val() );
			banner_text = banner_text.replace(/\n/g, "<br />");

		var bcolor_field = widget.find( '.ectabw-banner-color' );
		var bcolor = $.trim( bcolor_field.val() );

		var tcolor_field = widget.find( '.ectabw-text-color' );
		var tcolor = $.trim( tcolor_field.val() );

		if( '' == banner_text ) {
			preview_div.hide();
		} else {
			banner_div.css( { 'background-color' : bcolor } );
			text_div.css( { 'color' : tcolor } );
			text_div.html( banner_text );
			preview_div.show();
		}
	}
	
	
	/**
	 * Invokes banner preview when widget form is saved
	 *
	 * @since 1.0.0
	 */
	function ectabw_preview_form_update( event, widget ) {
		ectabw_preview_update( widget );
	}
	
	
	/**
	 * Color picker
	 *
	 * @since 1.0.0
	 */
	 
	// Init color picker when widget is added
	$( document ).on( 'widget-added widget-updated', ectabw_spectrum_form_update );

	// Init color picker when widget screen is loaded
	$( '#widgets-right .widget:has(.ectabw-color-picker)' ).each( function () {
		ectabw_init_spectrum( $( this ) );
	} );
	
	
	/**
	 * Banner preview
	 *
	 * @since 1.0.0
	 */
	 
	// Init banner preview when widget is added/updated
	$( document ).on( 'widget-added widget-updated', ectabw_preview_form_update );

	// Preview banner color/text when form color field changes
	$( '#customize-controls, #wpcontent' ).on( 'change', '.ectabw-banner-color', function ( e ) {
		var widget = $(this).closest('.widget');
		ectabw_preview_update( widget );
	});

	// Preview banner color/text when form text field changes
	$( '#customize-controls, #wpcontent' ).on( 'change', '.ectabw-text-color', function ( e ) {
		var widget = $(this).closest('.widget');
		ectabw_preview_update( widget );
	});

	// Preview banner color/text as user types
	$( '#customize-controls, #wpcontent' ).on( 'keyup', '.ectabw-banner-text', function ( e ) {
		var widget = $(this).closest('.widget');
		setTimeout( function(){
			ectabw_preview_update( widget );
		}, 300 );
		return;
	});

	// Init banner preview when widget screen is loaded
	$( '#widgets-right .widget:has(.ectabw-banner-preview)' ).each( function () {
		ectabw_preview_update( $( this ) );
	} );


}(jQuery) );