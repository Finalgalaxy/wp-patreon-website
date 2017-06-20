(function($){
	$.fn.OnetoneSerializeObject = function(){

		var self = this,
			json = {},
            push_counters = {},
            patterns = {
                "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                "push":     /^$/,
                "fixed":    /^\d+$/,
                "named":    /^[a-zA-Z0-9_]+$/
            };


        this.build = function(base, key, value){
            base[key] = value;
            return base;
        };

        this.push_counter = function(key){
            if(push_counters[key] === undefined){
                push_counters[key] = 0;
            }
            return push_counters[key]++;
        };

        $.each($(this).serializeArray(), function(){

            // skip invalid keys
            if(!patterns.validate.test(this.name)){
                return;
            }

            var k,
                keys = this.name.match(patterns.key),
                merge = this.value,
                reverse_key = this.name;

            while((k = keys.pop()) !== undefined){

                // adjust reverse_key
                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                // push
                if(k.match(patterns.push)){
                    merge = self.build([], self.push_counter(reverse_key), merge);
                }

                // fixed
                else if(k.match(patterns.fixed)){
                    merge = self.build([], k, merge);
                }

                // named
                else if(k.match(patterns.named)){
                    merge = self.build({}, k, merge);
                }
            }

            json = $.extend(true, json, merge);
        });

        return json;
    };
})(jQuery);


jQuery(document).ready(function($){

/* ------------------------------------------------------------------------ */
/*  section accordion         	  								  	    */
/* ------------------------------------------------------------------------ */

$('.section-accordion').click(function(){

 var accordion_item = $(this).find('.heading span').attr('id');
 //$('.'+accordion_item).slideToggle();
 if( $(this).hasClass('close')){
	$(this).removeClass('close').addClass('open');
	$(this).find('.heading span.fa').removeClass('fa-plus').addClass('fa-minus');
	}else{
		$(this).removeClass('open').addClass('close'); 
		$(this).find('.heading span.fa').removeClass('fa-minus').addClass('fa-plus');
		}

	$(this).parent('.section').find('.section_wrapper').slideToggle();

	});

// select section content model

$('.section-content-model').each(function(){

   var model          = $(this).find('input[type="radio"]:checked').val();
   var content_mode_0 = $(this).parents('.home-section').find('.content-model-0');
   var content_mode_1 = $(this).parents('.home-section').find('.content-model-1');

   if( model == 0 ){
		content_mode_0.show();
		content_mode_1.hide();
	}
	else
	{
	content_mode_0.hide();
	content_mode_1.show();
	}

});

	$( '.section-content-model input[type="radio"]' ).change(function() {

	var model          = $(this).val();
	var content_mode_0 = $(this).parents('.home-section').find('.content-model-0');
	var content_mode_1 = $(this).parents('.home-section').find('.content-model-1');

	if( model == 0 ){
		content_mode_0.show();
		content_mode_1.hide();
	}
	else
	{
		content_mode_0.hide();
		content_mode_1.show();
	}
	});
	$('.section_wrapper').each(function(){
		$(this).children(".content-model-0:first").addClass('model-item-first');
		$(this).children(".content-model-0:last").addClass('model-item-last');
	});
/* ------------------------------------------------------------------------ */
/*  delete section             	  								  	    */
/* ------------------------------------------------------------------------ */
	$('#optionsframework').on('click','.delete-section',function(){
		$(this).parents('.home-section').remove();	
		var i = 0;
		$('.home-section').each(function(){
			$(this).find("[name^='onetone']").each(function(){
				var name = $(this).attr('name');
				var id   = $(this).attr('id');
				var new_name = name.replace(/[0-9]+/, i);
				var new_id   = id.replace(/[0-9]+/, i);
				$(this).attr('name',new_name);
				$(this).attr('id',new_id);
			});
			i++;
			$('#section_num').val(i);
	});
	});

	if( $('.onetone-step-2-text').length ){
		$('#menu-appearance > a').append($('#onetone-step-1-text').html());
		$('.onetone-step-2-text').closest('li').addClass('onetone-step-2');
	}

// onetone guide

$('.onetone-step-2-text,.onetone-step-1-text').click(function(e){
	e.preventDefault();
});

$('.onetone-close-guide').click(function(e){
	e.preventDefault();	
	$('.onetone-guide').hide();
	$.ajax({
		type:"POST",
		dataType:"html",
		url:ajaxurl,
		data:"action=onetone_close_guide",
		success:function(data){},error:function(){}
	});
	});

$('.onetone-import-demos .button-import-demo').click(function(){
			$('.importer-notice').show();
	});

// save options

$(function(){
	var lastScroll = 0;
	$(window).scroll(function(event){
		var st = $(this).scrollTop();
		if (st > lastScroll){
			$(".onetone-admin-footer").css("display",'inline')
		}
		if(st == 0){
			$(".onetone-admin-footer").css("display",'none')
		}
		lastScroll = st;
	});
	});

$(function(){

function getDiff(obj1, obj2) {
  var diff = false;
  for (var key in obj1) {
    if(obj1.hasOwnProperty(key) && typeof obj1[key] !== "function") { 
      var obj1Val	= obj1[key],
          obj2Val	= obj2[key];

	  //if( obj2Val === false ) obj2Val = '';
      if (!(key in obj2)) {
        if(!diff) { diff = {}; }
        diff[key] = ''; 
      }

      else if(typeof obj1Val === "object") {
        var tempDiff = getDiff(obj1Val, obj2Val);
        if(tempDiff) {
          if(!diff) { diff = {}; }
          diff[key] = tempDiff;
        }
      }
      else if (obj1Val !== obj2Val) {
        if(!diff) { diff = {}; }
        diff[key] = obj2Val;
      }
    }
  }

  // Iterate over obj2 looking for any new additions
  for (key in obj2) {
    if(obj2.hasOwnProperty(key) && typeof obj2[key] !== "function") {
      var obj1Val	= obj1[key],
          obj2Val	= obj2[key];
          
      if (!(key in obj1)) {
        if(!diff) { diff = {}; }
        diff[key] = obj2Val;
      }
    }
  }

  return diff;
};

	var theme_options = $("#optionsframework > form").OnetoneSerializeObject(),themeOptions = theme_options[onetone_params.option_name];

	$(document).on('click','#onetone-save-options,#optionsframework-submit input[name="update"]',function(e){

		e.preventDefault();

		var formOptions  = $("#optionsframework > form").OnetoneSerializeObject();

		var result   = getDiff( themeOptions,formOptions[onetone_params.option_name] );

		$('.options-saving').fadeIn("fast");		 

		var option_page      = $('[name="option_page"]').val();
		var _wpnonce         = $('[name="_wpnonce"]').val();
		var _wp_http_referer = $('[name="_wp_http_referer"]').val();
		var action           = "onetone_save_options";

		var diffOptions = { 'option_page':option_page,'_wpnonce':_wpnonce,'_wp_http_referer':_wp_http_referer,'action':action};

		diffOptions[onetone_params.option_name] = result;

		$.post( onetone_params.ajaxurl,diffOptions,function(msg){
			$('.options-saving').fadeOut("fast");
			$('.options-saved').fadeIn("fast", function() {
			$(this).delay(2000).fadeOut("slow");

			});

		themeOptions = formOptions[onetone_params.option_name];

		return false;
	});
	return false;
	});

});

// backup theme options
$(document).on('click','#onetone-backup-btn',function(){
	$('.onetone-backup-complete').hide();
	$.ajax({type: "POST",url: onetone_params.ajaxurl,dataType: "html",data: { action: "onetone_options_backup"},
	success:function(content){
		$('.onetone-backup-complete').show();
		$('#onetone-backup-lists').append(content);
		return false;
	}
	});
		return false;
   });
 // delete theme options backup
$(document).on('click','#onetone-delete-btn',function(){
	if(confirm("Are you sure you want to do this?")){
		var key = $(this).data('key');
		$.ajax({type: "POST",url: onetone_params.ajaxurl,dataType: "html",data: { key:key,action: "onetone_options_backup_delete"},
		success:function(content){
			$('#tr-'+key).remove();
			return false;
			}
		});
		return false;
		}
	});
// restore theme options backup
$(document).on('click','#onetone-restore-btn',function(){
	if(confirm("Are you sure you want to do this?")){
		var restore_icon = $(this).find('.fa');
		restore_icon.addClass('fa-spin');
		var key = $(this).data('key');
		$.ajax({type: "POST",url: onetone_params.ajaxurl,dataType: "html",data: { key:key,action: "onetone_options_backup_restore"},
		success:function(content){
			restore_icon.removeClass('fa-spin');
			alert(content);
			window.location.reload();
			return false;
			}
		});
		return false;
		}
	});

$(document).on('click','.options-to-customise .notice-dismiss',function(){

	$.ajax({type: "POST",url: onetone_params.ajaxurl,dataType: "html",data: { action: "onetone_close_notice"}});

});

});