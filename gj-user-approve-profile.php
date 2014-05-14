<?php

class gjuaProfile {

  function __construct() {

    add_filter('manage_users_columns', array(&$this, 'gj_user_approve_add_column'));
    add_action('manage_users_custom_column', array(&$this, 'gj_user_approve_get_column_content'), 10, 3);
    add_filter('manage_users_sortable_columns', array(&$this, 'gj_user_approve_sort_column_content'));
    add_action('show_user_profile', array(&$this, 'gj_user_approve_admin_fields'));
    add_action('edit_user_profile', array(&$this, 'gj_user_approve_admin_fields'));

  }

  function gj_user_approve_add_column($columns) {
    $columns['approval_status'] = 'User Status';
    return $columns;
  }

  function gj_user_approve_get_column_content($value, $column_name, $user_id) {
    $user = get_userdata( $user_id );
    if ( 'approval_status' == $column_name )
      $value = get_user_meta($user_id, 'approval_status', true);
      return $value;
  }

  function gj_user_approve_sort_column_content($columns) {
    $columns['approval_status'] = 'approval_status';
      return $columns;
  }

  function gj_user_approve_admin_fields($user) {

    $status = get_user_meta($user->ID, 'approval_status', true);

    $userStates = array("Approved", "Pending", "Denied"); ?>

    <h3>GJ User Approve Options</h3>
    <table class="form-table">
      <tr>
        <th><label for="Approval Status">Approval Status</label></th>
        <td>
          <select name="approval_status"><?php
            foreach($userStates as $state) {

              echo '<option value="'.$state.'" '.($status === $state ? 'selected="selected"': '').'>'.$state.'</option>';

            } ?>
          </select>
        </td>
      </tr>
    </table><?php

  }

}
new gjuaProfile();
