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


global $id;
global $show_title;
global $list_type;
global $search;
global $field_set;
global $change_button;
global $sort_button;
global $hide_button;


// ========================================
// shop menu print

if( empty($id) ) return;

//fields

$post_meta = get_post_custom($id);

$shop_menu_items 				= get_post_meta($id,	'essence_shop_menu'	,true);
$shop_menu_type_id 			= get_post_meta($id,	'shop_menu_type'		,true);
$shop_menu_view 			   = get_post_meta($id,	'shop_menu_view'		,true);
$shop_menu_fields_value = get_post_meta($shop_menu_type_id, 'essence_shop_menu_fields',true);
$shop_menu_fields = $shop_menu_fields_value['fields'];

if( empty($shop_menu_fields) ) return;


$list_type  = !empty( $shop_menu_view ) ? $shop_menu_view : 'list';

if( !empty($shop_menu_fields) ){
	foreach( $shop_menu_fields as $key => $value ){
		$menu_field_arr[$value['menu_field']] = array(
			$value['menu_label'],
			$value['menu_type'],
			$value['menu_values']
		);
	}
}

$field_set = [];
foreach( $shop_menu_fields as $key => $value ){
	$field_set[$value['menu_field']]['label']   = $value['menu_label'];
	$field_set[$value['menu_field']]['type']    = !empty($value['menu_type']) 	 ? $value['menu_type'] 		: null ;
	$field_set[$value['menu_field']]['display'] = !empty($value['menu_display']) ? $value['menu_display'] : false ;
	$field_set[$value['menu_field']]['size']    = !empty($value['image_size']) 	 ? $value['image_size'] 	: 'thumbnail' ;
}

//post meta
$shop_menu_arr = get_post_meta($id,'essence_shop_menu',true);


if( empty($shop_menu_arr) ) return;

echo '<div id="menu_block_unit_id" class="menu_block_unit">';

  if( $show_title === true ){
    echo '<h2 class="title_bdr_tbtm">'.get_the_title($id).'</h2>';
  }
  do_action('before_print_shop_menu');
  print_shop_menu_item( $field_set, $shop_menu_arr);
  do_action('after_print_shop_menu');

echo '</div>';

?>