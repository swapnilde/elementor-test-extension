<?php
/**
 * Plugin Name: Elementor Test Extension
 * Description: Custom Elementor extension.
 * Plugin URI:  https://brainstormforce.com/
 * Version:     1.0.0
 * Author:      Brainstorm Force
 * Author URI:  https://brainstormforce.com/
 * Text Domain: elementor-test-extension
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'VERSION', '1.0.0');
define( 'MINIMUM_ELEMENTOR_VERSION', '2.0.0');
define( 'MINIMUM_PHP_VERSION', '7.0.0');
define( 'BSF_ETE_DIRPATH', plugin_dir_path( __FILE__ ) );
define( 'BSF_ETE_URLPATH', plugin_dir_url( __FILE__ ) );

require_once 'includes/class-elementor-test-extension.php';