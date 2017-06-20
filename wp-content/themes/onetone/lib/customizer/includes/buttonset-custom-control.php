<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

/**
 * Class to create a custom tags control
 */
class Buttonset_Custom_Control extends WP_Customize_Control {

	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );
	}

	/**
	* Render the content on the theme customizer page
	*/
	public function render_content() {
		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <span class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
				<div id="buttonset-<?php echo $this->id; ?>">
				<?php foreach ( $this->choices as $value => $label ) : ?>
					<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo $this->id .'-'. $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<label for="<?php echo $this->id .'-'. $value; ?>">
							<?php echo esc_html( $label ); ?>
						</label>
					</input>
				<?php endforeach; ?>
				</div>
				<script>
				jQuery(document).ready(function($) {
					$( '[id="buttonset-<?php echo $this->id; ?>"]' ).buttonset();
				});
				</script>
			</label>
		<?php
	}
}
