<?php
//display child page

global $theme_opt;
global $post_type_set;
global $page_info;
global $post_type_name;


$main_content   = array(
  'main-content-block',
  'list-unit',
);


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


// =============================
// set list type
$main_content[] = !empty($post_type_set['list_type']) ? $post_type_set['list_type'].'-type-group' : 'list-type-group' ;

if( !empty($post_type_set['list_type']) && $post_type_set['list_type'] == 'grid' && !empty($post_type_set['grid_cols']) ) {
  $main_content[] = $post_type_set['grid_cols'] ? 'grid_cols-'.$post_type_set['grid_cols'] : 4 ;
}


$child_args = array(
		'post_type' 			=> $post_type_name,
		'post_status' 		=> 'publish',
		'orderby' 				=> $orderby,
		'order' 					=> $posts_order,
		'posts_per_page'  => $posts_per_page,
		'paged' 					=> 0,
		'post_parent' 		=> $post->ID
		//'post__not_in' => array($post_id)
);
$query = new WP_Query( $child_args );

if($query->have_posts()){
	echo '<div class="'.implode(' ',$main_content).'">';
	while($query->have_posts()): $query->the_post();  
		get_template_part('template-parts/module/list-part');
	endwhile;
	echo '</div>';
};


$args = null;
wp_reset_query();

?>