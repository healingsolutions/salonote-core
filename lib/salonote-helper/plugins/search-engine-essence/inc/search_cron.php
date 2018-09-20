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
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/*=================================
// 投稿の日時が同一のものがあるか確認
// @param $post_date 投稿の日付
=================================*/

//cron スケジュール登録
if ( ! wp_next_scheduled( 'search_engine_essence_hook' ) ) {
    //wp_schedule_single_event( time(), 'scraping_hook' );
    wp_schedule_event( time(), 'daily', 'search_engine_essence_hook');
}


if ( !function_exists( 'search_engine_essence_function' ) ) :
function search_engine_essence_function() {
	require_once( SEARCH_ENGINE_ESSENCE_PLUGIN_PATH . '/inc/search_phaser.php' );
}

//WP_CRON　処理
add_action( 'search_engine_essence_hook', 'search_engine_essence_function' );
endif;
