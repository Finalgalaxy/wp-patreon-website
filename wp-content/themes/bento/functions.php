<?php // Theme Functions


// Theme setup
add_action( 'after_setup_theme', 'bento_theme_setup' );

function bento_theme_setup() {
	
	// Features
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'project', 'product' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'quote', 'link', 'image' ) );
	add_theme_support( 'woocommerce' ); 
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'custom-background', array ( 'default-color' => '#f4f4f4' ) );
	
	// Actions
	add_action( 'wp_enqueue_scripts', 'bento_theme_styles_scripts' );
	add_action( 'admin_enqueue_scripts', 'bento_admin_scripts' );
	add_action( 'admin_menu', 'bento_about_page' );
	add_action( 'load-themes.php', 'bento_add_welcome_message' );
	add_action( 'template_redirect', 'bento_theme_adjust_content_width' );
	add_action( 'init', 'bento_page_excerpt_support' );
	add_action( 'get_header', 'bento_enable_threaded_comments' );
	add_action( 'tgmpa_register', 'bento_register_required_plugins' );
	add_action( 'wp_ajax_ajax_pagination', 'bento_ajax_pagination' );
	add_action( 'wp_ajax_nopriv_ajax_pagination', 'bento_ajax_pagination' );
	add_action( 'widgets_init', 'bento_register_sidebars' );
	add_action( 'comment_form_defaults', 'bento_comment_form_defaults' );
	add_filter( 'comment_form_fields', 'bento_rearrange_comment_fields' );
	add_action( 'comment_form_default_fields', 'bento_comment_form_fields' );
	add_action( 'wp_ajax_bento_migrate_customizer_options', 'bento_migrate_customizer_options' );
	add_action( 'wp_ajax_nopriv_bento_migrate_customizer_options', 'bento_migrate_customizer_options' );
		
	// Filters
	add_filter( 'excerpt_more', 'bento_custom_excerpt_more' );
	add_filter( 'get_custom_logo', 'bento_get_custom_logo' );
	add_filter( 'get_the_excerpt', 'bento_grid_excerpt' );
	add_filter( 'body_class', 'bento_extra_classes' );
	add_filter( 'post_class', 'bento_has_thumb_class' );
	add_filter( 'get_the_archive_title', 'bento_cleaner_archive_titles' );
	add_filter( 'cmb2_admin_init', 'bento_metaboxes' );
	add_filter( 'dynamic_sidebar_params', 'bento_count_footer_widgets', 50 );
	
	// Languages
	load_theme_textdomain( 'bento', get_template_directory() . '/languages' );
	
	// Initialize navigation menus
	register_nav_menus(
		array(
			'primary-menu' => esc_html__( 'Primary Menu', 'bento' ),
			'footer-menu' => esc_html__( 'Footer Menu', 'bento' ),
		)
	);
	
	// Customizer options
	if ( file_exists( get_template_directory() . '/includes/customizer/customizer.php' ) ) {
		require_once( get_template_directory() . '/includes/customizer/customizer.php' );
	}
	add_action( 'customize_register', 'bento_customize_register' );
	add_action( 'customize_register', 'bento_customizer_rename_sections' );
	add_action( 'customize_controls_print_styles', 'bento_customizer_stylesheet' );
	add_action( 'customize_controls_enqueue_scripts', 'bento_customizer_scripts' );
	add_action( 'admin_notices', 'bento_customizer_admin_notice' );
	
	// SiteOrigin Content Builder integration
	add_filter('siteorigin_panels_row_attributes', 'bento_extra_row_attr', 10, 2);
	add_filter('siteorigin_panels_before_row', 'bento_content_builder_row_ids', 10, 3);
	
	// WooCommerce integration
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20, 0 );
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	add_action( 'woocommerce_before_main_content', 'bento_woo_wrapper_start', 10 );
	add_action( 'woocommerce_single_product_summary', 'bento_woo_product_title', 5 );
	add_action( 'woocommerce_after_main_content', 'bento_woo_wrapper_end', 10 );
	add_action( 'woocommerce_before_single_product_summary', 'bento_woo_single_product_sections_start', 20 );
	add_action( 'woocommerce_after_single_product_summary', 'bento_woo_single_product_sections_end', 20 );
	add_filter( 'woocommerce_enqueue_styles', 'bento_woo_dequeue_styles' );
	add_filter( 'woocommerce_product_add_to_cart_text', 'bento_woo_custom_cart_button_text' );  
	add_filter( 'get_product_search_form', 'bento_woo_custom_product_searchform' );
	add_filter( 'loop_shop_columns', 'bento_woo_loop_columns' );
	add_filter( 'loop_shop_per_page', 'bento_woo_loop_perpage', 20 );
	    
}


// Register and enqueue CSS and scripts
function bento_theme_styles_scripts () {	
	
	// Scripts
	wp_enqueue_script( 'jquery-isotope', get_template_directory_uri().'/includes/isotope/isotope.pkgd.min.js', array('jquery', 'imagesloaded'), false, true );
	wp_enqueue_script( 'jquery-packery', get_template_directory_uri().'/includes/isotope/packery-mode.pkgd.min.js', array('jquery', 'imagesloaded'), false, true );
	wp_enqueue_script( 'jquery-fitcolumns', get_template_directory_uri().'/includes/isotope/fit-columns.js', array('jquery'), false, true );
	wp_enqueue_script( 'jquery-fitvids', get_template_directory_uri().'/includes/fitvids/jquery.fitvids.js', array('jquery'), false, true );
	wp_enqueue_script( 'bento-theme-scripts', get_template_directory_uri().'/includes/js/theme-scripts.js', array('jquery'), false, true );
		
	// Styles
	wp_enqueue_style( 'bento-theme-styles', get_template_directory_uri().'/style.css', array( 'dashicons' ), null, 'all' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/includes/font-awesome/css/font-awesome.min.css', array(), null, 'all' );
	wp_enqueue_style( 'google-fonts', bento_google_fonts(), array(), null );
		
	// Passing php variables to theme scripts
	bento_localize_scripts();

	// Inline styles for customizing the theme
	wp_add_inline_style( 'bento-theme-styles', bento_customizer_css() );
	wp_add_inline_style( 'bento-theme-styles', bento_insert_custom_styles() );
	    
}


// Admin scripts
function bento_admin_scripts () {
	
	// Enqueue scripts
	$screen = get_current_screen();
	$edit_screens = array( 'post', 'page', 'project', 'product' );
	if ( in_array( $screen->id, $edit_screens ) ) {
		wp_enqueue_script( 'bento-admin-scripts', get_template_directory_uri().'/includes/admin/admin-scripts.js', array('jquery'), false, true );
	}
	$old_options = get_option( 'satori_options', 'none' );
	if ( $old_options != 'none' ) {
		wp_enqueue_script( 'bento-migrate-scripts', get_template_directory_uri().'/includes/js/migrate-scripts.js', array('jquery'), false, true );
	}
	if ( 'appearance_page_about-bento' == $screen->id ) {
		wp_enqueue_style( 'bento-admin-styles', get_template_directory_uri().'/includes/admin/admin-styles.css', array(), null, 'all' );
	}
	
	// Passing php variables to admin scripts
	bento_localize_migrate_scripts();
	
}


// Register theme status for the Expansion Pack
function bento_active() {
	$current_theme = wp_get_theme();
	if ( $current_theme == 'Bento' ) {
		return true;
	} else {
		return false;
	}
}


// Welcome notice and page
	
	// Add welcome message
	function bento_add_welcome_message() {
		$screen = get_current_screen();
		if ( is_admin() && ( 'themes' == $screen->id ) && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', 'bento_render_welcome_message', 99 );
		}
	}
	
	// Display welcome message
	function bento_render_welcome_message() {
		?>
			<div class="notice notice-success is-dismissible">
				<p><?php echo sprintf( esc_html__( 'Thank you for choosing Bento! Visit the %swelcome page%s to get the most out of the theme:', 'bento' ), '<a href="' . esc_url( admin_url( 'themes.php?page=about-bento' ) ) . '">', '</a>' ); ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=about-bento' ) ); ?>" class="button button-primary" style="text-decoration: none;"><?php esc_html_e( 'Get started with Bento', 'bento' ); ?></a></p>
			</div>
		<?php
	}
	
	// Create the submenu item
	function bento_about_page() {
		add_theme_page( esc_html__( 'Welcome to Bento!', 'bento' ), esc_html__( 'About Bento', 'bento' ), 'edit_theme_options', 'about-bento', 'bento_about_page_content' );
	}
	
	// Render page content
	function bento_about_page_content() {
		$current_theme = wp_get_theme();
		$theme_version = $current_theme->get( 'Version' );
		$theme_actions = array(
			array(
				'name' => 'demo',
				'text' => esc_html__( 'See full demonstration', 'bento' ),
				'url' => esc_url( 'http://satoristudio.net/bento/' ),
				'icon' => '<span class="dashicons dashicons-welcome-view-site"></span>',
			),
			array(
				'name' => 'manual',
				'text' => esc_html__( 'Detailed instructions', 'bento' ),
				'url' => esc_url( 'http://satoristudio.net/bento-manual/' ),
				'icon' => '<span class="dashicons dashicons-book-alt"></span>',
			),
			array(
				'name' => 'support',
				'text' => esc_html__( 'Visit official forum', 'bento' ),
				'url' => esc_url( 'https://wordpress.org/support/theme/bento/' ),
				'icon' => '<span class="dashicons dashicons-sos"></span>',
			),
		);
		$actions_html = '';
		foreach ( $theme_actions as $theme_action ) {
			$action = '
				<div class="bento-welcome-action bento-welcome-'.$theme_action['name'].'">
					<div class="bento-welcome-action-inner">
						<a href="'.$theme_action['url'].'" target="_blank">
							<div class="bento-welcome-action-icon">
								'.$theme_action['icon'].'
							</div>
							<div class="bento-welcome-action-title">
								'.ucfirst($theme_action['name']).'
							</div>
							<div class="bento-welcome-action-text">
								'.$theme_action['text'].'
							</div>
						</a>
					</div>
				</div>
			';
			$actions_html .= $action;
		}
		$upgrade_html = '';
		$ep_features = array(
			array (
				'title' => esc_html__( 'Footer copyright', 'bento' ),
				'text' => esc_html__( 'customize or remove the copyright statement in the footer', 'bento' ),
				'url' => esc_url( '' ),
			),
			array (
				'title' => esc_html__( 'Portfolio', 'bento' ),
				'text' => esc_html__( 'add stunning corporate portfolios, online storefronts, or personal showcases.', 'bento' ),
				'url' => esc_url( 'http://satoristudio.net/bento/portfolio-masonry/' ),
			),
			array (
				'title' => esc_html__( 'Pre-built layouts', 'bento' ),
				'text' => esc_html__( 'simplify the process of creating new pages using ready-made layouts.', 'bento' ),
				'url' => esc_url( 'http://satoristudio.net/bento/pre-built-layouts/' ),
			),
			array (
				'title' => esc_html__( 'Video and maps headers', 'bento' ),
				'text' => esc_html__( 'make your pages stand out with custom header content.', 'bento' ),
				'url' => esc_url( 'http://satoristudio.net/bento/video-background-in-header/' ),
			),
			array (
				'title' => esc_html__( 'Preloaders', 'bento' ),
				'text' => esc_html__( 'show your visitors a stylish progress animation until the page is fully loaded.', 'bento' ),
				'url' => esc_url( 'http://satoristudio.net/bento/preloader/' ),
			),
			array (
				'title' => esc_html__( 'And', 'bento' ),
				'text' => esc_html__( 'tons of other cool features.', 'bento' ),
				'url' => esc_url( 'http://satoristudio.net/bento-free-wordpress-theme/#expansion-pack' ),
			),
		);
		foreach ( $ep_features as $ep_feature ) {
			$link = '';
			if ( $ep_feature['url'] != '' ) {
				$link = '<a href="'.$ep_feature['url'].'" target="_blank">'.esc_html__( 'Preview', 'bento' ).'</a>';
			}
			$upgrade_html .= '
				<li><strong>'.$ep_feature['title'].'</strong>: '.$ep_feature['text'].' '.$link.'</li>';
		}
		?>
			<div class="wrap bento-welcome-container">
				<h1><?php esc_html_e( 'Thank you for choosing Bento!', 'bento' ); ?></h1>
				<div class="bento-welcome-about">
					<div class="bento-welcome-top">
						<a class="bento-welcome-rate" href="<?php echo esc_url( 'https://wordpress.org/support/theme/bento/reviews/' ); ?>" target="_blank">
							<span class="dashicons dashicons-heart"></span>
							<span class="bento-welcome-rate-link">
								<?php esc_html_e( 'Rate the theme', 'bento' ); ?>
							</span>
						</a>
					</div>
					<div class="bento-welcome-description">
						<?php esc_html_e( 'Bento is a powerful yet user-friendly WordPress theme intended for use in the broadest range of web projects. It boasts premium-grade design and is packed with awesome features, some of which are unique for free themes. Bento is mobile-friendly (responsive), retina-ready, optimized for speed, and implements SEO (search engine optimization) best practices. The theme is being constantly maintained by its author and offers regular free updates with bugfixes and additional features.', 'bento' ); ?>
					</div>
				</div>
				<div class="bento-welcome-actions">
					<?php echo $actions_html; ?>
				</div>
				<div class="bento-welcome-upgrade">
					<h2><?php esc_html_e( 'Supercharge your Bento', 'bento' ); ?> &mdash;</h2>
					<div class="bento-welcome-upgrade-cta">
						<a href="<?php echo esc_url( 'http://satoristudio.net/bento-free-wordpress-theme/#expansion-pack' ); ?>" class="button button-primary" target="_blank"><?php esc_html_e( 'Get the Expansion Pack', 'bento' ); ?></a>
					</div>
					<ul class="bento-welcome-upgrade-features">
						<?php echo $upgrade_html; ?>
					</ul>
				</div>
			</div>
		<?php
	}


// Localize scripts
function bento_localize_scripts() {
	$bento_query = new WP_Query( bento_grid_query() );
	$bento_max_pages = $bento_query->max_num_pages; 
	$postid = get_queried_object_id();
	$bento_grid_mode = 'nogrid';
	$bento_grid_setting = get_post_meta( $postid, 'bento_page_grid_mode', true );
	if ( get_page_template_slug($postid) == 'grid.php' ) {
		if ( $bento_grid_setting == 'rows' ) {
			$bento_grid_mode = 'fitRows';
		} else {
			$bento_grid_mode = 'packery';
		}
	}
	$bento_full_width_grid = 'off';
	if ( get_post_meta( $postid, 'bento_grid_full_width', true ) == 'on' ) {
		$bento_full_width_grid = 'on';
	}
    wp_localize_script( 'bento-theme-scripts', 'bentoThemeVars', array(
		'menu_config' => esc_html( get_theme_mod( 'bento_menu_config' ) ),
		'fixed_menu' => esc_html( get_theme_mod( 'bento_fixed_header' ) ),
		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
	    'query_vars' => wp_json_encode( $bento_query->query ),
        'max_pages' => esc_html( $bento_max_pages ),
		'grid_mode' => esc_html( $bento_grid_mode ),
		'full_width_grid' => esc_html( $bento_full_width_grid ),
    ));
	wp_reset_postdata();
}
function bento_localize_migrate_scripts() {
	wp_localize_script( 'bento-migrate-scripts', 'bentoMigrateVars', array(
		'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
	));
}


// Custom styles
function bento_insert_custom_styles() {
	
	$custom_css = '';
	
	// Grid
	$postid = get_queried_object_id();
	if ( is_singular() && get_page_template_slug( $postid ) == 'grid.php' ) {
		$bento_grid_gutter = 10;
		$bento_grid_column = 3;
		$bento_grid_column_width = 33.3333;
		if ( get_post_meta( $postid, 'bento_page_columns', true ) > 0 ) {
			$bento_grid_column = esc_html( get_post_meta( $postid, 'bento_page_columns', true ) ); 
		}
		$bento_grid_column_width = 100 / $bento_grid_column;
		$bento_gutter_setting = esc_html( get_post_meta( $postid, 'bento_page_item_margins', true ) ); 
		if ( is_numeric($bento_gutter_setting) ) {
			$bento_grid_gutter = $bento_gutter_setting;
		}
		if ( strpos($bento_gutter_setting, 'px') !== false ) {
			$bento_grid_gutter = substr($bento_gutter_setting, 0, -2);
		}
		$bento_grid_double_width = $bento_grid_column_width * 2;
		
		$custom_css .= '
			@media screen and (min-width: 10em) {
				.grid-item,
				.grid-sizer {
					width: 100%;	
				}
			}
			@media screen and (min-width: 48em) {
				.grid-item,
				.grid-sizer {
					width: '.$bento_grid_column_width.'%;	
				}
				.grid-masonry .grid-item.tile-2x1,
				.grid-masonry .grid-item.tile-2x2 {
					width: '.$bento_grid_double_width.'%;
				}
			}
			.grid-container {
				margin: 0 -'.$bento_grid_gutter.'px;	
			}
			.grid-item-inner {
				padding: '.$bento_grid_gutter.'px;	
			}
			.grid-rows .grid-item {
				margin-bottom: '.$bento_grid_gutter.'px;	
				padding-bottom: '.$bento_grid_gutter.'px;	
			}
		';
	}
	
	// Individual page/post settings
	if ( is_singular() ) {
		$custom_css .= '
			.post-header-title h1,
			.entry-header h1 { 
				color: '.esc_html( get_post_meta( $postid, 'bento_title_color', true ) ).'; 
			}
			.post-header-subtitle {
				color: '.esc_html( get_post_meta( $postid, 'bento_subtitle_color', true ) ).';
			}
			.site-content {
				background-color: '.esc_html( get_post_meta( $postid, 'bento_page_background_color', true ) ).';
			}
		';
		if ( get_post_meta( $postid, 'bento_hide_title', true ) == 'on' ) {
			$custom_css .= '
				.post-header-title h1,
				.entry-title:not(.grid-item-header .entry-title),
				.post-header-subtitle { 
					display: none;
				}
			';
		}
		if ( get_post_meta( $postid, 'bento_title_position', true ) == 'center' ) {
			$custom_css .= '
				.post-header-title,
				.post-header-subtitle {
					margin-left: auto;
					margin-right: auto;
				}
				.post-header-title h1,
				.entry-header h1,
				.post-header-subtitle,
				.portfolio-filter,
				.post-header-cta {
					text-align: center;
				}
				.post-header-cta {
					margin-left: 0;
				}
			';
		}
		if ( get_post_meta( $postid, 'bento_uppercase_title', true ) == 'on' ) {
			$custom_css .= '
				.post-header-title h1,
				.entry-header h1 { 
					text-transform: uppercase;
				}
			';
		}
		$postheader = '';
		if ( get_post_meta( $postid, 'bento_activate_header', true ) != '' && get_post_meta( $postid, 'bento_header_image', true ) != '' ) {
			$postheader = esc_url( get_post_meta( $postid, 'bento_header_image', true ) );
		} else if ( has_post_thumbnail( $postid ) ) {
			$postheader = get_the_post_thumbnail_url( $postid, 'full' );
		}
		if ( is_front_page() && 'page' == get_option('show_on_front') ) {
			if ( get_theme_mod( 'bento_front_header_image' ) != '' ) {
				$postheader_obj = wp_get_attachment_image_src( get_theme_mod( 'bento_front_header_image' ), 'full' );
				if ( $postheader_obj ) {
					$postheader = esc_url( $postheader_obj[0] );
				}
			}	
		}
		if ( $postheader != '' ) {
			$custom_css .= '
				.post-header {
					background-image: url('.$postheader.');
				}
			';
		}
		if ( get_post_meta( $postid, 'bento_activate_header', true ) != '' ) {
			$tile_opacity_raw = esc_html( get_post_meta( $postid, 'bento_header_overlay_opacity', true ) );
			if ( $tile_opacity_raw > 1 ) {
				$tile_opacity_raw = $tile_opacity_raw / 10;
			}
			$custom_css .= '
				.post-header-overlay {
					background-color: '.esc_html( get_post_meta( $postid, 'bento_header_overlay', true ) ).';
					opacity: '.$tile_opacity_raw.';
				}
				.post-header-subtitle {
					margin-bottom: 0;
				}
				.post-header-cta a,
				.post-header-cta div {
					border-color: '.esc_html( get_post_meta( $postid, 'bento_cta_background_color', true ) ).';
				}
				.post-header-cta .post-header-cta-primary {
					background-color: '.esc_html( get_post_meta( $postid, 'bento_cta_background_color', true ) ).';
					color: '.esc_html( get_post_meta( $postid, 'bento_cta_text_color', true ) ).';
				}
				.post-header-cta .post-header-cta-secondary {
					color: '.esc_html( get_post_meta( $postid, 'bento_cta_background_color', true ) ).';
				}
				.post-header-cta a:hover,
				.post-header-cta div:hover {
					border-color: '.esc_html( get_post_meta( $postid, 'bento_cta_background_color_hover', true ) ).';
				}
				.post-header-cta .post-header-cta-primary:hover {
					background-color: '.esc_html( get_post_meta( $postid, 'bento_cta_background_color_hover', true ) ).';
				}
				.post-header-cta .post-header-cta-secondary:hover {
					color: '.esc_html( get_post_meta( $postid, 'bento_cta_background_color_hover', true ) ).';
				}
				.post-header-cta .post-header-cta-secondary {
					color: '.esc_html( get_post_meta( $postid, 'bento_cta_secondary_color', true ) ).';
					border-color: '.esc_html( get_post_meta( $postid, 'bento_cta_secondary_color', true ) ).';
				}
				.post-header-cta .post-header-cta-secondary:hover {
					color: '.esc_html( get_post_meta( $postid, 'bento_cta_secondary_color_hover', true ) ).';
					border-color: '.esc_html( get_post_meta( $postid, 'bento_cta_secondary_color_hover', true ) ).';
				}
				@media screen and (min-width: 48em) {
					.post-header-title {
						padding-top: '.esc_html( get_post_meta( $postid, 'bento_header_image_height', true ) ).';
						padding-bottom: '.esc_html( get_post_meta( $postid, 'bento_header_image_height', true ) ).';
					}
				}
			';
			if ( get_post_meta( $postid, 'bento_transparent_header', true ) == 'on' && get_theme_mod( 'bento_menu_config' ) != 'side' ) {
				$custom_css .= '
					.site-header.no-fixed-header {
						background: transparent;
						position: absolute;
						top: 0;
						width: 100%;
					}
					.primary-menu > li > .sub-menu {
						border-top-color: transparent;
					}
					.no-fixed-header .primary-menu > li > a, 
					.site-header .mobile-menu-trigger,
					.site-header .ham-menu-trigger {
						color: '.esc_html( get_post_meta( $postid, 'bento_menu_color', true ) ).';
					}
					.no-fixed-header .primary-menu > li > a:hover {
						color: '.esc_html( get_post_meta( $postid, 'bento_menu_color_hover', true ) ).';
					}
				';
			}
		}
		if ( is_front_page() && 'page' == get_option('show_on_front') ) {
			$custom_css .= '
				.post-header-cta a,
				.post-header-cta div {
					border-color: '.esc_html( get_theme_mod( 'bento_front_header_primary_cta_bck_color', '#ffffff' ) ).';
				}
				.post-header-cta .post-header-cta-primary {
					background-color: '.esc_html( get_theme_mod( 'bento_front_header_primary_cta_bck_color', '#ffffff' ) ).';
					color: '.esc_html( get_theme_mod( 'bento_front_header_primary_cta_text_color', '#333333' ) ).';
				}
				.post-header-cta a:hover,
				.post-header-cta div:hover {
					border-color: '.esc_html( get_theme_mod( 'bento_front_header_primary_cta_bck_color_hover', '#cccccc' ) ).';
				}
				.post-header-cta .post-header-cta-primary:hover {
					background-color: '.esc_html( get_theme_mod( 'bento_front_header_primary_cta_bck_color_hover', '#cccccc' ) ).';
				}
				.post-header-cta .post-header-cta-secondary {
					color: '.esc_html( get_theme_mod( 'bento_front_header_secondary_cta_color', '#ffffff' ) ).';
					border-color: '.esc_html( get_theme_mod( 'bento_front_header_secondary_cta_color', '#ffffff' ) ).';
				}
				.post-header-cta .post-header-cta-secondary:hover {
					color: '.esc_html( get_theme_mod( 'bento_front_header_secondary_cta_color_hover', '#cccccc' ) ).';
					border-color: '.esc_html( get_theme_mod( 'bento_front_header_secondary_cta_color_hover', '#cccccc' ) ).';
				}
			';
		}
	}
	
	return $custom_css;
	
}


// Load custom template tags
if ( file_exists( get_template_directory() . '/includes/template-tags.php' ) ) {
	require_once get_template_directory() . '/includes/template-tags.php';
}


// Set the content width
$GLOBALS['content_width'] = 1440;
function bento_theme_adjust_content_width() {
	$content_width = $GLOBALS['content_width'];
	$postid = get_queried_object_id();
	if ( get_theme_mod( 'bento_content_width', 1080 ) > 0 ) {
		$content_width = get_theme_mod( 'bento_content_width', 1080 ) + 360;
		if ( get_theme_mod( 'bento_website_layout', 0 ) == 1 ) {
			$content_width = $content_width + 120;
		}
	}
	if ( ( is_singular() && get_post_meta( $postid, 'bento_sidebar_layout', true ) != 'full-width' ) || is_home() ) {
		$content_width = $content_width * 0.7;
	}
	$GLOBALS['content_width'] = apply_filters( 'bento_theme_adjust_content_width', $content_width );
}


// Add excerpt support for pages
function bento_page_excerpt_support() {
	add_post_type_support( 'page', 'excerpt' );
}


// Enable threaded comments
function bento_enable_threaded_comments() {
if ( !is_admin() ) {
	if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1) )
		wp_enqueue_script('comment-reply');
	}
}


// Register sidebars
function bento_register_sidebars() {
	register_sidebar(
		array(
			'name' => esc_html__( 'Sidebar', 'bento' ),
			'id' => 'bento_sidebar',
			'before_widget' => '<div id="%1$s" class="widget widget-sidebar %2$s clear">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	));
	register_sidebar(
		array(
			'name' => esc_html__( 'Footer', 'bento' ),
			'id' => 'bento_footer',
			'before_widget' => '<div id="%1$s" class="widget widget-footer %2$s clear">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
	));
	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(
			array(
				'name' => esc_html__( 'WooCommerce', 'bento' ),
				'id' => 'bento_woocommerce',
				'before_widget' => '<div id="%1$s" class="widget widget-woo %2$s clear">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			)
		);
	}
}


// Comment form defaults
function bento_comment_form_defaults( $defaults ) {
	$defaults['label_submit'] = esc_html__( 'Submit Comment', 'bento' );
    $defaults['comment_notes_before'] = '';
    $defaults['comment_field'] = '
		<div class="comment-form-comment">
			<textarea
				id="comment" 
				name="comment" 
				placeholder="'.esc_html__( 'Comment', 'bento' ).'" 
				cols="45" rows="8" 
				aria-required="true"
			></textarea>
		</div>
	';
	return $defaults;
}


// Move the textarea field to the bottom of comment form
function bento_rearrange_comment_fields( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}


// Comment form fields
function bento_comment_form_fields( $fields ) {
	$commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
	$fields['author'] = '
		<div class="comment-form-field comment-form-author">
			<label for="author">'.esc_html__( 'Name', 'bento' ).'</label>
			<input 
				id="author" 
				name="author" 
				type="text" 
				placeholder="'.esc_html__( 'Name','bento' ).'" 
				value="'.esc_attr( $commenter['comment_author'] ).'" 
				size="30"'.$aria_req.
			' />
		</div>
	';
    $fields['email'] = '
		<div class="comment-form-field comment-form-email">
			<label for="email">'.esc_html__( 'Email', 'bento' ).'</label>
			<input 
				id="email" 
				name="email" 
				type="text" 
				placeholder="'.esc_html__( 'Email','bento' ).'" 
				value="'. esc_attr( $commenter['comment_author_email'] ).'" 
				size="30"'.$aria_req.
			' />
		</div>
	';
	$fields['url'] = '';
	return $fields;
}


// Initialize the metabox class
if ( ! class_exists( 'CMB2_Bootstrap_224' ) ) {
	if ( file_exists( get_template_directory() . '/includes/metaboxes/init.php' ) ) {
		require_once ( get_template_directory().'/includes/metaboxes/init.php' );
	}
}


// Initialize the class for activating bundled plugins
if ( file_exists( get_template_directory() . '/includes/plugin-activation/class-tgm-plugin-activation.php' ) ) {
	require_once ( get_template_directory().'/includes/plugin-activation/class-tgm-plugin-activation.php' );
}
function bento_register_required_plugins() {
	$plugins = array(
		array(
			'name'      => __( 'Page Builder', 'bento' ),
			'slug'      => 'siteorigin-panels',
			'required'  => false,
		),
		array(
			'name'      => __( 'Page Builder: Extra Elements', 'bento' ),
			'slug'      => 'so-widgets-bundle',
			'required'  => false,
		),
	);
	// Array of configuration settings
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'bento-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);
	tgmpa( $plugins, $config );
}


// Custom excerpt ellipses
function bento_custom_excerpt_more($more) {
	return esc_html__('Continue reading', 'bento').' &rarr;';
}


// Custom logo markup
function bento_get_custom_logo() {
	$logo = '<span class="logo-default">'.get_bloginfo( 'name' ).'</span>';
	$logo_class = 'logo-default-link';
	if ( get_theme_mod( 'custom_logo' ) ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo_image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		$logo_full_url = $logo_mobile_url = $logo_image[0];
		$logo = '<img class="logo-fullsize" src="'.esc_url( $logo_full_url ).'" alt="'.esc_attr( get_bloginfo( 'name' ) ).'" />';
		$logo_class = 'logo-image-link';
	}
	if ( get_theme_mod( 'bento_logo_mobile' ) != '' ) {
		if ( ! get_theme_mod( 'custom_logo' ) ) {
			$logo = '<span class="logo-default logo-fullsize">'.get_bloginfo( 'name' ).'</span>';
			$logo_class = 'logo-default-link';
		}
		$mobile_logo_id = get_theme_mod( 'bento_logo_mobile' );
		$mobile_logo_image = wp_get_attachment_image_src( $mobile_logo_id , 'full' );
		$logo_mobile_url = $mobile_logo_image[0];
		$logo .= '<img class="logo-mobile" src="'.esc_url( $logo_mobile_url ).'" alt="'.esc_attr( get_bloginfo( 'name' ) ).'" />';
	} else if ( get_theme_mod( 'custom_logo' ) ) {
		$logo .= '<img class="logo-mobile" src="'.esc_url( $logo_full_url ).'" alt="'.esc_attr( get_bloginfo( 'name' ) ).'" />';
	}
	$logo_html = '<a href="'.esc_url( home_url( '/' ) ).'" class="'.$logo_class.'">'.$logo.'</a>';
	return $logo_html;
}


// Custom excerpt for grid items
function bento_grid_excerpt( $excerpt ) {
	global $bento_parent_page_id; 
	if ( 'grid.php' == get_page_template_slug( $bento_parent_page_id ) ) {
		$content = get_extended( apply_filters( 'the_content', strip_shortcodes( get_the_content() ) ) );
		$content = str_replace( ']]>', ']]&gt;', $content );
		$length = 300;
		if ( ! has_excerpt() ) {
			$content_main = $content['main'];
			if ( strlen($content_main) > $length ) {
				$pos = strpos( $content_main, ' ', $length );
				if ( $pos === false ) {
					$excerpt = $content_main;
				} else {
					$excerpt = substr( $content_main, 0, $pos );
				}
			} else {
				$excerpt = $content_main;
			}
		}
		$excerpt .= '.. <a href="'.esc_url( get_post_permalink() ).'">&rarr;</a>';
		if ( get_post_format() === 'link' ) { 
			$excerpt = bento_link_format_content();
		} elseif ( get_post_format() === 'quote' ) {
			$excerpt = bento_quote_format_content();
		}
		return '<div class="entry-content grid-item-content">'.$excerpt.'</div>';
	} else {
		return $excerpt; 
	}
}


// Extra body classes
function bento_extra_classes( $classes ) {
	$postid = get_queried_object_id();
    
	// Sidebar configuration	
	if ( is_singular() ) {
		if ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
			if ( ! is_active_sidebar( 'bento_woocommerce' ) || get_post_meta( $postid, 'bento_sidebar_layout', true ) == 'full-width' || is_cart() || is_checkout() ) {
				$classes[] = 'no-sidebar';
			} else {
				$classes[] = 'has-sidebar';
				if ( get_post_meta( $postid, 'bento_sidebar_layout', true ) == 'left-sidebar' ) {
					$classes[] = 'left-sidebar';
				} else {
					$classes[] = 'right-sidebar';
				}
			}
		} else {
			if ( ( ! is_active_sidebar( 'bento_sidebar' ) && get_post_type( $postid ) != 'project' ) || get_post_meta( $postid, 'bento_sidebar_layout', true ) == 'full-width' ) {
				$classes[] = 'no-sidebar';
			} else {
				$classes[] = 'has-sidebar';
				if ( get_post_meta( $postid, 'bento_sidebar_layout', true ) != '' ) {
					$classes[] = esc_html( get_post_meta( $postid, 'bento_sidebar_layout', true ) );
				} else {
					$classes[] = 'right-sidebar';
				}
			}
		}
	} else {
		if ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
			if ( is_shop() ) {
				$page_id = wc_get_page_id('shop');
				if ( get_post_meta( $page_id, 'bento_sidebar_layout', true ) == 'full-width' ) {
					$classes[] = 'no-sidebar';	
				} else {
					$classes[] = esc_html( get_post_meta( $page_id, 'bento_sidebar_layout', true ) );
					$classes[] = 'has-sidebar';
				}
			} else {
				if ( is_active_sidebar( 'bento_woocommerce' ) ) {
					$classes[] = 'has-sidebar';	
					$classes[] = 'right-sidebar';
				} else {
					$classes[] = 'no-sidebar';	
				}
			}
		} else {
			if ( is_active_sidebar( 'bento_sidebar' ) ) {
				$classes[] = 'has-sidebar';	
				$classes[] = 'right-sidebar';
			} else {
				$classes[] = 'no-sidebar';	
			}
		}
	}
	
	// Boxed website layout
	if ( get_theme_mod( 'bento_website_layout' ) == 1 ) {
		$classes[] = 'boxed-layout';
	}
	
	// Extended header
	if ( get_post_meta( $postid, 'bento_activate_header', true ) == 'on' ) {
		$classes[] = 'extended-header';
	}
	
	// Header configuration
	if ( get_theme_mod( 'bento_menu_config' ) == 1 ) {
		$classes[] = 'header-centered';
	} else if ( get_theme_mod( 'bento_menu_config' ) == 2 ) {
		$classes[] = 'header-hamburger';
	} else if ( get_theme_mod( 'bento_menu_config' ) == 3 ) {
		$classes[] = 'header-side';
	} else {
		$classes[] = 'header-default';
	}
	
	// WooCommerce shop columns
	if ( class_exists( 'WooCommerce' ) && is_shop() ) {
		$classes[] = 'shop-columns-'.esc_html( get_theme_mod( 'bento_wc_shop_columns' ) );
	}
	
    return $classes;
}


// Adds a class to post depending on whether it has a thumbnail
function bento_has_thumb_class( $classes ) {
	$postid = get_queried_object_id();
	if ( has_post_thumbnail( $postid ) ) { 
		$classes[] = 'has-thumb'; 
	} else {
		$classes[] = 'no-thumb'; 	
	}
	return $classes;
}


// Remove prefixes from archive page titles
function bento_cleaner_archive_titles($title) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>' ;
	}
    return $title;
}


// Count the number of active widgets
function bento_count_footer_widgets( $params ) {
	global $wp_registered_widgets;
	global $sidebars_widgets;
	$widget_count = 0;
	if ( isset ( $sidebars_widgets['bento_footer'] ) ) {
		foreach ( $sidebars_widgets['bento_footer'] as $widget_id ) {
			if ( function_exists( 'pll_current_language' ) && is_object( $wp_registered_widgets[ $widget_id ]['callback'][0] ) ) {
				$widget_options = get_option( 'widget_' . $wp_registered_widgets[ $widget_id ]['callback'][0]->id_base );
				$widget_number = preg_replace( '/[^0-9.]+/i', '', $widget_id );
				$current_widget_options = $widget_options[ $widget_number ];
				if ( $current_widget_options['pll_lang'] == pll_current_language() ) {
					$widget_count++;
				}
			} else {
				$widget_count ++;
			}
		}
	}	
	if ( isset( $params[0]['id'] ) && $params[0]['id'] == 'bento_footer' ) {
		$class = 'class="column-'.$widget_count.' '; 
		$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']);
	}
	return $params;
}


// Load more posts with ajax
function bento_ajax_pagination() {
	$url = wp_get_referer();
	$post_id = url_to_postid( $url );
	global $bento_parent_page_id; 
	$bento_parent_page_id = $post_id;
	$query_args = bento_grid_query(); 
	$query_args['paged'] = $_POST['page'] + 1;
	$post_types = get_post_meta( $post_id, 'bento_page_content_types', true );
	$query_args['post_type'] = $post_types;
	$bento_grid_number_items = get_post_meta( $post_id, 'bento_page_number_items', true );
	if ( ctype_digit($bento_grid_number_items) &&  ctype_digit($bento_grid_number_items) != 0 ) {
		$query_args['posts_per_page'] = (int)$bento_grid_number_items;
	} else {
		$query_args['posts_per_page'] = get_option('posts_per_page');	
	}
    $pagination_query = new WP_Query( $query_args );
	if ( $pagination_query->have_posts() ) { 
		while ( $pagination_query->have_posts() ) { 
			$pagination_query->the_post();
			// Include the page content
			if ( get_page_template_slug( $post_id ) == 'grid.php' ) {
				get_template_part( 'content', 'grid' ); 
			} else {
				get_template_part( 'content' ); 
			}
		}
	}
	wp_reset_postdata();
	die();
}


// Custom query for grid pages
function bento_grid_query() {
	$post_id = get_queried_object_id();
	$bento_grid_query_args = array();
	$post_types = get_post_meta( $post_id, 'bento_page_content_types', true );
	$bento_grid_query_args['post_type'] = $post_types;
	if ( is_front_page() ) {
		$bento_paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
	} else {
		$bento_paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	}
	$bento_grid_query_args['paged'] = $bento_paged;
	$bento_grid_number_items = get_post_meta( $post_id, 'bento_page_number_items', true );
	if ( ctype_digit($bento_grid_number_items) && ctype_digit($bento_grid_number_items) != 0 ) {
		$bento_grid_query_args['posts_per_page'] = (int)$bento_grid_number_items;
	} else {
		$bento_grid_query_args['posts_per_page'] = get_option('posts_per_page');	
	}
	return $bento_grid_query_args;
}


// Page settings metaboxes
function bento_metaboxes() {
	
	// Define strings
	$bento_prefix = 'bento_';
	$bento_ep_url = wp_kses( 
		'<a href="http://satoristudio.net/bento-free-wordpress-theme/#expansion-pack/?utm_source=disabled&utm_medium=theme&utm_campaign=theme" target="_blank">Expansion Pack</a>', 
		array(
			'a' => array(
				'href' => array(),
				'target' => array(),
			),
		) 
	);
	
	// Callback to display a field only on single post types
	function bento_show_field_on_single() {
		$current_screen = get_current_screen();
		if ( $current_screen->id == 'page' ) {
			return false;
		} else {
			return true;
		}
	}
	
	// Function to add a multicheck with post types
	add_action( 'cmb2_render_multicheck_posttype', 'bento_render_multicheck_posttype', 10, 5 );
	function bento_render_multicheck_posttype( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {
		if ( version_compare( CMB2_VERSION, '2.2.2', '>=' ) ) {
			$field_type_object->type = new CMB2_Type_Radio( $field_type_object );
		}
		$cpts = array( 'post', 'project' );
		if ( class_exists( 'WooCommerce' ) ) {
			$cpts[] = 'product';
		}
		$options = '';
		$i = 1;
		$values = (array) $escaped_value;
		if ( $cpts ) {
			foreach ( $cpts as $cpt ) {
				$args = array(
					'value' => $cpt,
					'label' => $cpt,
					'type' => 'checkbox',
					'name' => $field->args['_name'] . '[]',
				);
				if ( in_array( $cpt, $values ) ) {
					$args[ 'checked' ] = 'checked';
				}
				if ( $cpt == 'project' && get_option( 'bento_ep_license_status' ) != 'valid' ) {
					$args[ 'disabled' ] = 'disabled';
				}
				$options .= $field_type_object->list_input( $args, $i );
				$i++;
			}
		}
		$classes = false === $field->args( 'select_all_button' ) ? 'cmb2-checkbox-list no-select-all cmb2-list' : 'cmb2-checkbox-list cmb2-list';
		echo $field_type_object->radio( array( 'class' => $classes, 'options' => $options ), 'multicheck_posttype' );
	}
	
	// General page/post settings
	$bento_general_settings = new_cmb2_box( 
		array(
			'id'            => 'post_settings_metabox',
			'title'         => esc_html__( 'General Settings', 'bento' ),
			'object_types'  => array( 'post', 'page', 'project', 'product' ),
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names' => true,
		) 
	);
	$bento_general_settings->add_field(
		array(
			'name' => esc_html__( 'Sidebar layout', 'bento' ),
			'desc' => esc_html__( 'Choose whether to display a sidebar and on which side of the content', 'bento' ),
			'id' => $bento_prefix . 'sidebar_layout',
			'type' => 'select',
			'options' => array(
				'right-sidebar' => esc_html__( 'Right Sidebar (default)', 'bento' ),
				'left-sidebar' => esc_html__( 'Left Sidebar', 'bento' ),
				'full-width' => esc_html__( 'Full Width', 'bento' ),
			),
			'default' => 'right-sidebar',
		)
	);
	$bento_general_settings->add_field(
		array(
			'name' => esc_html__( 'Page background color', 'bento' ),
			'desc' => esc_html__( 'Choose the background color for current page/post. This will override any settings in the Theme Options', 'bento' ),
			'id' => $bento_prefix . 'page_background_color',
			'type' => 'colorpicker',
		)
	);
	$bento_general_settings->add_field(
		array(
			'name' => esc_html__( 'Hide featured image', 'bento' ),
			'desc' => esc_html__( 'Check this option if you DO NOT want to display the featured image (thumbnail) on the page; it will still be used for the corresponding tile on the "columns" or "rows" grid pages.', 'bento' ),
			'id' => $bento_prefix . 'hide_thumb',
			'type' => 'checkbox',
			'show_on_cb' => 'bento_show_field_on_single'
		)
	);
	$bento_general_settings->add_field(
		array(
			'name' => esc_html__( 'Hide title', 'bento' ),
			'desc' => esc_html__( 'Check this option if you DO NOT want to display the title on the page', 'bento' ),
			'id' => $bento_prefix . 'hide_title',
			'type' => 'checkbox',
		)
	);
	$bento_general_settings->add_field(
		array(
			'name' => esc_html__( 'Uppercase title', 'bento' ),
			'desc' => esc_html__( 'Check this option if you want the page title to be entirely in uppercase (useful for landing pages).', 'bento' ),
			'id' => $bento_prefix . 'uppercase_title',
			'type' => 'checkbox',
		)
	);
	$bento_general_settings->add_field(
		array(
			'name' => esc_html__( 'Title position', 'bento' ),
			'desc' => esc_html__( 'Choose the position of the title; default is left-aligned.', 'bento' ),
			'id' => $bento_prefix . 'title_position',
			'type' => 'select',
			'options' => array(
				'left' => esc_html__( 'Left-aligned (default)', 'bento' ),
				'center' => esc_html__( 'Centered', 'bento' ),
			),
			'default' => 'left',
		)
	);
	$bento_general_settings->add_field(
		array(
			'name' => esc_html__( 'Title color', 'bento' ),
			'desc' => esc_html__( 'Choose the text color for the title of this post. This will override any settings in the Theme Options', 'bento' ),
			'id' => $bento_prefix . 'title_color',
			'type' => 'colorpicker',
		)
	);
	$bento_general_settings->add_field(
		array(
			'name' => esc_html__( 'Subtitle (excerpt) color', 'bento' ),
			'desc' => esc_html__( 'Choose the text color for the subtitle of this page, sourced from the Excerpt field; default is #999999 (light grey).', 'bento' ),
			'id' => $bento_prefix . 'subtitle_color',
			'type' => 'colorpicker',
			'default' => '#999999',
		)
	);
	
	// Extended header settings
	$bento_header_settings = new_cmb2_box( 
		array(
			'id'            => 'post_header_metabox',
			'title'         => esc_html__( 'Page Header Settings', 'bento' ),
			'object_types'  => array( 'post', 'page', 'project', 'product' ),
			'context'       => 'normal',
			'priority'      => 'low',
			'show_names' => true,
		) 
	);
	$bento_header_settings->add_field(
		array(
			'name' => esc_html__( 'Activate extended header', 'bento' ),
			'desc' => esc_html__( 'Check this box to enable extended header options such as header image and call-to-action-buttons.', 'bento' ),
			'id' => $bento_prefix . 'activate_header',
			'type' => 'checkbox',
		)
	);
	$bento_header_settings->add_field(
		array(
			'name' => esc_html__( 'Header height', 'bento' ),
			'desc' => esc_html__( 'Choose the title top and bottom padding, which will affect the header height; default is 10%', 'bento' ),
			'id' => $bento_prefix . 'header_image_height',
			'type' => 'select',
			'options' => array(
				'' => esc_html__( 'Choose value', 'bento' ),
				'5%' => '5%',
				'10%' => esc_html__( '10% (default)', 'bento' ),
				'15%' => '15%',
				'20%' => '20%',
				'25%' => '25%',
			),
			'default' => '10%',
		)
	);
	if ( get_option( 'bento_ep_license_status' ) == 'valid' ) {
		$bento_header_settings->add_field(
			array(
				'name' => esc_html__( 'Header image', 'bento' ),
				'desc' => esc_html__( 'Upload the image to serve as the header; recommended size is 1400x300 pixels and above, yet mind the file size - excessively large images may worsen user experience', 'bento' ),
				'id' => $bento_prefix . 'header_image',
				'type' => 'file',
			)
		);
	}
	if ( get_option( 'bento_ep_license_status' ) == 'valid' ) {
		$bento_header_settings->add_field(
			array(
				'name' => esc_html__( 'Header video', 'bento' ),
				'desc' => esc_html__( 'Upload the video file to be used as header background; if this is active, the header image will serve as a placeholder for mobile devices; .mp4 files are recommended, but you can also use .ogv and .webm formats. Please mind the file size - excessively large images may worsen user experience', 'bento' ),
				'id' => $bento_prefix . 'header_video_source',
				'type' => 'file',
			)
		);
	}
	$bento_header_settings->add_field(
		array(
			'name' => esc_html__( 'Header image overlay color', 'bento' ),
			'desc' => esc_html__( 'Choose the color for the image overlay, designed to make the title text stand out more clearly', 'bento' ),
			'id' => $bento_prefix . 'header_overlay',
			'type' => 'colorpicker',
		)
	);
	$bento_header_settings->add_field(
		array(
			'name' => esc_html__( 'Header image overlay opacity', 'bento' ),
			'desc' => esc_html__( 'Choose the opacity level for the image overlay; 0.0 is fully transparent, 1.0 is fully opaque, default is 0.3', 'bento' ),
			'id' => $bento_prefix . 'header_overlay_opacity',
			'type' => 'select',
			'options' => array(
				'0' => '0.0',
				'1' => '0.1',
				'2' => '0.2',
				'3' => esc_html__( '0.3 (default)', 'bento' ),
				'4' => '0.4',
				'5' => '0.5',
				'6' => '0.6',
				'7' => '0.7',
				'8' => '0.8',
				'9' => '0.9',
				'10' => '1.0',
			),
			'default' => '0.3',
			'show_option_none' => esc_html__( 'Choose value', 'bento' ),
		)
	);
	$bento_header_settings->add_field(
		array(
			'name' => esc_html__( 'Transparent website header', 'bento' ),
			'desc' => esc_html__( 'Check this option to make the website header (the top area with the menu and the logo) look like a transparent overlay on top of the header image on this page.', 'bento' ),
			'id' => $bento_prefix . 'transparent_header',
			'type' => 'checkbox',
		)
	);
	$bento_header_settings->add_field(
		array(
			'name' => esc_html__( 'Website menu color on this page', 'bento' ),
			'desc' => esc_html__( 'Choose the color for the website menu on this page (useful for the transparent header).', 'bento' ),
			'id' => $bento_prefix . 'menu_color',
			'type' => 'colorpicker',
		)
	);
	$bento_header_settings->add_field(
		array(
			'name' => esc_html__( 'Website menu mouse-hover color on this page', 'bento' ),
			'desc' => esc_html__( 'Choose the mouse-over color for the website menu on this page (useful for the transparent header).', 'bento' ),
			'id' => $bento_prefix . 'menu_color_hover',
			'type' => 'colorpicker',
		)
	);
	
	// Map header settings
	if ( get_option( 'bento_ep_license_status' ) == 'valid' ) {
		$bento_headermap_settings = new_cmb2_box( 
			array(
				'id'            => 'post_headermap_metabox',
				'title'         => esc_html__( 'Map Header', 'bento' ),
				'object_types'  => array( 'page' ),
				'context'       => 'normal',
				'priority'      => 'low',
				'show_names' => true,
			) 
		);
		$bento_headermap_settings->add_field(
			array(
				'name' => esc_html__( 'Activate Google Maps header', 'bento' ),
				'desc' => esc_html__( 'Check this box to enable Google Maps header; note that this will deactivate the extended header image/video.', 'bento' ),
				'id' => $bento_prefix . 'activate_headermap',
				'type' => 'checkbox',
			)
		);
		$maps_key_url = 'https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key';
		$maps_key_text = sprintf( wp_kses( esc_html__( 'Input the API key for this instance of Maps - you can find detailed instructions on generating your API key <a href="%s" target="_blank">here</a>.', 'bento' ), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( $maps_key_url ) );
		$bento_headermap_settings->add_field(
			array(
				'name' => esc_html__( 'Google Maps API key', 'bento' ),
				'desc' => $maps_key_text,
				'id' => $bento_prefix . 'headermap_key',
				'type' => 'text',
			)
		);
		$bento_headermap_settings->add_field(
			array(
				'name' => esc_html__( 'Map center location', 'bento' ),
				'desc' => esc_html__( 'Input the address (country, city, or exact address) of the location on which to center the map.', 'bento' ),
				'id' => $bento_prefix . 'headermap_center',
				'type' => 'text',
			)
		);
		$bento_headermap_settings->add_field(
			array(
				'name' => esc_html__( 'Map height', 'bento' ),
				'desc' => esc_html__( 'Select the height of the map, in pixels.', 'bento' ),
				'id' => $bento_prefix . 'headermap_height',
				'type' => 'select',
				'options' => array(
					'100' => '100',
					'200' => '200',
					'300' => '300',
					'400' => esc_html__( '400 (default)', 'bento' ),
					'500' => '500',
					'600' => '600',
					'700' => '700',
				),
				'default' => '400',
			)
		);
		$bento_headermap_settings->add_field(
			array(
				'name' => esc_html__( 'Map zoom level', 'bento' ),
				'desc' => esc_html__( 'Choose the zoom level for the map, 1 being entire world and 20 being individual buildings.', 'bento' ),
				'id' => $bento_prefix . 'headermap_zoom',
				'type' => 'select',
				'options' => array(
					1 => '1',
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
					7 => '7',
					8 => '8',
					9 => '9',
					10 => '10',
					11 => '11',
					12 => '12',
					13 => '13',
					14 => '14',
					15 => esc_html__( '15 (default)', 'bento' ),
					16 => '16',
					17 => '17',
					18 => '18',
					19 => '19',
					20 => '20',
				),
				'default' => 15,
			)
		);
		$snazzymaps_url = 'https://snazzymaps.com';
		$snazzymaps_link = sprintf( wp_kses( esc_html__( 'You can insert the code for custom map styling here; check <a href="%s" target="_blank">Snazzymaps.com</a> for ready-made snippets: when on the page of the particular style, click on the "Copy" button or simply select and copy the code under the "Javascript Style Array" heading.', 'bento' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( $snazzymaps_url ) );
		$bento_headermap_settings->add_field(
			array(
				'name' => esc_html__( 'Map custom style', 'bento' ),
				'desc' => $snazzymaps_link,
				'id' => $bento_prefix . 'headermap_style',
				'type' => 'textarea',
			)
		);
	}
	
	// Masonry tile settings
	$bento_tile_settings = new_cmb2_box( 
		array(
			'id'            => 'tile_settings_metabox',
			'title'         => esc_html__( 'Masonry Tile Settings / Only for displaying on "Grid" page template with "Masonry" grid type', 'bento' ),
			'object_types'  => array( 'post', 'project', 'product' ),
			'context'       => 'normal',
			'priority'      => 'low',
			'show_names'	=> true,
		) 
	);
	$bento_tile_settings->add_field(
		array(
			'name' => esc_html__( 'Tile size', 'bento' ),
			'desc' => esc_html__( 'Choose the size of the tile relative to the default 1x1 tile (defined by the number of columns in the grid)', 'bento' ),
			'id' => $bento_prefix . 'tile_size',
			'type' => 'select',
			'options' => array(
				'1x1' => esc_html__( '1x1 (default)', 'bento' ),
				'1x2' => '1x2',
				'2x1' => '2x1',
				'2x2' => '2x2',
			),
			'default' => '1x1',
		)
	);
	$bento_tile_settings->add_field(
		array(
			'name' => esc_html__( 'Tile overlay color', 'bento' ),
			'desc' => esc_html__( 'Choose the color for an overlay for the tile background image; default is #666666 (grey)', 'bento' ),
			'id' => $bento_prefix . 'tile_overlay_color',
			'type' => 'colorpicker',
			'default' => '#666666',
		)
	);
	if ( get_option( 'bento_ep_license_status' ) == 'valid' ) {
		$bento_tile_settings->add_field(
			array(
				'name' => esc_html__( 'Tile image', 'bento' ),
				'desc' => esc_html__( 'Upload the image to be used in the tile; if this field is empty, the featured image (thumbnail) will be used.', 'bento' ),
				'id' => $bento_prefix . 'tile_image',
				'type' => 'file',
			)
		);
	}
	$bento_tile_settings->add_field(
		array(
			'name' => esc_html__( 'Tile overlay opacity', 'bento' ),
			'desc' => esc_html__( 'Select the opacity level for an overlay for the tile background image, 0 is fully transparent (default is 0.6)', 'bento' ),
			'id' => $bento_prefix . 'tile_overlay_opacity',
			'type' => 'select',
			'options' => array(
				'0' => '0.0',
				'1' => '0.1',
				'2' => '0.2',
				'3' => '0.3',
				'4' => '0.4',
				'5' => '0.5',
				'6' => esc_html__( '0.6 (default)', 'bento' ),
				'7' => '0.7',
				'8' => '0.8',
				'9' => '0.9',
				'10' => '1.0',
			),
			'default' => '0.6',
			'show_option_none' => esc_html__( 'Choose value', 'bento' ),
		)
	);
	$bento_tile_settings->add_field(
		array(
			'name' => esc_html__( 'Tile text color', 'bento' ),
			'desc' => esc_html__( 'Choose the color for the text inside the tile; default is #ffffff (white)', 'bento' ),
			'id' => $bento_prefix . 'tile_text_color',
			'type' => 'colorpicker',
			'default' => '#ffffff',
		)
	);
	$bento_tile_settings->add_field(
		array(
			'name' => esc_html__( 'Tile text size', 'bento' ),
			'desc' => esc_html__( 'Choose the text size for the tile; default is 16px', 'bento' ),
			'id' => $bento_prefix . 'tile_text_size',
			'type' => 'select',
			'options' => array(
				'12' => '12',
				'13' => '13',
				'14' => '14',
				'16' => esc_html__( '16 (default)', 'bento' ),
				'18' => '18',
				'20' => '20',
				'24' => '24',
				'28' => '28',
			),
			'default' => '16',
		)
	);
	
	// Grid page settings
	$bento_grid_settings = new_cmb2_box( 
		array(
			'id'            => 'grid_settings_metabox',
			'title'         => esc_html__( 'Grid Settings', 'bento' ),
			'object_types'  => array( 'page' ),
			'context'       => 'normal',
			'priority'      => 'low',
			'show_names'	=> true,
		) 
	);
	$bento_grid_settings->add_field(
		array(
			'name' => esc_html__( 'Grid mode', 'bento' ),
			'desc' => esc_html__( 'Choose which grid type to use on this page', 'bento' ),
			'id' => $bento_prefix . 'page_grid_mode',
			'type' => 'select',
			'options' => array(
				'columns' => 'Columns',
				'masonry' => 'Masonry',
				'rows' => 'Rows',
			),
			'default' => 'columns',
		)
	);
	$bento_grid_settings->add_field(
		array(
			'name' => esc_html__( 'Number of columns', 'bento' ),
			'desc' => esc_html__( 'Select the number of columns in the grid or number of base tiles per line in masonry', 'bento' ),
			'id' => $bento_prefix . 'page_columns',
			'type' => 'select',
			'options' => array(
				'1' => '1',
				'2' => '2',
				'3' => esc_html__( '3 (default)', 'bento' ),
				'4' => '4',
				'5' => '5',
				'6' => '6',
			),
			'default' => '3',
		)
	);
	if ( get_option( 'bento_ep_license_status' ) == 'valid' ) {
		$bento_grid_settings->add_field(
			array(
				'name' => esc_html__( 'Content types', 'bento' ),
				'id' => $bento_prefix . 'page_content_types',
				'type' => 'multicheck_posttype',
				'default' => 'post',
			)
		);
	} else {
		$bento_grid_settings->add_field(
			array(
				'name' => esc_html__( 'Content types', 'bento' ),
				'desc' => sprintf( esc_html__( 'Install the %s to use the "project" (portfolio) content type', 'bento' ), $bento_ep_url ),
				'id' => $bento_prefix . 'page_content_types',
				'type' => 'multicheck_posttype',
				'default' => 'post',
			)
		);
	}
	$bento_grid_settings->add_field(
		array(
			'name' => esc_html__( 'Items per page', 'bento' ),
			'desc' => esc_html__( 'Input the number of items to display per page; default is the number set in "Settings - Reading" admin section', 'bento' ),
			'id' => $bento_prefix . 'page_number_items',
			'type' => 'text_small',
			'default' => '10',
		)
	);
	$bento_grid_settings->add_field(
		array(
			'name' => esc_html__( 'Item margins', 'bento' ),
			'desc' => esc_html__( 'Input the margin width in pixels (default is 10)', 'bento' ),
			'id' => $bento_prefix . 'page_item_margins',
			'type' => 'text_small',
			'default' => '10',
		)
	);
	$bento_grid_settings->add_field(
		array(
			'name' => esc_html__( 'Hide tile overlays', 'bento' ),
			'desc' => esc_html__( 'Only display tile overlays in masonry on mouse hover', 'bento' ),
			'id' => $bento_prefix . 'hide_tile_overlays',
			'type' => 'checkbox',
		)
	);
	$bento_grid_settings->add_field(
		array(
			'name' => esc_html__( 'Force full width', 'bento' ),
			'desc' => esc_html__( 'Check this option if you want the grid to stretch the entire width of the screen', 'bento' ),
			'id' => $bento_prefix . 'grid_full_width',
			'type' => 'checkbox',
		)
	);
	$bento_grid_settings->add_field(
		array(
			'name' => esc_html__( 'Load items on same page', 'bento' ),
			'desc' => esc_html__( 'Replace the standard pagination with a button which loads next items without refreshing the page', 'bento' ),
			'id' => $bento_prefix . 'page_ajax_load',
			'type' => 'checkbox',
		)
	);
	
	// SEO settings
	if ( get_option( 'bento_ep_license_status' ) == 'valid' ) {
		$bento_seo_settings = new_cmb2_box( 
			array(
				'id'            => 'seo_settings_metabox',
				'title'         => esc_html__( 'SEO Settings', 'bento' ),
				'object_types'  => array( 'post', 'page', 'project', 'product' ),
				'context'       => 'normal',
				'priority'      => 'low',
				'show_names'	=> true,
			) 
		);
		$bento_seo_settings->add_field(
			array(
				'name' => esc_html__( 'Meta title', 'bento' ),
				'desc' => esc_html__( 'Input the meta title - the text to be used by search engines as well as browser tabs (recommended max length - 60 symbols); the post title will be used by default if this field is empty.', 'bento' ),
				'id' => $bento_prefix . 'meta_title',
				'type' => 'text',
			)
		);
		$bento_seo_settings->add_field(
			array(
				'name' => esc_html__( 'Meta description', 'bento' ),
				'desc' => esc_html__( 'Input the meta description - the text to be used by search engines on search result pages (recommended max length - 160 symbols); the first part of the post body will be used by default is this field is left blank.', 'bento' ),
				'id' => $bento_prefix . 'meta_description',
				'type' => 'textarea',
				'attributes' => array(
					'rows' => 3,
				),
			)
		);
	}
	
}


// SiteOrigin Content Builder integration
	
	// Add extra attribute to rows
	function bento_extra_row_attr( $attributes, $grid ) {
		if ( ! empty( $grid['style'] ) ) {
			if ( ! empty ( $grid['style']['class'] ) ) {
				$attributes['data-extraid'] = $grid['style']['class'];
			}
		}
		return $attributes;
	}
	
	// Add divs with ids before each row which has extra classes (useful for one-page layouts)
	function bento_content_builder_row_ids( $code, $grid, $attr ) {
		if ( ! empty( $attr['data-extraid'] ) ) {
			$rowclasses = $attr['data-extraid'];
			$extradiv = '<a id="'.$rowclasses.'"></a>';
			return $extradiv;
		}
	}


// WooCommerce integration

	// Declare new content wrappers
	function bento_woo_wrapper_start() {
		echo '<div class="bnt-container"><div class="content"><main class="site-main"><article>';
	}
	function bento_woo_wrapper_end() {
		echo '</article></main></div>';
		if ( is_shop() ) {
			$page_id = get_option( 'woocommerce_shop_page_id' );
		} else {
			$page_id = get_queried_object_id();
		}
		if ( is_active_sidebar( 'bento_woocommerce' )  ) {
			if ( get_post_meta( $page_id, 'bento_sidebar_layout', true ) != 'full-width' || is_product_category() ) {
				echo '<div class="sidebar widget-area sidebar-woo clear">';
					dynamic_sidebar( 'bento_woocommerce' );
				echo '</div>';
			}
		}
		echo '</div>';
	}
	
	// Remove plugin styling
	function bento_woo_dequeue_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-general'] );
		return $enqueue_styles;
	}
		
	// Hide image placeholder for products without thumbnails
	function woocommerce_template_loop_product_thumbnail() {
		global $post;
		if ( has_post_thumbnail() ) {
			echo get_the_post_thumbnail( $post->ID, 'shop_catalog' );
		}
	}
	
	// Change the "Add to cart" button text 
	function bento_woo_custom_cart_button_text() {
		return '';
	}
	
	// Hide product title if respective option is selected
	function bento_woo_product_title() {
		$page_id = get_queried_object_id();
		if ( get_post_meta( $page_id, 'bento_hide_title', true) != 'on' ) {
			the_title( '<h1 itemprop="name" class="product_title entry-title">', '</h1>' );
		}
	}
	
	// Custom number of products per shop page
	function bento_woo_loop_perpage() {
		$bento_wc_shop_num = esc_html( get_theme_mod( 'bento_wc_shop_number_items' ) );
		return $bento_wc_shop_num;
	}
	
	// Custom number of columns on the shop page
	function bento_woo_loop_columns() {
		$bento_wc_shop_col = 3;
		$bento_wc_settings_shop_col = (int)get_theme_mod( 'bento_wc_shop_columns' );
		if ( is_int($bento_wc_settings_shop_col) && $bento_wc_settings_shop_col > 0 ) 
		$bento_wc_shop_col = $bento_wc_settings_shop_col;
		return $bento_wc_shop_col;
	}
 
	// Adjust single product layout so that the sections flow more naturally
	function bento_woo_single_product_sections_start() {
		echo '<div class="single-product-section-wrap">';
	}
	function bento_woo_single_product_sections_end() { 
		echo '</div>';
		woocommerce_output_related_products(); 
	}
	
	// Custom search form
	function bento_woo_custom_product_searchform( $form ) {
		$form = '
			<form role="search" method="get" class="woocommerce-product-search" action="'.esc_url( home_url( '/'  ) ).'">
				<input type="search" class="search-field" placeholder="'.esc_attr_x( 'Search Products&hellip;', 'placeholder', 'bento' ).'" value="'.get_search_query().'" name="s" title="'.esc_attr_x( 'Search for:', 'label', 'bento' ).'" />
				<input type="submit" value="&#xf179;" />
				<input type="hidden" name="post_type" value="product" />
			</form>
		';
		return $form;
	}
	

?>