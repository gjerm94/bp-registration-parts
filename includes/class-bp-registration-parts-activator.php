<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/gjerm94
 * @since      1.0.0
 *
 * @package    Bp_Registration_Parts
 * @subpackage Bp_Registration_Parts/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Bp_Registration_Parts
 * @subpackage Bp_Registration_Parts/includes
 * @author     gjerm94 <gjermundbakken94@gmail.com>
 */
class Bp_Registration_Parts_Activator {

	/**
	 * Sets bprp_completed to true for all registered users
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		global $wpdb;
		
		$users = get_users();
		 
		foreach ( $users as $user ) {
			add_user_meta( $user->id, '_bprp_completed', true ); 
		}
	
	}

}
