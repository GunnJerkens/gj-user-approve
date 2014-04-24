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

  if (!current_user_can( 'edit_user', $user_id )) { 
    return false;
  }

  update_user_meta( $user_id, 'approval_status', $_POST['approval_status'] );

  $flag = get_user_meta($user_id, 'approval_flag', true);

  if($flag === "" OR $flag === "0") {

    $userdata = get_userdata($user_id);
    sendMailgun($userdata->user_email);

    update_user_meta( $user_id, 'approval_flag', 1 );

  }
}

function sendMailgun($email){

  $config = array();
  $config['api_key'] = get_option('mg_key');
  $config['api_url'] = 'https://api.mailgun.net/v2/'.get_option('mg_domain').'/messages';

  $message = array();
  $message['from'] = get_option('mg_from');
  $message['to'] = $email;
  $message['h:Reply-To'] = get_option('mg_reply');
  $message['subject'] = get_option('mg_subject');
  $message['html'] = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . get_option('mg_html'));
  $message['text'] = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . get_option('mg_text'));

  $curl = curl_init();

  curl_setopt($curl, CURLOPT_URL, $config['api_url']);
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($curl, CURLOPT_USERPWD, "api:{$config['api_key']}");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($curl, CURLOPT_POST, true); 
  curl_setopt($curl, CURLOPT_POSTFIELDS,$message);

  $result = curl_exec($curl);

  curl_close($curl);
  return $result;
}

