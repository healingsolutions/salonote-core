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
function print_character_essence_image($atts, $content = '') {
  global $id;
  
  extract(shortcode_atts(array(
    'id'      => null,
		'type'    => 'normal',
		'reverse' => 'false',
		'position' => 'left',
		'src'     => null,
  ), $atts));
	
	if( empty($id) ) return;
	
	$es_character_upload_images = get_post_meta( $id, 'es_character_upload_images', true );
	
	$style = ( $reverse == 'true' ) ? ' style="transform: scale(-1, 1);"' : '' ;

	
	return '<div class="character_essence char_reverse_'.$reverse.' char_position_'.$position.'"><img src="'.$es_character_upload_images[$type].'" /><div class="char_content">'.wpautop($content).'</div></div>';
	
  }
add_shortcode('character', 'print_character_essence_image');


?>