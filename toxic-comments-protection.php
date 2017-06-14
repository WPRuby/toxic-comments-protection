<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpruby.com
 * @since             1.0.0
 * @package           Toxic_Comments_Protection
 *
 * @wordpress-plugin
 * Plugin Name:       Toxic Comments Protection
 * Plugin URI:        https://wpruby.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            WPRuby
 * Author URI:        https://wpruby.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       toxic-comments-protection
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-toxic-comments-protection-activator.php
 */
function activate_toxic_comments_protection() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-toxic-comments-protection-activator.php';
	Toxic_Comments_Protection_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-toxic-comments-protection-deactivator.php
 */
function deactivate_toxic_comments_protection() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-toxic-comments-protection-deactivator.php';
	Toxic_Comments_Protection_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_toxic_comments_protection' );
register_deactivation_hook( __FILE__, 'deactivate_toxic_comments_protection' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-toxic-comments-protection.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_toxic_comments_protection() {

	$plugin = new Toxic_Comments_Protection();
	$plugin->run();

}
run_toxic_comments_protection();
