<?php
class My_Write_Block_Widget extends WP_Widget{

    function __construct() {
        parent::__construct(
            'writer_block_plugin', // Base ID
            __('writer block','salonote-essence'), // Name
            array( 'description' => __('display writer block','salonote-essence'), ) // Args
        );
    }
 

    public function widget( $args, $instance ) {

        global $post_type_name , $options;
        if( is_singular() ){
          
          
        
          $writer_field=isset($instance['writer_field']) ? $instance['writer_field']: null;
          $auther_ID = get_the_author_meta('ID');
          $auther_description = get_the_author_meta('description');
          $auther_image = !empty(get_the_author_meta('user_meta_image')) ? '<img src="'.get_the_author_meta('user_meta_image').'" width="150">' : get_avatar($auther_ID, 100, true);
          $auther_url 	= get_author_posts_url( get_the_author_meta( 'ID' ));
          $name 	= get_the_author_meta( 'display_name' );
          $user_company = get_the_author_meta( 'user_company' );

          echo $args['before_widget'];
 
           echo ' <div class="widget_author_block">';
					
					if( isset( $writer_field ) ){
                echo '<div class="widget-title text-center mb-5">'.$writer_field . '</div>';
            }
					
            if ( isset( $auther_url ) ){ echo '<a href="' . $auther_url . '">'; }
                
                if( isset( $auther_image ) ){
                     echo '<div class="mod_author_image img-circle text-center">' . $auther_image .'</div>';
                    }
                echo  '<div class="h4 text-center">' . $name. '</div>';
                
                 if( $user_company ){
                echo '<div class="text-center f-x-small mgb20">'. $user_company. '</div>';
                };
                
                if ( isset( $auther_description ) ){
                    echo  '<div class="small mt-3">' . nl2br($auther_description) . '</div>';
                    }
                    
            if ( isset( $auther_url ) ){ echo '</a>'; }
            echo '</div>';
            
          
          echo $args['after_widget'];
        }// is_single

    }
 

    public function form( $instance ){
        $writer_field=isset($instance['writer_field']) ? $instance['writer_field']: null;
        $writer_field_name = $this->get_field_name('writer_field');
        $writer_field_id = $this->get_field_id('writer_field');
        ?>
        <p>
        
            <label for="<?php echo $writer_field_id; ?>"><?php _e('headline','salonote-essence') ?></label>
            <input class="widefat" id="<?php echo $writer_field_id; ?>" name="<?php echo $writer_field_name; ?>" type="text" value="<?php echo esc_attr( $writer_field ); ?>">
        </p>
        <?php
    }

    function update($new_instance, $old_instance) {
        return $new_instance;
    }
}
 
add_action( 'widgets_init', function () {
    register_widget( 'My_Write_Block_Widget' );
} );
