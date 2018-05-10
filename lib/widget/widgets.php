<?php

//do_shortcode on widget text
add_filter('widget_text', 'do_shortcode' );


/*-------------------------------------------*/
/*	widgets
/*-------------------------------------------*/
    if (function_exists('register_sidebar')) {

     
     //コンテンツ内ウィジェット定義
     register_sidebar(array(
        'name' => __('inner content','salonote-essence'),
        'id' => 'content_inner',
        'description' => __('inner content','salonote-essence'),
        'before_widget' => '<div class="content_block_widget">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title bdr-btm-1">',
        'after_title' => '</div>'
    ));
 
 
    //コンテンツフッターウィジェット定義
    register_sidebar(array(
         'name' => __('bottom content','salonote-essence'),
         'id' => 'content_footer',
         'description' => __('display widget in bottom of content','salonote-essence'),
         'before_widget' => '<div class="main-block-footer">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title bdr-btm-1">',
        'after_title' => '</div>'
     ));
    
      
      
    //コンテンツフッターウィジェット定義
    register_sidebar(array(
         'name' => __('footer','salonote-essence'),
         'id' => 'footer',
         'description' => __('display widghet in footer','salonote-essence'),
         'before_widget' => '<div class="widget-footer">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title bdr-btm-1">',
        'after_title' => '</div>'
     ));
    

    //サイドウィジェット定義
    register_sidebar(array(
        'name' => __('side widget','salonote-essence'),
        'id' => 'sidebar',
        'description' => __('display widghet in sidebar','salonote-essence'),
        'before_widget' => '<div id="%1$s" class="side-block-item %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title bdr-btm-1">',
        'after_title' => '</div>'
    ));
      
    //ナビ直下
    register_sidebar(array(
        'name' => __('bottom of navigation','salonote-essence'),
        'id' => 'front_before_widgets',
        'description' => __('display widghet in bottom of navigation','salonote-essence'),
        'before_widget' => '<div class="front-top-before l-box">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget-title bdr-btm-1">',
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
                        'description' => sprintf(__('display widget on %s common upper part','salonote-essence'),$post_type_label),
                        'before_widget' => '<div class="posttype-bottom">',
                        'after_widget' => '</div>',
                        'before_title' => '<div class="widget-title bdr-btm-1">',
                        'after_title' => '</div>'
                    ));
					
                    register_sidebar(array(
                        'name' => $post_type_label. __('Common bottom part','salonote-essence'),
                        'id' => $post_type_name. '_after_widgets',
                        'description' =>  sprintf(__('display widget on %s common bottom part','salonote-essence'),$post_type_label),
                        'before_widget' => '<div class="posttype-bottom">',
                        'after_widget' => '</div>',
                        'before_title' => '<div class="widget-title bdr-btm-1">',
                        'after_title' => '</div>'
                    ));
                    
                    //ポストタイプウィジェット
                    register_sidebar(array(
                        'name' => $post_type_label. __('Common side part','salonote-essence'),
                        'id' => $post_type_name. '_side',
                        'description' =>  sprintf(__('display widget on %s common side part','salonote-essence'),$post_type_label),
                        'before_widget' => '<div class="posttype-side mgb-50">',
                        'after_widget' => '</div>',
                        'before_title' => '<div class="widget-title bdr-btm-1">',
                        'after_title' => '</div>'
                    ));
					
										//ポストタイプウィジェット
                    register_sidebar(array(
                        'name' => $post_type_label. __('on content bottom','salonote-essence'),
                        'id' => $post_type_name. '_after_content',
                        'description' =>  $post_type_label. sprintf(__('display widget on %s page content bottom','salonote-essence'),$post_type_label),
                        'before_widget' => '<div class="posttype-content">',
                        'after_widget' => '</div>',
                        'before_title' => '<div class="widget-title bdr-btm-1">',
                        'after_title' => '</div>'
                    ));
    }
     
}//register_sidebar

/*-------------------------------------------*/
/*	disable display title if before #
/*-------------------------------------------*/
add_filter( 'widget_title', 'remove_widget_title' );
function remove_widget_title( $widget_title ) {
	if ( substr ( $widget_title, 0, 1 ) == '#' )
		return;
  else{
		return ( $widget_title );
  }
}
     



/*-------------------------------------------*/
/* add class for recent_posts
/*-------------------------------------------*/
class My_WP_Widget_Recent_Posts extends WP_Widget_Recent_Posts{
 
    function widget($args, $instance) {
        $cache = wp_cache_get('widget_recent_posts', 'widget');
 
        if ( !is_array($cache) )
            $cache = array();
 
        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;
 
        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }
 
        ob_start();
        extract($args);
 
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts','salonote-essence') : $instance['title'], $instance, $this->id_base);
        if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
            $number = 10;
 
        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
?>
        <?php echo $before_widget; ?>
        <?php if ( $title ) echo $before_title . $title . $after_title; ?>
        <ul class="mod_list_bdr">
        <?php  while ($r->have_posts()) : $r->the_post(); ?>
        <li><a href="<?php the_permalink() ?>" title="<?php echo esc_attr(strip_tags(get_the_title()) ? strip_tags(get_the_title()) : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
        <?php endwhile; ?>
        </ul>
        <?php echo $after_widget; ?>
<?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
 
        endif;
 
        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }
}