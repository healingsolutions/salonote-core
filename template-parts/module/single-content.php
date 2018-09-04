<?php
global $theme_opt;
global $post_type_name;
global $post_type_set;
global $page_info;

global $page;
global $paged;

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
  echo '<h1 class="entry_block_title">'.$_the_title;
	
	//paged
  if( $paged >= 2 || $page >= 2 ){
		echo '<span class="entry_block_sub_title ml-3">'.max( $paged, $page ) . __(' page','salonote-essence').'目</span>';
  }
	
	echo '</h1>';
	
	
	
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

// writer =======================================
if(
  !empty( $post_type_set ) &&
	in_array('display_post_writer',$post_type_set)
){
	$auther_ID = get_the_author_meta('ID');
	$auther_url 	= get_author_posts_url( $auther_ID);
	$auther_image = get_avatar( $auther_ID, 35, false, get_the_title() .'の執筆者-' .get_the_author_meta('display_name') );
	if( isset($auther_image) ){
			echo '
			<div class="entry_block_writer text-right small">
			<a href="'. $auther_url .'">
				<div class="inline-block text-left mr-3" style="line-height:1.2; vertical-align:middle; ">writer：<br>'.get_the_author_meta('display_name').'</div>
				<div class="inline-block" style="vertical-align:middle;">'.
				$auther_image.'
				</div>
			</a>
			</div>';
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
	
// thumbnail =======================================
if(
  !empty( $post_type_set ) &&
  in_array('post_thumbnail',$post_type_set )&&
  has_post_thumbnail()
){
  echo '<div class="entry_post_thumbnail">';
	$thumb_attr = array(
		'class'	=> 'img-responsive mb-5',
		'alt'   => trim( strip_tags( get_the_title() )),
		'title' => trim( strip_tags( get_the_title() )),
	);
	$_thumbnail_url = get_the_post_thumbnail($post_id,'large',$thumb_attr);
	
	echo '<figure>';
	
	echo $_thumbnail_url;
	
	echo '</figure>';
	
	echo '</div>';
}
echo '</header>';


the_content('more...',true);

}// if has content

// content footer widget
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('content_inner')): 
	//dynamic_sidebar('content_inner');
endif;

$num = array(
    'before' => '<div class="pagination paging_arrows">',
    'after' => '</div>',
    'link_before' => '<span>',
    'link_after' => '</span>',
    'next_or_number' => 'number',
    'separator' => '',
    'pagelink' => '%',
    'echo' => 1
);
wp_link_pages($num);

comments_template();

// post_type widget
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_name . '_after_content')): 
	dynamic_sidebar( $post_type_name . '_after_content');
endif;

if( get_the_content() ) echo '</div>';
?>