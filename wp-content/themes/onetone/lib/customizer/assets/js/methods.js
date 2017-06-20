$ = jQuery.noConflict();

( function( $ ) {
	"use strict"

	$(document).ready(function(){
		$(".koo-chosen").chosen({
			allow_single_deselect :true,
			width:"100%",
		});
	});

	$.ONETONEDEPENDENCY = function( el, param ) {

		// Access to jQuery and DOM versions of element
		var base    = this;
		base.$el 	= $(el);
		base.el  	= el;

		base.init = function () {

			base.ruleset = $.deps.createRuleset();

			// required for shortcode attrs
			var cfg = {
				show: function( el ) {
					el.removeClass('hidden');
				},
				hide: function( el ) {
					el.addClass('hidden');
				},
				log: false,
				checkTargets: false
			};
		
			base.depRoot();

			$.deps.enable( base.$el, base.ruleset, cfg );

		};

		base.depRoot = function() {

			base.$el.each( function() {

				$(this).find('[data-controller]').each( function() {

					var $this   = $(this),
					_controller = $this.data('controller').split('|'),
					_condition  = $this.data('condition').split('|'),
					_value      = $this.data('value').toString().split('|'),
					_rules      = base.ruleset;

					$.each(_controller, function(index, element) {

						var value = _value[index] || '',
						condition = _condition[index] || _condition[0];

						_rules = _rules.createRule('[data-customize-setting-link="'+ element +'"]', condition, value);
						_rules.include($this);

					});

				});

			});

		};

		base.init();
	};

	$.fn.ONETONE_DEPENDENCY = function ( param ) {
		return this.each(function () {
			new $.ONETONEDEPENDENCY( this, param );
		});
	};

} )( jQuery );