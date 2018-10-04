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

function insert_salonote_note($_insert_text){
	global $post;
	global $post_type;
	global $post_id;
	global $insert_id;
	
	$post_value = [];
	
	//echo $_insert_text;
	
	if( !empty( $_POST['post_style'] )){
		
		if( $_POST['post_style'] === 'keyv-landing' ){
			$post_value['page_template'] = 'template/keyv-landing.php';
		}else{
			$post_value['page_template'] = 'default';
			
			if( !empty($post_id)){
				$page_bkg_upload_images = get_post_meta( $post_id, 'page_bkg_upload_images', true );
				if( !empty($page_bkg_upload_images)){
					delete_post_meta( $post_id, 'page_bkg_upload_images' ); 
				}
			}
			
		}
		
	}


	
	if( !empty( $_POST['post_new'] ) ){
		$post_value['post_title'] = !empty($_POST['post_title']) ? esc_html($_POST['post_title']) : 'new title' ;
		$post_value['post_status'] = 'publish';
		$post_value['post_type'] = !empty($_POST['post_type']) ? esc_html($_POST['post_type']) : null ;
		$post_value['post_content'] = !empty($_insert_text) ? $_insert_text : '' ;
		
		echo '<pre>post_value'; print_r($post_value); echo '</pre>';
		
		return $insert_id = wp_insert_post($post_value);
	}else{
		$post_value['ID'] = !empty($post_id) ? esc_html($post_id) : null ;
		$post_value['post_type'] = !empty($_POST['post_type']) ? esc_html($_POST['post_type']) : null ;
		$post_value['post_content'] = !empty($_insert_text) ? $_insert_text : '' ;
		
		echo '<pre>post_value'; print_r($post_value); echo '</pre>';
		
		return $insert_id = wp_update_post($post_value);
	}
	
	
	
	

}

?>
