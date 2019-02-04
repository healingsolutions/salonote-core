<?php



//set thumbnail
add_theme_support('post-thumbnails');
set_post_thumbnail_size('750,180,true'); 



function customize_admin_manage_posts_columns($columns) {
    $columns['thumbnail'] = __('Thumbnail','salonote-essence');
    return $columns;
}
function customize_admin_add_column($column_name, $post_id) {
    global $post_type;
        if ( 'thumbnail' == $column_name) {
            $thum = get_the_post_thumbnail($post_id, 'LargeThumb', array( 'style'=>'width:120px;height:auto;' ));
    }
  
    if ( isset($thum) && $thum ) {
        echo $thum;
    }
}



function customize_admin_css_list() {
    echo '<style type="text/css">.column-thumbnail{width:120px;}</style>';
}
add_filter( 'manage_posts_columns', 'customize_admin_manage_posts_columns' );
add_action( 'manage_posts_custom_column', 'customize_admin_add_column', 10, 2 );
add_action('admin_print_styles', 'customize_admin_css_list', 21);






function customize_admin_manage_pages_columns($columns) {
    $columns['thumbnail'] = __('Thumbnail','salonote-essence');
    return $columns;
}

function customize_pages_add_column($column_name) {
		$thum = '';
    if ( 'thumbnail' == $column_name) {
        $post_id = isset( $post_id) ? $post_id : null;
        $thum .= get_the_post_thumbnail($post_id, 'LargeThumb', array( 'style'=>'width:120px;height:auto;' ));
    }

    if ( isset($thum) && $thum ) {
        echo $thum;
    }
}
add_filter('manage_pages_columns', 'customize_admin_manage_pages_columns');
add_action('manage_pages_custom_column', 'customize_pages_add_column');


//editor class
function set_image_tag_class($class){
	return $class . ' img-responsive wow fadeIn';
}
add_filter('get_image_tag_class','set_image_tag_class',10);


/*
//lazy load
function customize_img_attribute( $content ) {
  $re_content = str_replace('alt=""', 'alt="image-'.wp_title('',false).'"', $content);
	
	//lazy load
	global $theme_opt;
	if( !empty($theme_opt['extention']) && in_array('use_lazy_load',$theme_opt['extention']) ){
		return str_replace('class="', 'class="lazy ', $re_content);
	};
  return $re_content;
}
add_filter('the_content','customize_img_attribute');
*/



/*-------------------------------------------*/
/*	add thumbnail sizes
/*-------------------------------------------*/

add_image_size('thumbnail_M', 350, 350,true);
add_image_size('thumbnail_L', 600, 600, true);
add_image_size('medium_banner', 468, 0, false);
add_image_size('side_banner', 350, 0, false);
add_image_size('profile', 450, 800, true);
add_image_size('profile_s', 250, 450, true);
//add_image_size('small_thumb', 250, 0, false);

global $essence_custom_image_sizes;
$essence_custom_image_sizes = array(
		'thumbnail_L' => array(
				'name'       => __('thumbnail_L','salonote-essence'),
				'width'      => 600,
				'height'     => 600,
				'crop'       => true,
				'selectable' => true
		),
		'thumbnail_M' => array(
				'name'       => __('thumbnail_M','salonote-essence'),
				'width'      => 350,
				'height'     => 350,
				'crop'       => true,
				'selectable' => true
		),
		'medium_large' => array(
				'name'       => __('medium_large','salonote-essence'),
				'width'      => 768,
				'height'     => 0,
				'crop'       => false,
				'selectable' => true
		),
		'medium_banner' => array(
				'name'       => __('medium_banner','salonote-essence'),
				'width'      => 468,
				'height'     => 0,
				'crop'       => false,
				'selectable' => true
		),
		'profile' => array(
				'name'       => __('profile','salonote-essence'),
				'width'      => 450,
				'height'     => 800,
				'crop'       => true,
				'selectable' => true
		),
		'profile_S' => array(
				'name'       => __('profile_S','salonote-essence'),
				'width'      => 250,
				'height'     => 450,
				'crop'       => true,
				'selectable' => true
		),
);

function add_custom_image_sizes( $essence_custom_image_sizes ) {
    global $essence_custom_image_sizes;
    
    foreach ( $essence_custom_image_sizes as $slug => $size ) {
        add_image_size( $slug, $size['width'], $size['height'], $size['crop'] );
    }
}
add_action( 'after_setup_theme', 'add_custom_image_sizes');

 

function add_custom_image_size_select( $size_names ) {
    global $essence_custom_image_sizes;
    $custom_sizes = get_intermediate_image_sizes();
    foreach ( $custom_sizes as $custom_size ) {
        if ( isset( $essence_custom_image_sizes[$custom_size]['selectable'] ) && $essence_custom_image_sizes[$custom_size]['selectable'] ) {
            $size_names[$custom_size] = $essence_custom_image_sizes[$custom_size]['name'];
        }
    }
    return $size_names;
}

add_filter( 'image_size_names_choose', 'add_custom_image_size_select',10 );

/**
 * Set sizes atribute for responsive images and better performance
 * @param  array        $attr       markup attributes
 * @param  object       $attachment WP_Post image attachment post
 * @param  string|array $size       named image size or array
 * @return array        markup attributes
 */
function armd_resp_img_sizes( $attr, $attachment, $size ) {
	
	global $essence_custom_image_sizes;
	$custom_sizes = get_intermediate_image_sizes();
	foreach ( $custom_sizes as $custom_size ) {
			if ( isset( $essence_custom_image_sizes[$custom_size]['selectable'] ) && $essence_custom_image_sizes[$custom_size]['selectable'] ) {
				$attr['sizes'] = $essence_custom_image_sizes[$custom_size]['width'];
			}
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'armd_resp_img_sizes', 25, 3 );



/**
 * HTML Replacement - Support for a custom class attribute in the native gallery shortcode
 */
add_filter( 'post_gallery', function( $html, $attr, $instance )
{
    add_filter( 'gallery_style', function( $html ) use ( $attr )
    {
        if( isset( $attr['class'] ) && $class = $attr['class'] )
        {
            unset( $attr['class'] );

            // Modify & replace the current class attribute
            $html = str_replace( 
                "class='gallery ",
                sprintf( 
                    "class='gallery wpse-gallery-%s ",
                    esc_attr( $class )
                ),
                $html
            );
        }
        return $html;
    } );

    return $html;
}, 10 ,3 );


// default attachement size
add_action('admin_init', 'webshufu_default_noimagelink', 10);
function webshufu_default_noimagelink() {
  $webshufu_default_imagelink = get_option( 'image_default_link_type' );
  if ($webshufu_default_imagelink !== 'none') {
    update_option('image_default_link_type', 'none');
  }
}




//svg
function essence_ext2type($ext2types) {
    array_push($ext2types, array('image' => array('svg', 'svgz')));
    return $ext2types;
}
add_filter('ext2type', 'essence_ext2type');
  
function essence_mime_types($mimes){
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'essence_mime_types');
  
function essence_mime_to_ext($mime_to_ext) {
    $mime_to_ext['image/svg+xml'] = 'svg';
    return $mime_to_ext;
}
add_filter('getimagesize_mimes_to_exts', 'essence_mime_to_ext');



/*
//get_avatar
add_filter('get_avatar','add_gravatar_class');
function add_gravatar_class($class) {
    $class = str_replace('class="avatar', 'class="avatar img-circled img-responsive', $class);
    return $class;
}
*/



function set_attach_check(){
	$attach_check = [];
	return;
}
add_action( 'export_wp', 'set_attach_check' );


function add_attachement_url( $post ){
	global $post;
	global $attach_check;

	if( !has_post_thumbnail($post->ID) || !empty($attach_check[$post->ID]) ) return;
	
	$attach_check[$post->ID] = true;
	$thumb_url = get_the_post_thumbnail_url( $post->ID, 'full' );
	?>
		<wp:postmeta>
			<wp:meta_key><![CDATA[_thumbnail_url]]></wp:meta_key>
			<wp:meta_value><![CDATA[<?php echo $thumb_url; ?>]]></wp:meta_value>
		</wp:postmeta>
	<?php
	
	return;
}
add_action('wxr_export_skip_postmeta','add_attachement_url');



/*

function set_post_attachment(){
	
	global $post;

	$_custom = get_post_custom($post->ID);	
	
	if( !empty($_custom['_thumbnail_url']) ){
		set_new_attachment($_custom['_thumbnail_url'][0]);
	}
	
	return;
}
//add_action( 'template_redirect', 'set_post_attachment' );



function set_post_attachment_loop(){
	
	if( !empty($_GET) && $_GET['set_post_attachment'] ){
	
		$args = array(
			'post_type'				=> 'works',
			'posts_per_page'	=> -1,
			'meta_key' => '_thumbnail_url',
			'meta_value' => 'null',
			'meta_compare' => '!='
		);

		$posts = get_posts($args);

		
		if( $posts ){
			foreach( $posts as $post ){
				$_custom = get_post_custom($post->ID);	
				if( !empty($_custom['_thumbnail_url']) ){
					set_new_attachment($_custom['_thumbnail_url'][0],$post->ID);
				}
			}
			sleep(1);
			delete_post_meta( $post->ID, '_thumbnail_url', null );
			//echo 'wp_redirect: ' .get_post_permalink().'&?set_post_attachment=true';
			//return;
			
			echo '
			<script>
			jQuery(window).load(function () {
					location.reload();
			});
			</script>
			';
			
			return;
			
		}else{
			return 'all done.';
		}

	}
	
	return;
}
add_action( 'the_content', 'set_post_attachment_loop' );

add_filter('stylesheet_directory_uri',function(){
	return get_template_directory_uri();
});

*/


function set_new_attachment( $url,$id=null ){
	
	global $post;
	
	$id = $id ? $id : $post->ID ;
	
	if( empty($id) ) return;
	
	
	
	$pathData = pathinfo($url);
	$pattern = '/(.+?)\/wp-content\/uploads\//i';
	
	$_directory = preg_replace($pattern, '', $pathData['dirname']);
	$upload_dir = wp_upload_dir();


	//画像をサーバーに保存 =======================

	//保存するフォルダ名
	$save_folder = $upload_dir['basedir'].'/'.$_directory;

	//保存するファイル名
	$save_filename = $save_folder.'/'.$pathData['basename'];

	// 保存先フォルダの作成する。
	if (!file_exists($save_folder)) {
			mkdir($save_folder);
	}

	//画像ファイルが無い時は取得
	if (!file_exists($save_filename)) {
			$file_get_contents = file_get_contents($url);
			file_put_contents($save_folder,$file_get_contents);
	}

	$wp_filetype = wp_check_filetype($save_filename );
	$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => sanitize_file_name($pathData['basename']),
			'post_content' => '',
			'post_status' => 'inherit'
	);
	
	//アイキャッチを登録
	if(!empty ($attachment) ){
		$attach_id = wp_insert_attachment( $attachment, $save_filename, $id );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $save_filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		set_post_thumbnail( $id, $attach_id );
	}
	
	delete_post_meta( $id, '_thumbnail_url', null );
	
	return;
}


 function update_attachment_filename( $post_ID, $_thumbnail_url ) {

		if( isset( $post_ID ) && isset( $_thumbnail_url ) && is_readable($_thumbnail_url) ) {
				//echo '['. $_thumbnail_url .']';

				// Update attachment meta data
				$file_updated_meta = wp_generate_attachment_metadata( $post_ID, $_thumbnail_url );
				wp_update_attachment_metadata( $post_ID, $file_updated_meta );

		}
	 
	 return;

}
