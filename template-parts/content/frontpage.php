<?php
//echo 'front-page';
global $theme_opt;
global $post_type_set;
global $post_type_name;
global $post_type_tmpl;
global $user_setting;

// =============================
// 初期化

$row_class = 'row';

$main_unit   = array('main-content-unit');
$main_unit[] = container_class();
$_main_width = !empty($theme_opt['base']['side_width']) ? (12 - $theme_opt['base']['side_width']) : 9 ;

$main_content   = array(
  'main-content-block'
);
$list_class = array(
	'list-unit'
);


// =============================
// サイドバーがある場合
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
// リストタイプを定義
$list_class[] = !empty($post_type_set['list_type']) ? $post_type_set['list_type'].'-type-group' : 'list-type-group' ;

if( !empty($post_type_set['list_type']) && $post_type_set['list_type'] == 'grid'){
	if(!empty($post_type_set['grid_cols']) ) {
		$list_class[] = 'grid_cols-'.$post_type_set['grid_cols'];
	}else{
		$list_class[] = 'grid_cols-4';
	}
}


global $wp_query;
$args = array(
  'post_type' => $post_type_name,
);

$args['posts_per_page'] = !empty($post_type_set['posts_per_page']) ? $post_type_set['posts_per_page'] : get_option('posts_per_page');
$args['order'] = !empty($post_type_set['posts_order']) ? $post_type_set['posts_order'] : 'ASC';


//順番の基準
if($args['order'] == 'menu_order'){
	$args['orderby'] = 'menu_order';
  $args['order'] = 'ASC';
}else{
	$args['orderby'] = 'post_date';
}

$args['orderby'] = !empty($post_type_set['posts_order']) ? $post_type_set['posts_order'] : 'ASC';

$args['paged'] = get_query_var( 'paged', 1 );

if( is_tax() ){
	$args['tax_query'] = array(
		array(
			'taxonomy' => $taxonomy,
			'field' => 'slug',
			'terms' => $term,
			)
		);
}


$query = new WP_Query( $args );

// =====================================================
echo '<div class="main-content-wrap">';
echo '<div class="'.implode(' ',$main_unit).'">';
echo '<div class="'.$row_class.'">';

  // main =======================
  echo '<div class="'.implode(' ',$main_content).'">';
		echo '<div class="'.implode(' ',$list_class).'">';


      // action essence_before_body_content =============================
      if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_before_body_content]</span>';}
      do_action( 'essence_before_body_content' );
      // ^action =============================


			//ポストタイプウィジェット

			if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_tmpl . '_before_widgets')): 
				//dynamic_sidebar( $post_type_name . 'widgets');
			endif;


			if( $paged > 1 ){
				echo '<div class="paged_title_block">' .$paged. __('page / all','salonote-essence').($query->max_num_pages / $args['posts_per_page'] * 10 ). __('pages','salonote-essence').'</div>';
			}


			/*-------------------------------------------*/
			/*	タクソノミーミーリスト
			/*-------------------------------------------*/
			get_template_part('template-parts/module/taxonomy_list');

      if($query->have_posts()){
        while($query->have_posts()): $query->the_post();  
          get_template_part('template-parts/module/list-part');
        endwhile;

      }else{
        get_template_part('template-parts/common/single-content');
      }

      
      
	//ポストタイプウィジェット
  if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_tmpl . '_after_widgets')): 
    //dynamic_sidebar( $post_type_name . 'widgets');
  endif;

// action essence_before_body_content =============================
      if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_after_body_content]</span>';}
      do_action( 'essence_after_body_content' );
      // ^action =============================

				// ページネーション
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
				//^ページネーション

  echo '</div>';
	echo '</div>';



  // side =======================
  if( !empty( $post_type_set ) && !in_array('full_archive',$post_type_set) ){
    get_sidebar();
  }

echo '</div>';
echo '</div>';
echo '</div>';
// =====================================================



?>
