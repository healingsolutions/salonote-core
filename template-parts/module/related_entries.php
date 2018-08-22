<?php
global $theme_opt;
global $post_type_set;
global $page_info;
global $post_type_name;

$_list_show_excerpt_tmp = $post_type_set['list_show_excerpt'];
$post_type_set['list_show_excerpt'] = 'hide';
	
if( empty( $post_type_set ) )return;
	 
if(!in_array('display_other_post',$post_type_set ))
{
	return;
}



$posts_per_page = isset($post_type_set['posts_per_page']) ? $post_type_set['posts_per_page'] : '10' ;
$posts_order = isset($post_type_set['posts_order']) ?$post_type_set['posts_order'] : 'DESC' ;
$event_date = isset($post_type_set['event_date']) ?$post_type_set['event_date'] : null ;

if($event_date){
  $orderby = 'meta_key';
}elseif($posts_order == 'menu_order'){
  $orderby = 'menu_order';
  $posts_order = 'ASC';
}else{
  $orderby = 'post_date';
}



$args = array(
		'post_type' => $post_type_name,
		'post_status' => 'publish',
		'orderby' => $orderby,
		'posts_per_page' => 8,
		//'post__in' => $relatedPost,
		'post__not_in' => array($post->ID),
);


$query = query_posts( $args );


$post_type_label = get_post_type_object($post_type_name)->label;
$post_type_label = $post_type_label ? $post_type_label : __('posts','salonote-essence');

$related_block_class   = [];
$related_block_class[] = 'list-unit';
$related_block_class[] = 'grid-type-group';
$related_block_class[] = 'related_entries_block';

if( !empty($post_type_set['grid_cols']) ) {
  $related_block_class[] = 'grid_cols-'.$post_type_set['grid_cols'];
}else{
	$related_block_class[] = 'grid_cols-4';
}


if( have_posts()){

	echo '<div class="posts">';
	echo '<div class="bold title_bdr_tbtm text-center">'.sprintf(__('other %s posts','salonote-essence') ,$post_type_label ) .'</div>';

	echo '<div class="'.implode(' ',$related_block_class).'">';
		while(have_posts()) : the_post();
		get_template_part('template-parts/module/list-part');
		endwhile;
	echo '</div>';
	echo '</div>';

 } else {
 }


wp_reset_postdata();
wp_reset_query();

$post_type_set['list_show_excerpt'] = $_list_show_excerpt_tmp;
?>