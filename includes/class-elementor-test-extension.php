<?php

final class Elementor_Test_Extension {

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function __construct() {

		add_action( 'init', [ $this, 'load_textdomain' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	public function load_textdomain() {

		load_plugin_textdomain( 'elementor-test-extension', false, basename( dirname( __FILE__ ) ) . '/languages/' );

	}

	public function init() {


		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}


		if ( ! version_compare( ELEMENTOR_VERSION, MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}


		if ( version_compare( PHP_VERSION, MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}


		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );

		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );
	}

	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		?>
		<div class='notice notice-error'><p>
					<?php
					echo 'Elementor Test Extension requires Elementor to be installed and activated.';
					?>
				</p>
		</div>
		<?php

	}

	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		?>
		<div class='notice notice-error'><p>
				<?php
				echo 'Elementor Test Extension requires Elementor version ' . MINIMUM_ELEMENTOR_VERSION .'or greater' ;
				?>
			</p>
		</div>
		<?php

	}

	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		?>
		<div class='notice notice-error'><p>
				<?php
				echo 'Elementor Test Extension requires PHP version ' . MINIMUM_PHP_VERSION . 'or grater';
				?>
			</p>
		</div>
		<?php

	}

	public function init_widgets() {

		require_once( BSF_ETE_DIRPATH . '/widgets/class-elementor-test-widget.php' );
		require_once (BSF_ETE_DIRPATH . '/widgets/class-elementor-repeater-widget.php');

		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Test_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Repeater_Widget() );

	}

	public function init_controls() {

		require_once( BSF_ETE_DIRPATH . '/controls/class-test-control.php' );

		\Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Test_Control() );

	}

	public function widget_styles(){
		wp_enqueue_style( 'test-widget', BSF_ETE_URLPATH . '/assets/test-widget.css' );
		wp_enqueue_style( 'repeater-widget', BSF_ETE_URLPATH . '/assets/repeater-widget.css' );
	}

}

Elementor_Test_Extension::instance();