<?php
/*
Description: Staff Fields
Author: Healin Solutions
Version: 0.1
Author URI:http://www.healing-solutions.jp
*/

add_action('add_meta_boxes', 'add_staff_profile');
add_action('save_post', 'save_staff_profile');
 
function add_staff_profile(){
  add_meta_box('staff_profile', __('Page Information','salonote-essence'), 'insert_staff_profile', 'staff', 'normal', 'low');
}
 
function insert_staff_profile(){
     global $post;
     wp_nonce_field(wp_create_nonce(__FILE__), 'staff_profile_nonce');
  
  $staff_profile_value = get_post_meta($post->ID,'staff_profile',true);

  $staff_profile_arr = array(
		'kana_name'			=> __('ふりがな','salonote-essence'),
		'catch_copy'		=> __('キャッチコピー','salonote-essence'),
		'nickname'			=> __('ニックネーム','salonote-essence'),
    'skill'					=> __('得意なスタイル','salonote-essence'),
    'birthday'			=> __('生年月日','salonote-essence'),
		'birthplace'		=> __('出身地','salonote-essence'),
		'blad'					=> __('血液型','salonote-essence'),
    'hobby'					=> __('趣味','salonote-essence'),
		'dream'					=> __('夢','salonote-essence'),
		'goal'					=> __('目標','salonote-essence'),
		'favorit_artist'=> __('好きなアーティスト','salonote-essence'),
		'favorit_words'	=> __('好きな言葉','salonote-essence'),
		'reason'				=> __('美容師になったきっかけ','salonote-essence'),
    'workday'				=> __('出勤','salonote-essence'),
		'comment'				=> __('一言コメント','salonote-essence'),
    'blog'					=> __('ブログ','salonote-essence'),
    'twitter'				=> __('Twitter','salonote-essence'),
		'facebook'			=> __('Facebook','salonote-essence'),
		'instagram'			=> __('Instagram','salonote-essence'),
  );
  
	echo '<table class="form-table">
	<tbody>';

  foreach($staff_profile_arr as $key => $value){
		
		$_field_key = 'staff_'.$key;
		?>
		<tr>
			
			<th><label for="staff_profile_<?php echo $key;?>"><?php echo $value; ?></labe></th>
			
			<?php
			if( $key === 'comment' ){
			?>
			<td><textarea id="staff_profile_<?php echo $key;?>" rows="4" class="regular-text" name="staff_profile[staff_<?php echo $key;?>]"><?php echo !empty($staff_profile_value[$_field_key]) ? $staff_profile_value[$_field_key] : '' ; ?></textarea></td>
				
			<?php
			}else{
				?>
			<td><input id="staff_profile_<?php echo $key;?>" type="text" class="regular-text" name="staff_profile[staff_<?php echo $key;?>]" value="<?php echo !empty($staff_profile_value[$_field_key]) ? $staff_profile_value[$_field_key] : '' ; ?>" /></td>
			
			<?php
			}
			?>
			
			
		</tr>
	
<?php
	}
	
	echo '
	</tbody>
</table>
';
	
}
 
function save_staff_profile($post_id){
	$staff_profile_nonce = isset($_POST['staff_profile_nonce']) ? $_POST['staff_profile_nonce'] : null;
	if(!wp_verify_nonce($staff_profile_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
  if( !empty($_POST['staff_profile']) ){
    $data = $_POST['staff_profile'];
  }else{
    $data = null;
  }
 
	if(get_post_meta($post_id, 'staff_profile') == ""){
		add_post_meta($post_id, 'staff_profile', $data, true);
	}elseif($data != get_post_meta($post_id, 'staff_profile', true)){
		update_post_meta($post_id, 'staff_profile', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'staff_profile', get_post_meta($post_id, 'staff_profile', true));
	}
}


add_action ( 'edit_category_form_fields', 'extra_category_fields');
function extra_category_fields( $tag ) {
    $t_id = $tag->term_id;
    $cat_meta = get_option( "cat_$t_id");
?>
<tr class="form-field">
    <th><label for="extra_text">その他テキスト</label></th>
    <td><input type="text" name="Cat_meta[extra_text]" id="extra_text" size="25" value="<?php if(isset ( $cat_meta['extra_text'])) echo esc_html($cat_meta['extra_text']) ?>" /></td>
</tr>
<tr class="form-field">
    <th><label for="upload_image">画像URL</label></th>
    <td>
        <input id="upload_image" type="text" size="36" name="Cat_meta[img]" value="<?php if(isset ( $cat_meta['img'])) echo esc_html($cat_meta['img']) ?>" /><br />
        画像を追加: <img src="images/media-button-other.gif" alt="画像を追加"  id="upload_image_button" value="Upload Image" style="cursor:pointer;" />
    </td>
</tr>
<?php
}

?>
