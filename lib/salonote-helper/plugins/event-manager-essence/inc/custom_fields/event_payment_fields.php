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

$event_opt = get_option('event_manager_essence_options');
if( empty($event_opt['manage_member']) ){
	return ;
}

add_action('admin_menu', 'add_pay_per_member');
add_action('save_post', 'save_pay_per_member');
 
function add_pay_per_member(){
  
	$event_opt = get_option('event_manager_essence_options');
	$event_opt['post_type']	= isset($event_opt['post_type'])? $event_opt['post_type']: null;
	if( !empty($event_opt['post_type']) ){
		foreach( $event_opt['post_type'] as $post_type ){
			add_meta_box('pay_per_member', '一人当たりの支払金額', 'insert_pay_per_member', $post_type, 'normal', 'high');
		}
	}
}
 
function insert_pay_per_member(){
     global $post;
     wp_nonce_field(wp_create_nonce(__FILE__), 'pay_per_member_nonce');
     echo '<label for="pay_per_member"></label>
     <input type="number" name="pay_per_member" class="reguler-text" value="'.esc_html(get_post_meta($post->ID, 'pay_per_member', true)).'" />';
}
 
function save_pay_per_member($post_id){
	$pay_per_member_nonce = isset($_POST['pay_per_member_nonce']) ? $_POST['pay_per_member_nonce'] : null;
	if(!wp_verify_nonce($pay_per_member_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
	$data = $_POST['pay_per_member'];
 
	if(get_post_meta($post_id, 'pay_per_member') == ""){
		add_post_meta($post_id, 'pay_per_member', $data, true);
	}elseif($data != get_post_meta($post_id, 'pay_per_member', true)){
		update_post_meta($post_id, 'pay_per_member', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'pay_per_member', get_post_meta($post_id, 'pay_per_member', true));
	}
}


?>
