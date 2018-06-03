<?php
/*
Template Name: photo gallery
*/

global $theme_opt;
global $post_type_name;
global $post_type_set;
global $page_info;
global $main_unit;
global $user_setting;

$page_info = get_post_meta($post->ID,'page_info',true);
$gallery_post_type_value = !empty(get_post_meta($post->ID,'gallery_post_type',true)) ? get_post_meta($post->ID,'gallery_post_type',true) : 'post' ;

// =============================
// initialize
$main_unit   = array('main-content-unit');
$main_unit[] = container_class();

$main_content[] = 'main-content-block';

$_main_width = !empty($theme_opt['base']['side_width']) ? (12 - $theme_opt['base']['side_width']) : 9 ;

// =============================
// if has sidebar
if(
	(
		!empty( $post_type_set ) &&
		!in_array('full_pages',$post_type_set)
	)||
	!empty($page_info['has_sidebar'] )
){
	
  if(
      empty($page_info['none_sidebar']) &&
			empty($page_info['full_size'] )
    ){
    $main_unit[]    = 'has_sidebar';
    $main_content[] = 'col-xs-12';
    $main_content[] = 'col-sm-'.$_main_width;
  }
	if(
      !empty($page_info['full_size'] )
    ){
		$main_unit = array_diff($main_unit, array('container'));
  }
}else{
    $main_unit[]    = 'none_sidebar';
    $main_content[] = 'col-xs-12';
    $main_content[] = 'col-sm-12';
}


if( !empty( $page_info ) ) {
  foreach( $page_info as $info_key => $value){
    $main_unit[] = $info_key;
  }
}

get_header();

echo '<div class="'.implode(' ',$main_unit).'">';
echo '<div class="'.$row_class.'">';

  // main =======================
  echo '<div class="'.implode(' ',$main_content).'">';

	$paged = (int) get_query_var('paged');
	$args = array(
			'post_type' => $gallery_post_type_value,
			'post_status' => 'publish',
			'posts_per_page' => 10,
			'paged' => $paged
	);
	$list_type = 'grid';
	echo '<div class="article-block">';

	if( isset($show_archive_title) ){
	$obj = get_post_type_object( $post_type_name );
	echo '<div class="post_title">'. $obj->labels->singular_name;

			global $page, $paged;
			//現在ページが2ページ目以降であればページ数を表示する
			if( $paged >= 2 || $page >= 2 ){
					echo ' <span>' . max( $paged, $page ) . "ページ目  " . '</sapn>';
			}

	 echo ' 画像</div>';
	 };

	$query = new WP_Query( $args );
	if( $paged > 1 ){
				echo '<div class="paged_title_block">' .$paged. __('page / all','salonote-essence').($query->max_num_pages / $args['posts_per_page'] * 10 ). __('pages','salonote-essence').'</div>';
			}

if($query->have_posts()){
        while($query->have_posts()): $query->the_post();  

	 $post_id =  get_the_ID();


		//投稿から画像リストを取得
		$image_args = array(
			'post_type'   => 'attachment',
			'numberposts' => -1,
			//'post_status' => null,
			'post_mime_type' => 'image',
			'post_parent' => $post_id
		);

		$grid_col = isset( $grid_col ) ? $grid_col : $post_type_set['grid_col'] ;
		$attr = array(
			'class' => 'img-responsive colorbox'
		);


		$attachments = get_posts( $image_args );
		if ( $attachments ) {
			?>

			<div class="<?php echo $entry_list_class; ?>_list bdr-tb">

			<!-- A single blog post -->
			<section class="<?php echo $entry_list_class; ?>__content clearfix">

			<?php

			echo '<a class="link_color" href="'. get_the_permalink($post_id).'">';			
			get_template_part( 'template-parts/module/list-part-inner' );
			echo '</a>';
			
			echo '<div class="gallery row">';
			foreach ( $attachments as $attachment ) {
				?>
				<?php
				$image_src = wp_get_attachment_image_src( $attachment->ID , 'large' );
				echo '<figure class="gallery-item col-xs-4 col-sm-4 col-md-3 col-lg-2"><a class="colorbox" href="'. $image_src[0] . '">';
				echo wp_get_attachment_image( $attachment->ID, 'thumbnail_M', false, $attr );
				echo '</a></figure>';
			}
			echo '</div>';
		}
		//end 投稿から画像リストを取得  

		endwhile;

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

} //endif;

echo '</div>';
echo '</div>';
echo '</div>';

get_footer();

?>