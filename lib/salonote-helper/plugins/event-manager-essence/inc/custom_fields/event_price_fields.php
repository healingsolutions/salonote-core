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
add_action('admin_menu', 'add_essence_event_price');
function add_essence_event_price(){
	$event_opt = get_option('event_manager_essence_options');
	$event_opt['post_type']	= isset($event_opt['post_type'])? $event_opt['post_type']: null;
	if( !empty($event_opt['post_type']) ){
		foreach( $event_opt['post_type'] as $post_type ){
			add_meta_box('essence_event_price', '必要経費', 'insert_essence_event_price', $post_type, 'normal', 'high');
		}
	}
}


//insert form
function insert_essence_event_price(){
	 global $post;
	 wp_nonce_field(wp_create_nonce(__FILE__), 'essence_event_price_nonce');
  
  $event_price_fields = get_post_meta($post->ID, 'essence_event_price',true);
	$event_price_essence_opt = get_option('event_price_essence_options');
	$opt['fields'] = !empty($event_price_essence_opt['fields']) ? $event_price_essence_opt['fields'] : null ;

	
	
  if(is_user_logged_in()){
    //echo '<pre>event_price_fields'; print_r($event_price_fields); echo '</pre>';
		//echo '<pre>event_price_fields'; print_r($opt['fields']); echo '</pre>';
  }

	$event_field_arr = [];
  $event_field_arr = array(
		'price_name'		=> array('項目名','text'),
		'price_number'	=> array('単価','number'),
		'price_times'		=> array('個数','number'),
		'price_memo'		=> array('メモ','text'),
	);


  
  $repeat_field = '
  <div class="doraggable-fields">
  <div id="event_price_form___name__"><span class="event_manager_number">__name__label__</span>
  ';
	
	
	foreach( $event_field_arr as $key => $value ){
		
		$repeat_field .= '<div class="event_manager_form_item item-type-'.$value[1].' '.$key.'-item">';
		$repeat_field .= '<label for="event_price_form___name___">'.$value[0].'</label>';

		
		switch ($value[1]) {
			case 'text':
			case 'number':
				$repeat_field .= '
				<input type="'.$value[1].'" id="event_price_form___name__" name="essence_event_price[__name__]['.$key.']" />';
			break;
				
			case 'textarea':
				$repeat_field .= '
				<textarea id="event_price_form___name__" name="essence_event_price[__name__]['.$key.']" rows="1"></textarea>';
			break;
				
			case 'checkbox':
					
					if( !empty($value[2]) ){
						$select_arr = explode("\n", $value[2]); // とりあえず行に分割
						$select_arr = array_map('trim', $select_arr); // 各行にtrim()をかける
						$select_arr = array_filter($select_arr, 'strlen'); // 文字数が0の行を取り除く
						$select_arr = array_values($select_arr); // これはキーを連番に振りなおしてるだけ

						foreach($select_arr as $select_key => $select){
							if(strpos($select,':') !== false){
								$select_value = explode(":", $select); // とりあえず行に分割
							}else{
								$select_value = array($select,$select);
							}
							$repeat_field .= '<input type="checkbox" id="event_price_form_'.$key.'" name="essence_event_price[__name__]['.$key.'][]" value="'.$select_value[0].'"/>'.$select_value[1];
						}
					}else{
						$repeat_field .= '<p>選択肢が設定されていません</p>';	
					}

				break;
				
			case 'select':
				
				if( !empty($value[2]) ){
					
					$select_arr = explode("\n", $value[2]); // とりあえず行に分割
					$select_arr = array_map('trim', $select_arr); // 各行にtrim()をかける
					$select_arr = array_filter($select_arr, 'strlen'); // 文字数が0の行を取り除く
					$select_arr = array_values($select_arr); // これはキーを連番に振りなおしてるだけ
					

					
				$repeat_field .= '
				<select id="event_price_form___name__" name="essence_event_price[__name__]['.$key.']">';
				
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
				<a id="event_price_form___name__" type="button" class="button event_price_image_upload" title="画像を追加・変更">アイテム画像の追加・削除</a>
				画像ID:<input type="text" readonly id="event_price_form___name__" name="essence_event_price[__name__]['.$key.']" />
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
  <div id="event_price_form" data-prototype="'.$repeat_field.'" class="sfPrototypeMan ui-sortable">';

	
	if( empty($event_price_fields) ){
		$event_price_fields = [];
		foreach($event_field_arr as $key => $value){
			$event_price_fields[0][$key] = '';
		}
	}

	foreach( $event_price_fields as $key => $items ){

		echo '
		<div class="doraggable-fields">
			<div id="event_price_form_'.$key.'"><span class="event_manager_number">'.$key.'</span>';
		
		foreach( $event_field_arr as $field_key => $field_value ){
			
			echo '<div class="event_manager_form_item item-type-'.$field_value[1].' '.$field_key.'-item"">';
			echo '<label for="event_price_form_'.$key.'">'.$field_value[0].'</label>';
		
			switch ($field_value[1]) {
				case 'text':
				case 'number':
					
					if( $field_key == 'price_times' ){
						$items[$field_key] = !empty($items[$field_key]) ? $items[$field_key] : 1 ;
					}
					
					echo '
					<input type="'.$field_value[1].'" id="event_price_form_'.$key.'" name="essence_event_price['.$key.']['.$field_key.']"  value="'.esc_html($items[$field_key]).'">';
				break;

				case 'textarea':
					echo '
					<textarea id="event_price_form_'.$key.'" name="essence_event_price['.$key.']['.$field_key.']" rows="1">'.esc_html($items[$field_key]).'</textarea>';
				break;

				case 'checkbox':
					
					if( !empty($field_value[2]) ){
						$select_arr = explode("\n", $field_value[2]); // とりあえず行に分割
						$select_arr = array_map('trim', $select_arr); // 各行にtrim()をかける
						$select_arr = array_filter($select_arr, 'strlen'); // 文字数が0の行を取り除く
						$select_arr = array_values($select_arr); // これはキーを連番に振りなおしてるだけ

						foreach($select_arr as $select_key => $select){
							if(strpos($select,':') !== false){
								$select_value = explode(":", $select); // とりあえず行に分割
							}else{
								$select_value = array($select,$select);
							}
							echo '<input type="checkbox" id="event_price_form_'.$key.'" name="essence_event_price['.$key.']['.$field_key.'][]" value="'.$select_value[0].'"';
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
						$select_arr = explode("\n", $field_value[2]); // とりあえず行に分割
						$select_arr = array_map('trim', $select_arr); // 各行にtrim()をかける
						$select_arr = array_filter($select_arr, 'strlen'); // 文字数が0の行を取り除く
						$select_arr = array_values($select_arr); // これはキーを連番に振りなおしてるだけ

						echo '<select id="event_price_form_'.$key.'" name="essence_event_price['.$key.']['.$field_key.']">';
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
					<a id="event_price_form_'.$key.'" type="button" class="button event_price_image_upload" title="画像を追加・変更">アイテム画像の追加・削除</a>
					<input type="hidden" name="essence_event_price['.$key.'][menu_assets]" value="'.$items[$field_key].'" />
					';

					if( !empty($items[$field_key]) ){
						echo '
						<p class="event_price_img" id=img_'.$items[$field_key].'>
						<a href="#" class="event_price_image_remove" title="画像を削除する"></a>
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
			<td><textarea class="large-text" name="event_price_import" rows="4"><?php //echo $event_price_import; ?></textarea></td>
		</tr>
	</table>
*/
	?>

	
	
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery().sfPrototypeMan({
			rmButtonText: "<div class=\"event_price_remove_btn\"></div>",
			addButtonText: "<div class=\"event_price_add_btn\"></div>"
		});
		jQuery("#event_price_form").sortable({
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
add_action('save_post', 'save_essence_event_price');
function save_essence_event_price($post_id){
	$essence_event_price_nonce = isset($_POST['essence_event_price_nonce']) ? $_POST['essence_event_price_nonce'] : null;
  
	if(!wp_verify_nonce($essence_event_price_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }
  
	if(!current_user_can('edit_post', $post_id)) {
    return $post_id;
  }
	
	
	/*
	if( !empty($_POST['event_price_import']) ){
		
		$menu_import_fields = [];
		$menu_import_result = [];
		
		$event_price_arr = explode("\n", $_POST['event_price_import']); // とりあえず行に分割
		foreach( $event_price_arr as $key => $value ){
			if( empty($value)) continue;
			$item_arr = explode("\t", $value); // とりあえず行に分割
			$menu_import_fields[] = array_map('trim', $item_arr); // 各行にtrim()をかける
		}

		$event_price_fields = [];
		foreach($event_field_label as $key => $value){
			$event_price_fields = $key;
		}


		foreach( $menu_import_fields as $key => $value ){
			$menu_import_result[] = array_combine($event_price_fields, $value);
			
		}
		update_post_meta($post_id, 'essence_event_price', $menu_import_result);
		
	}
	*/
	
 
	$data = $_POST['essence_event_price'];
 
	if(get_post_meta($post_id, 'essence_event_price') == ""){
		add_post_meta($post_id, 'essence_event_price', $data, true);
    
	}elseif($data != get_post_meta($post_id, 'essence_event_price', true)){
		update_post_meta($post_id, 'essence_event_price', $data);
    
	}elseif($data == ""){
		delete_post_meta($post_id, 'essence_event_price', get_post_meta($post_id, 'essence_event_price', true));
	}
}


?>
