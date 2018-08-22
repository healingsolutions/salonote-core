<?php


$userObj = get_queried_object();
$before_title = esc_html($userObj->display_name);
$user_ID = $userObj->ID;

echo '<div class="main-content-wrap">';
echo '<div class="'.$main_block_class.' main-content-unit">';

  $avatar_args = array(
    'size' => '150',
    'class'=>'img-circle',
    'default' => 'mystery'
  );

  //profile block
  if(get_the_author_meta( 'description', $user_ID )){
    echo '<div class="text-center">';
    echo '<h1>'. get_the_author_meta( 'display_name', $user_ID ). '</h1>';
    echo get_avatar( $user_ID,'','','', $avatar_args );
    echo '<div>'. nl2br(get_the_author_meta( 'description', $user_ID )). '</div>';
    echo '</div>';
  }
  
	/*
  $args = array( 
    'post_type' => 'post',
    'meta_query' => array(
          array(
              'key' => 'related_loop',
              'value' => $user_ID,
              'compare' => 'LIKE'
          )
    )
  );
	*/

	$args = array(
    'author'						=>( $user_ID ),
    'post_type' 				=> array('column','blog','news','post'),
    'post_status' 			=> 'publish',
    'suppress_filters' 	=> true,
    'ignore_sticky_posts' => true,
    'no_found_rows' 		=> true,
    'posts_per_page' 		=> $posts_per_page,
    'paged' 						=> get_query_var('paged') ? get_query_var('paged') : 1
	);
	$query = new WP_Query($args); 
	

  get_template_part('template-parts/common/archive-unit');

echo '</div>';
echo '</div>';

?>