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

		var avatarUploaded = false;
		$(document).on('click', '.avatar-crop-submit', function () {
			avatarUploaded = true;
		});

		/**
		 * Alert user if they have not saved a profile picture
		 */
		if ($('.bp-avatar').length) {
			$("#profile-edit-form").on("submit", function(){
				if(!avatarUploaded) {
					if (confirm('Du har ikke lagret eller lastet opp et profilbilde. Husk å trykke på "Lagre bilde" etter du har lastet opp bildet ditt. Er du sikker på at du vil fortsette?')) {
						return true;
					} else {
						return false;
					}
				}
				return true;
			});
		}
	});

	
	$(window).load(function() {
		// bp.Avatar.Attachment.on( 'change:url', function( data ) {
		// 	$( "#profile-group-edit-submit" ).trigger( "click" );	
		// } );


		});	
		
	
		
})( jQuery );
