
<?php

/**
 * Template for a single registration part
 *
 * @link       https://github.com/gjerm94
 * @since      1.0.0
 *
 * @package    Bp_Registration_Parts
 * @subpackage Bp_Registration_Parts/includes/templates
 */
?>

<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( $redirect_after_save ) {
	$redirect_url = apply_filters('bprp_completed_redirect_url', $redirect_url );
	wp_redirect($redirect_url);
}

require_once plugin_dir_path(dirname(__FILE__)) . 'templates/edit.php';

if ( isset( $_POST['profile-group-edit-submit']) ) {

    xprofile_screen_edit_profile();
    
    $bprp = new Bp_Registration_Parts();
    if ( ! $field_groups_completed ) {
        bp_core_redirect( home_url( $bprp->get_parts_slug() ) . '?step=' . $step_num . '&group_id=' . $group_ids[$step_num]['id']);
    } else {
        wp_redirect(home_url( $bprp->get_parts_slug() ) . '?step=' . '');
    }
} elseif ( isset( $_POST['profile-group-edit-prev']) ) {
    bp_core_redirect( home_url( $bprp->get_parts_slug() ) . '?step=' . $step_num . '&group_id=' . $group_ids[$step_num]['id']);
}

do_action( 'bp_before_profile_edit_content' ); ?>

<div id ="buddypress">
<div id="bprp-profile-group">

<?php

if ( bp_has_profile( 'user_id=' . get_current_user_id() . '&fetch_field_data=true&hide_empty_fields=0&profile_group_id=' . $group_ids[$step_num]['id']  ) ) :

	while ( bp_profile_groups() ) : bp_the_profile_group(); ?>
	<?php if ( bp_profile_has_multiple_groups() ) : ?>
					<ul class="button-nav" role="navigation">

						<?php $this->display_field_groups_nav($group_ids, $group_ids[$step_num]['id']); ?>

					</ul>
				<?php endif ;?>
	
		<form action="" method="post" id="profile-edit-form" class="standard-form <?php bp_the_profile_group_slug(); ?>">
			
			<?php
				/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
				do_action( 'bp_before_profile_field_content' ); ?>

				<h2><?php printf( __( 'Step %s: %s', 'bp-registration-parts' ), $step_num + 1, bp_get_the_profile_group_name()); ?></h2>


				

				<div class="clear"></div>

				<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

					<div<?php bp_field_css_class( 'editfield' ); ?>>
						<fieldset>

						<?php
						$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
						
						$raw_properties = array(
							'user_id' => get_current_user_id()
						);
						$dv = Devb_Conditional_XProfile_Field_Helper::get_instance();
						//var_dump($dv->to_js_objects());	

						$field_type->edit_field_html($raw_properties);
						/**
						 * Fires before the display of visibility options for the field.
						 *
						 * @since 1.7.0
						 */
						do_action( 'bp_custom_profile_edit_fields_pre_visibility' );
						?>

						<?php if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
							<p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>"><span id="<?php bp_the_profile_field_input_name(); ?>-2">
								<?php
								printf(
									__( 'This field can be seen by: %s', 'buddypress' ),
									'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
								);
								?>
								</span>
								<button type="button" class="visibility-toggle-link" aria-describedby="<?php bp_the_profile_field_input_name(); ?>-2" aria-expanded="false"><?php _ex( 'Change', 'Change profile field visibility level', 'buddypress' ); ?></button>
							</p>

							<div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">
								<fieldset>
									<legend><?php _e( 'Who can see this field?', 'buddypress' ) ?></legend>

									<?php bp_profile_visibility_radio_buttons() ?>

								</fieldset>
								<button type="button" class="field-visibility-settings-close"><?php _e( 'Close', 'buddypress' ) ?></button>
							</div>
						<?php else : ?>
							<div class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
								<?php
								printf(
									__( 'This field can be seen by: %s', 'buddypress' ),
									'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
								);
								?>
							</div>
						<?php endif ?>

						<?php

						/**
						 * Fires after the visibility options for a field.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_custom_profile_edit_fields' ); ?>

						</fieldset>
					</div>

				<?php endwhile; ?>

			<?php

			/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
			do_action( 'bp_after_profile_field_content' ); ?>

			<div class="submit">


			<?php $this->display_prev_next_buttons($group_ids, $step_num); ?>			
				
			
			</div>

			<input type="hidden" name="field_ids" id="field_ids" value="<?php bp_the_profile_field_ids(); ?>" />
			<input type="hidden" name="current_group_id" id="current_group_id" value="<?php echo $group_ids[$step_num]['id']; ?>" />
			<?php wp_nonce_field( 'bp_xprofile_edit' ); ?>

		</form>
	
<?php endwhile; endif; ?>
</div> <!-- #bprp-profile-group -->
</div> <!-- #buddypress -->
<?php

/**
 * Fires after the display of member profile edit content.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_profile_edit_content' );