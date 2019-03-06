<?php

/*=========================================================
// public css
----------------------------------------------------------*/
function salonote_essence_helper_head_enqueue() {
  global $theme_opt;
  
  
  if(!is_admin()){
    wp_deregister_script('jquery');
    wp_deregister_script('jquery-migrate');
  }
  
  //jQuery
  wp_enqueue_script('jquery','//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '3.2.1', true);

}
add_action( 'wp_enqueue_scripts', 'salonote_essence_helper_head_enqueue' ,1);




//===============================================
// edit the content
add_filter('the_content', 'edit_content_hook',10);
function edit_content_hook($content){
	

		require_once( SALONOTE_HELPER__PLUGIN_PATH. '/phpQuery/phpQuery-onefile.php' );
 
		$doc = phpQuery::newDocumentHTML($content);


		$counter = 0;
		$element = '';
		foreach($doc->find('.block-unit') as $block_unit) {
			
			$element = '';
			if( pq($block_unit)->find('img')->attr('src') ) {
				$element = ' has_image';
			}else{
				$element = ' has_text';
			}
			
			if( pq($block_unit)->next('.block-unit')->length && pq($block_unit)->prev('.block-group')->length == 0 ) {
				pq($block_unit)->removeClass('block-unit');
				pq($block_unit)->addClass('block-group block-index-'.$counter.$element);
			}
			if( pq($block_unit)->prev('.block-group')->length && pq($block_unit)->next('.block-group')->length == 0 ) {
				pq($block_unit)->removeClass('block-unit');
				pq($block_unit)->addClass('block-group block-index-'.$counter.$element);
				
				
				
			}
			if( pq($block_unit)->next('.block-unit')->length == 0 ) {
				++$counter;
				
			}
		}
		
		

		for ($count = 0; $count < $counter; $count++){
			$length = 0;

			$length = $doc->find('.block-index-'.$count)->length;
			if( $length >= 6 ) $length = ($length%6)+6;
			foreach($doc->find('.block-index-'.$count) as $group_col) {
				pq($group_col)->addClass('group-col-'. $length );
			}
			
		}
	
		for ($count = 0; $count < $counter; $count++){
			
			foreach($doc->find('.block-index-'.$count) as $group_col) {
				if( pq($block_unit)->parent('.block-group-wrap')->length == 0 ) {
					pq($group_col)->wrapInner('<div class="block-item-inner"><div class="block-content"></div></div>');
				}
				
				/*
				if( pq($block_unit)->parent('.block-content img')->length > 0 ) {
					$img_count = 0;
					foreach($doc->find('.block-content img') as $image_item) {
						pq($image_item)->addClass('image-item-'. $img_count );
						++ $img_count;
					}
					
				}
				*/
			}
		}
	
		for ($count = 0; $count < $counter; $count++){
			pq('.block-index-'.$count)->wrapAll('<div class="block-group-wrap" />');
			
			if( pq('.block-index-'.$count)->parent('.block-group-wrap')->find('img')->length == 1 ) {
				pq('.block-index-'.$count)->parent('.block-group-wrap')->addClass('has_image_block_group');
			}
		}
		

		return do_shortcode(replace_headline_text_content($doc)); //only pc
	
}

function replace_headline_text_content( $content ){
	global $theme_opt;

	if( !empty($theme_opt['base']['headline_1']) ){
		$content = str_replace('<h1>','<h1 class="'.$theme_opt['base']['headline_1'].'">',$content);
	}
	if( !empty($theme_opt['base']['headline_2']) ){	
		$content = str_replace('<h2>','<h2 class="'.$theme_opt['base']['headline_2'].'">',$content);
	}
	if( !empty($theme_opt['base']['headline_3']) ){	
		$content = str_replace('<h3>','<h3 class="'.$theme_opt['base']['headline_3'].'">',$content);
	}
	if( !empty($theme_opt['base']['headline_4']) ){	
		$content = str_replace('<h4>','<h4 class="'.$theme_opt['base']['headline_4'].'">',$content);
	}
	
	return $content;
}




function markdown_char($content){

	if(strpos($content,'[char') === false) return $content;
	
	$default_char = [];
	
	
	//念のためキャラクター情報を取得しておく
	$args = array(
		'post_type' 			=> 'es_character',
		'posts_per_page' 	=> 2,
	);
	$char_post = get_posts($args);
	if( !empty($char_post) ){
		$default_char[0] = get_post_meta( $char_post[0]->ID, 'es_character_upload_images', true );
		$default_char[1] = get_post_meta( $char_post[1]->ID, 'es_character_upload_images', true );
	}else{
		$fields_arr = array(
			'normal' 		 => 'ノーマル',
			'smile'  		 => 'スマイル',
			'happy'  		 => '楽しい',
			'pleased'  	 => '嬉しい',
			'seriously'  => '決め台詞',
			'correct'  	 => '合っている',
			'mistaken'   => '間違っている',
			'understand' => 'わかった',
			'question'   => 'わからない',
			'thanks'  	 => 'お礼を言う',
			'angry'  		 => '怒る',
			'surprised'  => 'おどろく',
			'panicked'   => 'あせる',
			'speechless' => '呆れる',
			'upset' 		 => '困る',
			'sad'		 		 => '悲しい',
			'trying'		 => '苦しい',
			'sorry' 		 => 'あやまる',
			'sleep'  		 => '寝る',
		);
		foreach( $fields_arr as $key => $value ){
			$default_char[0][$key] = CHARACTER_ESSENCE_PLUGIN_URI . '/statics/images/female/female_' . $key .'.jpg';
		}
		foreach( $fields_arr as $key => $value ){
			$default_char[1][$key] = CHARACTER_ESSENCE_PLUGIN_URI . '/statics/images/male/male_' . $key .'.jpg';
		}
	}
	
	
	//コンテンツ生成開始
	$char_content = '';

	$match_arr = preg_match_all('/\[cha(.+?)?\](.+?)\[\/char\]/s',$content,$match_txt, PREG_PATTERN_ORDER );
	//echo '<pre>match_txt'; print_r($match_txt); echo '</pre>';


	$check_char = '';
	$position = '';
	$char_content .= '';

	foreach( $match_txt[0] as $match_key => $match_content ){
		
		$check_key = $match_key-1;

		$set_content = $match_txt[1][$match_key];
		if( strpos($set_content,' ') !== false ){
			$char_set = explode(' ',$set_content);		
		}else{
			$char_set = [];
		}
		
		$char_set_arr = [];
		
		//echo '<pre>char_set'; print_r($char_set); echo '</pre>';

		foreach( $char_set as $set_key => $set_value ){
			$set_value_item = explode('=',$set_value);
			if( !empty($set_value_item[1]) && strpos($set_value_item[0],'[') === false  ){
				$char_set_arr[$match_key][$set_value_item[0]] = $set_value_item[1];
			}
		}

		//echo '<pre>char_set_arr'; print_r($char_set_arr); echo '</pre>';

		$char_content .= '[character';
		
		if( !empty($char_set_arr[$match_key]['id'])){
			$char_content .= ' id='.$char_set_arr[$match_key]['id'];
		}else{
			$char_content .= ' id=0';
		}
		
		if( !empty($char_set_arr[$match_key]['t'])){
			$char_content .= ' type='.$char_set_arr[$match_key]['t'];
		}else{
			$char_content .= ' type=normal';
		}

		if( !empty($char_set_arr[$match_key]['r']) && strpos($char_set_arr[$match_key]['r'],'t') !== false){
			$char_content .= ' reverse=true';
		}else{
			$char_content .= ' reverse=false';
		}


		if( !empty($char_set_arr[$match_key]['p']) && strpos($char_set_arr[$match_key]['p'],'r') !== false){
			$char_content .= ' position=right';
			$position = 'right';
		}else{
			
			

			
			if( $check_key >= 0 && $position === 'left'){
				$char_content .= ' position=right';
				$position = 'right';
			}else{
				$char_content .= ' position=left';
				$position = 'left';
			}
		}
		
		if( !empty($char_set_arr[$match_key]['c']) && strpos($char_set_arr[$match_key]['c'],'t') !== false){
			$char_content .= ' circled=true';
		}else{
			$char_content .= ' circled=false';
		}

		

		$id 	= !empty($char_set_arr[$match_key]['id']) ? $char_set_arr[$match_key]['id'] : null ;
		$type = !empty($char_set_arr[$match_key]['t']) ? $char_set_arr[$match_key]['t'] : 'normal' ;
		
		if( !empty($char_set_arr[$match_key]['src']) ){
			$src = $char_set_arr[$match_key]['src'];
		}else{
			if( $check_char === 'female' ){
				$src = $default_char[1][$type];
				$check_char = 'male';
			}else{
				$src = $default_char[0][$type];
				$check_char = 'female';
			}
			
		}
		
		$es_character_upload_images = get_post_meta( $id, 'es_character_upload_images', true );


		if( !empty( $es_character_upload_images ) ){
			$char_content .= ' src="'.$es_character_upload_images[$type].'"';
		}elseif( !empty( $src ) ){
			$char_content .= ' src="'.$src.'"';
		}
		
		$char_content .= ']';
		$char_content .= str_replace('[char]','',$match_txt[2][$match_key]);
		$char_content .= '[/character]';


	}
	

	

	return $char_content;
	
}



if( !empty($theme_opt['base']['custom_post_label']) ){


  //デフォルトの投稿のラベル変更
  function salonote_change_post_menu_label() {
    global $menu;
    global $submenu;
    global $theme_opt;
    $menu[5][0] = $theme_opt['base']['custom_post_label'];
    $submenu['edit.php'][5][0] = $theme_opt['base']['custom_post_label'] . '一覧';
    $submenu['edit.php'][10][0] = '新しい'.$theme_opt['base']['custom_post_label'];
    $submenu['edit.php'][16][0] = 'タグ';
  //echo ";
  }
  function salonote_change_post_object_label() {
    global $wp_post_types;
    global $theme_opt;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = $theme_opt['base']['custom_post_label'];
    $labels->singular_name = $theme_opt['base']['custom_post_label'];
    $labels->add_new = _x('追加', $theme_opt['base']['custom_post_label']);
    $labels->add_new_item = $theme_opt['base']['custom_post_label'].'の新規追加';
    $labels->edit_item = $theme_opt['base']['custom_post_label'].'の編集';
    $labels->new_item = '新規'.$theme_opt['base']['custom_post_label'];
    $labels->view_item = $theme_opt['base']['custom_post_label'].'を表示';
    $labels->search_items = $theme_opt['base']['custom_post_label'].'を検索';
    $labels->not_found = $theme_opt['base']['custom_post_label'].'が見つかりませんでした';
    $labels->not_found_in_trash = 'ゴミ箱に'.$theme_opt['base']['custom_post_label'].'は見つかりませんでした';
  }
  add_action( 'init', 'salonote_change_post_object_label' );
  add_action( 'admin_menu', 'salonote_change_post_menu_label' );
  
}

?>