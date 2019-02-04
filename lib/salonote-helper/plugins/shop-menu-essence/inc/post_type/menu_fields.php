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


// メニューフィールド

	function menu_fields_custom_post_type()
	{
			$labels = array(
					'name' => _x('メニューフィールド', 'post type general name'),
					'singular_name' => _x('メニューフィールド', 'post type singular name'),
					'add_new' => _x('メニューフィールドを追加', 'menu_fields'),
					'add_new_item' => __('新しいメニューフィールドを追加'),
					'edit_item' => __('メニューフィールドを編集'),
					'new_item' => __('新しいメニューフィールド'),
					'view_item' => __('メニューフィールドを表示'),
					'search_items' => __('メニューフィールドを探す'),
					'not_found' => __('メニューフィールドはありません'),
					'not_found_in_trash' => __('ゴミ箱にメニューフィールドはありません'),
					'parent_item_colon' => ''
			);
			$args = array(
					'labels'              => $labels,
					'public'              => false,
					'publicly_queryable'  => false,
					'show_in_nav_menus' 	=> false,
					'show_ui'             => true,
					'query_var'           => true,
					'rewrite'             => false,
					'capability_type'     => 'post',
					'hierarchical'        => false,
					'menu_position'       => 54,
					'menu_icon'           => 'dashicons-store',
					'has_archive'         => false,
					'supports'            => array('title'),
					'exclude_from_search' => true,
					'show_in_rest'			  => true,
					'rest_base'   				=> 'menu_fields'
			);
			register_post_type('menu_fields',$args);
	}
	add_action('init', 'menu_fields_custom_post_type',20);


/*
add_action('admin_menu', 'menu_fields_essence_pages');
function menu_fields_essence_pages() {
	
	$menu_slug = 'edit.php?post_type=shop_menu';

  add_submenu_page($menu_slug, 'メニューフィールド','メニューフィールド', 'manage_options', 'edit.php?post_type=menu_fields');
	add_submenu_page($menu_slug, 'メニューフィールドを追加','メニューフィールドを追加', 'manage_options', 'post-new.php?post_type=menu_fields');
}

add_action( 'admin_menu', 'remove_menu_fields_menu');
function remove_menu_fields_menu(){
  remove_menu_page( 'edit.php?post_type=menu_fields' );
}
*/


