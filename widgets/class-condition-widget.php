<?php
/**
 * Class Condition_Widget
 *
 * @package     elementor-test-extension
 */

namespace ElementorTestExtension\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Condition_Widget
 *
 * @since 1.0.0
 */
class Condition_Widget extends Widget_Base {

	/**
	 * Retrieve widget name.
	 *
	 * @return string Widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'ete_condition';
	}

	/**
	 * Retrieve widget title.
	 *
	 * @return string Widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return 'ETE Conditional content';
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
				'label' => 'Content',
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'content_type',
			array(
				'label'   => 'Select content type',
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'simple'  => array(
						'title' => 'Simple',
						'icon'  => 'fas fa-align-justify',
					),
					'advance' => array(
						'title' => 'HTML',
						'icon'  => 'fas fa-code',
					),
				),
				'default' => '',
				'toggle'  => true,
			)
		);

		$this->add_control(
			'simple_content',
			array(
				'label'       => 'Simple Content',
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 10,
				'default'     => '',
				'placeholder' => 'Type your content here',
				'condition'   => array(
					'content_type' => 'simple',
				),
			)
		);

		$this->add_control(
			'advance_content',
			array(
				'label'       => 'Advanced Content',
				'type'        => Controls_Manager::WYSIWYG,
				'default'     => '',
				'placeholder' => 'Type your content here',
				'condition'   => array(
					'content_type' => 'advance',
				),
			)
		);

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

		$this->add_inline_editing_attributes( 'simple_content', 'basic' );
		$this->add_inline_editing_attributes( 'advance_content', 'advanced' );
		//phpcs:disable
		?>
			<div class="container">
				<?php
				if ( 'simple' === $settings['content_type'] ) {
					?>
					<p><?php echo $settings['simple_content']; ?></p>
					<?php
				}
				if ( 'advance' === $settings['content_type'] ) {
					?>
					<p><?php echo $settings['advance_content']; ?></p>
					<?php
				}
				?>
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
		view.addInlineEditingAttributes( 'simple_content', 'basic' );
		view.addInlineEditingAttributes( 'advance_content', 'advanced' );
		#>

		<div class="container">
			<# if('simple' === settings.content_type){ #>
			<p>{{{ settings.simple_content }}}</p>
			<# }
				if('advance' === settings.content_type){ #>
					<p>{{{settings.advance_content}}}</p>
				<# }
			#>
		</div>

		<?php

	}
}
