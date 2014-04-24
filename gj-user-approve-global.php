<?php



show_admin_bar(false);

add_action('admin_init', 'disableDashboard');
function disableDashboard() {
  if (!current_user_can('manage_options') && $_SERVER['DOING_AJAX'] != '/wp-admin/admin-ajax.php') {
  wp_redirect(home_url()); exit;
  }
}
