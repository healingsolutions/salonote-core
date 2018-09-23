<?php
/*
Description: Page Information Fields
Author: Healin Solutions
Version: 0.1
Author URI:http://www.healing-solutions.jp
*/

add_action('add_meta_boxes', 'add_page_info');
add_action('save_post', 'save_page_info');
 
function add_page_info(){
  add_meta_box('page_info', __('Page Information','salonote-essence'), 'insert_page_info', array('post','page','style'), 'side', 'low');

}
 
function insert_page_info(){
     global $post;
     wp_nonce_field(wp_create_nonce(__FILE__), 'page_info_nonce');
  
  $page_info_value = get_post_meta($post->ID,'page_info',true);

  $page_info_arr = array(
    'full_size'    			=> __('Full Size','salonote-essence'),
    'none_sidebar' 			=> __('Hide Sidebar','salonote-essence'),
		'has_sidebar' 			=> __('Show Sidebar','salonote-essence'),
    'single_child_unit' => __('Show Children','salonote-essence'),
		'child_tab_nav' 		=> __('Tab navigation','salonote-essence'),
    'exclude_list' 			=> __('Hide in list','salonote-essence'),
    'disable_title' 		=> __('HIde Title','salonote-essence'),
    'super_container' 	=> __('Small container','salonote-essence'),
		'hide_header_description' 	=> __('Hide header description','salonote-essence'),
  );
  
  
  echo '
  <style>
  dl.essence_page_info_fields{
    display: block;
    clear: both;
    padding-bottom: 3px;
    border-bottom: 1px solid #eee;
  }
  dl.essence_page_info_fields dt,
  dl.essence_page_info_fields dd{
    display: inline-block;
  }
  dl.essence_page_info_fields dd{
    float: right;
  }
  </style>
  ';
  foreach($page_info_arr as $key => $value){
    echo '
    <dl class="essence_page_info_fields">
    <label for="page_info_'.$key.'">
    <dt>'.$value.'</dt>
    
    <dd>
    <input id="page_info_'.$key.'" type="checkbox" name="page_info['.$key.']" size="60" value="1"';
    if( !empty($page_info_value[$key]) ){
      echo ' checked';
    }
    echo '/>
    </dd>
    </label>
    </dl>
    ';
  }
	
	echo '<dl><dt>'. __('Side Content','salonote-essence') .'</dt><dd>';
	echo '<textarea id="page_info_side" class="large-text" name="page_info[sidebar]" rows="4">';
    echo !empty($page_info_value['sidebar']) ? esc_html($page_info_value['sidebar']) : '';
  echo '</textarea>';
	echo '</dd></dl>';
	

}
 
function save_page_info($post_id){
	$page_info_nonce = isset($_POST['page_info_nonce']) ? $_POST['page_info_nonce'] : null;
	if(!wp_verify_nonce($page_info_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
  if( !empty($_POST['page_info']) ){
    $data = $_POST['page_info'];
  }else{
    $data = null;
  }
 
	if(get_post_meta($post_id, 'page_info') == ""){
		add_post_meta($post_id, 'page_info', $data, true);
	}elseif($data != get_post_meta($post_id, 'page_info', true)){
		update_post_meta($post_id, 'page_info', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'page_info', get_post_meta($post_id, 'page_info', true));
	}
}


?>
