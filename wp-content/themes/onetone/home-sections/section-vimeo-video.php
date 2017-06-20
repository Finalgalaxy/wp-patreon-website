<?php

 $video_background_section  = onetone_option( 'video_background_section' );
 $i                         = $video_background_section-1 ;
 $video_controls            = onetone_option( 'vimeo_video_controls' );
 $section_background_video  = onetone_option( 'section_background_video_vimeo' );
 $vimeo_bg_type           = onetone_option("vimeo_bg_type");
 $vimeo_bg_type           = is_numeric($vimeo_bg_type)?$vimeo_bg_type:"1";
 $start_play              = absint(onetone_option("section_vimeo_start",3));

 $vimeo_autoplay          = onetone_option("vimeo_autoplay",1);
 $vimeo_loop              = onetone_option("vimeo_loop",1);
 $vimeo_mute              = onetone_option("vimeo_mute",50);
 
 if( $vimeo_autoplay == '1' )
   $vimeo_autoplay = 'true';
 else
   $vimeo_autoplay = 'false';
 
 if( $vimeo_loop == '1' )
   $vimeo_loop = 'true';
 else
   $vimeo_loop = 'false';
 
 if( $vimeo_mute == '1' )
   $vimeo_mute = 0;
 else
   $vimeo_mute = 50;
  
  $containment = '.onetone-vimeo-section';
  
  if( $vimeo_bg_type == '1')
    $containment = 'body';
	
	
	$sid = '193338881';
	if($section_background_video !== ''){
					if(preg_match( '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/',$section_background_video,$match)){
					$sid = $match[5];
					};
				}
?>
<section class="section home-section-<?php echo $video_background_section;?>  onetone-vimeo-section video-section">
<script src='<?php echo get_template_directory_uri();?>/plugins/okvideo.js'></script>

<?php get_template_part('home-sections/section',$video_background_section);?>
    
  <div class="clear"></div>
   <?php 
	  
		  
		  $detect = new Mobile_Detect;
		  
		  if(  !$detect->isMobile() && !$detect->isTablet() ){
			  
			  if( $vimeo_autoplay == 'true' )
			    $play_btn_icon = 'pause';
			  else
			    $play_btn_icon = 'play';
			  
			  if( $vimeo_mute == 0 )
			    $mute_btn_icon = 'volume-off';
			  else
			    $mute_btn_icon = 'volume-up';
			  
	  echo '<script>

		var vimeo_autoplay = '.$vimeo_autoplay.';
		jQuery("'.$containment.'").okvideo({ source: "'.$sid.'",
                    volume: '.$vimeo_mute.',
                    loop: '.$vimeo_loop.',
					autoplay: '.$vimeo_autoplay.',
					playlist: { 
					  list: null,
					  index: 0,
					  startSeconds: '.$start_play .',
					},
					hd:true,
                    adproof: true,
                    annotations: false,
                    onFinished: function() { console.log("finished") },
                    unstarted: function() { console.log("unstarted") },
                    onReady: function() { 
					jQuery(".onetone-vimeo-section,.onetone-vimeo-section section").css("background", "none");
					console.log("onready");
					
					},
                    onPlay: function() { 
					jQuery("#video-controls").show(); 
					
					if( vimeo_autoplay == false ){
					var iframe  = jQuery("'.$containment.' #okplayer")[0];
				    var player = $f(iframe);
				    player.api("pause");
					}
					
					console.log("onplay"); 
					},
                    onPause: function() { 
							console.log("pause") ;
					},
                    buffering: function() { console.log("buffering") },
                    cued: function() { console.log("cued") },
                 });
		
		</script>';
		
		if(  $video_controls == 1  ){
		echo '<script>
		jQuery(document).ready(function($){
		$(document).on("click",".fa-pause",function(){
				
				 var iframe  = $("'.$containment.' #okplayer")[0];
				 var player = $f(iframe);
				 player.api("pause");
				 $("#togglePlay i").removeClass("fa-pause").addClass("fa-play");
															
          });
		
		$(document).on("click",".fa-play",function(){
				
				 var iframe  = $("'.$containment.' #okplayer")[0];
				 var player = $f(iframe);
				 player.api("play");
				 $("#togglePlay i").removeClass("fa-play").addClass("fa-pause");
															
          });
		
		$(document).on("click",".fa-volume-off",function(){
				var iframe  = $("'.$containment.' #okplayer")[0];
				var player = $f(iframe);
				player.api("setVolume", 1);
				$(".vimeo-volume i").removeClass("fa-volume-off").addClass("fa-volume-up");
          });
		
		$(document).on("click",".fa-volume-up",function(){
				var iframe  = $("'.$containment.' #okplayer")[0];
				var player = $f(iframe);
				player.api("setVolume", 0);
				$(".vimeo-volume i").removeClass("fa-volume-up").addClass("fa-volume-off");
          });
		
		});
		</script>
		';
		
        echo '<p class="black-65" id="video-controls">
		  <a class="vimeo-pause command" id="togglePlay" href="javascript:;" onclick=""><i class="fa fa-'.$play_btn_icon.'"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <a class="vimeo-volume" href="javascript:;" onclick=""><i class="fa fa-'.$mute_btn_icon.' "></i></a>
	  </p>';
	 }
 }
	 
	  
	 ?>
</section>