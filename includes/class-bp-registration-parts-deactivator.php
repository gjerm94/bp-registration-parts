<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/gjerm94
 * @since      1.0.0
 *
 * @package    Bp_Registration_Parts
 * @subpackage Bp_Registration_Parts/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Bp_Registration_Parts
 * @subpackage Bp_Registration_Parts/includes
 * @author     gjerm94 <gjermundbakken94@gmail.com>
 */
class Bp_Registration_Parts_Deactivator {

	/**
	 * Removes user meta added by the plugin
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		global $wpdb;
		
		$users = get_users();
		 
		foreach ( $users as $user ) {
			delete_user_meta( $user->id, '_bprp_completed' ); 
		}
	
	}

}
