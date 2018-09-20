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

function search_engine_essence_admin_enqueue($hook_suffix){

  if( $hook_suffix !== 'settings_page_search-engine-essence/search-engine-essence' ){
    return;
  }
  wp_enqueue_script( 'jquery-dataTables','//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js',true );
  wp_enqueue_script( 'bootstrap-dataTables','//cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js',true );
  
  wp_enqueue_style('bootstrap','//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
  wp_enqueue_style('dataTables','//cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css');
}
add_action( 'admin_enqueue_scripts', 'search_engine_essence_admin_enqueue' );


?>