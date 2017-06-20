<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

/**
 * Class to create a image select
 */
class Image_Select_Control extends WP_Customize_Control {
	
	public function render_content() {
		$name = '_customize-radio-' . $this->id;
		?>
		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <span class="description customize-control-description"><?php echo esc_attr( $this->description ); ?></span>
		<?php foreach ( $this->choices as $value => $image ) : ?>
			<?php $class_selected = ( $this->value() == $value ) ? ' onetone-radio-img-selected' : ''; ?>
			<label class="image-radio-control">
				<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> class="screen-reader-text" />
				<span class="control-image">
					<img src="<?php echo esc_html( $image ); ?>" class="onetone-radio-img<?php echo $class_selected; ?>"/>
				</span>
			</label>
		<?php endforeach;
	}

}