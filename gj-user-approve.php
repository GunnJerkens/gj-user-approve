<?php
/*
Plugin Name: GJ User Approve
Plugin URI: https://github.com/GunnJerkens/gj-user-approve
Description: Flags WordPress users into pending status when registering to be then approved/denied by an admin.
Version: 0.1
Author: Gunn|Jerkens
Author URI: http://gunnjerkens.com
*/

function gj_admin_options() {
  include ('admin/gj-user-approve-options.php');
}
function gj_admin_actions() {
  add_users_page( "users.php", "GJ User Approve", 'administrator', "gj_user_approve", "gj_admin_options" );
}
add_action('admin_menu', 'gj_admin_actions');


class adminApproval {

  function __construct() {

    add_filter('manage_users_columns', array(&$this, 'add_column'));
    add_action('manage_users_custom_column', array(&$this, 'get_column_content'), 10, 3);
    add_filter('manage_users_sortable_columns', array(&$this, 'sort_column_content'));
    add_action('show_user_profile', array(&$this, 'admin_fields'));
    add_action('edit_user_profile', array(&$this, 'admin_fields'));
  }

  function add_column($columns) {
    $columns['approval_status'] = 'User Status';
    return $columns;
  }

  function get_column_content($value, $column_name, $user_id) {
    $user = get_userdata( $user_id );
    if ( 'approval_status' == $column_name )
      $value = get_user_meta($user_id, 'approval_status', true);
      return $value;
  }

  function sort_column_content($columns) {
    $columns['approval_status'] = 'approval_status';
      return $columns;
  }

  function admin_fields($user) {
    $status = get_user_meta($user->ID, 'approval_status', true);

    $approved = '';
    $pending = '';
    $denied = '';

    if($status === 'Approved') {
      $approved = 'selected';
    } else if ($status === 'Pending') {
      $pending = 'selected';
    } else if ($status === 'Denied' ) {
      $denied = 'selected';
    }
    echo '
      <h3>GJ User Approve Options</h3>
      <table class="form-table">
        <tr>
          <th><label for="Approval Status">Approval Status</label></th>
          <td>
            <select name="approval_status">
              <option value="Approved" '.$approved.'>Approved</option>
              <option value="Pending" '.$pending.'>Pending</option>
              <option value="Denied" '.$denied.'>Denied</option>
            </select>
          </td>
        </tr>
      </table>
    ';
  }



}
new adminApproval();


add_action( 'personal_options_update', 'save_admin_fields' );
add_action( 'edit_user_profile_update', 'save_admin_fields' );

function save_admin_fields( $user_id ) {
  if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
  update_user_meta( $user_id, 'approval_status', $_POST['approval_status'] );
}
