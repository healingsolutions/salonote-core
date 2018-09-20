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

global $shop_menu_essence_db_version;
$shop_menu_essence_db_version = '1.0';


function shop_menu_essence_install() {
  global $wpdb;
  global $shop_menu_essence_db_version;

  $table_name = $wpdb->prefix . 'shop_menu_essence';

  $charset_collate = $wpdb->get_charset_collate();
	
	$sql = "CREATE TABLE $table_name (
    meta_id bigint(20) UNSIGNED AUTO_INCREMENT,
		user_id bigint(20) UNSIGNED DEFAULT '0',
		rsv_date datetime DEFAULT '0000-00-00 00:00:00',
		rsv_name text,
		rsv_mail text,
		rsv_menu text,
		rsv_phone varchar(55),
		rsv_datetime text,
		rsv_memo text,
		rsv_flag text,
		UNIQUE KEY meta_id (meta_id)
  ) $charset_collate;";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
	
  dbDelta( $sql );

  add_option( 'shop_menu_essence_db_version', $shop_menu_essence_db_version );
}

function shop_menu_essence_install_data() {
  global $wpdb;


  $table_name = $wpdb->prefix . 'shop_menu_essence';

  $wpdb->insert(
    $table_name,
    array(
      'rsv_date' 			=> current_time( 'mysql' ),
      'rsv_name' 			=> '',
			'rsv_mail' 			=> '',
			'rsv_phone' 		=> '',
      'rsv_menu' 			=> '',
			'rsv_datetime' 	=> '',
			'rsv_memo'			=> '',
			'rsv_flag'			=> ''
    )
  );
}

?>