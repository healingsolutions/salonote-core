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
	
	//echo $_insert_text;
	
	$post_value = array(
		'ID'						=> (isset($post->ID) ? $post->ID : null ),
		'post_content'	=> $_insert_text,
	);
	$insert_id = wp_update_post($post_value);
	

	echo $insert_id;
}

?>
