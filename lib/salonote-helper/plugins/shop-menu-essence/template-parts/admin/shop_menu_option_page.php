<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

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

//wp_enqueue_script('jquery');
wp_enqueue_style( 'ui-lightness', '//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css');
wp_enqueue_script('sfprototypeman', SHOP_MENU_ESSENCE_PLUGIN_URI . '/statics/js/jquery.sfprototypeman.js', array(), '1.0.0');
wp_enqueue_script('shop_menu_essence', SHOP_MENU_ESSENCE_PLUGIN_URI . '/statics/js/shop-menu-admin-min.js', array(), '1.0.0' ,true);
wp_enqueue_style ('shop_menu_essence', SHOP_MENU_ESSENCE_PLUGIN_URI . '/statics/css/shop-menu-admin_style.css');
?>



<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>ショップメニュー　設定</h2>

<?php
//管理ページ内容
global $shop_menu_opt;

//初期化
$shop_menu_opt = array();

if ( !empty($_POST['shop_menu_essence_options'])) {
  
  check_admin_referer('shop_menu_nonce');
  $shop_menu_opt = $_POST['shop_menu_essence_options'];
  update_option('shop_menu_essence_options', $shop_menu_opt);
  
  echo '<div class="updated fade"><p><strong>';
  _e('保存完了');
  echo '</strong></p></div>';
}

?>
<style>
  .form-table td p.hint{
    font-size: 0.8em;
    color: #999999;
  }
</style>


<form action="" method="post" autocomplete="off">
<?php
wp_nonce_field('shop_menu_nonce');
$shop_menu_opt = get_option('shop_menu_essence_options');

?> 
<table class="form-table">
<tbody>

<tr valign="top">
	

  <th scope="row"><label for="manage_member">メニューページ</label></th>
  <td>
		<select name="shop_menu_essence_options[show_public]">
			<option value="">表示しない</option>
			<option value="show"<?php
							if( !empty($shop_menu_opt['show_public']) && $shop_menu_opt['show_public'] == 'show' ){
								echo ' selected';
							}
							?>>表示する</option>
		</select>
  </td>
</tr>

  
  
  <tr valign="top">
	

  <th scope="row"><label for="menu_tax">税表示</label></th>
  <td>
		<select name="shop_menu_essence_options[menu_tax]">
			<option value="">表示しない</option>
			<option value="show"<?php
							if( !empty($shop_menu_opt['menu_tax']) && $shop_menu_opt['menu_tax'] == 'show' ){
								echo ' selected';
							}
							?>>(税別)</option>
      <option value="show_2"<?php
							if( !empty($shop_menu_opt['menu_tax']) && $shop_menu_opt['menu_tax'] == 'show_2' ){
								echo ' selected';
							}
							?>>(+税)</option>
      <option value="in_tax"<?php
							if( !empty($shop_menu_opt['menu_tax']) && $shop_menu_opt['menu_tax'] == 'in_tax' ){
								echo ' selected';
							}
							?>>(税込)</option>
		</select>
  </td>
</tr>
  
  
<tr valign="top">
	

  <th scope="row"><label for="register_user">ユーザー登録</label></th>
  <td>
		<label for="register_user">
		<input id="register_user" type="checkbox" name="shop_menu_essence_options[register_user]" value="register"<?php
					 if( !empty($shop_menu_opt['register_user']) && $shop_menu_opt['register_user'] === 'register' ){
						 echo ' checked';
					 }
		?>>する</label>
  </td>
</tr>

	
<tr>
	
	<th scope="row"><label for="manage_member">予約希望確認</label></th>
  <td style="line-height: 2;">
		<div>
		<label for="reserve_type-hearing">
		<input id="reserve_type-hearing" type="checkbox" name="shop_menu_essence_options[reserve_type][]" value="hearing"<?php
					 if( !empty($shop_menu_opt['reserve_type']) && in_array( 'hearing' , $shop_menu_opt['reserve_type'] ) ){
						 echo ' checked';
					 }
		?>>ヒアリング</label>
		</div>
		
		<div>
		<label for="reserve_type-select">
		<input id="reserve_type-select" type="checkbox" name="shop_menu_essence_options[reserve_type][]" value="recommend"<?php
					 if( !empty($shop_menu_opt['reserve_type']) && in_array( 'recommend' , $shop_menu_opt['reserve_type'] ) ){
						 echo ' checked';
					 }
		?>>候補選択式</label>
		</div>
			
		<div>
		<label for="reserve_type-preferred">
		<input id="reserve_type-preferred" type="checkbox" name="shop_menu_essence_options[reserve_type][]" value="preferred"<?php
					 if( !empty($shop_menu_opt['reserve_type']) && in_array( 'preferred' , $shop_menu_opt['reserve_type'] ) ){
						 echo ' checked';
					 }
		?>>希望日入力</label>
		</div>
  </td>
</tr>

<tr id="shop_menu_holiday_week">
	
	<th scope="row">定休日</th>
  <td style="line-height: 2;">
		
		<?php
		$weekday = array('日', '月', '火', '水', '木', '金', '土');
		foreach( $weekday as $key => $value ){
			echo '
				<div style="display: inline; margin-right:10px;">
				<label for="reserve_type-holiday-'.$key.'">
				<input id="reserve_type-holiday-'.$key.'" type="checkbox" name="shop_menu_essence_options[holiday]['.$key.']" value="1"';

				if( !empty($shop_menu_opt['holiday'][$key]) ){
					echo ' checked';
				}
				echo '>';
				echo $value.'</label>
				</div>
			';
		};
		?>

  </td>
</tr>
	
	<tr>
		<th scope="row"><label for="enable_reserve">予約可能日数</label></th>
		<td>
			今日から<input type="number" class="small-text" name="shop_menu_essence_options[enable_reserve][start]" value="<?php echo (!empty($shop_menu_opt['enable_reserve']['start']) ? esc_attr($shop_menu_opt['enable_reserve']['start']) : ''); ?>">日後〜

			<input type="number" class="small-text" name="shop_menu_essence_options[enable_reserve][end]" value="<?php echo (!empty($shop_menu_opt['enable_reserve']['end']) ? esc_attr($shop_menu_opt['enable_reserve']['end']) : ''); ?>">日後まで
		</td>
	</tr>


	<tr>
		<th scope="row"><label for="manage_member">時間帯区切り</label></th>
		<td>
			<textarea rows="5" class="large-text" name="shop_menu_essence_options[reserve_times]"><?php echo (!empty($shop_menu_opt['reserve_times']) ? esc_attr($shop_menu_opt['reserve_times']) : '10:00〜'.PHP_EOL.'12:00〜'.PHP_EOL.'14:00〜'.PHP_EOL.'16:00〜'.PHP_EOL.'18:00〜'.PHP_EOL.'20:00〜'); ?></textarea>
			<p class="hint">予約受付の時間を改行で区切ってください</p>
		</td>
	</tr>
	
	<tr>
		<th scope="row"><label for="manage_member">ご都合の良い時間帯</label></th>
		<td>
			<textarea rows="5" class="large-text" name="shop_menu_essence_options[hearing_date_time]"><?php echo (!empty($shop_menu_opt['hearing_date_time']) ? esc_attr($shop_menu_opt['hearing_date_time']) : '午前中　早め'.PHP_EOL.'午前中　遅め'.PHP_EOL.'正午あたり'.PHP_EOL.'お昼　少し過ぎ'.PHP_EOL.'午後'.PHP_EOL.'夕方ごろ'.PHP_EOL.'夜　早め'.PHP_EOL.'夜　遅め'); ?></textarea>
			<p class="hint">ご都合の良い時間帯を改行で区切ってください。空欄の場合は初期値が適用されます</p>
		</td>
	</tr>
	
	
	<tr id="shop_menu_form">
		<th scope="row"><label for="manage_member">オススメする時間</label></th>
		<td>
			<?php
			$recommend_times = '<div class="doraggable-fields">
						<label for=" id="recommend_datetime___name___day">日にち</label>
						<input id="recommend_datetime___name___day" class="datepicker" type="text" name="shop_menu_essence_options[recommend_datetime][__name__][day]" value="">
						
						<label for=" id="recommend_datetime___name___time" style="margin-left: 15px;">時間</label>
						<input id="recommend_datetime___name___time" class="regular-text" type="text" name="shop_menu_essence_options[recommend_datetime][__name__][time]" value="">
					</div>';
			$recommend_times = htmlspecialchars($recommend_times);
			
			
			if( !empty($shop_menu_opt['recommend_datetime']) ){
				$recommend_datetime = $shop_menu_opt['recommend_datetime'];
			}else{
				$recommend_datetime = array(
					array(
						'day' => date('Y-m-d'),
						'time'=> '',
					)
				);
			}

			?>
			
			
			<div>
				<div id="recommend_times"  data-prototype="<?php echo $recommend_times; ?>">
					
					<?php
					foreach( $recommend_datetime as $key => $value ){
						if( empty($value['day']) ) continue;
						
						echo '<div class="doraggable-fields">
						<label for=" id="recommend_datetime_'.$key.'_day">日にち</label>
						<input id="recommend_datetime_'.$key.'_day" class="datepicker" type="text" name="shop_menu_essence_options[recommend_datetime]['.$key.'][day]" value="'.($value['day'] ? esc_attr($value['day']) : '' ).'">
						
						<label for=" id="recommend_datetime_'.$key.'_time" style="margin-left: 15px;">時間</label>
						<input id="recommend_datetime_'.$key.'_time" class="regular-text" type="text" name="shop_menu_essence_options[recommend_datetime]['.$key.'][time]" value="'.($value['time'] ? esc_attr($value['time']) : '全日' ).'">
					</div>';
					}
					?>
					
					
				</div>
			</div>

			
			<p class="hint">時間が空欄の場合は、自動的に「全日」扱いとなります</p>
		</td>
	</tr>


	</tbody>
</table>


<style type="text/css">
form .sfPrototypeMan {
  background-color: #ebebeb;
}
form .sfPrototypeMan div * {
  display: inline-block;
}
form .sfPrototypeMan label {
  margin-right: 1em;
}
</style>

	
	
<table class="form-table">
<tbody>	
<tr>
	<th scope="row"><label for="manage_member">通知メールアドレス</label></th>
  <td>
		<input type="email" name="shop_menu_essence_options[admin_mail]" value="<?php echo (!empty($shop_menu_opt['admin_mail']) ? esc_attr($shop_menu_opt['admin_mail']) : ''); ?>">
  </td>
</tr>
	
<tr>
	<th scope="row"><label for="manage_member">返信メールテキスト</label></th>
	<td>
		<textarea rows="5" class="large-text" name="shop_menu_essence_options[return_text]"><?php echo (!empty($shop_menu_opt['return_text']) ? esc_attr($shop_menu_opt['return_text']) : ''); ?></textarea>
		<p class="hint">返信メールと、サンクスページに表示されます</p>
	</td>
</tr>
	
</tbody>
</table>


<p class="submit"><input type="submit" name="Submit" class="button-primary" value="変更を保存" /></p>
</form>


</div><!-- /.wrap -->
