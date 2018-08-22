<?php
// parts
if (!function_exists('parts_custom_post_type')) {
function parts_custom_post_type()
{
    $labels = array(
        'name' => __('parts','salonote-essence'),
        'singular_name' => __('parts','salonote-essence'),
        'add_new' => __('add parts','salonote-essence'),
        'add_new_item' => __('add new parts','salonote-essence'),
        'edit_item' => __('edit parts','salonote-essence'),
        'new_item' => __('new parts','salonote-essence'),
        'view_item' => __('show parts','salonote-essence'),
        'search_items' => __('search parts','salonote-essence'),
        'not_found' => __('no parts','salonote-essence'),
        'not_found_in_trash' => __('no parts in trash','salonote-essence'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_position' => 50,
        'menu_icon' => 'dashicons-tagcloud',
        'has_archive' => true,
        'supports' => array('title','editor','custom-fields'),
        'exclude_from_search' => true
    );
    register_post_type('parts',$args);
}
add_action('init', 'parts_custom_post_type',20);



function salonote__manage_shortcode_columns($columns) {
		unset($columns['thumbnail']);
		unset($columns['date']);
    $columns['shortcode'] = __('shortcode','salonote-essence');
    return $columns;
}
add_filter('manage_edit-parts_columns', 'salonote__manage_shortcode_columns');


function salonote__add_shortcode_column($column_name) {

		$thum = '';
		if ( 'shortcode' == $column_name) {
        $post_id = isset( $post_id) ? $post_id : null;
        $post_type_name = get_post_type($post_id);
        if($post_type_name == 'shortcode' || $post_type_name == 'parts'){
          $thum .= '[essence-parts id=' . get_the_ID() . ']';
        }
		}
    if ( isset($thum) && $thum ) {
        echo $thum;
    }
}
add_action('manage_pages_custom_column', 'salonote__add_shortcode_column');



//parts 挿入
function print_parts_func($atts) {
  extract(shortcode_atts(array(
    'id'      => false,
  ), $atts));
  ob_start();
  if ( !empty($id) ){
      //global $post_id;

      $place = 'parts-content';
      $post = get_post( $id );

      //$_one_page_content = apply_filters('the_contrent', $post->post_content);
      //echo do_shortcode(edit_content_hook($_one_page_content));
			
			echo edit_content_hook(do_shortcode(apply_filters('the_contrent', $post->post_content)));

      do_action( 'essence_onepage_content' );
      do_action( 'essence_onepage_content_only_' . $id ); //１つだけに絞る場合

  };
  
  return ob_get_clean();
}
add_shortcode('essence-parts', 'print_parts_func');
}