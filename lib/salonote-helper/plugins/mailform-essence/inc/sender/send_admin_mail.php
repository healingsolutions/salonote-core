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

global $form_id;
global $insert_id;
global $post;
global $send_fields;
global $_essence_mailform;
global $_essence_mailform_setting;
global $attachments;

//echo '<pre>send_fields'; print_r($send_fields); echo '</pre>';


//管理者メール
$_admin_mail = !empty( $_essence_mailform_setting['admin_mail'] )   ? $_essence_mailform_setting['admin_mail']    : get_option( 'admin_email' ) ;

//お客様お名前フィールド
$_name_field   = !empty( $_essence_mailform_setting['name_field'] )   ? 'es_mail_'.$_essence_mailform_setting['name_field']  : null ;
$_send_name    = !empty( $send_fields[$_name_field]) ? $send_fields[$_name_field] : null ;

//お客様メールフィールド
$_email_field   = !empty( $_essence_mailform_setting['email_field'] )   ? 'es_mail_'.$_essence_mailform_setting['email_field']  : null ;
$_send_email    = !empty( $send_fields[$_email_field]) ? $send_fields[$_email_field] : null ;


if( !empty($_admin_mail) ){
  //emailフィールドがない場合は送信されません

  //確認メール
  $return_text = '以下のメールを受け付けました。'.PHP_EOL.'ありがとうございます。'.PHP_EOL;
	
  foreach( $send_fields as $field_label => $field_item ){

		$_field = str_replace('es_mail_', '', $field_label);
		if( $_fields[$_field]['type'] === 'file' ) continue;
		
		
		//break cookie
		if( $_fields[$_field]['type'] === 'param' ){
			setcookie($_field, '', time() - 3600);
		}

		if( is_array($field_item) ){
			$sub_field_text = '';
			foreach( $field_item as $sub_label => $sub_field_item ){
				if( !empty($sub_field_item) ){
					$sub_field_text .= $sub_label.':'.$sub_field_item. PHP_EOL;
				}
			}
			$field_item = $sub_field_text;
		}
		
		$return_text .= $_fields[$_field]['name'].' : '.$field_item.PHP_EOL;
	}
	
	
	//echo $return_text;


  $to      = $_admin_mail;
  $subject = get_bloginfo('name') .' '. get_the_title($form_id) .' メールを受け付けました。ありがとうございます';
  $message = strip_tags($return_text);
  $headers = 'From: '.( $_send_name ? $_send_name.'様' : get_bloginfo('name')).' <'.$_send_email.'>' . "\r\n";

  if( !empty($attachments) ){
    //add_filter( 'wp_mail_content_type', 'set_html_content_type' );
    foreach( $attachments as $asset ){
      //$message .= '<img src="'.$asset.'">' . PHP_EOL;
    }
  }
  
	if( !empty($attachments) ){
		wp_mail( $to, $subject, esc_attr($message), $headers,$attachments);
	}else{
		wp_mail( $to, $subject, esc_attr($message), $headers);
	}
  
	
  //echo '管理者に確認メールを送信しました';

}

?>