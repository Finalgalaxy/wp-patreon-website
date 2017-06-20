<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<?php

  global  $page_meta;
  $detect                      = new Mobile_Detect;
  $display_top_bar             = onetone_option('display_top_bar');
  $header_background_parallax  = onetone_option('header_background_parallax');
  $header_top_padding          = onetone_option('header_top_padding');
  $header_bottom_padding       = onetone_option('header_bottom_padding');
  $header_background_parallax  = $header_background_parallax=="yes"?"parallax-scrolling":"";
  $top_bar_left_content        = onetone_option('top_bar_left_content','info');
  $top_bar_right_content       = onetone_option('top_bar_right_content','info');
  $header_fullwidth            = onetone_option('header_fullwidth');
  $nav_hover_effect            = absint(onetone_option('nav_hover_effect'));
  
  $logo               = onetone_option('logo');
  $logo_retina        = onetone_option('logo_retina');
  $logo               = ( $logo == '' ) ? $logo_retina : $logo;
  
  $sticky_logo        = onetone_option('sticky_logo',$logo);
  $sticky_logo_retina = onetone_option('sticky_logo_retina');
  $sticky_logo        = ( $sticky_logo == '' ) ? $sticky_logo_retina : $sticky_logo;
  $logo_position      = onetone_option('logo_position','left');
  $logo_position      = $logo_position==''?'left':$logo_position;
  $header_overlay     = onetone_option('header_overlay');
 
  $overlay = '';
  if( ($header_overlay == 'yes'|| $header_overlay == '1' || $header_overlay == 'on' ) && (is_front_page()) ){
    $overlay      = 'overlay';
	$overlay_logo = onetone_option('overlay_logo');
	$logo         = ( $overlay_logo == '' ) ? $logo : $overlay_logo;
  }

  //sticky
  $enable_sticky_header         = onetone_option('enable_sticky_header');
  $enable_sticky_header_tablets = onetone_option('enable_sticky_header_tablets');
  $enable_sticky_header_mobiles = onetone_option('enable_sticky_header_mobiles');
     
 if(isset($page_meta['nav_menu']) && $page_meta['nav_menu'] !='')
   $theme_location = $page_meta['nav_menu'];
 else
   $theme_location = 'primary';
 
 $body_class  = 'page blog';
 
 if( is_front_page() )
   $body_class  = 'page homepage';
   
 $body_class      .= ' onetone';
 $header_container = 'container';
 
 if( $header_fullwidth == 1)
   $header_container = 'container-fluid';
 
 $header_image = get_header_image();
	
?>
<body <?php body_class($body_class); ?>>
	<div class="wrapper">
		<div class="top-wrap">
        <?php if( $header_image ):?>
        <img src="<?php echo $header_image; ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
         <?php endif;?>
            <!--Header-->
            <header class="header-wrap logo-<?php echo $logo_position; ?> <?php echo $overlay; ?>" role="banner">
             <?php if( $display_top_bar == 'yes' ):?>
                <div class="top-bar">
                    <div class="<?php echo $header_container; ?>">
                        <div class="top-bar-left">
                            <?php  onetone_get_topbar_content( $top_bar_left_content );?>                      
                        </div>
                        <div class="top-bar-right">
                          <?php onetone_get_topbar_content( $top_bar_right_content );?>
                        </div>
                    </div>
                </div>
                 <?php endif;?>
                
                <div class="main-header <?php echo $header_background_parallax; ?>">
                    <div class="<?php echo $header_container; ?>">
                        <div class="logo-box">
                        <?php if( $logo ):?>
                        
                            <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img class="site-logo normal_logo" alt="<?php bloginfo('name'); ?>" src="<?php echo esc_url($logo); ?>" />
                            </a>
<?php
					if( $logo_retina ):
					$pixels ="";
					if(is_numeric(onetone_option('retina_logo_width')) && is_numeric(onetone_option('retina_logo_height'))):
					$pixels ="px";
					endif; ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>">
					<img src="<?php echo $logo_retina; ?>" alt="<?php bloginfo('name'); ?>" style="width:<?php echo onetone_option('retina_logo_width').$pixels; ?>;max-height:<?php echo onetone_option('retina_logo_height').$pixels; ?>; height: auto !important" class="site-logo retina_logo" />
					 </a>
                     <?php endif;?>
                           <?php endif;?>
                            <div class="name-box" style=" display:block;">
                                <a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1></a>
                                <span class="site-tagline"><?php bloginfo('description'); ?></span>
                            </div>
                             
                        </div>	
                        <button class="site-nav-toggle">
                            <span class="sr-only"><?php _e( 'Toggle navigation', 'onetone' );?></span>
                            <i class="fa fa-bars fa-2x"></i>
                        </button>
                        <nav class="site-nav style<?php echo $nav_hover_effect;?>" role="navigation">


<?php 
	 wp_nav_menu(array('theme_location'=>$theme_location,'depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
?>
                        </nav>
                    </div>
                </div>
                
               
            <?php if( (!$detect->isTablet() && !$detect->isMobile() && $enable_sticky_header == 'yes') || ( $detect->isTablet() && $enable_sticky_header_tablets == 'yes' ) || ( $detect->isMobile() && !$detect->isTablet() && $enable_sticky_header_mobiles == 'yes' )  ):?>
            
                <div class="fxd-header">
                    <div class="<?php echo $header_container; ?>">
                        <div class="logo-box">
                        <?php if( $sticky_logo ):?>
                            <a href="<?php echo esc_url(home_url('/')); ?>"><img class="site-logo normal_logo" src="<?php echo esc_url($sticky_logo); ?>"></a>
                            
                               <?php
					if( $sticky_logo_retina ):
					$pixels ="";
					if( is_numeric(onetone_option('sticky_logo_width_for_retina_logo')) && is_numeric(onetone_option('sticky_logo_height_for_retina_logo')) ):
					$pixels ="px";
					endif; ?>
					<a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo $sticky_logo_retina; ?>" alt="<?php bloginfo('name'); ?>" style="width:<?php echo onetone_option('sticky_logo_width_for_retina_logo').$pixels; ?>;max-height:<?php echo onetone_option('sticky_logo_height_for_retina_logo').$pixels; ?>; height: auto !important" class="site-logo retina_logo" /></a>
					<?php endif; ?>
                    
                           <?php endif;?>
                            <div class="name-box" style=" display:block;">
                                <a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1></a>
                                <span class="site-tagline"><?php bloginfo('description'); ?></span>
                            </div>
                            
                        </div>
                        <button class="site-nav-toggle">
                            <span class="sr-only"><?php _e( 'Toggle navigation', 'onetone' );?></span>
                            <i class="fa fa-bars fa-2x"></i>
                        </button>
                        <nav class="site-nav style<?php echo $nav_hover_effect;?>" role="navigation">


<?php 
	 wp_nav_menu(array('theme_location'=>$theme_location,'depth'=>0,'fallback_cb' =>false,'container'=>'','container_class'=>'main-menu','menu_id'=>'menu-main','menu_class'=>'main-nav','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
?>
                        </nav>
                    </div>
                </div>
             <?php endif; ?>
            </header>
            <div class="slider-wrap"></div>
        </div>