<?php
class sns_buttons_Widget extends WP_Widget{

    function __construct() {
        parent::__construct(
            'essence_sns_btn_widget', // Base ID
            __('sns buttons','salonote-essence')
        );
    }
  

    public function widget( $args, $instance ) {
      get_template_part('template-parts/module/sns-buttons');
    }
 

    public function form( $instance ){
    }
 
    function update($new_instance, $old_instance) {
        if(!filter_var($new_instance)){
            //return false;
					return $new_instance;
        }
        return $new_instance;
    }
}
 
add_action( 'widgets_init', function () {
    register_widget( 'sns_buttons_Widget' );
} );
