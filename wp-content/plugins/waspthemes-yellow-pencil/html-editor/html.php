<?php



/* ---------------------------------------------------- */
/* Template Post Type									*/
/* ---------------------------------------------------- */
function yp_templates_post_type(){

	register_post_type('yp-templates',
		array(
			'labels' => array(
			'name' => __( 'Templates' ),
			'singular_name' => __( 'Template' )
		),
		'public' => true,
	    'publicly_queryable' => false,
	    'show_ui' => true, 
	    'show_in_menu' => true, 
	    'capability_type' => 'page',
	    'has_archive' => true, 
	    'supports' => array('title')
	));

}

add_action( 'init', 'yp_templates_post_type' );



/* ---------------------------------------------------- */
/* Template Post Type									*/
/* ---------------------------------------------------- */
function yp_add_new_layout_redirect() {

    $current_screen = get_current_screen();

    // If is "add template" page
    if($current_screen->id === "yp-templates") {

    	if($current_screen->base === "post"){

    		if(isset($_GET['post'])){
    			$post_id = $_GET['post'];
    		}else{
    			$post_id = 0;
    		}

			$href_url = esc_url(WT_PLUGIN_URL.'html-editor/template.php');
			$href_url = add_query_arg(array('yp-template-id' => $post_id),$href_url);
			$href_url = yp_urlencode($href_url);

    		$add_new_editor_link = get_admin_url(NULL, "admin.php?page=yellow-pencil-editor&href='$href_url'&yp-template-id='$post_id'");

    		wp_safe_redirect( $add_new_editor_link );

    	}

	}
    
}

add_action( 'current_screen', 'yp_add_new_layout_redirect' );



/* ---------------------------------------------------- */
/* Template Redirect									*/
/* ---------------------------------------------------- */
function yp_custom_template_update($page_template){

	// custom-field : template var ise; 
    if(is_page('elementor-6')){
        $page_template = dirname( __FILE__ ) . '/template.php';
    }

    return $page_template;

}

add_filter( 'page_template', 'yp_custom_template_update' );