<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wpruby.com
 * @since      1.0.0
 *
 * @package    Toxic_Comments_Protection
 * @subpackage Toxic_Comments_Protection/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Toxic_Comments_Protection
 * @subpackage Toxic_Comments_Protection/includes
 * @author     WPRuby <info@wpruby.com>
 */
class Toxic_Comments_Protection_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		$tcp_general = array(
				'tcp_general' =>	array(
					'hold_comments_score_ceil'	=>	'90'
				)
		);
		add_option('tcp_general', $tcp_general);
	}

}
