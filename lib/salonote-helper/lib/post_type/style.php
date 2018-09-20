<?php
// style
if (!function_exists('style_custom_post_type')) {
function style_custom_post_type()
{
    $labels = array(
        'name' => __('style','salonote-essence'),
        'singular_name' => __('style','salonote-essence'),
        'add_new' => __('add style','salonote-essence'),
        'add_new_item' => __('add new style','salonote-essence'),
        'edit_item' => __('edit style','salonote-essence'),
        'new_item' => __('new style','salonote-essence'),
        'view_item' => __('show style','salonote-essence'),
        'search_items' => __('search style','salonote-essence'),
        'not_found' => __('no style','salonote-essence'),
        'not_found_in_trash' => __('no style in trash','salonote-essence'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_position' => 50,
        'menu_icon' => 'dashicons-id-alt',
        'has_archive' => true,
        'supports' => array('title','editor','excerpt','thumbnail','author','page-attributes','post-formats'),
        'exclude_from_search' => false
    );
    register_post_type('style',$args);
}
add_action('init', 'style_custom_post_type',40);

}