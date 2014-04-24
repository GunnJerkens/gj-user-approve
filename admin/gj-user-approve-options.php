<?php
/*
* Options page for gj-user-approve.
*/

if ('gj-user-approve-options.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
  die();
}



$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'gj_user_approve_mailgun';

?>

<h2 class="nav-tab-wrapper">
  <a href="?page=gj_user_approve&tab=gj_user_approve_mailgun" class="nav-tab <?php echo $active_tab == 'gj_user_approve_mailgun' ? 'nav-tab-active' : ''; ?>">Mailgun</a>
  <a href="?page=gj_user_approve&tab=gj_user_approve_settings" class="nav-tab <?php echo $active_tab == 'gj_user_approve_settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
</h2>

<div class="wrap"><?php

  if( $active_tab == 'gj_user_approve_mailgun' ) {
    if (file_exists(__DIR__. '/gj-user-approve-mailgun.php')) {
      include_once(__DIR__. '/gj-user-approve-mailgun.php');
    }
    else {
      echo 'Mailgun tab is missing';  
    }
  }

  if( $active_tab == 'gj_user_approve_other' ) {
    if (file_exists(__DIR__. '/gj-user-approve-settings.php')) {
      include_once(__DIR__. '/gj-user-approve-settings.php');
    }
    else {
      echo 'File is missing';  
    }
  } ?>

</div>
