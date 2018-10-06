<?php
/*
Template Name: Key visual Landing Page
Template Post Type: post, page, style
*/

global $theme_opt;
global $post_type_name;
global $post_type_set;
global $page_info;
global $main_unit;
global $user_setting;

global $hide_header;
global $hide_footer;

$page_info = get_post_meta($post->ID,'page_info',true);
if( empty($page_info) ){
	$page_info = [];
}

$page_info['none_sidebar'] = true;
$page_info['has_sidebar'] = false;
$page_info['full_size'] = false;
$page_info['disable_title'] = true;


$landing_page_info = get_post_meta($post->ID,'landing_page_info',true);


if( !empty($landing_page_info) && $landing_page_info['none_header'] ){
	$hide_header = true;
}
if( !empty($landing_page_info) && $landing_page_info['none_footer'] ){
	$hide_footer = true;
}

$landing_page_item_inner = array('landing-page-item-inner');


if( !empty($landing_page_info) && $landing_page_info['use_container'] ){
	$landing_page_item_inner[] = 'container';
}

$gallery_post_type_value = !empty(get_post_meta($post->ID,'gallery_post_type',true)) ? get_post_meta($post->ID,'gallery_post_type',true) : 'post' ;

// =============================
// initialize
$main_unit   = array('main-content-unit');
$main_unit[] = container_class();

$main_content[] = 'main-content-block main-content-wrap';

$_main_width = !empty($theme_opt['base']['side_width']) ? (12 - $theme_opt['base']['side_width']) : 9 ;


$row_class = 'row';

// =============================
// if has sidebar
if(
	(
		!empty( $post_type_set ) &&
		!in_array('full_pages',$post_type_set)
	)||
	!empty($page_info['has_sidebar'] )
){
	
  if(
      empty($page_info['none_sidebar']) &&
			empty($page_info['full_size'] )
    ){
    $main_unit[]    = 'has_sidebar';
    $main_content[] = 'col-12';
    $main_content[] = 'col-lg-'.$_main_width;
  }
	if(
      !empty($page_info['full_size'] )
    ){
		$main_unit = array_diff($main_unit, array('container'));
  }
}else{
    $main_unit[]    = 'none_sidebar';
    $main_content[] = 'col-xs-12';
    $main_content[] = 'col-sm-12';
		$row_class .= '-block container';
}

$main_content[] = 'row';


if((
		!empty( $post_type_set ) &&
		in_array('hide_header',$post_type_set)
	)){
	$main_unit[]    = 'hide_header';
}
if((
		!empty( $post_type_set ) &&
		in_array('hide_footer',$post_type_set)
	)){
	$main_unit[]    = 'hide_footer';
}


if( !empty( $page_info ) && in_array(1,$page_info) ) {
  foreach( $page_info as $info_key => $value){
		if( !empty($value) ) $main_unit[] = $info_key;
  }
}



get_header();


echo '<div class="'.implode(' ',$main_unit).'">';
echo '<div class="'.$row_class.'">';

  // main =======================
  echo '<div class="'.implode(' ',$main_content).'">';

	

	if(have_posts()): while(have_posts()): the_post();

		$page_bkg	= get_post_meta(get_the_ID(),'page_bkg_upload_images', true );
		if( !empty($page_bkg) ){
			$thumb_src = wp_get_attachment_image_src ($page_bkg,'full');
			if( empty($thumb_src[0]) ){
				$thumb_src = wp_get_attachment_image_src ($page_bkg,'full');
			}
			if ( empty ($thumb_src[0]) ){
					//delete_post_meta( $post_id, 'page_bkg_upload_images', $img_id );
				$thumb_src[0] = wp_get_attachment_url($page_bkg);
			}
			$key_image = $thumb_src[0];
		}else{
			
			$attachment_images = get_attached_media( 'image', get_the_ID() );
			$attachment_images = array_shift($attachment_images);

			$attachment_id = $attachment_images->ID;
			$key_image_arr = wp_get_attachment_image_src ($attachment_id,'full');
			$key_image = $key_image_arr[0];
		}

		

	echo '
	<figure id="keyv-figure" class="col-12 col-md-7">
		<picture>
			<img class="img-fit" src="'. $key_image .'" alt="'.get_the_title().' - メインビジュアル">
		</picture>';
		
	if( has_excerpt() ){
		echo '<div class="figure-text">
		<div class="figure-text-inner">
		<h1>'. get_the_title() .'</h1>
		<p class="figure-text-inner-excerpt">';
		
		echo nl2br(get_the_excerpt());
		
		echo '</p>
		</div>
		</div>';
	}
		
		
		
	echo '</figure>';

	echo '<div id="keyv-content" class="col-12 col-md-5">';
		get_template_part('template-parts/module/single-content');
	echo '</div>';

  endwhile; endif;



echo '</div>';
echo '</div>';
echo '</div>';


?>



<?php

get_footer();
?>