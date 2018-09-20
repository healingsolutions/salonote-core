<?php


/*  Copyright 2016 Healing Solutions (email : info@healing-solutions.jp)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}



// お問い合わせ
function es_mailform_custom_post_type()
{
    $labels = array(
        'name'                => _x('お問い合わせ', 'post type general name'),
        'singular_name'       => _x('お問い合わせ', 'post type singular name'),
        'add_new'             => _x('お問い合わせを追加', 'mailform'),
        'add_new_item'        => __('新しいお問い合わせを追加'),
        'edit_item'           => __('お問い合わせを編集'),
        'new_item'            => __('新しいお問い合わせ'),
        'view_item'           => __('お問い合わせを表示'),
        'search_items'        => __('お問い合わせを探す'),
        'not_found'           => __('お問い合わせはありません'),
        'not_found_in_trash'  => __('ゴミ箱にお問い合わせはありません'),
        'parent_item_colon'   => ''
    );
    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'query_var'           => true,
        'rewrite'             => false,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 50,
        'menu_icon'           => 'dashicons-email',
        'has_archive'         => false,
        'supports'            => array('title'),
        'exclude_from_search' => true,
				'show_in_rest'			  => true,
				'rest_base'   				=> 'es_mailform',
    );
    register_post_type('es_mailform',$args);
    }
add_action('init', 'es_mailform_custom_post_type',23);



function customize_admin_manage_mailform_columns($columns) {
  global $post_type_name;
  if( $post_type_name !== 'es_mailform') {
    unset($columns['date']);
    unset($columns['thumbnail']);
    
    $columns['shortcode'] = 'ショートコード';
  }
  return $columns;

}
function customize_mailform_add_column($column_name) {
    if ( 'shortcode' == $column_name) {
        $post_id = isset( $post_id) ? $post_id : null;
        $post_type = get_post_type($post_id);
        if($post_type === 'es_mailform'){
          $thum = '[essence-mailform-pro id=' . get_the_ID() . ']';
        }
    }
    if ( isset($thum) && $thum ) {
        echo $thum;
    }
}
add_filter('manage_edit-es_mailform_columns', 'customize_admin_manage_mailform_columns');
add_action('manage_posts_custom_column', 'customize_mailform_add_column');



?>