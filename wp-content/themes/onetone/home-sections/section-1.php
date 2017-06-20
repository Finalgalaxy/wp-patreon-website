<?php
 global $onetone_animated;
 $i                   = 0 ;
 $section_title       = onetone_option( 'section_title_'.$i );
 $detect              = new Mobile_Detect;
 $section_menu        = onetone_option( 'menu_title_'.$i );
 $parallax_scrolling  = onetone_option( 'parallax_scrolling_'.$i );
 $section_css_class   = onetone_option( 'section_css_class_'.$i );
 $section_content     = onetone_option( 'section_content_'.$i );
 $full_width          = onetone_option( 'full_width_'.$i );
 
 $content_model       = onetone_option( 'section_content_model_'.$i,1);
 $section_subtitle    = onetone_option( 'section_subtitle_'.$i );
 $btn_text            = onetone_option( 'section_btn_text_'.$i );
 $btn_link            = onetone_option( 'section_btn_link_'.$i );
 $btn_target          = onetone_option( 'section_btn_target_'.$i );
 $icons               = onetone_option( 'section_icons_'.$i );
 $color               = onetone_option( 'section_color_'.$i );
 $section_icon        = onetone_option( 'section_icon_'.$i );
 
 
  if( !isset($section_content) || $section_content=="" ) 
  $section_content = onetone_option( 'sction_content_'.$i );
  
  $section_id      = sanitize_title( onetone_option( 'menu_slug_'.$i ,'section-'.($i+1) ) );
  if( $section_id == '' )
   $section_id = 'section-'.($i+1);
   
   $section_id  = strtolower( $section_id );
  
  $container_class = "container";
  if( $full_width == "yes" ){
  $container_class = "";
  }
  
  if( ($parallax_scrolling == "yes" || $parallax_scrolling == "1" || $parallax_scrolling == "on") && !$detect->isIOS()){
	 $section_css_class  .= ' onetone-parallax';
  }
  
  if( $content_model == '0' || $content_model == ''  ){
	  $section_css_class .= ' fullheight verticalmiddle';
	  }
  
?>


<section id="<?php echo $section_id; ?>" class="home-section-<?php echo ($i+1); ?> <?php echo $section_css_class;?> home-banner">
      <div class="section-content">
    	<div class="home-container <?php echo $container_class; ?> page_container">
        <?php
		if( $content_model == '0' || $content_model == ''  ):
		?>
       <div class="<?php echo $onetone_animated; ?>" data-animationduration="0.9" data-animationtype="bounceInDown" data-imageanimation="no">
        
          <div class="section-title-container">
          <?php if( $section_icon !='' ):?>
           <img class="section-banner-icon" src="<?php echo esc_url($section_icon); ?>" alt="" />
          <?php endif; ?>
            <h1 class="magee-heading heading-border section-title "><span class="heading-inner"><?php echo do_shortcode($section_title);?></span></h1>
          </div>
          <div style="margin-top: 50px; " class="section-subtitle"><?php echo do_shortcode($section_subtitle);?></div>
          <div style="text-align:center;color:<?php echo $color;?>;" class="home-section-content">
          <div style="margin-top: 20px;">
            
            <?php if( $btn_text != ''):?>
            <a href="<?php echo esc_url($btn_link);?>" target="<?php echo esc_attr($btn_target);?>" class=" magee-btn-normal btn-lg btn-line btn-light" style="text-decoration: none;"><?php echo do_shortcode($btn_text);?></a> 
               <?php endif;?>
            </div>
          <div class="banner-sns" style="margin-top: 50px;">
          <ul>
           <?php 
		   for( $s=0;$s<6;$s++ ):
		   
		   $icon       = onetone_option( "section_social_icon_".$i."_".$s );
           $link       = onetone_option( "section_icon_link_".$i."_".$s );
		   if( $icon !='' )
           echo ' <li><a href="'.esc_url($link).'" target="_blank"><i class="fa fa-2 '.esc_attr($icon).'">&nbsp;</i></a></li>';
		   endfor;
		   ?>
           </ul>
          </div>
        </div>
      </div>
        <?php
		else:
		?>
        <?php if( $section_title != '' ):?>
        <div class="section-title"><?php echo do_shortcode($section_title);?></div>
        <?php endif;?>
            <div class="home-section-content">
         <?php 
			if(function_exists('Form_maker_fornt_end_main'))
             {
                 $section_content = Form_maker_fornt_end_main($section_content);
              }
			 echo do_shortcode($section_content);
			?>
        </div>
        <?php 
		endif;
		?>
        </div>
  <div class="clear"></div>
  </div>
</section>