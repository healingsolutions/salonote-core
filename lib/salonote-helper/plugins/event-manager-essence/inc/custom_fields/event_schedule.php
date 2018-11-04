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
if( empty($event_opt['event_join']) ){
	return ;
}

//add meta box
add_action('admin_menu', 'add_essence_event_timetable_value');
function add_essence_event_timetable_value(){
    
	$event_opt = get_option('event_manager_essence_options');
	$event_opt['post_type']	= isset($event_opt['post_type'])? $event_opt['post_type']: null;
	if( !empty($event_opt['post_type']) ){
		foreach( $event_opt['post_type'] as $post_type ){
			add_meta_box('essence_event_timetable_value', 'スケジュール', 'insert_essence_event_timetable_value', $post_type, 'normal', 'high');
		}
	}
}


//insert form
function insert_essence_event_timetable_value(){
	 global $post;
	 wp_nonce_field(wp_create_nonce(__FILE__), 'essence_event_timetable_nonce');
  
	
	$event_timetable_labels = get_post_meta($post->ID, 'essence_event_timetable_label',true);
	$event_timetable_fields = get_post_meta($post->ID, 'essence_event_timetable_value',true);
	$event_timetable_reserve_limit 	= get_post_meta($post->ID, 'essence_event_timetable_reserve_limit',true);
	
	if(is_user_logged_in()){
	//echo '<pre>event_timetable_reserve_limit'; print_r($event_timetable_reserve_limit); echo '</pre>';
}
	
	$event_opt = get_option('event_manager_essence_options');
	$event_opt_schedule = !empty($event_opt['event_timetable']) ? $event_opt['event_timetable']: null;
	$event_timetable_labels = !empty($event_timetable_labels) ? $event_timetable_labels: $event_opt_schedule;
	
	
	$event_timetable_limit = !empty($event_opt['event_timetable_limit']) ? $event_opt['event_timetable_limit']: 0;

  if(is_user_logged_in()){
    //echo '<pre>event_timetable_labels'; print_r($event_timetable_labels); echo '</pre>';
		//echo '<pre>event_timetable_fields'; print_r($event_timetable_fields); echo '</pre>';
  }

	$event_field_arr = [];
	$event_field_arr['date'] = array('日にち','date');
	$event_field_arr['place'] = array('場所','text');
	$event_field_arr['memo'] = array('メモ','text');
	$event_field_arr[] = array('','sepalater');
	$schedule_labels_arr = explode(",", $event_timetable_labels);
	foreach($schedule_labels_arr as $key => $value){
		$event_field_arr[] = array($value,'number');
	}

	//echo '<pre>event_field_arr'; print_r($event_field_arr); echo '</pre>';


	echo '
	<table class="form-table">
	<tr>
	<th><label for="essence_event_labels">タイムテーブル</label></th>
	<td><input name="essence_event_timetable_label" type="text" value="'.$event_timetable_labels.'" class="regular-text"/></td>
	</tr>

	<tr>
	<th><label for="essence_event_timetable_reserve_limit">一人のユーザーが予約可能な予約件数</label></th>
	<td><input name="essence_event_timetable_reserve_limit" type="number" min="0" value="'.$event_timetable_reserve_limit.'" class="small-text"/></td>
	</tr>
	</table>';
  
	
	//===================================
	
  $repeat_field = '
  <div class="doraggable-fields">
  <div id="event_timetable_form___name__"><span class="event_manager_number">__name__label__</span>
  ';
	
	
	foreach( $event_field_arr as $key => $value ){
		
		$repeat_field .= '<div class="event_manager_form_item item-type-'.$value[1].' item-'.$key.'">';
		$repeat_field .= '<label for="event_timetable_form___name___">'.$value[0].'</label>';

		
		switch ($value[1]) {
			case 'text':
				$repeat_field .= '
				<input type="'.$value[1].'" id="event_timetable_form___name__" name="essence_event_timetable_value[__name__]['.$key.']" />';
			break;
				
			case 'number':
				$repeat_field .= '
				<input type="'.$value[1].'" id="event_timetable_form___name__" name="essence_event_timetable_value[__name__]['.$key.']" value="'.$event_timetable_limit.'" />';
			break;
				
			case 'date':
				$repeat_field .= '
				<input type="'.$value[1].'" id="event_timetable_form___name__" name="essence_event_timetable_value[__name__]['.$key.']" value="'.date('Y-m-d').'" />';
			break;
				
			case 'sepalater':
				$repeat_field .= '
				<hr class="sepalater">';
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
  <div id="event_timetable_form" data-prototype="'.$repeat_field.'" class="sfPrototypeMan ui-sortable">';

	
	if( empty($event_timetable_fields) ){
		$event_timetable_fields = [];
		$event_timetable_fields[] = '';
	}

	foreach( $event_timetable_fields as $key => $items ){
		
		

		echo '
		<div class="doraggable-fields">
			<div id="event_timetable_form_'.$key.'"><span class="event_manager_number">'.$key.'</span>';
		
		foreach( $event_field_arr as $field_key => $field_value ){
			
			
			
			switch ($field_value[1]) {

			case 'sepalater':
				echo '<hr class="sepalater">';
			break;
			
			case 'number':
				$item_value = !empty($items[$field_key]) ? $items[$field_key] : '0' ;
				echo '<div class="event_manager_form_item item-type-'.$field_value[1].' item-'.$field_key.'">';
				echo '<label for="event_timetable_form_'.$key.'">'.$field_value[0].'</label>';
				echo '<input type="'.$field_value[1].'" id="event_timetable_form_'.$key.'" name="essence_event_timetable_value['.$key.']['.$field_key.']"  value="'.esc_html($item_value).'">';
				echo '</div>';
			break;
			
			default:
				$item_value = !empty($items[$field_key]) ? $items[$field_key] : '' ;
				echo '<div class="event_manager_form_item item-type-'.$field_value[1].' item-'.$field_key.'">';
				echo '<label for="event_timetable_form_'.$key.'">'.$field_value[0].'</label>';
				echo '<input type="'.$field_value[1].'" id="event_timetable_form_'.$key.'" name="essence_event_timetable_value['.$key.']['.$field_key.']"  value="'.esc_html($item_value).'">';
				echo '</div>';
			break;
					
			}
			
			
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
			<td><textarea class="large-text" name="event_timetable_import" rows="4"><?php //echo $event_timetable_import; ?></textarea></td>
		</tr>
	</table>
*/
	?>

	
	
	<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery().sfPrototypeMan({
			rmButtonText: "<div class=\"event_timetable_remove_btn\"></div>",
			addButtonText: "<div class=\"event_timetable_add_btn\"></div>"
		});
		jQuery("#event_timetable_form").sortable({
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
add_action('save_post', 'save_essence_event_timetable_value');
function save_essence_event_timetable_value($post_id){
	$essence_event_timetable_nonce = isset($_POST['essence_event_timetable_nonce']) ? $_POST['essence_event_timetable_nonce'] : null;
  
	if(!wp_verify_nonce($essence_event_timetable_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }
  
	if(!current_user_can('edit_post', $post_id)) {
    return $post_id;
  }
	
	
	/*
	if( !empty($_POST['event_timetable_import']) ){
		
		$menu_import_fields = [];
		$menu_import_result = [];
		
		$event_timetable_arr = explode("\n", $_POST['event_timetable_import']); // とりあえず行に分割
		foreach( $event_timetable_arr as $key => $value ){
			if( empty($value)) continue;
			$item_arr = explode("\t", $value); // とりあえず行に分割
			$menu_import_fields[] = array_map('trim', $item_arr); // 各行にtrim()をかける
		}

		$event_timetable_fields = [];
		foreach($event_field_label as $key => $value){
			$event_timetable_fields = $key;
		}


		foreach( $menu_import_fields as $key => $value ){
			$menu_import_result[] = array_combine($event_timetable_fields, $value);
			
		}
		update_post_meta($post_id, 'essence_event_timetable_value', $menu_import_result);
		
	}
	*/
	
 
	$_label = $_POST['essence_event_timetable_label'];
 
	if(get_post_meta($post_id, 'essence_event_timetable_label') == "" ){
		add_post_meta($post_id, 'essence_event_timetable_label', $_label, true);
    
	}elseif($_label != get_post_meta($post_id, 'essence_event_timetable_label', true)){
		update_post_meta($post_id, 'essence_event_timetable_label', $_label);
    
	}elseif($_label == ""){
		delete_post_meta($post_id, 'essence_event_timetable_label', get_post_meta($post_id, 'essence_event_timetable_label', true));
	}
	
	$_value = $_POST['essence_event_timetable_value'];
	
	if(get_post_meta($post_id, 'essence_event_timetable_value') == "" ){
		add_post_meta($post_id, 'essence_event_timetable_value', $_value, true);
    
	}elseif($_value != get_post_meta($post_id, 'essence_event_timetable_value', true)){
		update_post_meta($post_id, 'essence_event_timetable_value', $_value);
    
	}elseif($_value == ""){
		delete_post_meta($post_id, 'essence_event_timetable_value', get_post_meta($post_id, 'essence_event_timetable_value', true));
	}
	
	
	$_limit = $_POST['essence_event_timetable_reserve_limit'];
	
	if(get_post_meta($post_id, 'essence_event_timetable_reserve_limit') == "" ){
		add_post_meta($post_id, 'essence_event_timetable_reserve_limit', $_limit, true);
    
	}elseif($_limit != get_post_meta($post_id, 'essence_event_timetable_reserve_limit', true)){
		update_post_meta($post_id, 'essence_event_timetable_reserve_limit', $_limit);
    
	}elseif($_limit == ""){
		delete_post_meta($post_id, 'essence_event_timetable_reserve_limit', get_post_meta($post_id, 'essence_event_timetable_reserve_limit', true));
	}
}


?>
