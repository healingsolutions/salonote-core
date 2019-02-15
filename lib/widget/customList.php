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
			global $post_type;

			
						
      //$main_content[] = 'main-content-block';
      $main_content[] = 'list-unit';
      $main_content[] = $instance['list_type'] . '-type-group';
			
			if( !empty($post_type_set['grid_cols']) ) {
				$main_content[] = 'grid_cols-'.$post_type_set['grid_cols'];
			}else{
				$main_content[] = 'grid_cols-4';
			}
      
			if( $instance['list_type'] === 'carousel' ){
				$instance['list_count'] = 12;
			}
      
			
			$post_type = $instance['post_type_name'];
      $query_args = array(
        'post_type' 		 => $instance['post_type_name'],
				'posts_per_page' => $instance['list_count'],
      );
			
			if( !empty($instance['taxonomy']) ){
				$query_args['tax_query'] = array(
						array(
							'taxonomy' => $instance['taxonomy'],
							'field'    => 'slug',
							'terms'    => '',
					),
				);
			}
 
      
      $paged = (get_query_var('page')) ? get_query_var('page') : 1;
      $query_args['paged'] = $paged;
			
      $query = new WP_Query( $query_args );
			
			$post_type_set_tmp = $post_type_set;
      
      if( is_array($instance['post_type_name']) ){
        $post_type_set = $theme_opt['post_type'][$instance['post_type_name'][0]];
      }else{
        $post_type_set = $theme_opt['post_type'][$instance['post_type_name']];
      }
			
			
			if( is_array($post_type_set) ){
			$post_type_set = array_diff($post_type_set, array(
				'display_grid_title',
				'display_list_writer',
				'display_entry_excerpt',
				'display_grid_sub_title',
				'display_list_term',
				'display_other_post',
        'display_post_date',
				//'display_thumbnail',
			));
			}
			$post_type_set['list_show_excerpt'] = null;

			if( !empty($instance['enable_excerpt'])) $post_type_set['list_show_excerpt'] = $instance['enable_excerpt'];
			if( !empty($instance['post_data_format'])) $post_type_set['post_data_format'] = $instance['post_data_format'];
			
			if( in_array('enable_title',$instance) ) $post_type_set[] = 'display_grid_title';
			if( in_array('enable_writer',$instance) ) $post_type_set[] = 'display_list_writer';
			if( in_array('enable_thumbnail',$instance) ) $post_type_set[] = 'display_thumbnail';
			if( in_array('enable_tax',$instance) ) $post_type_set[] = 'display_list_term';
      if( in_array('enable_post_type',$instance) ) $post_type_set[] = 'display_post_type';
      if( in_array('enable_date',$instance) ) $post_type_set[] = 'display_post_date';
      
      $post_type_set['show_post_type'] = $instance['post_type_name'];
      

			
			echo !empty($args['before_widget']) ? $args['before_widget'] : '' ;
			
			if( !empty($instance['widget_title']) ){
        echo '<div class="widget-title'. (!empty($theme_opt['base']['widget_title']) ? ' '.$theme_opt['base']['widget_title'] : '' ).'">';
				echo $instance['widget_title'].'</div>';
			}
			
      echo '<div class="'.implode(' ',$main_content).'">';
			
				if( $instance['list_type'] === 'calendar' ){
					get_template_part('template-parts/module/parts/calendar-block');
					return;
				}else{
						if($query->have_posts()): while($query->have_posts()): $query->the_post();
							get_template_part('template-parts/module/list-part');
						endwhile; endif;
          
				}
      echo '</div>';
			
			$post_type_set = $post_type_set_tmp;
			wp_reset_query();
			
			
			echo !empty($args['after_widget']) ? $args['after_widget'] : '' ;
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
			
			
		$tax_args = array(
			'public'   => true,
			'_builtin' => false
		); 
		$taxonomy_array = get_taxonomies($tax_args,'names');

			
    global $field_arr;
    $field_arr = array(
				'widget_title' => array(
            'label' => __('title','salonote-essence'),
            'type'  => 'text'
        ),
        'post_type_name' => array(
            'label' => __('post type','salonote-essence'),
            'type'  => 'checkboxlist',
								'selecter' => $post_types_array
        ),
			
				'taxonomy' => array(
            'label' => __('custom list taxonomy','salonote-essence'),
            'type'  => 'select',
								'selecter' => $taxonomy_array
        ),
			
			
			/*
				'terms' => array(
            'label' => __('custom list term','salonote-essence'),
            'type'  => 'select',
								'selecter' => $terms_array
        ),
			*/
			
				'enable_title' => array(
            'label' => __('enable Title','salonote-essence'),
            'type'  => 'checkbox'
        ),

				'enable_excerpt' => array(
            'label' => __('enable excerpt','salonote-essence'),
            'type' => 'select',
							'selecter' => array(
								'body' =>  __('has excerpt','salonote-essence'),
								'trim' =>  __('trim','salonote-essence'),
							)
        ),
				'enable_writer' => array(
            'label' => __('enable writer','salonote-essence'),
            'type'  => 'checkbox'
        ),
				'enable_date' => array(
            'label' => __('enable date','salonote-essence'),
            'type'  => 'checkbox'
        ),
				'post_data_format' => array(
            'label'       => __('data format','salonote-essence'),
            'type'        => 'text',
        ),
				'enable_thumbnail' => array(
            'label' => __('enable thumbnail','salonote-essence'),
            'type'  => 'checkbox'
        ),
			
				'enable_tax' => array(
            'label' => __('enable tax','salonote-essence'),
            'type'  => 'checkbox'
        ),
        'enable_post_type' => array(
            'label' => __('enable post_type','salonote-essence'),
            'type'  => 'checkbox'
        ),
			
        'list_type' => array(
            'label' => __('list type','salonote-essence'),
            'type'  => 'select',
								'selecter' => array(
												'list'  		=> __('list','salonote-essence'),
                        'plane'  		=> __('plane','salonote-essence'),
												'grid'  		=> __('grid','salonote-essence'),
												'timeline' 	=> __('timeline','salonote-essence'),
												'carousel' 	=> __('carousel','salonote-essence'),
												'calendar' 	=> __('calendar','salonote-essence'),
								)
        ),
        'list_count' => array(
            'label'       => __('display number','salonote-essence'),
            'type'        => 'number',
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
