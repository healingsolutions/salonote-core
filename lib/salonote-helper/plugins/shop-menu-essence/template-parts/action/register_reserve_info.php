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

global $wpdb;

$table_name = $wpdb->prefix . 'shop_menu_essence';

$sql = $wpdb->prepare(
		"INSERT INTO {$table_name}
		(user_id, rsv_date, rsv_name, rsv_mail, rsv_phone, rsv_menu, rsv_datetime, rsv_memo, rsv_flag)
		VALUES (%d, %s, %s, %s, %s, %s, %s ,%s, %s)",
		esc_attr($user_id),
		current_time( 'mysql' ),
		esc_attr($user_name),
		esc_attr($user_email),
		esc_attr($user_tel),
		serialize($reserv_arr),
		serialize($rsv_datetime),
		serialize($rsv_memo),
		''
);

$wpdb->query($sql);		
$wpdb->show_errors();

?>