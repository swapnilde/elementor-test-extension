<?php
/**
 * Class Elementor_Test_Widget
 *
 * @package     elementor-test-extension
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Elementor_Test_Widget
 *
 * @since 1.0.0
 */
class Elementor_Test_Widget extends \Elementor\Widget_Base {

	/**
	 * Retrieve widget name.
	 *
	 * @return string Widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'bsf_ad';
	}

	/**
	 * Retrieve widget title.
	 *
	 * @return string Widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return 'BSF Insert Ad';
	}

	/**
	 * Retrieve widget icon.
	 *
	 * @return string Widget icon.
	 *
	 * @since 1.0.0
	 */
	public function get_icon() {
		return 'fa fa-file-image-o';
	}

	/**
	 * Retrieve the list of categories the widget will belong to.
	 *
	 * @return array|string[] Widget categories.
	 *
	 * @since 1.0.0
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Register widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 */
	protected function _register_controls() { //phpcs:ignore

		$this->start_controls_section(
			'content_section',
			array(
				'label' => 'BSF Ad',
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->start_controls_tabs(
			'content_tabs'
		);

			$this->start_controls_tab(
				'content_regular_tab',
				array(
					'label' => 'Regular Info',
				)
			);

				$this->add_control(
					'main_heading',
					array(
						'label'   => 'Main Heading',
						'type'    => \Elementor\Controls_Manager::TEXT,
						'default' => 'My Main Heading',
					)
				);

				$this->add_control(
					'show_content_heading',
					array(
						'label'        => 'Show Content Heading',
						'type'         => \Elementor\Controls_Manager::SWITCHER,
						'label_on'     => 'Show',
						'label_off'    => 'Hide',
						'return_value' => 'yes',
						'default'      => 'yes',
					)
				);

				$this->add_control(
					'content_heading',
					array(
						'label'   => 'Content Heading',
						'type'    => \Elementor\Controls_Manager::TEXT,
						'default' => 'My Content Heading',
					)
				);

				$this->add_control(
					'content',
					array(
						'label'   => 'Content',
						'type'    => \Elementor\Controls_Manager::WYSIWYG,
						'default' => 'This is a dummy content. Put your content here.',
					)
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'content_extra_tab',
				array(
					'label' => 'Extra Info',
				)
			);

				$this->add_control(
					'emoji_text',
					array(
						'label'   => 'Text with emoji',
						'type'    => 'emojionearea',
						'default' => 'Here you can write content with emojis.',
					)
				);

				$this->add_control(
					'select_opt',
					array(
						'label'   => 'Select Fruit',
						'type'    => \Elementor\Controls_Manager::SELECT,
						'default' => 'Orange',
						'options' => array(
							'Orange'    => 'Orange',
							'Apple'     => 'Apple',
							'Pineapple' => 'Pineapple',
							'Mango'     => 'Mango',
						),
					)
				);

				$this->add_control(
					'select_adv',
					array(
						'label'    => 'Select Position',
						'type'     => \Elementor\Controls_Manager::SELECT2,
						'default'  => array( 'Top' ),
						'options'  => array(
							'Top'    => 'Top',
							'Middle' => 'Middle',
							'Bottom' => 'Bottom',
						),
						'multiple' => true,
					)
				);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes( 'main_heading', 'basic' );
		$this->add_inline_editing_attributes( 'content_heading', 'basic' );
		$this->add_inline_editing_attributes( 'content', 'advanced' );

		$this->add_render_attribute(
			'main_heading',
			array(
				'class' => array( 'ad__main_heading' ),
			)
		);
		$this->add_render_attribute(
			'content_heading',
			array(
				'class' => array( 'ad__content_heading' ),
			)
		);
		$this->add_render_attribute(
			'content',
			array(
				'class' => array( 'ad__content_copy' ),
			)
		);
		//phpcs:disable
		?>

		<div class="ad">
			<div <?php echo $this->get_render_attribute_string( 'main_heading' ); ?> >
				<?php echo $settings['main_heading']; ?>
			</div>
			<div class="ad__content">
				<div <?php echo $this->get_render_attribute_string( 'content_heading' ); ?>>
					<?php
					if ( 'yes' === $settings['show_content_heading'] ) {
						echo $settings['content_heading'];
					}
					?>
				</div>
				<div <?php echo $this->get_render_attribute_string( 'content' ); ?>>
					<?php echo $settings['content']; ?>
				</div>
				<div>
					<?php echo $settings['select_opt']; ?>
				</div>
					<?php
					foreach ( $settings['select_adv'] as $position ) {
						echo '<div>' . $position . '</div>';
					}
					?>
			</div>
		</div>

		<?php
		//phpcs:enable
	}

	/**
	 * Render widget output on the live preview.
	 *
	 * Written in Backbone JS template and used to generate HTML in live preview.
	 *
	 * @since 1.0.0
	 */
	protected function _content_template() { //phpcs:ignore
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
					<# if('yes' === settings.show_content_heading){ #>
							{{{ settings.content_heading }}}
					<# }
					#>
				</div>
				<div {{{ view.getRenderAttributeString( 'content' ) }}}>
					{{{ settings.content }}}
				</div>
				<div>
					{{{settings.select_opt}}}
				</div>
				<div>
					<#
						_.each(settings.select_adv, function(position){ #>
							{{{position}}}
					<#	});
					#>
				</div>
			</div>
		</div>

		<?php
	}
}
