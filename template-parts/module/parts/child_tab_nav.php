<?php
//display child page

global $theme_opt;
global $post_type_set;
global $page_info;
global $post_type_name;


if( is_child() ){
	$parent_id = $post_id = get_top_parent_page_id($post->ID);
	$post_ancestors = get_post_ancestors($post->ID);	
}else{
	$post_id = $post->ID;
}


$main_content   = array(
  //'main-content-block',
  'tab-nav-unit',
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



$child_args = array(
		'post_type' 			=> $post_type_name,
		'post_status' 		=> 'publish',
		'orderby' 				=> $orderby,
		'order' 					=> $posts_order,
		'posts_per_page'  => $posts_per_page,
		'paged' 					=> 0,
		'post_parent' 		=> $post_id
		//'post__not_in' => array($post_id)
);
$query = new WP_Query( $child_args );



if($query->have_posts()){
	echo '<div class="'.implode(' ',$main_content).'"><ul class="nav nav-tabs menu">';
	
	if( is_child() ){
		echo '<li class="nav-item">
			<a class="nav-link" href="'.get_the_permalink($parent_id).'">'.get_the_title($parent_id).'</a>
		</li>';
	}else{
		echo '<li class="nav-item">
			<a class="nav-link" href="'.get_the_permalink($post_id).'">'.get_the_title($post_id).'</a>
		</li>';
	}
	
	while($query->have_posts()): $query->the_post();
	
	
	echo '<li class="nav-item'. (has_children() ? ' menu-item-has-children' : '' ) .'">
    <a class="nav-link" href="'.get_the_permalink().'">'.get_the_title().'</a>';
	
	
		if( has_children() ){

			
			$child_query = new WP_Query(array('post_parent' => get_the_ID(), 'post_type' => 'any'));
			if($child_query->have_posts()){
				echo '<ul class="tab-nav-child sub-menu">';
				while($child_query->have_posts()): $child_query->the_post();
				echo '<li class="nav-item">
							<a class="nav-link" href="'.get_the_permalink().'">'.get_the_title().'</a>
							</li>';
				endwhile;
				echo '</ul>';
			}
		}
	
  echo '</li>';

	endwhile;
	echo '</ul>';
	
	
	//if has child
	if( !empty($post_ancestors) && $post_ancestors[0] !== $parent_id ){
		$brother_query = new WP_Query(array('post_parent' => $post_ancestors[0], 'post_type' => 'any'));
		if($brother_query->have_posts()){
			echo '<ul class="tab-nav-child inner-tab-nav">';
			while($brother_query->have_posts()): $brother_query->the_post();
			echo '<li class="nav-item label-block';
			if( get_the_ID() === $post_id ) echo ' current' ;
			echo '">
						<a class="nav-link" href="'.get_the_permalink().'">'.get_the_title().'</a>
						</li>';
			endwhile;
			echo '</ul>';
		}
	}
	
	echo '</div>';
};


$args = null;
wp_reset_query();

?>