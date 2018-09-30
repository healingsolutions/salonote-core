<?php
//echo 'index';
global $theme_opt;
global $post_type_set;
global $post_type_name;
global $post_type_tmpl;
global $user_setting;


if( is_tax() || is_category() ){
	if( is_tax()){
		$taxonomy = get_query_var('taxonomy');
		
		if(is_user_logged_in()){
			echo '<pre>'; print_r($taxonomy); echo '</pre>';
		}
		$post_type_name = !empty(get_taxonomy($taxonomy)->object_type[0]) ? get_taxonomy($taxonomy)->object_type[0] : 'post';
	}
	if( is_category()){
		$post_type_name = 'post';
	}
}

$post_type_set  = !empty($post_type_name) ? $theme_opt['post_type'][$post_type_name] : $theme_opt['post_type']['post'];


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
$list_type = $list_class[] = !empty($post_type_set['list_type']) ? $post_type_set['list_type'].'-type-group' : 'list-type-group' ;

if( !empty($post_type_set['list_type']) && $post_type_set['list_type'] == 'grid'){
	if(!empty($post_type_set['grid_cols']) ) {
		$list_class[] = 'grid_cols-'.$post_type_set['grid_cols'];
	}else{
		$list_class[] = 'grid_cols-4';
	}
}


global $wp_query;

$args['post_type'] = $post_type_name;
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

if( is_tax() ){
	$args['post_type'] = $post_type_name;
	
	$args['tax_query'] = array(
		array(
			'taxonomy' => $taxonomy,
			'field' => 'slug',
			'terms' => $term,
			)
		);
}

if( is_month() ){
	$args['year'] 		= get_query_var('year');
	$args['monthnum'] = get_query_var('monthnum');
}


$query = new WP_Query( $args );


// =====================================================
echo '<div class="main-content-wrap">';
echo '<div class="'.implode(' ',$main_unit).'">';
echo '<div class="'.$row_class.'">';

  // main =======================
  echo '<article class="'.implode(' ',$main_content).'">';

		echo '<div class="archive-page-title-block">';

			if( !empty( $post_type_set ) && in_array('display_archive_title',$post_type_set)){
				

				$obj = !empty($post_type_name) ? get_post_type_object($post_type_name) :  get_post_type_object('post') ;
				
				

				
				echo '<div class="entry-block-title-wrap label-block '. $list_type .'-title">';

					echo '<p class="entry_block_title nav_font"'. ((mb_strlen(esc_html( $obj->name )) > 6 ) ? ' style="font-size:1em;"' : '' ).'>'.strtoupper(str_replace('_',' ',esc_html( $obj->name ))).'</p>';
				
					echo '<p class="entry_block_sub_title body_font">'.esc_html( $obj->label ).'</p>';
				
				echo '</div>';
			}


			// ========================
			// taxonomy
			if (is_tax() || is_category()) {
				
				echo '<div class="entry_block_taxonomy_label">';
				echo '<h1 class="taxonomy_lable">'.single_term_title('',false).'</h1>';
				echo '</div>';
				
			} elseif( is_tag() ){
				
				echo '<div class="entry_block_taxonomy_label">';
				echo '<h1 class="taxonomy_lable">'.single_tag_title('',false).'</h1>';
				echo '</div>';
				
			} elseif( is_month() ){
				echo '<div class="entry_block_taxonomy_label">';
				echo '<h1 class="taxonomy_lable">'.get_query_var('year').'年'.get_query_var('monthnum').'月'.'</h1>';
				echo '</div>';

			}

		echo '</div>';

		

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
