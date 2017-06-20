<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

/**
 * Class to create a custom tags control
 */
class Text_Editor_Custom_Control extends WP_Customize_Control {
	/**
	* Render the content on the theme customizer page
	*/
	public function render_content() {
		?>
			<label>
			  <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
              <span class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
			  <?php
				$settings = array(
				  'textarea_name' 	=> $this->id,
				  'drag_drop_upload'=> true,
				  'media_buttons' 	=> false,
				  'textarea_rows' 	=> 10
				  );

				wp_editor( $this->value(), $this->id, $settings );
				do_action( 'admin_print_footer_scripts' );
			  ?>
			</label>
		<?php
	}
}
