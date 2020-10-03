<?php
/**
 * Class Random
 *
 * @package     elementor-test-extension
 */

namespace ElementorTestExtension\Widgets;

use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Random
 *
 * @since 1.0.0
 */
class Random extends Widget_Base {

	/**
	 * Retrieve widget name.
	 *
	 * @return string Widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'ete_random';
	}

	/**
	 * Retrieve widget title.
	 *
	 * @return string Widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return 'ETE Random';
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
	protected function _register_controls() { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		$this->start_controls_section(
			'content_section',
			array(
				'label' => 'Content',
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'label'    => __( 'Typography', 'plugin-domain' ),
				'scheme'   => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .text',
			)
		);

		$this->add_control(
			'margin',
			array(
				'label'      => 'Margin',
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'name'     => 'text_shadow',
				'label'    => 'Text Shadow',
				'selector' => '{{WRAPPER}} .text-shadow',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'box_shadow',
				'label'    => 'Box Shadow',
				'selector' => '{{WRAPPER}} .box-shadow',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'background',
				'label'    => 'Background',
				'types'    => array( 'classic', 'gradient', 'video' ),
				'selector' => '{{WRAPPER}} .background',
			)
		);

		$this->add_control(
			'number',
			array(
				'label'   => 'Number',
				'type'    => Controls_Manager::NUMBER,
				'min'     => 5,
				'max'     => 100,
				'step'    => 5,
				'default' => 10,
			)
		);

		$this->add_control(
			'custom_html',
			array(
				'label'    => 'Custom HTML',
				'type'     => Controls_Manager::CODE,
				'language' => 'html',
				'rows'     => 20,
			)
		);

		$this->add_control(
			'entrance_animation',
			array(
				'label' => 'Entrance Animation',
				'type'  => Controls_Manager::ANIMATION,
			)
		);

		$this->add_control(
			'gallery',
			array(
				'label'   => 'Add Images',
				'type'    => Controls_Manager::GALLERY,
				'default' => array(),
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
		<div class="text box text-shadow box-shadow background animated-<?php echo $settings['entrance_animation']; ?>">
			<p>This is a dummy text.</p>
			<p class="number"><?php echo $settings['number']; ?></p>
			<div class="custom_html">
				<?php echo $settings['custom_html']; ?>
			</div>
			<br>
			<div class="gallery">
				<?php
				foreach ( $settings['gallery'] as $image ) {
					echo '<img src="' . $image['url'] . '">';
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
	protected function _content_template() { //phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
		?>
		<div class="text box text-shadow box-shadow background animated-{{ settings.entrance_animation }}">
			<p>This is a dummy text.</p>
			<p class="number">{{{settings.number}}}</p>
			<div class="custom_html">
				{{{ settings.custom_html }}}
			</div>
			<br>
			<div class="gallery">
				<# _.each( settings.gallery, function( image ) { #>
				<img src="{{ image.url }}">
				<# }); #>
			</div>
		</div>
		<?php
	}
}
