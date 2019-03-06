<?php
/*
Plugin Name:Words Check Essence
Plugin URI: 
Description:記事の文字数と見出し回数・キーワード出現率をカウントする
Version: 1.1.0
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


//プラグインのパスを設定
define('WORDS_CHECK_PLUGIN_PATH' , dirname(__FILE__)  );

//$_plug_url = preg_replace( '/https?\:/', '', plugins_url()); //for usage plugin
$_plug_url = preg_replace( '/https?\:/', '', get_template_directory_uri().'/lib/salonote-helper/plugins');
define('WORDS_CHECK_PLUGIN_URI'  , $_plug_url.'/words-check-essence'  );

class words_check_essence_Class {

	function __construct() {

    //Headline Essence function
    require( WORDS_CHECK_PLUGIN_PATH . '/lib/words_check_function.php');
    require( WORDS_CHECK_PLUGIN_PATH . '/lib/keywords.php');
    
  }
}
$obj = new words_check_essence_Class();

