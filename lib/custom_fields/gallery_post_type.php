<?php
/*
Description: Gallery Post Type Fields
Author: Healin Solutions
Version: 0.1
Author URI:http://www.healing-solutions.jp
*/

add_action('add_meta_boxes', 'add_gallery_post_type');
add_action('save_post', 'save_gallery_post_type');
 
function add_gallery_post_type(){
	global $post;

	if(!empty($post))
	{
			$pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

			if($pageTemplate == 'template/attachment-list.php' )
			{
					add_meta_box(
							'gallery_post_type', // $id
							 __('Gallery Post Type','salonote-essence'), // $title
							'insert_gallery_post_type', // $callback
							'page', // $page
							'side', // $context
							'default'); // $priority
			}
	}
}
 
function insert_gallery_post_type(){
	global $post;
	wp_nonce_field(wp_create_nonce(__FILE__), 'gallery_post_type_nonce');
  $gallery_post_type_value = !empty(get_post_meta($post->ID,'gallery_post_type',true)) ? get_post_meta($post->ID,'gallery_post_type',true) : 'post' ;

	
	
	$args = array(
		 'public'   => true,
		 '_builtin' => false
	);

	$post_types = get_post_types( $args, 'names' );
	array_push($post_types, "post");
	echo '<select name="gallery_post_type">';
	foreach ( array_reverse($post_types) as $post_type_name ) {
		if( !empty($post_type_name) && $post_type_name !== 'front_page' ){
			$post_type_label = !empty(get_post_type_object($post_type_name)->labels->singular_name) ? get_post_type_object($post_type_name)->labels->singular_name : null ;
		}
		if( empty($post_type_label) ) continue;
		
		echo '<option value="'.$post_type_name.'"';
		if( $gallery_post_type_value == $post_type_name ){
			echo ' selected';
		}
		echo '>'.$post_type_label.'</option>';
	}
	
	echo '</select>';
}
 
function save_gallery_post_type($post_id){
	$gallery_post_type_nonce = isset($_POST['gallery_post_type_nonce']) ? $_POST['gallery_post_type_nonce'] : null;
	if(!wp_verify_nonce($gallery_post_type_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
  if( !empty($_POST['gallery_post_type']) ){
    $data = $_POST['gallery_post_type'];
  }else{
    $data = null;
  }
 
	if(get_post_meta($post_id, 'gallery_post_type') == ""){
		add_post_meta($post_id, 'gallery_post_type', $data, true);
	}elseif($data != get_post_meta($post_id, 'gallery_post_type', true)){
		update_post_meta($post_id, 'gallery_post_type', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'gallery_post_type', get_post_meta($post_id, 'gallery_post_type', true));
	}
}


?>
