(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			zzzRemoveExpiredStorage.init();
		}
	);

	var zzzRemoveExpiredStorage = {
		init: function () {
			var currentDate = new Date();

			var expirationTime = 3600000;
			var sessionObject  = sessionStorage.getItem( 'zzzTokenObject' );
			var localObject    = localStorage.getItem( 'zzzTokenObject' );

			if ( null !== sessionObject || null !== localObject ) {
				var sessionObjectParsed   = JSON.parse( sessionStorage.getItem( 'zzzTokenObject' ) );
				var localObjectParsed     = JSON.parse( localStorage.getItem( 'zzzTokenObject' ) );
				var sessionExpirationDate = sessionObjectParsed.expiresAt;
				var localExpirationDate   = localObjectParsed.expiresAt;

				if ( Date.parse( currentDate ) > Date.parse( sessionExpirationDate ) + expirationTime ) {
					sessionStorage.removeItem( 'zzzTokenObject' );
					console.log( 'sessionObject expired' );
				}

				if ( Date.parse( currentDate ) > Date.parse( localExpirationDate ) + expirationTime ) {
					localStorage.removeItem( 'zzzTokenObject' );
					console.log( 'localObject expired' );
				}
			}
		}
	};

})( jQuery );
