<?php
global $theme_opt;
global $post_type_name;
global $post_type_set;
global $page_info;

global $page;
global $paged;

$post_id = get_the_ID();

echo '<div class="entry_block_content';
if( has_post_thumbnail() ) echo ' has_thumbnail';
echo '">';


if( empty($_POST) ){
  echo '<header>';

  // title =======================================
  if(
    !empty( $post_type_set ) &&
    in_array('display_entry_title',$post_type_set )&&
    empty( $page_info['disable_title'] )
  ){
    $_the_title = get_the_title();
    if( in_array('break_title',$theme_opt['base'])){
      $_the_title = preg_replace('/(\,|】|'.__(',','salonote-essence').')/', '$1<br />', $_the_title);
      $_the_title = preg_replace('/(~|〜)/', '<br /><span class="small">$1', $_the_title).'</span>';
    }
    $entry_block_title = array('entry_block_title');
    if( !empty($theme_opt['base']['entry_title']) ){
      $entry_block_title[] = $theme_opt['base']['entry_title'];
    }
    echo '<h1 class="'. implode(' ',$entry_block_title) .'">'.$_the_title;

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


  /*-------------------------------------------*/
  /*	taxonomy_list
  /*-------------------------------------------*/
  get_template_part('template-parts/module/taxonomy_list');


  echo '<div class="shop_menu_page-block grid-inner row">';


  // thumbnail =======================================
  if(
    !empty( $post_type_set ) &&
    in_array('post_thumbnail',$post_type_set )&&
    $page === 1 &&
    has_post_thumbnail()
  ){

    echo '<div class="entry_post_thumbnail col-12 col-md-4">';
    $thumb_attr = array(
      'class'	=> 'img-responsive mb-5',
      'alt'   => trim( strip_tags( get_the_title() )),
      'title' => trim( strip_tags( get_the_title() )),
    );
    $_thumbnail_url = get_the_post_thumbnail($post_id,'profile',$thumb_attr);

    echo '<figure>';

    echo $_thumbnail_url;

    echo '</figure>';

    echo '</div>';
  }

  echo '<div class="staff_profile_block col-12'. (has_post_thumbnail() ? ' col-md-8' : '') .'">';


  // excerpt =======================================
  if(
    !empty( $post_type_set ) &&
    in_array('display_entry_excerpt',$post_type_set )&&
    has_excerpt()
  ){
    echo '<div class="entry_block_excerpt">'.nl2br($post->post_excerpt).'</div>';
  }


  echo '</div>';
  echo '</div>';

  echo '</header>';

}
the_content('more...',true);

if( empty($_POST) ){
require( SHOP_MENU_ESSENCE_PLUGIN_PATH. "/template-parts/print_shop_menu.php");
}


// content footer widget
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('content_inner')): 
	//dynamic_sidebar('content_inner');
endif;


get_paged_nav_title($post);

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