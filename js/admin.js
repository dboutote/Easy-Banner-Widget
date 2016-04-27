/**
 * Plugin functions file.
 *
 */
if( "undefined"==typeof jQuery )throw new Error( "Easy Banners Widget's JavaScript requires jQuery" );

(function ( $ ) {

    'use strict';

	function ectabwSpectrum( widget ) {
		widget.find( '.ectabw-color-picker' ).spectrum({
			preferredFormat: "hex",
			showInput: true,
		});
	}

	function ectabwFormUpdate( event, widget ) {
		ectabwSpectrum( widget );
	}

	$( document ).on( 'widget-added widget-updated', ectabwFormUpdate );

	$( document ).ready( function() {
		$( '#widgets-right .widget:has(.ectabw-color-picker)' ).each( function () {
			ectabwSpectrum( $( this ) );
		} );
	} );

}(jQuery) );