(function($){

// contact form
function IsEmail($email ) {
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
	return emailReg.test( $email );
	}

jQuery("form.contact-form #submit").click(function(){
	var obj     = jQuery(this).parents(".contact-form");
	var Name    = obj.find("input#name").val();
	var Email   = obj.find("input#email").val();
	var Message = obj.find("textarea#message").val();
	var sendto  = obj.find("input#sendto").val();
	var notice  = obj.find(".noticefailed");
	Name        = Name.replace('Name','');
	Email       = Email.replace('Email','');
	Message     = Message.replace('Message','');
	
	if( !notice.length ){
		obj.append('<div class="noticefailed"></div>');
		notice  = obj.find(".noticefailed");
	}

	notice.text("");

	if(Name ===''){

		notice.html("Please enter your name.");
		return false;
	}

	if( !IsEmail( Email ) ) {
		notice.html("Please enter valid email.");
		return false;
	}

	if(Message === ''){
		notice.html("Message is required.");
		return false;
	}

	notice.html("");
	notice.append("<img alt='loading' class='loading' src='"+onetone_params.themeurl+"/images/loading.gif' />");

	jQuery.ajax({
		type:"POST",
		dataType:"json",
		url:onetone_params.ajaxurl,
		data:{'Name':Name,'Email':Email,'Message':Message,'sendto':sendto,'action':'onetone_contact'},
		success:function(data){ 
			if(data.error==0){
				notice.addClass("noticesuccess").removeClass("noticefailed");
				obj.find(".noticesuccess").html(data.msg);
			}else{
				notice.html(data.msg);	
			}
			jQuery('.loading').remove();obj[0].reset();
			},
		error:function(){
			notice.html("Error.");
			obj.find('.loading').remove();
			}
		});
	});

//top menu
$(".site-navbar,.home-navbar").click(function(){
		$(".top-nav").toggle();
	});

	$('.top-nav ul li').hover(function(){

		$(this).find('ul:first').slideDown(100);
		$(this).addClass("hover");
	},function(){
		$(this).find('ul').css('display','none');
		$(this).removeClass("hover");
	});
	$('.top-nav li ul li:has(ul)').find("a:first").append(" <span class='menu_more'>»</span> ");

	var windowWidth = $(window).width(); 
	if(windowWidth > 939){
		if($(".site-main .sidebar").height() > $(".site-main .main-content").height()){
			$(".site-main .main-content").css("height",($(".site-main .sidebar").height()+140)+"px");
		}
	}else{
			$(".site-main .main-content").css("height","auto");
	}

	$(window).resize(function() {

		var windowWidth = $(window).width(); 
		if(windowWidth > 939){

			if( $(".site-main .sidebar").height() > $(".site-main .main-content").height() ){
				$(".site-main .main-content").css("height",($(".site-main .sidebar").height()+140)+"px");
			}
			}else{
			$(".site-main .main-content").css("height","auto");
			}	
	  
	if(windowWidth > 919){
		$(".top-nav").show();
	}else{
		$(".top-nav").hide();
	}
	});
	
})(jQuery);


jQuery(document).ready(function($){
								
	var adminbarHeight = function(){
		
		var stickyTop;
    if ($("body.admin-bar").length) {

        if ($(window).width() < 765) {
            stickyTop = 46;
        } else {
            stickyTop = 32;
        }
    } else {
        stickyTop = 0;
    }
	
	return stickyTop;
	
	}

	var is_rtl = false;
	var stickyTop;
	if( onetone_params.is_rtl == '1' )
	is_rtl = true;
	
	stickyTop = adminbarHeight();
	
 //slider
	if( $("section.homepage-slider .item").length >1 ){

	if( onetone_params.slide_fullheight == '1' && $(window).width() > 1024 ){
		$('section.homepage-slider').height($(window).height()-stickyTop);
		$('section.homepage-slider .item').height($(window).height()-stickyTop);
	}

	$("#onetone-owl-slider").owlCarousel({
		nav:onetone_params.slider_control == '1'?true:false,
		dots:onetone_params.slider_pagination == '1'?true:false,
		slideSpeed : 300,
		items:1,
		autoplay:onetone_params.slide_autoplay == '1'?true:false,
		margin:0,
		rtl: is_rtl,
		loop:true,
		paginationSpeed : 400,
		singleItem:true,
		autoplayTimeout:parseInt(onetone_params.slideSpeed)
	 
	});
	}
	
	//related posts
	if($(".onetone-related-posts").length){
		$(".onetone-related-posts").owlCarousel({
			navigation : false, // Show next and prev buttons
			pagination: false,
			loop:false,
			items:4,
			slideSpeed : 300,
			paginationSpeed : 400,
			margin:15,
			rtl: is_rtl,
			singleItem:false,
			responsive:{
			320:{
				items:1,
				nav:false
			},
			768:{
				items:2,
				nav:false
			},
			992:{
				items:3,
				nav:false
			},
			1200:{
				items:4,
				nav:false,
			}
		}
		});
		}

	if($("section.homepage-slider .item").length ==1 ){
		$("section.homepage-slider .owl-carousel").show();
	}

	$(".site-nav-toggle").click(function(){
		$(".site-nav").toggle();
	});
// retina logo
	if( window.devicePixelRatio > 1 ){
		if($('.normal_logo').length && $('.retina_logo').length){
			$('.normal_logo').hide();
			$('.retina_logo').show();
		}
		
	$('.page-title-bar').addClass('page-title-bar-retina');
	
	}
	
//video background
	var myPlayer;
	$(function () {
	myPlayer = $("#onetone-youtube-video").YTPlayer();

	$("#onetone-youtube-video").on("YTPReady",function(e){
		$(".onetone-youtube-section,.onetone-youtube-section section").css('background', 'none');
		$("#video-controls").show();
	});
});

// BACK TO TOP
$(window).scroll(function(){
	if($(window).scrollTop() > 200){
		$("#back-to-top").fadeIn(200);
	} else{
		$("#back-to-top").fadeOut(200);
	}
});
	
$('#back-to-top, .back-to-top').click(function() {
	$('html, body').animate({ scrollTop:0 }, '800');
	return false;
});

//parallax background image
$('.onetone-parallax').parallax("50%", 0.1);

// parallax scrolling
if( $('.parallax-scrolling').length ){
	$('.parallax-scrolling').parallax({speed : 0.15});
}

//sticky header
$(window).scroll(function(){

	var scrollTop = $(window).scrollTop(); 

	if( $('div.fxd-header').length ){
		if (scrollTop > 0 ) {
			$('.fxd-header').css({'top':stickyTop}).show();
			$('header').addClass('fixed-header');
		}else{
			$('.fxd-header').hide();
			$('header').removeClass('fixed-header');
		}
	}
});

// scheme
	if( typeof onetone_params.primary_color !== 'undefined' && onetone_params.primary_color !== '' ){
 less.modifyVars({
		'@color-main': onetone_params.primary_color
	});
	}

// sticky header
$(document).on('click', "a.scroll,.onetone-nav a[href^='#']",function(e){

	if($(window).width() <= 919) {
		$(".site-nav").hide();
	}

	var selectorHeight = 0;
	if( $('.fxd-header').length )
		var selectorHeight = $('.fxd-header').outerHeight();  
				
	var scrollTop = $(window).scrollTop(); 
	e.preventDefault();
	var id = $(this).attr('href');
	if(typeof $(id).offset() !== 'undefined'){
	
		var goTo = $(id).offset().top - selectorHeight - stickyTop  + 1;
		$("html, body").animate({ scrollTop: goTo }, 1000);
	}

	});

	$('header .site-nav ul,ul.onetone-dots').onePageNav({filter: 'a[href^="#"]',scrollThreshold:0.3});	

// smooth scrolling  btn 
$("div.page a[href^='#'],div.post a[href^='#'],div.home-wrapper a[href^='#'],.banner-scroll a[href^='#']").on('click', function(e){
	var selectorHeight = $('header').height();   
	var scrollTop = $(window).scrollTop(); 
	e.preventDefault();
	var id = $(this).attr('href');
		
	if(typeof $(id).offset() !== 'undefined'){
		var goTo = $(id).offset().top - selectorHeight;
		$("html, body").animate({ scrollTop: goTo }, 1000);
	}
});

//prettyPhoto
$("a[rel^='portfolio-image']").prettyPhoto();	 
// gallery lightbox
$(".gallery .gallery-item a").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});

if($(window).width() <1200){	
	newPercentage = (($(window).width() / 1200) * 100) + "%";
	$(".home-banner .heading-inner").css({"font-size": newPercentage});
}

$(window).on("resize", function (){
	if($(window).width() <1200){
		newPercentage = (($(window).width() / 1200) * 100) + "%";
		$(".home-banner .heading-inner").css({"font-size": newPercentage});
	}else{
		$(".home-banner .heading-inner").css({"font-size": "100%"});
	}
	});

// section fullheight
var win_height = $(window).height();

$("section.fullheight").each(function(){
	var section_height = $(this).height();
	$(this).css({'height':section_height,'min-height':win_height});
	});

   // hide animation items

$('.onetone-animated').each(function(){
	if($(this).data('imageanimation')==="yes"){
		$(this).find("img,i.fa").css("visibility","hidden");	
	}
	else{
		$(this).css("visibility","hidden");	
	}

});

// section one animation
if( $('.onetone-animated').length &&  $(window).height() > $('.onetone-animated:first').offset().top  ){
	onetone_animation($('.onetone-animated:first'));
}

// counter up
setTimeout(function () {
	$('.magee-counter-box .counter-num').counterUp({
		delay: 10,
		time: 1000
	});
}, 5000);

});

// home page animation
function onetone_animation(e){
	
	e.css({'visibility':'visible'});
		e.find("img,i.fa").css({'visibility':'visible'});	

			// this code is executed for each appeared element
		var animation_type       = e.data('animationtype');
		var animation_duration   = e.data('animationduration');
		var image_animation      = e.data('imageanimation');
		if(image_animation === "yes"){
						 
		e.find("img,i.fa").addClass("animated "+animation_type);

		if(animation_duration) {
			e.find("img,i.fa").css('-moz-animation-duration', animation_duration+'s');
			e.find("img,i.fa").css('-webkit-animation-duration', animation_duration+'s');
			e.find("img,i.fa").css('-ms-animation-duration', animation_duration+'s');
			e.find("img,i.fa").css('-o-animation-duration', animation_duration+'s');
			e.find("img,i.fa").css('animation-duration', animation_duration+'s');
		}

	}else{
		e.addClass("animated "+animation_type);

		if(animation_duration) {
			e.css('-moz-animation-duration', animation_duration+'s');
			e.css('-webkit-animation-duration', animation_duration+'s');
			e.css('-ms-animation-duration', animation_duration+'s');
			e.css('-o-animation-duration', animation_duration+'s');
			e.css('animation-duration', animation_duration+'s');
		}
	}
	}

	var animated = false;
	jQuery(window).scroll(function () {
		
		if(jQuery().waypoint && animated == false ) {

			jQuery('.onetone-animated').waypoint(function() {
				onetone_animation(jQuery(this));
			},{ triggerOnce: true, offset: '90%' });
		}
	animated = true;

});