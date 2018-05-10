<?php
// list


global $post;
global $post_type_set;
global $user_setting;
global $theme_mods;
global $post_taxonomies;

//echo $post->ID;
$page_info = get_post_meta($post->ID,'page_info',true);

$exclude_list = !empty( $page_info['exclude_list'] ) ? intval( $page_info['exclude_list']) : null ;
if( $exclude_list !== 1){

?>


<div id="list-item-<?php echo $post->ID;?>" class="list_item_block<?php
                                                   if( !empty($theme_mods['list_bdr_color']) )
                                                     echo ' has_list_bdr';
                                                   if(
                                                     !has_post_thumbnail($post->ID) ||
                                                     empty( get_the_post_thumbnail_url($post->ID) )
                                                    )
                                                    echo ' none_post_thumbnail';
                                                   ?>">
<?php

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
		echo '<div class="list-taxonomy-block">';
		foreach($post_taxonomies as $tax_item){
			echo get_the_term_list($post->ID ,$tax_item, '<span>', '</span><span>', '</span>');
		}
		echo '</div>';
	}
?>
</div>


<?php
};
?>