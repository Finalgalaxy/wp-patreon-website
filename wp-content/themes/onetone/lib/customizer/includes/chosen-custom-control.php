<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

/**
 * Class to create a custom post control
 */
class Chosen_Custom_Control extends WP_Customize_Control {
	public $choices = false;

	public function __construct( $manager, $id, $args = array(), $options = array() ) {

		parent::__construct( $manager, $id, $args );
	}

	/**
	* Render the content on the theme customizer page
	*/
	public function render_content() {
		
		if ( ! empty( $this->choices ) ) {
			?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                    <span class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
					<select <?php $this->link(); ?> class="koo-chosen" style="width:100%;">
						<?php
						foreach ( $this->choices as $value => $label )
							echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $label . '</option>';
						?>
					</select>
				</label>
			<?php
		}
	}
}
