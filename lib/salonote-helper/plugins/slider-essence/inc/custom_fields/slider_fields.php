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

add_action("admin_init", "slider_essence_metaboxs_init");
function slider_essence_metaboxs_init(){ // 投稿編集画面にメタボックスを追加する
    add_meta_box( 'es_slider_upload', 'スライダー', 'es_slider_upload_postmeta', 'page', 'normal','high' ); // ポジションはsideが推奨です
    add_action('save_post', 'save_es_slider_upload_postmeta');
}
  
/////////////////////// メタボックス（画像アップロード用） /////////////////////// 
   
function es_slider_upload_postmeta(){ //投稿ページに表示されるカスタムフィールド
	global $post;
	$post_id = $post->ID;
	$es_slider_upload_images = get_post_meta( $post_id, 'es_slider_upload_images', true );

	//初期化
	$es_slider_upload_li = '';

	if( !empty($es_slider_upload_images) ){

	
		foreach( $es_slider_upload_images as $key => $value ){

			
				$thumb_src = wp_get_attachment_image_src ($value['image'],'large');
				if( empty($thumb_src[0]) ){
					$thumb_src = wp_get_attachment_image_src ($value['image'],'full');
				}
				if ( empty ($thumb_src[0]) ){ //画像が存在しない空IDを強制的に取り除く
						//delete_post_meta( $post_id, 'es_slider_upload_images', $img_id );
					$thumb_src[0] = wp_get_attachment_url($value['image']);
				}
				if ( !empty ($thumb_src[0]) )
					{
						$es_slider_upload_li.= 
						'<li class="img" id="img_'.$value['image'].'">
						<div class="img_wrap">
						<a href="#" class="es_slider_upload_images_remove" title="画像を削除する"></a>
						<div class="slider-item" style="background-image:url('.$thumb_src[0].')">
						<!-- image -->
						
						<input type="hidden" name="es_slider_upload_images['.$key.'][image]" value="'.$value['image'].'" />
						<input class="slider-text" type="text" name="es_slider_upload_images['.$key.'][text]" value="'. (!empty($value['text']) ? $value['text'] : '') .'">
						<textarea class="slider-textarea" name="es_slider_upload_images['.$key.'][textarea]">'. ( !empty($value['textarea']) ? $value['textarea'] : '' ).'</textarea>
						</div>
						</li>';
				}
		}
	}
?>


<div id="es_slider_upload_buttons">
    <a id="es_slider_upload_media" type="button" class="button" title="画像を追加">画像を追加</a>
</div>
<ul id="es_slider_upload_images">
<?php echo $es_slider_upload_li; ?>
</ul>


<?php
	$es_slider_info = get_post_meta( $post_id, 'es_slider_info',true );
	$_content = !empty( $es_slider_info['content'] ) ? $es_slider_info['content'] : '' ;
	$_height  = !empty( $es_slider_info['height'] )  ? $es_slider_info['height']  : null ;
?>

<table class="form-table" style="vertical-align: top;">
	<tbody>
		<tr>
			<th>共通テキスト</th>
			<td><textarea class="large-text" name="es_slider_info[content]"><?php echo $_content ?></textarea></td>

			<th>このページのスライドの高さ</th>
			<td><input type="text" class="reguler-text" name="es_slider_info[height]" value="<?php echo $_height; ?>"></td>
		</tr>
	</tbody>
</table>


<input type="hidden" name="es_slider_upload_postmeta_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />
<br clear="all">
 
<?php }
   
/*データ更新時の保存*/
function save_es_slider_upload_postmeta( $post_id ){
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id; // 自動保存ルーチンの時は何もしない
	
	if ( empty($_POST['es_slider_upload_postmeta_nonce']) )
		return $post_id;
	
	if ( !wp_verify_nonce($_POST['es_slider_upload_postmeta_nonce'], basename(__FILE__)))
		return $post_id; // wp-nonceチェック
	
	if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) ) // パーミッションチェック
			return $post_id;
	} else {
			if ( !current_user_can( 'edit_post', $post_id ) ) // パーミッションチェック
			return $post_id;
	}
	
	$new_images = isset($_POST['es_slider_upload_images']) ? $_POST['es_slider_upload_images']: null; //POSTされたデータ
	$ex_images = get_post_meta( $post_id, 'es_slider_upload_images', true ); //DBのデータ
	if ( $ex_images !== $new_images ){
			if ( $new_images ){
					update_post_meta( $post_id, 'es_slider_upload_images', $new_images ); // アップデート
			} else {
					delete_post_meta( $post_id, 'es_slider_upload_images', $ex_images ); 
			}
	}
	
	$new_content = isset($_POST['es_slider_info']) ? $_POST['es_slider_info']: null; //POSTされたデータ
	$ex_content = get_post_meta( $post_id, 'es_slider_info', true ); //DBのデータ
	if ( $ex_content !== $new_content ){
			if ( $new_content ){
					update_post_meta( $post_id, 'es_slider_info', $new_content ); // アップデート
			} else {
					delete_post_meta( $post_id, 'es_slider_info', $ex_content ); 
			}
	}
}
?>
