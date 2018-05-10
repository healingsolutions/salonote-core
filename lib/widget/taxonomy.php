<?php
class CustomCat_Widget extends WP_Widget{
    /**
     * CustomCat Widgetを登録する
     */
    function __construct() {
        parent::__construct(
            'CustomCat_Widget', // Base ID
            __('custom category','salonote-essence'), // Name
            array( 'description' => __('category list','salonote-essence'), ) // Args
        );
    }
 

    public function widget( $args, $instance ) {
        global $options,$post_type,$post_type_set;

        $CustomCat_title = isset($instance['CustomCat_title']) ? $instance['CustomCat_title']: null;
        $show_taxonomy=isset($options[$post_type_name . '_taxonomy']['slug']) ? $options[$post_type_name . '_taxonomy']['slug']: false;
      
        $taxonomy = !empty($post_type_set['taxonomy']) ? $post_type_set['taxonomy'] : 'category';
      
        if( !empty($taxonomy) ){
        
        $tax_info = get_categories(array(
            'taxonomy' => $taxonomy ,
            //'orderby' => 'count',
            //'order'     => 'DESC',
        ));
        
        echo $args['before_widget'];
          

        echo '<div class="tax-list-group topic-list mod_hover-list inner mgb-50">';
                
                if( isset($CustomCat_title) ){ echo '<div class="title_bdr_tbtm">'. $CustomCat_title .'</div>'; }
                
                if( array($tax_info)){
                    echo '<ul class="l-sidebar__side-list">';
                    
                    foreach ($tax_info as $category) {
                        if( $category->count != 0) :
                     ?>
                        <li class="bdr-btm-1-dotted pgl-20"><a href="<?php echo  get_term_link( $category ) ; ?>">
                            <?php echo $category->cat_name; ?>
                            <?php /* <span class="badge"><?php echo $category->count; ?></span> */ ?>
                        </a></li>
                        <?php
                         endif;
                 };
        echo '</ul>';
        }
        
        echo '</div>';
        echo $args['after_widget'];
       wp_reset_query(); 
        }//endif;
    }
 

    public function form( $instance ){
        $CustomCat_title=isset($instance['CustomCat_title']) ? $instance['CustomCat_title']: null;
        $CustomCat_title_tag = $this->get_field_name('CustomCat_title');
        ?>
        
        
        <p>
            <label for="<?php echo $CustomCat_title_tag; ?>"><?php _e('headline','salonote-essence') ?></label><br>
            <input class="w-80" id="<?php echo $CustomCat_title_tag; ?>" name="<?php echo $CustomCat_title_tag; ?>" type="text" value="<?php echo  $CustomCat_title ; ?>">
        </p>
        
        <?php
    }

    function update($new_instance, $old_instance) {

        return $new_instance;
    }
}
 
add_action( 'widgets_init', function () {
    register_widget( 'CustomCat_Widget' );
} );
