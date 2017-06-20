<?php

class Onetone_Customizer {
	
	protected static $default_data = array(
			'default' 		=> '',
			'slug' 			=> '',
			'panel'			=> '', 
			'label' 		=> '',
			'description'	=> '',
			'transport' 	=> 'refresh',
			'priority' 		=> '',
			'type' 			=> 'color',
			'selector' 		=> '',
			'property' 		=> '',
			'property2' 	=> '',
			'output' 		=> true,
			'font_amount' 	=> 500,
		);

	function __construct() {

		$this->onetone_define_constants();
		$this->onetone_load_custom_controls();
		$this->onetone_load_customizer_data();
		add_action( 'customize_register', array( &$this, 'onetone_theme_customizer_register' ), 10 );
		add_action( 'customize_preview_init', array( &$this, 'onetone_customizer_live_preview' ) , 1 );
		add_action( 'wp_head', array( &$this, 'onetone_customizer_print_css' ), 10 );
		add_action( 'wp_head', array( &$this, 'onetone_customizer_font_output' ), 15 );
		add_action( 'customize_controls_enqueue_scripts', array( &$this, 'onetone_customizer_enqueue_scripts' ), 20 );
	}

	/**
	 * Define constants
	 **/
	function onetone_define_constants() {
		if ( ! defined( 'ONETONE_DIR' ) ) define( 'ONETONE_DIR', trailingslashit( get_template_directory() . '/lib/customizer' ) );
		if ( ! defined( 'ONETONE_URI' ) )define( 'ONETONE_URI', trailingslashit( get_template_directory_uri() . '/lib/customizer' ) );
	}

	/**
	 * Automatically load all custom control files
	 *
	 **/
	function onetone_load_custom_controls() {
		foreach ( glob( ONETONE_DIR . "includes/*.php" ) as $filename ) {
			include $filename;
		}
	}

	/**
	 * Load customizer file
	 *
	 * @return void
	 * @author 
	 **/
	function onetone_load_customizer_data() {
		require_once ONETONE_DIR . '/customizer-data.php';
	}

	/**
	 * Get all registered data
	 *
	 */
	function onetone_get_customizer_data() {
		$onetone_options= array();
		return apply_filters( 'onetone_customizer_data', $onetone_options );
	}

	/**
	 * Register Custom Sections, Settings, And Controls
	 *
	 */
	function onetone_theme_customizer_register( $wp_customize ) {
		
		$onetone_get_data 	= array();
		$onetone_data 		= $this->onetone_get_customizer_data( $onetone_get_data );
		//create the componen from array data
		foreach ( $onetone_data as $data ) {

			$data = wp_parse_args( $data, self::$default_data );
	
			// Define each customizer type 
			switch ( $data['type'] ) {
				
				case 'panel':
					// Add Panel
					$wp_customize->add_panel( $data['slug'], array(
						'priority'			=> $data['priority'],
						'capability'		=> 'edit_theme_options',
						'theme_supports'	=> '',
						'title'				=> $data['label'],
						'description'		=> $data['description'],
					) );

					break;

				case 'section':
					// Add Section
					$wp_customize->add_section( $data['slug'], 
						array(
							'title'    	=> $data['label'],
							'priority' 	=> $data['priority'],
							'panel' 	=> $data['panel']
					));
					break;

				case 'color':
				case 'color_rgb':
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'type' 				=> 'option', 
							'capability' 		=> 'edit_theme_options', 
							'transport'			=> $data['transport'], 
							'sanitize_callback'	=> 'sanitize_hex_color', 
							) 
						);
					$wp_customize->add_control(  new WP_Customize_Color_Control( 
						$wp_customize,$data['slug'], 
						array( 
							'label' 		=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 		=> $data['section'], 
							'priority'		=> $data['priority'], 
							'settings' 		=> $data['slug'] 
							) 
						));
					break;
				
				case 'text' :
					$wp_customize->add_setting( $data['slug'], 
						array(
							'default' 			=> $data['default'],
							'type' 				=> 'option', 
							'capability' 		=> 'edit_theme_options',
							'transport'   		=> $data['transport'],
							'sanitize_callback'	=> 'sanitize_text_field',
						) );
					$wp_customize->add_control(  
						$data['slug'], 
						array( 
							'label' 		=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 		=> $data['section'],
							'default' 		=> $data['default'],
							'priority'		=> $data['priority'],
							'settings' 		=> $data['slug'], 
							'type'			=> 'text'
							)
						);
					break;

				case 'email' :
					$wp_customize->add_setting( $data['slug'], 
						array(
							'default' 			=> $data['default'],
							'type' 				=> 'option', 
							'capability' 		=> 'edit_theme_options',
							'transport'   		=> $data['transport'],
							'sanitize_callback'	=> 'sanitize_email',
						) );
					$wp_customize->add_control(
						$data['slug'], 
						array( 
							'label' 		=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 		=> $data['section'],
							'default' 		=> $data['default'],
							'priority'		=> $data['priority'],
							'settings' 		=> $data['slug'], 
							'type'			=> 'email'
							)
						);
					break;

				case 'url' :
					$wp_customize->add_setting( $data['slug'], 
						array(
							'default' 			=> $data['default'],
							'type' 				=> 'option', 
							'capability' 		=> 'edit_theme_options',
							'transport'   		=> $data['transport'],
							'sanitize_callback'	=> 'esc_url',
						) );
					$wp_customize->add_control(
						$data['slug'], 
						array( 
							'label' 		=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 		=> $data['section'],
							'default' 		=> $data['default'],
							'priority'		=> $data['priority'],
							'settings' 		=> $data['slug'], 
							'type'			=> 'url'
							)
						);
					break;

				case 'password' :
					$wp_customize->add_setting( $data['slug'], 
						array(
							'default' 			=> $data['default'],
							'type' 				=> 'option', 
							'capability' 		=> 'edit_theme_options',
							'transport'   		=> $data['transport'],
							'sanitize_callback'	=> 'sanitize_text_field',
						) );
					$wp_customize->add_control(
						$data['slug'], 
						array( 
							'label' 		=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 		=> $data['section'],
							'default' 		=> $data['default'],
							'priority'		=> $data['priority'],
							'settings' 		=> $data['slug'], 
							'type'			=> 'password'
							)
						);
					break;

				case 'textarea' :
					$wp_customize->add_setting( $data['slug'], 
						array(
							'default' 			=> $data['default'],
							'type' 				=> 'option', 
							'capability' 		=> 'edit_theme_options',
							'transport'   		=> $data['transport'],
							'sanitize_callback'	=> 'wp_kses_post',
						) );
					$wp_customize->add_control(
						$data['slug'], 
						array( 
							'label' 		=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 		=> $data['section'],
							'default' 		=> $data['default'],
							'priority'		=> $data['priority'],
							'settings' 		=> $data['slug'], 
							'type'			=> 'textarea'
							)
						);
					break;

				case 'date' :
					$wp_customize->add_setting( $data['slug'], 
						array(
							'default' 			=> $data['default'],
							'type' 				=> 'option', 
							'capability' 		=> 'edit_theme_options',
							'transport'   		=> $data['transport'],
							'sanitize_callback'	=> 'sanitize_text_field',
						) );
					$wp_customize->add_control(
						$data['slug'], 
						array( 
							'label' 		=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 		=> $data['section'],
							'default' 		=> $data['default'],
							'priority'		=> $data['priority'],
							'settings' 		=> $data['slug'], 
							'type'			=> 'date'
							)
						);
					break;

				case 'select' :
					$wp_customize->add_setting( $data['slug'], 
						array(
							'default' 			=> $data['default'],
							'type' 				=> 'option', 
							'transport'   		=> $data['transport'],
							'capability' 		=> 'edit_theme_options',
							'sanitize_callback'	=> 'esc_attr',
						) );
					$wp_customize->add_control( 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'default' 	=> $data['default'],
							'priority'	=> $data['priority'],
							'settings' 	=> $data['slug'], 
							'choices'	=> $data['choices'], 
							'type'		=> 'select'
							)
					);
					break;

				case 'radio' :
					$wp_customize->add_setting( $data['slug'], 
						array(
							'default' 			=> $data['default'],
							'type' 				=> 'option', 
							'transport'   		=> $data['transport'],
							'capability' 		=> 'edit_theme_options',
							'sanitize_callback'	=> 'esc_attr',
						) );
					$wp_customize->add_control( 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'default' 	=> $data['default'],
							'priority'	=> $data['priority'],
							'settings' 	=> $data['slug'], 
							'choices'	=> $data['choices'], 
							'type'		=> 'radio'
							)
						);
					break;

				case 'dropdown-pages' :
					$wp_customize->add_setting( $data['slug'], 
						array(
							'default' 			=> $data['default'],
							'type' 				=> 'option', 
							'transport'   		=> $data['transport'],
							'capability' 		=> 'edit_theme_options',
							'sanitize_callback'	=> 'esc_attr',
						) );
					$wp_customize->add_control(
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'default' 	=> $data['default'],
							'priority'	=> $data['priority'],
							'settings' 	=> $data['slug'], 
							'type'		=> 'dropdown-pages'
							)
						);
					break;

				case 'checkbox' :
					$wp_customize->add_setting( $data['slug'], 
						array(
							'default' 			=> $data['default'],
							'type' 				=> 'option', 
							'transport'   		=> $data['transport'],
							'capability' 		=> 'edit_theme_options',
							'sanitize_callback'	=> 'esc_attr',
						) );
					$wp_customize->add_control(
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'default' 	=> $data['default'],
							'priority'	=> $data['priority'],
							'settings' 	=> $data['slug'], 
							'type'		=> 'checkbox'
							)
						);
					break;

				case 'images' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_url_raw', 
							));   
					$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'priority'	=> $data['priority'], 
							'settings' 	=> $data['slug']
							 )));
					break;

				case 'image_select' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_attr', 
							));   
					$wp_customize->add_control( new Image_Select_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'priority'	=> $data['priority'], 
							'settings' 	=> $data['slug'],
							'choices' 	=> $data['choices']
							 )));
					break;

				case 'file' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_url_raw', 
							));   
					$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'priority'	=> $data['priority'], 
							'settings' 	=> $data['slug']
							 )));
					break;

				case 'category_dropdown' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_attr', 
							));   
					$wp_customize->add_control( new Category_Dropdown_Custom_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'priority'	=> $data['priority'], 
							'settings' 	=> $data['slug']
							 )));
					break;

				case 'menu_dropdown' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_attr', 
							));   
					$wp_customize->add_control( new Menu_Dropdown_Custom_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'priority'	=> $data['priority'], 
							'settings' 	=> $data['slug']
							 )));
					break;

				case 'post_dropdown' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_attr', 
							));   
					$wp_customize->add_control( new Post_Dropdown_Custom_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'priority'	=> $data['priority'], 
							'settings' 	=> $data['slug']
							 )));
					break;

				case 'post_type_dropdown' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_attr', 
							));   
					$wp_customize->add_control( new Post_Type_Dropdown_Custom_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'priority'	=> $data['priority'], 
							'settings' 	=> $data['slug']
							 )));
					break;

				case 'dropdown_user' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_attr', 
							));   
					$wp_customize->add_control( new User_Dropdown_Custom_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'priority'	=> $data['priority'], 
							'settings' 	=> $data['slug']
							 )));
					break;

				case 'editor' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_textarea', 
							));   
					$wp_customize->add_control( new Text_Editor_Custom_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'priority'	=> $data['priority'], 
							'settings' 	=> $data['slug']
							 )));
					break;

				case 'google_font' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_attr', 
							));   
					$wp_customize->add_control( new Google_Font_Dropdown_Custom_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'priority'	=> $data['priority'], 
							'settings' 	=> $data['slug'],
							'amount' 	=> $data['font_amount']
							 )));
					break;

				case 'select_chosen' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_attr', 
							));   
					$wp_customize->add_control( new Chosen_Custom_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'priority'	=> $data['priority'], 
							'settings' 	=> $data['slug'],
							'choices' 	=> $data['choices'],
							 )));
					break;

				case 'image_select' :
					$wp_customize->add_setting( $data['slug'], 
						array( 
							'default' 			=> $data['default'], 
							'capability' 		=> 'edit_theme_options', 
							'type' 				=> 'option',
							'sanitize_callback'	=> 'esc_attr', 
							));   
					$wp_customize->add_control( new Image_Select_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 		=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 		=> $data['section'],
							'priority'		=> $data['priority'], 
							'settings' 		=> $data['slug'],
							'choices' 		=> $data['choices']
							 )));
					break;
					
				case 'buttonset' :
					$wp_customize->add_setting( $data['slug'], 
						array(
							'default' 			=> $data['default'],
							'type' 				=> 'option', 
							'transport'   		=> $data['transport'],
							'capability' 		=> 'edit_theme_options',
							'sanitize_callback'	=> 'esc_attr',
						) );
					$wp_customize->add_control( new Buttonset_Custom_Control( $wp_customize, 
						$data['slug'], 
						array( 
							'label' 	=> $data['label'], 
							'description' 	=> $data['description'], 
							'section' 	=> $data['section'],
							'default' 	=> $data['default'],
							'priority'	=> $data['priority'],
							'settings' 	=> $data['slug'], 
							'choices'	=> $data['choices'], 
							'type'		=> 'buttonset'
							)
						));
					break;

				default:
					break;
			}
		}
	}

	/**
	 * Used by hook: 'customize_preview_init'
	 *
	 * @see add_action( 'customize_preview_init', $func )
	 */
	function onetone_customizer_live_preview() {
		
		$onetone_options	= array();
		$onetone_options	= $this->onetone_get_customizer_data( $onetone_options );

		wp_enqueue_script( 'customizer-preview', ONETONE_URI . 'assets/js/customizer-preview.js', array( 'jquery', 'customize-preview' ), '', true );
		wp_localize_script(	'customizer-preview', 'onetoneStyle', $onetone_options );

	}

	/**
	* Enqueue Scripts
	*
	* @return void
	**/
	function onetone_customizer_enqueue_scripts() {
		$onetone_options	= array();
		$onetone_options	= $this->onetone_get_customizer_data( $onetone_options );

		wp_enqueue_script( 'onetone-customizer-plugins', ONETONE_URI . 'assets/js/plugins.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'onetone-customizer-methods', ONETONE_URI . 'assets/js/methods.js', array( 'jquery' ), '', true );
		wp_localize_script( 'onetone-customizer-methods', 'onetoneScript', $onetone_options );
		wp_enqueue_style( 'onetone-customizer-style', ONETONE_URI . 'assets/css/styles.css' );
		wp_enqueue_style( 'onetone-customizer-plugins', ONETONE_URI . 'assets/css/plugins.min.css' );

		wp_enqueue_style( 'onetone-customizer-jquery-ui', ONETONE_URI . 'assets/css/jquery-ui.min.css' );
		wp_enqueue_style( 'onetone-customizer-jquery-ui-theme', ONETONE_URI . 'assets/css/jquery-ui.theme.min.css' );
	}

	/**
	 * Sanitize and Print To Head
	 *
	 */
	 
	function onetone_customizer_print_css() { 
		
		$onetone_options= array();
		$onetone_options= $this->onetone_get_customizer_data( $onetone_options );
		$style 		= '';

		foreach ( $onetone_options as $data ) {

			$data = wp_parse_args( $data, self::$default_data );

			$selectors 	= $data['selector'];
			$newvalue	= get_theme_mod( $data['slug'] );

			if ( isset( $newvalue ) && ! empty( $newvalue ) ) {
				switch ( $data['type'] ) {

					case 'color':
						if ( true == $data['output'] ) {
							$style .=  
								$selectors. '{'
								.$data['property'].':'.$newvalue.' '.$data['property2'].'}';
						}
						break;

					case 'color_rgb':
						if ( true == $data['output'] ) {
							$get_rgb_color 	= $this->onetone_hex2RGB( $newvalue );
							$red 			= $get_rgb_color['r']; 
							$green 			= $get_rgb_color['g']; 
							$blue 			= $get_rgb_color['b'];
							$property2 		= $data['property2']; 
							$rgb_color 		= 'rgb('.$red.','.$green.','.$blue.', ' . $property2 . ')';

							$style .=  
								$selectors. '{'
								.$data['property'].':'.$rgb_color.'}';
						}
						break;

					case 'images':
						if ( true == $data['output'] ) {
							$style .=  $selectors. '{' 
							.$data['property'].':url("'.$newvalue.'") '.' '.$data['property2'].'}';
						}
						break;

					case 'google_font':
							$style .=  $selectors.'{' 
							.$data['property'].':'.$newvalue.' '.$data['property2'].'}';
						break;

					default:
						break;
				}
			}
		}
		$style = "\n".'<style type="text/css">'.trim( $style ).'</style>'."\n";
		printf( '%s', $style );
	}

	/**
	 * Enqueue Google Font Base on Customizer Data
	 *
	 * @return void
	 **/
	function onetone_customizer_font_output() {

		$onetone_options	= array();
		$onetone_data 		= $this->onetone_get_customizer_data( $onetone_options );
		$loaded_font 	= '';

		foreach ( $onetone_data as $data ) {

			$data = wp_parse_args( $data, self::$default_data );

			$selectors 	= $data['selector'];
			$newvalue	= get_theme_mod( $data['slug'] );

			if ( $data['type'] == 'select_font' ) {
				if ( isset( $newvalue ) && ! empty( $newvalue ) ) {
					$get_selected_font = str_replace(' ', '+', $newvalue );
					$loaded_font .= '@import url(//fonts.googleapis.com/css?family='.$get_selected_font.');';
				}
			}
		} 
		$loaded_font = "\n".'<style type="text/css">'.trim( $loaded_font ).'</style>'."\n";
		printf( '%s', $loaded_font );
	}

	/**
	 * Convert Hexa to RGB
	 *
	 * @return void
	 **/
	function onetone_hex2RGB( $hex ) {
		preg_match( "/^#{0,1}([0-9a-f]{1,6})$/i", $hex, $match );
		
		if ( ! isset( $match[1] ) ) {
			return false;
		}

		if ( strlen( $match[1] ) == 6 ) {
			list( $r, $g, $b ) = array( $hex[0] . $hex[1], $hex[2] . $hex[3], $hex[4] . $hex[5] );
		} elseif ( strlen( $match[1] ) == 3 ) {
			list( $r, $g, $b ) = array( $hex[0] . $hex[0], $hex[1] . $hex[1], $hex[2] . $hex[2] );
		} else if ( strlen( $match[1] ) == 2 ) {
			list( $r, $g, $b ) = array( $hex[0] . $hex[1], $hex[0] . $hex[1], $hex[0] . $hex[1] );
		} else if ( strlen( $match[1] ) == 1 ) {
			list( $r, $g, $b ) = array( $hex . $hex, $hex . $hex, $hex . $hex );
		} else {
			return false;
		}

		$color 		= array();
		$color['r'] = hexdec( $r );
		$color['g'] = hexdec( $g );
		$color['b'] = hexdec( $b );

		return $color;
	}

}

new Onetone_Customizer();