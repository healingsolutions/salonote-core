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



function create_salonote_body( $body=null, $images=null ){
	
	$_note_html = '';
	
	$count_body		= count($body);
	$count_image	= count($images);
	
	$item_count = max($count_body,$count_image);
	
	$counter = 0;
	$use_cover = 0;
	
	
	if( ($count_body + $count_image) === 0 ) return;

	for ($key = 0; $key < $item_count; $key++){
		
		$_tmp_html = [];

		if( !empty($body[$key]) ){
			++$counter;

			if( substr_count($body[$key],"\n") >= 1 ){
				//set textarea
				$_tmp_html['text'] = '<div class="block-unit vertical-middle">'.wpautop($body[$key]).'</div>';
				$_tmp_html['image'] = '<div class="block-unit"><img class="img-responsive wow fadeIn aligncenter size-large" src="'.$images[$key].'" alt="" /></div>';

			}else{
				//set headline
				
				
				if( $use_cover === 0 && !empty($images[$key]) ){
					++$use_cover;
					$_tmp_html['text'] = '<div class="block-unit"><img class="img-responsive wow fadeIn aligncenter size-large img-cover-block bkg-fixed" src="'.$images[$key].'" alt="" /></div>';
					$_tmp_html['text'] .= '<div class="text-cover-block"><div class="block-center"><div class="bkg-white-text"><h1>'.$body[$key].'</h1></div></div></div>';
				}else{
					$_tmp_html['text'] = '<h1>'.$body[$key].'</h1>';
					
					if( !empty($images[$key]) ){
					$_tmp_html['image'] = '<div class="block-unit"><img class="img-responsive wow fadeIn aligncenter size-large" src="'.$images[$key].'" alt="" /></div>';
					}
				}
				
			}

			


			if( $counter%2 === 0 ){
				$_note_html .= !empty($_tmp_html['image']) 	? $_tmp_html['image'] : '';
				$_note_html .= !empty($_tmp_html['text']) 	? $_tmp_html['text'] : '';
			}else{
				$_note_html .= !empty($_tmp_html['text']) 	? $_tmp_html['text'] : '';
				$_note_html .= !empty($_tmp_html['image']) 	? $_tmp_html['image'] : '';
			}

			$_note_html .= '<hr class="short-horizon" />';


		}else{
			if( $key >= $count_body ){
				if( $key === $count_body ) $_note_html .= '<div class="row col-12">';
				$_note_html .='<div class="col-3"><img class="img-responsive" src="'.$images[$key].'"></div>';
				if( $key === $item_count ) $_note_html .= '</div>';
			}else{
				'<img class="img-responsive" src="'.$images[$key].'">';
			}
		}




	}


	//return edit_content_hook($_note_html); // show confirm
	return $_note_html;
}


?>