<?php

class gjuaUpdate {

  function __construct() {

    add_action('personal_options_update', array(&$this, 'gj_user_approve_save_admin_fields'));
    add_action('edit_user_profile_update', array(&$this, 'gj_user_approve_save_admin_fields'));

  }

  function gj_user_approve_save_admin_fields($user_id) {

    if (!current_user_can( 'edit_user', $user_id )) { 
      return false;
    }

    $status = $_POST['approval_status'];
    update_user_meta($user_id, 'approval_status', $status);
    $flag = get_user_meta($user_id, 'approval_flag', true);

    if($status === 'Approved' && $flag === "" || $flag === "0" ) {

      $userdata = get_userdata($user_id);
      $this->sendMailgun($userdata->user_email);
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

}
new gjuaUpdate();
