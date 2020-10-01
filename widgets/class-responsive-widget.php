<?php
/**
 * Class Responsive_Widget
 *
 * @package     elementor-test-extension
 */

namespace ElementorTestExtension\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Condition_Widget
 *
 * @since 1.0.0
 */
class Responsive_Widget extends Widget_Base {

	/**
	 * Retrieve widget name.
	 *
	 * @return string Widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'ete_responsive';
	}

	/**
	 * Retrieve widget title.
	 *
	 * @return string Widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return 'ETE Responsive content';
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
			'select_image',
			array(
				'label'   => 'Choose Image',
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => 'Image width',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 500,
				),
				'devices'    => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'  => array(
					'{{WRAPPER}} .widget-image' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_height',
			array(
				'label'      => 'Image height',
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 500,
				),
				'devices'    => array( 'desktop', 'tablet', 'mobile' ),
				'selectors'  => array(
					'{{WRAPPER}} .widget-image' => 'height: {{SIZE}}{{UNIT}};',
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

		//phpcs:disable
		?>

		<div>
			<img src="<?php echo $settings['select_image']['url']; ?>" class="widget-image">
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

		<div>
			<img src="{{{ settings.select_image.url }}}" class="widget-image">
		</div>

		<?php

	}

}
