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


function installer_start(){
	$opt_values 		= get_option('insert_essence',true);


	$count_posts = wp_count_posts('page');
	

	if( is_front_page() && is_home() && ($count_posts->publish + $count_posts->draft) <= 1 && current_user_can( 'activate_plugins' ) ){

		//postがある場合は、値をセットする
		if( !empty($_POST['insert_essence']) ){
			//CSRF対策用のチェック
			if(wp_verify_nonce($_POST['nonce_insert_essence'], 'action_nonce_insert_essence')){

				$insert_values = $_POST['insert_essence'];
				
				if(is_user_logged_in()){
					echo '<pre>insert_values'; print_r($insert_values); echo '</pre>';
				}
				
				insert_meta_action($insert_values);
				
			}
		}
		
		$can_installer = !empty($opt_values['installer_end']) ? 'done' : 'can' ;
		if( $can_installer == 'done' ) return;
		
		show_admin_bar( false );
		
		function installer_essence_enqueue() {
			wp_enqueue_style('installer-essence', INSTALLER_ESSENCE_PLUGIN_URI.'/statics/installer-public.css', array(), '1.0.0');
			wp_enqueue_script('installer-essence', INSTALLER_ESSENCE_PLUGIN_URI.'/statics/installer-public.js', array(), '1.0.0' ,true);
			
			wp_enqueue_style('installer-minicolors', get_template_directory_uri().'/statics/js/colorpicker/jquery.minicolors.css', array(), '1.0.0');
			wp_enqueue_script('installer-minicolors', get_template_directory_uri().'/statics/js/colorpicker/jquery.minicolors.min.js', array(), '1.0.0' ,true);
		}
		add_action( 'wp_enqueue_scripts', 'installer_essence_enqueue' ,1);
		
		
		function installer_essence_body(){
			//echo 'start installer';
			require( INSTALLER_ESSENCE_PLUGIN_PATH. "/template-parts/installer-essence-body.php");
		}
		add_action( 'wp_footer', 'installer_essence_body');
	}else{
		//
	}


}
add_action('template_redirect', 'installer_start');