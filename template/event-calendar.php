<?php
/*
Template Name: Event Calendar
*/




global $theme_opt;
global $post_type_name;
global $post_type_set;
global $page_info;
global $main_unit;
global $user_setting;

global $hide_header;
global $hide_footer;


global $event_posts;

$args = array(
		'post_type' 			=> 'events',
		'post_status' => 'publish',
		'posts_per_page' 	=> 10,
		'order'          	=> 'ASC',
		'orderby'        	=> 'menu_order',
);
$event_posts = get_posts( $args );
$params['ym'] = null;


$page_info = get_post_meta($post->ID,'page_info',true);
$landing_page_info = get_post_meta($post->ID,'landing_page_info',true);

if( !empty($landing_page_info) && !in_array('none_header',$landing_page_info) ){
	$hide_header = true;
}
if( !empty($landing_page_info) && !in_array('none_footer',$landing_page_info) ){
	$hide_footer = true;
}

$gallery_post_type_value = !empty(get_post_meta($post->ID,'gallery_post_type',true)) ? get_post_meta($post->ID,'gallery_post_type',true) : 'post' ;

// =============================
// initialize
$main_unit   = array('main-content-unit');
$main_unit[] = container_class();

$main_content[] = 'main-content-block';

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
		$row_class .= '-block';
}


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


if( !empty( $page_info ) ) {
  foreach( $page_info as $info_key => $value){
    $main_unit[] = $info_key;
  }
}



get_header();



echo '<div class="'.implode(' ',$main_unit).'">';
echo '<div class="'.$row_class.'">';

  // main =======================
  echo '<div class="'.implode(' ',$main_content).'">';



	echo '<div class="landing-page-block">';


	$page_info['disable_title'] = true;

	get_template_part('template-parts/module/parts/calendar-block');


	echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';


get_footer();
?>