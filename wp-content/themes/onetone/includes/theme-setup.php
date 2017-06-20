<?php

 function onetone_setup(){

	global $content_width, $onetone_options,$onetone_default_options, $onetone_option_name;
	
	$lang = get_template_directory(). '/languages';
	load_theme_textdomain('onetone', $lang);
	add_theme_support( 'post-thumbnails' ); 
	$args = array();
	$header_args = array( 
	    'default-image'          => '',
		 'default-repeat' => 'repeat',
        'default-text-color'     => '333333',
        'width'                  => 1120,
        'height'                 => 80,
        'flex-height'            => true
     );
	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio' ) );
	
	add_theme_support( 'custom-background', $args );
	add_theme_support( 'custom-header', $header_args );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('nav_menus');
	add_theme_support( "title-tag" );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'onetone' ),
		'home_menu' => __( 'Home Page Header Menu', 'onetone' ),
		'top_bar_menu' => __( 'Top Bar Menu', 'onetone' ),
		'custom_menu_1' => __( 'Custom Menu 1', 'onetone' ),
		'custom_menu_2' => __( 'Custom Menu 2', 'onetone' ),
		'custom_menu_3' => __( 'Custom Menu 3', 'onetone' ),
		'custom_menu_4' => __( 'Custom Menu 4', 'onetone' ),
		'custom_menu_5' => __( 'Custom Menu 5', 'onetone' ),
		'custom_menu_6' => __( 'Custom Menu 6', 'onetone' ),
											  
	));
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );


	add_editor_style("editor-style.css");
	if ( ! isset( $content_width ) ) $content_width = 1120;
				
	// get options 
	$onetone_options = onetone_of_get_options();
	
	}

 add_action( 'after_setup_theme', 'onetone_setup' );


 function onetone_custom_scripts(){
	 
	 global $page_meta,$post,$shop_style;
	 
	 if($post){
	  $page_meta = get_post_meta( $post->ID ,'_onetone_post_meta');
	}	
	
	if( isset($page_meta[0]) && $page_meta[0]!='' )
	  $page_meta = @json_decode( $page_meta[0],true );
	
    $theme_info = wp_get_theme();
	$detect     = new Mobile_Detect;
	
	wp_enqueue_style('font-awesome',  get_template_directory_uri() .'/plugins/font-awesome/css/font-awesome.min.css', false, '4.3.0', false);
	wp_enqueue_style('bootstrap',  get_template_directory_uri() .'/plugins/bootstrap/css/bootstrap.min.css', false, '3.3.4', false);
	wp_enqueue_style( 'owl.carousel',  get_template_directory_uri() .'/plugins/owl-carousel/assets/owl.carousel.css', false, '2.2.0', false );
	wp_enqueue_style('prettyPhoto',  get_template_directory_uri() .'/css/prettyPhoto.css', false, '3.1.5', false);
	

	if( !onetone_is_plugin_active('magee-shortcodes/Magee.php') ){
		wp_enqueue_style('onetone-shortcodes',  get_template_directory_uri() .'/css/shortcode.css', false, $theme_info->get( 'Version' ), false);
    }
	
	wp_enqueue_style('onetone-animate',  get_template_directory_uri() .'/css/animate.css', false, '3.5.1', false);

	wp_enqueue_style( 'onetone-main', get_stylesheet_uri(), array(), $theme_info->get( 'Version' ) );
	wp_enqueue_style('onetone-onetone',  get_template_directory_uri() .'/css/onetone.css', false, $theme_info->get( 'Version' ), false);

	wp_enqueue_style('onetone-ms',  get_template_directory_uri() .'/css/onetone-ms.css', false, $theme_info->get( 'Version' ), false);

	wp_enqueue_style('onetone-scheme',  get_template_directory_uri() .'/css/scheme.less', false, $theme_info->get( 'Version' ), false);

	wp_enqueue_style('onetone-home',  get_template_directory_uri() .'/css/home.css', false, $theme_info->get( 'Version' ), false);
	
	$is_rtl = false;
	if ( is_rtl() ) {
       wp_enqueue_style('onetone-rtl',  get_template_directory_uri() .'/rtl.css', false, $theme_info->get( 'Version' ), false);
	   $is_rtl = true;
     }
	
   $background_array   = onetone_option("page_background");
   $background         = onetone_get_background($background_array);
   $header_image       = get_header_image();
   $onetone_custom_css = "";
   
	if (isset($header_image) && ! empty( $header_image )) {
	$onetone_custom_css .= ".home-header{background:url(".$header_image. ") repeat;}\n";
	}
    if ( 'blank' != get_header_textcolor() && '' != get_header_textcolor() ){
       $header_color        =  ' color:#' . get_header_textcolor() . ';';
	   $onetone_custom_css .=  'header .site-name,header .site-description,header .site-tagline{'.$header_color.'}';
		}
	else{
	   $onetone_custom_css .=  'header .site-name,header .site-description,header .site-tagline{display:none;}';	
		
		}
		
	$custom_css           =  onetone_option("custom_css");
	$onetone_custom_css  .=  '.site{'.$background.'}';
	
	$links_color   = onetone_option( 'links_color','#37cadd');
	
	//scheme
	$primary_color = esc_attr(onetone_option('primary_color',$links_color));	
	
	$links_color   = onetone_option( 'links_color');
	
	if($links_color )
	  $onetone_custom_css  .=  '.entry-content a,.home-section-content a{color:'.$links_color.' ;}';

	$top_menu_font_color = onetone_option( 'font_color');
	
	if($top_menu_font_color !="" && $top_menu_font_color!=null){
		$onetone_custom_css  .=  'header .site-nav > ul > li > a {color:'.$top_menu_font_color.'}';
		}
		
	// header
	$sticky_header_background_color    = esc_attr(onetone_option('sticky_header_background_color',''));
    $sticky_header_background_opacity  = esc_attr(onetone_option('sticky_header_background_opacity','1')); 
	$header_background_color           = esc_attr(onetone_option('header_background_color'));
    $header_background_opacity         = esc_attr(onetone_option('header_background_opacity','1')); 
	$header_border_color               = esc_attr(onetone_option('header_border_color','')); 
	$page_title_bar_background_color   = esc_attr(onetone_option('page_title_bar_background_color','')); 
	$page_title_bar_borders_color      = esc_attr(onetone_option('page_title_bar_borders_color','')); 
	$top_bar_social_icons_color        = esc_attr(onetone_option('top_bar_social_icons_color')); 
	
	
	// top bar icon color
	if($sticky_header_background_color){
	    $onetone_custom_css .= ".top-bar-sns li i{
		color: ".$top_bar_social_icons_color.";
		}";
		}
		
	// sticky header background
	if($sticky_header_background_color){
		$rgb = onetone_hex2rgb( $sticky_header_background_color );
	    $onetone_custom_css .= ".fxd-header {
		background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",".$sticky_header_background_opacity.");
		}";
		}
		
		// main header background
	if( $header_background_color ){
		$rgb = onetone_hex2rgb( $header_background_color );

	    $onetone_custom_css .= ".main-header {
		background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",".$header_background_opacity.");
		}";
		
		}
	
	// sticky header
  
	$sticky_header_opacity               =  onetone_option('sticky_header_background_opacity','1');
	$sticky_header_menu_item_padding     =  onetone_option('sticky_header_menu_item_padding','');
	$sticky_header_navigation_font_size  =  onetone_option('sticky_header_navigation_font_size','');
	$sticky_header_logo_width            =  onetone_option('sticky_header_logo_width','');
	$logo_left_margin                    =  onetone_option('logo_left_margin','');
	$logo_right_margin                   =  onetone_option('logo_right_margin','');
	$logo_top_margin                     =  onetone_option('logo_top_margin','');
	$logo_bottom_margin                  =  onetone_option('logo_bottom_margin','');
		
	if( $sticky_header_background_color ){
		$rgb = onetone_hex2rgb( $sticky_header_background_color );
	    $onetone_custom_css .= ".fxd-header{background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",".esc_attr($sticky_header_opacity).");}\r\n";
	}
	
    if( $sticky_header_menu_item_padding )
	  $onetone_custom_css .= ".fxd-header .site-nav > ul > li > a {padding:".absint($sticky_header_menu_item_padding)."px;}\r\n";
	  
	if( $sticky_header_navigation_font_size )
	  $onetone_custom_css .= ".fxd-header .site-nav > ul > li > a {font-size:".absint($sticky_header_navigation_font_size)."px;}\r\n";
	  
	if( $sticky_header_logo_width )
	  $onetone_custom_css .= ".fxd-header img.site-logo{ width:".absint($sticky_header_logo_width)."px;}\r\n";
	
	if( $logo_left_margin )
	  $onetone_custom_css .= "img.site-logo{ margin-left:".absint($logo_left_margin)."px;}\r\n";
	  
	if( $logo_right_margin )
	  $onetone_custom_css .= "img.site-logo{ margin-right:".absint($logo_right_margin)."px;}\r\n";
	  
	if( $logo_top_margin )
	  $onetone_custom_css .= "img.site-logo{ margin-top:".absint($logo_top_margin)."px;}\r\n";
	  
	if( $logo_bottom_margin )
	  $onetone_custom_css .= "img.site-logo{ margin-bottom:".absint($logo_bottom_margin)."px;}\r\n";
	
	// top bar
	$display_top_bar             = onetone_option('display_top_bar','yes');
	$top_bar_background_color    = onetone_option('top_bar_background_color','');
	$top_bar_info_color          = onetone_option('top_bar_info_color','');
	$top_bar_menu_color          = onetone_option('top_bar_menu_color','');
	
	if( $top_bar_background_color )
	  $onetone_custom_css .= ".top-bar{background-color:".$top_bar_background_color.";}";
	
	if( $display_top_bar == 'yes' )
	  $onetone_custom_css .= ".top-bar{display:block;}";
	
	if( $top_bar_info_color  )
	  $onetone_custom_css .= ".top-bar-info{color:".$top_bar_info_color.";}";
	
	if( $top_bar_menu_color  )
	  $onetone_custom_css .= ".top-bar ul li a{color:".$top_bar_menu_color.";}";
	
	// Header background
    $header_background_image     = onetone_option('header_background_image','');
	$header_background_full      = onetone_option('header_background_full','');
	$header_background_repeat    = onetone_option('header_background_repeat','');
	$header_background_parallax  = onetone_option('header_background_parallax','');
	$header_background           = '';
	
	if( $header_background_image ){
		$header_background  .= "header .main-header{\r\n";
		
	    $header_background  .= "background-image: url(".esc_url($header_background_image).");\r\n";
		
	if( $header_background_full == 'yes' )
		$header_background  .= "-webkit-background-size: cover;
								-moz-background-size: cover;
								-o-background-size: cover;
								background-size: cover;\r\n";
								
	if( $header_background_parallax  == 'no' )		
	     $header_background  .=  "background-repeat:".$header_background_repeat.";";
	   
	if( $header_background_parallax  == 'yes' )
	     $header_background  .= "background-attachment: fixed;
		                       background-position:top center;
							   background-repeat: no-repeat;";
        $header_background  .= "}\r\n";	
	}
	
	$onetone_custom_css .= $header_background;
	
	// Header  Padding
	$header_top_padding     = onetone_option('header_top_padding','');
	$header_bottom_padding  = onetone_option('header_bottom_padding','');
	
	if( $header_top_padding )
	  $onetone_custom_css .= ".site-nav > ul > li > a{padding-top:".$header_top_padding."}";
	
	if( $header_bottom_padding )
	  $onetone_custom_css .= ".site-nav > ul > li > a{padding-bottom:".$header_bottom_padding."}";
	
	$content_background_color          = esc_attr(onetone_option('content_background_color',''));
	$sidebar_background_color          = esc_attr(onetone_option('sidebar_background_color',''));
	$footer_background_color           = esc_attr(onetone_option('footer_background_color',''));
	$copyright_background_color        = esc_attr(onetone_option('copyright_background_color',''));
		
	// content backgroud color
		
    if( $content_background_color )
	   $onetone_custom_css  .= ".col-main {background-color:".$content_background_color.";}";
	 
	if( $sidebar_background_color )
	  $onetone_custom_css  .= ".col-aside-left,.col-aside-right {background-color:".$sidebar_background_color.";}";
	
	//footer background
	if( $footer_background_color )
	  $onetone_custom_css  .= "footer .footer-widget-area{background-color:".$footer_background_color.";}";
	 
	if( $copyright_background_color )
	  $onetone_custom_css  .= "footer .footer-info-area{background-color:".$copyright_background_color."}";
	 
	// Element Colors
	
	$form_background_color = esc_attr(onetone_option('form_background_color',''));
	$form_text_color       = esc_attr(onetone_option('form_text_color',''));
	$form_border_color     = esc_attr(onetone_option('form_border_color',''));
	
	if( $form_background_color )
	  $onetone_custom_css  .= "footer input,footer textarea{background-color:".$form_background_color.";}";
	
	if( $form_text_color )
	  $onetone_custom_css  .= "footer input,footer textarea{color:".$form_text_color.";}";
	
	if( $form_border_color )
	  $onetone_custom_css  .= "footer input,footer textarea{border-color:".$form_border_color.";}";

	//Layout Options
	
	$page_content_top_padding          = esc_attr(onetone_option('page_content_top_padding',''));
	$page_content_bottom_padding       = esc_attr(onetone_option('page_content_bottom_padding',''));
	$hundredp_padding                  = esc_attr(onetone_option('hundredp_padding',''));
	$sidebar_padding                   = esc_attr(onetone_option('sidebar_padding',''));
	$column_top_margin                 = esc_attr(onetone_option('column_top_margin',''));
	$column_bottom_margin              = esc_attr(onetone_option('column_bottom_margin',''));
	
	if( $page_content_top_padding )
	  $onetone_custom_css  .= ".post-inner,.page-inner{padding-top:".$page_content_top_padding.";}";
	
	if( $page_content_bottom_padding )
	  $onetone_custom_css  .= ".post-inner,.page-inner{padding-bottom:".$page_content_bottom_padding.";}";
	
	if( isset($page_meta['padding_top']) && $page_meta['padding_top'] !='' )
	  $onetone_custom_css  .= ".post-inner,.page-inner{padding-top:".esc_attr($page_meta['padding_top']).";}";
	
	if( isset($page_meta['padding_bottom']) && $page_meta['padding_bottom'] !='' )
	  $onetone_custom_css  .= ".post-inner,.page-inner{padding-bottom:".esc_attr($page_meta['padding_bottom']).";}";
		
	if( $sidebar_padding )
	  $onetone_custom_css  .= ".col-aside-left,.col-aside-right{padding:".$sidebar_padding.";}";
	
	if( $column_top_margin )
	  $onetone_custom_css  .= ".col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9{margin-top:".$column_top_margin.";}";
	
	if( $column_bottom_margin )
	$onetone_custom_css  .= ".col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9{margin-bottom:".$column_bottom_margin.";}";
	
	//fonts color
	
	$fixed_header_text_color           = esc_attr(onetone_option('fixed_header_text_color'));
	$overlay_header_text_color         = esc_attr(onetone_option('overlay_header_text_color'));
	$page_title_color                  = esc_attr(onetone_option('page_title_color',''));
	$h1_color                          = esc_attr(onetone_option('h1_color',''));
	$h2_color                          = esc_attr(onetone_option('h2_color',''));
	$h3_color                          = esc_attr(onetone_option('h3_color',''));
	$h4_color                          = esc_attr(onetone_option('h4_color',''));
	$h5_color                          = esc_attr(onetone_option('h5_color',''));
	$h6_color                          = esc_attr(onetone_option('h6_color',''));
	$body_text_color                   = esc_attr(onetone_option('body_text_color',''));
	$link_color                        = esc_attr(onetone_option('link_color',''));
	$breadcrumbs_text_color            = esc_attr(onetone_option('breadcrumbs_text_color',''));
	$sidebar_widget_headings_color     = esc_attr(onetone_option('sidebar_widget_headings_color',''));
	$footer_headings_color             = esc_attr(onetone_option('footer_headings_color',''));
	$footer_text_color                 = esc_attr(onetone_option('footer_text_color'));
	$footer_link_color                 = esc_attr(onetone_option('footer_link_color'));
	
	if( $fixed_header_text_color )
	  $onetone_custom_css  .= ".fxd-header .site-tagline,.fxd-header .site-name{color:".$fixed_header_text_color.";}";
	
	if( $overlay_header_text_color )
	  $onetone_custom_css  .= "header.overlay .main-header .site-tagline,header.overlay .main-header .site-name{color:".$overlay_header_text_color.";}";
	
	if( $page_title_color )
	  $onetone_custom_css  .= ".page-title h1{color:".$page_title_color.";}";
	if( $h1_color )
	  $onetone_custom_css  .= "h1{color:".$h1_color.";}";
	if( $h2_color )
	  $onetone_custom_css  .= "h2{color:".$h2_color.";}";
	if( $h3_color )
	  $onetone_custom_css  .= "h3{color:".$h3_color.";}";
	if( $h4_color )
	  $onetone_custom_css  .= "h4{color:".$h4_color.";}";
	if( $h5_color )
	  $onetone_custom_css  .= "h5{color:".$h5_color.";}";
	if( $h6_color )
	  $onetone_custom_css  .= "h6{color:".$h6_color.";}";
	
	if( $body_text_color )
	  $onetone_custom_css  .= ".entry-content,.entry-content p{color:".$body_text_color.";}";
	
	if( $link_color )
	  $onetone_custom_css  .= ".entry-summary a, .entry-content a{color:".$link_color.";}";
	
	if( $breadcrumbs_text_color )
	  $onetone_custom_css  .= ".breadcrumb-nav span,.breadcrumb-nav a{color:".$breadcrumbs_text_color.";}";
	
	if( $sidebar_widget_headings_color )
	  $onetone_custom_css  .= ".col-aside-left .widget-title,.col-aside-right .widget-title{color:".$sidebar_widget_headings_color.";}";
	
	if( $footer_headings_color )
	  $onetone_custom_css  .= ".footer-widget-area .widget-title{color:".$footer_headings_color.";}";
	
	if( $footer_text_color )
	  $onetone_custom_css  .= "footer,footer p,footer span,footer div{color:".$footer_text_color.";}";
	
	if( $footer_link_color )
	  $onetone_custom_css  .= "footer a{color:".$footer_link_color.";}";
	
	//Main Menu Colors 
	$main_menu_background_color_1   = esc_attr(onetone_option('main_menu_background_color_1',''));
	$main_menu_font_color_1         = esc_attr(onetone_option('main_menu_font_color_1',''));
	$main_menu_overlay_font_color_1 = esc_attr(onetone_option('main_menu_overlay_font_color_1',''));
	$main_menu_font_hover_color_1   = esc_attr(onetone_option('main_menu_font_hover_color_1',''));
	$main_menu_background_color_2   = esc_attr(onetone_option('main_menu_background_color_2',''));
	$main_menu_font_color_2         = esc_attr(onetone_option('main_menu_font_color_2',''));
	$main_menu_font_hover_color_2   = esc_attr(onetone_option('main_menu_font_hover_color_2',''));
	$main_menu_separator_color_2    = esc_attr(onetone_option('main_menu_separator_color_2',''));
	$woo_cart_menu_background_color = esc_attr(onetone_option('woo_cart_menu_background_color',''));
	$side_menu_color                = esc_attr(onetone_option('side_menu_color'));
	
	if( $main_menu_background_color_1 )
	$onetone_custom_css  .= ".main-header .site-nav{ background-color:".$main_menu_background_color_1.";}";
	
	if( $main_menu_font_color_1 )
	$onetone_custom_css  .= "#menu-main > li > a {color:".$main_menu_font_color_1.";}";
	
	if( $main_menu_overlay_font_color_1 )
	$onetone_custom_css  .= "header.overlay .main-header #menu-main > li > a {color:".$main_menu_overlay_font_color_1.";}";
	
	if( $main_menu_font_hover_color_1 )
	$onetone_custom_css  .= "#menu-main > li > a:hover,#menu-main > li.current > a{color:".$main_menu_font_hover_color_1.";}";
	
	if( $main_menu_background_color_2 )
	$onetone_custom_css  .= ".main-header .sub-menu{background-color:".$main_menu_background_color_2.";}";
	$onetone_custom_css  .= ".fxd-header .sub-menu{background-color:".$main_menu_background_color_2.";}";
	if( $main_menu_font_color_2 )
	$onetone_custom_css  .= "#menu-main  li li a{color:".$main_menu_font_color_2.";}";
	if( $main_menu_font_hover_color_2 )
	$onetone_custom_css  .= "#menu-main  li li a:hover{color:".$main_menu_font_hover_color_2.";}";
	if( $main_menu_separator_color_2 )
	$onetone_custom_css  .= ".site-nav  ul li li a{border-color:".$main_menu_separator_color_2." !important;}";
	
	if( $side_menu_color )
	$onetone_custom_css  .= "
	@media screen and (min-width: 920px) {
	.onetone-dots li a {
		border: 2px solid ".$side_menu_color.";
		}
	.onetone-dots li.active a,
	.onetone-dots li.current a,
	.onetone-dots li a:hover {
	  background-color: ".$side_menu_color.";
	}
	}";
		
	$onetone_custom_css  .= "@media screen and (max-width: 920px) {\r\n
		.site-nav ul{ background-color:".$main_menu_background_color_2.";}\r\n
		#menu-main  li a,header.overlay .main-header #menu-main > li > a {color:".$main_menu_font_color_2.";}\r\n
		.site-nav  ul li a{border-color:".$main_menu_separator_color_2." !important;}\r\n
		}";
	


	
	// home page sections 
	
	$section_title_css   = '';
	$section_content_css = '';
	$video_background_section  = onetone_option( 'video_background_section' );
	
	for($i=0;$i<15;$i++):

	$section_css         = '';
	
	$section_background  = onetone_option( 'section_background_'.$i );
	$background_size     = onetone_option( 'background_size_'.$i );
	$section_padding     = onetone_option( 'section_padding_'.$i ,$i == 0?'':'50px 0');
    $text_align          = onetone_option( 'text_align_'.$i);
	$parallax_scrolling  = onetone_option( 'parallax_scrolling_'.$i );
	
	$section_title_typography    = onetone_option( 'section_title_typography_'.$i);
    $title_typography            = onetone_get_typography( $section_title_typography );
    
	$section_subtitle_typography = onetone_option( 'section_subtitle_typography_'.$i);
    $subtitle_typography         = onetone_get_typography( $section_subtitle_typography );
	
	$section_content_typography  = onetone_option( 'section_content_typography_'.$i);
	$content_typography          = onetone_get_typography( $section_content_typography );
	$content_nosize_typography   = onetone_get_typography($section_content_typography,array('face','style','color'));
	$content_color_typography    = onetone_get_typography($section_content_typography,array('color'));
	
	$section_title_color         = isset( $section_title_typography['color'] )? $section_title_typography['color']:'';
	$section_title_font          = isset( $section_title_typography['face'] ) ? $section_title_typography['face']:'';
	$section_content_color       = isset( $section_content_typography['color'] )? $section_content_typography['color']:'';
	
	
	if( $parallax_scrolling == "yes" || $parallax_scrolling == "1" || $parallax_scrolling == "on" ){
	    $section_css .= "background-attachment:fixed;background-position:50% 0;background-repeat:repeat;\r\n";
	 }
	 
	if( $background_size == "yes" ){
		$section_css .= "-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;\r\n";
	}
	
	if( $section_padding ){
	    $section_css .= "padding:".$section_padding.";\r\n";; 
	}
	
    //if( $video_background_section != ($i+1) || $detect->isMobile() || $detect->isTablet() )
	$section_css       .= onetone_get_background( $section_background );
	
	$section_title_css .= "section.home-section-".($i+1)." .section-title{text-align:center ;}\r\n";
	
	if( $title_typography )
	  $section_title_css .= "section.home-section-".($i+1)." .section-title{".$title_typography."}\r\n";
	
	if( $section_title_color && $i==0 )
	$section_title_css .= "section.home-section-1 .section-title {border-color:".$section_title_color.";}\r\n";
	
	if( $section_title_font =='' && $i==0 )
	  $section_title_css .= "section.home-section-1 .section-title-container {font-family:'Lustria,serif';}\r\n";  
	  
	if( $subtitle_typography )
	  $section_title_css .= "section.home-section-".($i+1)." .section-subtitle{".$subtitle_typography."}\r\n";
	  
	if( $content_typography )
	$section_content_css .= "section.home-section-".($i+1)." .home-section-content{".$content_typography."}\r\n";
	
	if( $content_nosize_typography)
	$section_title_css .= "
	section.home-section-".($i+1)." .home-section-content p,
	section.home-section-".($i+1)." .home-section-content h1,
	section.home-section-".($i+1)." .home-section-content h2,
	section.home-section-".($i+1)." .home-section-content h3,
	section.home-section-".($i+1)." .home-section-content h4,
	section.home-section-".($i+1)." .home-section-content h5,
	section.home-section-".($i+1)." .home-section-content h6{".$content_nosize_typography."}\r\n"; 
	
	
	if( $section_content_color && $i==0 )
	$section_content_css .= "section.home-section-1 .magee-btn-normal.btn-line.btn-light {
								  color: ".$section_content_color." !important;
								  border-color: ".$section_content_color." !important;
							  }
							  section.home-section-1 .banner-sns li a i {
								  color: ".$section_content_color.";
							  }\r\n";

    if($section_content_color && $i==2  )
	  $section_content_css .= "section.home-section-3 .home-section-content a {
								  color: ".$section_content_color." ;
							  }\r\n"; 
							  
	if($section_content_color && $i==4  )
	  $section_content_css .= "section.home-section-5 .home-section-content a {
								  color: ".$section_content_color." ;
							  }\r\n"; 	
							  					  
	if($section_content_color && $i==5  )
	  $section_content_css .= "section.home-section-6 .home-section-content a {
								  color: ".$section_content_color." ;
							  }\r\n"; 
							  	
    if($section_content_color && $i==8  )
	  $section_content_css .= "section.home-section-9 .home-section-content .form-control,
section.home-section-9 .home-section-content .magee-contact-form .magee-btn-normal,section.home-section-9 .contact-form input,
section.home-section-9 .contact-form textarea{
								  color: ".$section_content_color." ;
								  border-color: ".$section_content_color." ;
							  }\r\n"; 	

if( $i==0)
$section_title_css .= "section.home-section-".($i+1)." .magee-heading{".$title_typography."}\r\n";
							  		  
       
							  						  
	if( $text_align )
    $section_content_css .= "section.home-section-".($i+1)." .home-section-content{text-align:".$text_align."}\r\n";
	
	$section_content_css .=  "section.home-section-".($i+1)." {".$section_css."}\r\n";	
	
	endfor;

	// footer
	
	$footer_background_image          = onetone_option('footer_background_image',''); 
	$footer_bg_full                   = onetone_option('footer_bg_full','yes'); 
	$footer_background_repeat         = onetone_option('footer_background_repeat',''); 
	$footer_background_position       = onetone_option('footer_background_position',''); 
	$footer_top_padding               = onetone_option('footer_top_padding',''); 
	$footer_bottom_padding            = onetone_option('footer_bottom_padding',''); 
	
	$copyright_top_padding            = onetone_option('copyright_top_padding'); 
	$copyright_bottom_padding         = onetone_option('copyright_bottom_padding'); 
	
	$footer_background = "";
	
	if( $footer_background_image ){
		$footer_background  .= ".footer-widget-area{\r\n";
		
	    $footer_background  .= "background-image: url(".esc_url($footer_background_image).");\r\n";
		
	if( $footer_bg_full == 'yes' )
		  $footer_background  .= "-webkit-background-size: cover;
								-moz-background-size: cover;
								-o-background-size: cover;
								background-size: cover;\r\n";
		
	   $footer_background  .=  "background-repeat:".esc_attr($footer_background_repeat).";";
	   $footer_background  .=  "background-position:".esc_attr($footer_background_position).";";

		  
        $footer_background  .= "}\r\n";	
	}
	
	$onetone_custom_css      .= $footer_background ;
	
	$onetone_custom_css      .= ".footer-widget-area{\r\n
	                           padding-top:".$footer_top_padding.";\r\n
							   padding-bottom:".$footer_bottom_padding.";\r\n
							   }" ;
	$onetone_custom_css      .= ".footer-info-area{\r\n
	                           padding-top:".$copyright_top_padding.";\r\n
							   padding-bottom:".$copyright_bottom_padding.";\r\n
							   }" ;	
	
	$onetone_custom_css  .=  $section_title_css;
	$onetone_custom_css  .=  $section_content_css;
	
	$onetone_custom_css  .=  $custom_css;
	
	wp_add_inline_style( 'onetone-main', $onetone_custom_css );
		
  wp_enqueue_style( 'jquery.mb.YTPlayer', get_template_directory_uri().'/plugins/YTPlayer/css/jquery.mb.YTPlayer.min.css','', '', true );
	wp_enqueue_script( 'jquery.mb.YTPlayer', get_template_directory_uri().'/plugins/YTPlayer/jquery.mb.YTPlayer.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/plugins/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.3.4', false );
  wp_enqueue_script( 'jquery.nav', get_template_directory_uri().'/plugins/jquery.nav.js', array( 'jquery' ), '1.4.14 ', false );
	wp_enqueue_script( 'jquery.scrollTo', get_template_directory_uri().'/plugins/jquery.scrollTo.js', array( 'jquery' ), '1.4.14', false );
	wp_enqueue_script( 'jquery.parallax', get_template_directory_uri().'/plugins/jquery.parallax-1.1.3.js', array( 'jquery' ), '1.1.3', true );
	wp_enqueue_script( 'respond', get_template_directory_uri().'/plugins/respond.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'less', get_template_directory_uri().'/plugins/less.min.js', array( 'jquery' ), '2.5.1', true );
	wp_enqueue_script( 'jquery.prettyPhoto', get_template_directory_uri().'/plugins/jquery.prettyPhoto.js', array( 'jquery' ), '3.1.5', true );
	wp_enqueue_script('masonry');
	wp_enqueue_script( 'jquery.counterup', get_template_directory_uri() . '/plugins/jquery.counterup.js', array( 'jquery'), '1.0', true );
	wp_enqueue_script( 'jquery.waypoints', get_template_directory_uri() . '/plugins/jquery.waypoints.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/plugins/owl-carousel/owl.carousel.js', array( 'jquery' ), '2.2.0', true );


	wp_enqueue_script( 'onetone-default', get_template_directory_uri().'/js/onetone.js', array( 'jquery' ),$theme_info->get( 'Version' ), true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){wp_enqueue_script( 'comment-reply' );}
	
	$slide_autoplay    = onetone_option("slide_autoplay",1);
	$slide_time        = onetone_option("slide_time");
	$slider_control    = onetone_option("slider_control",1);
	$slider_pagination = onetone_option("slider_pagination",1);
	$slide_fullheight  = onetone_option("slide_fullheight");
	
	$slide_time = is_numeric($slide_time)?$slide_time:"5000";
	
	$isMobile = 0;
	if( $detect->isMobile() && !$detect->isTablet() ){
		$isMobile = 1;
		}
	
	$sticky_header    = esc_attr(onetone_option('enable_sticky_header','yes'));	
	
	wp_localize_script( 'onetone-default', 'onetone_params', array(
			'ajaxurl'        => admin_url('admin-ajax.php'),
			'themeurl' => get_template_directory_uri(),
			'slide_autoplay'  => $slide_autoplay,
			'slideSpeed'  => $slide_time,
			'slider_control'  => $slider_control,
			'slider_pagination'  => $slider_pagination,
			'slide_fullheight'  => $slide_fullheight,
			'sticky_header' => $sticky_header,
			'isMobile' =>$isMobile,
			'primary_color' => $primary_color,
			'is_rtl' => $is_rtl,
			
		)  );	
	}
	
	function onetone_admin_scripts(){
		
		global $pagenow , $onetone_options_saved, $onetone_options, $onetone_default_options, $onetone_option_name;
		
		$theme_info = wp_get_theme();
		
		wp_enqueue_style( 'onetone-admin', get_template_directory_uri().'/css/admin.css', false, $theme_info->get( 'Version' ), false);
		
		
		if( $pagenow == "post.php" || $pagenow == "post-new.php" || (isset($_GET['page']) && $_GET['page'] == "onetone-options") ):
		wp_enqueue_style('font-awesome',  get_template_directory_uri() .'/plugins/font-awesome/css/font-awesome.min.css', false, '4.4.0', false);
		wp_enqueue_style('onetone-options',  get_template_directory_uri() .'/css/options.css', false, $theme_info->get( 'Version' ), false);
		endif;

		wp_enqueue_script( 'onetone-admin', get_template_directory_uri().'/js/admin.js', array( 'jquery' ), $theme_info->get( 'Version' ), false );
		
	    wp_localize_script( 'onetone-admin', 'onetone_params', array(
			'ajaxurl'        => admin_url('admin-ajax.php'),
			'themeurl'       => get_template_directory_uri(),
			'options_saved'  => $onetone_options_saved,
			'option_name' => $onetone_option_name,
		)  );
		
		}
		
  add_action( 'wp_enqueue_scripts', 'onetone_custom_scripts' );
  add_action( 'admin_enqueue_scripts', 'onetone_admin_scripts' );
  
 
  
  function onetone_of_get_options($default = false) {
	  
	  global $onetone_options_saved,$onetone_default_options;
	  	 
	  $option_name  = optionsframework_option_name();
	  
	  if ( get_option($option_name) ) {
		  $options = get_option($option_name);
	  }
	  else{
		  
		  $options = $onetone_default_options;
		  
		  }
		  
	  if ( isset($options) ) {
		  return $options;
	  } else {
		  return $default;
	  }
  
  }
  

  function onetone_option($name,$default=''){
	  
	  global $onetone_default_options, $onetone_options;
	  
	  if(is_customize_preview())
	  $onetone_options = onetone_of_get_options();
	  
	  if( isset($onetone_options[$name]) )
			return $onetone_options[$name];		
		elseif( isset($onetone_default_options[$name]) )
			return $onetone_default_options[$name];
		
	    else
			return $default;
  }
  

  /* 
   * This is an example of how to add custom scripts to the options panel.
   * This one shows/hides the an option when a checkbox is clicked.
   */
  
  add_action('optionsframework_custom_scripts', 'onetone_optionsframework_custom_scripts');
  
  function onetone_optionsframework_custom_scripts() { 
  
  }
  
  add_filter('options_framework_location','onetone_options_framework_location_override');
  
  function onetone_options_framework_location_override() {
	  return array('includes/admin-options.php');
  }
  
  function onetone_optionscheck_options_menu_params( $menu ) {
	  
	  $menu['page_title'] = __( 'Onetone Options', 'onetone');
	  $menu['menu_title'] = __( 'Onetone Options', 'onetone');
	  $menu['menu_slug'] = 'onetone-options';
	  return $menu;
  }
  add_filter( 'optionsframework_menu', 'onetone_optionscheck_options_menu_params' );
  
  function onetone_title( $title ) {
  if ( $title == '' ) {
		return __( 'Untitled', 'onetone');
	} else {
		return $title;
	}
  }
  add_filter( 'the_title', 'onetone_title' );