<?php

/**
 * BuddyPress - Members Profile Change Avatar
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<?php

if (isset($_POST['profile-group-edit-submit'])) {

	// Save profile fields for the last field group.
	require_once plugin_dir_path(dirname(__FILE__)) . 'templates/edit.php';
	xprofile_screen_edit_profile();
}

$this->redirect_after_submit($group_ids, $step_num);

?>

<?php

/**
 * Fires before the display of profile avatar upload content.
 *
 * @since 1.1.0
 */
do_action('bp_before_profile_avatar_upload_content'); ?>

<div id="buddypress">
	<div id="bprp-profile-group-nav-wrap">

		<?php $this->display_progress_bar($group_ids, $step_num); ?>

		<div id="bprp-profile-group">
			<h2><?php printf(__('Step %s: %s', 'bp-registration-parts'), $step_num + 1, $group_ids[$step_num]['name']); ?></h2>
			<?php if (!(int) bp_get_option('bp-disable-avatar-uploads')) : ?>

				<p><?php _e('Your profile photo will be used on your profile and throughout the site. If there is a <a href="http://gravatar.com">Gravatar</a> associated with your account email we will use that, or you can upload an image from your computer.', 'buddypress'); ?></p>

				<form action="<?php echo $form_action; ?>" method="post" id="avatar-upload-form" class="standard-form" enctype="multipart/form-data">

					<?php if ('upload-image' == bp_get_avatar_admin_step()) : ?>

						<?php wp_nonce_field('bp_avatar_upload'); ?>
						<p><?php _e('Click below to select a JPG, GIF or PNG format photo from your computer and then click \'Upload Image\' to proceed.', 'buddypress'); ?></p>

						<p id="avatar-upload">
							<label for="file" class="bp-screen-reader-text"><?php
																					/* translators: accessibility text */
																					_e('Select an image', 'buddypress');
																					?></label>
							<input type="file" name="file" id="file" />
							<input type="submit" name="upload" id="upload" value="<?php esc_attr_e('Upload Image', 'buddypress'); ?>" />
							<input type="hidden" name="action" id="action" value="bp_avatar_upload" />
						</p>

					<?php endif; ?>

					<?php if ('crop-image' == bp_get_avatar_admin_step()) : ?>

						<h5><?php _e('Crop Your New Profile Photo', 'buddypress'); ?></h5>

						<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-to-crop" class="avatar" alt="<?php esc_attr_e('Profile photo to crop', 'buddypress'); ?>" />

						<div id="avatar-crop-pane">
							<img src="<?php bp_avatar_to_crop(); ?>" id="avatar-crop-preview" class="avatar" alt="<?php esc_attr_e('Profile photo preview', 'buddypress'); ?>" />
						</div>

						<input type="submit" name="avatar-crop-submit" id="avatar-crop-submit" value="<?php esc_attr_e('Crop Image', 'buddypress'); ?>" />

						<input type="hidden" name="image_src" id="image_src" value="<?php bp_avatar_to_crop_src(); ?>" />
						<input type="hidden" id="x" name="x" />
						<input type="hidden" id="y" name="y" />
						<input type="hidden" id="w" name="w" />
						<input type="hidden" id="h" name="h" />

						<?php wp_nonce_field('bp_avatar_cropstore'); ?>

					<?php endif; ?>

				</form>

				<?php
					/**
					 * Load the Avatar UI templates
					 *
					 * @since  2.3.0
					 */
					bp_avatar_get_templates(); ?>

			<?php else : ?>

				<p><?php _e('Your profile photo will be used on your profile and throughout the site. To change your profile photo, please create an account with <a href="https://gravatar.com">Gravatar</a> using the same email address as you used to register with this site.', 'buddypress'); ?></p>

			<?php endif; ?>

			<form action="" method="post" id="profile-edit-form" class="standard-form">
				<div class="submit">
					<?php $this->display_prev_next_buttons($group_ids, $step_num); ?>
				</div>
			</form>
		</div> <!-- #bprp-profile-group -->
	</div> <!-- #buddypress -->
</div> <!-- #bprp-profile-group-nav-wrap -->
<?php

/**
 * Fires after the display of profile avatar upload content.
 *
 * @since 1.1.0
 */
do_action('bp_after_profile_avatar_upload_content');
