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
global $_fields;
global $_essence_mailform;
global $_essence_mailform_setting;
global $attachments;


//echo '<pre>send_fields'; print_r($send_fields); echo '</pre>';

//管理者メール
$_admin_mail     = !empty( $_essence_mailform_setting['admin_mail'] )   ? $_essence_mailform_setting['admin_mail']    : get_option( 'admin_email' ) ;

//お客様メールフィールド
$_email_field   = !empty( $_essence_mailform_setting['email_field'] )   ? 'es_mail_'.$_essence_mailform_setting['email_field']  : null ;
$_send_email    = !empty( $send_fields[$_email_field]) ? $send_fields[$_email_field] : null ;

if( empty($_send_email) ){ return; }; //お客様メールがない場合は、処理を止める

$return_text_arr = get_post_meta($form_id, 'essence_mailform_thanks', true);
$return_text = $return_text_arr['return'];




if( $_email_field ){
  //emailフィールドがない場合は送信されません


  $_send_email = $post_fields[$_email_field];

  if( !empty($_admin_mail) && !empty($_send_email) ){

    $_send_email    = $post_fields[$_email_field];
    
    foreach( $send_fields as $field_label => $field_item ){

			$_field = str_replace('es_mail_', '', $field_label);
			if( $_fields[$_field]['type'] === 'file' ) continue;
			
      if( is_array($field_item) ){
        $sub_field_text = '';
        foreach( $field_item as $sub_label => $sub_field_item ){
          $sub_field_text .= $sub_label.':'.$sub_field_item. PHP_EOL;
        }
        $field_item = $sub_field_text;
      }
      $target = '%%'.$_fields[$_field]['name'].'%%';
      $return_text = str_replace($target, $field_item, $return_text);
    }
	  
	$return_text = preg_replace('/%%(.+?)%%/', '', $return_text);
    
    
    
    //確認メール
    if( empty( $return_text ) ){
      $return_text .= 'ありがとうございました'.PHP_EOL.'確認メールを送信いたします。'.PHP_EOL;
      foreach( $send_fields as $field_label => $field_item ){
        $return_text .= '【'.$_fields[$field_label]['name'].'】 : '.$field_item . PHP_EOL;
      }
      $return_text .= PHP_EOL.get_bloginfo('name').PHP_EOL;
    }
    
    $to      = $_send_email;
    $subject = get_bloginfo('name') .' '. get_the_title($form_id) .' メールを受け付けました。ありがとうございます';
    $message = strip_tags($return_text);
    $headers = 'From: '.get_bloginfo('name').' <'.$_admin_mail.'>' . "\r\n";
    
    if( !empty($attachments) ){
      //add_filter( 'wp_mail_content_type', 'set_html_content_type' );
      
      foreach( $attachments as $asset ){
        //$message .= '<img src="'.$asset.'">' . PHP_EOL;
      }
    }
    
    
    if( !empty($attachments) ){
			wp_mail( $to, $subject, $message, $headers,$attachments);
		}else{
			wp_mail( $to, $subject, $message, $headers);
		}
    //wp_mail( $to, $subject, $message );
    //echo '送信しました';
    
    // トラブルを避ける為にコンテツタイプをリセット -- http://core.trac.wordpress.org/ticket/23578
    //remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
    
    
  }
  
}



?>