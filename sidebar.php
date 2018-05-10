<?php

global $theme_opt;
global $user_setting;
global $post_type_name;
global $page_info;

	$sidebar_class = array('sidebar','col-xs-12','col-sm-3');

	// fit-sidebar =======================================
  if( !empty( $theme_opt['base'] ) && in_array('fitSidebar',$theme_opt['base'] ) ){
		$sidebar_class[] = 'fit-sidebar';
  }


	echo '<div id="sidebar" class="'. implode(' ',$sidebar_class) .'">';
		echo '<div class="sidebar_inner">';
			echo '<div class="sidebar_inner__content">';

				if( !empty($page_info['sidebar']) ){
					echo do_shortcode( $page_info['sidebar'] );
				}

				//post_type sidebar
				if( isset($post_type_name) ){
						if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_name . '_side')): 
								//$post_type_name . '_side'
						endif;
				}


        // action essence_before_single_content =============================
        if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_before_sidebar]</span>';}
        do_action( 'essence_before_sidebar' );
        // ^action =============================


				//has-parent-list
        get_template_part('template-parts/module/has-parent-list');
	
				//taxonomy
				if( is_tax() ){
          get_template_part('template-parts/module/has-taxonomy-list');
				}
				

				

				if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar')): 
						//sidebar
				endif;

				//inline links
				if(isset($index_nav)){
					echo $index_nav;
				}
  
        // action essence_before_single_content =============================
        if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_after_sidebar]</span>';}
        do_action( 'essence_after_sidebar' );
        // ^action =============================
	
			echo '</div>';
		echo '</div>';
	echo '</div>';
