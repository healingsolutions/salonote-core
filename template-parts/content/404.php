<?php
//404
$main_block_class = '';
$has_sidebar      = '';
$article_class    = '';
$post_type_class  = '';
$entry_list_class = '';
$thumbnail_class  = '';
$sidebar_class    = '';
$post_title_class = '';
$_page_type       = '';

$posts_per_page = isset($post_type_set['post_count']) ?$post_type_set['post_count'] : '10' ;
$posts_order = isset($post_type_set['posts_order']) ?$post_type_set['posts_order'] : 'DESC' ;
$event_date = isset($post_type_set['event_date']) ?$post_type_set['event_date'] : null ;

echo '<div class="main-content-wrap">';
	echo '<div class="'.$main_block_class.' main-content-unit">';
		echo '<div class="container text-center">';


			if( !empty($_POST) && !empty($_POST['post_id']) ){
				echo '<div class="h1">';
				echo get_the_title($_POST['post_id']);
				echo '</div>';
				
			}else{
				echo '<div class="h1">404</div>';
				echo '<p>'.__('no posts','salonote-essence').'</p>';
			}

			do_action('error_page_action');
		echo '</div>';
	echo '</div>';
echo '</div>';

?>