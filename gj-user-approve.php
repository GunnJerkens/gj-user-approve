<?php
/*
Plugin Name: GJ User Approve
Plugin URI: https://github.com/GunnJerkens/gj-user-approve
Description: Flags WordPress users into pending status when registering to be then approved/denied by an admin.
Version: 0.1
Author: Gunn|Jerkens
Author URI: http://gunnjerkens.com
*/

require_once('gj-user-approve-profile.php');
require_once('gj-user-approve-update.php');
require_once('gj-user-approve-global.php');

add_action('admin_menu', 'gj_admin_actions');

function gj_admin_actions() {
  add_users_page( "users.php", "GJ User Approve", 'administrator', "gj_user_approve", "gj_admin_options" );
}

function gj_admin_options() {
  include ('admin/gj-user-approve-options.php');
}
