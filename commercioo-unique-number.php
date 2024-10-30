<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:       Commercioo Unique Number
 * Plugin URI:        https://commercioo.com
 * Description:       Unique number for bank transfer payment.
 * Version:           0.0.2
 * Author:            Commercioo
 * Author URI:        https://profiles.wordpress.org/commercioo
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       commercioo-unique-number
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'COMMERCIOO_UNIQUE_NUMBER_VERSION', '0.0.2' );
define( 'COMMERCIOO_UNIQUE_NUMBER_FILE', __FILE__ );
define( 'COMMERCIOO_UNIQUE_NUMBER_PATH', plugin_dir_path( __FILE__ ) );
define( 'COMMERCIOO_UNIQUE_NUMBER_BASENAME', plugin_basename(__FILE__));
define( 'COMMERCIOO_UNIQUE_NUMBER_URL', plugin_dir_url( __FILE__ ) );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-commercioo-unique-number-activator.php
 */
function activate_commercioo_unique_number() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-commercioo-unique-number-activator.php';
	Commercioo_Unique_Number_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-commercioo-unique-number-deactivator.php
 */
function deactivate_commercioo_unique_number() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-commercioo-unique-number-deactivator.php';
	Commercioo_Unique_Number_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_commercioo_unique_number' );
register_deactivation_hook( __FILE__, 'deactivate_commercioo_unique_number' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-commercioo-unique-number.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */
function run_commercioo_unique_number() {

	$plugin = new Commercioo_Unique_Number();
	$plugin->run();

}
run_commercioo_unique_number();
