<?php
/*
Plugin Name: Page subTitle Custom Field
Plugin URI: http://www.healing-solutions.jp
Description: ページにサブタイトルフィールドを追加
Author: Healin Solutions
Version: 0.1
Author URI:http://www.healing-solutions.jp
*/

add_action('admin_menu', 'add_subTitle');
add_action('save_post', 'save_subTitle');
 
function add_subTitle(){
     
    $theme_opt['post_type'] = get_option('essence_post_type');
	
		$args = array(
			'public'   => true,
			'_builtin' => false
		);
		$post_types = get_post_types( $args, 'names' );
		array_unshift($post_types, "page");
		array_unshift($post_types, "post");
		array_unshift($post_types, "front_page");
	
    foreach ( $post_types as $post_type_name ) {
			
			$post_type_set  = !empty($theme_opt['post_type'][$post_type_name]) ? $theme_opt['post_type'][$post_type_name] : null ;

			if( !empty($post_type_set) && in_array('display_entry_sub_title',$post_type_set) ){
					add_meta_box('subTitle', 'サブタイトル', 'insert_subTitle', $post_type_name, 'normal', 'high');
			}
    }
}
 
function insert_subTitle(){
     global $post;
     wp_nonce_field(wp_create_nonce(__FILE__), 'subtitle_nonce');
     echo '<label for="subTitle"></label><input type="text" name="subTitle" size="60" value="'.esc_html(get_post_meta($post->ID, 'subTitle', true)).'" />';
}
 
function save_subTitle($post_id){
	$subtitle_nonce = isset($_POST['subtitle_nonce']) ? $_POST['subtitle_nonce'] : null;
	if(!wp_verify_nonce($subtitle_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
	$data = $_POST['subTitle'];
 
	if(get_post_meta($post_id, 'subTitle') == ""){
		add_post_meta($post_id, 'subTitle', $data, true);
	}elseif($data != get_post_meta($post_id, 'subTitle', true)){
		update_post_meta($post_id, 'subTitle', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'subTitle', get_post_meta($post_id, 'subTitle', true));
	}
}


?>
