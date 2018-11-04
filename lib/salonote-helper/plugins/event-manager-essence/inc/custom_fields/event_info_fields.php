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
if( empty($event_opt['event_info']) ){
	return ;
}

//add meta box
add_action('admin_menu', 'add_essence_event_information');
function add_essence_event_information(){
    //add_meta_box('essence_event_information', 'イベント情報', 'insert_essence_event_information', 'events', 'normal', 'high');
		$event_opt = get_option('event_manager_essence_options');
		$event_opt['post_type']	= isset($event_opt['post_type'])? $event_opt['post_type']: null;
		if( !empty($event_opt['post_type']) ){
			foreach( $event_opt['post_type'] as $post_type ){
				add_meta_box('essence_event_information', 'イベント情報', 'insert_essence_event_information', $post_type, 'normal', 'high');
			}
		}
}


//insert form
function insert_essence_event_information(){
	 global $post;
	 wp_nonce_field(wp_create_nonce(__FILE__), 'essence_event_information_nonce');
  
  $event_fields = get_post_meta($post->ID, 'essence_event_information',true);
	
	$event_information_essence_opt = get_option('event_information_essence_options');
	$opt['fields'] = !empty($event_information_essence_opt['fields']) ? $event_information_essence_opt['fields'] : null ;


	?>

<table class="form-table">
	<tbody>
		<tr>
			
			<th>開始時間</th>
			<td><input type="text" class="reguler-text" name="essence_event_information[event_start]" value="<?php echo !empty($event_fields['event_start']) ? $event_fields['event_start'] : '' ; ?>" /></td>
			
			<th>終了時間</th>
			<td><input type="text" class="reguler-text" name="essence_event_information[event_end]" value="<?php echo !empty($event_fields['event_end']) ? $event_fields['event_end'] : '' ; ?>" /></td>
			
			<th>参加料金</th>
			<td><input type="text" class="reguler-text" name="essence_event_information[event_price]" value="<?php echo !empty($event_fields['event_price']) ? $event_fields['event_price'] : '' ; ?>" /></td>
			
		</tr>
	</tbody>
</table>

<table class="form-table">
	<tbody>
		<tr>
			<th>開催場所</th>
			<td><textarea class="large-text" name="essence_event_information[event_place]"><?php echo !empty($event_fields['event_place']) ? esc_attr($event_fields['event_place']) : '' ; ?></textarea></td>
		</tr>
		<tr>
			<th>GoogleMap</th>
			<td><textarea class="large-text" name="essence_event_information[event_map]"><?php echo !empty($event_fields['event_map']) ? $event_fields['event_map'] : '' ; ?></textarea></td>
		</tr>
		<tr>
			<th>主催者</th>
			<td><textarea class="large-text" name="essence_event_information[event_owner]"><?php echo !empty($event_fields['event_owner']) ? esc_attr($event_fields['event_owner']) : '' ; ?></textarea></td>
		</tr>
		<tr>
			<th>参加方法</th>
			<td><textarea class="large-text" name="essence_event_information[event_join]"><?php echo !empty($event_fields['event_join']) ? esc_attr($event_fields['event_join']) : '' ; ?></textarea></td>
		</tr>
		<tr>
			<th>URL</th>
			<td><input type="text" class="large-text" name="essence_event_information[event_url]" value="<?php echo !empty($event_fields['event_url']) ? $event_fields['event_url'] : '' ; ?>" /></td>
		</tr>
		<tr>
			<th>対象となる人</th>
			<td><textarea class="large-text" rows="8" name="essence_event_information[event_target]"><?php echo !empty($event_fields['event_target']) ? $event_fields['event_target'] : '' ; ?></textarea>
			<p class="hint">対象となる人を改行して箇条書きで記入します</p>
			</td>
		</tr>
		<tr>
			<th>得られるもの</th>
			<td><textarea class="large-text" rows="8" name="essence_event_information[event_gain]"><?php echo !empty($event_fields['event_gain']) ? $event_fields['event_gain'] : '' ; ?></textarea>
			<p class="hint">得られるものを改行して箇条書きで記入します</p>
			</td>
		</tr>
	</tbody>
</table>
		
	<?php
}

//save action
add_action('save_post', 'save_essence_event_information');
function save_essence_event_information($post_id){
	$essence_event_information_nonce = isset($_POST['essence_event_information_nonce']) ? $_POST['essence_event_information_nonce'] : null;
  
	if(!wp_verify_nonce($essence_event_information_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }
  
	if(!current_user_can('edit_post', $post_id)) {
    return $post_id;
  }
	
	$data = $_POST['essence_event_information'];
 
	if(get_post_meta($post_id, 'essence_event_information') == ""){
		add_post_meta($post_id, 'essence_event_information', $data, true);
    
	}elseif($data != get_post_meta($post_id, 'essence_event_information', true)){
		update_post_meta($post_id, 'essence_event_information', $data);
    
	}elseif($data == ""){
		delete_post_meta($post_id, 'essence_event_information', get_post_meta($post_id, 'essence_event_information', true));
	}
}


?>
