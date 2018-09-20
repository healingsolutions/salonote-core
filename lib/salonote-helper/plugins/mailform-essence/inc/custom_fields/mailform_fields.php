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

add_action('admin_menu', 'add_essence_mailform_setting'); 
function add_essence_mailform_setting(){
  add_meta_box('essence_mailform_setting', 'メールフォーム設定', 'insert_essence_mailform_setting', 'es_mailform', 'normal', 'low');
}

 
function insert_essence_mailform_setting(){
	global $post;
	
    wp_nonce_field(wp_create_nonce(__FILE__), 'essence_mailform_setting_nonce');

    $id = get_the_ID();
    $_mailform_setting = get_post_meta($id, 'essence_mailform_setting', true);
		$mailform_fields = get_post_meta($post->ID, 'essence_mailform',true);
	
    if(is_user_logged_in()){
      //echo '<pre>mailform_fields'; print_r($mailform_fields); echo '</pre>';
    }
  
    echo '
    <script>
      jQuery(function($) {
      var dateFormat = \'yy-mm-dd\';
        $("#datepicker_start").datepicker({
            dateFormat: dateFormat
        });
        $("#datepicker_end").datepicker({
            dateFormat: dateFormat
        });
      });
    </script>
    ';
    
    $_admin_mail    = !empty( $_mailform_setting['admin_mail'] )    ? $_mailform_setting['admin_mail'] 	: get_option( 'admin_email' ) ;
    $_isert_user    = !empty( $_mailform_setting['insert_user'] )   ? ' checked="checked"'             	: '' ;
    $_print_confirm = !empty( $_mailform_setting['print_confirm'] ) ? ' checked="checked"'             	: '' ;
    $_send_confirm  = !empty( $_mailform_setting['send_confirm'] )  ? ' checked="checked"'             	: '' ;
		$_name_field   	= !empty( $_mailform_setting['name_field'] )   	? $_mailform_setting['name_field']	: '' ;
    $_email_field   = !empty( $_mailform_setting['email_field'] )   ? $_mailform_setting['email_field']	: '' ;
    $_start_date    = !empty( $_mailform_setting['start_date'] )    ? $_mailform_setting['start_date'] 	: '' ;
    $_end_date      = !empty( $_mailform_setting['end_date'] )      ? $_mailform_setting['end_date']   	: '' ;
    $_count_down    = !empty( $_mailform_setting['count_down'] )    ? ' checked="checked"'             	: '' ;
    $_print_result  = !empty( $_mailform_setting['print_result'] )  ? ' checked="checked"'             	: '' ;
    $_request_limit = !empty( $_mailform_setting['request_limit'] ) ? $_mailform_setting['request_limit']: null ;
  
    echo '<table class="table table-striped table-bordered"><tbody>';
    echo '<tr><th>管理者メールアドレス</th><td><input type="mail" name="essence_mailform_setting[admin_mail]" value="'. $_admin_mail .'">';
    
    if( empty($_admin_mail) ){
      echo '<p class="attention">空欄の場合は、システムのメールアドレス【'.get_option( 'admin_email' ).'】が使用されます</p>';
    }
  
    echo '</td>';
    echo '<tr><th>設定</th>
          <td>
          <p><input type="checkbox" name="essence_mailform_setting[insert_user]" value="1"'. $_isert_user .'>ユーザー登録をする</p>
          <!-- <p><input type="checkbox" name="essence_mailform_setting[print_confirm]" value="1"'. $_print_confirm .'>確認画面を表示する</p> -->
          <p><input type="checkbox" name="essence_mailform_setting[send_confirm]" value="1"'. $_send_confirm .'>送信完了メールを送る</p>
          <p><input type="checkbox" name="essence_mailform_setting[print_result]" value="1"'. $_print_result .'>選択肢の結果を完了画面に公開する</p>
          ';
  
    if( !empty( $_mailform_setting['insert_user'] ) && empty( $_email_field ) ){
      echo '<p class="attention">お客様のメールアドレスフィールドが登録されていないため、ユーザー登録できません</p>';
    }
    if( !empty( $_mailform_setting['send_confirm'] ) && empty( $_email_field ) ){
      echo '<p class="attention">お客様のメールアドレスフィールドが登録されていないため、確認メールを送信できません</p>';
    }
  
    if( !empty( $_mailform_setting['insert_user'] ) && empty( $_email_field ) ){
      echo '<p class="attention">お客様のメールアドレスフィールドが登録されていないため、ユーザー登録できません</p>';
    }
  
    if( !empty( $_mailform_setting['send_confirm'] ) ){
      $_admin_mail_host = strpos($_admin_mail, "@");
      $_admin_mail_host = substr($_admin_mail, $_admin_mail_host + 1);
      if( strpos($_admin_mail_host,$_SERVER['SERVER_NAME']) === false){
        echo '<p class="attention">管理者メールにドメインが含まれていないので、迷惑メール扱いになる可能性があります。</p>';
      }
    }
      
  
    echo '</td>';
	
		echo '<tr><th>お客様のお名前フィールド</th><td>';
	
		if( empty($mailform_fields) ){
			echo 'フィールド保存後に選択が可能となります';
		}else{
			echo '<select name="essence_mailform_setting[name_field]">';
				foreach( $mailform_fields as $key => $value){
					if( !empty($value['field']) && $value['type'] !== 'text' ) continue;
					
					echo '<option value="'. $value['field'] .'"';
					if( !empty($value['field']) && $_name_field === $value['field'] ) echo ' selected';
					echo '>'. $value['name'];
				}
			echo '</select>';
		}
	
    echo '<tr><th>お客様のメールアドレスフィールド</th><td>';
	
		if( empty($mailform_fields) ){
			echo 'フィールド保存後に選択が可能となります';
		}else{
			echo '<select name="essence_mailform_setting[email_field]">';
				foreach( $mailform_fields as $key => $value){
					if( !empty($value['field']) && $value['type'] !== 'email' ) continue;
					
					echo '<option value="'. $value['field'] .'"';
					if( !empty($value['field']) && $_email_field === $value['field'] ) echo ' selected';
					echo '>'. $value['name'];
				}
			echo '</select>';
		}
		echo '</td>';
	
	
    echo '<tr><th>公開期限</th><td>
      <input id="datepicker_start" type="text" name="essence_mailform_setting[start_date]" value="'. $_start_date .'"> 〜
      <input id="datepicker_end" type="text" name="essence_mailform_setting[end_date]" value="'. $_end_date .'">
      
      <input type="checkbox" name="essence_mailform_setting[count_down]" value="1"'. $_count_down .'>カウントダウンを表示
    </td>';
  
    echo '<tr><th>受付上限</th><td>
      <input id="datepicker_start" type="number" name="essence_mailform_setting[request_limit]" value="'. $_request_limit .'">
    </td>';

    echo '</tbody></table>';
    
}




add_action('save_post', 'save_essence_mailform_setting');
function save_essence_mailform_setting($post_id){
	$essence_mailform_setting_nonce = isset($_POST['essence_mailform_setting_nonce']) ? $_POST['essence_mailform_setting_nonce'] : null;
	if(!wp_verify_nonce($essence_mailform_setting_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
	$data = $_POST['essence_mailform_setting'];
 
	if(get_post_meta($post_id, 'essence_mailform_setting') == ""){
		add_post_meta($post_id, 'essence_mailform_setting', $data, true);
	}elseif($data != get_post_meta($post_id, 'essence_mailform_setting', true)){
		update_post_meta($post_id, 'essence_mailform_setting', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'essence_mailform_setting', get_post_meta($post_id, 'essence_mailform_setting', true));
	}
}


