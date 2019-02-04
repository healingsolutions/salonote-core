<?php
/*
Description: Page Information Fields
Author: Healin Solutions
Version: 0.1
Author URI:http://www.healing-solutions.jp
*/

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


add_action('admin_menu', 'add_shop_menu_type');
add_action('save_post', 'save_shop_menu_type');
 
function add_shop_menu_type(){
  add_meta_box('shop_menu_type', 'メニューフィールドタイプ', 'insert_shop_menu_type', 'shop_menu', 'side', 'low');
}
 
function insert_shop_menu_type(){
	global $post;
	wp_nonce_field(wp_create_nonce(__FILE__), 'shop_menu_type_nonce');
  
  $shop_menu_type_id = get_post_meta($post->ID,'shop_menu_type',true);

	
	$args = array(
		'post_type'  => 'menu_fields',
		'posts_per_page' => -1,
	);
	$_menu_fields_posts = get_posts($args);

	
	echo '
	<select name="shop_menu_type">';
	
	foreach( $_menu_fields_posts as $menu_field_post ){
		echo '<option value="'.$menu_field_post->ID.'"';
		if( $menu_field_post->ID == $shop_menu_type_id ) { echo ' selected'; };
		echo '>'.$menu_field_post->post_title.'</option>';
	}

	echo '
	</select>
	';
	
	
	echo '
  <style>
  dl.essence_shop_menu_type_fields{
    display: block;
    clear: both;
    padding-bottom: 3px;
    border-bottom: 1px solid #eee;
  }
  dl.essence_shop_menu_type_fields dt,
  dl.essence_shop_menu_type_fields dd{
    display: inline-block;
  }
  dl.essence_shop_menu_type_fields dd{
    float: right;
  }
  </style>
  ';

}
 
function save_shop_menu_type($post_id){
	$shop_menu_type_nonce = isset($_POST['shop_menu_type_nonce']) ? $_POST['shop_menu_type_nonce'] : null;
	if(!wp_verify_nonce($shop_menu_type_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
  if( !empty($_POST['shop_menu_type']) ){
    $data = $_POST['shop_menu_type'];
  }else{
    $data = null;
  }
 
	if(get_post_meta($post_id, 'shop_menu_type') == ""){
		add_post_meta($post_id, 'shop_menu_type', $data, true);
	}elseif($data != get_post_meta($post_id, 'shop_menu_type', true)){
		update_post_meta($post_id, 'shop_menu_type', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'shop_menu_type', get_post_meta($post_id, 'shop_menu_type', true));
	}
}





//=======================


add_action('admin_menu', 'add_shop_menu_view');
add_action('save_post', 'save_shop_menu_view');
 
function add_shop_menu_view(){
  add_meta_box('shop_menu_view', 'メニュー表示タイプ', 'insert_shop_menu_view', 'shop_menu', 'side', 'low');
}
 
function insert_shop_menu_view(){
	global $post;
	wp_nonce_field(wp_create_nonce(__FILE__), 'shop_menu_view_nonce');
  
	$shop_menu_view    = get_post_meta($post->ID,'shop_menu_view',true);
	
	echo '
  <div>
  <select name="shop_menu_view">
    <option value="list"'. ( $shop_menu_view === 'list' ? ' selected' : '' ) .'>リスト</option>
    <option value="grid"'. ( $shop_menu_view === 'grid' ? ' selected' : '' ) .'>グリッド</option>
    <option value="select"'. ( $shop_menu_view === 'select' ? ' selected' : '' ) .'>切り替え</option>
  </select>
  </div>
	';

}
 
function save_shop_menu_view($post_id){
	$shop_menu_view_nonce = isset($_POST['shop_menu_view_nonce']) ? $_POST['shop_menu_view_nonce'] : null;
	if(!wp_verify_nonce($shop_menu_view_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return $post_id; }
	if(!current_user_can('edit_post', $post_id)) { return $post_id; }
 
  if( !empty($_POST['shop_menu_view']) ){
    $data = $_POST['shop_menu_view'];
  }else{
    $data = null;
  }
 
	if(get_post_meta($post_id, 'shop_menu_view') == ""){
		add_post_meta($post_id, 'shop_menu_view', $data, true);
	}elseif($data != get_post_meta($post_id, 'shop_menu_view', true)){
		update_post_meta($post_id, 'shop_menu_view', $data);
	}elseif($data == ""){
		delete_post_meta($post_id, 'shop_menu_view', get_post_meta($post_id, 'shop_menu_view', true));
	}
}


?>
