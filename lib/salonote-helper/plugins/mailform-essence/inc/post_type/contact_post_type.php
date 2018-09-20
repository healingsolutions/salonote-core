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

// コンタクト
function es_contact_custom_post_type()
{
    $labels = array(
        'name'                => _x('コンタクト', 'post type general name'),
        'singular_name'       => _x('コンタクト', 'post type singular name'),
        'add_new'             => _x('コンタクトを追加', 'es_contact'),
        'add_new_item'        => __('新しいコンタクトを追加'),
        'edit_item'           => __('コンタクトを編集'),
        'new_item'            => __('新しいコンタクト'),
        'view_item'           => __('コンタクトを表示'),
        'search_items'        => __('コンタクトを探す'),
        'not_found'           => __('コンタクトはありません'),
        'not_found_in_trash'  => __('ゴミ箱にコンタクトはありません'),
        'parent_item_colon'   => ''
    );
    $args = array(
        'labels'              => $labels,
        'public'              => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'query_var'           => true,
        'rewrite'             => false,
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'menu_position'       => 51,
        'menu_icon'           => 'dashicons-testimonial',
        'has_archive'         => false,
        'supports'            => array('title','comments'),
        'exclude_from_search' => true
    );
    register_post_type('es_contact',$args);
    }
add_action('init', 'es_contact_custom_post_type',24);




/**
 * カスタム投稿タイプ一覧に商品コード列追加
 */
add_filter( 'manage_edit-es_contact_columns', 'manage_es_contact_columns' );
function manage_es_contact_columns($columns) {
  //unset($columns['date']);
  unset($columns['thumbnail']);
  $columns['parent_post'] = "お問い合わせページ";
	$columns['contact'] = "内容";
	return $columns;
}

add_action( 'manage_posts_custom_column', 'add_es_contanct_column', 10, 2 );
function add_es_contanct_column($column_name, $post_id) {
	
	$defalut_time = date_default_timezone_get();
	$original_timezone = !empty( $defalut_time ) ? $defalut_time : 'Asia/Tokyo' ;
	date_default_timezone_set( $original_timezone );
  
  if ($column_name == 'parent_post') {
    global $post;
    echo get_the_title( $post->post_parent );
  }
  
  
	if( $column_name == 'contact' ) {
    
    
		$post_fields = get_post_meta($post_id, 'post_fields',true);
		
		
		if(is_user_logged_in()){
			//echo '<pre>'; print_r($post_fields); echo '</pre>';
		}
		
    if( is_array( $post_fields ) ){

			unset($post_fields['btn_submit']);
			unset($post_fields['file_label']);

			echo '<dl class="mailform-essence-list">';
			foreach( $post_fields as $label => $value ){

				if( empty( $value['value']) || $label === 'send_count' ) continue;

				if( is_array($value['value']) ){
					echo '<dt>'.esc_attr($value['name']).'</dt><dd>';
					foreach( $value['value'] as $sub_label => $sub_field_item ){
						echo esc_attr($sub_field_item) .'<br>';
					}
					echo '</dd>';

				}else{
					echo '
						<dt>'.esc_attr($value['name']).'</dt>
						<dd>'.esc_attr($value['value']).'</dd>
						';
				}
			}

			
			// 日時
			$from = get_the_date('c',$post_id);
			$to = date('c');

			// 日時からタイムスタンプを作成
			$fromSec = strtotime($from);
			$toSec   = strtotime($to);

			// 秒数の差分を求める
			$differences = $toSec - $fromSec;

			// フォーマットする
			$_result_day = gmdate("j", $differences) - 1;
			
			$result = '';
			if( $_result_day > 0 ){
				$result .= $_result_day .'日と';
			}
			$result .= gmdate("G時間 i分", $differences) ;
			
			echo '<dt>送信日</dt><dd>'.get_the_date('Y-m-d H:i:s',$post_id). '<span class="mailform-essence-differ">'.$result.'前</span></dd>';
			echo '</dl>';
			
			//投稿から画像リストを取得
      $image_args = array(
        'post_type'   => 'attachment',
        'numberposts' => -1,
        //'post_status' => null,
        'post_parent' => $post_id
      );
      $attachments = get_posts( $image_args );
      if ( $attachments ) {
        echo '<div class="es_contact-attachment-block">';
        foreach ( $attachments as $attachment ) {
          $image_src = wp_get_attachment_image_src( $attachment->ID , 'large' );
          if($image_src[0]){
            echo '<a class="colorbox" href="'. $image_src[0] . '"><div class="thumbnail-block thumbnail">';
            echo wp_get_attachment_image( $attachment->ID, 'thumbnail', false );
            echo '</div></a>';
          }
        }
        echo '</div>';
      }
      
      
      
			
			/*
      $post_cutom = get_post_custom($post_id);
			if(is_user_logged_in()){
				echo '<pre>post_cutom'; print_r($post_cutom); echo '</pre>';
			}
			*/
      
    }
  }
}

// ======================

/**
* 投稿一覧ソート機能
*
*/
function mailform_essence_sortable_columns($sort_column) {
  $sort_column['parent_post'] = 'parent_post';
  return $sort_column;
}

function mailform_essence_orderby_columns( $vars ) {
  if (isset($vars['orderby']) && 'parent_post' == $vars['orderby']) {
    $vars = array_merge($vars, array(
      'orderby' => 'title',
    ));
  }
  return $vars;

}
add_filter( 'manage_edit-es_contact_sortable_columns', 'mailform_essence_sortable_columns' ); // manage_edit-[post_type]_sortable_columns
add_filter( 'request', 'mailform_essence_orderby_columns' );

?>