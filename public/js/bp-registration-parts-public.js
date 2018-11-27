(function( $ ) {
	'use strict';
	$( document ).ready(function() {

		/**
		 * Unsets the form action in case the previous button is clicked on the last registration step
		 */
		$("#profile-group-edit-prev").click(function() {
			$( '#profile-edit-form' ).attr('action', '');
		});
		
		if ( $('#profile-edit-form').length && $('.page-breadcrumbs').length) {
			$('.page-breadcrumbs').hide();
		}
	});

})( jQuery );
