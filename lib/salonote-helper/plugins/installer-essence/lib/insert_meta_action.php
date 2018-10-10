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

function insert_meta_action( $values ){

	$opt_values = get_option('insert_essence',true);
	
	if(is_user_logged_in()){
		echo '<pre>opt_values'; print_r($opt_values); echo '</pre>';
	}
	
	if(is_user_logged_in()){
		echo '<pre>post_values'; print_r($values); echo '</pre>';
	}
	
	
	if( !empty($opt_values) && is_array($opt_values) ){
		echo 'do_merge';
		$values = array_merge($opt_values, $values);
	}
	
	if(is_user_logged_in()){
		echo '<pre>unique_values'; print_r($values); echo '</pre>';
	}

	update_option('insert_essence', $values);

	
	wp_safe_redirect( get_bloginfo('url') ); exit;
}


?>