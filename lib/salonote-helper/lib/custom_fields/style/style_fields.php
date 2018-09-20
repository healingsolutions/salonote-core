<?php
/*
Description: Style Fields
Author: Healin Solutions
Version: 0.1
Author URI:http://www.healing-solutions.jp
*/

add_action('add_meta_boxes', 'add_style_fields');
add_action('save_post', 'save_style_fields');
 
function add_style_fields(){
  add_meta_box('style_fields', __('Page Information','salonote-essence'), 'insert_style_fields', 'style', 'normal', 'low');
}
 
function insert_style_fields(){
     global $post;
     wp_nonce_field(wp_create_nonce(__FILE__), 'style_fields_nonce');
  
  $style_fields_value = get_post_meta($post->ID,'style_fields',true);

  $style_fields_arr = array(
		'length'				=> __('長さ','salonote-essence'),
    'image'					=> __('イメージ','salonote-essence'),
		'color'					=> __('カラー','salonote-essence'),
    'perma'					=> __('パーマ','salonote-essence'),
		'comment'				=> __('ポイント','salonote-essence'),

  );
  
	echo '<table class="form-table">
	<tbody>';


  foreach($style_fields_arr as $key => $value){
		
		$_field_key = 'style_'.$key;
		?>
		<tr>
			
			<th><label for="style_fields_<?php echo $key;?>"><?php echo $value; ?></labe></th>
			<td><input id="style_fields_<?php echo $key;?>" type="text" class="regular-text" name="style_fields[style_<?php echo $key;?>]" value="<?php echo !empty($style_fields_value[$_field_key]) ? $style_fields_value[$_field_key] : '' ; ?>" /></td>
			
		</tr>
	
<?php
	}
	
	echo '
	</tbody>
</table>
';
	
}
 
function save_style_fields($post_id){
	$style_fields_nonce = isset($_POST['style_fields_nonce']) ? $_POST['style_fields_nonce'] : null;
	if(!wp_verify_nonce($style_fields_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
  if( !empty($_POST['style_fields']) ){
    $data = $_POST['style_fields'];
  }else{
    $data = null;
  }
 
	if(get_post_meta($post_id, 'style_fields') == ""){
		add_post_meta($post_id, 'style_fields', $data, true);
	}elseif($data != get_post_meta($post_id, 'style_fields', true)){
		update_post_meta($post_id, 'style_fields', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'style_fields', get_post_meta($post_id, 'style_fields', true));
	}
}


?>
