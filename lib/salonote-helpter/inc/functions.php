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

	
	if ( !wp_is_mobile() ) {

		require_once( SALONOTE_HELPER__PLUGIN_PATH. '/phpQuery/phpQuery-onefile.php' );
 
		$doc = phpQuery::newDocumentHTML($content);

		$counter = 0;
		foreach($doc->find('.block-unit') as $block_unit) {
			
			if( pq($block_unit)->next('.block-unit')->length && pq($block_unit)->prev('.block-group')->length == 0 ) {
				pq($block_unit)->removeClass('block-unit');
				pq($block_unit)->addClass('block-group block-index-'.$counter);
			}
			if( pq($block_unit)->prev('.block-group')->length && pq($block_unit)->next('.block-group')->length == 0 ) {
				pq($block_unit)->removeClass('block-unit');
				pq($block_unit)->addClass('block-group block-index-'.$counter);
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
			}
		}
	
		for ($count = 0; $count < $counter; $count++){
					pq('.block-index-'.$count)->wrapAll('<div class="block-group-wrap" />');
		}

		return do_shortcode($doc); //only pc
	}
	return do_shortcode($content); //only sp
}


$theme_opt['post_type'] = get_option('essence_post_type');

if( !empty( $theme_opt['post_type'] ) && is_admin() ){
	foreach( $theme_opt['post_type'] as $post_type => $value ){
		if( !empty( $value ) && in_array('check_words_count',$value ) ){
		add_filter('manage_edit-'.$post_type.'_columns', 'salonote_check_words_columns');
		add_action('manage_'.$post_type.'_posts_custom_column', 'salonote_add_words_count_column');
		}
	}
}

function salonote_check_words_columns($columns) {
		$columns['words_count'] = __('Words count','salonote-essence');
		return $columns;
}

function salonote_add_words_count_column($column_name) {

	global $theme_opt;
	global $post_type;
	global $post;

	$words_column = '';
	if ( 'words_count' == $column_name) {

		
		$post_id = isset( $post_id) ? $post_id : null;

		$title		= get_the_title($post_id);
		$content	= strip_shortcodes(wp_strip_all_tags(get_post_field( 'post_content', $post_id )));
		

		$_title_word	 = mb_strlen(strip_tags($title));
		$_content_word = mb_strlen(preg_replace('/\n(\s|\n)*\n/u',"",$content));


		$post_type_name = get_post_type($post_id);

		$words_column	.= '<div>タイトル：<span style="font-size:1.6em;">' .$_title_word.'</span> 文字';
		$words_column	.= ($_title_word > 32) ? '<span class="column_badge bad">Long</span>' : '' ;
		$words_column	.= '</div>';
		
		$words_column	.= '<div>本　文　：<span style="font-size:1.6em;">' .$_content_word.'</span> 文字';
		if( $_content_word > 2000 ){
			$words_column	.= '<span class="column_badge good">Good</span>';
		}elseif( $_content_word > 1000 ){
			$words_column	.= '<span class="column_badge fine">OK</span>';
		}elseif( $_content_word < 500 ){
			$words_column	.= '<span class="column_badge bad">Short</span>';
		}
		$words_column	.='</div>';
		
		$keywords = get_post_meta($post->ID, 'keywords', true);
		$keywords_arr = explode( ',', $keywords );

		
		
		if( $_content_word > 0 && !empty($keywords) ){
			
			$words_column	.= '<p class="heading bold"><b>キーワード出現回数</b></p>';
			
			

			$words_column	.= '<ul style="marign:0;">';
			foreach( $keywords_arr as $word ){

				$_word_count = substr_count( $content, $word );

				$words_column	.= '<li>'.$word.' : '.$_word_count.'回';

				//echo $word*$_word_count.'<br>';
				//echo $_content_word.'<br>';

				if( $_word_count > 0 ){
					$_word_per = (mb_strlen($word)*$_word_count / $_content_word * 100);
					$words_column	.= ' <span>('.floor( $_word_per * pow( 10 , 1 ) ) / pow( 10 ,1 ).'%)</span>' ;
					
					if( $_word_per < 4.3 ){
						$words_column	.= '<span class="column_badge bad">少ない</span>';
					}elseif( $_word_per > 5.7 ){
						$words_column	.= '<span class="column_badge bad">多い</span>';
					}else{
						$words_column	.= '<span class="column_badge good">適正</span>';
					}
					
				}

				$words_column	.= '</li>';

			}
			$words_column	.= '</ul>';
		}

		

	}
	if ( isset($words_column) ) {
		echo $words_column;
	}
}


?>