<?php
global $theme_opt;
global $post_type_name;
global $post_type_set;
global $page_info;

$post_id = get_the_ID();

if( get_the_content() ){
echo '<div class="entry_block_content">';
echo '<header>';

// title =======================================
if(
  !empty( $post_type_set ) &&
  in_array('display_entry_title',$post_type_set )&&
  empty( $page_info['disable_title'] )
){
	$_the_title = get_the_title();
	if( in_array('break_title',$theme_opt['base'])){
		$_the_title = preg_replace('/(\,|'.__(',','salonote-essence').')/', '$1<br />', $_the_title);
		$_the_title = preg_replace('/(~|〜)/', '<br /><span class="small">$1', $_the_title).'</span>';
	}
  echo '<h1 class="entry_block_title">'.$_the_title.'</h1>';
}


// sub_title =======================================
if(
  !empty( $post_type_set ) &&
  in_array('display_entry_sub_title',$post_type_set )
){
	
	$_sub_title = get_post_meta($post_id, 'subTitle',true);
	if( !empty($_sub_title) ){
		echo '<h2 class="entry_block_sub_title">'.$_sub_title.'</h2>';
	}
  
}


/*-------------------------------------------*/
/*	taxonomy_list
/*-------------------------------------------*/
get_template_part('template-parts/module/taxonomy_list');

// date =======================================
if(
  !empty( $post_type_set ) &&
  in_array('display_post_date',$post_type_set )
){
  echo '<time class="entry_block_date">'.get_the_date('Y-m-d').'</time>';
}


// date =======================================
if(
  !empty( $post_type_set ) &&
  in_array('display_entry_excerpt',$post_type_set )&&
  has_excerpt()
){
  echo '<div class="entry_block_excerpt">'.get_the_excerpt().'</div>';
}
	
// date =======================================
if(
  !empty( $post_type_set ) &&
  in_array('post_thumbnail',$post_type_set )&&
  has_post_thumbnail() && 
){
  echo '<div class="entry_post_thumbnail">';
	$thumb_size = !empty( $post_type_set['thumbnail_size'] ) ? $post_type_set['thumbnail_size'] : 'thumbnail' ;
	$thumb_attr = array(
		'alt'   => trim( strip_tags( get_the_title() )),
		'title' => trim( strip_tags( get_the_title() )),
	);
	$_thumbnail_url = get_the_post_thumbnail($post_id,'large',$thumb_attr);
	
	echo '</div>';
}
echo '</header>';


the_content();

}// if has content

// content footer widget
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('content_inner')): 
	//dynamic_sidebar('content_inner');
endif;
wp_link_pages();
comments_template();

// post_type widget
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_name . '_after_content')): 
	dynamic_sidebar( $post_type_name . '_after_content');
endif;

if( get_the_content() ) echo '</div>';
?>