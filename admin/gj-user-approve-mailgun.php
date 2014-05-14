<?php

if(isset($_POST['gj_hidden']) && $_POST['gj_hidden'] == 'gj_form_update_options') {

  $mg_key = $_POST['mg_key'];
  update_option('mg_key', $mg_key);

  $mg_domain = $_POST['mg_domain'];
  update_option('mg_domain', $mg_domain);

  $mg_from = $_POST['mg_from'];
  update_option('mg_from', $mg_from);

  $mg_reply = $_POST['mg_reply'];
  update_option('mg_reply', $mg_reply);

  $mg_subject = $_POST['mg_subject'];
  update_option('mg_subject', $mg_subject);

  $mg_text = $_POST['mg_text'];
  update_option('mg_text', $mg_text);

  $mg_html = $_POST['mg_html'];
  update_option('mg_html', $mg_html); ?>

  <div class="updated"><p><strong>Options saved.</strong></p></div><?php

} else {

  $mg_key = get_option('mg_key');
  $mg_domain = get_option('mg_domain');
  $mg_from = get_option('mg_from');
  $mg_reply = get_option('mg_reply');
  $mg_subject = get_option('mg_subject');
  $mg_text = get_option('mg_text');
  $mg_html = get_option('mg_html');

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
        <th><label for="mg_key">API Key</label></th>
        <td><input type="text" name="mg_key" class="mg-key" value="<?php echo $mg_key; ?>"/></td>
      </tr>
      <tr>
        <th><label for="mg_domain">Send From Domain</label></th>
        <td><input type="text" name="mg_domain" class="mg-domain" value="<?php echo $mg_domain; ?>"/></td>
      </tr>
      <tr>
        <th><label for="mg_from">From Address</label></th>
        <td><input type="text" name="mg_from" class="mg-from" value="<?php echo $mg_from; ?>"/></td>
      </tr>
      <tr>
        <th><label for="mg_reply">Reply Address</label></th>
        <td><input type="text" name="mg_reply" class="mg-reply" value="<?php echo $mg_reply; ?>"/></td>
      </tr>
      <tr>
        <th><label for="mg_subject">Email Subject</label></th>
        <td><input type="text" name="mg_subject" class="mg-subject" value="<?php echo $mg_subject; ?>"/></td>
      </tr>
      <tr>
        <th><label for="mg_text">Text Email (/path/to.txt)</label></th>
        <td><input type="text" name="mg_text" class="mg-text" value="<?php echo stripslashes($mg_text); ?>"/></td>
      </tr>
      <tr>
        <th><label for="mg_html">HTML Email (/path/to.html)</label></th>
        <td><input type="text" name="mg_html" class="mg-html" value="<?php echo stripslashes($mg_html); ?>"/></td>
      </tr>
    </table>

    <input class="btn" type="submit" name="Submit" value="Update Options" />

  </form>
