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




function OMAKASE_ESSENCE_public_style(){

	
	if( !is_singular() ) return;
	if( empty( $_POST['note']) ) return;
	if( !current_user_can('edit_posts') ) return $content;
	if ( !is_admin_bar_showing() )  return $content;
	
	wp_enqueue_script('jquery','//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '3.2.1', true);
	wp_enqueue_style('essence', get_template_directory_uri().'/style-min.css', array(), $_salonote_ver);
	wp_enqueue_script('essence', get_template_directory_uri().'/statics/js/main-min.js', array(), $_salonote_ver ,true);

}
add_action( 'admin_enqueue_scripts', 'OMAKASE_ESSENCE_public_style' ); //公開用のCSS



function note_essence($content){

	
	if( empty( $_POST['note']) ) return $content;
	if( !current_user_can('edit_posts') ) return $content;
	if ( !is_admin_bar_showing() ) return $content;
	
	global $post;
	global $post_id;
	global $insert_id;
	
	if( empty( $_POST['post_new'])){
		$post_id = !empty( $_POST['post_id'] ) ? $_POST['post_id'] : null ;
	}else{
		$post_id = null;
	}
	
	//echo '<pre>note_body'; print_r($_FILES); echo '</pre>';
	
	if( !empty($_POST['nonce_note_essence']) ){
		//CSRF対策用のチェック
		if(wp_verify_nonce($_POST['nonce_note_essence'], 'add_OMAKASE_ESSENCE_post')){
			//echo 'success';
			
			if( !empty($_FILES) ){
				foreach( $_FILES['note_images']['name'] as $key => $image_data ){
					$_file_data[$key]['name']			= $image_data;
					$_file_data[$key]['type'] 		= $_FILES['note_images']['type'][$key];
					$_file_data[$key]['tmp_name'] = $_FILES['note_images']['tmp_name'][$key];
					$_file_data[$key]['error'] 		= $_FILES['note_images']['error'][$key];
					$_file_data[$key]['size'] 		= $_FILES['note_images']['size'][$key];
				}
				
				
				//echo '<pre>_file_data'; print_r($_file_data); echo '</pre>';
				
				$_up_dir = wp_upload_dir();
				//$save_folder 	= $_up_dir['basedir'] . '/tmp/';
				//$save_url 		= $_up_dir['baseurl'] . '/tmp/';
				$save_folder 	= $_up_dir['path'].'/';
				$save_url 		= $_up_dir['url'].'/';
				
				// 保存先フォルダの作成する。
				if (!is_dir($save_folder)) {
					if ( mkdir( $save_folder, 0755,true ) ) {
					 //echo "ディレクトリ作成成功！！";      
					} else {
					 //echo "ディレクトリ作成失敗！！";
					}
				}
				
				$_use_files = [];
				
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
				
				
				foreach( $_file_data as $key => $image_item ){
					if(is_uploaded_file($image_item['tmp_name'])){
						
						//$name = basename($image_item['tmp_name']);

						$_file_name = str_replace('=','', base64_encode($image_item['name'])).'.'.pathinfo($image_item['name'], PATHINFO_EXTENSION);
						$save_filename = $save_folder . $_file_name;
						$save_fileurl = $save_url.$_file_name;
						
						
						if(is_user_logged_in()){
							//echo '<pre>'; print_r($save_url.$_file_name); echo '</pre>';
						}
						
						//画像ファイルが無い時は取得
						if (!file_exists($save_filename)) {
							if(move_uploaded_file( $image_item['tmp_name'], $save_filename)){
									//echo "uploaded";
								
								//アップロードファイルがある場合、以下実行
								//拡張子をチェックする
								$exten = '';
								if ( $image_item['type'] == 'image/jpeg' ) { $exten = 'jpg'; }
								elseif ( $image_item['type'] == 'image/png' ) { $exten = 'png'; }
								elseif ( $image_item['type'] == 'image/gif' ) { $exten = 'gif'; }
								if($exten !== ''){
									//アップロードファイルを添付する
									$attachment = array(
										'post_mime_type' => $image_item['type'], 
										'post_title' => $image_item['name'], 
										'post_content' => '', 
										'post_status' => 'inherit'
									);

								 $attach_id = wp_insert_attachment( $attachment, $save_filename, $post_id );

								//echo 'attach_id:' . $attach_id . '<br>';

								 
								 $attach_data = wp_generate_attachment_metadata( $attach_id, $save_filename );
								 wp_update_attachment_metadata( $attach_id,  $attach_data );

							 }

								

							}else{
									echo "error while saving.";
							}
						}else{
							//echo $save_filename .'<br>';
							echo 'already uploaded<br>';
							$attach_id = attachment_url_to_postid($save_fileurl);
						  $attach_data = wp_generate_attachment_metadata( $attach_id, $save_filename );
						  wp_update_attachment_metadata( $attach_id,  $attach_data );
						}
						
						
						

					}else{
							echo "file not uploaded.";
					}
					
					
					$attach_id = attachment_url_to_postid($save_fileurl);
					$_use_files[$key]['url'] 	= $save_fileurl;
					$_use_files[$key]['id'] 	= $attach_id;	
				}
			}
			

			$br_count = 2;
			$note_body = preg_split("/\R{{$br_count},}/", esc_attr($_POST['note_body']) ); // とりあえず行に分割
			$note_body = array_map('trim', $note_body); // 各行にtrim()をかける
			$note_body = array_filter($note_body, 'strlen'); // 文字数が0の行を取り除く
			$note_body = array_values($note_body); // これはキーを連番に振りなおしてるだけ
			
			//echo '<pre>note_body'; print_r($note_body); echo '</pre>';
			//echo '<pre>_use_files'; print_r($_use_files); echo '</pre>';
			
			$_insert_text = create_salonote_body($note_body , $_use_files);
			
			
			//echo $note_body[0];
			
			insert_salonote_note($_insert_text);
			
			//アイキャッチを登録
			if(!empty ($_use_files) ){
				set_post_thumbnail( $insert_id, $_use_files[0]['id'] );
				
				if( $_POST['post_style'] === 'keyv-landing' ){
					update_post_meta( $insert_id, 'page_bkg_upload_images', $_use_files[0]['id'] );
						$excerpt_arr = array(
								'ID'           => $insert_id,
								'post_excerpt' => !empty($note_body[0]) ? esc_html($note_body[0]) : 'new title'
						);
						wp_update_post( $excerpt_arr );
				}
			}

			
		}else{
			echo 'error';
			exit( '不正な遷移です' );
		}

		
		$post_custom = get_post_custom($insert_id);
		//echo '<pre>post_custom'; print_r($post_custom); echo '</pre>';
		//echo '<a href="'. get_post_permalink($insert_id)  .'">'.get_the_title($insert_id).'</a>';
		
		wp_safe_redirect( get_post_permalink($insert_id) );
		exit();
	}else{
	
	global $post;
	$post_type = null;

	?>
	<form method="post" action="#note" enctype="multipart/form-data" data-persist="garlic">
	<div class="container col-12 row mt-5">
	

		<?php wp_nonce_field( 'add_OMAKASE_ESSENCE_post', 'nonce_note_essence' ); ?>
		<input type="hidden" name="note" value="1">
		
		
		
		<div class="col-12 col-md-6 form-control-checkbox mb-5">
			
			<?php
				if( !empty($_POST) && !empty($_POST['post_id']) ){
					$post = get_post($_POST['post_id']);
					$post_type = get_post_type($_POST['post_id']);
					echo '
					<div id="post_target_field" class="form-group row mt-3" style="display : none;">
					<label for="post_title" class="col-sm-3 col-form-label text-left">編集するページ</label>
					<div class="col-sm-9 text-left">
						<input class="form-control" type="text" value="'.get_the_title($_POST['post_id']).'" readonly>
						<input class="form-control" type="hidden" name="post_id" value="'.$_POST['post_id'].'">
						<input type="hidden" name="edit_post_type" value="'.$post_type.'">
					</div>
					</div>';
				}
			?>
			
			
			
			<div id="post_title_field" class="form-group row mt-3">
				<label for="post_title" class="col-sm-3 col-form-label text-left">タイトル</label>
				<div class="col-sm-9 text-left">
					<input class="form-control" type="text" name="post_title" value="" id="post_title">
				</div>
			</div>
			
			<div class="form-group row mt-3">
				<label for="post_new" class="col-sm-3 col-form-label text-left">新規投稿</label>
				<div class="col-sm-9 text-left">
					<input class="form-check-input" type="checkbox" id="post_new" name="post_new" value="1" checked>
				</div>	
			</div>
			
			<div id="post_type_field" class="form-group row mt-3">
				<label for="post_type" class="col-sm-3 col-form-label text-left">投稿タイプ</label>
				<div class="col-sm-9">
				<?php
				$args = array(
					 'public'   => true,
					 '_builtin' => false
				);

				$post_types = get_post_types( $args, 'names' );
				
				array_push($post_types, "page");
				array_push($post_types, "post");
		
				echo '<select name="post_type" class="form-control">';

				foreach ( array_reverse($post_types) as $post_type_name ) {
					if( !empty($post_type_name) && $post_type_name !== 'front_page' ){
						$post_type_label = !empty(get_post_type_object($post_type_name)->labels->singular_name) ? get_post_type_object($post_type_name)->labels->singular_name : null ;
					}
					if( empty($post_type_label) ) continue;

					echo '<option value="'.$post_type_name.'"';
					if( 'post' === $post_type_name ){
						echo ' selected';
					}
					echo'>'.$post_type_label.'</option>';
				}

				echo '</select>';

				?>
				</div>
			</div>
			
		</div>
		
		<?php
		$template = get_page_template_slug($_POST['post_id']);
		?>
		<div class="col-12 col-md-6 form-control-checkbox mb-5">
				<div id="post_style_field" class="form-group row mt-3">
				<label for="post_style" class="col-sm-3 col-form-label text-left">スタイル</label>
				<div class="col-sm-9">
					<select class="form-control" id="post_style" name="post_style">
						<option value="simple_blog">シンプルブログ</option>
						<option value="left_right">左右振り分け</option>
						<option value="keyv-landing">キービジュアルランディング</option>
						<option value="character">キャラクター会話</option>
					</select>
			</div>
		</div>
			
		</div>
		

		
		<div class="col-12 col-md-7 mb-5">
			<textarea rows="20" class="form-control" name="note_body"><?php echo !empty($post->post_content) ? strip_tags($post->post_content) : '' ;?></textarea>
		</div>

		<div class="col-12 col-md-5 mb-5">
			<div class="imagePreview"></div>
			<div class="input-group">
					<label class="input-group-btn">
							<span class="btn btn-primary">
									ファイルを選択
								<input id="note_images" name="note_images[]" type="file" multiple="multiple" style="display:none" class="uploadFile" accept="image/*">
							</span>
					</label>
					<input id="form-input-note_images" type="text" class="form-control" readonly="">
					<input type="hidden" name="file_label" value="" />
<br>
					<table id="uploadedfiles" class="table table-striped">
							<tr><th>Image</th><th>Name</th><th>Size</th><th>Actions</th></tr>
					</table>
				
			</div>
		</div>
		
		
		<div class="col-12 text-center">
			<button class="btn-item" type="submit" value="投稿">投稿</button>
		</div>
	
	</div>
	</form>

	<?php
	}
	remove_action('error_page_action','note_essence',10);
}
add_action('error_page_action','note_essence',9);



add_action('wp_footer', 'footer_note_action',99);
function footer_note_action(){
	global $post;
	
	if( current_user_can('edit_posts') ){
		echo '
		<form id="omakase-essence-write-form" action="'.get_home_url().'/note_essence/" method="post">
			<input type="hidden" name="post_id" value="'. (isset($post->ID) ? $post->ID : '' ) .'">
			<button id="omakase-essence-write-btn" name="note" value="1"><span class="dashicons dashicons-edit"></span></button>
		</form>';
	}

	
	global $post;
	if( empty( $_POST['note']) ) return;
	
	?>
<script>
$(document).ready(function() {

	
	$('#post_new').on('change', function(e) {
		if( $(this).prop('checked') ){
			$('#post_type_field').show('fast');
			$('#post_target_field').hide('fast');
			$('#post_title_field').show('fast');
		}else{
			$('#post_type_field').hide('fast');
			$('#post_target_field').show('fast');
			$('#post_title_field').hide('fast');
			
		}
	});

	var storedFiles = [];      
	$('#note_images').on('change', function() {
			$('#note_images').html('');
			var myfiles = document.getElementById('note_images');
			var files = myfiles.files;
			var i=0;
			for (i = 0; i<files.length; i++) {
					var readImg = new FileReader();
					var file=files[i];
					if(file.type.match('image.*')){
							storedFiles.push(file);
							readImg.onload = (function(file) {
									return function(e) {
											$('#uploadedfiles').append('<tr class="imageinfo"><td><img width="80" height="70" src="'+e.target.result+'"/></td><td>'+file.name+'</td><td>'+Math.round((file.size/1024))+'KB</td><td><a href="" class="lnkcancelimage" file="'+file.name+'" title="Cancel">X</a></td></tr>');
									};
							})(file);
							readImg.readAsDataURL(file);
					}else{
							alert('the file '+file.name+' is not an image<br/>');
					}
			}
	});

	$('#uploadedfiles').on('click','a.lnkcancelimage',function(){
			$(this).parent().parent().html('');
			var file=$(this).attr('file');
			for(var i=0;i<storedFiles.length;i++) {
					if(storedFiles[i].name == file) {
							storedFiles.splice(i,1);
							break;
					}
			}
			return false;
	});


});
</script>


<?php

	remove_action('wp_footer','footer_note_action');
	
};


?>