<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/gjerm94
 * @since      1.0.0
 *
 * @package    Bp_Registration_Parts
 * @subpackage Bp_Registration_Parts/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Bp_Registration_Parts
 * @subpackage Bp_Registration_Parts/public
 * @author     gjerm94 <gjermundbakken94@gmail.com>
 */
class Bp_Registration_Parts_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bp_Registration_Parts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bp_Registration_Parts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bp-registration-parts-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Bp_Registration_Parts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bp_Registration_Parts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bp-registration-parts-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Displays a part of the registration
	 * 
	 * @todo 	Allow users to change the page instead of hard coding the slug
	 * @since 	1.0.0
	 */
	public function display_part($content) {

		$page_slug = 'post-reg-setup';
		if ( basename( get_permalink( ) ) == $page_slug ) {
			if ( in_the_loop() ) {
			 
			$group_ids = $this->get_profile_group_ids();
			$form_action = "";		
		if (isset($_POST['current_group_id'])) {
			$current_group_id = $_POST['current_group_id'];
			$index = array_search($current_group_id, $group_ids);
			$redirect_after_save = false;
			if ( isset( $_POST['profile-group-edit-prev'])) {
				//Previous button is clicked, go back to previous group ID
				$index--;
				$current_group_id = $group_ids[$index];
			} elseif (isset ( $_POST['profile-group-edit-submit'])) {
				$index++;
				$current_group_id = $group_ids[$index];
				if ( $group_ids[$index] ) {
					$current_group_id = $group_ids[$index];
				} else {
					$redirect_after_save = true;
					$redirect_url = bp_loggedin_user_domain();
				}
					
			}
		} else {
			$current_group_id = $group_ids[0];
		}
			require_once plugin_dir_path(dirname(__FILE__)) . 'includes/templates/part-template.php';
		}		
		
		}
	
		return $content;
	
	}

	/**
	 * Retrieves IDs of all xprofile field groups
	 * IDs are sorted by group order in ascending order
	 * 
	 * @since 	1.0.0
	 * @return  array 	The IDs
	 */
	public function get_profile_group_ids() {
		
		$group_ids = [];

		$args = apply_filters( 'bprp_xprofile_groups_args', $args );
		
		$groups = bp_xprofile_get_groups( $args );
		
		usort( $groups, array( $this, 'sort_group_by_order' ));	
		
		foreach ( $groups as $group ) {
				$group_ids[] = $group->id;
		}

		return $group_ids;
	}

	/**
	 * Used with usort to sort field groups by group order in ascending order
	 */
	public function sort_group_by_order($grp1, $grp2) {
		return $grp1->group_order > $grp2->group_order;
	}
}
