<?php
/*
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

global $search_engin_essence_db_version;
$search_engin_essence_db_version = '1.0';

function search_engine_essence_install() {
  global $wpdb;
  global $search_engin_essence_db_version;

  $table_name = $wpdb->prefix . 'ranking_essence';

  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $table_name (
    id mediumint(9) AUTO_INCREMENT,
    date datetime DEFAULT '0000-00-00 00:00:00',
    rank mediumint(9),
		title text,
    keywords text,
    url varchar(55),
    UNIQUE KEY id (id)
  ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option( 'search_engin_essence_db_version', $search_engin_essence_db_version );
}

function search_engin_essence_install_data() {
  global $wpdb;


  $table_name = $wpdb->prefix . 'ranking_essence';

  $wpdb->insert(
    $table_name,
    array(
      'date' => current_time( 'mysql' ),
      'rank' => 0,
			'title' => '',
      'keywords' => '',
			'url' => get_bloginfo('url')
    )
  );
}

?>