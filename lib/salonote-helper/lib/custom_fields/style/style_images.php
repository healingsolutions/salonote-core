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

add_action("admin_init", "essence_style_images_metaboxs_init");
function essence_style_images_metaboxs_init(){
    add_meta_box( 'style_images_upload', 'スタイルギャラリー', 'style_images_upload_postmeta', 'style', 'normal','low' );
    add_action('save_post', 'save_style_images_upload_postmeta');
}
  
   
function style_images_upload_postmeta(){
	
	
	
	global $post;
	$post_id = $post->ID;
	$style_images_upload_images = get_post_meta( $post_id, 'style_images_upload_images', true );

	//初期化
	$style_images_upload_li = '';

	if( !empty($style_images_upload_images) ){

		foreach( $style_images_upload_images as $key => $image ){
				$thumb_src = wp_get_attachment_image_src ($image,'thumbnail_M');
				if( empty($thumb_src[0]) ){
					$thumb_src = wp_get_attachment_image_src ($image,'full');
				}
				if ( empty ($thumb_src[0]) ){
						//delete_post_meta( $post_id, 'style_images_upload_images', $img_id );
					$thumb_src[0] = wp_get_attachment_url($image);
				}
				if ( !empty ($thumb_src[0]) )
					{
						$style_images_upload_li.= '<div class="salonote_images_img_wrap">';
						$style_images_upload_li.= 
						'
							<a href="#" class="salonote_images_upload_images_remove" title="画像を削除する"></a>
							<img src="'.$thumb_src[0].')">
							<input type="hidden" name="style_images_upload_images[]" value="'.$image.'" />
						';
						$style_images_upload_li.= '</div>';
				}
		}
		
		
		

				
	}
?>

<script>
$( function() {
	$( "#style_images_upload_images" ).sortable();
	$( "#style_images_upload_images" ).disableSelection();
} );
</script>

<div id="salonote_images_upload_buttons"<?php
	//if ( !empty ($thumb_src[0]) ) echo ' style="display:none;"'
	?>>
    <a id="salonote_images_upload_media" type="button" class="button" title="画像を追加">画像を追加</a>
</div>
<div id="style_images_upload_images" class="salonote_images_upload_images-unit">
<?php echo $style_images_upload_li; ?>
</div>


<input type="hidden" name="style_images_upload_postmeta_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />



<script>
// JavaScript Document

jQuery( function(){
    var custom_uploader;
	
		//アップローダー起動
    jQuery('#salonote_images_upload_media').click(function(e) {
        e.preventDefault();
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media({
            title: _wpMediaViewsL10n.mediaLibraryTitle,
            library: {
                type: ''
            },
            button: {
                text: '画像を選択'
            },
            multiple: true,
            frame: 'select',
            editing: false,
        }); 
  
 
        custom_uploader.on('ready', function() {
           // jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
        });
        custom_uploader.on('select', function() {
            var images = custom_uploader.state().get('selection');
						images.each(function( file ){
							
							console.log(file);
                new_id = file.toJSON().id;
								file_src = file.attributes.url;
								thumbnail_src = file.attributes.sizes.thumbnail_M.url;

							
							$('#style_images_upload_images').append(
									'<div class="salonote_images_img_wrap">' +
									'<a href="#" class="salonote_images_upload_images_remove" title="画像を削除する"></a>' +
									'<img src="'+thumbnail_src+')">' +
									'<input type="hidden" name="style_images_upload_images[]" value="'+new_id+'" />' +
									'</div>'
							);
							
							$('#salonote_images_upload_buttons').hide();
							
						})
        });
        custom_uploader.open();
    });
	
	
    jQuery( ".salonote_images_upload_images_remove" ).live( 'click', function( e ) {
        e.preventDefault();
        e.stopPropagation();
        img_obj = jQuery(this).parents('.salonote_images_img_wrap').remove(),
					$('#salonote_images_upload_buttons').show();
    });
	


});
</script>


<?php }
   

function save_style_images_upload_postmeta( $post_id ){
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	
	if ( empty($_POST['style_images_upload_postmeta_nonce']) )
		return $post_id;
	
	if ( !wp_verify_nonce($_POST['style_images_upload_postmeta_nonce'], basename(__FILE__)))
		return $post_id;
	
	if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	} else {
			if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}
	
	$new_images = isset($_POST['style_images_upload_images']) ? $_POST['style_images_upload_images']: null;
	$ex_images = get_post_meta( $post_id, 'style_images_upload_images', true );
	if ( $ex_images !== $new_images ){
			if ( $new_images ){
					update_post_meta( $post_id, 'style_images_upload_images', $new_images );
			} else {
					delete_post_meta( $post_id, 'style_images_upload_images', $ex_images ); 
			}
	}

}



function stylist_field(){
	
	$content_text = '';
	
	$auther_ID = get_the_author_meta('ID');
	if( get_avatar($auther_ID, 80) ){
			$auther_image = get_avatar( $auther_ID, 100, false, get_the_title() .'のスタイリスト-' .get_the_author_meta('display_name') );
			$auther_url 	= get_author_posts_url( $auther_ID);
	}
	if( isset($auther_image) ){
			$content_text .= '<div class="style_stylist-image post-avatar">';
			$content_text .= '<a href="'. $auther_url .'">' .$auther_image. '</a><p>STYLIST: '.get_the_author_meta('display_name').'</p>';
			$content_text .= '</div>';
	}
	
	
	$style_fields_value = get_post_meta(get_the_ID(),'style_fields',true);
	if( !empty($style_fields_value) ){

		$style_fields_arr = array(
			'length'				=> __('長さ','salonote-essence'),
			'image'					=> __('イメージ','salonote-essence'),
			'color'					=> __('カラー','salonote-essence'),
			'perma'					=> __('パーマ','salonote-essence'),
			'comment'				=> __('ポイント','salonote-essence'),
		);

		$content_text .= '<div class="style_styleinfo-block"><table class="table table-striped"><tbody>';
		foreach($style_fields_arr as $key => $value){
			$style_key = 'style_'.$key;
			if( empty($style_fields_value[$style_key]) ) continue;
			$content_text .= '<tr><th>'.$style_fields_arr[$key].'</th><td>'.$style_fields_value[$style_key].'</td></tr>';
		}
		$content_text .= '</tbody></table></div>';
	}
	
	return $content_text;
}

function print_style_images( $content ){
	global $post_type;
	if( $post_type !== 'style' || !is_main_query() || !is_singular()) return $content;
	
	$attachment_images = get_attached_media( 'image', get_the_ID() );
	
	if( !$attachment_images ) return $content;

	$content_text = '';
	
	$content_text .= '<div class="style_gallery_wrap gallery_group">';
	foreach( $attachment_images as $image ){
		
		$img_src = wp_get_attachment_image_src ($image->ID,'full');

		$thumb_src = wp_get_attachment_image_src ($image->ID,'thumbnail_M');
		if( empty($thumb_src[0]) ){
			$thumb_src = wp_get_attachment_image_src ($image->ID,'full');
		}
		if ( empty ($thumb_src[0]) ){
			continue;
		}
		
		
		
		$attachment = get_post( $image->ID );
		$content_text .= '<div class="style_gallery_item"><a class="colorbox" href="'. $img_src[0] .'"><img src="'.$thumb_src[0].')" alt="'.$attachment->post_excerpt.'-'.$image->ID.'" title="'.$attachment->post_excerpt.'"></a></div>';
	}
	$content_text .= '</div>';
	
	
	$content_text .= $content;
	
	$content_text .= stylist_field();
	
	remove_filter('the_content','print_style_images');
	return $content_text;
}
add_filter('the_content','print_style_images',11);



function print_style_excerpt($excerpt){
	global $post_type;
	if( $post_type !== 'style' || !is_main_query() || !is_singular()) return $excerpt;
	
	if (has_filter( 'the_content', 'print_style_images' ))
	{
			remove_filter( 'the_content', 'print_style_images' ); // if this filter got priority different from 10 (default), you need to specify it
	}
	
	$excerpt_text = $excerpt;
	
	$excerpt_text .= '<div class="style_stylist-block">';
	$excerpt_text .= stylist_field();
	
	remove_filter('get_the_excerpt','print_style_excerpt');
	return $excerpt_text;
	
}
add_filter('get_the_excerpt','print_style_excerpt');





?>
