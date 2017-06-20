
( function( $ ) {

	$.each( onetoneStyle, function( index ) {

		var dataType 		= onetoneStyle[index].type;
		var dataSlug		= onetoneStyle[index].slug;
		var dataProperty	= onetoneStyle[index].property;
		var dataProperty2	= onetoneStyle[index].property2;
		var dataSelector 	= onetoneStyle[index].selector;
		var dataChoices 	= onetoneStyle[index].choices;

		switch( dataType ) {

			case 'color' :
			case 'color_rgb' :
				wp.customize( dataSlug, function( value ) {
					value.bind( function( to ) {
						$( dataSelector ).css( dataProperty, to ? to : '' );
					});
				});

				break;

			case 'text' :
			case 'textarea' :
			case 'email' :

				wp.customize( dataSlug, function( value ) {
					value.bind( function( to ) {
						$( dataSelector ).html( to );
					} );
				} );

				break;

			case 'checkbox' :

				wp.customize( dataSlug, function( value ) {
					value.bind( function( to ) {
						false === to ? $( dataSelector ).hide() : $( dataSelector ).show();
					} );
				} );

				break;

			case 'images' :
					
					wp.customize( dataSlug, function( value ) {
						value.bind( function( to ) {
							$( dataSelector ).css( dataProperty, 'url(' + "'" + to + "'" + ')' + dataProperty2 );
						} );
					} );
				
				break;

			case 'google_font' :

				wp.customize( dataSlug, function( value ) {
					value.bind( function( to ) {
						$( dataSelector ).css( dataProperty, to ? to : '' );
						// add Google Fonts lib call in <head>
						var font_url = '//fonts.googleapis.com/css?family=';
						var font_link = '<link type="text/css" media="all" href="' + font_url + to.replace( ' ', '+') + '" rel="stylesheet">';
						$( font_link ).appendTo( $( 'head' ) );
					});
				});
				
				break;

			default:
				
				break;
		}

		
	});
	
} )( jQuery );