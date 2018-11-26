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



function create_salonote_body( $body=null, $images=null, $post_style='simple_blog'){
	
	$_note_html = '';
	
	
	$count_body		= count($body);
	$count_image	= count($images);
	
	if(is_user_logged_in()){
		//echo '<pre>count_body'; print_r($count_body); echo '</pre>';
		//echo '<pre>count_image'; print_r($count_image); echo '</pre>';
	}
	
	
	$post_style = isset($_POST['post_style']) ? $_POST['post_style'] : $post_style ;
	if( $post_style == 'left_image' || $post_style == 'right_image' ){
		$post_style = 'left_right';
	}
	
	
	$item_count = max($count_body,$count_image);
	
	$counter = 0;
	$use_cover = 0;
	$gallery_arr = [];
	
	if( ($count_body + $count_image) === 0 ) return;

	for ($key = 0; $key < $item_count; $key++){
		
		$_tmp_html = [];

		if( !empty($body[$key]) ){
			
			
			
			++$counter;
			$_tmp_html['text'] = '';
			$_tmp_html['image'] = '';
			$_img_src = !empty( $images[$key]['id'] ) ? wp_get_attachment_image_src( $images[$key]['id'], 'large') : null;

			if( substr_count($body[$key],"-") >= 3 ){
				$body[$key] = preg_replace('/(\-){3,}/','<hr class="short-horizon" />', $body[$key]);
			}
			

			if(
					(!empty($body[$key]) && !empty($images[$key]['url'])) &&
					(
						( substr_count($body[$key],"\n") >= 1 && $key <= $count_image) ||
						( !empty($body[($key-1)]) && substr_count($body[($key-1)],"\n") <= 1)
					)
			){
				//set textarea
				if( !empty($body[$key]) ){
					
					if( $post_style === 'left_right' ) $_tmp_html['text'] 	.= '<div class="block-unit vertical-middle">';

					//convert headlin to first text line
					if( substr_count($body[$key],"\n") >= 1){
						
						$body_item_arr = '';
						$body_item_arr = br2array($body[$key]);

			
						foreach( $body_item_arr as $body_key => $body_item ){
							if( mb_strlen($body_item) < 15 ){
								
								$_tmp_html['text'] 	.= '<h2>'.$body_item.'</h2>';
							}else{
								$_tmp_html['text'] 	.= wpautop($body_item);
							}
						}
					}else{
						$_tmp_html['text'] 	.= wpautop($body[$key]);
					}//^ convert headlin to first text line
					
					
					if( $post_style === 'left_right' ) $_tmp_html['text'] 	.= '</div>';
				}

				if( !empty($images[$key]['url']) ){
					
					
					
					if( $post_style === 'left_right' ) $_tmp_html['image'] 	.= '<div class="block-unit vertical-middle">';
					$_tmp_html['image'] .= '<img class="img-responsive wow wp-image-'.$images[$key]['id'].' fadeIn aligncenter size-large" src="'.$_img_src[0].'" alt="" />';
					if( $post_style === 'left_right' ) $_tmp_html['image'] 	.= '</div>';
				}

			}else{
				
				
				if( $use_cover <= 2 && !empty($images[$key]['url']) && $post_style !== 'keyv-landing'){
					++$use_cover;
					
					$_tmp_html['text'] = '<div class="block-unit"><img class="img-responsive wow wp-image-'.$images[$key]['id'].' fadeIn aligncenter size-large img-cover-block bkg-fixed" src="'.$_img_src[0].'" alt="" /></div>';
					$_tmp_html['text'] .= '<div class="text-cover-block"><div class="block-center"><div class="bkg-white-text"><h1>'.$body[$key].'</h1></div></div></div>';

				}else{
					
					if( !empty($body[($key-1)]) && substr_count($body[($key-1)],"\n") > 0 && substr_count($body[($key)],"\n") === 0 ){
						//前に見出しが含まれていない場合
						$_tmp_html['text'] = '<h1>'.$body[$key].'</h1>';
					}else{
						//前が見出しだった場合
						
						//convert headlin to first text line
						if( substr_count($body[$key],"\n") >= 1){

							$body_item_arr = '';

							$body_item_arr = br2array($body[$key]);

							foreach( $body_item_arr as $body_key => $body_item ){
								if( !empty($body_item) ){
									if( mb_strlen($body_item) < 15 ){
										$_tmp_html['text'] 	.= '<h2>'.$body_item.'</h2>';
									}else{
										$_tmp_html['text'] 	.= wpautop($body_item);
									}
								}
							}
						}else{
							if( !empty($body[$key]) ){
								$_tmp_html['text'] 	.= wpautop($body[$key]);
							}
						}//^ convert headlin to first text line
						
	
					}
					
					if( !empty($images[$key]['url']) ){
					$_tmp_html['image'] = '<img class="img-responsive wow wp-image-'.$images[$key]['id'].' fadeIn aligncenter size-large" src="'.$_img_src[0].'" alt="" />';
					}
				}
				
			}

			


			if( $counter%2 === 0 && $post_style === 'left_right' ){
				$_note_html .= !empty($_tmp_html['image']) 	? $_tmp_html['image'] : '';
				$_note_html .= !empty($_tmp_html['text']) 	? $_tmp_html['text'] : '';
				
			}elseif( $post_style === 'left_image' ){
				$_note_html .= !empty($_tmp_html['image']) 	? $_tmp_html['image'] : '';
				$_note_html .= !empty($_tmp_html['text']) 	? $_tmp_html['text'] : '';
				
			}elseif( $post_style === 'right_image' ){
				$_note_html .= !empty($_tmp_html['text']) 	? $_tmp_html['text'] : '';
				$_note_html .= !empty($_tmp_html['image']) 	? $_tmp_html['image'] : '';
				
			}else{
				$_note_html .= !empty($_tmp_html['text']) 	? $_tmp_html['text'] : '';
				$_note_html .= !empty($_tmp_html['image']) 	? $_tmp_html['image'] : '';
			}
			
			if( !empty($_tmp_html['image']) && !empty($_tmp_html['text'] ) && $post_style !== 'keyv-landing' ){
				$_note_html .= '<hr class="short-horizon" />';
			}

			


		}else{
			if( $key >= $count_body ){

				$gallery_arr[] = $images[$key]['id'];

			}else{
				$_note_html .= '<img class="img-responsive wp-image-'.$images[$key]['id'].'" src="'.$_img_src[0].'">';
			}
		}

	}
	
	if( !empty($gallery_arr) ){
		$_note_html .= '[gallery columns="4" link="file" size="thumbnail_M" ids="'.implode(',',$gallery_arr).'"]';
	}


	//return edit_content_hook($_note_html); // show confirm
	
	if( $post_style === 'character' ){
		return markdown_char($_note_html);
	}else{
		return $_note_html;
	}
	
}

?>