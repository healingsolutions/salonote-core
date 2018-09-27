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
	
	if( !is_singular() ) return;
	if( empty( $_GET['note']) ) return;
	if( !current_user_can('edit_posts') ) return $content;
	wp_enqueue_script('jquery','//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '3.2.1', true);
	wp_enqueue_style('essence', get_template_directory_uri().'/style-min.css', array(), $_salonote_ver);
	wp_enqueue_script('essence', get_template_directory_uri().'/statics/js/main-min.js', array(), $_salonote_ver ,true);

}
add_action( 'admin_enqueue_scripts', 'note_essence_public_style' ); //公開用のCSS



function note_essence($content){
	if( !is_singular() ) return;
	if( empty( $_GET['note']) ) return $content;
	if( !current_user_can('edit_posts') ) return $content;
	
	
	//echo '<pre>note_body'; print_r($_FILES); echo '</pre>';
	
	if( !empty($_POST['nonce_note_essence']) ){
		//CSRF対策用のチェック
		if(wp_verify_nonce($_POST['nonce_note_essence'], 'add_note_essence_post')){
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
				$save_folder 	= $_up_dir['basedir'] . '/tmp/';
				$save_url 		= $_up_dir['baseurl'] . '/tmp/';
				
				// 保存先フォルダの作成する。
				if (!file_exists($save_folder)) {
						mkdir($save_folder);
				}
				
				$_use_files = [];
				
				
				foreach( $_file_data as $key => $image_item ){
					if(is_uploaded_file($image_item['tmp_name'])){
						
						//$name = basename($image_item['tmp_name']);
						$_file_name = base64_encode($image_item['name']).'.'.pathinfo($image_item['name'], PATHINFO_EXTENSION);
						$save_filename = $save_folder . $_file_name;
						
						$_use_files[] = $save_url.$_file_name;
						
						//画像ファイルが無い時は取得
						if (!file_exists($save_filename)) {
							if(move_uploaded_file( $image_item['tmp_name'], $save_filename)){
									//echo "uploaded";
								
							}else{
									echo "error while saving.";
							}
						}else{
							//echo 'already uploaded.';
						}

					}else{
							echo "file not uploaded.";
					}
				}
			}
			

			$note_body = preg_split("/\R{2,}/", esc_attr($_POST['note_body']) ); // とりあえず行に分割
			$note_body = array_map('trim', $note_body); // 各行にtrim()をかける
			$note_body = array_filter($note_body, 'strlen'); // 文字数が0の行を取り除く
			$note_body = array_values($note_body); // これはキーを連番に振りなおしてるだけ
			
			//echo '<pre>note_body'; print_r($note_body); echo '</pre>';
			//echo '<pre>_use_files'; print_r($_use_files); echo '</pre>';
			
			$_insert_text = create_salonote_body($note_body , $_use_files);
			insert_salonote_note($_insert_text);
			
			
		}else{
			echo 'error';
			exit( '不正な遷移です' );
		}
		
		//wp_safe_redirect( get_post_permalink() );
		//return;
	}else{
	
	global $post;

	?>
	<form method="post" action="#thanks" enctype="multipart/form-data" data-persist="garlic">
	<div class="container col-12 row">
	

		<?php wp_nonce_field( 'add_note_essence_post', 'nonce_note_essence' ); ?>
		<input type="hidden" name="post_id" value="<?php echo $post->ID;?>">

		<div class="col-12 col-md-7 mb-5">
			<textarea rows="20" class="form-control" name="note_body"><?php echo $post->post_content ;?></textarea>
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
		
		
		<div class="text-center">
	<button class="btn-item" type="submit" value="投稿">投稿</button>
			</div>
	
	</div>
	</form>

	<?php
	}
}
add_action('the_content','note_essence',9);



add_action('wp_footer', function () {
	
	if( !is_singular() )
		return;
	
	global $post;
	if( empty( $_GET['note']) ) return;
	
	?>
<script>
$(document).ready(function() {
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
	
},99);


?>