<?php
//echo 'after single body hook';

global $theme_opt;
global $post_type_set;
global $post_type_name;



// front_page ===============
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('front_bottom_widgets')){
  //front_bottom_widgets
}
?>