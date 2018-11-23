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
	public function display_part() {
		
		if ( basename( get_permalink( ) ) == 'post-reg-setup' ) {
		
			if ( in_the_loop() ) {
				

				$template_loader = new BP_Registration_Parts_Template_Loader;
				
				$data = array( 'group_id' => 8 );
				$template_loader->set_template_data( $data );
				$template_loader->get_template_part('part-template');
		
			}		
		
		}
	
	}
}
