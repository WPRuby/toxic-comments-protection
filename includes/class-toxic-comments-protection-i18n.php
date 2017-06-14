<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Toxic_Comments_Protection
 * @subpackage Toxic_Comments_Protection/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Toxic_Comments_Protection
 * @subpackage Toxic_Comments_Protection/includes
 * @author     WPRuby <info@wpruby.com>
 */
class Toxic_Comments_Protection_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'toxic-comments-protection',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
