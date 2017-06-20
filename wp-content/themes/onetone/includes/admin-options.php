<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
if( !function_exists('optionsframework_option_name') ):
	function optionsframework_option_name() {

		$themename = get_option( 'stylesheet' );
		$themename = preg_replace("/\W/", "_", strtolower($themename) );
  
		if( is_child_theme() ){	
			$themename = str_replace("_child","",$themename ) ;
		  }
		$themename_lan = $themename;
	  
		if( defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE != 'en' )
			$themename_lan = $themename.'_'.ICL_LANGUAGE_CODE;
	  
		if(function_exists('pll_current_language')){
			$default_lan = pll_default_language('slug');
			$current_lan = pll_current_language('slug');
	  
		if($current_lan !='')
			$themename_lan = $themename.'_'.$current_lan;
		}
 
		return $themename_lan;
  }
endif;

// get num string
function onetone_CountTail($number)  
  {  
	 $nstring = (string) $number;  
	 $pointer = strlen($nstring) - 1;  
	 $digit   = $nstring[$pointer];  
	 $suffix  = "th";  
	
	 if ($pointer == 0 ||  
		($pointer > 0 && $nstring[$pointer - 1] != 1))  
	 {  
		switch ($nstring[$pointer])  
		{  
		   case 1: $suffix = "st"; break;  
		   case 2: $suffix = "nd"; break;  
		   case 3: $suffix = "rd"; break;  
		}  
	 }  
	   
	 return $number . $suffix;  
  }  
  
  
  global $social_icons;

$social_icons = array(
	array('title'=>'Facebook','icon' => 'facebook', 'link'=>'#'),
	array ('title'=>'Twitter','icon' => 'twitter', 'link'=>'#'), 
	array('title'=>'LinkedIn','icon' => 'linkedin', 'link'=>'#'),
	array  ('title'=>'YouTube','icon' => 'youtube', 'link'=>'#'),
	array('title'=>'Skype','icon' => 'skype', 'link'=>'#'),
	array ('title'=>'Pinterest','icon' => 'pinterest', 'link'=>'#'),
	array('title'=>'Google+','icon' => 'google-plus', 'link'=>'#'),
	array('title'=>'Email','icon' => 'envelope', 'link'=>'#'),
	array ('title'=>'RSS','icon' => 'rss', 'link'=>'#')
  );

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 */

if( !function_exists('optionsframework_options') ):
function optionsframework_options() {
	
	global $social_icons,$sidebars,$onetone_options_saved,$onetone_home_sections,$onetone_old_version, $onetone_model_v;
	
	$onetone_option_name	= onetone_option_name();
    $theme_options          = get_option($onetone_option_name);
	
	$google_fonts = array();
	$os_fonts        = onetone_options_typography_get_os_fonts();
	$os_fonts        = array_merge( array('' => __( '-- Default --', 'onetone' ) ), $os_fonts);

	$onetone_typography_mixed_fonts = array_merge( $os_fonts  , $google_fonts );
	asort($onetone_typography_mixed_fonts);
		
	$nav_typography_defaults = array(
		'size'  => '16px',
		'face'  => 'Calibri,sans-serif',
		'style' => 'normal',
		'color' => '#dddddd' );
		
	$footer_typography_defaults = array(
		'size'  => '14px',
		'face'  => 'Calibri,sans-serif',
		'style' => 'inherit',
		'color' => '#777777' );
		
	$typography_options = array(
		'sizes'  => array( '10','11','12','13','14','16','18','20','24','26','28','30','35','36','38','40','46','50','60','64' ),
		'faces'  => $onetone_typography_mixed_fonts,
		'styles' => array(
				  'normal' =>  'Normal',
				  'italic' => 'Italic', 
				  'bold' => 'Bold',
				  'bold italic' => 'Bold Italic',
				  '100' => '100', 
				  '200' =>  '200',
				  '300' => '300',
				  '400' => '400', 
				  '500' =>  '500', 
				  '600' =>  '600', 
				  '700' =>  '700', 
				  '800' =>  '800',
				  '900' =>  '900' 
				  ),
		
		'color'  => true );

	$font_color         = array('color' =>  '');
	$section_font_color = array('color' => '');
 
	$choices =  array( 
          
		'yes' => __( 'Yes', 'onetone' ),
		'no'  => __( 'No', 'onetone' )
 
        );
	
	$choices2 =  array( 
          
		'1'   => __( 'Yes', 'onetone' ),
		'0'   => __( 'No', 'onetone' )
 
        );
	
    $choices_reverse =  array( 
          
		'no'   => __( 'No', 'onetone' ),
		'yes' => __( 'Yes', 'onetone' )
         
        );
	
	$align =  array( 
         ''        => __( 'Default', 'onetone' ),
		'left'    => __( 'Left', 'onetone' ),
        'right'   => __( 'Right', 'onetone' ),
        'center'  => __( 'Center', 'onetone' )         
        );
	
	$repeat = array( 
		'repeat'     => __( 'Repeat', 'onetone' ),
		'repeat-x'   => __( 'Repeat X', 'onetone' ),
		'repeat-y'   => __( 'Repeat Y', 'onetone' ),
		'no-repeat'  => __( 'No Repeat', 'onetone' )
			
		  );
	
	$target = array(
		'_blank' => __( 'Blank', 'onetone' ),
		'_self'  => __( 'Self', 'onetone' )
			);
	
	$position =  array( 
			
		'top left'      => __( 'Top Left', 'onetone' ),
		'top center'    => __( 'Top Center', 'onetone' ),
		'top right'     => __( 'Top Right', 'onetone' ),
		'center left'   => __( 'Center Left', 'onetone' ),
		'center center' => __( 'Center Center', 'onetone' ),
		'center right'  => __( 'Center Right', 'onetone' ),
		'bottom left'   => __( 'Bottom Left', 'onetone' ),
		'bottom center' => __( 'Bottom Center', 'onetone' ),
		'bottom right'  => __( 'Bottom Right', 'onetone' )
			  
		  );
  
    $opacity             = array_combine(range(0.1,1,0.1), range(0.1,1,0.1));
    $font_size           = array_combine(range(1,100,1), range(1,100,1));
	
	$section_menu        = array("Home","","Services","Gallery","Team","About","Testimonials","","Contact","Portfolio","Pricing","Blog");
	$section_slug        = array('home','','services','gallery','team','about','testimonials','','contact','portfolio',"pricing","blog");
	$section_padding     = array('','30px 0','50px 0','50px 0','50px 0','50px 0','50px 0 30px','50px 0','50px 0','50px 0','50px 0','50px 0','50px 0','50px 0','50px 0');
	$text_align          = array('center','left','center','center','center','left','center','left','center');
	
	$section_title       = array("POWERFUL ONE PAGE THEME","","","GALLERY","OUR TEAM","ABOUT","","","CONTACT","PORTFOLIO","PRICING","BLOG","","");
	$section_color       = array("#ffffff","#555555","#555555","#555555","#555555","#666666","#ffffff","#555555","#555555");
	$section_subtitle    = array(
								 "BASED ON BOOTSTRAP FRAMEWORK AND SHORTCODES, QUICK SET AND EASY BUILD, SHINES ONE PAGE SMALL BUSINESS WEBSITE.",
								 "",
								 "",
								 "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere c.<br/>Etiam ut dui eu nisi lobortis rhoncus ac quis nunc.",
								 "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere c.<br/>Etiam ut dui eu nisi lobortis rhoncus ac quis nunc.",
								 "",
								 "",
								 "",
								 "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere c.<br/>Etiam ut dui eu nisi lobortis rhoncus ac quis nunc.",
								 "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere c.<br/>Etiam ut dui eu nisi lobortis rhoncus ac quis nunc.",
								 "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere c.<br/>Etiam ut dui eu nisi lobortis rhoncus ac quis nunc.",
								 );
	
	
	if( $onetone_old_version )
	  $content_model = '1';
	else
	  $content_model = '0';
	  
	  if ( isset( $_POST['reset'] ) ) 
		   $content_model = '0';
	
	$default_section_num = count($section_menu);

	$section_background  = array(
	     array(
		'color' => '#333333',
		'image' => ONETONE_THEME_BASE_URL.'/images/home-bg01.jpg',
		'repeat' => 'repeat',
		'position' => 'center center',
		'attachment'=>'scroll' ),
		 array(
		'color' => '#eeeeee',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		 array(
		'color' => '#ffffff',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		 array(
		'color' => '#eeeeee',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		 ##  section 5
		 array(
		'color' => '#ffffff',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		 array(
		'color' => '',
		'image' => esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/Image_02.png'),
		'repeat' => 'repeat',
		'position' => 'center center',
		'attachment'=>'fixed' ),
		 array(
		'color' => '#37cadd',
		'image' => '',
		'repeat' => 'no-repeat',
		'position' => 'bottom center',
		'attachment'=>'scroll' ),
		 array(
		'color' => '#ffffff',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		 
		  array(
		'color' => '',
		'image' => esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/16110810_1.jpg'),
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		   array(
		'color' => '#ffffff',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		    array(
		'color' => '#eeeeee',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		array(
		'color' => '#ffffff',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top left',
		'attachment'=>'scroll' ),
		 		 
			);
	
	$section_css_class = array("section-banner","","","","","","","","");
	
	$section_title_typography_defaults = array(
		array('size'  => '64px','face'  => 'Lustria,serif','style' => 'normal','color' => '#ffffff' ),
		array('size'  => '48px','face'  => '','style' => 'normal','color' => '#666666' ),
		array('size'  => '48px','face'  => '','style' => 'normal','color' => '#666666' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#666666' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#666666' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#666666' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#ffffff' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#666666' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#666666' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#666666' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#666666' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#666666' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#666666' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#666666' ),
		array('size'  => '36px','face'  => '','style' => 'bold','color' => '#666666' ),
							
         );
		 
	$section_subtitle_typography_defaults = array(
		array('size'  => '18px','face'  => '','style' => 'normal','color' => '#ffffff' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#555555' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#555555' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#555555' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#555555' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#666666' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#ffffff' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#555555' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#555555' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#666666' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#666666' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#666666' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#666666' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#666666' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#666666' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#666666' ),
      );
	  
	$section_content_typography_defaults = array(
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#ffffff' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#666666' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#ffffff' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#555555' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#ffffff' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '#ffffff' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '' ),
		array('size'  => '14px','face'  => '','style' => 'normal','color' => '' ),
													 
          );
	 
	$home_sections = array(
		1 => __('Section 1 - Banner', 'onetone' ),
		2 => __('Section 2 - Slogan', 'onetone' ),
		3 => __('Section 3 - Service', 'onetone' ),
		4 => __('Section 4 - Gallery', 'onetone' ),
		5 => __('Section 5 - Team', 'onetone' ),
		6 => __('Section 6 - About', 'onetone' ),
		7 => __('Section 7 - Counter', 'onetone' ),
		8 => __('Section 8 - Testimonial', 'onetone' ),
		9 => __('Section 9 - Contact', 'onetone' ),
		10 => __('Section 10 - Portfolio', 'onetone' ),
		11 => __('Section 11 - Pricing', 'onetone' ),
		12 => __('Section 12 - Blog', 'onetone' ),
		13 => sprintf(__('Section %s', 'onetone'),13),
		14 => sprintf(__('Section %s', 'onetone'),14),
		15 => sprintf(__('Section %s', 'onetone'),15),
		);
	 
    $onetone_home_sections = $home_sections;
	 
    $section_num = count( $home_sections );

	$options = array();
	

	//HOME PAGE
	$options[] = array(
		'icon' => 'fa-home',
		'name' => __('Home Page', 'onetone'),
		'type' => 'heading'
		);
		
	//HOME PAGE SECTION
		
	$options[] = array(
		'id'          => 'header_overlay',
		'name'       => __( 'Home Page Header Overlay', 'onetone' ),
		'desc'        => __( 'Choose to set home page header as overlay style.', 'onetone' ),
		'std'         => 1,
		'type'        => 'checkbox',
		'section'     => 'header_tab_section',
		'class'       => '',
		'options'     => $choices_reverse
		);
	
	$options[] = array(
		'id'          => 'enable_side_nav',
		'name'       => __( 'Enable Side Navigation', 'onetone' ),
		'desc'        => __( 'Enable side dot navigation.', 'onetone' ),
		'std'         => '',
		'type'        => 'checkbox',
		'section'     => 'header_tab_section',
		'class'       => '',
		'options'     => $choices_reverse
		);
	

	// YouTube video background options
	$options[] = array('name' => '','id' => 'youtube_video_group','type' => 'start_group','class'=>''); 
	$options[] =   	 array(
		'id'          => 'youtube_video_titled',
		'name'        => __( 'YouTube Video Background Options', 'onetone' ).' <span id="accordion-group-youtube_video" class="fa fa-plus"></span>',
		'desc'        => '',
		'std'         => '',
		'type'        => 'textblock-titled',
		'rows'        => '4',
		'class'       => 'section-accordion close',
		);
		
	$options[] = array('name' => '','id' => 'wrapper_start','type' => 'wrapper_start','class'=>'home-section-wrapper');
		
	$options[] = array(
		'name' => __('YouTube ID for Video Background', 'onetone'),
		'std' => 'XDLmLYXuIDM',
		'desc' => __('Insert the eleven-letter id here, not url.', 'onetone'),
		'id' => 'section_background_video_0',
		'type' => 'text',
		'class'=>'section-item accordion-group-youtube_video'
		);
		
	$options[] = array('name' => __('Start Time', 'onetone'),'std' => '18','desc' => __('Choose time to start to play, in seconds', 'onetone'),'id' => 'section_youtube_start','type' => 'text','class' => 'section-item accordion-group-youtube_video' );
	
	$options[] = array('name' => __('Stop Time', 'onetone'),'std' => '0','desc' => __('Choose time to stop to play, in seconds', 'onetone'),'id' => 'section_youtube_stop','type' => 'text','class' => 'section-item accordion-group-youtube_video' );
		
	$options[] = array(
		'name' => __('Display Video Control Buttons.', 'onetone'),
		'desc' => __('Choose to display video controls at bottom of the section with video background.', 'onetone'),
		'id' => 'video_controls',
		'std' => '1',
		'class' => 'section-item accordion-group-youtube_video',
		'options' => $choices2,
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Mute', 'onetone'),
		'desc' => __('Choose to set the video mute', 'onetone'),
		'id' => 'youtube_mute',
		'std' => '0',
		'class' => 'mini section-item accordion-group-youtube_video',
		'options' => $choices2,
		'type' => 'select'
		);
		
	$options[] = array(
		'name' => __('AutoPlay', 'onetone'),
		'desc' => __('Choose to set the video autoplay', 'onetone'),
		'id' => 'youtube_autoplay',
		'std' => '1',
		'class' => 'mini section-item accordion-group-youtube_video',
		'options' => $choices2,
		'type' => 'select'
		);
		
	$options[] = array(
		'name' => __('Loop', 'onetone'),
		'desc' => __('Choose to set the video loop', 'onetone'),
		'id' => 'youtube_loop',
		'std' => '1',
		'class' => 'mini section-item accordion-group-youtube_video',
		'options' => $choices2,
		'type' => 'select');
		
	$options[] = array(
		'name' => __('Background Type', 'onetone'),
		'desc' => __('Choose to set the video as background of the whole site or just one section', 'onetone'),
		'id' => 'youtube_bg_type',
		'std' => '1',
		'class' => 'mini section-item accordion-group-youtube_video',
		'options' => array('1'=>__('Body Background', 'onetone'),'0'=>__('Section Background', 'onetone')),
		'type' => 'select');
		
		
	$options[] = array('name' => '','id' => 'wrapper_end','type' => 'wrapper_end','class'=>'home-section-wrapper');
	$options[] = array('name' => '','id' => 'youtube_video_group_','type' => 'end_group','class'=>'');
		

	// Vimeo video background options
	$options[] = array('name' => '','id' => 'vimeo_video_group','type' => 'start_group','class'=>''); 
	$options[] =   	 array(
		'id'          => 'vimeo_video_titled',
		'name'        => __( 'Vimeo Video Background Options', 'onetone' ).' <span id="accordion-group-vimeo_video" class="fa fa-plus"></span>',
		'desc'        => '',
		'std'         => '',
		'type'        => 'textblock-titled',
		'rows'        => '4',
		'class'       => 'section-accordion close',
						  
		);
		
	$options[] = array('name' => '','id' => 'wrapper_start','type' => 'wrapper_start','class'=>'home-section-wrapper');
		
	$options[] = array(
		'name' => __('Vimeo URL for Video Background', 'onetone'),
		'std' => '',
		'desc' => __('Insert the vimeo video URL here, e.g. https://vimeo.com/193338881', 'onetone'),
		'id' => 'section_background_video_vimeo',
		'type' => 'text',
		'class'=>'section-item accordion-group-vimeo_video'
		);
		
	$options[] = array('name' => __('Start Time', 'onetone'),'std' => '1','desc' => __('Choose time to start to play, in seconds', 'onetone'),'id' => 'section_vimeo_start','type' => 'text','class' => 'section-item accordion-group-vimeo_video' );
		
	$options[] = array(
		'name' => __('Display Video Control Buttons.', 'onetone'),
		'desc' => __('Choose to display video controls at bottom of the section with video background.', 'onetone'),
		'id' => 'vimeo_video_controls',
		'std' => '1',
		'class' => 'section-item accordion-group-vimeo_video',
		'options' => $choices2,
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Mute', 'onetone'),
		'desc' => __('Choose to set the video mute', 'onetone'),
		'id' => 'vimeo_mute',
		'std' => '0',
		'class' => 'mini section-item accordion-group-vimeo_video',
		'options' => $choices2,
		'type' => 'select');
		
	$options[] = array(
		'name' => __('AutoPlay', 'onetone'),
		'desc' => __('Choose to set the video autoplay', 'onetone'),
		'id' => 'vimeo_autoplay',
		'std' => '1',
		'class' => 'mini section-item accordion-group-vimeo_video',
		'options' => $choices2,
		'type' => 'select');
		
	$options[] = array(
		'name' => __('Loop', 'onetone'),
		'desc' => __('Choose to set the video loop', 'onetone'),
		'id' => 'vimeo_loop',
		'std' => '1',
		'class' => 'mini section-item accordion-group-vimeo_video',
		'options' => $choices2,
		'type' => 'select');
		
	$options[] = array(
		'name' => __('Background Type', 'onetone'),
		'desc' => __('Choose to set the video as background of the whole site or just one section', 'onetone'),
		'id' => 'vimeo_bg_type',
		'std' => '0',
		'class' => 'mini section-item accordion-group-vimeo_video',
		'options' => array('1'=>__('Body Background', 'onetone'),'0'=>__('Section Background', 'onetone')),
		'type' => 'select');
		
		
	$options[] = array('name' => '','id' => 'wrapper_end','type' => 'wrapper_end','class'=>'home-section-wrapper');
	$options[] = array('name' => '','id' => 'vimeo_video_group_','type' => 'end_group','class'=>'');
		


	$video_types = array( 'youtube'=> __('YouTube Video', 'onetone'),'vimeo'=> __('Vimeo Video', 'onetone') );
	$options[] = array(	
		'name' => __('Video Background Type', 'onetone'),
		'id' => 'video_background_type',
		'std' => 'youtube',
		'desc' => __('Choose type of video background', 'onetone'),
		'class' => 'mini',
		'options' => $video_types,
		'type' => 'select'
		);
		
	$video_background_section = array("0"=>__('No video background','onetone'));
	
	foreach( $home_sections as $k=>$v ){
			
		$video_background_section[$k] = $v;
			
	}
			
	$options[] = array(
		'name' => __('Video Background Section', 'onetone'),
		'std' => '1',
		'id' => 'video_background_section',
		'type' => 'select',
		'options'=>$video_background_section,
		'desc' => __('Choose a section to set the video as background for', 'onetone'),
		);
		
		
	$options[] = array(
		'name' => __('Display slider instead in section 1', 'onetone'),
		'std' => '',
		'id' => 'section_1_content',
		'type' => 'checkbox',
		'desc' =>  __('Choose to display default slider instead of section contents here.', 'onetone')
		);
		
	$options[] = array(
		'name' => __('Enable Animation', 'onetone'),
		'desc'=>__('Enable animation for default section content.', 'onetone'),
		'std' => '1',
		'id' => 'home_animated',
		'type' => 'checkbox'
		);
		
	
		
	$options[] = array('name' => '','id' => 'section_order','type' => 'start_group','class'=>''); 
		
	$options[] = array(
		'id'          => 'section_order_titled',
		'name'       => __( 'Sections Order', 'onetone' ).' <span id="accordion-group-section_order" class="fa fa-plus"></span>',
		'desc'        => '',
		'std'         => '',
		'type'        => 'textblock-titled',
		'rows'        => '4',
		'class'       => 'section-accordion close',
        
		);
		 
	$options[] = array('name' => '','id' => 'wrapper_start','type' => 'wrapper_start','class'=>'home-section-wrapper');

	$options[] = array(
		'name' => '',
		'desc' => sprintf(__('<span style="padding-left:20px;">Get the <a href="%s" target="_blank">Pro version</a> of Onetone to acquire this feature.</span>', 'onetone' ),esc_url('https://www.mageewp.com/onetone-theme.html')),
		'id' => 'onetone_get_pro',
		'std' => '',
		'type' => 'info',
		'class'=>'section-item accordion-group-section-order'
		);

			  
	$options[]     = array('name' => '','id' => 'wrapper_end','type' => 'wrapper_end','class'=>'home-section-wrapper');
		
	$options[]     = array('name' => '','id' => 'section_order_','type' => 'end_group','class'=>'');
			  		
	$o_section_num = isset($theme_options[ 'section_num'])?$theme_options[ 'section_num']:''; 
		
	$options[] = array('name' => '','id' => 'home-sections-wrapper','type' => 'wrapper_start','class'=>'home-sections-wrapper');
		
	for( $i=0; $i < $section_num; $i++ ){
		
		$hide_section = '';
		
		if( $i >= $o_section_num && $o_section_num >0  )
			$hide_section = 1;
        if( $o_section_num <=0 && $i > 8 ){
			
			$hide_section  = 1;
			$content_model = 1;
			
			}
					
		
		if(!isset($section_title[$i])){ 
		     $section_title[$i] = "";
			 }
			 
		if(!isset($section_subtitle[$i])){
			$section_subtitle[$i] = "";
			}
			
		if(!isset($section_color[$i])){
			$section_color[$i] = "";
			}
			
		if(!isset($section_menu[$i])){
			$section_menu[$i] = "";
			}
		
		if(!isset($section_background[$i])){
		   $section_background[$i] = array('color' => '','image' => '','repeat' => '','position' => '','attachment'=>'');
		}
		
		if(!isset($section_title[$i])){
			$section_title[$i] = "";
			}
			
		if(!isset($menu_title[$i])){
			$menu_title[$i] = "";
			}
			
		if(!isset($menu_slug[$i])){
			$menu_slug[$i] = "";
			}
			
		if(!isset($section_background[$i])){
			$section_background[$i] = "";
			}
			
		if(!isset($background_size[$i])){
			$background_size[$i] = "";
			}
			
		if(!isset($parallax_scrolling[$i])){
			$parallax_scrolling[$i] = "";
			}
			
		if(!isset($full_width[$i])){
			$full_width[$i] = "";
			}
		
		if(!isset($section_css_class[$i])){
			$section_css_class[$i] = "";
			}
			
		if(!isset($section_content[$i])){
			$section_content[$i] = "";
			}
			
		if(!isset($section_slug[$i])){ 
		     $section_slug[$i] = "";
			 }
			 
		if(!isset($text_align[$i])){ 
		     $text_align[$i] = "";
			 }
			 
		if(!isset($section_padding[$i])){ 
		     $section_padding[$i] = "";
			 }
		
		if(!isset($section_padding[$i])){ 
		     $section_padding[$i] = "";
			 }
		
		if(!isset($section_title_typography_defaults[$i])){ 
		     $section_title_typography_defaults[$i] = array('size'  => '36px','face'  => '','style' => 'normal','color' => '#666666' );
		   }
		   
		if(!isset($section_subtitle_typography_defaults[$i])){ 
		     $section_subtitle_typography_defaults[$i] = array('size'  => '14px','face'  => '','style' => 'normal','color' => '#666666' );
		   }  
		   
		if(!isset($section_content_typography_defaults[$i])){ 
		     $section_content_typography_defaults[$i] = array('size'  => '14px','face'  => '','style' => 'normal','color' => '#666666' );
		   }
				
		$section_name = isset($theme_options[ 'section_title_'.$i])?$theme_options['section_title_'.$i]:''; 
		$menu_title   = isset($theme_options[ 'menu_title_'.$i])?$theme_options['menu_title_'.$i]:''; 
		$section_name = $section_name?$section_name:$menu_title;
        $section_name = $section_name? ' ('.$section_name.')':'';
		$section_name = $home_sections[$i+1] .' '. $section_name;
		
	$options[] = array('name' => '','id' => 'section_group_start_'.$i.'','type' => 'start_group','class'=>'home-section group_close');
		
	$options[] =   	 array(
		'id'          => 'sections_titled_'.$i,
		'name'       => $section_name .' <span id="accordion-group-section-'.$i.'" class="fa fa-plus"></span>',
		'desc'        => '',
		'std'         => '',
		'type'        => 'textblock-titled',
		'rows'        => '',
		'class'       => 'section-accordion close accordion-group-title-section-'.$i
      );
		
	$options[] = array('name' => '','id' => 'wrapper_start','type' => 'wrapper_start','class'=>'home-section-wrapper');
		
	$options[] = array(
		'name' => __('Hide Section', 'onetone'),
		'std' => $hide_section,
		'id' => 'section_hide_'.$i,
		                   'type' => 'checkbox',
		'class'=>'section-item accordion-group-section-'.$i,
		'desc'=> __('Hide this section on front page.', 'onetone'),
		);
				
	$options[] = array(
		'name' => __('Section Title', 'onetone'),
		'id' => 'section_title_'.$i.'',
		'type' => 'text',
		'std' => $section_title[$i],
		'class'=>'section-item accordion-group-section-'.$i,
		'desc' => __('Insert title for this section. It would appear at the top of the section.', 'onetone'),
		);
		
	$options[] = array(
		'name' => __('Menu Title', 'onetone'),
		'id' => 'menu_title_'.$i.'',
		'type' => 'text',
		'std'=> $section_menu[$i],
		'desc'=> __('Insert menu title for this section. This title would appear in the header menu. If leave it as blank, the link of this section would not be displayed in header menu.', 'onetone'),
		'class'=>'section-item accordion-group-section-'.$i
		);
		
	$options[] = array(
		'name' => __('Menu Slug', 'onetone'),
		'id' => 'menu_slug_'.$i.'',
		'type' => 'text',
		'std'=> $section_slug[$i],
		'desc'=> __('Attention! The "slug" is the URL-friendly version of menu title. It is usually all lowercase and contains only letters, numbers, and hyphens. If the menu title contains non-eng characters, you need to fill this form.', 'onetone'),
		'class'=>'section-item accordion-group-section-'.$i
		);

		
	$options[] = array(
		'name' =>  __('Section Background', 'onetone'),
		'id' => 'section_background_'.$i.'',
		'std' => $section_background[$i],
		'type' => 'background' ,
		'class'=>'section-item accordion-group-section-'.$i,
		'desc' => __('Set background color & background image for this section.', 'onetone'),
		);

	
	$options[] = array(
		'name' => __('Parallax Scrolling Background Image', 'onetone'),
		'std' => '0',
		'id' => 'parallax_scrolling_'.$i.'',
		'type' => 'checkbox',
		'class'=>'section-item accordion-group-section-'.$i,
		'desc' => __('Choose to apply parallax scrolling effect for background image.', 'onetone'),
		);

	$options[] = array(
		'name' => __('Full Width', 'onetone'),
		'std' => 'no',
		'id' => 'full_width_'.$i.'',
		'type' => 'select',
		'desc' => __('Choose to set width of section content as 100%', 'onetone'),
		'class'=>'mini section-item accordion-group-section-'.$i,
		'options'=>$choices_reverse
						  
		);
		
	$options[] = array(
		'name' => __('Section Css Class', 'onetone'),
		'id' => 'section_css_class_'.$i.'',
		'type' => 'text',
		'std'=>$section_css_class[$i],
		'class'=>'section-item accordion-group-section-'.$i,
		'desc' => __('Set an aditional css class of this section.', 'onetone'),
		
		);
		
	$options[] = array(
		'name' => __('Section Padding', 'onetone'),
		'id' => 'section_padding_'.$i.'',
		'type' => 'text',
		'std'=>$section_padding[$i],
		'class'=>'section-item accordion-group-section-'.$i,
		'desc' => __('Set padding for this section. In pixels (px), eg: 10px 20px 30px 0. These four numbers represent padding top/right/bottom/left.', 'onetone'),
		);
		
	$options[] = array(
		'name' => __('Text Align', 'onetone'),
		'std' => $text_align[$i],
		'id' => 'text_align_'.$i.'',
		'type' => 'select',
		'class'=>'mini section-item accordion-group-section-'.$i,
		'options'=>$align,
		'desc' => __('Set content align for this section.', 'onetone'),
		);
			    
	$options[] = array(
		'name' => __('Section Title Typography', 'onetone'),
		'id'   => "section_title_typography_".$i,
		'std'  => $section_title_typography_defaults[$i],
		'type' => 'typography',
		'options' => $typography_options ,
		'class'=>'section-item accordion-group-section-'.$i
		);
						  
	$options[] = array(
		'name' => __('Section Subtitle Typography', 'onetone'),
		'id'   => "section_subtitle_typography_".$i,
		'std'  => $section_subtitle_typography_defaults[$i],
		'type' => 'typography',
		'options' => $typography_options ,
		'class'=>'section-item accordion-group-section-'.$i
		);	
						  
	$options[] = array(
		'name' => __('Section Content Typography', 'onetone'),
		'id'   => "section_content_typography_".$i,
		'std'  => $section_content_typography_defaults[$i],
		'type' => 'typography',
		'options' => $typography_options ,
		'class'=>'section-item accordion-group-section-'.$i
		);
		
	$options[] = array(
		'name' =>  __('Section Content Model', 'onetone'),
		'id' =>'section_content_model_'.$i,
		'std' => $content_model,
		'class' => 'section-content-model section-item accordion-group-section-'.$i,
		'type' => 'radio',
		'options'=>array('0'=> __('Default', 'onetone'),'1'=>__('Custom', 'onetone'))
		);
		
	// Fixed content
	$options[] = array(
		'name' => __('Section Subtitle', 'onetone'),
		'id' => 'section_subtitle_'.$i.'',
		'type' => 'text',
		'std'=> $section_subtitle[$i],
		'class'=>'content-model-0 section-item accordion-group-section-'.$i,
		'desc'=> __('Insert sub-title for this section. It would appear at the bottom of the section title.', 'onetone'),
		);
		
	switch( $i ){
			case "0": // section banner
			
			$options[] = array(
						  'name' => __('Icon', 'onetone'),
						  'id'   => "section_icon_".$i,
						  'std'  => '',
						  'desc' => __( 'The image will display above the section title.', 'onetone' ),
						  'type' => 'upload',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
						
		     $options[] = array(
						  'name' => __('Button Text', 'onetone'),
						  'id'   => "section_btn_text_".$i,
						  'std'  => 'Click Me',
						  'type' => 'text',
						  'desc' => __('Insert text for the button', 'onetone'),
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			  $options[] = array(
						  'name' => __('Button Link', 'onetone'),
						  'id'   => "section_btn_link_".$i,
						  'std'  => '#',
						  'desc' => __('Insert link for the button, begin with http:// or https://', 'onetone'),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			  $options[] = array(
						  'name' => __('Button Target', 'onetone'),
						  'id'   => "section_btn_target_".$i,
						  'std'  => '_self',
						  'desc' => __('Self: open in the same window; blank: open in a new window', 'onetone'),
						  'type' => 'select',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i,
						  'options'     => $target
						  );
			  
			  $banner_social_icon = array('fa-facebook','fa-skype','fa-twitter','fa-linkedin','fa-google-plus','fa-rss');
			  
			  for( $s=0;$s<6;$s++ ):
			  
			  $options[] = array(
						  'name' => __('Social Icon', 'onetone').' '.($s+1),
						  'id'   => "section_social_icon_".$i."_".$s,
						  'std'  => $banner_social_icon[$s],
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i,
						  'desc' => __('Insert Fontawsome icon code', 'onetone')
						  );
			  $options[] = array(
						  'name' => __('Social Icon Link', 'onetone').' '.($s+1),
						  'id'   => "section_icon_link_".$i."_".$s,
						  'std'  => '#',
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i,
						  'desc' => __('Insert link for the icon', 'onetone')
						  );
			  
			  endfor;
	 
			break;
			case "1": // Section Slogan
			 $options[] = array(
						  'name' => __('Button Text', 'onetone'),
						  'id'   => "section_btn_text_".$i,
						  'std'  => 'Click Me',
						  'desc' => __('Insert text for the button', 'onetone'),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			  $options[] = array(
						  'name' => __('Button Link', 'onetone'),
						  'id'   => "section_btn_link_".$i,
						  'std'  => '#',
						  'desc' => __('Insert link for the button, begin with http:// or https://', 'onetone'),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			  $options[] = array(
						  'name' => __('Button Target', 'onetone'),
						  'id'   => "section_btn_target_".$i,
						  'std'  => '_self',
						  'desc' => __('Self: open in the same window; blank: open in a new window', 'onetone'),
						  'type' => 'select',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i,
						  'options'     => $target
						  );
			  
				$options[] = array(
						  'name' => __('Description', 'onetone'),
						  'desc' => '',
						  'id' => 'section_desc_'.$i,
						  'std' => '<h4>Morbi rutrum, elit ac fermentum egestas, tortor ante vestibulum est, eget scelerisque nisl velit eget tellus.</h4>',
						  'desc' => __('Insert content for the banner, html tags allowed', 'onetone'),
						  'type' => 'textarea',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i,
						  );
			
			break;
			case "2": // Section Service
			$icons   = array('fa-leaf','fa-hourglass-end','fa-signal','fa-heart','fa-camera','fa-tag');
			$images  = array(
							 'https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/Icon_1.png',
							 'https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/Icon_2.png',
							 'https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/Icon_3.png',
							 'https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/Icon_4.png',
							 'https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/Icon_5.png',
							 'https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/Icon_6.png'
							 );
			
			$options[] = array(
						  'id'          => 'section_service_icon_color_'.$i.'',
						  'name'       => __( 'Icon Color', 'onetone' ),
						  'desc'        => __( 'Set service icon color.', 'onetone' ),
						  'std'         => '#666666',
						  'type'        => 'color',
						  'class'       => 'content-model-0 section-item accordion-group-section-'.$i,
						  
						);
			
			for($c=0;$c<6;$c++){
				
				$options[] = array(
						  'name' => sprintf(__('Service Icon %d', 'onetone'),$c+1),
						  'id'   => "section_icon_".$i."_".$c,
						  'std'  => '',
						  'desc' => __('Insert Fontawsome icon code', 'onetone'),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				$options[] = array(
						  'name' => sprintf(__('Service Image %d', 'onetone'),$c+1),
						  'id'   => "section_image_".$i."_".$c,
						  'std'  => $images[$c],
						  'desc' => __('Or choose to upload icon image', 'onetone'),
						  'type' => 'upload',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				$options[] = array(
						  'name' => sprintf(__('Service Title %d', 'onetone'),$c+1),
						  'id'   => "section_title_".$i."_".$c,
						  'std'  => 'FREE PSD TEMPLATE',
						  'desc' => __('Set title for service item', 'onetone'),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				$options[] = array(
						  'name' => sprintf(__('Title Link %d', 'onetone'),$c+1),
						  'id'   => "section_link_".$i."_".$c,
						  'std'  => '',
						  'desc' => __('Insert link for service item', 'onetone'),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				
				$options[] = array(
						  'name' => sprintf(__('Link Target %d', 'onetone'),$c+1),
						  'id'   => "section_target_".$i."_".$c,
						  'std'  => '',
						  'desc' => __('Self: open in the same window; blank: open in a new window', 'onetone'),
						  'type' => 'select',
						  'options'=>$target,
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				
				$options[] = array(
						  'name' => sprintf(__('Service Description %d', 'onetone'),$c+1),
						  'id'   => "section_desc_".$i."_".$c,
						  'std'  => 'Integer pulvinar elementum est, suscipit ornare ante finibus ac. Praesent vel ex dignissim, rhoncus eros luctus, dignissim arcu.',
						  'desc' => __('Insert content for the banner, html tags allowed', 'onetone'),
						  'type' => 'textarea',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				
				}
			
			break;
			
			case "3": // Section Gallery
			
			$default_images = array(
									esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/16110807.jpg'),
									esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/16110805.jpg'),
									esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/16110806.jpg'),
									esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/16110802.jpg'),
									esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/161110001.jpg'),
									esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/16110803.jpg'),
									);
			for($c=0;$c<6;$c++){
				
		
				$options[] = array(
						  'name' => sprintf(__('Image %d', 'onetone'),$c+1),
						  'id'   => "section_image_".$i."_".$c,
						  'std'  => $default_images[$c],
						  'desc' => __('Choose to upload image for gallery item', 'onetone'),
						  'type' => 'upload',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
		
				$options[] = array(
						  'name' => sprintf(__('Link %d', 'onetone'),$c+1),
						  'id'   => "section_link_".$i."_".$c,
						  'std'  => '',
						  'desc' => __('Insert link for this item', 'onetone'),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				
				$options[] = array(
						  'name' => sprintf(__('Link Target %d', 'onetone'),$c+1),
						  'id'   => "section_target_".$i."_".$c,
						  'std'  => '',
						  'desc' => __('Self: open in the same window; blank: open in a new window', 'onetone'),
						  'type' => 'select',
						  'options' => $target,
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
								
				}
			
			break;
			case "4": // Section Team
			$social_icon = array('instagram','facebook','google-plus','envelope','','');
			$avatar = array(
							esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/team16110801.jpg'),
							esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/team16110802.jpg'),
							esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/team16110803.jpg'),
							esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/team16110804.jpg'),
							'',
							'',
							'',
							''
							);
			
			$options[] = array(
						  'id' => "section_team_columns",
						  'name' => __( 'Columns', 'onetone' ),
						  'desc' => __( 'Set columns for portfolio module', 'onetone' ),
						  'type'    => 'select',
						  'options' => array(1=>1,2=>2,3=>3,4=>4),
						  'std' => '4',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
					  );
			
			$options[] = array(
						  'id' => "section_team_style",
						  'name' => __( 'Style', 'onetone' ),
						  'desc' => '',
						  'type'    => 'select',
						  'options' => array(0=> __('Normal', 'onetone'),1=>__('Carousel', 'onetone') ),
						  'std' => '4',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
					  );
			
			for( $t=0; $t<8; $t++ ){
				
				$options[] = array(
						  'name' => sprintf(__('Avatar %d', 'onetone'),$t+1),
						  'id'   => "section_avatar_".$i."_".$t,
						  'std'  => $avatar[$t],
						  'desc' => __( 'Choose to upload image for the person avatar', 'onetone' ),
						  'type' => 'upload',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				
				$options[] = array(
						  'name' => sprintf(__('Link %d', 'onetone'),$t+1),
						  'id'   => "section_link_".$i."_".$t,
						  'std'  => '',
						  'desc' => __( 'Set link for the person', 'onetone' ),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				$options[] = array(
						  'name' => sprintf(__('Name %d', 'onetone'),$t+1),
						  'id'   => "section_name_".$i."_".$t,
						  'std'  => 'KEVIN PERRY',
						  'desc' => __( 'Set name for the person', 'onetone' ),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				$options[] = array(
						  'name' => sprintf(__('Byline %d', 'onetone'),$t+1),
						  'id'   => "section_byline_".$i."_".$t,
						  'std'  => 'SOFTWARE DEVELOPER',
						  'desc' => __( 'Set byline for the person', 'onetone' ),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				$options[] = array(
						  'name' => sprintf(__('Description %d', 'onetone'),$t+1),
						  'id'   => "section_desc_".$i."_".$t,
						  'std'  => 'Vivamus congue justo eget diam interdum scelerisque. In hac habitasse platea dictumst.',
						  'desc' => __( 'Insert description for the person', 'onetone' ),
						  'type' => 'textarea',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				
				for($k=0;$k<4;$k++):
		
				$options[] = array(
					  'id' => 'section_icon_'.$i.'_'.$t.'_'.$k,
					  'name' => sprintf(__( 'Social Icon %d - %d', 'onetone' ),$t+1,$k+1),
					  'desc' => __( 'Choose social icon', 'onetone' ),
					  'type'    => 'text',
					  'std' => $social_icon[$k],
					  'class'=>'content-model-0 section-item accordion-group-section-'.$i
				  );
				$options[] = array(
					  'id' => 'section_icon_link_'.$i.'_'.$t.'_'.$k,
					  'name' => sprintf(__( 'Social Icon Link %d - %d', 'onetone' ),$t+1,$k+1),
					  'desc' => __( 'Insert link for the icon', 'onetone' ),
					  'type'    => 'text',
					  'std' => '#',
					  'class'=>'content-model-0 section-item accordion-group-section-'.$i
				  );
				  
				endfor;
				
	  
			}
			
			break;
			case "5": // Section About
			
			$options[] = array(
						  'name' => __('Left Content', 'onetone'),
						  'id'   => "section_left_content_".$i,
						  'std'  => '<h3>Biography</h3>
<p>Morbi rutrum, elit ac fermentum egestas, tortor ante vestibulum est, eget scelerisque nisl velit eget tellus. Fusce porta facilisis luctus. Integer neque dolor, rhoncus nec euismod eget, pharetra et tortor. Nulla id pulvinar nunc. Vestibulum auctor nisl vel lectus ullamcorper sed pellentesque dolor eleifend. Praesent lobortis magna vel diam mattis sagittis.Mauris porta odio eu risus scelerisque id facilisis ipsum dictum vitae volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pulvinar neque eu purus sollicitudin et sollicitudin dui ultricies. Maecenas cursus auctor tellus sit amet blandit. Maecenas a erat ac nibh molestie interdum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed lorem enim, ultricies sed sodales id, convallis molestie ipsum. Morbi eget dolor ligula. Vivamus accumsan rutrum nisi nec elementum. Pellentesque at nunc risus. Phasellus ullamcorper bibendum varius. Quisque quis ligula sit amet felis ornare porta. Aenean viverra lacus et mi elementum mollis. Praesent eu justo elit.</p>',
						  'desc' => __( 'Insert content for the left column, html tags allowed', 'onetone' ),
						  'type' => 'textarea',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			
			$options[] = array(
						  'name' => __('Right Content', 'onetone'),
						  'id'   => "section_right_content_".$i,
						  'std'  => '<h3>Personal Info</h3>
  <div>
    <ul class="magee-icon-list">
      <li><i class="fa fa-phone">&nbsp;</i> +1123 2456 689</li>
    </ul>
    <ul class="magee-icon-list">
      <li><i class="fa fa-map-marker">&nbsp;</i> 3301 Lorem Ipsum, Dolor Sit St</li>
    </ul>
    <ul class="magee-icon-list">
      <li><i class="fa fa-envelope-o">&nbsp;</i> admin@domain.com</a>.</li>
    </ul>
    <ul class="magee-icon-list">
      <li><i class="fa fa-internet-explorer">&nbsp;</i> <a href="#">Mageewp.com</a></li>
    </ul>
  </div>',
						  'desc' => __( 'Insert content for the right column, html tags allowed', 'onetone' ),
						  'type' => 'textarea',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			
			break;
			case "6": // Section Counter
			
	         $options[] = array(
						  'name' => __('Counter Title 1', 'onetone'),
						  'id'   => "counter_title_1_".$i,
						  'std'  => $onetone_old_version?'':'Themes',
						  'desc' => '',
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			 $options[] = array(
						  'name' => __('Counter Number 1', 'onetone'),
						  'id'   => "counter_number_1_".$i,
						  'std'  => $onetone_old_version?'':'200',
						  'desc' => '',
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			 
			 $options[] = array(
						  'name' => __('Counter Title 2', 'onetone'),
						  'id'   => "counter_title_2_".$i,
						  'std'  => $onetone_old_version?'':'Supporters',
						  'desc' => '',
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			 $options[] = array(
						  'name' => __('Counter Number 2', 'onetone'),
						  'id'   => "counter_number_2_".$i,
						  'std'  => $onetone_old_version?'':'98',
						  'desc' => '',
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			 
			 
			 $options[] = array(
						  'name' => __('Counter Title 3', 'onetone'),
						  'id'   => "counter_title_3_".$i,
						  'std'  => $onetone_old_version?'':'Projuects',
						  'desc' => '',
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			 $options[] = array(
						  'name' => __('Counter Number 3', 'onetone'),
						  'id'   => "counter_number_3_".$i,
						  'std'  => $onetone_old_version?'':'1360',
						  'desc' => '',
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			 
			 $options[] = array(
						  'name' => __('Counter Title 4', 'onetone'),
						  'id'   => "counter_title_4_".$i,
						  'std'  => $onetone_old_version?'':'Customers',
						  'desc' => '',
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			 $options[] = array(
						  'name' => __('Counter Number 4', 'onetone'),
						  'id'   => "counter_number_4_".$i,
						  'std'  => $onetone_old_version?'':'8000',
						  'desc' => '',
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			 
			break;
			case "7": // Section  Testimonial
			
			$avatar = array(
							esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/person-8-thumbnail.jpg'),
							esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/person-7-thumbnail.jpg'),
							esc_url('https://demo.mageewp.com/wootest/wp-content/uploads/sites/31/2016/11/person-6-thumbnail.jpg'),
							'',
							'',
							'',
							'',
							''
							);
			
			$options[] = array(
						  'id' => "section_testimonial_columns",
						  'name' => __( 'Columns', 'onetone' ),
						  'desc' => __( 'Set columns for testimonial module', 'onetone' ),
						  'type'    => 'select',
						  'options' => array(1=>1,2=>2,3=>3,4=>4),
						  'std' => '3',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
					  );
			
			$options[] = array(
						  'id' => "section_testimonial_style",
						  'name' => __( 'Style', 'onetone' ),
						  'desc' => '',
						  'type'    => 'select',
						  'options' => array(0=> __('Normal', 'onetone'),1=>__('Carousel', 'onetone') ),
						  'std' => '4',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
					  );
			
			for( $t=0; $t<8; $t++ ){
				$description = '';
				
				if( $t<3 )
				$description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat non ex quis consectetur. Aliquam iaculis dolor erat, ut ornare dui vulputate nec. Cras a sem mattis, tincidunt urna nec, iaculis nisl. Nam congue ultricies dui.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat non ex quis consectetur. Aliquam iaculis dolor erat, ut ornare dui vulputate nec. Cras a sem mattis, tincidunt urna nec, iaculis nisl. Nam congue ultricies dui.';
				
				$options[] = array(
						  'name' => sprintf(__('Avatar %d', 'onetone'),$t+1),
						  'id'   => "section_avatar_".$i."_".$t,
						  'std'  => $avatar[$t],
						  'desc' => __( 'Choose to upload image for the client avatar', 'onetone' ),
						  'type' => 'upload',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				
				$options[] = array(
						  'name' => sprintf(__('Name %d', 'onetone'),$t+1),
						  'id'   => "section_name_".$i."_".$t,
						  'std'  => 'KEVIN PERRY',
						  'desc' => __( 'Insert name for the client', 'onetone' ),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				$options[] = array(
						  'name' => sprintf(__('Byline %d', 'onetone'),$t+1),
						  'id'   => "section_byline_".$i."_".$t,
						  'std'  => 'Web Developer',
						  'desc' => __( 'Insert byline for the client', 'onetone' ),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
				$options[] = array(
						  'name' => sprintf(__('Description %d', 'onetone'),$t+1),
						  'id'   => "section_desc_".$i."_".$t,
						  'std'  => $description,
						  'desc' => __( 'Insert description for the client', 'onetone' ),
						  'type' => 'textarea',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			}
			
			break;
			case "8": // Section Contact
			$emailTo = get_option('admin_email');
			$options[] = array(
						  'name' => __('Your E-mail', 'onetone'),
						  'id'   => "section_email_".$i,
						  'std'  => $emailTo,
						  'desc' => __( 'Set email address to receive mails from contact form', 'onetone' ),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			
			$options[] = array(
						  'name' => __('Button Text', 'onetone'),
						  'id'   => "section_btn_text_".$i,
						  'std'  => 'Post',
						  'desc' => __('Insert text for the button', 'onetone'),
						  'type' => 'text',
						  'class'=>'content-model-0 section-item accordion-group-section-'.$i
						  );
			
			
			break;

			
		}
		
		
		$options[] = array(
		'name' => __('Section Content', 'onetone'),
		'id' => 'section_content_'.$i,
		'std' => '',
		'type' => 'editor',
		'class'=>'section-item content-model-1 accordion-group-section-'.$i
		);
						  

		$options[] = array('name' => '','id' => 'wrapper_end','type' => 'wrapper_end','class'=>'');
	
		$options[] = array('name' => '','id' => 'section_group_end_'.$i.'','type' => 'end_group');
		
		
		}
		
		$options[] = array('name' => '','id' => '','type' => 'wrapper_end','class'=>'');

 //END HOME PAGE SECTION
	
 // Slider
  $options[] = array(
		'icon' => 'fa-sliders',			   
		'name' => __('Slideshow', 'onetone'),
		'type' => 'heading');
  
  //HOME PAGE SLIDER
  $options[] = array('name' => __('Slideshow', 'onetone'),'id' => 'group_title','type' => 'title');
  
  $slide_img = array(
					 ONETONE_THEME_BASE_URL.'/images/banner-1.jpg',
					 ONETONE_THEME_BASE_URL.'/images/banner-2.jpg',
					 ONETONE_THEME_BASE_URL.'/images/banner-3.jpg',
					 ONETONE_THEME_BASE_URL.'/images/banner-4.jpg',
					 '',
					 '',
					 '',
					 '',
					 '',
					 '',
					 );  
  
  $slide_desc = array(
						 '<h1>The jQuery slider that just slides.</h1><p>No fancy effects or unnecessary markup.</p>',
						 
						 '<h1>Fluid, flexible, fantastically minimal.</h1><p>Use any HTML in your slides, extend with CSS. You have full control.</p>',
						 
						 '<h1>Open-source.</h1><p> Vestibulum auctor nisl vel lectus ullamcorper sed pellentesque dolor eleifend.</p>',
						 
						 '<h1>Uh, that\'s about it.</h1><p>I just wanted to show you another slide.</p>',
						 '',
						 '',
						 '',
						 '',
						 '',
						 '',
						 
						 );
  
  for( $s=1;$s<=10; $s++ ):
  
	$options[] = array('name' => '','id' => 'slide_'.$s.'_group','type' => 'start_group','class'=>'');
	$options[] =   	 array(
		'id'          => 'slide_titled_'.$s.'',
		'name'       => sprintf(__('Slide %d', 'onetone'),$s).' <span id="accordion-group-slide-'.$s.'" class="fa fa-plus"></span>',
		'desc'        => '',
		'std'         => '',
		'type'        => 'textblock-titled',
		'rows'        => '',
		'class'       => 'section-accordion close',
  
  );
  
	$options[] = array('name' => '','id' => 'wrapper_start','type' => 'wrapper_start','class'=>'');	
  
	$options[] = array(
		'name' => __('Image', 'onetone'),
		'id' => 'onetone_slide_image_'.$s.'',
		'type' => 'upload',
		'std'=> isset($slide_img[$s-1])?$slide_img[$s-1]:'',
		'class'=>'slide-item  accordion-group-slide-'.$s.''
		);

	$options[] = array(
		'name' => __('Caption', 'onetone'),
		'id' => 'onetone_slide_text_'.$s.'',
		'type' => 'editor',
		'std'=> isset($slide_desc[$s-1])?$slide_desc[$s-1]:'',
		'class'=>'slide-item  accordion-group-slide-'.$s.''
		);
  
	$options[] = array(
		'name' => __('Button Text', 'onetone'),
		'id' => 'onetone_slide_btn_txt_'.$s.'',
		'std' => $onetone_old_version == true?'':__('Click Me', 'onetone'),
		'desc'=> '',
		'type' => 'text');	
  
	$options[] = array(
		'name' => __('Button Link', 'onetone'),
		'id' => 'onetone_slide_btn_link_'.$s.'',
		'std' => '#',
		'desc'=> '',
		'type' => 'text');	
  
	$options[] = array(
		'name' => __('Button Link Target', 'onetone'),
		'id' => 'onetone_slide_btn_target_'.$s.'',
		'std' => '_self',
		'desc'=> '',
		'options' => $target,
		'type' => 'select');	
  
  
	$options[] = array('name' => '','id' => 'wrapper_end','type' => 'wrapper_end','class'=>'');
	$options[] = array('name' => '','id' => 'slide_'.$s.'_group_','type' => 'end_group','class'=>'');
  
  endfor;
  
	$options[] =  array(
		'id'          => 'slide_autoplay',
		'name'       => __( 'Autoplay', 'onetone' ),
		'desc'       => __('Enable slider autoplay.', 'onetone' ),
		'std'         => '1',
		'type'        => 'checkbox',
		'class'       => '',
		);
	
	$options[] = array(
		'name' => __('Autoplay Timeout', 'onetone'),
		'id' => 'slide_time',
		'std' => '5000',
		'desc'=>__('Milliseconds between the end of the sliding effect and the start of the nex one.','onetone'),
		'type' => 'text');	
  
	$options[] =  array(
		'id'          => 'slider_control',
		'name'       => __( 'Display Control', 'onetone' ),
		'desc'       => __( 'Display control.', 'onetone' ),
		'std'         => '1',
		'type'        => 'checkbox',
		'class'       => '',
		);
  
	$options[] =  array(
		'id'          => 'slider_pagination',
		'name'       => __( 'Display Pagination', 'onetone' ),
		'desc'       => __( 'Display pagination.', 'onetone' ),
		'std'         => '1',
		'type'        => 'checkbox',
		'class'       => '',
		);
  
	$options[] =  array(
		'id'          => 'slide_fullheight',
		'name'       => __( 'Full Height', 'onetone' ),
		'desc'       => __( 'Full screen height for desktop.', 'onetone' ),
		'std'         => '',
		'type'        => 'checkbox',
		'class'       => '',
		);
	   
  //END HOME PAGE SLIDER
		  
  // About Onetone
	$options[] = array(
		'icon' => 'fa-file-o',
		'name' => __('About Onetone', 'onetone'),
		'type' => 'heading');
  
	$options[] =   	 array(
		'id'          => 'about-onetone',
		'name'       => __('About Onetone', 'onetone'),
		'desc'        => '',
		'std'         => '',
		'type'        => 'textblock-titled',
		'rows'        => '',
		'class'       => 'sub_section_titled',
					);
	$options[] = array(
		'name' => '',
		'desc' => '<div class="onetone-desc">'.__('Based on Bootstrap and coded with HTML5 and CSS3 language, Onetone is fully responsive in desktops and mobile devices. With enriched settings in theme options , you can not only change header and footer patterns, but also customize background colors, page layouts and social links, etc. Read below for additional information about Onetone.', 'onetone').'</div>
					
					<div class="theme-support"><div class="col-1-3">
<h4>'.__('Documentation', 'onetone').'</h4>
<p>'.__('The online documentaiton for Onetone is an incredible resource for learning how to use Onetone. You could follow this manual step by step to build your site.', 'onetone').'</p>
<a class="button" href="'.esc_url('https://www.mageewp.com/manuals/theme-guide-onetone.html').'" target="_blank">'.__('Documentation', 'onetone').'</a>
</div>
<div class="col-1-3">
<h4>'.__('Support Forum', 'onetone').'</h4><p>'.__('We also have a support forum for users to communicate. If you have any problem while using this theme, feel free to post in the forum. Our support team would reply you asap.', 'onetone').'</p>
<a class="button" href="'.esc_url('https://www.mageewp.com/forums/onetone/').'" target="_blank">'.__('Support Forum', 'onetone').'</a>  
</div>
<div class="col-1-3 last">
<h4>'.__('Theme Center', 'onetone').'</h4><p>'.__('Like our themes? Come here to get more.', 'onetone').'</p>
<a class="button" href="'.esc_url('https://www.mageewp.com/wordpress-themes').'" target="_blank">'.__('Theme Center', 'onetone').'</a>
</div></div>',
		'id' => 'about_onetone',
		'std' => '',
		'type' => 'info',
		'class'=>'',
		);
  
  // Options Backup
	$options[] = array(
		'icon' => 'fa-files-o',
		'name' => __('Options Backup', 'onetone'),
		'type' => 'heading');
  
	$options[] =   	 array(
		'id'          => 'options-backup',
		'name'       => __('Options Backup', 'onetone'),
		'desc'        => '',
		'std'         => '',
		'type'        => 'textblock-titled',
		'rows'        => '',
		'class'       => 'sub_section_titled',
		);
  
  
  $backup_list      = get_option('onetone_options_backup');
  $backup_list_html = '';
  if( is_array($backup_list) && $backup_list != NULL )
  {
	  foreach( $backup_list as $backup_item ){
		  
		  $backup_list      = get_option('onetone_options_backup_'.$backup_item);
		  $backup_list_html .= '<tr id="tr-'.$backup_item.'">
  <td style="padding-left:20px;"> '.__('Backup', 'onetone').' '.date('Y-m-d H:i:s',$backup_item).'</td>
  <td><a class="button" id="onetone-restore-btn" data-key="'.$backup_item.'" href="#"><i class="fa fa-refresh"></i> '.__('Restore', 'onetone').'</a></td>
  <td><a class="button" id="onetone-delete-btn" data-key="'.$backup_item.'" href="#"><i class="fa fa-remove"></i> '.__('Delete', 'onetone').'</a></td>
  </tr>';
		  }
	  
	  }
  
  $options[] = array(
		'name' => '',
		'desc' => '<div class="onetone-desc"> <a class="button" id="onetone-backup-btn" href="#">'.__('Create New Backup', 'onetone').'</a> <span style=" padding-left:20px; display:none; color:green;" class="onetone-backup-complete">'.__('Theme options have been backuped.', 'onetone').'</span></div>
					  <table width="100%" border="1" id="onetone-backup-lists" style=" margin-top:50px;">
					'.$backup_list_html.'   </table>',
		'id' => 'options_backup',
		'std' => '',
		'type' => 'info',
		'class'=>'',
		);  
  
  //Notice
	$options[] = array(
		'icon' => 'fa-gear',
		'name' => __('Styling', 'onetone'),
		'type' => 'heading'
		);
	$notice  = '';
	$dismiss = get_option('_onetone_options_dismiss');
	if( $dismiss != '1' )
	$notice  = '<div class="options-to-customise notice notice-warning is-dismissible" style="display:block !important;">
	        <p>'.sprintf(__( 'Styling Options have been migrated to <a href="%s">customize</a>.', 'onetone' ), admin_url('customize.php')).'</p></div>';
	
	$options[] = array(
		'name' => '',
		'desc' => '<div class="onetone-notice">'.$notice.'<p><a href="'.admin_url('customize.php').'"><img src="'.ONETONE_THEME_BASE_URL.'/images/options-to-customise.jpg" /></a></p>
			</div>',
		'id' => 'notice_onetone',
		'std' => '',
		'type' => 'info',
		'class'=>'',
		);
	
	  return $options;
  }
  endif;