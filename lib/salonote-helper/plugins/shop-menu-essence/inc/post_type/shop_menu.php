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


// 店舗メニュー

	function shop_menu_custom_post_type()
	{
		$shop_menu_opt = get_option('shop_menu_essence_options');
		
		if( !empty($shop_menu_opt['show_public']) && $shop_menu_opt['show_public'] == 'show' ){
			$_public = true;
		}else{
			$_public = false;
		}

			$labels = array(
					'name' => _x('店舗メニュー', 'post type general name'),
					'singular_name' => _x('店舗メニュー', 'post type singular name'),
					'add_new' => _x('店舗メニューを追加', 'shop_menu'),
					'add_new_item' => __('新しい店舗メニューを追加'),
					'edit_item' => __('店舗メニューを編集'),
					'new_item' => __('新しい店舗メニュー'),
					'view_item' => __('店舗メニューを表示'),
					'search_items' => __('店舗メニューを探す'),
					'not_found' => __('店舗メニューはありません'),
					'not_found_in_trash' => __('ゴミ箱に店舗メニューはありません'),
					'parent_item_colon' => ''
			);
			$args = array(
					'labels'              => $labels,
					'public'              => $_public,
					'publicly_queryable'  => $_public,
					'show_ui'             => true,
					'query_var'           => true,
					'rewrite'             => $_public,
					'capability_type'     => 'post',
					'hierarchical'        => false,
					'menu_position'       => 54,
					'menu_icon'           => 'dashicons-store',
					'has_archive'         => $_public,
					'supports'            => array('title','editor','thumbnail'),
					'exclude_from_search' => true,
					'show_in_rest'			  => true,
					'rest_base'   				=> 'shop_menu'
			);
			register_post_type('shop_menu',$args);
    
    // カスタムタクソノミーを作成
			$args = array(
					'label' => 'ジャンル',
					'public' => true,
					'show_ui' => true,
					'hierarchical' => true
			);
			register_taxonomy('menu_genre','shop_menu',$args);
	}
	add_action('init', 'shop_menu_custom_post_type',20);




function shop_menu_essence_manage_shortcode_columns($columns) {
		unset($columns['thumbnail']);
		unset($columns['date']);
    $columns['shortcode'] = 'ショートコード';
    return $columns;
}
add_filter('manage_edit-shop_menu_columns', 'shop_menu_essence_manage_shortcode_columns');


function shop_menu_essence_add_shortcode_column($column_name) {

		$thum = '';
		if ( 'shortcode' == $column_name) {
        $post_id = isset( $post_id) ? $post_id : null;
        $post_type_name = get_post_type($post_id);
        if($post_type_name == 'shortcode' || $post_type_name == 'shop_menu'){
          $thum .= '[shop_menu label='.get_the_title().' id=' . get_the_ID() . ']';
        }
		}
    if ( isset($thum) && $thum ) {
        echo $thum;
    }
}
add_action('manage_posts_custom_column', 'shop_menu_essence_add_shortcode_column');


function set_custom_edit_shop_menu_columns($columns) {
  $columns['menu_genre'] = "カテゴリー";
  return $columns;
}
function custom_shop_menu_column($column_name, $post_id) {
  if( $column_name == 'menu_genre' ) {
    $tax = wp_get_object_terms($post_id, 'menu_genre');
    if(  isset($tax[0]) ) $stitle = $tax[0]->name;
  }
 
  if ( isset($stitle) && $stitle ) {
    echo '<a href="edit.php?post_type=shop_menu&amp;menu_genre='. urlencode(esc_html($tax[0]->name)).'">'.esc_attr($stitle).'</a>';
  }
}
function my_add_post_taxonomy_restrict_filter() {
  global $post_type;
  if ( 'shop_menu' == $post_type ) {
?>
    <select name="menu_genre">
      <option value="">カテゴリー指定なし</option>
<?php
      $terms = get_terms('menu_genre');
      foreach ($terms as $term) { ?>
        <option value="<?php echo $term->slug; ?>" <?php if ( !empty($_GET['menu_genre']) && $_GET['menu_genre'] == $term->slug ) { print 'selected'; } ?>><?php echo $term->name; ?></option>
<?php
      }
?>
    </select>
<?php
  }
}

add_filter( 'manage_shop_menu_posts_columns', 'set_custom_edit_shop_menu_columns' );
add_action( 'manage_shop_menu_posts_custom_column' , 'custom_shop_menu_column', 10, 2 );

add_action( 'restrict_manage_posts', 'my_add_post_taxonomy_restrict_filter' );

?>