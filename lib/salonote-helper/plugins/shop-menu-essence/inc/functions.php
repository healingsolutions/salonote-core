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



//admin enqueue
function shop_menu_essence_admin_style($hook){
	global $hook_suffix;
	if ( 'post.php' !== $hook_suffix && 'post-new.php' !== $hook_suffix ) {
			return;
	}
	$post_type = get_post_type();
	if ( $post_type !== 'menu_fields' && $post_type !== 'shop_menu' ) {
			return;
	}
	
	
	wp_enqueue_style( 'ui-lightness', '//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css');
	wp_enqueue_script( 'jquery-ui-core', '//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js');
	wp_enqueue_script('sfprototypeman', SHOP_MENU_ESSENCE_PLUGIN_URI . '/statics/js/jquery.sfprototypeman.js', array(), '1.0.0');
	wp_enqueue_script('shop_menu_essence', SHOP_MENU_ESSENCE_PLUGIN_URI . '/statics/js/shop-menu-admin-min.js', array(), '1.0.1' ,true);
	wp_enqueue_style ('shop_menu_essence', SHOP_MENU_ESSENCE_PLUGIN_URI . '/statics/css/shop-menu-admin_style.css');
}
add_action( 'admin_enqueue_scripts', 'shop_menu_essence_admin_style' );



//public enqueue
function shop_menu_print_footer_scripts($post){
	if ( is_admin() && !is_singular() ){
		return;
	}
	global $post;
	
	if(
		!empty($post) && 
		(
			strpos($post->post_content,'[shop_menu ') !== false ||
			is_singular('shop_menu')
		)
		)
	{
		wp_enqueue_script('validate', '//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js', array(), '1.15.0' ,true);
		wp_enqueue_script('shop_menu_essence', SHOP_MENU_ESSENCE_PLUGIN_URI . '/statics/js/shop-menu-public-min.js', array(), '1.0.3' ,true);
		wp_enqueue_script('formtowizard', SHOP_MENU_ESSENCE_PLUGIN_URI . '/statics/js/jquery.formtowizard.js', array(), '1.0.0' ,true);

		
		// shop menu colors
		$mods = get_theme_mods();	
		echo '<style>';

		if( !empty($mods['es_shopmenu_bkg']) ){
			echo '
			.shop_menu_block .shop_menu_block-item{
				background-color: '.$mods['es_shopmenu_bkg'].';
				padding:10px;
				margin-bottom:20px;
			}
			';
		}

		if( !empty($mods['es_shopmenu_lable_bkg']) ){
			echo '
			.shop_menu_block dl dt{
				background-color: '.$mods['es_shopmenu_lable_bkg'].';
			}';
		}

		if( !empty($mods['es_shopmenu_left_bdr']) ){
			echo '
			.shop_menu_block .shop_menu_block-item{
				border-left: 4px solid '.$mods['es_shopmenu_left_bdr'] .';
			}
			.shop_menu_block .shop_menu_check label::before{
				border: 2px solid '.$mods['es_shopmenu_left_bdr'] .' !important;
			}
			.shop_menu_block .shop_menu_check input[type=\'checkbox\']:checked + label::before{
				background: '.$mods['es_shopmenu_left_bdr'] .'!important;
			}';
		}

		echo '</style>';
		
	}
	
}
add_action('wp_enqueue_scripts','shop_menu_print_footer_scripts');



function shop_menu_style_wp_enqueue_scripts() {
	if ( is_admin() && !is_singular() ){
		return;
	}
	global $post;
	
	if(
			(!empty($post->post_content) && strpos($post->post_content,'[shop_menu ') !== false)||
			is_singular('shop_menu')
		)
	{
		wp_enqueue_style( 'shop_menu_style', SHOP_MENU_ESSENCE_PLUGIN_URI . '/statics/css/shop-menu-public_style.css',array(),'1.0.0.2' );
	}
}
add_action( 'wp_enqueue_scripts', 'shop_menu_style_wp_enqueue_scripts' );




function shopmenu_essence_none_cache_hook_wrap() {
	global $post;
	if( is_singular()){
		
		if( has_shortcode( $post->post_content, 'shop_menu') ){
			define('LSCACHE_NO_CACHE', true);
			//echo 'clear default_cache';
			
			define('DONOTCACHEPAGE',true);
			
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if( is_plugin_active( 'wp-super-cache/wp-cache.php' ) ){
				wpsc_delete_post_cache($post->ID);
				//echo 'clear super_cache';
			}
			return;
		}
	}
	
	return;
}
add_action( 'template_redirect', 'shopmenu_essence_none_cache_hook_wrap');






function check_shop_menu_nonce_function(){
  if( !empty($_POST['nonce_shop_menu_reserve_send']) && wp_verify_nonce($_POST['nonce_shop_menu_reserve_send'], 'post_shop_menu_reserve_send')){
		
		// ===================================
		// 送信処理
		// ===================================
		//  ポストされたワンタイムチケットを取得する。
		$ticket = isset($_POST['ticket'])    ? $_POST['ticket']    : '';

		//  セッション変数に保存されたワンタイムチケットを取得する。
		$save   = isset($_SESSION['ticket']) ? $_SESSION['ticket'] : '';

		//  セッション変数を解放し、ブラウザの戻るボタンで戻った場合に備え
		//  る。
		
		if ( empty($_SESSION['ticket'])) {
			wp_redirect($_SERVER["REQUEST_URI"]); exit;
		}
  }
}
add_filter('template_redirect','check_shop_menu_nonce_function');

function shop_menu_reserve_hook($content){
	

	if( !empty($_POST['nonce_shop_menu_reserve_send']) && wp_verify_nonce($_POST['nonce_shop_menu_reserve_send'], 'post_shop_menu_reserve_send')){

		// ===================================
		// 送信処理
		// ===================================
		//  ポストされたワンタイムチケットを取得する。
		$ticket = isset($_POST['ticket'])    ? $_POST['ticket']    : '';

		//  セッション変数に保存されたワンタイムチケットを取得する。
		$save   = isset($_SESSION['ticket']) ? $_SESSION['ticket'] : '';

		unset($_SESSION['ticket']);

		if ( !isset($ticket) || $ticket !== $save) {
			return;
			die('不正なアクセスです');
		}
		

		require_once( SHOP_MENU_ESSENCE_PLUGIN_PATH. "/template-parts/action/send_notification.php");
		require_once( SHOP_MENU_ESSENCE_PLUGIN_PATH. "/template-parts/action/register_reserve_info.php");
		echo !empty($shop_menu_opt['return_text']) ? wpautop($shop_menu_opt['return_text']) : '予約希望を受付いたしました。ありがとうございます。';		
		return;
	}
	
	if( !empty($_POST['nonce_shop_menu_reserve_confirm']) && wp_verify_nonce($_POST['nonce_shop_menu_reserve_confirm'], 'post_shop_menu_reserve_confirm')){
		require_once( SHOP_MENU_ESSENCE_PLUGIN_PATH. "/template-parts/module/shop_menu_post.php");
		return;
	}

	if( !empty($_POST['menu_reserve']) && $_POST['menu_reserve'] ){
		require_once( SHOP_MENU_ESSENCE_PLUGIN_PATH. "/template-parts/module/shop_menu_confirm.php");
		return;
	}else{
		return $content;
	}
}
add_filter('the_content','shop_menu_reserve_hook');
	



class ShopMenu_Essence_Theme_Customize
   {

    //管理画面のカスタマイズにテーマカラーの設定セクションを追加
    public static function shopmenu_essence_customize_register($wp_customize) {

			$wp_customize->add_setting( 'es_shopmenu_bkg', array( 'default' => null,'sanitize_callback' => 'sanitize_hex_color' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'es_shopmenu_bkg' , array(
					'label' => 'ショップメニュー背景',
					'section' => 'colors',
					'settings' => 'es_shopmenu_bkg',
			) ) );
			
			$wp_customize->add_setting( 'es_shopmenu_lable_bkg', array( 'default' => null,'sanitize_callback' => 'sanitize_hex_color' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'es_shopmenu_lable_bkg' , array(
					'label' => 'ショップメニュー見出し背景',
					'section' => 'colors',
					'settings' => 'es_shopmenu_lable_bkg',
			) ) );
			
			$wp_customize->add_setting( 'es_shopmenu_left_bdr', array( 'default' => null,'sanitize_callback' => 'sanitize_hex_color' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'es_shopmenu_left_bdr' , array(
					'label' => 'ショップメニュー左ボーダー',
					'section' => 'colors',
					'settings' => 'es_shopmenu_left_bdr',
			) ) );
			

			
    }

}//Slide_Essence_Theme_Customize

// テーマ設定やコントロールをセットアップします。
add_action( 'customize_register' , array( 'ShopMenu_Essence_Theme_Customize' , 'shopmenu_essence_customize_register' ),20 );




//管理画面に優先度メニューを追加

add_action('admin_menu', 'shop_menu_essence_pages');

function shop_menu_essence_pages() {
  $page_title = 'ご予約';
  $menu_title = 'ご予約';
  $capability = 'manage_options';
  $menu_slug = 'shop_menu_reserves_page';
  $function = 'shop_menu_reserves_page';
  add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function,'dashicons-list-view',53);

	$submenu_title = 'ご予約リスト';
  add_submenu_page($menu_slug, $page_title, $submenu_title, $capability, $menu_slug, $function);
	
	
  $submenu_page_title = 'ご予約を追加';
  $submenu_title = 'ご予約を追加';
  $submenu_slug = 'add_shop_menu_reserve';
  $submenu_function = 'add_shop_menu_reserve';
  add_submenu_page($menu_slug, $page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);
	

  $submenu_page_title = '予約設定';
  $submenu_title = '予約設定';
  $submenu_slug = 'setting_shop_menu_reserve';
  $submenu_function = 'setting_shop_menu_reserve';
  add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);
}

function shop_menu_reserves_page() {
  if (!current_user_can('manage_options')) {
      wp_die('このページへアクセスする権限がありません。');
  }
	require_once( SHOP_MENU_ESSENCE_PLUGIN_PATH. "/template-parts/admin/shop_menu_reserves.php");
}

function add_shop_menu_reserve() {
  if (!current_user_can('manage_options')) {
      wp_die('このページへアクセスする権限がありません。');
  }
	require_once( SHOP_MENU_ESSENCE_PLUGIN_PATH. "/template-parts/admin/add_shop_menu_reserve.php");
}

function setting_shop_menu_reserve() {
  if (!current_user_can('manage_options')) {
      wp_die('このページへアクセスする権限がありません。');
  }
	require_once( SHOP_MENU_ESSENCE_PLUGIN_PATH . '/template-parts/admin/shop_menu_option_page.php');
}




function print_shop_menu_item( $field_set=null , $shop_menu_arr=null, $not_reserve = false ){
	
	if( empty($shop_menu_arr) ) return;
	
	global $id;
	global $list_type;
	
	if(is_user_logged_in()){
		//echo '<pre>field_set'; print_r($field_set); echo '</pre>';
		//echo '<pre>$shop_menu_arr'; print_r($shop_menu_arr); echo '</pre>';
	}
	
	
	echo '<div id="" class="shop_menu_block_id shop_menu_block '.$list_type.'-view">';


	

	foreach( $shop_menu_arr as $key => $item ){


		if( !empty($search) ){
			$search_match = false;
			foreach( $item as $field => $value ){

				if( strpos($value,$search) !== false ){
					//echo '<p>'.$value.':'.$search.' match</p>';
					$search_match = true;
					continue;
				}
			}

			if( !$search_match ){
				continue;
			}
		}


		// check menu item price
		$menu_price =  !empty($item['menu_price']) ? $item['menu_price'] : 0 ;
		$item_price =  !empty($item['menu_global_price']) ? $item['menu_global_price'] : $item['menu_price'] ;
		$item_price = preg_replace('/[^0-9]/', '', $item_price);

		$menu_time =  !empty($item['menu_time']) ? $item['menu_time'] : 0 ;
		$menu_time = preg_replace('/[^0-9]/', '', $menu_time);	

		echo '<div id="shop_menu_block-item_'.$key.'" class="shop_menu_block-item menu_block_'.$key.'" data-index="'.$key.'" data-price="'.$item_price.'" data-time="'.$menu_time.'">';

		$field_images = 0;
		foreach( $item as $field => $value ){
			if( !empty($field_set[$field]['type']) && $field_set[$field]['type'] == 'upload' ){
				if( !empty($value) ) ++$field_images;	
			}
		}


		echo '<dl';
		if( $field_images > 0 ){
			echo ' class="has_upload_field"';
		}
		echo '>';
		foreach( $item as $field => $value ){

			if( empty($value) || $field === 'menu_global_name' || $field === 'menu_global_price' || $field === 'menu_global_option' || $field === 'menu_global_reserve' ) continue;

			$_dd_class = '';
			//echo '<pre>field'; print_r($field); echo '</pre>';
			//echo '<pre>$field_set'; print_r($field_set); echo '</pre>';

			if( !empty($field_set[$field]['type']) && $field_set[$field]['type'] == 'upload' ){
				echo '</dl><div class="'.$field.' image_type_dd">';
				echo wp_get_attachment_image( $value, $field_set[$field]['size'] );
				echo '</div><dl>';
			}else{


				if( !empty($field_set[$field]['display']) && $field_set[$field]['display'] !== 'false' ){
					echo '<dt class="'.$field.'">';
					echo !empty($field_set[$field]['label']) ? esc_attr($field_set[$field]['label'] ) : '' ;
					echo '</dt>';
				}else{
					echo '<dt class="hidden '.$field.'">';
					echo !empty($field_set[$field]['label']) ? esc_attr($field_set[$field]['label'] ) : '' ;
					echo '</dt>';
					$_dd_class = ' none_dt';
				}

				echo '<dd class="'.$field.$_dd_class.'">';
					echo !empty($value) ? wpautop( $value ) : '' ;
					//echo '<pre>fields'; print_r($value); echo '</pre>';
				echo '</dd>';
			}
		}

		echo '</dl>';

		if( !empty($item['menu_global_option']) ){
			echo '<div class="shop_menu_essence-option-btn btn-color">オプション</div>';
		}elseif( !empty($item['menu_global_reserve']) && $not_reserve !== true ){
			echo '
			<form class="shop_menu_essence-reserve_button" action="" method="POST">
				<input type="hidden" name="menu_post_id" value="'. $id .'">
				<input type="hidden" name="menu_item_id" value="'. $key .'">
				<button class="btn-item" type="send" name="menu_reserve" value="'. $item['menu_name'] .'">このメニューを予約する</button>
			</form>
			';
		}

		echo '</div>';
	}
	
	echo '</div>';
	
};


?>