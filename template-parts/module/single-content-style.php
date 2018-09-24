<?php
global $theme_opt;
global $post_type_name;
global $post_type_set;
global $page_info;

global $page;
global $paged;

$post_id = get_the_ID();

if( get_the_content() || has_post_thumbnail() ){
echo '<div class="entry_block_content';
if( has_post_thumbnail() ) echo ' has_thumbnail';
echo '">';
echo '<header>';


// title =======================================
if(
  !empty( $post_type_set ) &&
  in_array('display_entry_title',$post_type_set )&&
  empty( $page_info['disable_title'] )
){
	$_the_title = get_the_title();
	if( in_array('break_title',$theme_opt['base'])){
		$_the_title = preg_replace('/(\,|】|'.__(',','salonote-essence').')/', '$1<br />', $_the_title);
		$_the_title = preg_replace('/(~|〜)/', '<br /><span class="small">$1', $_the_title).'</span>';
	}
  echo '<h1 class="entry_block_title">'.$_the_title;
	
	//paged
  if( $paged >= 2 || $page >= 2 ){
		echo '<span class="entry_block_sub_title ml-3">'.max( $paged, $page ) . __(' page','salonote-essence').'目</span>';
  }
	
	echo '</h1>';
	
	
	
}

// sub_title =======================================
if(
  !empty( $post_type_set ) &&
  in_array('display_entry_sub_title',$post_type_set )
){
	
	$_sub_title = get_post_meta($post_id, 'subTitle',true);
	if( !empty($_sub_title) ){
		echo '<h2 class="entry_block_sub_title">'.$_sub_title.'</h2>';
	}
  
}


/*-------------------------------------------*/
/*	taxonomy_list
/*-------------------------------------------*/
get_template_part('template-parts/module/taxonomy_list');


echo '<div class="staff_page-block grid-inner row">';

	
// thumbnail =======================================
if(
  !empty( $post_type_set ) &&
  in_array('post_thumbnail',$post_type_set )&&
	$page === 1 &&
  has_post_thumbnail()
){
	
  echo '<div class="entry_post_thumbnail col-12 col-md-4">';
	$thumb_attr = array(
		'class'	=> 'img-responsive mb-5',
		'alt'   => trim( strip_tags( get_the_title() )),
		'title' => trim( strip_tags( get_the_title() )),
	);
	$_thumbnail_url = get_the_post_thumbnail($post_id,'profile',$thumb_attr);
	
	echo '<figure id="replace-target">';
	
	echo $_thumbnail_url;
	
	echo '</figure>';
	
	echo '</div>';
}

echo '<div class="staff_profile_block col-12'. (has_post_thumbnail() ? ' col-md-8' : '') .'">';


	
$style_images_upload_images = get_post_meta( $post_id, 'style_images_upload_images', true );

//初期化
$style_images_upload_li = '';

if( !empty($style_images_upload_images) ){
	
	echo '<div id="style_gallery-unit" class="row mb-5 gallery">';

	foreach( $style_images_upload_images as $key => $image ){
			$thumb_src = wp_get_attachment_image_src ($image,'thumbnail_M');
			$profile_src = wp_get_attachment_image_src ($image,'profile');
			if( empty($thumb_src[0]) ){
				$thumb_src = wp_get_attachment_image_src ($image,'full');
			}
			if ( empty ($thumb_src[0]) ){
					//delete_post_meta( $post_id, 'style_images_upload_images', $img_id );
				$thumb_src[0] = wp_get_attachment_url($image);
			}
			if ( !empty ($thumb_src[0]) )
				{
					$style_images_upload_li.= '<div class="gallery-item replace-item col-3 mb-5">';
					$style_images_upload_li.= '<img src="'.$thumb_src[0].')" data-src="'.$profile_src[0].'">';
					$style_images_upload_li.= '</div>';
			}
	}

	echo $style_images_upload_li;
	echo '</div>';

}
	

// excerpt =======================================
echo print_style_excerpt($post->post_excerpt);
	
echo '</div>';
echo '</div>';
	
echo '</header>';


the_content('more...',true);

}// if has content

// content footer widget
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('content_inner')): 
	//dynamic_sidebar('content_inner');
endif;


get_paged_nav_title($post);

$num = array(
    'before' => '<div class="pagination paging_arrows">',
    'after' => '</div>',
    'link_before' => '<span>',
    'link_after' => '</span>',
    'next_or_number' => 'number',
    'separator' => '',
    'pagelink' => '%',
    'echo' => 1
);
wp_link_pages($num);

comments_template();

// post_type widget
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_name . '_after_content')): 
	dynamic_sidebar( $post_type_name . '_after_content');
endif;

if( get_the_content() ) echo '</div>';
?>