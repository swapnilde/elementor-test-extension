<?php

class Test_Control extends \Elementor\Base_Data_Control {

	public function get_type() {
		return 'emojionearea';
	}

	public function enqueue() {

	}

	protected function get_default_settings() {
		return [
			'label_block' => true,
			'rows' => 3,
			//'emojionearea_options' => [],
		];
	}

	public function content_template() {
		$control_uid = $this->get_control_uid('t-area');
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