<?php
// list


global $post;
global $post_type;
global $post_type_set;
global $user_setting;
global $theme_mods;
global $post_taxonomies;

//echo $post->ID;
$page_info = get_post_meta($post->ID,'page_info',true);

$exclude_list = !empty( $page_info['exclude_list'] ) ? intval( $page_info['exclude_list']) : null ;
if( $exclude_list !== 1){



?>


<section id="list-item-<?php echo $post->ID;?>" class="list_item_block<?php
if( !empty($theme_mods['list_bdr_color']) ){
	echo ' has_list_bdr';
}
if(
	!has_post_thumbnail($post->ID) ||
	empty( get_the_post_thumbnail_url($post->ID) )
){
	echo ' none_post_thumbnail';
}
if(
	!empty( $post_type_set ) &&
	in_array('display_post_writer',$post_type_set)
){
	echo ' has_post_writer';
}
if(
	!empty($post_type_set['list_position_excerpt'])
){
	echo ' excertp_position-'.$post_type_set['list_position_excerpt'];
}
  
if( has_category()){
  $cat_arr = wp_get_post_categories( $post->ID );
  if( !empty($cat_arr)){
    foreach( $cat_arr as $cat_item ){
      $cat_info = get_category( $cat_item );
      echo ' cat_name-' . esc_attr($cat_info->name);
      echo ' cat_slug-' . esc_attr($cat_info->slug);
    }
  }
	
}              
                         
                         
?>">
<?php
												 
	if(
		!empty( $post_type_set ) &&
		in_array('display_list_writer',$post_type_set)
	){
		$auther_ID = get_the_author_meta('ID');
		if( get_avatar($auther_ID, 80, true) ){
				$auther_image = get_avatar( $auther_ID, 48, false, get_the_title() .'の執筆者-' .get_the_author_meta('display_name') );
				$auther_url 	= get_author_posts_url( $auther_ID);
		}
		if( isset($auther_image) ){
				echo '<div class="list_block_writer post-avatar">
				<a href="'. $auther_url .'">' .$auther_image. '</a>
				</div>';
		}
	}

  // link =======================================
  $_link_check = !empty( $post_type_set['list_none_href'] ) ? true : false ;
  if(!empty( $post_type_set ) && $_link_check !== true){
    echo '<a href="'.get_the_permalink().'">';
	}
    
    get_template_part( 'template-parts/module/list-part-inner' );

  // action essence_list_part_inner =============================
  if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_list_part_inner]</span>';}
  do_action( 'essence_list_part_inner' );
  // ^action =============================
  
  if(!empty( $post_type_set ) && $_link_check !== true){
    echo '</a>';
	}
												 
	
	
	
	
	if(
		!is_tax() &&
		!empty( $post_type_set ) &&
		in_array('display_list_term',$post_type_set)
	){
    $post_type_name  = get_post_type();
    $post_taxonomies = [];
    $post_type_taxonomies = get_object_taxonomies( ( ($post_type_name !== 'front_page') ? $post_type_name : 'post') , 'objects' );

    if ( !empty($post_type_taxonomies) ) {
      foreach( $post_type_taxonomies as $post_type_taxonomy ) {
        if( is_object($post_type_taxonomy) ){
          $post_taxonomies[] = $post_type_taxonomy->name;
        }
      }
    }
    
		echo '<div class="list-taxonomy-block">';
		foreach($post_taxonomies as $tax_item){
			echo get_the_term_list($post->ID ,$tax_item, '<span>', '</span><span>', '</span>');
		}
		echo '</div>';
	}
                         
                         
                         
  if(
    
		!empty( $post_type_set ) &&
		in_array('display_post_type',$post_type_set) &&
    count($post_type_set['show_post_type']) > 1
	){
    $entry_post_type = get_post_type( $post );
		if( isset($entry_post_type) ){
        
        $obj = get_post_type_object( $entry_post_type );
				echo '<div class="list_block_post-type">
				<a class="btn-color" href="'. get_post_type_archive_link( $entry_post_type ) .'">' .$obj->labels->singular_name. '</a>
				</div>';
		}
	}
?>
</section>


<?php
};
?>