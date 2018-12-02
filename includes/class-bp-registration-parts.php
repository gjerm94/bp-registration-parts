<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/gjerm94
 * @since      1.0.0
 *
 * @package    Bp_Registration_Parts
 * @subpackage Bp_Registration_Parts/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Bp_Registration_Parts
 * @subpackage Bp_Registration_Parts/includes
 * @author     gjerm94 <gjermundbakken94@gmail.com>
 */
class Bp_Registration_Parts {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Bp_Registration_Parts_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Slug of the page used to display the parts template.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $pars_page    The page slug.
	 */	
	protected $parts_slug;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'bp-registration-parts';
		$this->parts_slug = 'post-reg-setup';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_core_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Bp_Registration_Parts_Loader. Orchestrates the hooks of the plugin.
	 * - Bp_Registration_Parts_i18n. Defines internationalization functionality.
	 * - Bp_Registration_Parts_Admin. Defines all hooks for the admin area.
	 * - Bp_Registration_Parts_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bp-registration-parts-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-bp-registration-parts-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-bp-registration-parts-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-bp-registration-parts-public.php';


		$this->loader = new Bp_Registration_Parts_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Bp_Registration_Parts_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Bp_Registration_Parts_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}
	
	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Bp_Registration_Parts_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
	
		$plugin_public = new Bp_Registration_Parts_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		$this->loader->add_filter( 'the_content', $plugin_public, 'display_part' );
		$this->loader->add_filter( 'bp_is_conditional_profile_field_active', $plugin_public, 'add_bpcpf_compat' );
		
	}

	/**
	 * Register all of the hooks not specifically related to the 
	 * core functionality of the plugin
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_core_hooks() {

		$this->loader->add_filter( 'bp_attachment_avatar_params', $this, 'filter_bp_attachment_avatar_params' ); 
		$this->loader->add_filter( 'bp_avatar_is_front_edit', $this, 'add_avatar_functionality' );
		$this->loader->add_action( 'user_register', $this, 'add_bprp_completed_meta' );
		$this->loader->add_action( 'template_redirect', $this, 'redirect_to_part_page' );

	}
	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Bp_Registration_Parts_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the slug of the page used to display the parts template.
	 *
	 * @since     1.0.0
	 * @return    string    The page slug.
	 */
	public function get_parts_slug() {
		return $this->parts_slug;
	}

	/**
	 * Registers bprp_completed meta for user.
	 * 
	 * This meta field is used to determine if a user has completed the registration steps.
	 * 
	 * @since 	1.0.0
	 */
	public function add_bprp_completed_meta( $user_id ) {
		add_user_meta( $user_id, '_bprp_completed', false ); 
	}

	/**
	 * Redirects to the registration parts page if current user has not completed registration
	 * 
	 * @since 	1.0.0
	 */
	public function redirect_to_part_page( ) {
	
		if (is_user_logged_in()) {
			
			$user_id = wp_get_current_user()->ID;
			$completed = get_user_meta( $user_id, '_bprp_completed', true);
			
			if ( ! $completed ) {
				
				if ( ! $this->is_parts_page() ) {
					
					wp_redirect( home_url( $this->parts_slug ) );	
					exit;
				
				}
			
			}
		
		}
	
	}

	/**
	 * Adds buddypress avatar edit page functionality
	 * 
	 * @since 	1.0.0
	 */
	public function add_avatar_functionality( $retval ) {
		
		if ( $this->is_parts_page()) {
			$retval = true;
		}
	
		return $retval;

	}

	public function is_parts_page() {
		return home_url( parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ) === home_url( $this->parts_slug ); 
	}

	/**
	 * Filters the bp avatar params so it fetches the right user ID.
	 * 
	 * @since 	1.0.0
	 */
	public function filter_bp_attachment_avatar_params( $bp_params ) { 

		if ( $this->is_parts_page ) {
			
			$bp_params = array(
				'object'     => 'user',
				'item_id'    => get_current_user_id(),
				'nonces'  => array(
					'set'    => wp_create_nonce( 'bp_avatar_cropstore' ),
					'remove' => wp_create_nonce( 'bp_delete_avatar_link' ),
				),
			);
			
		}
		
		return $bp_params; 

	} 

}
