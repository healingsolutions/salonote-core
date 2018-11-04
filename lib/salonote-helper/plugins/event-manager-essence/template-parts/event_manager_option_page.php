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

?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>イベント　設定</h2>

<?php
//管理ページ内容
global $event_opt;

//初期化
$event_opt = array();

if ( isset($_POST['event_manager_essence_options'])) {
  
  check_admin_referer('shoptions');
  $event_opt = $_POST['event_manager_essence_options'];
  update_option('event_manager_essence_options', $event_opt);
  
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
wp_nonce_field('shoptions');
$event_opt = get_option('event_manager_essence_options');

$event_opt['manage_member']		= isset($event_opt['manage_member'])	? $event_opt['manage_member']		: null;
$event_opt['event_info']			= isset($event_opt['event_info'])			? $event_opt['event_info']			: null;
$event_opt['event_join']			= isset($event_opt['event_join'])			? $event_opt['event_join'] 	 		: null;
$event_opt['event_timetable']	= isset($event_opt['event_timetable'])? $event_opt['event_timetable']	: '';
	
$event_opt['baby_price']			= isset($event_opt['baby_price'])			? $event_opt['baby_price']			: 0;  
$event_opt['child_price']			= isset($event_opt['child_price'])		? $event_opt['child_price']			: 500;
	
$event_opt['post_type']				= isset($event_opt['post_type'])			? $event_opt['post_type']				: null;

?> 
<table class="form-table">

<tr valign="top">
  <th scope="row"><label for="manage_member">参加者管理をする</label></th>
  <td>
  <input name="event_manager_essence_options[manage_member]" type="checkbox" value="1" <?php echo !empty($event_opt['manage_member']) ? ' checked' : '' ?>/>
  </td>
</tr>
	
<tr valign="top">
  <th scope="row"><label for="event_info">イベント情報の管理をする</label></th>
  <td>
  <input name="event_manager_essence_options[event_info]" type="checkbox" value="1" <?php echo !empty($event_opt['event_info']) ? ' checked' : '' ?>/>
  </td>
</tr>
	
<tr valign="top">
  <th scope="row"><label for="event_join">参加を受け付ける</label></th>
  <td>
		<input name="event_manager_essence_options[event_join]" type="checkbox" value="1" <?php echo !empty($event_opt['event_join']) ? ' checked' : '' ?>/>
		<p class="hint">参加フォーム形式で受け付ける場合</p>
  </td>
</tr>

<tr valign="top">
  <th scope="row"><label for="event_schedule">時間割</label></th>
  <td>
		<input name="event_manager_essence_options[event_timetable]" type="text" value="<?php echo $event_opt['event_timetable'] ?>" class="regular-text"/>
		<p class="hint">あらかじめ時間割が決まっている場合は、半角カンマ区切りで入力してください</p>
  </td>
</tr>

<tr valign="top">
  <th scope="row"><label for="event_timetable_limit">時間割の受付人数</label></th>
  <td>
		<input name="event_manager_essence_options[event_timetable_limit]" type="number" value="<?php echo $event_opt['event_timetable_limit'] ?>" class="small-text"/>
		<p class="hint">時間割の受付人数の初期値を設定できます</p>
  </td>
</tr>


<tr valign="top">
  <th scope="row"><label for="event_timetable_login">ログイン必須</label></th>
  <td>
		<input name="event_manager_essence_options[event_timetable_login]" type="checkbox" value="1" <?php echo !empty($event_opt['event_timetable_login']) ? ' checked' : '' ?>/>
		<p class="hint">タイムテーブルの予約はログインを必須にする</p>
  </td>
</tr>
	
<tr valign="top">
  <th scope="row"><label for="baby_price">未就学児料金</label></th>
  <td>
  <input name="event_manager_essence_options[baby_price]" type="number" value="<?php echo $event_opt['baby_price'] ?>" class="regular-text"/>
  </td>
</tr>
	
<tr valign="top">
  <th scope="row"><label for="child_price">子ども向け料金</label></th>
  <td>
  <input name="event_manager_essence_options[child_price]" type="number" value="<?php echo $event_opt['child_price'] ?>" class="regular-text"/>
  </td>
</tr>
	
	
<tr valign="top">
  <th scope="row"><label for="child_price">適用する投稿タイプ</label></th>
  <td>
		<ul>
		<?php
	
			$args = array(
				 'public'   => true,
				 '_builtin' => false
			);

			$post_types = get_post_types( $args, 'names' );
			array_push($post_types, "post");
			array_push($post_types, "page");
			
			foreach ( $post_types as $post_type_name ) {
				echo '<li><label for="">';
				echo '<input type="checkbox"  name="event_manager_essence_options[post_type][]" value="'. $post_type_name .'"';
				if( !empty($event_opt['post_type']) && in_array($post_type_name,$event_opt['post_type']) ){
					echo ' checked';
				}
				echo '>';
				echo get_post_type_object($post_type_name)->labels->singular_name;
				echo '</label></li>';
			}
		?>
		</ul>
  </td>
</tr>


</table>


<p class="submit"><input type="submit" name="Submit" class="button-primary" value="変更を保存" /></p>
</form>


</div><!-- /.wrap -->
