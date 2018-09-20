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

wp_enqueue_style ('shop_menu_essence', SHOP_MENU_ESSENCE_PLUGIN_URI . '/statics/css/shop-menu-admin_style.css');

global $wpdb;

$url = admin_url();

$table_name = $wpdb->prefix . 'shop_menu_essence';

$query = "SELECT *
FROM $table_name
ORDER BY meta_id DESC
LIMIT 20;";

$reserves_result = $wpdb->get_results($query);

?>

<div class="wrap">
<h1 class="wp-heading-inline">ご予約リスト</h1>

<a href="<?php echo $url; ?>admin.php?page=shop_menu_reserves_page" class="page-title-action">ご予約を追加</a>
<hr class="wp-header-end">

	
<?php
if( !empty($reserves_result) ){
	foreach( $reserves_result as $key => $value ){
		
		echo '<div class="shop_menu_reserves-block">';
		
		echo '<dl class="shop_menu_reserves-block basic-info">';

		// basic information ===============================
		
		echo $value->rsv_name ? '<dt>ご予約名</dt><dd>'.$value->rsv_name.'</dd>' : '';
		echo $value->rsv_mail ? '<dt>メールアドレス</dt><dd>'.$value->rsv_mail.'</dd>' : '';
		echo $value->rsv_phone ? '<dt>お電話番号</dt><dd><a href="tel:'.$value->rsv_phone.'">'.$value->rsv_phone.'</a></dd>' : '';
		
		echo '</dl>';
		
		echo '<hr>';
		
		
		// reserve menu ===============================
		$rsv_menu = unserialize($value->rsv_menu);
		//echo '<pre>rsv_menu'; print_r($rsv_menu); echo '</pre>';
		echo $rsv_menu['menu'] ? '<dl class="shop_menu_reserves-block reserve-menu"><dt>ご予約メニュー</dt><dd>'.$rsv_menu['menu'].'</dd></dl>' : '';
		
		if( !empty($rsv_menu['option']) ){
			echo '<dl class="shop_menu_reserves-block reserve-menu">';
			echo '<dt>オプション</dt>';
			foreach( $rsv_menu['option'] as $option_key => $option_value ){
				preg_match('/%%(.+?)%%/', $option_value, $matches);
				$_option_id = $matches[1];
				$_option_label = str_replace('%%'.$_option_id.'%%', '', $option_value);
				echo $option_value ? '<dd>'.$_option_label.'</dd>' : '';
			}
			echo '</dl>';
		}
		
		
		echo '<hr>';
		
		
		// reserve datetime ===============================
		$rsv_datetime = unserialize($value->rsv_datetime);
		//echo '<pre>rsv_datetime'; print_r($rsv_datetime); echo '</pre>';
		
		// hearing -----------
		if( !empty($rsv_datetime['hearing']) ){
			
			if( !empty($rsv_datetime['hearing']['week']) && !empty($rsv_datetime['hearing']['date_time']) ){
			
			echo '<div class="heading">ご希望</div>';

			echo '<dl class="shop_menu_reserves-block reserve-date">';
				if( !empty($rsv_datetime['hearing']['week']) ){
					echo '<dt>曜日</dt>';
					foreach( $rsv_datetime['hearing']['week'] as $hearing_week_key => $hearing_week_value ){
						echo $hearing_week_value ? '<dd>'.$hearing_week_value.'</dd>' : '';
					}
				}
			
				if( !empty($rsv_datetime['hearing']['date_time']) ){
					echo '<dt>時間</dt>';
					foreach( $rsv_datetime['hearing']['date_time'] as $hearing_date_time_key => $hearing_date_time_value ){
						echo $hearing_date_time_value ? '<dd>'.$hearing_date_time_value.'</dd>' : '';
					}
				}
			
				echo $rsv_datetime['hearing']['reason'] ? '<dt>ご希望の理由</dt><dd>'.$rsv_datetime['hearing']['reason'].'</dd>' : '';
				echo '</dl>';
			}
		}
		
		// recommend -----------
		if( !empty($rsv_datetime['recommend']) ){
				echo '<dl class="shop_menu_reserves-block reserve-date">';
				echo $rsv_datetime['recommend'] ? '<dt>ご予約日</dt><dd>'.$rsv_datetime['recommend'].'</dd>' : '';
				echo '</dl>';
		}
		
		
		// preferred -----------
		if( !empty($rsv_datetime['preferred']) ){
			echo '<div class="heading">ご希望日</div>';
			foreach( $rsv_datetime['preferred'] as $preferred_key => $preferred_value ){
				
				if( empty($preferred_value['date']) ) continue;
				
				echo '<dl class="shop_menu_reserves-block reserve-date">';
				echo $preferred_value['date'] ? '<dt>日付</dt><dd>'.$preferred_value['date'].'</dd>' : '';
				
				if( !empty($preferred_value['time']) ){
					echo '<dt>時間</dt>';
					foreach( $preferred_value['time'] as $preferred_time_key => $preferred_time_value ){
						echo $preferred_time_value ? '<dd>'.$preferred_time_value.'</dd>' : '';
					}
				}
				echo '</dl>';
			}
		}
		
		
		echo '<dl class="shop_menu_reserves-block memo-block">';
		$rsv_memo = unserialize($value->rsv_memo);
		//echo '<pre>rsv_memo'; print_r($rsv_memo); echo '</pre>';
		echo $rsv_memo['address'] ? '<dt>ご住所</dt><dd>'.$rsv_memo['address'].'</dd>' : '';
		echo $rsv_memo['message'] ? '<dt>メッセージ・ご要望</dt><dd>'.$rsv_memo['message'].'</dd>' : '';

		echo '</dl>';
		
		echo '<hr>';
		echo '<dl class="shop_menu_reserves-block basic-info">';
		echo $value->rsv_date ? '<dt>ご予約送信日</dt><dd>'.$value->rsv_date.'</dd>' : '';
		echo '</dl>';
		
		echo '</div>';
	}
}else{
	echo '<p>まだ予約がありません</p>';
}
?>

<div id="ajax-response"></div>
<br class="clear">
</div>