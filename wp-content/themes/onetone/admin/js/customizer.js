jQuery(document).ready( function( $ ) {
			
	$('#customize-theme-controls > ul').prepend('<li id="accordion-section-importer" class="accordion-section control-section control-section-importer" style="display: list-item;padding: 15px 10px 15px;box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;background: #fff;"><a href="#" id="import-theme-options" class="button">'+onetone_customize_params.import_options+'</a><div class="import-status"></div></li>');
	$(document).on('click','#import-theme-options',function(){
			
		if(confirm( onetone_customize_params.confirm )){
			
		$('#accordion-section-importer .import-status').text(onetone_customize_params.loading);							
		$.ajax({type:"POST",dataType:"html",url:onetone_customize_params.ajaxurl,data:"action=onetone_otpions_customize",
			success:function(data){
				$('#accordion-section-importer .import-status').text(onetone_customize_params.complete);
				location.reload() ;
			},error:function(){
				$('#accordion-section-importer .import-status').text(onetone_customize_params.error);
		}});
		}
	});
});