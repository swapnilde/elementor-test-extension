<?php
/**
 * Class Elementor_Repeater_Widget
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
 * Class Elementor_Repeater_Widget
 *
 * @since 1.0.0
 */
class Elementor_Repeater_Widget extends Widget_Base {

	/**
	 * Retrieve widget name.
	 *
	 * @return string Widget name.
	 *
	 * @since 1.0.0
	 */
	public function get_name() {
		return 'bsf_repeater';
	}

	/**
	 * Retrieve widget title.
	 *
	 * @return string Widget title.
	 *
	 * @since 1.0.0
	 */
	public function get_title() {
		return 'BSF Repeater';
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
				'label' => 'BSF Repeater',
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_title',
			array(
				'label'   => 'Title',
				'type'    => Controls_Manager::TEXT,
				'default' => 'List Title',
			)
		);

		$repeater->add_control(
			'list_content',
			array(
				'label'   => 'Content',
				'type'    => Controls_Manager::WYSIWYG,
				'default' => 'List Content',
			)
		);

		$repeater->add_control(
			'list_color',
			array(
				'label'     => 'Color',
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'list',
			array(
				'label'   => 'Repeater List',
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => array(
					array(
						'list_title'   => 'Title #1',
						'list_content' => 'Item content. Click the edit button to change this text.',
					),
					array(
						'list_title'   => 'Title #2',
						'list_content' => 'Item content. Click the edit button to change this text.',
					),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style-section',
			array(
				'label' => 'Repeater Styles',
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'popover_toggle',
			array(
				'label'        => 'Box',
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => 'Default',
				'label_on'     => 'Custom',
				'return_value' => 'yes',
			)
		);

			$this->start_popover();

				$this->add_control(
					'hover_animation',
					array(
						'label'   => 'Hover Animation',
						'type'    => Controls_Manager::HOVER_ANIMATION,
						'default' => 'float',
					)
				);

			$this->end_popover();

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

		echo esc_html__( '<div class="card-container card--fixedWidth">', 'ele-test-ext' );
		foreach ( $settings['list'] as $setting ) {
			//phpcs:disable
			?>

				<div class="card elementor-repeater-item-<?php echo $setting['_id']; ?> <?php echo 'elementor-animation-' . $settings['hover_animation']; ?>">
					<h6><?php echo $setting['list_title']; ?></h6>
					<p><?php echo $setting['list_content']; ?></p>
				</div>

			<?php
			//phpcs:enable
		}
		echo '</div>';

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
		<# if ( settings.list.length ) { #>
		<div class="card-container card--fixedWidth">
			<# _.each( settings.list, function( item ) { #>
			<div class="card elementor-repeater-item-{{ item._id }} elementor-animation-{{settings.hover_animation}}">
				<h6>{{{ item.list_title }}}</h6>
				<p>{{{ item.list_content }}}</p>
			</div>
			<# }); #>
		</div>
		<# } #>
		<?php
	}
}
