<?php


if(isset($_POST['gj_hidden']) && $_POST['gj_hidden'] == 'gj_form_update_options') {

  $disable_dashboard = isset($_POST['disable_dashboard']);
  update_option('disable_dashboard', $disable_dashboard);

  $disable_toolbar = isset($_POST['disable_toolbar']);
  update_option('disable_toolbar', $disable_toolbar); ?>

  <div class="updated"><p><strong>Options saved.</strong></p></div><?php

} else {

  $disable_dashboard = get_option('disable_dashboard');
  $disable_toolbar = get_option('disable_toolbar');

} ?>

  <style>
    input {
      min-width: 300px;
    }
    input.btn {
      width: auto;
      margin-top: 15px;
    }
  </style>

  <form name="gj_form_update_options" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="gj_hidden" value="gj_form_update_options">
    <table class="form-table">
      <tr>
        <th><label for="disable_dashboard">Disable Dashboard</label></th>
        <td><input type="checkbox" name="disable_dashboard" <?php if ($disable_dashboard) echo 'checked'; ?>></td>
      </tr>
      <tr>
        <th><label for="disable_toolbar">Disable Toolbar</label></th>
        <td><input type="checkbox" name="disable_toolbar" <?php if ($disable_toolbar) echo 'checked'; ?>></td>
      </tr>
    </table>

    <input class="btn" type="submit" name="Submit" value="Update Options" />

  </form>
