<?php
/*
Plugin Name: omakase-essence
Plugin URI: 
Description: 文章と写真からコンテンツをおまかせで自動生成する
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


//プラグインのパスを設定
define('OMAKASE_ESSENCE_PLUGIN_PATH' , dirname(__FILE__)  );


//$_plug_url = preg_replace( '/https?\:/', '', plugins_url()); //for usage plugin
$_plug_url = preg_replace( '/https?\:/', '', get_template_directory_uri().'/lib/salonote-helper/plugins');
define('OMAKASE_ESSENCE_PLUGIN_URI'  , $_plug_url.'/omakase-essence'  );


class OMAKASE_ESSENCE_Class {

	function __construct() {
    
    //function 
    require( OMAKASE_ESSENCE_PLUGIN_PATH . '/inc/functions.php');
		require( OMAKASE_ESSENCE_PLUGIN_PATH . '/inc/create_salonote_body.php');
		require( OMAKASE_ESSENCE_PLUGIN_PATH . '/inc/insert_salonote_note.php');
    
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

  
  function activation() {
      /* 有効にした時の処理 */
  } 
  function deactivation() {
      /* 停止にした時の処理 */  
  }
  
    

}
$obj = new OMAKASE_ESSENCE_Class();
