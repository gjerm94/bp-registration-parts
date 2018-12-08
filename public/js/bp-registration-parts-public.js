(function( $ ) {
	'use strict';
	$( document ).ready(function() {

		/**
		 * Unsets the form action in case the previous button is clicked on the last registration step
		 */
		$("#profile-group-edit-prev").click(function() {
			$( '#profile-edit-form' ).attr('action', '');
		});

		$('#profile-group-edit-submit').click(function(e) {
			window.onbeforeunload = null;
		});
		
		/**
		 * Filler value for required profile fields so registration doesn't break
		 */
		if ($('#profile-details-section input').length) {
			$('#profile-details-section input').val("e");
		}
	});

	
	$(window).load(function() {
		bp.Avatar.Attachment.on( 'change:url', function( data ) {
			$( "#profile-group-edit-submit" ).trigger( "click" );	
		} );


		});	
		
	
		
})( jQuery );
