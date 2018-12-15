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




function note_essence_public_style(){

	if( empty( $_GET['note']) ) return;
	if( !current_user_can('edit_posts') ) return $content;
	//if ( !is_admin_bar_showing() )  return $content;
	
	wp_enqueue_script('jQuery');
	wp_enqueue_style('wp-admin');
	wp_enqueue_media();
	
	wp_enqueue_style('note-essence', NOTE_ESSENCE_PLUGIN_URI.'/statics/css/style-min.css', array(), '1.0.0');
	wp_enqueue_script('note-essence', NOTE_ESSENCE_PLUGIN_URI.'/statics/js/main-min.js', array(), '1.0.0' ,true);
	
	wp_enqueue_style('upload_images-essence', get_template_directory_uri().'/statics/css/upload-images.css', array(), '1.0.0');
	wp_enqueue_script('upload_images-essence', get_template_directory_uri().'/statics/js/upload_images-min.js', array(), '1.0.0' ,true);
}
add_action( 'wp_enqueue_scripts', 'note_essence_public_style' ); //公開用のCSS



function posted_note_essence(){
	

  if( empty( $_POST['note']) ) return;
	if( !current_user_can('edit_posts') ) return;
	//if ( !is_admin_bar_showing() ) return;
	
	global $post;
	global $post_id;
	global $insert_id;
	
	if( empty( $_POST['post_new'])){
		$post_id = !empty( $_POST['post_id'] ) ? $_POST['post_id'] : null ;
	}else{
		$post_id = null;
	}

	if( !empty($_POST['nonce_note_essence']) ){
		//CSRF対策用のチェック
		if(wp_verify_nonce($_POST['nonce_note_essence'], 'add_note_essence_post')){
			//echo 'success';

			$_use_files = [];
			if( !empty($_POST['note_images']) ){
				foreach( $_POST['note_images'] as $attach_key => $attach_id ){
					$_use_files[$attach_key]['id'] 		= $attach_id;
					$_use_files[$attach_key]['url'] 	= wp_get_attachment_url($attach_id);
				}
			}

			$note_body = br2array( $_POST['note_body'], 2 );// value , count
			
			//echo '<pre>note_body'; print_r($note_body); echo '</pre>';
			//echo '<pre>_use_files'; print_r($_use_files); echo '</pre>';
			
			//$note_body = mb_convert_encoding($note_body, bloginfo('charset'), "auto");
			
			if( function_exists( 'use_block_editor_for_post' ) && use_block_editor_for_post( $post )) { 
				$_insert_text = create_salonote_gutenberg($note_body , $_use_files);
			}   
			else {
				$_insert_text = create_salonote_body($note_body , $_use_files);
			}   
			
			
			
			//echo $note_body[0];
			
			$insert_id = insert_salonote_note($_insert_text);
			
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
			
			
			//オプションを登録
			if( !empty($_POST['page_info'])){
				update_post_meta( $insert_id, 'page_info', $_POST['page_info'] );
			}
			

			
		}else{
			//echo 'error';
			exit( '不正な遷移です' );
		}

		
		//$post_custom = get_post_custom($insert_id);
		//echo '<pre>post_custom'; print_r($post_custom); echo '</pre>';
		//echo '<a href="'. get_post_permalink($insert_id)  .'">'.get_the_title($insert_id).'-'.$insert_id.'</a>';
		
		/**/
		wp_safe_redirect( get_post_permalink($insert_id) );
		exit();
    die;
		
	}
}
add_action( 'template_redirect', 'posted_note_essence' );



add_filter( 'body_class', 'note_essence_class_names' );
function note_essence_class_names( $classes ) {
	
	if( !empty( $_GET['note']) ){
		$classes[] = 'note_essence_form';
	}
	
	return $classes;
}


function note_essence($content){
	
	
	if( empty( $_GET['note']) ) return $content;
	if( !current_user_can('edit_posts') ) return $content;
	//if ( !is_admin_bar_showing() ) return;
	

	global $post;
	$post_type = null;
	
	$post_id = !empty($_GET['post_id']) ? esc_attr($_GET['post_id']) : null ;

	?>
	<form method="post" action="<?php echo get_the_permalink($post_id); ?>" enctype="multipart/form-data" data-persist="garlic">
	<div class="container col-12 row mt-5">
	

		<?php wp_nonce_field( 'add_note_essence_post', 'nonce_note_essence' ); ?>
		<input type="hidden" name="note" value="1">
		
		
		
		<div class="col-12 col-md-6 note_post_fields mb-5">
			
			<?php
				if( !empty($post_id) ){
					$post = get_post($post_id);
					$post_type = get_post_type($post_id);
					echo '
					<div id="post_target_field" class="form-group row mt-3" style="display : none;">
					<label for="post_title" class="col-sm-3 col-form-label text-left">編集するページ</label>
					<div class="col-sm-9 text-left">
						<input class="form-control" type="text" value="'.get_the_title($post_id).'" readonly>
						<input class="form-control" type="hidden" name="post_id" value="'.$post_id.'">
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
		$template = get_page_template_slug($post_id);
		?>
		<div class="col-12 col-md-6 note_post_fields mb-5">
			
				<div id="post_style_field" class="form-group row mt-3">
						<label for="post_style" class="col-sm-3 col-form-label text-left">スタイル</label>
						<div class="col-sm-9">
							<select class="form-control" id="post_style" name="post_style">
								<option value="simple_blog">シンプルブログ</option>
								<option value="left_right">左右振り分け</option>
								<option value="left_image">左に画像</option>
								<option value="right_image">右に画像</option>
								<option value="keyv-landing">キービジュアルランディング</option>
								<option value="character">キャラクター会話</option>
							</select>
					</div>
				</div>
			
				<div id="post_option_field" class="form-group row mt-3">
						<label for="post_style" class="col-sm-3 col-form-label text-left">オプション</label>
						<div class="col-sm-9 text-left">
							<div class="form-group">
								
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="post_option_full_size" name="page_info[full_size]" value="1">
									<label class="form-check-label ml-3" for="post_option_full_size">全画面表示</label>
								</div>
								
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="post_option_none_sidebar" name="page_info[none_sidebar]" value="1">
									<label class="form-check-label ml-3" for="post_option_none_sidebar">メインのみ</label>
								</div>
								
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="post_option_super_container" name="page_info[super_container]" value="1">
									<label class="form-check-label ml-3" for="post_option_super_container">コンテンツの幅を狭める</label>
								</div>
								
							</div>

					</div>
				</div>
			
			
		</div>
		

		
		<div class="col-12 col-md-7 mb-5">
			<textarea rows="20" class="form-control" name="note_body"><?php echo !empty($post->post_content) ? strip_tags($post->post_content) : '' ;?></textarea>
		</div>

		<div class="col-12 col-md-5 mb-5">
			
			
<?php	
	$custom_text = '';
	$upload_images = !empty($opt_values['upload_images']) ?$opt_values['upload_images'] : null;
	if(is_user_logged_in()){
		//echo '<pre>upload_images'; print_r($upload_images); echo '</pre>';
	}

	if( $upload_images ){
		foreach( $upload_images as $key => $item ){
			$custom_text .= '<li class="upload_images_wrap" id=img_'.$item.'>
			<div class="upload_images_item">
			<a href="#" class="upload_images_remove" title="画像を削除する"><span class="dashicons dashicons-dismiss"></span></a><div class="upload_images_bkg">'.wp_get_attachment_image( $item, 'thumbnail' ) .'
			<input type="hidden" name="note_images[]" value="'.$item.'" />
			</div></div>
			</li>';
		}
	}

		echo '
		<div class="image-upload-wrap">
			<ul class="image-preview-wrapper upload_images">'.preg_replace('/(?:\n|\r|\r\n)/', '', $custom_text ).'</ul>
			<input id="upload_image_button-1" type="button" class="btn btn-item upload_image_button" rel="multiple" data-name="note_images" data-parent="'.$post_id.'" value="画像アップロード" />
		</div>
		';

?>

		</div>
		
		
		<div class="col-12 text-center">
			<button class="btn btn-item" type="submit" value="投稿">投稿</button>
		</div>
	
	</div>
	</form>

	<?php
	remove_action('error_page_action','note_essence',10);
}
add_action('error_page_action','note_essence',9);




function toolbar_link_to_mypage( $wp_admin_bar ) {
	if( current_user_can('edit_posts') ){
		global $post;
		
		$args = array(
			'id'    => 'note-essence',
			'title' => '<span class="ab-icon dashicons dashicons-book-alt"></span><span class="ab-label">シンプル投稿</span>',
			'href'  => get_home_url().'/note_essence/?post_id='. (isset($post->ID) ? $post->ID : '' ).'&note=true',
		);
		$wp_admin_bar->add_node( $args );
		
		}
	}
add_action( 'admin_bar_menu', 'toolbar_link_to_mypage', 90 );


?>