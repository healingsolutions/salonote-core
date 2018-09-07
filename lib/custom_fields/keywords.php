<?php
/*
Plugin Name: Page keywords Custom Field
Plugin URI: http://www.healing-solutions.jp
Description: ページにキーワードフィールドを追加
Author: Healin Solutions
Version: 0.1
Author URI:http://www.healing-solutions.jp
*/

add_action('admin_menu', 'add_keywords');
add_action('save_post', 'save_keywords');
 
function add_keywords(){
     
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

			if( !empty($post_type_set) && in_array('check_words_count',$post_type_set) ){
					add_meta_box('keywords', 'キーワード', 'insert_keywords', $post_type_name, 'normal', 'high');
			}
    }
}
 
function insert_keywords(){
     global $post;
     wp_nonce_field(wp_create_nonce(__FILE__), 'keywords_nonce');
     echo '<label for="keywords"></label><input type="text" name="keywords" size="60" value="'.esc_html(get_post_meta($post->ID, 'keywords', true)).'" />';
}
 
function save_keywords($post_id){
	$keywords_nonce = isset($_POST['keywords_nonce']) ? $_POST['keywords_nonce'] : null;
	if(!wp_verify_nonce($keywords_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
	$data = $_POST['keywords'];
 
	if(get_post_meta($post_id, 'keywords') == ""){
		add_post_meta($post_id, 'keywords', $data, true);
	}elseif($data != get_post_meta($post_id, 'keywords', true)){
		update_post_meta($post_id, 'keywords', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'keywords', get_post_meta($post_id, 'keywords', true));
	}
}

?>