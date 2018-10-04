<?php
/*
Plugin Name:Search Engin Essence
Plugin URI: 
Description:検索順位管理機能
Version: 1.0.0
Author:Healing Solutions
Author URI: https://www.healing-solutions.jp/
License: GPL2
*/

/*  Copyright 2018 Healing Solutions (email : info@healing-solutions.jp)
 
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




define('SEARCH_ENGINE_ESSENCE_PLUGIN_PATH' , dirname(__FILE__)  );

//$_plug_url = preg_replace( '/https?\:/', '', plugins_url()); //for usage plugin
$_plug_url = preg_replace( '/https?\:/', '', get_template_directory_uri().'/lib/salonote-helper/plugins');
define('SEARCH_ENGINE_ESSENCE_PLUGIN_URI'  , $_plug_url.'/search-engine-essence'  );


add_action( 'plugins_loaded', 'search_engine_essence_load_textdomain' );
function search_engine_essence_load_textdomain() {
	// localization
	load_plugin_textdomain( 'search_engine_essence', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

class SEARCH_ENGINE_ESSENCE_Class {

	function __construct() {
		

		//管理画面を作成
		add_action('admin_menu', array($this, 'add_search_engine_essence_pages'));
		
		//cronを登録
		add_action('init',array($this, 'search_engine_essence_cron'));
    
    //function 
    require( SEARCH_ENGINE_ESSENCE_PLUGIN_PATH . '/inc/functions.php');
		
		//dashboardを設定
		require( SEARCH_ENGINE_ESSENCE_PLUGIN_PATH . '/lib/dashboard/search_engine_dashboard.php');
		
		//custom table 
    require( SEARCH_ENGINE_ESSENCE_PLUGIN_PATH . '/custom-meta-table/ranking-table.php');
    
    /* 有効にした時に引数で指定したファンクションを実行 */
      if (function_exists('register_activation_hook'))
      {
          register_activation_hook(__FILE__, array(&$this, 'activation'));
					register_activation_hook( __FILE__, 'search_engine_essence_install' );
					//register_activation_hook( __FILE__, 'shop_menu_essence_install_data' );
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
		
		
		add_action("essence_theme_activate", "search_engine_essence_install");
    
	}
	
	//管理ページの設定
	function add_search_engine_essence_pages() {
		add_options_page('検索順位チェック','検索順位チェック',  'level_8', __FILE__, array($this,'search_engine_essence_option_page'), '', 26);
	}

	function search_engine_essence_option_page() {
		require( SEARCH_ENGINE_ESSENCE_PLUGIN_PATH . '/template-parts/search_engine_option_page.php');
	}


  
  function activation() {
      /* 有効にした時の処理 */
  } 
  function deactivation() {
      /* 停止にした時の処理 */  
  }
	
	function search_engine_essence_cron() {
      require_once( SEARCH_ENGINE_ESSENCE_PLUGIN_PATH . '/inc/search_cron.php' );
	}//search_engine_essence_cron
  
    

}
$obj = new SEARCH_ENGINE_ESSENCE_Class();
