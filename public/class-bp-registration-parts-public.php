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
	 * 
	 */
	private $step_counter;

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
		$this->step_counter = 0;
	
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bp-registration-parts-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bp-registration-parts-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Displays a part of the registration
	 * 
	 * @todo 	Allow users to change the page instead of hard coding the slug
	 * @since 	1.0.0
	 */
	public function display_part( $content ) {
	
	$bprp = new Bp_Registration_Parts();	
	$page_slug = $bprp->get_parts_slug();	
	$step_num = 0;

			if ( isset( $_GET['step'])) {
				$step_num = $_GET['step'];
			}
	if ( basename( get_permalink( ) ) == $page_slug ) {

		if ( in_the_loop() ) {
			
			$group_ids = $this->get_profile_group_ids();

			

			// Change the step number according to which button was clicked.
			if ( isset( $_POST['profile-group-edit-submit']) || isset( $_POST['profile-group-edit-prev'] ) ) {

				if (isset ( $_POST['profile-group-edit-submit'] ) ) {

					$step_num++; 

				} elseif ( isset( $_POST['profile-group-edit-prev'] ) ) {

					$step_num--;

				} 
			
			}

			// Load the right template.
			if ( $group_ids[$step_num]['id'] == 'avatar_upload' ) {
				require_once plugin_dir_path(dirname(__FILE__)) . 'includes/templates/change-avatar.php';	
			} elseif ( $group_ids[$step_num]['id'] == 'suggestions' ) {

			} else {
				require_once plugin_dir_path(dirname(__FILE__)) . 'includes/templates/part-template.php';	
			}
		
		}		
	
	}
		return $content;

	}

	public function display_avatar_edit() {

	}

	public function display_friend_suggestions() {

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

		$args = apply_filters( 'bprp_xprofile_groups_args', array() );
		
		$groups = bp_xprofile_get_groups( $args );
		
		usort( $groups, array( $this, 'sort_group_by_order' ));	
		
		foreach ( $groups as $group ) {
				$group_ids[] = array(
					'id' => $group->id,
					'name' => $group->name
				);
		}

		if ( $this->should_show_avatar_upload() ) {
			$group_ids[] = array( 
				'id' 	=> 'avatar_upload',
				'name'  => __( 'Profile Photo', 'bp-registration-parts')
			);
		}

		if ( $this->should_show_suggestions() ) {
			$groups_ids[] = array( 
				'id' 	=>'suggestions',
				'name'  => __( 'Add some friends!', 'bp-registration-parts' ) 
			);
		}
		return $group_ids;

	}

	/**
	 * Gets the current step number
	 */
	public function get_step_counter() {
		return $this->step_counter;
	}
	/**
	 * Used with usort to sort field groups by group order in ascending order
	 */
	public function sort_group_by_order( $grp1, $grp2 ) {
		return $grp1->group_order > $grp2->group_order;
	}

	/**
	 * Check if last step of registration
	 */
	public function is_first_step( $group_ids, $step_num ) {
		
		if ( $step_num < 1 ) {
			return true;
		}

		return false;

	}

	/**
	 * Check if first step of registration
	 */
	public function is_last_step( $group_ids, $step_num ) {
	
		return $group_ids[$step_num] == end( $group_ids );
		
	}

	public function should_show_suggestions() {
		return false;
	}

	public function should_show_avatar_upload() {
		return true;
	}

	public function is_suggestions_page() {
		if ( isset( $_GET['step'] )) {
			if ( $_GET['step'] == 'suggestions' ) {
				return true;
			}
		}

		return false;
	}

	public function is_avatar_upload_page() {

		if ( isset( $_GET['step'] )) {
			if ( $_GET['step'] == 'avatar_upload' ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Displays the group nav at the top of the part template
	 * 
	 * "Nav" is kind of misleading here because we are not adding any links
	 * just the name of the group and the step #.
	 * 
	 * @since 	1.0.0
	 */
	public function display_field_groups_nav( $group_ids, $current_group_id ) {
		
		for ( $i = 0, $count = count($group_ids); $i < $count; ++$i ) {
			
			//$group = new BP_XProfile_Group($id = $group_ids[$i]->id);
			// Setup the selected class.
			$selected = '';
			
			if ( $group_ids[$i]['id'] === $current_group_id ) {
				$selected = ' class="current"';
			}

			$step = sprintf( __( 'Step %s: ', 'bp-registration-parts' ), $i + 1);
			
			//Add tab to end of tabs array.
			$tabs[] = sprintf(
				'<li %1$s><span class="registration-step">%2$s</span><span class="profile-group-name">%3$s</span></li>',
				$selected,
				esc_html( $step ),
				esc_html( apply_filters( 'bprp_get_the_profile_group_name', $group_ids[$i]['name'] ) )
			);
		
		}

		echo join( '', $tabs );

	}

	/**
	 * Adds compatibility with BP Conditional Profile Fields plugin
	 * 
	 * @since 	1.0.0
	 */
	public function add_bpcpf_compat($is_active) {
		
		$bprp = new Bp_Registration_Parts();
		
		if ( $bprp->is_parts_page() ) {
			$is_active = true;
		}
		
		return $is_active;
	
	}

	/**
	 * Displays the previous and/or next buttons
	 * 
	 * @since 	1.0.0
	 */
	public function display_prev_next_buttons($group_ids, $step_num) {
		?>
		
			
			<?php if ( !$this->is_first_step($group_ids, $step_num) ) : ?>
				<input type="submit" name="profile-group-edit-prev" id="profile-group-edit-prev" value="<?php esc_attr_e( '❮ Previous step', 'bp-registration-parts' ); ?> " />	
			<?php endif; ?> 
		
			<?php 
			$text = __('Next step ❯', 'bp-registration-parts');
			if ( $this->is_last_step($group_ids, $step_num)) {
				$text = __('Save & submit', 'bp-registration-parts');
			}
			?>

			<input type="submit" name="profile-group-edit-submit" id="profile-group-edit-submit" value="<?php esc_attr_e( $text, 'bp-registration-parts' ); ?> " />
			
		
		<?php
	}
}
