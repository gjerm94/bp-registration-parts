<?php
    $this->redirect_after_submit( $group_ids, $step_num );
?>
<div id="buddypress">
<div id="bprp-profile-group-nav-wrap">
<?php $this->display_progress_bar($group_ids, $step_num); ?>

    <div id="bprp-profile-group">	
	<h2><?php printf( __( 'Step %s: %s', 'bp-registration-parts' ), $step_num + 1, $group_ids[$step_num]['name']); ?></h2>

<form action="" method="post" id="members-directory-form" class="dir-form">
<div id="members-dir-list" class="members dir-list">

<?php 
  // Use this filter to customize the member loop
  // TODO: Add easier way to customize this
  $args = apply_filters('bprp_friend_suggestions_args', '');

  if ( bp_has_members( bp_ajax_querystring( 'members' ). '&exclude=' . get_current_user_id() . '&include=' . $args) ) : 
 ?>
 
  <div id="pag-top" class="pagination">
 
    <div class="pag-count" id="member-dir-count-top">
 
      <?php bp_members_pagination_count(); ?>
 
   </div>
 
   <div class="pagination-links" id="member-dir-pag-top">
 
      <?php bp_members_pagination_links(); ?>
 
   </div>
 
  </div>
 
  <?php do_action( 'bp_before_directory_members_list' ); ?>
 
  <ul id="members-list" class="item-list" role="main">
 
  <?php while ( bp_members() ) : bp_the_member(); ?>
 
    <li>
      <div class="item-avatar">
         <a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar( 'type=full&height=150&width=150' ); ?></a>
      </div>
 
      <div class="item">
        <div class="item-title">
           <a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
 
       </div>
 
       <div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>
 
       <?php do_action( 'bp_directory_members_item' ); ?>
 
      <?php
       /***
        * If you want to show specific profile fields here you can,
        * but it'll add an extra query for each member in the loop
        * (only one regardless of the number of fields you show):
        *
        * bp_member_profile_data( 'field=the field name' );
       */
       ?>
       </div>
 
       <div class="action">
 
           <?php do_action( 'bp_directory_members_actions' ); ?>
 
      </div>
 
      <div class="clear"></div>
   </li>
 
 <?php endwhile; ?>
 
 </ul>
 
 <?php do_action( 'bp_after_directory_members_list' ); ?>
 
 <?php bp_member_hidden_fields(); ?>
 
 <div id="pag-bottom" class="pagination">
 
    <div class="pag-count" id="member-dir-count-bottom">
 
       <?php bp_members_pagination_count(); ?>
 
    </div>
 
    <div class="pagination-links" id="member-dir-pag-bottom">
 
      <?php bp_members_pagination_links(); ?>
 
    </div>
 
  </div>
 
<?php else: ?>
 
   <div id="message" class="info">
      <p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
   </div>
 
<?php endif; ?>
</div>
</form>
<form action="" method="post" id="profile-edit-form" class="standard-form">
<div class ="submit">
	<?php $this->display_prev_next_buttons($group_ids, $step_num); ?>
</div>
</form>
</div> <!-- #bprp-profile-group-nav-wrap --> 
</div> 

</div> <!-- #buddypress -->

