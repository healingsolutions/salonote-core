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
<h2>スライダー　設定</h2>

<?php
//管理ページ内容
global $slider_essence_opt;

//初期化
$slider_essence_opt = array();

if ( isset($_POST['slider_essence_options'])) {
  
  check_admin_referer('shoptions');
  $slider_essence_opt = $_POST['slider_essence_options'];
  update_option('slider_essence_options', $slider_essence_opt);
  
  echo '<div class="updated fade"><p><strong>';
  _e('保存完了');
  echo '</strong></p></div>';
}

?>

<form action="" method="post">
<?php
wp_nonce_field('shoptions');
$slider_essence_opt = get_option('slider_essence_options');
	
$opt['place']				= !empty($slider_essence_opt['place'])				? $slider_essence_opt['place'] : '' ;
$opt['height']			= !empty($slider_essence_opt['height'])				? $slider_essence_opt['height'] : '' ;
$opt['sp_height']		= !empty($slider_essence_opt['sp_height']) 		? $slider_essence_opt['sp_height'] : '' ;
$opt['sp_right']		= !empty($slider_essence_opt['sp_right']) 		? $slider_essence_opt['sp_right'] : 0 ;
$opt['speed']				= !empty($slider_essence_opt['speed']) 				? $slider_essence_opt['speed'] : 8 ;
$opt['font_size']   = !empty($slider_essence_opt['font_size'])    ? $slider_essence_opt['font_size'] : 2.2;
$opt['size']				= !empty($slider_essence_opt['size']) 				? $slider_essence_opt['size'] : 'full';
$opt['zoom']				= !empty($slider_essence_opt['zoom']) 				? $slider_essence_opt['zoom'] : 0;
$opt['title_class'] = !empty($slider_essence_opt['title_class'])  ? $slider_essence_opt['title_class'] : '';
$opt['body_class']  = !empty($slider_essence_opt['body_class'])   ? $slider_essence_opt['body_class'] : '';
$opt['center_mode'] = !empty($slider_essence_opt['center_mode'])  ? $slider_essence_opt['center_mode'] : false;
?>
  
<table class="form-table">


<tr valign="top">
  <th scope="row"><label for="place">配置する場所</label></th>
  <td>
    <input type="text" name="slider_essence_options[place]" value="<?php echo $opt['place'];?>">
  </td>
</tr>
  
<tr valign="top">
  <th scope="row"><label for="title_class">タイトルのclass</label></th>
  <td>
    <input id="title_class" type="text" name="slider_essence_options[title_class]" value="<?php echo $opt['title_class'];?>">
  </td>
</tr>
  
<tr valign="top">
  <th scope="row"><label for="body_class">本文のclass</label></th>
  <td>
    <input id="body_class" type="text" name="slider_essence_options[body_class]" value="<?php echo $opt['body_class'];?>">
  </td>
</tr>
	
<tr valign="top">
  <th scope="row"><label for="height">PC高さ</label></th>
  <td>
    <input type="text" name="slider_essence_options[height]" value="<?php echo $opt['height'];?>">
  </td>
	
	<th scope="row"><label for="sp_height">スマホでの高さ</label></th>
  <td>
    <input type="text" name="slider_essence_options[sp_height]" value="<?php echo $opt['sp_height'];?>">
  </td>
	
	<th scope="row"><label for="sp_right">スマホでの右側比率</label></th>
  <td>
    <input type="number" name="slider_essence_options[sp_right]" value="<?php echo $opt['sp_right'];?>">%
  </td>
</tr>
	
<tr valign="top">
  <th scope="row"><label for="speed">スライド時間</label></th>
  <td>
    <input type="number" name="slider_essence_options[speed]" value="<?php echo $opt['speed'];?>">秒
  </td>
</tr>
  
<tr valign="top">
  <th scope="row"><label for="font_size">フォントサイズ</label></th>
  <td>
    <input type="number" step="0.1" name="slider_essence_options[font_size]" value="<?php echo $opt['font_size'];?>">em
  </td>
</tr>
	
<tr valign="top">
  <th scope="row"><label for="size">画像サイズ</label></th>
  <td>
		<select name="slider_essence_options[size]">
			<option value="large"<?php echo ($opt['size'] == 'large') ? ' selected' : '' ;?>>大サイズ  - large</option>
			<option value="full"<?php echo ($opt['size'] == 'full') ? ' selected' : '' ;?>>フルサイズ  - full</option>
		</select>
  </td>
</tr>
	
<tr valign="top">
  <th scope="row"><label for="zoom">ズーム</label></th>
  <td>
    <input type="checkbox" name="slider_essence_options[zoom]" value="1"<?php echo ($opt['zoom']) ? ' checked' : '' ;?>>
		<p class="hint">スライドした時にゆっくり画像をズームさせる</p>
  </td>
</tr>
  
<tr valign="top">
  <th scope="row"><label for="center_mode">センターモード</label></th>
  <td>
    <input type="checkbox" name="slider_essence_options[center_mode]" value="1"<?php echo ($opt['center_mode']) ? ' checked' : '' ;?>>
		<p class="hint">左右に余白を表示する</p>
  </td>
</tr>



</table>

<p class="submit"><input type="submit" name="Submit" class="button-primary" value="変更を保存" /></p>
</form>


</div><!-- /.wrap -->
