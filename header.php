<?php
global $theme_opt;
global $post_type_set;
global $page_info;

$hide_header = false;

if( is_singular() ){
	$page_info = get_post_meta($post->ID,'page_info',true);
}

?><!--[if IE 8 ]><html lang='ja' class="ie ie8"><![endif]-->
<!--[if IE 9 ]><html lang='ja' class="ie9"><![endif]-->
<!--[if !(IE)]><!--><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
<?php
	get_template_part('template-parts/common/head');

	//if set max width
	if( !empty($post_type_set['max_container_width']) ){
		?>
	<style>
		@media screen and (min-width: 980px) {
       .container{ max-width:<?php echo $post_type_set['max_container_width'];?>px; }; 
     }
	</style>

		<?php
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