<?php
global $theme_opt;
global $post_type_set;
global $page_info;
global $hide_header;

$hide_header = isset($hide_header) ? $hide_header : false;

if( is_singular() ){
	$page_info	= get_post_meta($post->ID,'page_info',true);
	$page_bkg		= get_post_meta($post->ID,'page_bkg_upload_images', true );
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
<?php
if( !empty($theme_opt['base']['google_analytics']) && !current_user_can( 'administrator' )){
//display google analytics only bisiter
$_gtag = $theme_opt['base']['google_analytics'];
echo <<< EOM
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={$_gtag}"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', '{$_gtag}');
</script>
EOM;
}// google analytics 

	
	get_template_part('template-parts/common/head');

	//if set max width
	if( !empty($post_type_set['max_container_width']) ){
		?>
	<style>
		@media screen and (min-width: 980px) {
      .main-content-unit.container,
			.main-content-unit .landing-page-item-inner.container{ max-width:<?php echo $post_type_set['max_container_width'];?>px; }; 
     }
	</style>
	
	<?php
	};
	
	
	//if has page bkg
		
	if( !empty($page_bkg) ){
		$thumb_src = wp_get_attachment_image_src ($page_bkg,'large');
		if( empty($thumb_src[0]) ){
			$thumb_src = wp_get_attachment_image_src ($page_bkg,'full');
		}
		if ( empty ($thumb_src[0]) ){
				//delete_post_meta( $post_id, 'page_bkg_upload_images', $img_id );
			$thumb_src[0] = wp_get_attachment_url($page_bkg);
		}
	
	echo '<style>
		.main-content-wrap{
			background-image: url('.$thumb_src[0].');
			background-size: cover;
			background-attachment: fixed;
		}
	</style>';

	}
	
	
	
if( !empty($theme_opt['extention']['head_tag_admin']) && !current_user_can( 'administrator' )){
	echo $theme_opt['extention']['head_tag_admin'];
}
	
if( !empty($theme_opt['extention']['head_tag_uesr']) ){
	echo $theme_opt['extention']['head_tag_uesr'];
}
?>
</head>
<body <?php body_class(); ?>>
  <div id="body-wrap" class="fader">
    
<?php

	// =============================
	// check display header
	if(
		!empty( $post_type_set ) &&
		in_array('hide_header',$post_type_set)
	){
		$hide_header = true;
	}
		
	if(
		is_singular() &&
		!empty( $page_info['hide_header'] )
	){
		$hide_header = true;
	}
		
	if( !$hide_header ){
		get_template_part('template-parts/common/header');
		get_template_part('template-parts/module/breadcrumb');
	}
  
?>