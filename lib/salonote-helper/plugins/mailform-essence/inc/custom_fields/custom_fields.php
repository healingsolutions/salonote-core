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

//add meta box
add_action('admin_menu', 'add_essence_mailform');
function add_essence_mailform(){
    add_meta_box('essence_mailform', 'お問い合わせフォーム', 'insert_essence_mailform', 'es_mailform', 'normal', 'high');
}


//insert form
function insert_essence_mailform(){
     global $post;
     wp_nonce_field(wp_create_nonce(__FILE__), 'essence_mailform_nonce');
  
  $mailform_fields = get_post_meta($post->ID, 'essence_mailform');
  if(is_user_logged_in()){
    //echo '<pre>'; print_r($mailform_fields); echo '</pre>';
  }

  
  
  
  $repeat_field = '

  <div class="doraggable-fields">
  <div id="essence_mailform___name__">
  
  <div>
  <label for="essence_mailform___name___name">ラベル</label>
  <input type="text" id="essence_mailform___name___name" name="essence_mailform[__name__][name]" />
	
	<label for="essence_mailform___name___required">field</label>
  <input type="text" name="essence_mailform[__name__][field]" id="essence_mailform___name___field" value="field___name__">
  
  <label for="essence_mailform___name___type">形式</label>
  <select name="essence_mailform[__name__][type]" id="essence_mailform__name__type">
    <option value="text">１行テキスト</option>
    <option value="textarea">テキストエリア</option>
    <option value="checkbox">チェックボックス</option>
    <option value="select">セレクトボックス</option>
    <option value="radio">ラジオボタン</option>
    <option value="email">メールアドレス</option>
    <option value="zip">郵便番号</option>
    <option value="tel">電話番号</option>
    <option value="file">画像</option>
		<option value="date">日付</option>
		<option value="pagetitle">ページタイトル</option>
		<option value="param">パラメーター</option>
    <option value="hr">区切り線</option>
  </select>
	
	
  
  <label for="essence_mailform___name___required">必須</label>
  <input type="checkbox" name="essence_mailform[__name__][required]" id="essence_mailform___name___required" value="1">
  
  <label for="essence_mailform___name___memo">メモ</label>
  <textarea row="2" name="essence_mailform[__name__][memo]" id="essence_mailform___name___memo"></textarea>
  
  <div class="select_fields essence_mailform___name___fields" style="display:none;">
    <label for="essence_mailform___name___fields">選択肢</label>
    <textarea name="essence_mailform[__name__][fields]" id="essence_mailform___name___fields"></textarea>
  </div>
  
  </div>
  </div>
  </div>';
  
  $repeat_field = htmlspecialchars($repeat_field);
  
  
  echo '

<link rel="stylesheet" href="'.MAILFORM_ESSENCE_PLUGIN_URI.'/statics/css/mailform-essence.css" type="text/css" media="all" />
<script type="text/javascript" src="'.MAILFORM_ESSENCE_PLUGIN_URI.'/statics/js/jquery.sfprototypeman.js"></script>

 

<div>
    <div id="socials" data-prototype="'.$repeat_field.'" class="sfPrototypeMan ui-sortable">';

  
if( empty($mailform_fields[0]) ){
  $mailform_fields = array(
    array(
      array(
          'name' => '',
          'type' => '',
      )
    )
  );
}
if(is_user_logged_in()){
	//echo '<pre>'; print_r($mailform_fields); echo '</pre>';
}
  
  

  
  
foreach( $mailform_fields[0] as $key => $value ){
  if( (!empty($value['name']) || !empty($value['fields'])) || (!empty($value['type']) && $value['type'] == 'hr')){
    
    $_name      = !empty( $value['name'] )     ? $value['name']     : '' ;
		$_field    	= !empty( $value['field'] )   ? $value['field']   : '' ;
    $_fields    = !empty( $value['fields'] )   ? $value['fields']   : '' ;
    $_type      = !empty( $value['type'] )     ? $value['type']     : '' ;
    $_memo      = !empty( $value['memo'] )     ? $value['memo']     : '' ;

    
  echo '
  
    <script type="text/javascript">
    jQuery(function($){
      $(\'#essence_mailform_'.$key.' select[name="essence_mailform['.$key.'][type]"]\').change(function() {
        if ($(\'select[name="essence_mailform['.$key.'][type]"] option:selected\').val() == \'select\') $(\'.essence_mailform_'.$key.'_fields\').css(\'display\',\'inline-block\');
        else if ($(\'select[name="essence_mailform['.$key.'][type]"] option:selected\').val() == \'radio\') $(\'.essence_mailform_'.$key.'_fields\').css(\'display\',\'inline-block\');
        else if ($(\'select[name="essence_mailform['.$key.'][type]"] option:selected\').val() == \'checkbox\') $(\'.essence_mailform_'.$key.'_fields\').css(\'display\',\'inline-block\');
        else $(\'.essence_mailform_'.$key.'_fields\').css(\'display\',\'none\');
      });

    });
    </script>
  
  
    <div class="doraggable-fields">
          <div id="essence_mailform_'.$key.'">
          
              <label for="essence_mailform_'.$key.'_name">ラベル</label>
              <input type="text" name="essence_mailform['.$key.'][name]" id="essence_mailform_'.$key.'_name" value="'.esc_html($_name).'">
							
							<label for="essence_mailform___name___required">field</label>
							<input type="text" name="essence_mailform['.$key.'][field]" id="essence_mailform_'.$key.'_field" value="'.($_field ? esc_html($_field) : 'field_'.$key ).'">
              
              <label for="essence_mailform_'.$key.'_type">形式</label>
              <select name="essence_mailform['.$key.'][type]" id="essence_mailform_'.$key.'_type">
                <option value="text"'. (($_type == 'text') ? ' selected' : '' ) .'>１行テキスト</option>
                <option value="textarea"'. (($_type == 'textarea') ? ' selected' : '' ) .'>テキストエリア</option>
                <option value="checkbox"'. (($_type == 'checkbox') ? ' selected' : '' ) .'>チェックボックス</option>
                <option value="select"'. (($_type == 'select') ? ' selected' : '' ) .'>セレクトボックス</option>
                <option value="radio"'. (($_type == 'radio') ? ' selected' : '' ) .'>ラジオボタン</option>
                <option value="email"'. (($_type == 'email') ? ' selected' : '' ) .'>メールアドレス</option>
                <option value="zip"'. (($_type == 'zip') ? ' selected' : '' ) .'>郵便番号</option>
                <option value="tel"'. (($_type == 'tel') ? ' selected' : '' ) .'>電話番号</option>
                <option value="file"'. (($_type == 'file') ? ' selected' : '' ) .'>画像</option>
								<option value="file"'. (($_type == 'date') ? ' selected' : '' ) .'>日付</option>
								<option value="pagetitle"'. (($_type == 'pagetitle') ? ' selected' : '' ) .'>ページタイトル</option>
								<option value="param"'. (($_type == 'param') ? ' selected' : '' ) .'>パラメーター</option>
                
                <option value="hr"'. (($_type == 'hr') ? ' selected' : '' ) .'>区切り線</option>
              </select>
							
							
              
              <label for="essence_mailform_'.$key.'_required">必須</label>
              <input type="checkbox" name="essence_mailform['.$key.'][required]" id="essence_mailform_'.$key.'_required" value="1" '. (!empty($value['required']) ? 'checked' : '' ) .'>
              
              <label for="essence_mailform_'.$key.'_memo">メモ</label>
              <textarea name="essence_mailform['.$key.'][memo]" id="essence_mailform_'.$key.'_memo">'.esc_html($_memo).'</textarea>
              
              <div class="select_fields essence_mailform_'.$key.'_fields field_type-'.esc_html($_type).'" style="display:none;">
                <label for="essence_mailform_'.$key.'_fields">選択肢</label>
                <textarea name="essence_mailform['.$key.'][fields]" id="essence_mailform_'.$key.'_fields">'.esc_html($_fields).'</textarea>
              </div>';
    
        if( $_type == 'zip' ){
          echo '<p class="hint" style="display:block;">次のフィールドに住所を自動入力します。自動的に入れない場合は区切り線を入れてください</p>';
        }

        echo '
          </div>
        </div>
    ';
    }
}
        
                
  echo '
      </div>
  </div>
  ';
	
	
	 ?>

<script type="text/javascript">
jQuery(document).ready(function() {
  jQuery().sfPrototypeMan({
    rmButtonText: "<div class=\"mailessence_remove_btn\"></div>",
    addButtonText: "<div class=\"mailessence_add_btn\"></div>"
  });
  jQuery("#socials").sortable({
			axis: 'y',
			opacity: 0.5,
		});
});
</script>

<?php
	
}



//save action
add_action('save_post', 'save_essence_mailform');
function save_essence_mailform($post_id){
	$essence_mailform_nonce = isset($_POST['essence_mailform_nonce']) ? $_POST['essence_mailform_nonce'] : null;
  
	if(!wp_verify_nonce($essence_mailform_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }
  
	if(!current_user_can('edit_post', $post_id)) {
    return $post_id;
  }
 
	$data = $_POST['essence_mailform'];
 
	if(get_post_meta($post_id, 'essence_mailform') == ""){
		add_post_meta($post_id, 'essence_mailform', $data, true);
    
	}elseif($data != get_post_meta($post_id, 'essence_mailform', true)){
		update_post_meta($post_id, 'essence_mailform', $data);
    
	}elseif($data == ""){
		delete_post_meta($post_id, 'essence_mailform', get_post_meta($post_id, 'essence_mailform', true));
	}
}


?>
