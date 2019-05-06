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



//mail form
function print_shop_menu_list($atts) {
  global $id;
	global $show_title;
	global $list_type;
	global $search;
	
	global $change_button;
	global $sort_button;
	global $hide_button;

  extract(shortcode_atts(array(
    'id'      			=> null,
		'show_title'		=> true,
		'list_type'			=> 'list',
		'search'  			=> null,
		'change_button' => null,
		'sort_button' 	=> null,
		'hide_button' 	=> null,
  ), $atts));
	
	
  ob_start();
	
	

	echo get_post_field('post_content', $id);
	
  require( SHOP_MENU_ESSENCE_PLUGIN_PATH. "/template-parts/print_shop_menu.php");

  return ob_get_clean();
  }
add_shortcode('shop_menu', 'print_shop_menu_list');


function print_shop_menu_hook(){
  global $not_reserve;
  $not_reserve = false;
  require( SHOP_MENU_ESSENCE_PLUGIN_PATH. "/template-parts/print_shop_menu.php");
}
add_action('essence_list_part_inner_content', 'print_shop_menu_hook');


?>