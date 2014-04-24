<?php

if(isset($_POST['gj_hidden']) && $_POST['gj_hidden'] == 'gj_form_update_options') {

  $mg_key = $_POST['mg_key'];
  update_option('mg_key', $mg_key);

  $mg_domain = $_POST['mg_domain'];
  update_option('mg_domain', $mg_domain);

  $mg_from = $_POST['mg_from'];
  update_option('mg_from', $mg_from);

  $mg_subject = $_POST['mg_subject'];
  update_option('mg_subject', $mg_subject);

  $mg_text = $_POST['mg_text'];
  update_option('mg_text', $mg_text);

  $mg_html = $_POST['mg_html'];
  update_option('mg_html', $mg_text); ?>

  <div class="updated"><p><strong>Options saved.</strong></p></div><?php

} else {

  $mg_key = get_option('mg_key');
  $mg_domain = get_option('mg_domain');
  $mg_from = get_option('mg_from');
  $mg_subject = get_option('mg_subject');
  $mg_text = get_option('mg_text');
  $mg_html = get_option('mg_html');

} ?>

  <form name="gj_form_update_options" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="gj_hidden" value="gj_form_update_options">
    <p>API Key:<input type="text" name="mg_key" class="mg-key" value="<?php echo $mg_key; ?>"/></p>
    <p>Domain:<input type="text" name="mg_domain" class="mg-domain" value="<?php echo $mg_domain; ?>"/></p>
    <p>From:<input type="text" name="mg_from" class="mg-from" value="<?php echo $mg_from; ?>"/></p>
    <p>Subject:<input type="text" name="mg_subject" class="mg-subject" value="<?php echo $mg_subject; ?>"/></p>
    <p>Text Email:<input type="text" name="mg_text" class="mg-text" value="<?php echo stripslashes($mg_text); ?>"/></p>
    <p>HTML Email:<input type="text" name="mg_html" class="mg-html" value="<?php echo stripslashes($mg_html); ?>"/></p>
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options', 'gj_trdom' ) ?>" />
    </p>
  </form>