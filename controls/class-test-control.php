<?php
/**
 * Class Test_Control
 *
 * @package     elementor-test-extension
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Test_Control
 *
 * A control for displaying a textarea with the ability to add emojis.
 *
 * @since 1.0.0
 */
class Test_Control extends \Elementor\Base_Data_Control {

	/**
	 * Retrieve the control type, in this case `emojionearea`.
	 *
	 * @return string Control type.
	 *
	 * @since 1.0.0
	 */
	public function get_type() {
		return 'emojionearea';
	}

	/**
	 * Used to register and enqueue custom scripts and styles used by the control.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {

		wp_enqueue_style( 'emojionearea', 'https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.css', array(), '3.4.1' );

		wp_register_script( 'emojionearea', 'https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.1/emojionearea.js', array(), '3.4.1', true );
		wp_enqueue_script( 'emojionearea-control', BSF_ETE_URLPATH . '/assets/js/emojionearea-control.js', array( 'emojionearea', 'jquery' ), '1.0.0', true );
	}

	/**
	 * Retrieve the default settings of the emoji one area control. Used to return
	 * the default settings while initializing the emoji one area control.
	 *
	 * @return array Control default settings.
	 *
	 * @since 1.0.0
	 */
	protected function get_default_settings() {
		return array(
			'label_block'          => true,
			'rows'                 => 3,
			'emojionearea_options' => array(),
		);
	}

	/**
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<div class="elementor-control-input-wrapper">
				<textarea id="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-tag-area" rows="{{ data.rows }}" data-setting="{{ data.name }}" placeholder="{{ data.placeholder }}"></textarea>
			</div>
		</div>
		<# if ( data.description ) { #>
		<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
