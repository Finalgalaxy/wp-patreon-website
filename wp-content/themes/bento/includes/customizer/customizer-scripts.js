
// Scripts for the theme customizer

var $str = jQuery.noConflict();

$str(document).ready(function() {
	
	
	// Control visibility logic
	
	function bntMenuBackground() {
		var $parent = $str( '#customize-control-bento_menu_config select' );
		var $child1 = $str( '#customize-control-bento_primary_menu_background' );
		var $child2 = $str( '#customize-control-bento_menu_separators' );
		if ( $parent.attr('value') == 2 ) {
			$child1.show();
			$child2.hide();
		} else if ( $parent.attr('value') == 3 ) {
			$child2.show();
			$child1.hide();
		} else {
			$child1.hide();
			$child2.hide();
		}
	}
	bntMenuBackground();
	$str( '#customize-control-bento_menu_config select' ).change( function() {
		bntMenuBackground();
	});
	
	function bntPopupLocation() {
		var $parent = $str( '#customize-control-bento_cta_location select' );
		var $child = $str( '#customize-control-bento_cta_page' );
		if ( $parent.attr('value') == 4 ) {
			$child.show();
		} else {
			$child.hide();
		}
	}
	bntPopupLocation();
	$str( '#customize-control-bento_cta_location select' ).change( function() {
		bntPopupLocation();
	});
	
	function bntPopupTrigger() {
		var $parent = $str( '#customize-control-bento_cta_trigger select' );
		var $child = $str( '#customize-control-bento_cta_timeonpage' );
		if ( $parent.attr('value') == 0 ) {
			$child.show();
		} else {
			$child.hide();
		}
	}
	bntPopupTrigger();
	$str( '#customize-control-bento_cta_trigger select' ).change( function() {
		bntPopupTrigger();
	});
	
	function bntStaticFront() {
		var $parent = $str( '#customize-control-show_on_front' );
		var $child = $str( '#customize-control-bento_front_header_image, #customize-control-bento_front_header_primary_cta_text, #customize-control-bento_front_header_primary_cta_link, #customize-control-bento_front_header_primary_cta_bck_color, #customize-control-bento_front_header_primary_cta_bck_color_hover, #customize-control-bento_front_header_primary_cta_text_color, #customize-control-bento_front_header_secondary_cta_text, #customize-control-bento_front_header_secondary_cta_link, #customize-control-bento_front_header_secondary_cta_color, #customize-control-bento_front_header_secondary_cta_color_hover' );
		if ( $parent.find('input[value="page"]').attr('checked') == 'checked' ) {
			$child.show();
		} else {
			$child.hide();
		}
	}
	bntStaticFront();
	$str( '#customize-control-show_on_front input' ).change( function() {
		bntStaticFront();
	});
		
		
});