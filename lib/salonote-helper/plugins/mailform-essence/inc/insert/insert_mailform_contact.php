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
global $form_id;
global $post;
global $_fields;
global $post_fields;
global $insert_id;

//画像処理
global $image_item;

//date_default_timezone_set('Asia/Tokyo');

$post_value = array(
		'post_title'    => get_the_title($post_fields['post_id']) . date('Y-m-d H:i:s',strtotime( $post_fields['post_date'])),    // 投稿のタイトル
		'post_type'     => 'es_contact',      // 投稿タイプ
		'post_status'   => 'publish',    // 公開ステータス
		'post_date'     => date('Y-m-d H:i:s',strtotime( $post_fields['post_date'])),     // 投稿の作成日時。
		'post_date_gmt' => gmdate('Y-m-d H:i:s',strtotime( $post_fields['post_date'])),     // 投稿の作成日時（GMT）。
		'post_name'     => $post_fields['ticket'], // 投稿のスラッグ。
    'post_parent'   => $form_id // 親投稿のID
);
$insert_id = wp_insert_post($post_value);

if($insert_id) {
	$_fields['send_count']['name'] 	= '入力時間';
	$_fields['send_count']['value'] = $post_fields['send_count'];
	$_fields['send_count']['type']	= 'number';
  update_post_meta( $insert_id,  'post_fields' , $_fields );
	
	if(is_user_logged_in()){
		//echo '<pre>_fields'; print_r($_fields); echo '</pre>';
	}

	
	foreach( $_fields as $field_label => $field_item ){
		$_field = str_replace('es_mail_', '', $field_label);
		if( $_fields[$_field]['type'] === 'param' ){
			update_post_meta( $insert_id, $field_label ,$_fields[$_field]['value'] );
		}
	}
	
}



?>