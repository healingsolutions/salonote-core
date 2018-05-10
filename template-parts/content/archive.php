<?php
//archive
//echo 'archive';
global $post_type_name;

$post_type_set = $options['themePostType'][$post_type_name];

$posts_per_page = isset($post_type_set['post_count']) ?$post_type_set['post_count'] : '10' ;
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


global $wp_query;


$paged = (int) get_query_var('paged');
$args = array(
    //'post_type' => $post_type,
    //'post_status' => 'publish',
    'order' => $posts_order,
    'orderby' => $orderby,
    'posts_per_page' => $posts_per_page,
    'paged' => $paged
);
$archive_query = array_merge( $wp_query->query, $args );
query_posts( $archive_query );



echo '<div class="'.$main_block_class.' main-content-unit';
	if( !empty($posttype_content_class) ){ echo ' '.$posttype_content_class; };
echo '">';

get_template_part('template-parts/common/archive-unit');

echo '</div>';


