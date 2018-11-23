<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/gjerm94
 * @since             1.0.0
 * @package           Bp_Registration_Parts
 *
 * @wordpress-plugin
 * Plugin Name:       BuddyPress Registration Parts
 * Plugin URI:        https://github.com/gjerm94/bp-registration-parts
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            gjerm94
 * Author URI:        https://github.com/gjerm94
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bp-registration-parts
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Root path for the plugin 
 */
define( 'BPRP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bp-registration-parts-activator.php
 */
function activate_bp_registration_parts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bp-registration-parts-activator.php';
	Bp_Registration_Parts_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bp-registration-parts-deactivator.php
 */
function deactivate_bp_registration_parts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bp-registration-parts-deactivator.php';
	Bp_Registration_Parts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bp_registration_parts' );
register_deactivation_hook( __FILE__, 'deactivate_bp_registration_parts' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bp-registration-parts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bp_registration_parts() {

	$plugin = new Bp_Registration_Parts();
	$plugin->run();

}
run_bp_registration_parts();
