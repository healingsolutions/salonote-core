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
function print_event_manager_list($atts) {
  global $id;
  
  extract(shortcode_atts(array(
    'id'      => null,
  ), $atts));

  ob_start();
  
  require_once( EVENT_MANAGER_ESSENCE_PLUGIN_PATH. "/template-parts/print_event_manager.php");

  return ob_get_clean();
  }
add_shortcode('event_manager', 'print_event_manager_list');



// ==================================
// サイドに自分の予約情報を表示
function print_event_my_reserve(){
	if( !is_singular() ) return;
	ob_start();
  require_once( EVENT_MANAGER_ESSENCE_PLUGIN_PATH. "/template-parts/print_event_my_reserve.php");
  return ob_get_clean();
}
add_shortcode('event_my_reserve', 'print_event_my_reserve');

?>