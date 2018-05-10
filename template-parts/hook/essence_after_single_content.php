<?php
global $theme_opt;
global $post_type_set;
global $post_type_name;
//after single body hook


// if has prev ||  next post
if(
  !empty( $post_type_set ) &&
  in_array('display_next_post',$post_type_set)
){
  get_template_part('template-parts/module/paging');
}



?>