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

// キャラクター
function es_character_custom_post_type()
{
    $labels = array(
        'name'                => _x('キャラクター', 'post type general name'),
        'singular_name'       => _x('キャラクター', 'post type singular name'),
        'add_new'             => _x('キャラクターを追加', 'es_character'),
        'add_new_item'        => __('新しいキャラクターを追加'),
        'edit_item'           => __('キャラクターを編集'),
        'new_item'            => __('新しいキャラクター'),
        'view_item'           => __('キャラクターを表示'),
        'search_items'        => __('キャラクターを探す'),
        'not_found'           => __('キャラクターがありません'),
        'not_found_in_trash'  => __('ゴミ箱にキャラクターがありません'),
        'parent_item_colon'   => ''
    );
    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'query_var'           => true,
        'rewrite'             => false,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 51,
        'menu_icon'           => 'dashicons-format-status',
        'has_archive'         => false,
        'supports'            => array('title'),
        'exclude_from_search' => true,
				'show_in_rest'			  => true,
				'rest_base'   				=> 'es_character',
    );
    register_post_type('es_character',$args);
    }
add_action('init', 'es_character_custom_post_type',20);





// ======================

/**
* 投稿一覧ソート機能
*
*/
function character_sortable_columns($sort_column) {
  $sort_column['parent_post'] = 'parent_post';
  return $sort_column;
}

function character_orderby_columns( $vars ) {
  if (isset($vars['orderby']) && 'parent_post' == $vars['orderby']) {
    $vars = array_merge($vars, array(
      'orderby' => 'title',
    ));
  }
  return $vars;

}
add_filter( 'manage_edit-es_character_sortable_columns', 'character_sortable_columns' ); // manage_edit-[post_type]_sortable_columns
add_filter( 'request', 'character_orderby_columns' );

?>