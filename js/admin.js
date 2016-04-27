/**
 * Plugin functions file.
 *
 */
if( "undefined"==typeof jQuery )throw new Error( "Easy Banners Widget's JavaScript requires jQuery" );

(function ( $ ) {

    'use strict';

	/**
	 * Add spectrum color picker to color fields
	 * 
	 * @since 1.0
	 */
	function ectabw_init_spectrum( widget ) {
		widget.find( '.ectabw-color-picker' ).spectrum({
			preferredFormat: "hex",
			showInput: true,
		});
	}

	function ectabw_spectrum_form_update( event, widget ) {
		ectabw_init_spectrum( widget );
	}

	$( document ).on( 'widget-added widget-updated', ectabw_spectrum_form_update );

	$( document ).ready( function() {
		$( '#widgets-right .widget:has(.ectabw-color-picker)' ).each( function () {
			ectabw_init_spectrum( $( this ) );
		} );
	} );
	
	

	
	/**
	 * Preview color choices
	 * 
	 * @since 1.0
	 */
	$( document ).on( 'widget-added widget-updated', ectabw_preview_form_update );
	
	function ectabw_preview_form_update( event, widget ) {
		ectabw_preview_update( widget );
	}
	
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
	
	$( document ).ready( function() {
	
		$( '#customize-controls, #wpcontent' ).on( 'change', '.ectabw-banner-color', function ( e ) {
			var widget = $(this).closest('.widget');
			ectabw_preview_update( widget );
		});
		
		$( '#customize-controls, #wpcontent' ).on( 'change', '.ectabw-text-color', function ( e ) {
			var widget = $(this).closest('.widget');
			ectabw_preview_update( widget );
		});	

		$( '#customize-controls, #wpcontent' ).on( 'keyup', '.ectabw-banner-text', function ( e ) {
			var widget = $(this).closest('.widget');
			setTimeout( function(){
				ectabw_preview_update( widget );
			}, 300 );
			return;
		});			
		
		$( '#widgets-right .widget:has(.ectabw-banner-preview)' ).each( function () {
			ectabw_preview_update( $( this ) );
		} );
	} );	

}(jQuery) );