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
				sort($group_ids);
			//var_dump($group_ids);	
		// global $_POST;	
	//var_dump($_POST['field_ids']);	
	$form_action = "";		
		if (isset($_POST['current_group_id'])) {
				//echo "rrrr";
				$current_group_id = $_POST['current_group_id'];
				$index = array_search($current_group_id, $group_ids);
				
				if ( isset( $_POST['profile-group-edit-prev'])) {
					$current_group_id = $group_ids[$index - 1];
				} else {
					if ( $group_ids[$index] != end($group_ids)) {
						$current_group_id = $group_ids[$index + 1];
					} else {
						$form_action = bp_loggedin_user_domain();
					}
				}
			} else {
				$current_group_id = $group_ids[0];
			}
			
		//	$form_action = trailingslashit( $page_slug );
			/**var_dump( $_POST['field_ids']);
				$template_loader = new BP_Registration_Parts_Template_Loader;
				$form_action = trailingslashit( $page_slug );
				$data = array( 
					'group_id' 		=> 8, 
					'form_action' 	=> $form_action
				);
				
				$template_loader->set_template_data( $data );
				
				$template_loader->get_template_part('part-template');
				*/
				require_once plugin_dir_path(dirname(__FILE__)) . 'includes/templates/part-template.php';
			}		
		
		}
	
		return $content;
	
	}

	/**
	 * Retrieves IDs of all xprofile field groups
	 * 
	 * @since 	1.0.0
	 * @return  array 	The IDs
	 */
	public function get_profile_group_ids() {
		
		$group_ids = [];
		
		if ( bp_has_profile( ) ) {
			while ( bp_profile_groups() ) : bp_the_profile_group();
			$group_ids[] = bp_get_the_profile_group_id();
			endwhile;
		}
		
		return $group_ids;
	}

	function carFormSubmit() {
    var_dump($_POST); //$_POST variables should be accessible now

    //Optional: Now you can redirect the user to your confirmation page using wp_redirect()
}
}
