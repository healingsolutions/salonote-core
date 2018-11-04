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

$shop_menu_opt = get_option('shop_menu_essence_options');

if(is_user_logged_in()){
	//echo '<pre>shop_menu_opt'; print_r($shop_menu_opt); echo '</pre>';
}


//管理者メール
$_admin_mail = !empty( $shop_menu_opt['admin_mail'] ) ? $shop_menu_opt['admin_mail'] : get_option( 'admin_email' ) ;


if( !empty($_admin_mail) && !empty($_POST) ){
  //emailフィールドがない場合は送信されません
	
	if(is_user_logged_in()){
		//echo '<pre>'; print_r($_POST); echo '</pre>';
	}
	
	//user basic information ========================
	$user_id 			= !empty($_POST['user_id']) 			? esc_attr($_POST['user_id']) 			: 1 ;
	$user_name 		= !empty($_POST['user_name']) 		? esc_attr($_POST['user_name']) 		: '' ;
	$user_email 	= !empty($_POST['user_email']) 		? esc_attr($_POST['user_email']) 		: '' ;
	$user_tel 		= !empty($_POST['user_tel']) 			? esc_attr($_POST['user_tel']) 			: '' ;
	$user_address = !empty($_POST['user_address']) 	? esc_attr($_POST['user_address']) 	: '' ;
	$user_message = !empty($_POST['user_message']) 	? esc_attr($_POST['user_message']) 	: '' ;
	
	$rsv_message = [];
	$rsv_memo['address'] 		=	$user_address;
	$rsv_memo['message'] 		=	$user_message;

	// register wp user
	$register 		= !empty($_POST['register']) 			? esc_attr($_POST['register']) 			: null ;
	
	//reserve menu ========================
	
	$reserve_menu 		= !empty($_POST['reserve_menu']) 			? esc_attr($_POST['reserve_menu'])	: null ;
	$shop_menu_option = !empty($_POST['shop_menu_option']) 	? $_POST['shop_menu_option'] 				: '' ;
	
	$reserv_arr = [];
	$reserv_arr['menu'] = $reserve_menu;
	$reserv_arr['option'] = $shop_menu_option;
	
	//reserve times ========================
		
	$rsv_hearing 				= !empty($_POST['hearing']) 						? $_POST['hearing'] 								: null ;
	$rsv_recommend 			= !empty($_POST['recommend_datetime']) 	? $_POST['recommend_datetime']			: null ;
	$rsv_preferred 			= !empty($_POST['preferred']) 					? $_POST['preferred'] 							: null ;
	
	$rsv_datetime = [];
	$rsv_datetime['hearing']		= $rsv_hearing;
	$rsv_datetime['recommend']	= !empty($shop_menu_opt['recommend_datetime'][$rsv_recommend]['day']) ? $shop_menu_opt['recommend_datetime'][$rsv_recommend]['day'] .' '. $shop_menu_opt['recommend_datetime'][$rsv_recommend]['time'] : null ;
	
	if(is_user_logged_in()){
		//echo '<pre>recommend_datetime'; print_r($shop_menu_opt['recommend_datetime']); echo '</pre>';
	}
	
	
	$rsv_datetime['preferred']	= $rsv_preferred;


//確認メール
$return_text = '予約を付けました。'.PHP_EOL.
'管理者用の確認メールを送信いたします。'.PHP_EOL.
PHP_EOL.
PHP_EOL;
	
	$return_text = '';
	
	
	$return_text .= (!empty($user_name) ? 'ご予約者：　'.$user_name : '') . PHP_EOL;
	$return_text .= (!empty($user_email) ? 'Email：　'.$user_email : '') . PHP_EOL;
	$return_text .= (!empty($user_tel) ? 'TEL：　'.$user_tel : '') . PHP_EOL;
	$return_text .= (!empty($user_address) ? 'ご住所：　'.$user_address : '') . PHP_EOL;
	$return_text .= (!empty($user_memo) ? 'メッセージ：　'.$user_memo : '') . PHP_EOL;
	
	$return_text .= (!empty($register) ? 'ユーザー登録：　する': '') . PHP_EOL;
	
	$return_text .= (!empty($reserve_menu) ? 'メニュー：　'.$reserve_menu : '') . PHP_EOL;


	if( !empty($shop_menu_option) ){
		foreach( $shop_menu_option as $key => $value ){
			
			preg_match('/%%(.+?)%%/', $value, $matches);
			$_option_id = $matches[1];
			$_option_label = str_replace('%%'.$_option_id.'%%', '', $value);
			
			$return_text .= (!empty($_option_label) ? 'オプション：　'.$_option_label : '') . PHP_EOL;
		}
	}
	
	$return_text .= PHP_EOL.'========================'.PHP_EOL;
	
	if( !empty($rsv_preferred) ){
		foreach( $rsv_preferred as $key => $value ){
			$return_text .= (!empty($value['date']) ? '第'.($key+1).'希望：　'.$value['date'] : '') . PHP_EOL;
			
			if( !empty($value['time']) ){
				foreach( $value['time'] as $time_key => $time_value ){
					$return_text .= $time_value . PHP_EOL;
				}
			}
			
			$return_text .= PHP_EOL.'- - - - - - - '.PHP_EOL;
			
		}
	}
	
	// $rsv_hearing==============================
	
	if( !empty($rsv_hearing) ){
		
		if( !empty($rsv_hearing['week']) ){
			$return_text .= 'ご希望曜日：'.PHP_EOL;
			foreach( $rsv_hearing['week'] as $key => $value ){
				$return_text .= $value .'曜日'.PHP_EOL;
			}
			$return_text .= PHP_EOL.'- - - - - - - '.PHP_EOL;
		}
		
		if( !empty($rsv_hearing['date_time']) ){
			$return_text .= 'ご希望時間帯：'.PHP_EOL;;
			foreach( $rsv_hearing['date_time'] as $key => $value ){
				$return_text .= $value .PHP_EOL;
			}
			$return_text .= PHP_EOL.'- - - - - - - '.PHP_EOL;
		}
		
		if( !empty($rsv_hearing['reason']) ){
			$return_text .= 'ご希望の理由：'.PHP_EOL;
			$return_text .= esc_attr($rsv_hearing['reason']);
			$return_text .= PHP_EOL.'- - - - - - - '.PHP_EOL;
		}
		
		
		
		
	}
	
	
	// rsv_recommend==============================
	if( !empty($rsv_recommend) ){
		$return_text .= 'ご希望日：　'.$rsv_datetime['recommend'];
		
		$recommend_datetime_key = $_POST['recommend_datetime'];
		$recommend_datetime_opt = $shop_menu_opt['recommend_datetime'];
		unset($recommend_datetime_opt[$recommend_datetime_key]);
		$recommend_datetime_opt_arr = array_values($recommend_datetime_opt);
		
		unset($shop_menu_opt['recommend_datetime']);
		$shop_menu_opt['recommend_datetime'] = $recommend_datetime_opt_arr;
		$shop_menu_opt = update_option('shop_menu_essence_options',$shop_menu_opt);
		

		$return_text .= PHP_EOL.'- - - - - - - '.PHP_EOL;
		
	}

	$return_text .= PHP_EOL.'========================'.PHP_EOL;
	
	$return_text .= PHP_EOL.get_bloginfo('name').PHP_EOL;

	
	// admin_notification ====================================
	$admin_message = '予約希望を受信しました。'.PHP_EOL.
	'管理者用の確認メールを送信いたします。'.PHP_EOL.
	PHP_EOL.
	PHP_EOL;
	
  $to      = $_admin_mail;
  $subject = get_bloginfo('name') .'【管理者用　ご予約確認メール】';
  $message = strip_tags($admin_message.$return_text);
  $headers = 'From: '.($user_name ? esc_attr($user_name) : '').' <'.$user_email.'>' . "\r\n";
	wp_mail( $to, $subject, $message, $headers);
	
	
	// custmer_notification ====================================
	$user_message = 'ご予約希望を受付け致しました。'.PHP_EOL.
	'ご予約の確認メールを送信いたします。'.PHP_EOL.
	PHP_EOL.
	PHP_EOL;
	$return_text .= PHP_EOL. 'ご予約ありがとうございました。'.PHP_EOL;
	
	$to      = $user_email;
  $subject = get_bloginfo('name') .'【ご予約確認メール】　ご予約希望ありがとうございます';
  $message = strip_tags($user_message.$return_text);
	$headers = 'From: '.get_bloginfo('name').' <'.$_admin_mail.'>' . "\r\n";
  
	wp_mail( $to, $subject, $message, $headers);

	echo nl2br(esc_attr(strip_tags($return_text)));
	

}

?>