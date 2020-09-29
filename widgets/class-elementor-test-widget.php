<?php


use Elementor\Base_Data_Control;
use Elementor\Controls_Manager;

class Elementor_Test_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'bsf_ad';
	}

	public function get_title() {
		return 'BSF Insert Ad';
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
				'label' => 'BSF Ad',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'main_heading',
			[
				'label' => 'Main Heading',
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'My Main Heading',
			],
		);

		$this->add_control(
			'content_heading',
			[
				'label' => 'Content Heading',
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => 'My Content Heading',
			],
		);

		$this->add_control(
			'content',
			[
				'label' => 'Content',
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => 'This is a dummy content. Put your content here.',
			],
		);

		$this->add_control(
				'emoji_text',
			[
				'label' => 'Text with emoji',
				'type' => 'emojionearea',
				'default' => 'Here you can write content with emojis.'
			]
		);

		$this->add_control(
				'select_opt',
				[
					'label'	=> 'Select Fruit',
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'Orange',
					'options' => [
							'Orange'=>'Orange',
							'Apple'=>'Apple',
							'Pineapple'=>'Pineapple',
							'Mango'=>'Mango',
					],
				]
		);

		$this->add_control(
				'select_adv',
				[
					'label'=>'Select Position',
					'type'=>\Elementor\Controls_Manager::SELECT2,
					'default'=>['Top'],
					'options'=>[
						'Top'=>'Top',
						'Middle'=>'Middle',
						'Bottom'=>'Bottom',
					],
					'multiple'=>true,
				],
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes('main_heading', 'basic');
		$this->add_inline_editing_attributes('content_heading', 'basic');
		$this->add_inline_editing_attributes('content', 'advanced');

		$this->add_render_attribute(
			'main_heading',
			[
				'class' => ['ad__main_heading'],
			]
		);
		$this->add_render_attribute(
			'content_heading',
			[
				'class' => ['ad__content_heading'],
			]
		);
		$this->add_render_attribute(
			'content',
			[
				'class' => ['ad__content_copy'],
			]
		);

		?>

		<div class="ad">
			<div <?php echo $this->get_render_attribute_string( 'main_heading'); ?> >
				<?php echo $settings['main_heading']?>
			</div>
			<div class="ad__content">
				<div <?php echo $this->get_render_attribute_string( 'content_heading'); ?>>
					<?php echo $settings['content_heading'] ?>
				</div>
				<div <?php echo $this->get_render_attribute_string( 'content'); ?>>
					<?php echo $settings['content'] ?>
				</div>
				<div>
					<?php echo $settings['select_opt'] ?>
				</div>
					<?php
						foreach ($settings['select_adv'] as $position){
							echo '<div>' . $position . '</div>';
						}
					?>
			</div>
		</div>

		<?php
	}

	protected function _content_template() {
		?>

		<#
		view.addInlineEditingAttributes( 'main_heading', 'basic' );
		view.addInlineEditingAttributes( 'content_heading', 'basic' );
		view.addInlineEditingAttributes( 'content', 'advanced' );

			view.addRenderAttribute(
				'main_heading',
				{
				'class': [ 'ad__main_heading' ],
				}
			);
			view.addRenderAttribute(
				'content_heading',
				{
				'class': [ 'ad__content_heading' ],
				}
			);
			view.addRenderAttribute(
				'content',
				{
				'class': [ 'ad__content_copy' ],
				}
			);
		#>

		<div class="ad">
			<div {{{ view.getRenderAttributeString( 'main_heading' ) }}}>
				{{{ settings.main_heading }}}
			</div>
			<div class="ad__content">
				<div {{{ view.getRenderAttributeString( 'content_heading' ) }}}>
					{{{ settings.content_heading }}}
				</div>
				<div {{{ view.getRenderAttributeString( 'content' ) }}}>
					{{{ settings.content }}}
				</div>
				<div>
					{{{settings.select_opt}}}
				</div>
				<div>
					<#
						_.each(settings.select_adv, function(position){
							{{{position}}}
						});
					#>
				</div>
			</div>
		</div>

		<?php
	}
}