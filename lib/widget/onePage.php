<?php
class My_One_Page_Widget extends WP_Widget{

    function __construct() {
        parent::__construct(
            'my_onePage_plugin', // Base ID
            __('page content','salonote-essence'), // Name
            array( 'description' => __('display page content','salonote-essence'), ) // Args
        );
    }
 

    public function widget( $args, $instance ) {
        
        global $post_id,$display_date,$display_title,$field;
        $post_id = isset($instance['onepage_tag']) ? $instance['onepage_tag']: null;
        $onepage_class=isset($instance['onepage_class']) ? $instance['onepage_class']: null;

        
        if ( !empty($post_id) ){
            echo $args['before_widget'];
            //global $post_id;
						$place = 'parts-content';
            $post = get_post( $post_id );
            
            if( !empty( $onepage_class) ){ echo '<div class="'. $onepage_class . '">'; };
            $_one_page_content = apply_filters('the_contrent', $post->post_content);

						echo do_shortcode(wpautop($_one_page_content));

					
						do_action( 'essence_onepage_content' );
						do_action( 'essence_onepage_content_only_' . $post_id );

          
            if( !empty( $onepage_class) ){ echo '</div>'; };
            
            echo $args['after_widget'];
        };
        
        $post_id = null;
        wp_reset_query(); 
    }
 
    public function form( $instance ){
        $onepage_tag=isset($instance['onepage_tag']) ? $instance['onepage_tag']: null;
        $onepage_tag_name = $this->get_field_name('onepage_tag');
        $onepage_tag_id = $this->get_field_id('onepage_tag');
        
        $onepage_class=isset($instance['onepage_class']) ? $instance['onepage_class']: null;
        $onepage_class_name = $this->get_field_name('onepage_class');
        $onepage_class_id = $this->get_field_id('onepage_class');
        ?>

        <p>
        <label for="<?php echo $onepage_tag_id; ?>"><?php _e('pages','salonote-essence'); ?></label>
        <select  class="widefat" name="<?php echo $onepage_tag_name; ?>" id="<?php echo $onepage_tag_id; ?>"> 
         <option value=""><?php _e('select page','salonote-essence'); ?></option> 
        
         <?php 
         $args = array(
              'numberposts' => -1, 
              'post_type' => array('page','parts')
          );
          $pages = get_posts($args);
          foreach ( $pages as $page ) {
            $check_page_id = $page->ID;
            $option = '<option value="' . $check_page_id.'"';
            if( $check_page_id == $onepage_tag  ){
                $option .= ' selected';
            }
            $option .= '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
          }
         ?>
        </select>
        </p>
        
        <p>
           <label for="<?php echo $onepage_class_id; ?>">class</label>
            <input class="widefat" id="<?php echo $onepage_class_id; ?>" name="<?php echo $onepage_class_name; ?>" type="text" value="<?php echo esc_attr( $onepage_class ); ?>">
        </p>
        
        <?php
    }
 
    function update($new_instance, $old_instance) {
        if(!filter_var($new_instance['onepage_tag'])){
            return false;
        }
        return $new_instance;
    }
}
 
add_action( 'widgets_init', function () {
    register_widget( 'My_One_Page_Widget' );
});