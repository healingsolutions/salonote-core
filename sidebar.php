<?php

global $theme_opt;
global $user_setting;
global $post_type_name;
global $page_info;

	$_side_width = !empty($theme_opt['base']['side_width']) ? $theme_opt['base']['side_width'] : 3 ;
	$sidebar_class = array('sidebar','col-12','col-lg-'.$_side_width);
	if( $_side_width <= 2 ) $sidebar_class[] = 'col-md-'.($_side_width+1);

	// fit-sidebar =======================================
  if( !empty( $theme_opt['base'] ) && in_array('fitSidebar',$theme_opt['base'] ) ){
		$sidebar_class[] = 'fit-sidebar';
  }

	if( !empty( get_theme_mod('side_title_bkg') )) {
		$sidebar_class[] = 'has_sidebar_color';
	}



	echo '<aside id="sidebar" class="'. implode(' ',$sidebar_class) .'">';
		echo '<div class="sidebar_inner">';
			echo '<div class="sidebar_inner__content">';

				if( !empty($page_info['sidebar']) ){
					echo do_shortcode( $page_info['sidebar'] );
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
				
				//post_type sidebar
				if( isset($post_type_name) ){
						if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_name . '_side')): 
								//$post_type_name . '_side'
						endif;
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
	echo '</aside>';
