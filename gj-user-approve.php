<?php
/*
Plugin Name: GJ User Approve
Plugin URI: https://github.com/GunnJerkens/gj-user-approve
Description: Flags WordPress users into pending status when registering to be then approved/denied by an admin.
Version: 0.1
Author: Gunn|Jerkens
Author URI: http://gunnjerkens.com
*/


add_filter('manage_users_columns', 'add_column');
function add_column($columns) {
  $columns['approval_status'] = 'User Status';
  return $columns;
}
 
add_action('manage_users_custom_column', 'get_column_content', 10, 3);
function get_column_content($value, $column_name, $user_id) {
  $user = get_userdata( $user_id );
  if ( 'approval_status' == $column_name )
    $value = get_user_meta($user_id, 'approval_status', true);
    return $value;
}

if(current_user_can('edit_users')) {
  add_action( 'show_user_profile', 'extra_user_profile_fields' );
  add_action( 'edit_user_profile', 'extra_user_profile_fields' );
}

function extra_user_profile_fields($user) {
  $status = get_user_meta($user->ID, 'approval_status', true);
  var_dump($status);
  ?>

<h3>User Administration Options</h3>

<table class="form-table">
<tr>
<th><label for="Approval Status"><?php _e("Approval Status"); ?></label></th>
<td>
<select name="approval_status">
<option value="Approved" <?php if($status==='Approved') echo 'selected'; ?>>Approved</option>
<option value="Pending" <?php if($status==='Pending') echo 'selected'; ?>>Pending</option>
<option value="Denied" <?php if($status==='Denied') echo 'selected'; ?>>Denied</option>
</select>
</td>
</tr>
</table>

<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {

if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }

  update_user_meta( $user_id, 'approval_status', $_POST['approval_status'] );

}