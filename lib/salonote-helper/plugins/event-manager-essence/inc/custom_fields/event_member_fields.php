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

$event_opt = get_option('event_manager_essence_options');
if( empty($event_opt['manage_member']) ){
	return ;
}

//add meta box
add_action('admin_menu', 'add_essence_event_manager');
function add_essence_event_manager(){
    
		$event_opt = get_option('event_manager_essence_options');
		$event_opt['post_type']	= isset($event_opt['post_type'])? $event_opt['post_type']: null;
		if( !empty($event_opt['post_type']) ){
			foreach( $event_opt['post_type'] as $post_type ){
				add_meta_box('essence_event_manager', '参加者', 'insert_essence_event_manager', $post_type, 'normal', 'high');
			}
		}
}


//insert form
function insert_essence_event_manager(){
	 global $post;
	 wp_nonce_field(wp_create_nonce(__FILE__), 'essence_event_manager_nonce');
  
  $event_manager_fields = get_post_meta($post->ID, 'essence_event_manager',true);
	$event_manager_essence_opt = get_option('event_manager_essence_options');
	$opt['fields'] = !empty($event_manager_essence_opt['fields']) ? $event_manager_essence_opt['fields'] : null ;

	
	
  if(is_user_logged_in()){
    //echo '<pre>event_manager_fields'; print_r($event_manager_fields); echo '</pre>';
		//echo '<pre>event_manager_fields'; print_r($opt['fields']); echo '</pre>';
  }

	$event_field_arr = [];
  $event_field_arr = array(
    'member_paid'		 => array('支払済','select','支払済'),
		'member_name'			=> array('お名前','text'),
		'member_price'		=> array('料金','number'),
    'member_return'	  => array('還元報酬','number'),
		'member_label'		=> array('肩書き','text'),
		'member_memo'		  => array('メモ','textarea'),
		'member_tag'		  => array('タグ','select','未就学児
お子様
ゲスト
ノーカウント
功労者
ショート滞在
'),
    
    
	);


  
  $repeat_field = '
  <div class="doraggable-fields">
  <div id="event_manager_form___name__"><span class="event_manager_number">__name__label__</span>
  ';
	
	
	foreach( $event_field_arr as $key => $value ){
		
		$repeat_field .= '<div class="event_manager_form_item item-type-'.$value[1].' '.$key.'-item">';
		$repeat_field .= '<label for="event_manager_form___name___">'.$value[0].'</label>';

		
		switch ($value[1]) {
			case 'text':
			case 'number':
				$repeat_field .= '
				<input type="'.$value[1].'" id="event_manager_form___name__" name="essence_event_manager[__name__]['.$key.']" />';
			break;
				
			case 'textarea':
				$repeat_field .= '
				<textarea id="event_manager_form___name__" name="essence_event_manager[__name__]['.$key.']" rows="1"></textarea>';
			break;
				
			case 'checkbox':
					
					if( !empty($value[2]) ){
						$select_arr = br2array($value[2]);

						foreach($select_arr as $select_key => $select){
							if(strpos($select,':') !== false){
								$select_value = explode(":", $select); // とりあえず行に分割
							}else{
								$select_value = array($select,$select);
							}
							$repeat_field .= '<input type="checkbox" id="event_manager_form_'.$key.'" name="essence_event_manager[__name__]['.$key.'][]" value="'.$select_value[0].'"/>'.$select_value[1];
						}
					}else{
						$repeat_field .= '<p>選択肢が設定されていません</p>';	
					}

				break;
				
			case 'select':
				
				if( !empty($value[2]) ){
					$select_arr = br2array($value[2]);

					
				$repeat_field .= '
				<select id="event_manager_form___name__" name="essence_event_manager[__name__]['.$key.']">';
				$repeat_field .= '<option value="">---</option>';
				foreach($select_arr as $select_key => $select){
					if(strpos($select,':') !== false){
						$select_value = explode(":", $select); // とりあえず行に分割
					}else{
						$select_value = array($select,$select);
					}
					$repeat_field .= '<option value="'.$select_value[0].'">'.$select_value[1].'</option>';
				}
				
				$repeat_field .= '</select>';
				}
			break;
				
			case 'upload':
				$repeat_field .= '
				<a id="event_manager_form___name__" type="button" class="button event_manager_image_upload" title="画像を追加・変更">アイテム画像の追加・削除</a>
				画像ID:<input type="text" readonly id="event_manager_form___name__" name="essence_event_manager[__name__]['.$key.']" />
				';
			break;
		}
		
		$repeat_field .= '</div>';
		
	}
	

  $repeat_field .= '  
  </div>
  </div>';
  
  $repeat_field = htmlspecialchars($repeat_field);
  
  
  echo '
	<div>
  <div id="event_manager_form" data-prototype="'.$repeat_field.'" class="sfPrototypeMan ui-sortable">';

	
	if( empty($event_manager_fields) ){
		$event_manager_fields = [];
		foreach($event_field_arr as $key => $value){
			$event_manager_fields[0][$key] = '';
		}
	}

	foreach( $event_manager_fields as $key => $items ){

		echo '
		<div class="doraggable-fields">
			<div id="event_manager_form_'.$key.'"><span class="event_manager_number">'.$key.'</span>';
		
		foreach( $event_field_arr as $field_key => $field_value ){
			
			echo '<div class="event_manager_form_item item-type-'.$field_value[1].' '.$field_key.'-item"">';
			echo '<label for="event_manager_form_'.$key.'">'.$field_value[0].'</label>';
		
			switch ($field_value[1]) {
				case 'text':
				case 'number':
					echo '
					<input type="'.$field_value[1].'" id="event_manager_form_'.$key.'" name="essence_event_manager['.$key.']['.$field_key.']"  value="'.esc_html($items[$field_key]).'">';
				break;

				case 'textarea':
					echo '
					<textarea id="event_manager_form_'.$key.'" name="essence_event_manager['.$key.']['.$field_key.']" rows="1">'.esc_html($items[$field_key]).'</textarea>';
				break;

				case 'checkbox':
					
					if( !empty($field_value[2]) ){
						$select_arr = br2array($field_value[2]);

						foreach($select_arr as $select_key => $select){
							if(strpos($select,':') !== false){
								$select_value = explode(":", $select); // とりあえず行に分割
							}else{
								$select_value = array($select,$select);
							}
							echo '<input type="checkbox" id="event_manager_form_'.$key.'" name="essence_event_manager['.$key.']['.$field_key.'][]" value="'.$select_value[0].'"';
							if( !empty($items[$field_key]) && $items[$field_key] == $select_value[0]){
								echo ' checked';
							}
							echo ' />'.$select_value[1];
						}
					}else{
						echo '<p>選択肢が設定されていません</p>';	
					}

				break;
					
				case 'select':

					if( !empty($field_value[2]) ){
						$select_arr = br2array($field_value[2]);

						echo '<select id="event_manager_form_'.$key.'" name="essence_event_manager['.$key.']['.$field_key.']">';
						echo '<option value="">---</option>';
						foreach($select_arr as $select_key => $select){
							if(strpos($select,':') !== false){
								$select_value = explode(":", $select); // とりあえず行に分割
							}else{
								$select_value = array($select,$select);
							}
							echo '<option value="'.$select_value[0].'"';
							if( !empty($items[$field_key]) && $items[$field_key] == $select_value[0] ){
								echo ' selected';
							}
							echo '>'.$select_value[1].'</option>';
						}
						echo '</select>';
					}else{
						echo '<p>選択肢が設定されていません</p>';	
					}
				break;
					
				case 'upload':
					echo '
					<a id="event_manager_form_'.$key.'" type="button" class="button event_manager_image_upload" title="画像を追加・変更">アイテム画像の追加・削除</a>
					<input type="hidden" name="essence_event_manager['.$key.'][menu_assets]" value="'.$items[$field_key].'" />
					';

					if( !empty($items[$field_key]) ){
						echo '
						<p class="event_manager_img" id=img_'.$items[$field_key].'>
						<a href="#" class="event_manager_image_remove" title="画像を削除する"></a>
						<img src="'.wp_get_attachment_thumb_url($items[$field_key]).'" />
						</p>';
					}

				break;
			}
			
			echo '</div>';
		}
		
			

		echo'
			</div>
		</div>
		';
	}
        
                
  echo '
      </div>
  </div>
  ';
	?>
	
	<?php
	/*
	<table class="form-table">
		<tr>
			<th>インポート</th>
			<td><textarea class="large-text" name="event_manager_import" rows="4"><?php //echo $event_manager_import; ?></textarea></td>
		</tr>
	</table>
*/
	?>

	
	
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery().sfPrototypeMan({
			rmButtonText: "<div class=\"event_manager_remove_btn\"></div>",
			addButtonText: "<div class=\"event_manager_add_btn\"></div>"
		});
		jQuery("#event_manager_form").sortable({
			axis: 'y',
			opacity: 0.5,
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
add_action('save_post', 'save_essence_event_manager');
function save_essence_event_manager($post_id){
	$essence_event_manager_nonce = isset($_POST['essence_event_manager_nonce']) ? $_POST['essence_event_manager_nonce'] : null;
  
	if(!wp_verify_nonce($essence_event_manager_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }
  
	if(!current_user_can('edit_post', $post_id)) {
    return $post_id;
  }
	
	
	/*
	if( !empty($_POST['event_manager_import']) ){
		
		$menu_import_fields = [];
		$menu_import_result = [];
		
		$event_manager_arr = explode("\n", $_POST['event_manager_import']); // とりあえず行に分割
		foreach( $event_manager_arr as $key => $value ){
			if( empty($value)) continue;
			$item_arr = explode("\t", $value); // とりあえず行に分割
			$menu_import_fields[] = array_map('trim', $item_arr); // 各行にtrim()をかける
		}

		$event_manager_fields = [];
		foreach($event_field_label as $key => $value){
			$event_manager_fields = $key;
		}


		foreach( $menu_import_fields as $key => $value ){
			$menu_import_result[] = array_combine($event_manager_fields, $value);
			
		}
		update_post_meta($post_id, 'essence_event_manager', $menu_import_result);
		
	}
	*/
	
 
	$data = $_POST['essence_event_manager'];
 
	if(get_post_meta($post_id, 'essence_event_manager') == ""){
		add_post_meta($post_id, 'essence_event_manager', $data, true);
    
	}elseif($data != get_post_meta($post_id, 'essence_event_manager', true)){
		update_post_meta($post_id, 'essence_event_manager', $data);
    
	}elseif($data == ""){
		delete_post_meta($post_id, 'essence_event_manager', get_post_meta($post_id, 'essence_event_manager', true));
	}
}


?>
