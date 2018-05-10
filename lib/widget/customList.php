<?php
class Essence_CustomList_Widget extends WP_Widget{

    function __construct() {
        parent::__construct(
            'essence_custom_list_widget', // Base ID
            __('custom list','salonote-essence'), // Name
            array( 'description' => __('display custom list','salonote-essence'), ) // Args
        );

    }
  

    public function widget( $args, $instance ) {
			
			global $theme_opt;
			global $post_type_set;

      //$main_content[] = 'main-content-block';
      $main_content[] = 'list-unit';
      $main_content[] = $instance['list_type'] . '-type-group';
      
      
      $args = array(
        'post_type' 		 => $instance['post_type_name'],
				'posts_per_page' => $instance['list_count'],
      );
			
      $query = new WP_Query( $args );
			
			$post_type_set_tmp = $post_type_set;
			$post_type_set = $theme_opt['post_type'][$instance['post_type_name']];
			
			if( !empty($instance['widget_title']) ){
				echo '<div class="widget_title">'.$instance['widget_title'].'</div>';
			}
			
      echo '<div class="'.implode(' ',$main_content).'">';
        if($query->have_posts()): while($query->have_posts()): $query->the_post();
          get_template_part('template-parts/module/list-part');
        endwhile; endif;
      echo '</div>';
			
			$post_type_set = $post_type_set_tmp;
			wp_reset_query();
    }

    public function form( $instance ){
			
			$args = array(
				'public'   => true,
				'_builtin' => false
			);
			$post_types = get_post_types( $args, 'names' );



		//array_unshift($post_types, "author");
		//array_unshift($post_types, "page");
		array_unshift($post_types, "post");
		//array_unshift($post_types, "front_page");
			
		$post_types_array = get_post_type_list($post_types);
			
    global $field_arr;
    $field_arr = array(
				'widget_title' => array(
            'label' => __('title','salonote-essence'),
            'type'  => 'text'
        ),
        'post_type_name' => array(
            'label' => __('post type','salonote-essence'),
            'type'  => 'select',
								'selecter' => $post_types_array
        ),
        'list_type' => array(
            'label' => __('list type','salonote-essence'),
            'type'  => 'select',
								'selecter' => array(
												'list'  => __('list','salonote-essence'),
												'grid'  => __('grid','salonote-essence'),
												'timeline' => __('timeline','salonote-essence'),
								)
        ),
        'list_count' => array(
            'label'       => __('display number','salonote-essence'),
            'type'        => 'number',
        ),
      );
      $field_key = 'widget-'. $this->id_base .'['.$this->number.']';
			
			if(is_user_logged_in()){
				//echo '<pre>'; echo($this->get_field_name('post_type_name')); echo '</pre>';
				//echo '<pre>'; print_r($this); echo '</pre>';
				//echo '<pre>'; print_r($instance); echo '</pre>';
			}
			
			
      essence_theme_opiton_form($field_key,$field_arr,$instance,'dldtdd');


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
    register_widget( 'Essence_CustomList_Widget' );
} );