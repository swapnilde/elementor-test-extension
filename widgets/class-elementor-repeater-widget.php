<?php

class Elementor_Repeater_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'bsf_repeater';
	}

	public function get_title() {
		return 'BSF Repeater';
	}

	public function get_icon() {
		return 'fa fa-file-image-o';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => 'BSF Repeater',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title',
			[
				'label' => 'Title',
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' =>'List Title',
			]
		);

		$repeater->add_control(
			'list_content',
			[
				'label' =>'Content',
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' =>'List Content' ,
			]
		);

		$repeater->add_control(
			'list_color',
			[
				'label' =>'Color',
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label' =>'Repeater List',
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_title' => 'Title #1',
						'list_content' => 'Item content. Click the edit button to change this text.',
					],
					[
						'list_title' => 'Title #2',
						'list_content' => 'Item content. Click the edit button to change this text.',
					],
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		echo '<div class="card-container card--fixedWidth">';
		foreach ($settings['list'] as $setting){
			?>
				<div class="card elementor-repeater-item-<?php echo $setting['_id'] ?>">
				    <h6><?php echo $setting['list_title'] ?></h6>
					<p><?php echo $setting['list_content'] ?></p>
			    </div>
			<?php
		}
		echo '</div>';

	}

	protected function _content_template() {
		?>
		<# if ( settings.list.length ) { #>
		<div class="card-container card--fixedWidth">
			<# _.each( settings.list, function( item ) { #>
			<div class="card elementor-repeater-item-{{ item._id }}">
				<h6>{{{ item.list_title }}}</h6>
				<p>{{{ item.list_content }}}</p>
			</div>
			<# }); #>
		</div>
		<# } #>
		<?php
	}
}