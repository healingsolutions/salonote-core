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
		'circled' => false,
		'src'     => null,
  ), $atts));
	
	
	if( (empty($id) || $id === 0) && empty($src) ){
		
			$args = array(
				'post_type' 			=> 'es_character',
				'posts_per_page' 	=> 1,
			);
			$char_post = get_posts($args);
		

		
			if( !empty($char_post) ){
				$default_char = get_post_meta( $char_post[0]->ID, 'es_character_upload_images', true );
			}else{
				$fields_arr = array(
					'normal' 		 => 'ノーマル',
					'smile'  		 => 'スマイル',
					'happy'  		 => '楽しい',
					'pleased'  	 => '嬉しい',
					'seriously'  => '決め台詞',
					'correct'  	 => '合っている',
					'mistaken'   => '間違っている',
					'understand' => 'わかった',
					'question'   => 'わからない',
					'thanks'  	 => 'お礼を言う',
					'angry'  		 => '怒る',
					'surprised'  => 'おどろく',
					'panicked'   => 'あせる',
					'speechless' => '呆れる',
					'upset' 		 => '困る',
					'sad'		 		 => '悲しい',
					'trying'		 => '苦しい',
					'sorry' 		 => 'あやまる',
					'sleep'  		 => '寝る',
				);
				foreach( $fields_arr as $key => $value ){
					$default_char[$key] = CHARACTER_ESSENCE_PLUGIN_URI . '/statics/images/female/female_' . $key .'.jpg';
				}
			}
		
	}elseif( !empty($id) && $id !== 0 ){
		$default_char = get_post_meta( $id, 'es_character_upload_images', true ) ? get_post_meta( $id, 'es_character_upload_images', true ) : null ;
	}
	

	

	$style = ( $reverse == 'true' ) ? ' style="transform: scale(-1, 1);"' : '' ;

	if( !empty($circled) && $circled === 'true' ){
		$position .= ' char_circled';
	}

	
	$image = !empty( $default_char[$type] ) ? $default_char[$type] : $src;
	
	$char_txt = '<div class="character_essence char_reverse_'.$reverse.' char_position_'.$position.'">';
	
	if( !empty($image) ){
		$char_txt .= '<img src="'.$image.'" />';
	}
	
	$char_txt .= '<div class="char_content">'.wpautop($content).'</div></div>';
	
	return $char_txt;
	
  }
add_shortcode('character', 'print_character_essence_image');


?>