<?php

if (get_option('disable_toolbar')) {
  show_admin_bar(false);
}

if (get_option('disable_dashboard')) {

  add_action('admin_init', 'disableDashboard');

  function disableDashboard() {
    if (!current_user_can('manage_options') && $_SERVER['DOING_AJAX'] != '/wp-admin/admin-ajax.php') {
      wp_redirect(home_url()); exit;
    }
  }

}
