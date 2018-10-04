<?php
/*
Plugin Name:Character-Essence
Plugin URI: 
Description:キャラクター機能で、吹き出しでの会話をサポート
Version: 1.0.0
Author:Healing Solutions
Author URI: https://www.healing-solutions.jp/
License: GPL2
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




define('CHARACTER_ESSENCE_PLUGIN_PATH' , dirname(__FILE__)  );

//$_plug_url = preg_replace( '/https?\:/', '', plugins_url()); //for usage plugin
$_plug_url = preg_replace( '/https?\:/', '', get_template_directory_uri().'/lib/salonote-helper/plugins');
define('CHARACTER_ESSENCE_PLUGIN_URI'  , $_plug_url.'/character-essence'  );


class CHARACTER_ESSENCE_Class {

	function __construct() {
    
    
    
    //管理画面を作成
		add_action('admin_menu', array($this, 'add_character_essence_pages'));
    
    //function 
    require( CHARACTER_ESSENCE_PLUGIN_PATH . '/inc/functions.php');
    
    //post_type
    require( CHARACTER_ESSENCE_PLUGIN_PATH . '/inc/character_post_type.php');

    //short code
    require( CHARACTER_ESSENCE_PLUGIN_PATH . '/inc/character_shortcode.php');
    
    //custom_field
    require( CHARACTER_ESSENCE_PLUGIN_PATH . '/custom_fields/character_fields.php');
		require( CHARACTER_ESSENCE_PLUGIN_PATH . '/custom_fields/profile_fields.php');
		
		//print shopmenu tinymce
    require( CHARACTER_ESSENCE_PLUGIN_PATH . '/tinymce/character_essence_tinymce.php');
		

    
    /* 有効にした時に引数で指定したファンクションを実行 */
      if (function_exists('register_activation_hook'))
      {
          register_activation_hook(__FILE__, array(&$this, 'activation'));
      }
      /* 停止した時に引数で指定したファンクションを実行 */
      if (function_exists('register_deactivation_hook'))
      {
          register_deactivation_hook(__FILE__, array(&$this, 'deactivation'));
      }
      /* アンインストールした時に引数で指定したファンクションを実行 */
      if (function_exists('register_uninstall_hook'))
      {
          register_uninstall_hook(__FILE__, 'PluginDeveloper_Uninstall');
      }
    
	}
  
  //管理ページの設定
	function add_character_essence_pages() {
		add_options_page('キャラクター設定','キャラクター設定',  'level_8', __FILE__, array($this,'character_essence_option_page'), '', 26);
	}

	function character_essence_option_page() {
		require( CHARACTER_ESSENCE_PLUGIN_PATH . '/template-parts/character_option_page.php');
	}


  
  function activation() {
      /* 有効にした時の処理 */
  } 
  function deactivation() {
      /* 停止にした時の処理 */  
  }
  
    

}
$obj = new CHARACTER_ESSENCE_Class();
