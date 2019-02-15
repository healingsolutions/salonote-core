<?php

//do_shortcode on widget text
add_filter('widget_text', 'do_shortcode' );

global $theme_opt;


/*-------------------------------------------*/
/*	widgets
/*-------------------------------------------*/
    if (function_exists('register_sidebar')) {
			
		//ページ最上部
    register_sidebar(array(
        'name' => __('top of page','salonote-essence'),
        'id' => 'header_top_widgets',
        'description' => __('display widghet in top of page','salonote-essence'),
        'before_widget' => '<div id="%1$s" class="%2$s header_top_widgets">',
        'after_widget' => '</div>',
        //'before_title' => '<div class="widget-title bdr-btm-1">',
        //'after_title' => '</div>'
    ));
			
		//コンテンツヘッダーウィジェット定義
    register_sidebar(array(
         'name' => __('top content','salonote-essence'),
         'id' => 'content_top',
         'description' => __('display widget in top of content','salonote-essence'),
         'before_widget' => '<div id="%1$s" class="%2$s main-block-top_widget">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>'
     ));

     
     //コンテンツ内ウィジェット定義
     register_sidebar(array(
        'name' => __('inner content','salonote-essence'),
        'id' => 'content_inner',
        'description' => __('inner content','salonote-essence'),
        'before_widget' => '<div id="%1$s" class="%2$s content_block_widget">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>'
    ));
 
 
    //コンテンツフッターウィジェット定義
    register_sidebar(array(
         'name' => __('bottom content','salonote-essence'),
         'id' => 'content_footer',
         'description' => __('display widget in bottom of content','salonote-essence'),
        'before_widget' => '<div id="%1$s" class="%2$s main-block-footer">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>'
     ));
    
      
      
    //コンテンツフッターウィジェット定義
    register_sidebar(array(
			'name' => __('footer','salonote-essence'),
			'id' => 'footer',
			'description' => __('display widghet in footer','salonote-essence'),
			'before_widget' => '<div id="%1$s" class="%2$s footer-widget-block">',
      'after_widget' => '</div>',
			'before_title' => '<div class="widget-title">',
			'after_title' => '</div>'
     ));
    

    //サイドウィジェット定義
    register_sidebar(array(
			'name' => __('side widget','salonote-essence'),
			'id' => 'sidebar',
			'description' => __('display widghet in sidebar','salonote-essence'),
			'before_widget' => '<div id="%1$s" class="side-block-item mb-3 %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widget-title'. (!empty($theme_opt['base']['widget_title']) ? ' '.$theme_opt['base']['widget_title'] : '' ).'">',
			'after_title' => '</div>'
    ));
      
    //ナビ直下
    register_sidebar(array(
        'name' => __('bottom of navigation','salonote-essence'),
        'id' => 'front_before_widgets',
        'description' => __('display widghet in bottom of navigation','salonote-essence'),
        'before_widget' => '<div id="%1$s" class="%2$s front-top-before l-box">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title">',
        'after_title' => '</div>'
    ));
    

    
    //サイドウィジェット定義
    register_sidebar(array(
        'name' => __('bottom of smartphone navigation','salonote-essence'),
        'id' => 'sp_nav_bottom',
        'description' => __('display widghet in bottom of smartphone navigation','salonote-essence'),
        'before_widget' => '<div class="sp_nav_bottom">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title bdr-btm-1">',
        'after_title' => '</div>'
    ));
      



        $args = array(
           'public'   => true,
           '_builtin' => false
        );

        $post_types = get_post_types( $args, 'names' );
        array_push($post_types, "front_page");
        array_push($post_types, "post");
        array_push($post_types, "page");
        array_push($post_types, "author");

        
        foreach ( $post_types as $post_type_name ) {
					
					if( !empty($post_type_name) && $post_type_name !== 'front_page' ){
						$post_type_label = !empty(get_post_type_object($post_type_name)->labels->singular_name) ? get_post_type_object($post_type_name)->labels->singular_name : null ;
					}else{
						$post_type_label = __('front-page','salonote-essence');
					}
          if( empty($post_type_label) ) continue;

                   //post_type widget
                    register_sidebar(array(
                        'name' => $post_type_label. __('Common upper part','salonote-essence'),
                        'id' => $post_type_name. '_before_widgets',
                        'description' => sprintf(__('display widget on %s common upper part','salonote-essence'),$post_type_label). $post_type_name. '_before_widgets',
                        'before_widget' => '<div id="%1$s" class="%2$s '. $post_type_name. '_before_widgets">',
                        'after_widget' => '</div>',
                        'before_title' => '<h2 class="widget-title">',
                        'after_title' => '</h2>'
                    ));
					
                    register_sidebar(array(
                        'name' => $post_type_label. __('Common bottom part','salonote-essence'),
                        'id' => $post_type_name. '_after_widgets',
                        'description' =>  sprintf(__('display widget on %s common bottom part','salonote-essence'),$post_type_label). $post_type_name. '_after_widgets',
                        'before_widget' => '<div id="%1$s" class="%2$s '.$post_type_name. '_after_widgets mb-3">',
                        'after_widget' => '</div>',
                        'before_title' => '<h2 class="widget-title">',
                        'after_title' => '</h2>'
                    ));
                    
                    //ポストタイプウィジェット
                    register_sidebar(array(
                        'name' => $post_type_label. __('Common side part','salonote-essence'),
                        'id' => $post_type_name. '_side',
                        'description' =>  sprintf(__('display widget on %s common side part','salonote-essence'),$post_type_label). $post_type_name. '_side',
                        'before_widget' => '<div id="%1$s" class="%2$s '.$post_type_name.'-posttype-side mgb-50">',
                        'after_widget' => '</div>',
                        'before_title' => '<div class="widget-title'. (!empty($theme_opt['base']['widget_title']) ? ' '.$theme_opt['base']['widget_title'] : '' ).'">',
                        'after_title' => '</div>'
                    ));
					
										//ポストタイプウィジェット
                    register_sidebar(array(
                        'name' => $post_type_label. __('on content bottom','salonote-essence'),
                        'id' => $post_type_name. '_after_content',
                        'description' =>  $post_type_label. sprintf(__('display widget on %s page content bottom','salonote-essence'),$post_type_label) . $post_type_name. '_after_content',
                        'before_widget' => '<div id="%1$s" class="%2$s '.$post_type_name.'-posttype-content">',
                        'after_widget' => '</div>',
                        'before_title' => '<h2 class="widget-title">',
                        'after_title' => '</h2>'
                    ));
    }
     
}//register_sidebar

/*-------------------------------------------*/
/*	disable display title if before #
/*-------------------------------------------*/

function remove_widget_title( $widget_title ) {
	if ( substr ( $widget_title, 0, 1 ) == '#' )
		return;
  else{
		return ( $widget_title );
  }
}
add_filter( 'widget_title', 'remove_widget_title' );
     

