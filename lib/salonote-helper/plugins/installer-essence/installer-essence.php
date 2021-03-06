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




//プラグインのパスを設定
define('INSTALLER_ESSENCE_PLUGIN_PATH' , dirname(__FILE__)  );

$_plug_url = preg_replace( '/https?\:/', '', get_template_directory_uri().'/lib/salonote-helper/plugins');
define('INSTALLER_ESSENCE_PLUGIN_URI'  , $_plug_url.'/installer-essence'  );


class INSTALLER_ESSENCE_Class {

	function __construct() {
    
    //function 
    require( INSTALLER_ESSENCE_PLUGIN_PATH . '/inc/functions.php');
		
		require( INSTALLER_ESSENCE_PLUGIN_PATH . '/lib/insert_meta_action.php');
		require( INSTALLER_ESSENCE_PLUGIN_PATH . '/lib/create_salonote_site.php');

	}

}
$obj = new INSTALLER_ESSENCE_Class();
