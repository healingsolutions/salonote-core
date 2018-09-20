<?php
/*  Copyright 2016 Healing Solutions (email : info@healing-solutions.jp)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

//user create action

global $_essence_mailform_setting;

//初期化
$user_name     = '';
$user_password = '';


if( $_POST['insert_user']) === true ):

if( !empty($_essence_mailform_setting['email_field']) ){
  $user_email_field_name = $_essence_mailform_setting['email_field'];
  
  $user_name  = $mailform_fields[$user_email_field_name];
  $user_email = $mailform_fields[$user_email_field_name];
}


$user_id = username_exists($user_name);
$user_password = trim($user_password);
$email_password = false;
if ( !$user_id && empty($user_password) ) {
	$user_password = wp_generate_password( 12, false );
	$message = __('<strong><em>Note that password</em></strong> carefully! It is a <em>random</em> password that was generated just for you.');
	$user_id = wp_create_user($user_name, $user_password, $user_email);
	update_user_option($user_id, 'default_password_nag', true, true);
	$email_password = true;
} elseif ( ! $user_id ) {
	// Password has been provided
	$message = '<em>'.__('Your chosen password.').'</em>';
	$user_id = wp_create_user($user_name, $user_password, $user_email);
} else {
	$message = __('User already exists. Password inherited.');
}
  
  echo $message;

endif; // if insert_user

?>