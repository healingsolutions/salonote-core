<?php

/*  Copyright 2016 Healing Solutions (email : info@healing-solutions.jp)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action("admin_init", "metaboxs_init");
function metaboxs_init(){ // 投稿編集画面にメタボックスを追加する
    add_meta_box( 'es_character_upload', 'キャラクター', 'es_character_upload_postmeta', 'es_character', 'normal','high' ); // ポジションはsideが推奨です
    add_action('save_post_es_character', 'save_es_character_upload_postmeta');
}
  
/////////////////////// メタボックス（画像アップロード用） /////////////////////// 
   
function es_character_upload_postmeta(){ //投稿ページに表示されるカスタムフィールド
	global $post;
	$post_id = $post->ID;
	$es_character_upload_images = get_post_meta( $post_id, 'es_character_upload_images', true );
	if(is_user_logged_in()){
		//echo '<pre>'; print_r($es_character_upload_images); echo '</pre>';
	}
	$assets = [];
	
	

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
	
	foreach($fields_arr as $key => $label){

		if( !empty($es_character_upload_images[$key]) && is_array($es_character_upload_images[$key]) ){
			$assets[$key]['url'] = !empty($es_character_upload_images[$key]['url']) ? esc_html($es_character_upload_images[$key]['url']) : null ;
			$assets[$key]['id'] = !empty($es_character_upload_images[$key]['id']) ? esc_html($es_character_upload_images[$key]['id']) : null ;
		}else{
			$assets[$key]['url'] = !empty($es_character_upload_images[$key]) ? esc_html($es_character_upload_images[$key]) : null ;
			$assets[$key]['id'] = !empty($es_character_upload_images[$key]) ? esc_html(get_attachment_id($es_character_upload_images[$key])) : null ;
		}

	}
	
?>


	<table id="character_essence_table">
		<tbody>
		<?php
		$index = 0;
		foreach($fields_arr as $key => $label){
		?>
		<tr>
			<th><?php echo $label; ?></div>
			<td class="character_td">
					<a rel="character_<?php echo $key; ?>" type="button" class="button character_image_upload" title="画像を追加・変更"<?php if( !empty($assets[$key]['url'])) echo ' style="display:none;"';?>>追加・削除</a>
					
					<div id="character_<?php echo $key; ?>_asset">
						<div class="character_asset_block salonote_images_upload_block">
							<?php
							if( !empty($assets[$key]['url']) ){
					
								echo '<a href="#" class="salonote_images_upload_images_remove" title="画像を削除する"></a>';
								
							
								if( is_array($assets[$key]) ){
									echo '<img src="'.$assets[$key]['url'].'" />';
									echo '<input id="character_'.$key.'_url" type="hidden" name="es_character_upload_images['.$key.'][url]" value="'.$assets[$key]['url'].'" />';
									echo '<input id="character_'.$key.'_id" type="hidden" name="es_character_upload_images['.$key.'][id]" value="'.$assets[$key]['id'].'" />';
								}else{
									echo '<img src="'.$assets[$key].'" />';
									echo '<input id="character_'.$key.'_url" type="hidden" name="es_character_upload_images['.$key.'][url]" value="'.$assets[$key].'" />';
									echo '<input id="character_'.$key.'_id" type="hidden" name="es_character_upload_images['.$key.'][id]" value="'.get_attachment_id($assets[$key]).'" />';
								}
			
								
							}
							?>
						</div>
					</div>

			</td>
			<td>
			<p>[character id=<?php echo $post_id; ?> type=<?php echo $key; ?> reverse=false position=left src=""]テキスト[/character]</p>
			<p>[char id=<?php echo $post_id; ?> t=<?php echo $key; ?> r=f p=l src=""]テキスト[/char]</p>
			</td>
		</tr>
			
		<?php
			++ $index;
		};
		?>
			</tbody>
		</table>

<input type="hidden" name="es_character_upload_postmeta_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />

 
<?php }
   
/*データ更新時の保存*/
function save_es_character_upload_postmeta( $post_id ){

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
	return $post_id; // 自動保存ルーチンの時は何もしない
	
	if ( !empty($_POST['es_character_upload_postmeta_nonce']) && !wp_verify_nonce($_POST['es_character_upload_postmeta_nonce'], basename(__FILE__)))
	return $post_id; // wp-nonceチェック
	
	if ( !empty($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) ) // パーミッションチェック
			return $post_id;
	} else {
			if ( !current_user_can( 'edit_post', $post_id ) ) // パーミッションチェック
			return $post_id;
	}
	
	$new_images = isset($_POST['es_character_upload_images']) ? $_POST['es_character_upload_images']: null; //POSTされたデータ
	$ex_images = get_post_meta( $post_id, 'es_character_upload_images', true ); //DBのデータ
	if ( $ex_images !== $new_images ){
			if ( $new_images ){
					update_post_meta( $post_id, 'es_character_upload_images', $new_images ); // アップデート
					character_esence_update_post();
			} else {
					delete_post_meta( $post_id, 'es_character_upload_images', $ex_images ); 
			}
	}
}




// ここからキャラクターを保存した時に実行される関数を定義します。
function character_esence_update_post() {
  // ここにテーマが有効化された時のコードを書きます。

  require_once(ABSPATH . 'wp-admin/includes/file.php');//WP_Filesystemの使用
  
	//初期化
	$character_json = [];
	$character_style = '
	.character {
		padding: 10px;
	}
	.char_reverse_true{
		transform: scale(-1, 1);
	}';
	
	$args = array(
		'post_type'      => 'es_character',
		'posts_per_page' => -1
	);
	$characters = get_posts($args);
	
	foreach( $characters as $post ){
		$char_arr = get_post_meta( $post->ID, 'es_character_upload_images', true );
		$value_arr = [];
		foreach( $char_arr as $key=> $value ){
			$character_style .= '.char_id_'.$post->ID.'.char_type_'.$key.'{ background-image:url( '.$value.' ) };'.PHP_EOL;
			
			$value_arr[$key] = $value;
		}
		$character_json[$post->ID]['label'] = get_the_title($post->ID);
		$character_json[$post->ID]['images'] = $value_arr;
	}

	//CSSを書き出し
  //file_put_contents( CHARACTER_ESSENCE_PLUGIN_PATH. "/statics/css/character.css",$character_style);
	
	//jsonを書き出し
	$character_json = json_encode($character_json);
	//$character_json = 'test';
	file_put_contents( CHARACTER_ESSENCE_PLUGIN_PATH. "/statics/json/character.json" , $character_json);
  
}
?>
