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

add_action('admin_menu', 'add_essence_mailform_thanks'); 
function add_essence_mailform_thanks(){
  add_meta_box('essence_mailform_thanks', 'サンクステキスト', 'insert_essence_mailform_thanks', 'es_mailform', 'normal', 'low');
}

 
function insert_essence_mailform_thanks(){
    wp_nonce_field(wp_create_nonce(__FILE__), 'essence_mailform_thanks_nonce');
  
    global $mailform_fields;

    $id = get_the_ID();
    $_mailform_thanks = get_post_meta($id, 'essence_mailform_thanks', true);
  
    // =================================
    // サンクステキスト
    $content   = !empty( $_mailform_thanks['thanks'] )   ? $_mailform_thanks['thanks']  : '' ;
    $settings = array();
    wp_editor( $content, 'essence_mailform_thanks_editor', array( 'media_buttons'=>false, 'textarea_name'=>'essence_mailform_thanks[thanks]' ) );
  
  
    $mailform_fields = get_post_meta($id, 'essence_mailform');
    if( !empty($mailform_fields[0]) ){
      echo '<div class="mail_form_essence_tag">利用できるパラメーター：　';
      foreach( $mailform_fields[0] as $key => $value ){
        if( !empty($value['name']) )
        echo '<span style="margin:0 10px;">%%'.$value['name'].'%%</span>';
      }
      echo '</div>';
    }
  
  
  
    // =================================
    // サンクステキスト
    $_mailform_return   = !empty( $_mailform_thanks['return'] )   ? $_mailform_thanks['return']  : '' ;
    echo '
    <hr>
    <h1>返信メール</h1>
    <textarea rows="10" class="reguler-text" name="essence_mailform_thanks[return]" style="width:100%;">'.$_mailform_return.'</textarea>';
    if( !empty($mailform_fields[0]) ){
      echo '<div class="mail_form_essence_tag">利用できるパラメーター：　';
      foreach( $mailform_fields[0] as $key => $value ){
        if( !empty($value['name']) )
        echo '<span style="margin:0 10px;">%%'.$value['name'].'%%</span>';
      }
      echo '</div>';
      
      
      echo '
      <hr>
      <script type="text/javascript"><!--
      jQuery(document).ready(function($){
          $(\'.selectAll\')
              .focus(function(){
                  $(this).select();
              })
              .click(function(){
                  $(this).select();
                  return false;
              });
      });
      //--></script>
      <div>
        <h1>サンプルテキスト</h1>
<textarea id="mailform_sample_text" rows="4" class="reguler-text selectAll" style="width:100%;" readonly>
ありがとうございます。
ご入力いただいた内容は以下の通りです。

| ご入力内容 |─────────────────
';
foreach( $mailform_fields[0] as $key => $value ){
if( !empty($value['name']) )
echo $value['name'].'：　%%'.$value['name'].'%%'.PHP_EOL;
}
echo '
─────────────────────────────

'. get_bloginfo('name') .'
'. get_bloginfo('description') .'

URL / '. get_bloginfo('url') .'
mail/ '. get_bloginfo('admin_email') .'

</textarea>
</div>';
    }
  
//============================================
//chart 
require( MAILFORM_ESSENCE_PLUGIN_PATH . '/module/print_chart.php');

}




add_action('save_post', 'save_essence_mailform_thanks');
function save_essence_mailform_thanks($post_id){
	$essence_mailform_thanks_nonce = isset($_POST['essence_mailform_thanks_nonce']) ? $_POST['essence_mailform_thanks_nonce'] : null;
	if(!wp_verify_nonce($essence_mailform_thanks_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
	$data = $_POST['essence_mailform_thanks'];
 
	if(get_post_meta($post_id, 'essence_mailform_thanks') == ""){
		add_post_meta($post_id, 'essence_mailform_thanks', $data, true);
	}elseif($data != get_post_meta($post_id, 'essence_mailform_thanks', true)){
		update_post_meta($post_id, 'essence_mailform_thanks', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'essence_mailform_thanks', get_post_meta($post_id, 'essence_mailform_thanks', true));
	}
}


