<?php 
/**
 * Theme Customizer Data
 */
add_filter( 'onetone_customizer_data', 'onetone_standard_settings_data' );
function onetone_standard_settings_data( $onetone_options = array() ) {
	global $social_icons, 
	$onetone_option_name,
	$sidebars,
	$onetone_options_saved,
	$onetone_home_sections,
	$onetone_default_options,
	$onetone_customize_options;

	$option_name	= $onetone_option_name;
	
	$repeat = array( 
		'repeat'     => __( 'Repeat', 'onetone' ),
		'repeat-x'   => __( 'Repeat X', 'onetone' ),
		'repeat-y'   => __( 'Repeat Y', 'onetone' ),
		'no-repeat'  => __( 'No Repeat', 'onetone' )
			
		);
	
	$choices =  array( 
          
		'yes' => __( 'Yes', 'onetone' ),
		'no'  => __( 'No', 'onetone' )
 
        );
	
	$target = array(
		'_blank' => __( 'Blank', 'onetone' ),
		'_self'  => __( 'Self', 'onetone' )
		);
	
	$align =  array( 
          ''        => __( 'Default', 'onetone' ),
          'left'    => __( 'Left', 'onetone' ),
          'right'   => __( 'Right', 'onetone' ),
          'center'  => __( 'Center', 'onetone' )         
        );
	
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
	
	$os_fonts        = onetone_options_typography_get_os_fonts();	
	$os_fonts        = array_merge( array('' => __( '-- Default --', 'onetone' ) ), $os_fonts);
	$opacity         = array_combine(range(0,1,0.1), range(0,1,0.1));
    $font_size       = array_combine(range(0,100,1), range(0,100,1));
	
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

	$options[] = array(
		'slug'		=> 'onetone_general_option',
		'label'		=> __( 'Onetone: General Options', 'onetone' ),
		'priority'	=> 1,
		'type' 		=> 'panel'
		);

	
	// Tracking
	$options[] = array(
		'slug'		=> 'onetone_tracking_options',
		'label'		=> __( 'Tracking', 'onetone' ),
		'panel' 	=> 'onetone_general_option',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
	
	
	$options[] =  array(
        'slug'          => $option_name.'[tracking_code]',
        'label'       => __( 'Tracking Code', 'onetone' ),
        'description' => __( 'Paste your Google Analytics (or other) tracking code here. This will be added into the header template of your theme. Please put code inside script tags.', 'onetone' ),
        'default'         => '',
        'type'        => 'textarea',
        'section'     => 'onetone_tracking_options',
        'class'       => '',
        
      );
	 
	 $options[] =  array(
        'slug'          => $option_name.'[space_before_head]',
        'label'       => __( 'Space before &lt;/head&gt;', 'onetone' ),
        'description' => __( 'Add code before the head tag.', 'onetone' ),
        'default'         => '',
        'type'        => 'textarea',
        'section'     => 'onetone_tracking_options',
        'class'       => '',
        
      );
	 
	 $options[] =  array(
        'slug'          => $option_name.'[space_before_body]',
        'label'       => __( 'Space before &lt;/body&gt;', 'onetone' ),
        'description' => __( 'Add code before the body tag.', 'onetone' ),
        'default'         => '',
        'type'        => 'textarea',
        'section'     => 'onetone_tracking_options',
        'class'       => '',
        
      );

	 // 404
	$options[] = array(
		'slug'		=> 'onetone_404_page',
		'label'		=> __( '404 page', 'onetone' ),
		'panel' 	=> 'onetone_general_option',
		'priority'	=> 3,
		'type' 		=> 'section'
		);
 
	$options[] = array(
  
	'label' => __('404 page content', 'onetone'),
	'description' => '',
	'slug' => $option_name.'[content_404]',
	'default' => '<h2>WHOOPS!</h2><p>THERE IS NOTHING HERE.<br>PERHAPS YOU WERE GIVEN THE WRONG URL?</p>',
	'type' => 'textarea',
	'section'     => 'onetone_404_page',
	);
  
	// Blog
	$options[] = array(
		'slug'		=> 'onetone_blog',
		'label'		=> __( 'Blog', 'onetone' ),
		'panel' 	=> 'onetone_general_option',
		'priority'	=> 4,
		'type' 		=> 'section'
		);


	$options[] =  array(
		'slug'          => $option_name.'[archive_content]',
		'name'       => __( 'Blog Archive List Content', 'onetone' ),
		'description'        => __('Choose to display full content or excerpt in blog archive pages', 'onetone'),
		'default'         => 'excerpt',
		'type'        => 'select',
		'section'     => 'onetone_blog',
		'choices'     => array(
			'content' =>  __( 'Content', 'onetone' ),
			'excerpt' =>  __( 'Excerpt', 'onetone' ),
			)
		);
	
	
	$options[] =  array(
		  'slug'          => $option_name.'[excerpt_length]',
		 'label'       => __( 'Excerpt Length', 'onetone' ),
		  'description'        => '',
		  'default'         => '55',
		  'type'        => 'text',
		  'section'     => 'onetone_blog',
	);
  


	$options[] =  array(
		'slug'        => $option_name.'[display_author_info]',
		'label'       => __( 'Display Author Info?', 'onetone' ),
		'description' => __('Display author info on single page.', 'onetone'),
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_blog',
				  
		);
	
	$options[] =  array(
		'slug'        => $option_name.'[display_related_posts]',
		'label'       => __( 'Display Related Posts?', 'onetone' ),
		'description' => __('Display related posts on single page.', 'onetone'),
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_blog',
				  
		);
	
	$options[] = array(
		'slug'		=> 'onetone_layout_options',
		'label'		=> __( 'Layout Options', 'onetone' ),
		'panel' 	=> 'onetone_general_option',
		'priority'	=> 5,
		'type' 		=> 'section'
		);
  
	$options[] =  array(
		  'slug'          => $option_name.'[page_content_top_padding]',
		 'label'       => __( 'Page Content Top Padding', 'onetone' ),
		  'description'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '55px',
		  'type'        => 'text',
		  'section'     => 'onetone_layout_options',
	);
	$options[] =  array(
		  'slug'          => $option_name.'[page_content_bottom_padding]',
		 'label'       => __( 'Page Content Bottom Padding', 'onetone' ),
		  'description'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '40px',
		  'type'        => 'text',
		  'section'     => 'onetone_layout_options',
	);
	$options[] =  array(
		  'slug'          => $option_name.'[hundredp_padding]',
		 'label'       => __( '100% Width Left/Right Padding ###', 'onetone' ),
		  'description'        => __( 'This option controls the left/right padding for page content when using 100% site width or 100% width page template. In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '20px',
		  'type'        => 'text',
		  'section'     => 'onetone_layout_options',
	);
	$options[] =  array(
		  'slug'          => $option_name.'[sidebar_padding]',
		 'label'       => __( 'Sidebar Padding', 'onetone' ),
		  'description'        => __( 'Enter a pixel or percentage based value, ex: 5px or 5%', 'onetone' ),
		  'default'         => '0',
		  'type'        => 'text',
		  'section'     => 'onetone_layout_options',
	);
	$options[] =  array(
		  'slug'          => $option_name.'[column_top_margin]',
		 'label'       => __( 'Column Top Margin', 'onetone' ),
		  'description'        => __( 'Controls the top margin for all column sizes. In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '0px',
		  'type'        => 'text',
		  'section'     => 'onetone_layout_options',
	);
	$options[] =  array(
		  'slug'          => $option_name.'[column_bottom_margin]',
		 'label'       => __( 'Column Bottom Margin', 'onetone' ),
		  'description'        => __( 'Controls the bottom margin for all column sizes. In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '20px',
		  'type'        => 'text',
		  'section'     => 'onetone_layout_options',
	);
	// Additional
	$options[] = array(
		'slug'		=> 'onetone_general_options',
		'label'		=> __( 'Additional', 'onetone' ),
		'panel' 	=> 'onetone_general_option',
		'priority'	=> 6,
		'type' 		=> 'section'
		);
	
	$options[] = array( 
		'slug'		=> $option_name.'[back_to_top_btn]', 
		'default'	=> 'show', 
		'priority'	=> 1, 
		'label'		=> __( 'Back to Top Button', 'onetone' ),
		'section'	=> 'onetone_general_options',
		'property'	=> '',
		'type' 		=> 'select',
		'choices'  =>array("show"=> __('Show', 'onetone'),"hide"=>__('Hide', 'onetone')),
		);
	
	$options[] = array(
		'label' => __('Custom CSS', 'onetone'),
		'priority'	=> 2, 
		'description' => __('The following css code will add to the header before the closing &lt;/head&gt; tag.', 'onetone'),
		'slug'   => $option_name.'[custom_css]',
		'default'  => 'body{margin:0px;}',
		'type' => 'textarea',
		'section'	=> 'onetone_general_options',
		);
	
	 
	$options[] = array(
		'slug'		=> 'onetone_header',
		'label'		=> __( 'Onetone: Header', 'onetone' ),
		'priority'	=> 2,
		'type' 		=> 'panel'
	);
	
	// Top Bar Options 
	
	$options[] = array(
		'slug'		=> 'onetone_top_bar_options',
		'label'		=> __( 'Top Bar Options', 'onetone' ),
		'panel' 	=> 'onetone_header',
		'priority'	=> 1,
		'type' 		=> 'section'
		);
	
	$options[] = array(
        'slug'          => $option_name.'[display_top_bar]',
        'label'        => __( 'Display Top Bar', 'onetone' ),
        'description'        => __( 'Choose to display top bar above the header', 'onetone' ),
        'default'         => 'yes',
        'type'        => 'select',
        'section'     => 'onetone_top_bar_options',
        'choices'     => $choices
      );
	$options[] = array(
        'slug'          => $option_name.'[top_bar_background_color]',
        'label'        => __( 'Background Color', 'onetone' ),
        'description'        => __( 'Set background color for top bar', 'onetone' ),
        'default'         => '#eee',
        'type'        => 'color',
        'section'     => 'onetone_top_bar_options',
        
      );
	
	$options[] =  array(
        'slug'          => $option_name.'[top_bar_left_content]',
        'label'        => __( 'Left Content', 'onetone' ),
        'description'        => __( 'Choose content in left side', 'onetone' ),
        'default'         => 'info',
        'type'        => 'select',
        'section'     => 'onetone_top_bar_options',
        'choices'     => array( 
			'info'      => __( 'Info', 'onetone' ),
			'sns'       => __( 'SNS', 'onetone' ),
			'menu'      => __( 'Menu', 'onetone' ),
			'none'      => __( 'None', 'onetone' ),
           
        )
      );
	
	$options[] = array(
        'slug'          => $option_name.'[top_bar_right_content]',
        'label'        => __( 'Right Content', 'onetone' ),
        'description'        => __( 'Choose content in right side', 'onetone' ),
        'default'         => 'sns',
        'type'        => 'select',
        'section'     => 'onetone_top_bar_options',
        'choices'     => array( 
			'info'      => __( 'Info', 'onetone' ),
			'sns'       => __( 'SNS', 'onetone' ),
			'menu'      => __( 'Menu', 'onetone' ),
			'none'      => __( 'None', 'onetone' ),
        ),
	
      );	
	
	$options[] = array(
        'slug'          => $option_name.'[top_bar_info_color]',
        'label'        => __( 'Info Color', 'onetone' ),
        'description'        => __( 'Set color for info in top bar', 'onetone' ),
        'default'         => '#555',
        'type'        => 'color',
        'section'     => 'onetone_top_bar_options',
        
      );
	$options[] = 	array(
        'slug'          => $option_name.'[top_bar_info_content]',
        'label'        => __( 'Info Content', 'onetone' ),
        'description'        => __( 'Insert content for info in top bar', 'onetone' ),
        'default'         => 'Tel: 123456789',
        'type'        => 'textarea',
        'section'     => 'onetone_top_bar_options',
        
      );
	
	$options[] = array(
        'slug'          => $option_name.'[top_bar_menu_color]',
        'label'        => __( 'Menu Color', 'onetone' ),
        'description'        => __( 'Set color for menu in top bar', 'onetone' ),
        'default'         => '#555',
        'type'        => 'color',
        'section'     => 'onetone_top_bar_options',
        
      );
				
	$options[] = array(
		'slug'          => $option_name.'[social_links]',
		'label'        => __( 'Social Links', 'onetone' ),
		'description'        => '',
		'default'         => '',
		'type'        => 'textblock-titled',
		'section'     => 'onetone_top_bar_options',
			
			);
			
	$options[] =  array(
        'slug'          => $option_name.'[top_bar_social_icons_color]',
        'label'       => __( 'Social Icons Color', 'onetone' ),
        'description'        => '',
        'default'         => '',
        'type'        => 'color',
        'section'     => 'onetone_top_bar_options',
        
      );
	$options[] = array(
		'slug'          => $option_name.'[top_bar_social_icons_tooltip_position]',
		'label'       => __( 'Social Icon Tooltip Position', 'onetone' ),
		'description'        => '',
		'default'         => 'bottom',
		'type'        => 'select',
		'section'     => 'onetone_top_bar_options',
		'choices'     => array( 
			'left'     => __( 'left', 'onetone' ),
			'right'     => __( 'right', 'onetone' ),
			'bottom'     => __( 'bottom', 'onetone' ),
			 
		),
	  
		);			
 if( $social_icons ):
  $i = 1;
  
 foreach($social_icons as $social_icon){
	
	$options[] =  array(
        'slug'          => $option_name.'[header_social_title_'.$i.']',
        'label'        => __( 'Social Title', 'onetone' ) .' '.$i,
        'description'        => __( 'Set title for social icon', 'onetone' ),
        'default'         => $social_icon['title'],
        'type'        => 'text',
        'section'     => 'onetone_top_bar_options',
        
      );
	$options[] = array(
        'slug'          => $option_name.'[header_social_icon_'.$i.']',
        'label'       => __( 'Social Icon', 'onetone' ).' '.$i,
        'description'        => __( 'Choose FontAwesome Icon', 'onetone' ),
        'default'         => $social_icon['icon'],
        'type'        => 'text',
        'section'     => 'onetone_top_bar_options',
        
      );
	$options[] = array(
        'slug'          => $option_name.'[header_social_link_'.$i.']',
        'label'       => __( 'Social Icon Link', 'onetone' ).' '.$i,
        'description' => __( 'Set link for social icon', 'onetone' ),
        'default'         => $social_icon['link'],
        'type'        => 'text',
        'section'     => 'onetone_top_bar_options',
        
      );

	 $i++;
	 }
	endif;	
	
	
	 // Logo
	$options[] = array(
		'slug'		=> 'onetone_logo',
		'label'		=> __( 'Logo', 'onetone' ),
		'panel' 	=> 'onetone_header',
		'priority'	=> 3,
		'type' 		=> 'section'
		);
	  
	$options[] = array(
		'slug'          => $option_name.'[logo]',
		'label'       => __( 'Upload Logo', 'onetone' ),
		'description'        => __( 'Select an image file for your logo.', 'onetone' ),
		'default'         => ONETONE_THEME_BASE_URL.'/images/logo.png',
		'type'        => 'images',
		'section'     => 'onetone_logo',
		);
  
	$options[] = array(
        'slug'          => $option_name.'[overlay_logo]',
        'label'       => __( 'Upload Overlay Header Logo', 'onetone' ),
        'description'        => __( 'Select an image file for your logo.', 'onetone' ),
        'default'         => ONETONE_THEME_BASE_URL.'/images/overlay-logo.png',
        'type'        => 'images',
        'section'     => 'onetone_logo',
      );
	  
	$options[] =  array(
		'slug'          => $option_name.'[logo_retina]',
		'label'       => __( 'Upload Logo (Retina Version @2x)', 'onetone' ),
		'description'        => __( 'Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', 'onetone' ),
		'default'         => '',
		'type'        => 'images',
		'section'     => 'onetone_logo',
		
		);
	$options[] = array(
		'slug'          => $option_name.'[retina_logo_width]',
		'label'       => __( 'Standard Logo Width for Retina Logo', 'onetone' ),
		'description'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version width, do not enter the retina logo width. Use a number without \'px\', ex: 40', 'onetone' ),
		'default'         => '',
		'type'        => 'text',
		'section'     => 'onetone_logo',
		
		);
  
	$options[] =  array(
		'slug'          => $option_name.'[retina_logo_height]',
		'label'       => __( 'Standard Logo Height for Retina Logo', 'onetone' ),
		'description'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version height, do not enter the retina logo height. Use a number without \'px\', ex: 40', 'onetone' ),
		'default'         => '',
		'type'        => 'text',
		'section'     => 'onetone_logo',
		
		);
	
	 // Sticky Header Logo
	
	$options[] = array(
		'slug'		=> 'onetone_sticky_header_logo',
		'label'		=> __( 'Sticky Header Logo', 'onetone' ),
		'panel' 	=> 'onetone_header',
		'priority'	=> 4,
		'type' 		=> 'section'
		);
	
	$options[] = array(
		'slug'          => $option_name.'[sticky_logo]',
		'label'       => __( 'Upload Logo', 'onetone' ),
		'description'        => __( 'Select an image file for your logo.', 'onetone' ),
		'default'         => ONETONE_THEME_BASE_URL.'/images/logo.png',
		'type'        => 'images',
		'section'     => 'onetone_sticky_header_logo',
		
		);
	  
	$options[] =  array(
		'slug'          => $option_name.'[sticky_logo_retina]',
		'label'       => __( 'Upload Logo (Retina Version @2x)', 'onetone' ),
		'description'        => __( 'Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', 'onetone' ),
		'default'         => '',
		'type'        => 'images',
		'section'     => 'onetone_sticky_header_logo',
		
		);
	
	$options[] = array(
		'slug'          => $option_name.'[sticky_logo_width_for_retina_logo]',
		'label'       => __( 'Sticky Logo Width for Retina Logo', 'onetone' ),
		'description'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version width, do not enter the retina logo width. Use a number without \'px\', ex: 40', 'onetone' ),
  
		'default'         => '',
		'type'        => 'text',
		'section'     => 'onetone_sticky_header_logo',
		
		);
	
	$options[] = array(
		'slug'          => $option_name.'[sticky_logo_height_for_retina_logo]',
		'label'       => __( 'Sticky Logo Height for Retina Logo', 'onetone' ),
		'description'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version height, do not enter the retina logo height. Use a number without \'px\', ex: 40', 'onetone' ),
		'default'         => '',
		'type'        => 'text',
		'section'     => 'onetone_sticky_header_logo',
		
		);
  
   // Logo Options
	
	$options[] = array(
		'slug'		=> 'onetone_logo_options',
		'label'		=> __( 'Logo Options', 'onetone' ),
		'panel' 	=> 'onetone_header',
		'priority'	=> 5,
		'type' 		=> 'section'
		);
	
	$options[] =  array(
		  'slug'          => $option_name.'[logo_position]',
		  'label'       => __( 'Logo Position', 'onetone' ),
		  'description'       => __( 'Set position for logo in header', 'onetone' ),
		  'default'         => 'left',
		  'type'        => 'select',
		  'section'     => 'onetone_logo_options',
		  'choices'     => $align
		);
  
	$options[] =  array(
		  'slug'          => $option_name.'[logo_left_margin]',
		  'label'       => __( 'Logo Left Margin', 'onetone' ),
		  'description'        => __( 'Use a number without \'px\', ex: 40', 'onetone' ),
		  'default'         => '0',
		  'type'        => 'text',
		  'section'     => 'onetone_logo_options',
		  
		);
	$options[] = array(
		  'slug'          => $option_name.'[logo_right_margin]',
		  'label'       => __( 'Logo Right Margin', 'onetone' ),
		  'description'        => __( 'Use a number without \'px\', ex: 40', 'onetone' ),
		  'default'         => '10',
		  'type'        => 'text',
		  'section'     => 'onetone_logo_options',
		  
		);
	$options[] = array(
		  'slug'          => $option_name.'[logo_top_margin]',
		  'label'       => __( 'Logo Top Margin', 'onetone' ),
		  'description'        => __( 'Use a number without \'px\', ex: 40', 'onetone' ),
		  'default'         => '10',
		  'type'        => 'text',
		  'section'     => 'onetone_logo_options',
		  
		);
	$options[] = array(
		  'slug'          => $option_name.'[logo_bottom_margin]',
		  'label'       => __( 'Logo Bottom Margin', 'onetone' ),
		  'description'        => __( 'Use a number without \'px\', ex: 40', 'onetone' ),
		  'default'         => '10',
		  'type'        => 'text',
		  'section'     => 'onetone_logo_options',
		  
		);
	 
	 // Header Options 
	$options[] = array(
		'slug'		=> 'onetone_header_option',
		'label'		=> __( 'Header Options', 'onetone' ),
		'panel' 	=> 'onetone_header',
		'priority'	=> 6,
		'type' 		=> 'section'
		);
	
	$options[] = array(
        'slug'        => $option_name.'[header_fullwidth]',
        'label'       => __( 'Full Width Header', 'onetone' ),
        'description' => __( 'Enable header full width.', 'onetone' ),
        'default'     => '',
        'type'        => 'checkbox',
        'section'     => 'onetone_header_option',
        
        );


	$options[] = array(
        'slug'        => $option_name.'[nav_hover_effect]',
        'label'       => __( 'Nav Hover Effect', 'onetone' ),
        'description' => '',
        'default'     => '3',
        'type'        => 'image_select',
        'section'     => 'onetone_header_option',
        'choices'     => array(
							 '0'=> ONETONE_THEME_BASE_URL.'/images/nav-style0.gif',
							 '1'=> ONETONE_THEME_BASE_URL.'/images/nav-style1.gif',
							 '2'=> ONETONE_THEME_BASE_URL.'/images/nav-style2.gif',
							 '3'=> ONETONE_THEME_BASE_URL.'/images/nav-style3.gif',
							 )
      );
	
	// Header Background
	$options[] = array(
        'slug'        => $option_name.'[header_background_image]',
        'label'       => __( 'Header Background Image', 'onetone' ),
        'description' => __( 'Background Image For Header Area', 'onetone' ),
        'default'     => '',
        'type'        => 'images',
        'section'     => 'onetone_header_option',
        
      );
		
	$options[] = array(
        'slug'        => $option_name.'[header_background_full]',
        'label'       => __( '100% Background Image', 'onetone' ),
        'description' => __( 'Turn on to have the header background image display at 100% in width and height and scale according to the browser size.', 'onetone' ),
        'default'     => 'yes',
        'type'        => 'select',
        'section'     => 'onetone_header_option',
		'choices'     => $choices
      );
		
	$options[] = array(
        'slug'        => $option_name.'[header_background_parallax]',
        'label'       => __( 'Parallax Background Image', 'onetone' ),
        'description' => __( 'Turn on to enable parallax scrolling on the background image for header top positions.', 'onetone' ),
        'default'     => 'no',
        'type'        => 'select',
        'section'     => 'onetone_header_option',
		'choices'     => $choices
      );
		
	$options[] =  array(
        'slug'        => $option_name.'[header_background_repeat]',
        'label'       => __( 'Background Repeat', 'onetone' ),
        'description' => __( 'Select how the background image repeats.', 'onetone' ),
        'default'     => 'repeat',
        'type'        => 'select',
        'section'     => 'onetone_header_option',
        'choices'     => $repeat
      );
	$options[] =  array(
        'slug'        => $option_name.'[header_top_padding]',
        'label'       => __( 'Header Top Padding', 'onetone' ),
        'description' => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
        'default'     => '0px',
        'type'        => 'text',
        'section'     => 'onetone_header_option',
        
      );
	$options[] = array(
        'slug'        => $option_name.'[header_bottom_padding]',
        'label'       => __( 'Header Bottom Padding', 'onetone' ),
        'description' => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
        'default'     => '0px',
        'type'        => 'text',
        'section'     => 'onetone_header_option',
        
      );
	
	 //Sticky Header Options 

	$options[] = array(
		'slug'		=> 'onetone_sticky_header',
		'label'		=> __( 'Sticky Header', 'onetone' ),
		'panel' 	=> 'onetone_header',
		'priority'	=> 7,
		'type' 		=> 'section'
		);
	
	$options[] =  array(
		'slug'        => $option_name.'[enable_sticky_header]',
		'label'       => __( 'Enable Sticky Header', 'onetone' ),
		'description' => __( 'Choose to enable sticky header', 'onetone' ),
		'default'     => 'yes',
		'type'        => 'select',
		'section'     => 'onetone_sticky_header',
		'choices'     => $choices
		);
  $options[] = array(
		'slug'        => $option_name.'[enable_sticky_header_tablets]',
		'label'       => __( 'Enable Sticky Header on Tablets', 'onetone' ),
		'description' => __( 'Choose to enable sticky header on tablets', 'onetone' ),
		'default'     => 'no',
		'type'        => 'select',
		'section'     => 'onetone_sticky_header',
		'choices'     => $choices
		);
  $options[] = array(
		'slug'        => $option_name.'[enable_sticky_header_mobiles]',
		'label'       => __( 'Enable Sticky Header on Mobiles', 'onetone' ),
		'description' => __( 'Choose to enable sticky header on mobiles', 'onetone' ),
		'default'     => 'no',
		'type'        => 'select',
		'section'     => 'onetone_sticky_header',
		'choices'     => $choices
		);
  
  		
  $options[] = array(
		'slug'        => $option_name.'[sticky_header_menu_item_padding]',
		'label'       => __( 'Sticky Header Menu Item Padding', 'onetone' ),
		'description' => __( 'Controls the space between each menu item in the sticky header. Use a number without \'px\', default is 0. ex: 10', 'onetone' ),
		'default'     => '0',
		'type'        => 'text',
		'section'     => 'onetone_sticky_header',
		
		);
  $options[] = array(
		'slug'        => $option_name.'[sticky_header_navigation_font_size]',
		'label'       => __( 'Sticky Header Navigation Font Size', 'onetone' ),
		'description' => __( 'Controls the font size of the menu items in the sticky header. Use a number without \'px\', default is 14. ex: 14', 'onetone' ),
		'default'     => '13',
		'type'        => 'text',
		'section'     => 'onetone_sticky_header',
		
		);
  $options[] = array(
		'slug'        => $option_name.'[sticky_header_logo_width]',
		'label'       => __( 'Sticky Header Logo Width', 'onetone' ),
		'description' => __( 'Controls the logo width in the sticky header. Use a number without \'px\'.', 'onetone' ),
		'default'     => '',
		'type'        => 'text',
		'section'     => 'onetone_sticky_header',
		
		);
	
	

	$options[] = array(
		'slug'		=> 'onetone_page_title_bar',
		'label'		=> __( 'Onetone: Page Title Bar', 'onetone' ),
		'priority'	=> 5,
		'type' 		=> 'panel'
	);

  $options[] = array(
		'slug'		=> 'onetone_styling',
		'label'		=> __( 'Onetone: Styling', 'onetone' ),
		'priority'	=> 7,
		'type' 		=> 'panel'
	);

	$options[] = array(
		'slug'		=> 'onetone_styling_general',
		'label'		=> __( 'Primary Color', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 1,
		'type' 		=> 'section'
		);
	
 
  $options[] =  array(
		  'slug'          => $option_name.'[primary_color]',
		 'label'       => __( 'Primary Color', 'onetone' ),
		  'description'       => __( 'Set primary color for the theme', 'onetone' ),
		  'default'         => '#37cadd',
		  'type'        => 'color',
		  'section'     => 'onetone_styling_general',
		  
		);
  
    
	$options[] = array(
		'slug'		=> 'onetone_background_colors',
		'label'		=> __( 'Background Colors', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
	  
  $options[] =  array(
		  'slug'          => $option_name.'[sticky_header_background_color]',
		 'label'       => __( 'Sticky Header Background Color', 'onetone' ),
		  'description'       => __( 'Set background color for sticky header', 'onetone' ),
		  'default'         => '#ffffff',
		  'type'        => 'color',
		  'section'     => 'onetone_background_colors',
);
  $options[] = array(
		  'slug'          => $option_name.'[sticky_header_background_opacity]',
		 'label'       => __( 'Sticky Header Background Opacity', 'onetone' ),
		  'description'        => __( 'Opacity only works with header top position and ranges between 0 (transparent) and 1.', 'onetone' ),
		  'default'         => '0.7',
		  'type'        => 'select',
		  'section'     => 'onetone_background_colors',
		  'choices'     => $opacity,
);
  $options[] = array(
		  'slug'          => $option_name.'[header_background_color]',
		 'label'       => __( 'Header Background Color', 'onetone' ),
		  'description'       => __( 'Set background color for main header', 'onetone' ),
		  'default'         => '#ffffff',
		  'type'        => 'color',
		  'section'     => 'onetone_background_colors',
);
  $options[] = array(
		  'slug'          => $option_name.'[header_background_opacity]',
		 'label'       => __( 'Header Background Opacity', 'onetone' ),
		  'description'        => __( 'Opacity only works with header top position and ranges between 0 (transparent) and 1.', 'onetone' ),
		  'default'         => '1',
		  'type'        => 'select',
		  'section'     => 'onetone_background_colors',
		  'choices'     => $opacity,
);
  
  $options[] = array(
		  'slug'          => $option_name.'[content_background_color]',
		 'label'       => __( 'Content Background Color', 'onetone' ),
		  'description'       => __( 'Set background color for site content', 'onetone' ),
		  'default'         => '#ffffff',
		  'type'        => 'color',
		  'section'     => 'onetone_background_colors',
		  
		);
  
  $options[] = array(
		  'slug'          => $option_name.'[sidebar_background_color]',
		 'label'       => __( 'Sidebar Background Color', 'onetone' ),
		  'description'       => __( 'Set background color for sidebar', 'onetone' ),
		  'default'         => '#ffffff',
		  'type'        => 'color',
		  'section'     => 'onetone_background_colors',
);
  $options[] = array(
		  'slug'          => $option_name.'[footer_background_color]',
		 'label'       => __( 'Footer Background Color', 'onetone' ),
		  'description'       => __( 'Set background color for the footer', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_background_colors',
);
  
  $options[] = array(
		  'slug'          => $option_name.'[copyright_background_color]',
		 'label'       => __( 'Copyright Background Color', 'onetone' ),
		  'description'       => __( 'Set background color for the copyright area in footer', 'onetone' ),
		  'default'         => '#000000',
		  'type'        => 'color',
		  'section'     => 'onetone_background_colors',
);
  
  $options[] = array(
		'slug'		=> 'onetone_element_colors',
		'label'		=> __( 'Element Colors', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 3,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
		  'slug'          => $option_name.'[form_background_color]',
		 'label'       => __( 'Form Background Color', 'onetone' ),
		  'description'        => __( 'Controls the background color of form fields', 'onetone' ),
		  'default'         => '',
		  'type'        => 'color',
		  'section'     => 'onetone_element_colors',
);
  $options[] =  array(
		  'slug'          => $option_name.'[form_text_color]',
		 'label'       => __( 'Form Text Color', 'onetone' ),
		  'description'        => __( 'Controls the text color for forms', 'onetone' ),
		  'default'         => '#666666',
		  'type'        => 'color',
		  'section'     => 'onetone_element_colors',
);
  $options[] =  array(
		  'slug'          => $option_name.'[form_border_color]',
		 'label'       => __( 'Form Border Color', 'onetone' ),
		  'description'        => __( 'Controls the border color for forms', 'onetone' ),
		  'default'         => '#666666',
		  'type'        => 'color',
		  'section'     => 'onetone_element_colors',
);
  
    
  $options[] = array(
		'slug'		=> 'onetone_font_colors',
		'label'		=> __( 'Font Colors', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 4,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
        'slug'          => $option_name.'[fixed_header_text_color]',
       'label'       => __( 'Sticky Header Text Color', 'onetone' ),
        'description'       => __( 'Set color for tagline in fixed header', 'onetone' ),
        'default'         => '#333333',
        'type'        => 'color',
        'section'     => 'onetone_font_colors',
        
      );
 $options[] =  array(
        'slug'          => $option_name.'[overlay_header_text_color]',
       'label'       => __( 'Overlay Header Text Color', 'onetone' ),
        'description'       => __( 'Set color for tagline in overlay header', 'onetone' ),
        'default'         => '#ffffff',
        'type'        => 'color',
        'section'     => 'onetone_font_colors',
        
      );
 
  $options[] =  array(
		  'slug'          => $option_name.'[page_title_color',
		 'label'       => __( 'Page Title', 'onetone' ),
		  'description'       => __( 'Set color for page title', 'onetone' ),
		  'default'         => '#555555',
		 'type'        => 'color',
		  'section'     => 'onetone_font_colors',

		);
  
  $options[] =  array(
		  'slug'          => $option_name.'[h1_color]',
		 'label'       => __( 'Heading 1 (H1) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H1 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => $option_name.'[h2_color]',
		 'label'       => __( 'Heading 2 (H2) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H2 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => $option_name.'[h3_color]',
		 'label'       => __( 'Heading 3 (H3) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H3 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => $option_name.'[h4_color]',
		 'label'       => __( 'Heading 4 (H4) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H4 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => $option_name.'[h5_color]',
		 'label'       => __( 'Heading 5 (H5) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H5 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => $option_name.'[h6_color]',
		 'label'       => __( 'Heading 6 (H6) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H6 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
   
  $options[] =  array(
		  'slug'          => $option_name.'[body_text_color]',
		 'label'       => __( 'Body Text Color', 'onetone' ),
		  'description'       => __( 'Choose color for body text', 'onetone' ),
		  'default'         => '#333333',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => $option_name.'[links_color]',
		 'label'       => __( 'Links Color', 'onetone' ),
		  'description'       => __( 'Choose color for links', 'onetone' ),
		  'default'         => '#37cadd',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => $option_name.'[breadcrumbs_text_color]',
		 'label'       => __( 'Breadcrumbs Text Color', 'onetone' ),
		  'description'       => __( 'Choose color for breadcrumbs', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => $option_name.'[sidebar_widget_headings_color]',
		 'label'       => __( 'Sidebar Widget Headings Color', 'onetone' ),
		  'description'       => __( 'Choose color for Sidebar widget headings', 'onetone' ),
		  'default'         => '#333333',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] = array(
		  'slug'          => $option_name.'[footer_headings_color]',
		 'label'       => __( 'Footer Headings Color', 'onetone' ),
		  'description'       => __( 'Choose color for footer headings', 'onetone' ),
		  'default'         => '#ffffff',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] = array(
		  'slug'          => $option_name.'[footer_text_color]',
		 'label'       => __( 'Footer Text Color', 'onetone' ),
		  'description'       => __( 'Choose color for footer text', 'onetone' ),
		  'default'         => '#ffffff',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
		  
		);
  
  $options[] = array(
		  'slug'          => $option_name.'[footer_link_color]',
		 'label'       => __( 'Footer Link Color', 'onetone' ),
		  'description'       => __( 'Choose color for links in footer', 'onetone' ),
		  'default'         => '#a0a0a0',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  
  $options[] = array(
		'slug'		=> 'onetone_main_menu_colors',
		'label'		=> __( 'Main Menu Colors', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 5,
		'type' 		=> 'section'
		);
 
  $options[] =  array(
		  'slug'          => $option_name.'[main_menu_background_color_1]',
		 'label'       => __( 'Main Menu Background Color', 'onetone' ),
		  'description'       => __( 'Choose background color for main menu', 'onetone' ),
		  'default'         => '',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
  
  $options[] =  array(
		  'slug'          => $option_name.'[main_menu_font_color_1]',
		 'label'       => __( 'Main Menu Font Color ( First Level )', 'onetone' ),
		  'description'       => __( 'Choose font color for first level of main menu', 'onetone' ),
		  'default'         => '#3d3d3d',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
  
  $options[] =  array(
        'slug'          => $option_name.'[main_menu_overlay_font_color_1]',
       'label'       => __( 'Main Menu Font Color of Overlay Header ( First Level )', 'onetone' ),
        'description'       => __( 'Choose font color for first level of main menu', 'onetone' ),
        'default'         => '#ffffff',
        'type'        => 'color',
        'section'     => 'onetone_main_menu_colors',
 );
  
  $options[] =  array(
		'slug'          => $option_name.'[main_menu_font_hover_color_1]',
		'name'       => __( 'Main Menu Font Hover Color ( First Level )', 'onetone' ),
		'description'       => __( 'Choose hover color for first level of main menu', 'onetone' ),
		'default'         => '#3d3d3d',
		'type'        => 'color',
		'section'     => 'onetone_main_menu_colors',		
		);
  
  $options[] =  array(
		  'slug'          => $option_name.'[main_menu_background_color_2]',
		 'label'       => __( 'Main Menu Background Color ( Sub Level )', 'onetone' ),
		  'description'       => __( 'Choose background color for sub level of main menu', 'onetone' ),
		  'default'         => '#ffffff',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
	 
  $options[] =  array(
		  'slug'          => $option_name.'[main_menu_font_color_2]',
		 'label'       => __( 'Main Menu Font Color ( Sub Level )', 'onetone' ),
		  'description'       => __( 'Choose font color for sub level of main menu', 'onetone' ),
		  'default'         => '#3d3d3d',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
  
  $options[] =  array(
		  'slug'          => $option_name.'[main_menu_font_hover_color_2]',
		 'label'       => __( 'Main Menu Font Hover Color ( Sub Level )', 'onetone' ),
		  'description'       => __( 'Choose hover color for sub level of main menu', 'onetone' ),
		  'default'         => '#222222',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
  
  $options[] =  array(
		  'slug'          => $option_name.'[main_menu_separator_color_2]',
		 'label'       => __( 'Main Menu Separator Color ( Sub Levels )', 'onetone' ),
		  'description'       => __( 'Choose separator color for sub level of main menu', 'onetone' ),
		  'default'         => '#000000',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
  
  
  $options[] = array(
		'slug'		=> 'onetone_side_menu_colors',
		'label'		=> __( 'Front Page Side Navigation Color', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 5,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
		  'slug'          => $option_name.'[side_menu_color]',
		 'label'       => __( 'Side Navigation Color', 'onetone' ),
		  'description'       => __( 'Choose color for side navigation of front page.', 'onetone' ),
		  'default'         => '#37cadd',
		  'type'        => 'color',
		  'section'     => 'onetone_side_menu_colors',
);


	$options[] = array(
		'slug'		=> 'onetone_sidebar',
		'label'		=> __( 'Onetone: Sidebar', 'onetone' ),
		'priority'	=> 8,
		'type' 		=> 'panel'
	);

	$options[] = array(
		'slug'		=> 'onetone_sidebar_blog_posts',
		'label'		=> __( 'Blog Posts', 'onetone' ),
		'panel' 	=> 'onetone_sidebar',
		'priority'	=> 1,
		'type' 		=> 'section'
		);
   
  $options[] =  array(
		  'slug'          => $option_name.'[left_sidebar_blog_posts]',
		 'label'       => __( 'Left Sidebar', 'onetone' ),
		  'description'       => __( 'Choose left sidebar for blog posts', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_blog_posts',
		  'choices'     => $sidebars,
	  
		);
  $options[] =  array(
		  'slug'          => $option_name.'[right_sidebar_blog_posts]',
		 'label'       => __( 'Right Sidebar', 'onetone' ),
		  'description'       => __( 'Choose right sidebar for blog posts', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_blog_posts',
		  'choices'     => $sidebars,
	  
		);
  

	$options[] = array(
		'slug'		=> 'onetone_sidebar_blog_archive',
		'label'		=> __( 'Blog Archive / Category Pages', 'onetone' ),
		'panel' 	=> 'onetone_sidebar',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
		  'slug'          => $option_name.'[left_sidebar_blog_archive]',
		 'label'       => __( 'Left Sidebar', 'onetone' ),
		  'description'       => __( 'Choose left sidebar for blog archive page', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_blog_archive',
		  
		  'choices'     => $sidebars,
	  
		);
  $options[] =  array(
		  'slug'          => $option_name.'[right_sidebar_blog_archive]',
		 'label'       => __( 'Right Sidebar', 'onetone' ),
		  'description'       => __( 'Choose right sidebar for blog archive page', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_blog_archive',
		  
		  'choices'     => $sidebars,
	  
		);


 //Sidebar search
 $options[] = array(
		'slug'		=> 'onetone_sidebar_search',
		'label'		=> __( 'Search Page', 'onetone' ),
		'panel' 	=> 'onetone_sidebar',
		'priority'	=> 7,
		'type' 		=> 'section'
		);
 
  $options[] =  array(
		  'slug'          => $option_name.'[left_sidebar_search]',
		 'label'       => __( 'Left Sidebar', 'onetone' ),
		  'description'       => __( 'Choose left sidebar for blog search result page', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_search',
		  'choices'     => $sidebars,
	  
		);
  $options[] =  array(
		  'slug'          => $option_name.'[right_sidebar_search]',
		 'label'       => __( 'Right Sidebar', 'onetone' ),
		  'description'       => __( 'Choose right sidebar for blog search result page', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_search',
		  'choices'     => $sidebars,
	  
		);
  
  $options[] = array(
		'slug'		=> 'onetone_sidebar_404',
		'label'		=> __( '404 Page', 'onetone' ),
		'panel' 	=> 'onetone_sidebar',
		'priority'	=> 8,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
		  'slug'          => $option_name.'[left_sidebar_404]',
		 'label'       => __( 'Left Sidebar', 'onetone' ),
		  'description'       => __( 'Choose left sidebar for 404 page', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_404',
		  
		  'choices'     => $sidebars,
	  
		);
  $options[] =  array(
		  'slug'          => $option_name.'[right_sidebar_404]',
		 'label'       => __( 'Right Sidebar', 'onetone' ),
		  'description'       => __( 'Choose left sidebar for 404 page', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_404',
		  
		  'choices'     => $sidebars,
	  
		);
  		  
  // FOOTER
  $options[] = array(
		'slug'		=> 'onetone_footer',
		'label'		=> __( 'Onetone: Footer', 'onetone' ),
		'priority'	=> 9,
		'type' 		=> 'panel'
	);

	$options[] = array(
		'slug'		=> 'onetone_footer_widgets_area_options',
		'label'		=> __( 'Footer Widgets Area Options', 'onetone' ),
		'panel' 	=> 'onetone_footer',
		'priority'	=> 1,
		'type' 		=> 'section'
		);
	

  
  $options[] =  array(
		  'slug'          => $option_name.'[enable_footer_widget_area]',
		 'label'       => __( 'Display footer widgets?', 'onetone' ),
		  'description'        => __('Choose to display footer widgets', 'onetone'),
		  'default'         => '',
		  'type'        => 'checkbox',
		  'section'     => 'onetone_footer_widgets_area_options',
		  
	  
		);
  
  $options[] =  array(
		  'slug'          => $option_name.'[footer_columns]',
		 'label'       => __( 'Number of Footer Columns', 'onetone' ),
		  'description'        => __('Set column number for footer widget area', 'onetone'),
		  'default'         => '4',
		  'type'        => 'select',
		  'section'     => 'onetone_footer_widgets_area_options',
		  
		  'choices'     => array( 
			'1'     => '1',
			'2'     => '2',
			'3'     => '3',
			'4'     => '4',
		  ),
	  
		);
  
  $options[] =  array(
		  'slug'          => $option_name.'[footer_background_image]',
		 'label'       => __( 'Upload Background Image', 'onetone' ),
		  'description'       => __( 'Choose to upload background image for footer', 'onetone' ),
		  'default'         => '',
		  'type'        => 'images',
		  'section'     => 'onetone_footer_widgets_area_options',
);
  $options[] =  array(
		  'slug'          => $option_name.'[footer_bg_full]',
		 'label'       => __( '100% Background Image', 'onetone' ),
		  'description'        => __( 'Select yes to have the footer widgets area background image display at 100% in width and height and scale according to the browser size.', 'onetone' ),
		  'default'         => 'no',
		  'type'        => 'select',
		  'section'     => 'onetone_footer_widgets_area_options',
		  
		  'choices'     => $choices
		);
  $options[] =  array(
		  'slug'          => $option_name.'[footer_parallax_background]',
		 'label'       => __( 'Parallax Background Image', 'onetone' ),
		  'description'       => __( 'Choose to set parallax background effect for footer', 'onetone' ),
		  'default'         => 'no',
		  'type'        => 'select',
		  'section'     => 'onetone_footer_widgets_area_options',
		  
		  'choices'     => $choices
		);
  $options[] =  array(
		  'slug'          => $option_name.'[footer_background_repeat]',
		 'label'       => __( 'Background Repeat', 'onetone' ),
		  'description'       => __( 'Set repeat for background image in footer', 'onetone' ),
		  'default'         => 'repeat',
		  'type'        => 'select',
		  'section'     => 'onetone_footer_widgets_area_options',
		  
		  'choices'     => $repeat
		);
  $options[] =  array(
		  'slug'          => $option_name.'[footer_background_position]',
		 'label'       => __( 'Background Position', 'onetone' ),
		  'description'       => __( 'Set position for background image in footer', 'onetone' ),
		  'default'         => 'top left',
		  'type'        => 'select',
		  'section'     => 'onetone_footer_widgets_area_options',
		  
		  'choices'     => $position
		);
  $options[] =  array(
		  'slug'          => $option_name.'[footer_top_padding]',
		 'label'       => __( 'Footer Top Padding', 'onetone' ),
		  'description'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '60px',
		  'type'        => 'text',
		  'section'     => 'onetone_footer_widgets_area_options',
);
  $options[] =  array(
		  'slug'          => $option_name.'[footer_bottom_padding]',
		 'label'       => __( 'Footer Bottom Padding', 'onetone' ),
		  'description'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '40px',
		  'type'        => 'text',
		  'section'     => 'onetone_footer_widgets_area_options',
);
  
  
  $options[] = array(
		'slug'		=> 'onetone_copyright_options',
		'label'		=> __( 'Copyright Options', 'onetone' ),
		'panel' 	=> 'onetone_footer',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
		  'slug'          => $option_name.'[display_copyright_bar]',
		 'label'       => __( 'Display Copyright Bar', 'onetone' ),
		  'description'       => __( 'Choose to display copyright bar', 'onetone' ),
		  'default'         => 'yes',
		  'type'        => 'select',
		  'section'     => 'onetone_copyright_options',
		  
		  'choices'     => $choices
		);
  $options[] =  array(
		  'slug'          => $option_name.'[copyright]',
		 'label'       => __( 'Copyright Text', 'onetone' ),
		  'description'        => __( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'onetone' ),
		  'default'         => 'Copyright &copy; '.date('Y').'.',
		  'type'        => 'textarea',
		  'section'     => 'onetone_copyright_options',
  
		);
  $options[] =  array(
		  'slug'          => $option_name.'[copyright_top_padding]',
		 'label'       => __( 'Copyright Top Padding', 'onetone' ),
		  'description'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '20px',
		  'type'        => 'text',
		  'section'     => 'onetone_copyright_options',
);
  $options[] =  array(
		  'slug'          => $option_name.'[copyright_bottom_padding]',
		 'label'       => __( 'Copyright Bottom Padding', 'onetone' ),
		  'description'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '20px',
		  'type'        => 'text',
		  'section'     => 'onetone_copyright_options',
);
  
  
  $options[] = array(
		'slug'		=> 'onetone_footer_social_icons',
		'label'		=> __( 'Footer Social Icons', 'onetone' ),
		'panel' 	=> 'onetone_footer',
		'priority'	=> 3,
		'type' 		=> 'section'
		);
  
 if( $social_icons ):
 $i = 1;
 foreach($social_icons as $social_icon){
	
	 $options[] =  array(
        'slug'          => $option_name.'[footer_social_title_'.$i.']',
       'label'       => __( 'Social Title', 'onetone' ) .' '.$i,
        'description'       => __( 'Set title for social icon', 'onetone' ),
        'default'         => $social_icon['title'],
        'type'        => 'text',
        'section'     => 'onetone_footer_social_icons',
        
        
      );
 $options[] = array(
        'slug'          => $option_name.'[footer_social_icon_'.$i.']',
       'label'       => __( 'Social Icon', 'onetone' ).' '.$i,
        'description'        => __( 'Choose FontAwesome icon', 'onetone' ),
        'default'         => $social_icon['icon'],
        'type'        => 'text',
        'section'     => 'onetone_footer_social_icons',
        
        
      );
 $options[] = array(
        'slug'          => $option_name.'[footer_social_link_'.$i.']',
       'label'       => __( 'Social Icon Link', 'onetone' ).' '.$i,
        'description'       => __( 'Set link for social icon', 'onetone' ),
        'default'         => $social_icon['link'],
        'type'        => 'text',
        'section'     => 'onetone_footer_social_icons',
        
        
      );
	 $i++;
	 }
	endif;	
 
 
  

   $onetone_customize_options = $options;

	return $options;
}


	
