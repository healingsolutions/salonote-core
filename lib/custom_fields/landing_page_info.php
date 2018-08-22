<?php
/*
Description: Landing Page Info Fields
Author: Healin Solutions
Version: 0.1
Author URI:http://www.healing-solutions.jp
*/

add_action('add_meta_boxes', 'add_landing_page_info');
add_action('save_post', 'save_landing_page_info');
 
function add_landing_page_info(){
	global $post;

	if(!empty($post))
	{
			$pageTemplate = get_post_meta($post->ID, '_wp_page_template', true);

			if($pageTemplate == 'template/landing-list.php' )
			{
					add_meta_box(
							'landing_page_info', // $id
							 __('Landing Page Info Fields','salonote-essence'), // $title
							'insert_landing_page_info', // $callback
							'page', // $page
							'side', // $context
							'default'); // $priority
			}
	}
}
 
function insert_landing_page_info(){
     global $post;
     wp_nonce_field(wp_create_nonce(__FILE__), 'landing_page_info_nonce');
  
  $landing_page_info_value = get_post_meta($post->ID,'landing_page_info',true);

  $landing_page_info_arr = array(
    'none_header'    		=> __('None Header','salonote-essence'),
    'none_footer' 			=> __('None Footer','salonote-essence'),
		'use_container' 		=> __('User Container','salonote-essence'),
  );
  
  
  echo '
  <style>
  dl.essence_landing_page_info_fields{
    display: block;
    clear: both;
    padding-bottom: 3px;
    border-bottom: 1px solid #eee;
  }
  dl.essence_landing_page_info_fields dt,
  dl.essence_landing_page_info_fields dd{
    display: inline-block;
  }
  dl.essence_landing_page_info_fields dd{
    float: right;
  }
  </style>
  ';
  foreach($landing_page_info_arr as $key => $value){
    echo '
    <dl class="essence_landing_page_info_fields">
    <label for="landing_page_info_'.$key.'">
    <dt>'.$value.'</dt>
    
    <dd>
    <input id="landing_page_info_'.$key.'" type="checkbox" name="landing_page_info['.$key.']" size="60" value="1"';
    if( !empty($landing_page_info_value[$key]) ){
      echo ' checked';
    }
    echo '/>
    </dd>
    </label>
    </dl>
    ';
  }

}
 
function save_landing_page_info($post_id){
	$landing_page_info_nonce = isset($_POST['landing_page_info_nonce']) ? $_POST['landing_page_info_nonce'] : null;
	if(!wp_verify_nonce($landing_page_info_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
  if( !empty($_POST['landing_page_info']) ){
    $data = $_POST['landing_page_info'];
  }else{
    $data = null;
  }
 
	if(get_post_meta($post_id, 'landing_page_info') == ""){
		add_post_meta($post_id, 'landing_page_info', $data, true);
	}elseif($data != get_post_meta($post_id, 'landing_page_info', true)){
		update_post_meta($post_id, 'landing_page_info', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'landing_page_info', get_post_meta($post_id, 'landing_page_info', true));
	}
}

?>
