<?php
global $theme_opt;
global $post_type_set;
global $page_info;
global $post_type_name;
global $post_taxonomies;

$_list_show_excerpt_tmp = $post_type_set['list_show_excerpt'];

$post_type_set['list_show_excerpt'] = !empty($post_type_set['related_list_show_excerpt']) ? $post_type_set['related_list_show_excerpt']  : 'hide' ;


	
if( empty( $post_type_set ) )return;
	 
if(!in_array('display_other_post',$post_type_set ))
{
	return;
}



$args = array(
		'post_type' => $post_type_name,
		'post_status' => 'publish',
		'post__not_in' => array($post->ID),
);


$args['posts_per_page']		= isset($post_type_set['posts_per_page']) ? $post_type_set['posts_per_page'] : 8 ;
$args['order']			= isset($post_type_set['posts_order']) ?$post_type_set['posts_order'] : 'DESC' ;
$event_date = isset($post_type_set['event_date']) ?$post_type_set['event_date'] : null ;

if($event_date){
  $args['orderby']			= 'meta_key';
}elseif($args['order'] == 'menu_order'){
  $args['orderby']			= 'menu_order';
  $args['order']	= 'ASC';
}else{
  $args['orderby']			= 'post_date';
}



if( !empty($post_taxonomies) ){
	$term_list = wp_get_post_terms($post->ID, $post_taxonomies[0], array('fields' => 'all') );
	
		if( !empty($term_list[0]->slug) ){
			$args['tax_query'][] = array(
				'taxonomy' => $post_taxonomies[0],
				'terms'    => $term_list[0]->slug,
				'field'    => 'slug',
			);
		}

		$post_type_label = !empty( $term_list[0]->name ) ? $term_list[0]->name : '' ;
		$post_type_arr = get_post_type_object(get_post_type());
		$print_label			= sprintf('他の %s '.esc_html($post_type_arr->labels->name) ,$post_type_label );
}else{
	$post_type_label	= get_post_type_object($post_type_name)->label;
	$print_label			= sprintf(__('other %s posts','salonote-essence') ,$post_type_label );
}
$post_type_label = $post_type_label ? $post_type_label : __('posts','salonote-essence');




$query = query_posts( $args );




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
	echo '<div class="bold title_bdr_tbtm text-center">'. $print_label .'</div>';

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