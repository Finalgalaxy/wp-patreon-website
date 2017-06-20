<?php
  function onetone_customize_importer_js() {
	// Restore defaults 
	global $pagenow,$onetone_upgrade_from_options;
	
	if( $pagenow == "customize.php" ){
	
	$themename = onetone_option_name();
	
	$theme_options_version = 0;
	if( get_option($themename) && $onetone_upgrade_from_options == '0' )
	$theme_options_version = 1;
	
	$loading         = __('Updating','onetone');
	$complete        = __('Complete','onetone');
	$error           = __('Error','onetone');
	$import_options  = __('Restore Defaults','onetone');
	$confirm         = esc_js( __( 'Click OK to reset. Any onetone options will be restored!', 'onetone' ) );
	
    wp_enqueue_script( 'onetone-customize-importer', get_template_directory_uri() . '/admin/js/customizer.js', '', '' );
	wp_localize_script( 'onetone-customize-importer', 'onetone_customize_params', array(
			'ajaxurl'        => admin_url('admin-ajax.php'),
			'themeurl' => get_template_directory_uri(),
			'theme_options_version' => $theme_options_version,
			'loading' => $loading,
			'complete' => $complete,
			'error' => $error,
			'import_options' =>$import_options,
			'confirm' =>$confirm,
		)  );
	}
  }

 add_action( 'admin_enqueue_scripts', 'onetone_customize_importer_js' );
 add_action( 'wp_ajax_onetone_otpions_customize', 'onetone_otpions_customize' );
 add_action( 'wp_ajax_nopriv_onetone_otpions_customize', 'onetone_otpions_customize' );

 function onetone_otpions_customize(){
	 
	  $option_name     = onetone_option_name();
	  $options         = get_option($option_name);
	  $default_options = array(); 
	  if( function_exists('onetone_standard_settings_data')){

		  $options = onetone_standard_settings_data();
		  	foreach( $options as $option ){
				
				if(strstr($option['slug'],$option_name.'[')){
								
						$id = str_replace(array('onetone[',']'),array('',''),$option['slug']);
						$default_options[$id] = $option['default'];
					}
				}
		  }

		  if(!empty( $options )){
			  
			 $new_options =  array_merge($options,$default_options);
			 update_option( $option_name ,$new_options);
			 
			  }
			  exit(0);
	 }