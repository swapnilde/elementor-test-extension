<?php
/**
 * Class Elementor_Test_Extension
 *
 * @package     elementor-test-extension
 */

namespace ElementorTestExtension;

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Elementor_Test_Extension
 *
 * @since 1.0.0
 */
final class Elementor_Test_Extension {

	/**
	 * Class instance property
	 *
	 * @var $instance
	 *
	 * @since 1.0.0
	 */
	private static $instance = null;

	/**
	 * Singleton instance
	 *
	 * @return Elementor_Test_Extension|null
	 *
	 * @since 1.0.0
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;

	}

	/**
	 * Elementor_Test_Extension constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'load_textdomain' ) );
		add_action( 'plugins_loaded', array( $this, 'init' ) );

	}

	/**
	 * Load the text domain of the plugin
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {

		load_plugin_textdomain( 'ele-test-ext', false, basename( dirname( __FILE__ ) ) . '/languages/' );

	}

	/**
	 * Initialize the plugin
	 *
	 * @since 1.0.0
	 */
	public function init() {

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		if ( ! version_compare( ELEMENTOR_VERSION, MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		if ( version_compare( PHP_VERSION, MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_widgets' ) );
		add_action( 'elementor/controls/controls_registered', array( $this, 'init_controls' ) );

		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'widget_styles' ) );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) && wp_verify_nonce( isset( $_GET['_wpnonce'] ) ) ) {
			unset( $_GET['activate'] );
		}
		?>
		<div class='notice notice-error'><p>
					<?php
					echo 'Elementor Test Extension requires Elementor to be installed and activated.';
					?>
				</p>
		</div>
		<?php

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) && wp_verify_nonce( isset( $_GET['_wpnonce'] ) ) ) {
			unset( $_GET['activate'] );
		}
		?>
		<div class='notice notice-error'><p>
				<?php
				/* translators: 1: Required ELEMENTOR version */
				sprintf( esc_html__( 'Elementor Test Extension requires Elementor version %1$s or greater', 'ele-test-ext' ), MINIMUM_ELEMENTOR_VERSION );
				?>
			</p>
		</div>
		<?php

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) && wp_verify_nonce( isset( $_GET['_wpnonce'] ) ) ) {
			unset( $_GET['activate'] );
		}
		?>
		<div class='notice notice-error'><p>
				<?php
				/* translators: 1: Required PHP version */
				sprintf( esc_html__( 'Elementor Test Extension requires PHP version %1$s or grater', 'ele-test-ext' ), MINIMUM_PHP_VERSION );
				?>
			</p>
		</div>
		<?php

	}

	/**
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 */
	public function init_widgets() {

		require_once BSF_ETE_DIRPATH . '/widgets/class-elementor-test-widget.php';
		require_once BSF_ETE_DIRPATH . '/widgets/class-elementor-repeater-widget.php';
		require_once BSF_ETE_DIRPATH . '/widgets/class-condition-widget.php';
		require_once BSF_ETE_DIRPATH . '/widgets/class-responsive-widget.php';
		require_once BSF_ETE_DIRPATH . '/widgets/class-random.php';

		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Elementor_Test_Widget() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Elementor_Repeater_Widget() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Condition_Widget() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Responsive_Widget() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Random() );


	}

	/**
	 * Include controls files and register them
	 *
	 * @since 1.0.0
	 */
	public function init_controls() {

		require_once BSF_ETE_DIRPATH . '/controls/class-test-control.php';

		Plugin::$instance->controls_manager->register_control( 'emojionearea', new Controls\Test_Control() );

	}

	/**
	 * Register Widget Styles
	 *
	 * @since 1.0.0
	 */
	public function widget_styles() {
		wp_enqueue_style( 'test-widget', BSF_ETE_URLPATH . '/assets/css/test-widget.css', array(), '1.0.0' );
		wp_enqueue_style( 'repeater-widget', BSF_ETE_URLPATH . '/assets/css/repeater-widget.css', array(), '1.0.0' );
	}

}

Elementor_Test_Extension::instance();
