<?php
global $theme_opt;
global $post_type_set;
global $post_type_name;
global $post_type_label;


if( !empty( $theme_opt['base'] ) && !in_array('BreadCrumb',$theme_opt['base'] ) )
  return;


global $wp_query,$post_type_name;
$post = $wp_query->get_queried_object();
$frontpage_id = get_option( 'page_on_front' );

//Initialization
$breadcrumb = null;
$bread_arr = [];


// ========================
// home

if( !is_home() && !is_front_page() ){
  
  if( $frontpage_id ){
    $bread_arr[] = array(
      'label' => get_the_title($frontpage_id),
      'url'   => get_the_permalink($frontpage_id),
    );
  }else{
    $bread_arr[] = array(
      'label' => 'HOME',
      'url'   => get_home_url(),
    );
  }
}


// ========================
// author page
if (is_author()) {
  $userObj = get_queried_object();
  $bread_arr[] = array(
    'label' => esc_html($userObj->display_name),
    'url'   => null,
  );  
}


// ========================
// taxonomy
if (is_tax()) {
	$taxonomy = get_query_var('taxonomy');
	$post_type_name = get_taxonomy($taxonomy)->object_type[0]; 
}


// ========================
// post_type
if( !is_front_page() && $post_type_name !== 'post' && $post_type_name !== 'page' ){
	if( !empty($post_type_name) && is_post_type_archive($post_type_name) ){
		$bread_arr[] = array(
			'label' => esc_html(get_post_type_object($post_type_name)->label),
			'url'   => get_post_type_archive_link($post_type_name)
		);
	}
	
	if( !empty($post_type_name) && is_tax() ){

		$bread_arr[] = array(
			'label' => esc_html(get_post_type_object($post_type_name)->label),
			'url'   => get_post_type_archive_link($post_type_name)
		);
		
		$bread_arr[] = array(
			'label' => single_term_title('',false),
			'url'   => null
		);
	}
}

  
// ========================
// pages
if (is_singular() && intval($post->ID) !== intval($frontpage_id) ) {
  // if sub_page
  if ( $post->post_parent ) {
    if($post->ancestors){
      foreach( $post->ancestors as $ancestor ){
        
        $bread_arr[] = array(
          'label' => esc_html(get_the_title($ancestor)),
          'url'   => get_the_permalink($ancestor),
        );
      }
    }
  }
  $bread_arr[] = array(
    'label' => esc_html(get_the_title($post->ID)),
    'url'   => get_the_permalink($post->ID),
  );
}
  

//add breadcrumb class
$breadcrumb_class[] = 'breadcrumb';
$breadcrumb_class[] = container_class();


if( $bread_arr ){
  echo '<ol class="'.implode(' ',$breadcrumb_class).'">';
  foreach( $bread_arr as $bread_item ){
    echo '<li class="breadcrumb-item">';
    echo '<a href="'. (!empty($bread_item['url']) ? $bread_item['url'] : '#') .'">'.$bread_item['label'].'</a></li>';
  }
  echo '</ol>';
}

?>