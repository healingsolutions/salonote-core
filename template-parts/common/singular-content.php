<?php
global $theme_opt;
global $post_type_name;
global $post_type_set;
global $page_info;
global $main_unit;
global $user_setting;


//$page_info = get_post_meta($post->ID,'page_info',true);

// =============================
// initialize
$main_unit   = array('main-content-unit');
$main_unit[] = container_class();

$main_content[] = 'main-content-block';



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
    $main_content[] = 'col-xs-12';
    $main_content[] = 'col-sm-9';
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
}


if( !empty( $page_info ) ) {
  foreach( $page_info as $info_key => $value){
    $main_unit[] = $info_key;
  }
}


// =====================================================

echo '<div class="'.implode(' ',$main_unit).'">';

if( in_array('container',$main_unit) ){
	echo '<div class="row">';
}

  // action essence_before_body_content =============================
  if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_before_body_content]</span>';}
  do_action( 'essence_before_body_content' );
  // ^action =============================


echo '<div class="'.implode(' ',$main_content).'">';

  // action essence_before_single_content =============================
  if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_before_single_content]</span>';}
  do_action( 'essence_before_single_content' );
  // ^action =============================

  //before post_type widget
  if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_name . '_before_widgets')): 
    //dynamic_sidebar( $post_type_name . 'widgets');
  endif;

  if(have_posts()): while(have_posts()): the_post();
    get_template_part('template-parts/module/single-content');
  endwhile; endif;

  //after post_type widget
  if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_name . '_after_widgets')): 
    //dynamic_sidebar( $post_type_name . 'widgets');
  endif;

	

	
	if(
      !empty($page_info['single_child_unit']) &&
		  $page_info['single_child_unit']
    ){
			//display child pages
			get_template_part('template-parts/module/single_child_unit');
  }


  // action essence_after_single_content =============================
  if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_after_single_content]</span>';}
  do_action( 'essence_after_single_content' );
  // ^action =============================

	//related posts
	get_template_part('template-parts/module/related_entries');


	// content footer widget
  if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('content_footer')): 
    //dynamic_sidebar('content_footer');
  endif;

  
echo '</div>';//main_content

  // =====================
  // sidebar
  if(
		(
			!empty( $post_type_set ) &&
			!in_array('full_pages',$post_type_set)
		) ||
		!empty($page_info['has_sidebar'] )
  ){
		
    if(
      empty($page_info['none_sidebar']) &&
      empty($page_info['full_size'] ) 
    ){
      get_sidebar();
    }
  }


  // action essence_after_body_content =============================
  if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_after_body_content]</span>';}
  do_action( 'essence_after_body_content' );
  // ^action =============================

if( in_array('container',$main_unit) ){
	echo '</div>';//row
}
	
echo '</div>';// main_unit

// =====================================================

?>