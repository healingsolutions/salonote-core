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



//seo columns
$theme_opt['post_type'] = get_option('essence_post_type');

add_action( 'edit_form_after_title', 'check_title_words_count' );
function check_title_words_count() {
	global $theme_opt;
	global $post_type;

	if( !empty( $theme_opt['post_type'][$post_type] ) && in_array('check_words_count', $theme_opt['post_type'][$post_type] ) ){
		
		$_title_count = mb_strlen( get_the_title() ) ? mb_strlen( get_the_title() ) : 0 ;
		
		echo '<div id="title_count_wrap"';
		if( $_title_count > 32 ) echo ' class="bad"';
		echo '><span id="title_count_item">'. ($_title_count ? $_title_count : 0 ) .'</span>文字</div>';
	?>
<script type="text/javascript">
$(function(){
    $('input[name="post_title"]').bind('keydown keyup keypress change',function(){
        var thisValueLength = $(this).val().length;
        $('#title_count_item').html(thisValueLength);
			
				if( thisValueLength > 32 ){
					 $('#title_count_wrap').addClass('bad');
				}else{
					 $('#title_count_wrap').removeClass('bad');
				}
    });
});
</script>
<style>
	#title_count_wrap{
		margin-top: 10px;
	}
	#title_count_wrap span{
		font-size: 2em;
	}
	#title_count_wrap.bad{
		
	}
	#title_count_wrap.bad::after{
		content: '長い';
		display: inline-block;
		vertical-align: top;
		font-size: 0.8em;
		margin-left: 15px;
		color: white;
		padding: 3px;
		border-radius: 4px;
		background-color: #C02B2D;
	}

</style>
<?php
	};
}


if( !empty( $theme_opt['post_type'] ) && is_admin() ){
	foreach( $theme_opt['post_type'] as $post_type => $value ){
		if( !empty( $value ) && in_array('check_words_count',$value ) ){
			
		add_filter('manage_edit-'.$post_type.'_columns', 'salonote_check_words_columns');
		add_filter('manage_edit-'.$post_type.'_columns', 'salonote_check_headline_columns');
			
		add_action('manage_'.$post_type.'_posts_custom_column', 'salonote_add_words_count_column');
		add_action('manage_'.$post_type.'_posts_custom_column', 'salonote_add_headline_count_column');
		}
	}
}

function salonote_check_words_columns($columns) {
		$columns['words_count'] = __('Words count','salonote-essence');
		return $columns;
}
function salonote_check_headline_columns($columns) {
		$columns['headline_count'] = __('Headline count','salonote-essence');
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
			$words_column .= '<div class="post_keywords">'.get_post_meta($post->ID, 'keywords', true).'</div>';
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



function substr_count_array($haystack, $needle) {
    $count = 0;
    $haystack = strtolower($haystack);
    foreach ($needle as $substring) {
			if( empty($haystack) || empty($substring) ) continue;
      $count += substr_count($haystack, strtolower($substring));
    }
    return $count;
}


function salonote_add_headline_count_column($column_name) {
		global $theme_opt;
	global $post_type;
	global $post;

	$headline_count = '';
	if ( 'headline_count' == $column_name) {
		
		$post_id = isset( $post_id) ? $post_id : null;

		$pattern= '/\<h(\d{1}).+?\>(.+?)\<\/h\d{1}>/';
		preg_match_all($pattern, get_post_field( 'post_content', $post_id ) , $match);
		
		
		if( empty($match) ) return;
		
		$keywords = get_post_meta($post->ID, 'keywords', true);
		$keywords_arr = explode( ',', $keywords );
		
		
		echo '<div class="headline-count-block">';
		
		
		$headlines = [];
		foreach( $match[1] as $key => $headline ){
			$headlines[$headline][] = $match[2][$key];
		}
		
		foreach( $headlines as $key => $value ){
			if( count( $value ) === 0 ) continue;
			echo '<h2 class="headline-count">見出し' .$key.' <span>'. count( $value ) .'</span>回</h2>';
			
			echo '<ul>';
			foreach( $value as $headline_txt ){
				
				
				$_word_count = 0;
				$_word_count = substr_count_array( $headline_txt, $keywords_arr );
				
				echo '<li>'. strip_tags($headline_txt);
				if( $_word_count ){
					echo '<span class="column_badge good">Good</span>';
				}
				
				echo '</li>';
			}
			echo '</ul>';
		}
		
		echo '</div>';

		
	}
	
	
	if ( isset($headline_count) ) {
		echo $headline_count;
	}
}









function display_salonote_keywords_quickmenu( $column_name, $post_type ) {
	global $post;
	static $print_nonce = TRUE;
    if ( $print_nonce ) {
        $print_nonce = FALSE;
        wp_nonce_field( 'quick_edit_action', $post_type . '_edit_nonce' );
    }
    ?>
<fieldset class="inline-edit-col-right inline-custom-meta">
<div class="inline-edit-col column-<?php echo $column_name ?>">
            <label class="inline-edit-group"></p>
              <?php
			
                switch ( $column_name ) {
                    case 'headline_count':
                        ?><span class="title">キーワード</span><input type="text" name="keywords" value="<?php echo $keywords;?>" /><?php
                        break;
                }
                ?>
           </label>
        </div>
</fieldset>
<?php
}
add_action( 'quick_edit_custom_box', 'display_salonote_keywords_quickmenu', 10, 2 );



function save_salonote_keywords_meta( $post_id ) {
    $slug = get_post_type( $post_id );
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    $_POST += array("{$slug}_edit_nonce" => '');
    if ( !wp_verify_nonce( $_POST["{$slug}_edit_nonce"], 'quick_edit_action' ) ) {
        return;
    }
    if ( isset( $_REQUEST['keywords'] ) ) {
        update_post_meta( $post_id, 'keywords', $_REQUEST['keywords'] );
    }
}
add_action( 'save_post', 'save_salonote_keywords_meta' );




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
			'seriously'  => '決め台詞',
			'sad'		 		 => '悲しい',
			'understand' => 'わかった',
			'question'   => 'わからない',
			'angry'  		 => '怒る',
			'surprised'  => 'おどろく',
			'speechless' => '呆れる',
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

		if( !empty($char_set_arr[$match_key]['r']) && strpos($char_set_arr[$match_key]['r'],'t') === false){
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
			if( $check_char === 'male' ){
				$src = $default_char[0]['normal'];
				$check_char = 'female';
			}else{
				$src = $default_char[1]['normal'];
				$check_char = 'male';
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


?>