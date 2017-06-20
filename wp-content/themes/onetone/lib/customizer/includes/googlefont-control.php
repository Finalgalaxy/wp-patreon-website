<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

/**
 * A class to create a dropdown for all google fonts
 */
 class Google_Font_Dropdown_Custom_Control extends WP_Customize_Control {
   
	private $fonts = false;

	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		$this->fonts = $this->get_fonts( $args['amount'] );

		parent::__construct( $manager, $id, $args );
	}

   /**
	* Render the content on the theme customizer page
	*/
	public function render_content() {

		if ( empty( $this->fonts ) ) {
			return false;
		}
		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <span class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
				<select <?php $this->link(); ?>>
					<?php
						foreach ( $this->fonts as $k => $v ) {
							printf( '<option value="%s" %s>%s</option>', $k, selected( $this->value(), $k, false ), $v->family );
						}
					?>
				</select>
			</label>
		<?php
	}

	/**
	 * Get the google fonts from the API or in the cache
	 *
	 * @param  integer $amount
	 *
	 * @return String
	 */
	public function get_fonts( $amount = 500, $api_key = 'AIzaSyBa9fRtVKujSxVn2uoxtqa3DbR-fCym1ig' ) {
		
		global $onetone_google_fonts;
		
		$selectDirectory = ONETONE_DIR . '/includes/';
		$selectDirectoryInc = ONETONE_DIR . '/includes/';

		$finalselectDirectory = '';

		if ( is_dir( $selectDirectory ) ) {
			$finalselectDirectory = $selectDirectory;
		}

		if ( is_dir( $selectDirectoryInc ) ) {
			$finalselectDirectory = $selectDirectoryInc;
		}
		
		$fontFile = $finalselectDirectory . '/google-web-fonts.php';
        
		//Total time the file will be cached in seconds, set to a week
		$cachetime = 86400 * 7;

		if ( file_exists( $fontFile ) && $cachetime < filemtime( $fontFile ) ) {
			require_once $fontFile;
			$content = json_decode( $onetone_google_fonts );
		} else {			
			$googleApi = '//www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=' . $api_key;
			$fontContent = wp_remote_get( $googleApi, array( 'sslverify'   => false ) );
			$content = json_decode( $fontContent['body'] );
		}

		if ( $amount == 'all' ) {
			return $content->items;
		} else {
			return array_slice( $content->items, 0, $amount );
		}
	}
}