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
					add_meta_box('keywords', 'キーワード', 'insert_keywords', $post_type_name, 'side','high');
			}
    }
}
 
function insert_keywords(){
	global $post;
	wp_nonce_field(wp_create_nonce(__FILE__), 'keywords_nonce');
	
	$keywords = esc_html(get_post_meta($post->ID, 'keywords', true));
	
	echo '<label for="keywords"></label><input type="text" name="keywords" size="60" value="'.$keywords.'" />';

	if( !empty($keywords) ){
		$suggest_data = suggest_from_keywords($keywords );
		
		if( count($suggest_data) > 0 ){
			
			echo '<p class="hint">Googleでは同時にこのようなワードが検索されています</p>';
			echo '<ul style="background-color: white; padding:1.5em; border:1px solid #CCCCCC; ">';
			foreach( $suggest_data as $key => $word_item ){
				echo '<li style="display:inline-block; margin:4px; padding: 3px 7px; background-color: #F2F2F2;">'.$word_item.'</li>';
			}
			echo '</ul>';
		
		//echo '<pre>suggest_data'; print_r($suggest_data); echo '</pre>';
		}else{
			echo '<p class="hint">関連サジェストが見つかりません</p>';
		}
	}
	
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



//Google Suggest

function suggest_from_keywords($keywords){
	
	if( empty($keywords) ) return;
	
	$suggest_data = array();
	$keywords_arr = explode(',',$keywords);
	
	foreach( $keywords_arr as $key => $words){
		$suggest_url = 'http://www.google.com/complete/search?hl=en&output=toolbar&q='. preg_replace('/(　| )/','%20',$words);
		$content = utf8_encode(file_get_contents($suggest_url));
		$xml = simplexml_load_string($content);

		foreach($xml->CompleteSuggestion as $item){
			$str = (string)$item->suggestion['data'];
				$suggest_data[] = $str;
		}
	}

	return $suggest_data;
	
}


?>