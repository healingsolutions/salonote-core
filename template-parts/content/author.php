<?php
//echo 'index';
global $theme_opt;
global $post_type_set;
global $post_type_name;
global $post_type_tmpl;
global $user_setting;

$post_type_name = 'post';
$post_type_set = $theme_opt['post_type'][$post_type_name];

$userObj = get_queried_object();


// =============================
// initialize

$row_class = 'main-content-row';

$main_unit   = array('main-content-unit');
$main_unit[] = container_class();

$_main_width = !empty($theme_opt['base']['side_width']) ? (12 - $theme_opt['base']['side_width']) : 9 ;

$main_content   = array(
  'main-content-block',
	'mt-5 mb-5'
);
$list_class = array(
	'list-unit'
);


// =============================
// has sidebar
if(
  !empty( $post_type_set ) &&
  !in_array('full_archive',$post_type_set)
){
  $main_unit[]    = 'has_sidebar';
  $main_content[] = 'col-12';
  $main_content[] = 'col-lg-'.$_main_width;
}else{
	$row_class .= '-block';
}



// =============================
// list_type
$list_class[] = !empty($post_type_set['list_type']) ? $post_type_set['list_type'].'-type-group' : 'list-type-group' ;

if( !empty($post_type_set['list_type']) && $post_type_set['list_type'] == 'grid'){
	if(!empty($post_type_set['grid_cols']) ) {
		$list_class[] = 'grid_cols-'.$post_type_set['grid_cols'];
	}else{
		$list_class[] = 'grid_cols-4';
	}
}


global $wp_query;

$args['post_type'] = 'any';
$args['posts_per_page'] = !empty($post_type_set['posts_per_page']) ? $post_type_set['posts_per_page'] : get_option('posts_per_page');
$args['order'] = !empty($post_type_set['posts_order']) ? $post_type_set['posts_order'] : 'ASC';


//order
if($args['order'] == 'menu_order'){
	$args['orderby'] = 'menu_order';
  $args['order'] = 'ASC';
}else{
	$args['orderby'] = 'post_date';
}

$args['orderby'] = !empty($post_type_set['posts_order']) ? $post_type_set['posts_order'] : 'ASC';

$args['paged'] = get_query_var( 'paged', 1 );
$args['author'] = $userObj->ID;



$query = new WP_Query( $args );


// =====================================================
echo '<div class="main-content-wrap">';
echo '<div class="'.implode(' ',$main_unit).'">';
echo '<div class="'.$row_class.'">';

  // main =======================
  echo '<article class="'.implode(' ',$main_content).'">';


			if( get_avatar($userObj->ID, 150, true) ){
					$auther_image = get_avatar( $userObj->ID, 150, false, get_the_title() );
					$auther_url 	= get_author_posts_url( $userObj->ID);
			}
			if( isset($auther_image) ){
					echo '<div class="author_block_writer post-avatar text-center">
					' .$auther_image.
					'<p class="mt-2">'.esc_html($userObj->display_name).'</p>
					</div>';
			}

			//profile block
			if(get_the_author_meta( 'user_url', $userObj->ID )){
				echo '<div class="author_block_user_url text-center"><p><a href="'.get_the_author_meta( 'user_url', $userObj->ID ).'" target="_blank">'. esc_attr(get_the_author_meta( 'user_url', $userObj->ID )). '</a></p></div>';
			}


			//profile block
			if(get_the_author_meta( 'description', $userObj->ID )){
				echo '<div class="author_block_description"><p>'. nl2br(esc_attr(get_the_author_meta( 'description',$userObj->ID ))). '</p></div>';
			}

			


		

		if( !empty( $post_type_set ) && in_array('display_archive_title',$post_type_set) ){
				$obj = get_post_type_object($post_type_name);
			
			
			
				
				echo '<p class="entry_block_title">'.esc_html($userObj->display_name) .'<span class="small">の'.$obj->labels->singular_name.'</span></p>';
				echo '<p class="entry_block_sub_title">'.$obj->name.'</p>';
			}

		/*-------------------------------------------*/
		/*	taxonomy_list
		/*-------------------------------------------*/
		get_template_part('template-parts/module/taxonomy_list');

		echo '<div class="'.implode(' ',$list_class).'">';


      // action essence_before_body_content =============================
      if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_before_body_content]</span>';}
      do_action( 'essence_before_body_content' );
      // ^action =============================


			//post_type widget
			if( $post_type_tmpl !== 'front_page' && ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_tmpl . '_before_widgets'))): 
				//dynamic_sidebar( $post_type_name . 'widgets');
			endif;

			



			if( $paged > 1 ){
				echo '<div class="paged_title_block">' .$paged. __('page / all','salonote-essence').($query->max_num_pages / $args['posts_per_page'] * 10 ). __('pages','salonote-essence').'</div>';
			}



			
      if($query->have_posts()){
        while($query->have_posts()): $query->the_post();  
          get_template_part('template-parts/module/list-part');
        endwhile;

      }else{
        get_template_part('template-parts/common/single-content');
      }

      
      


	echo '</div>';

	//post_type widget
  if( $post_type_tmpl !== 'front_page' && (!function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_tmpl . '_after_widgets'))): 
    //dynamic_sidebar( $post_type_name . 'widgets');
  endif;

// action essence_before_body_content =============================
      if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_after_body_content]</span>';}
      do_action( 'essence_after_body_content' );
      // ^action =============================

				// pagenation
				if (function_exists("essence_pagination")) {
						essence_pagination($query->max_num_pages,$args['posts_per_page']);
				}else{
					//pagenation
					$big = 9999999999;
					$arg = array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'current' => max( 1, get_query_var('paged') ),
							'total'   => $query->max_num_pages
					);
					echo paginate_links($arg);
				}
				//^pagenation

  
	echo '</article>';



  // side =======================
  if( !empty( $post_type_set ) && !in_array('full_archive',$post_type_set) ){
    get_sidebar();
  }

echo '</div>';
echo '</div>';
echo '</div>';
// =====================================================



?>
