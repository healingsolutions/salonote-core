<?php
class extra_archive_Widget extends WP_Widget{

    function __construct() {
        parent::__construct(
            'extra_archive_Widget', // Base ID
            __('post type archive link','salonote-essence'), // Name
            array( 'description' => __('display post type archive link','salonote-essence'), ) // Args
        );
    }
 

    public function widget( $args, $instance ) {
        global $options,$post_type,$post_type_set;

        $extra_archive_title = isset($instance['extra_archive_title']) ? $instance['extra_archive_title']: null;
      
        $post_type = 'report';
 
        echo $args['before_widget'];
        echo '<ul>';
        wp_get_archives('type=monthly&post_type='. $post_type .'&show_post_count=1&limit=999');
        echo '</ul>';
        
        echo '</div>';
        echo $args['after_widget'];

    }

    public function form( $instance ){
        $extra_archive_title=isset($instance['extra_archive_title']) ? $instance['extra_archive_title']: null;
        $extra_archive_title_tag = $this->get_field_name('extra_archive_title');
        ?>
        
        
        <p>
            <label for="<?php echo $extra_archive_title_tag; ?>"><?php _e('headline','salonote-essence') ?></label><br>
            <input class="w-80" id="<?php echo $extra_archive_title_tag; ?>" name="<?php echo $extra_archive_title_tag; ?>" type="text" value="<?php echo  $extra_archive_title ; ?>">
        </p>
        
        <?php
    }

    function update($new_instance, $old_instance) {

        return $new_instance;
    }
}
 
add_action( 'widgets_init', function () {
    register_widget( 'extra_archive_Widget' );
} );
