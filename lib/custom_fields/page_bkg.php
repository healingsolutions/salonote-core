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

add_action("admin_init", "essence_page_bkg_metaboxs_init");
function essence_page_bkg_metaboxs_init(){
    add_meta_box( 'page_bkg_upload', 'ページ画像', 'page_bkg_upload_postmeta', 'page', 'side','low' );
    add_action('save_post', 'save_page_bkg_upload_postmeta');
}
  
   
function page_bkg_upload_postmeta(){
	global $post;
	$post_id = $post->ID;
	$page_bkg_upload_images = get_post_meta( $post_id, 'page_bkg_upload_images', true );

	//初期化
	$page_bkg_upload_li = '';

	if( !empty($page_bkg_upload_images) ){

				$thumb_src = wp_get_attachment_image_src ($page_bkg_upload_images,'large');
				if( empty($thumb_src) ){
					$thumb_src = wp_get_attachment_image_src ($page_bkg_upload_images,'full');
				}
				if ( empty ($thumb_src) ){
						//delete_post_meta( $post_id, 'page_bkg_upload_images', $img_id );
					$thumb_src[0] = wp_get_attachment_url($page_bkg_upload_images);
				}

		
				if ( !empty ($thumb_src[0]) )
					{
						$page_bkg_upload_li.= 
						'
						<div id="page_bkg_img_wrap">
							<a href="#" class="page_bkg_upload_images_remove" title="画像を削除する"></a>
							<img src="'.$thumb_src[0].')">
							<input type="hidden" name="page_bkg_upload_images" value="'.$page_bkg_upload_images.'" />
						</div>
						';
				}
	}
?>


<div id="page_bkg_upload_buttons"<?php
	if ( !empty ($thumb_src[0]) ) echo ' style="display:none;"'
	?>>
    <a id="page_bkg_upload_media" type="button" class="button" title="画像を追加">画像を追加</a>
</div>
<div id="page_bkg_upload_images">
<?php echo $page_bkg_upload_li; ?>
</div>


<input type="hidden" name="page_bkg_upload_postmeta_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />



<script>
// JavaScript Document

jQuery( function(){
    var custom_uploader;
	
		//アップローダー起動
    jQuery('#page_bkg_upload_media').click(function(e) {
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
            multiple: false,
            frame: 'select',
            editing: false,
        }); 
  
 
        custom_uploader.on('ready', function() {
           // jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
        });
        custom_uploader.on('select', function() {
            var images = custom_uploader.state().get('selection');
						images.each(function( file ){
                new_id = file.toJSON().id;
								file_src = file.attributes.url;

							
							$('#page_bkg_upload_images').append(
									'<div id="page_bkg_img_wrap">' +
									'<a href="#" class="page_bkg_upload_images_remove" title="画像を削除する"></a>' +
									'<img src="'+file_src+')">' +
									'<input type="hidden" name="page_bkg_upload_images" value="'+new_id+'" />' +
									'</div>'
							);
							
							$('#page_bkg_upload_buttons').hide();
							
						})
        });
        custom_uploader.open();
    });
	
	
    jQuery( ".page_bkg_upload_images_remove" ).live( 'click', function( e ) {
        e.preventDefault();
        e.stopPropagation();
        img_obj = jQuery(this).parents('#page_bkg_img_wrap').remove(),
					$('#page_bkg_upload_buttons').show();
    });

});
</script>


<?php }
   

function save_page_bkg_upload_postmeta( $post_id ){
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	
	if ( empty($_POST['page_bkg_upload_postmeta_nonce']) )
		return $post_id;
	
	if ( !wp_verify_nonce($_POST['page_bkg_upload_postmeta_nonce'], basename(__FILE__)))
		return $post_id;
	
	if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	} else {
			if ( !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
	}
	
	$new_images = isset($_POST['page_bkg_upload_images']) ? $_POST['page_bkg_upload_images']: null;
	$ex_images = get_post_meta( $post_id, 'page_bkg_upload_images', true );
	if ( $ex_images !== $new_images ){
			if ( $new_images ){
					update_post_meta( $post_id, 'page_bkg_upload_images', $new_images );
			} else {
					delete_post_meta( $post_id, 'page_bkg_upload_images', $ex_images ); 
			}
	}

}
?>
