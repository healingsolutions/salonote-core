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
?>

<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>検索順位チェック</h2>

<?php
//管理ページ内容
global $search_engine_opt;

//初期化
$search_engine_opt = array();

if ( isset($_POST['search_engine_ad_essence_options'])) {
  
  check_admin_referer('shoptions');
  $search_engine_opt = $_POST['search_engine_ad_essence_options'];
  update_option('search_engine_ad_essence_options', $search_engine_opt);
  
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
$search_engine_opt = get_option('search_engine_ad_essence_options');

$search_engine_opt['get_keywords']  		= isset($search_engine_opt['get_keywords'])  			? $search_engine_opt['get_keywords']			:  '';
$search_engine_opt['alert_range']  			= isset($search_engine_opt['alert_range'])  			? $search_engine_opt['alert_range']				:  10;
$search_engine_opt['get_search_page']  	= isset($search_engine_opt['get_search_page'])  	? $search_engine_opt['get_search_page']		:  5;
$search_engine_opt['disable_phpquery']  = isset($search_engine_opt['disable_phpquery'])  	? $search_engine_opt['disable_phpquery']	:  false;
$search_engine_opt['get_mobile_rank'] 	= isset($search_engine_opt['get_mobile_rank'])  	? $search_engine_opt['get_mobile_rank']		:  false;

$search_words = explode(',',esc_html($search_engine_opt['get_keywords']));
$_scraping_loop = count($search_words) * $search_engine_opt['get_search_page'];
if( $_scraping_loop > 8 ){
	echo '<p class="attention">負荷が高すぎます。検索ワード数を減らすか、取得するページを減らしてください<br>
	申し訳ありませんが、この問題が解決されるまでは、検索順位の取得は行われません</p>';
}
	
//require_once( SEARCH_ENGINE_ESSENCE_PLUGIN_PATH . '/inc/search_phaser.php' );

	/*
	global $wpdb;
	$table_name = $wpdb->prefix . 'ranking_essence';
	$_my_ranking_archive = array(
			'date' 		=> '2018-05-10 07:59:10',
			'rank' 		=> 11,
			'title' 	=> 'WordPressを使ったホームページ制作のヒーリングソリューションズ',
			'keywords'=> 'WordPress サロン　ホームページ制作',
			'url'  		=> 'https://www.healing-solutions.jp/',
	);


	$wpdb->insert(
		$table_name,
		//$_my_ranking
		$_my_ranking_archive
	);
	*/
	
?> 
<table class="form-table">

	
<tr valign="top">
  <th scope="row"><label for="inputtext">取得するキーワード</label></th>
  <td>
  <input type="text" class="large-text" name="search_engine_ad_essence_options[get_keywords]" value="<?php echo $search_engine_opt['get_keywords'] ?>">
  <p class="hint">複数の場合は半角カンマ区切り</p>
  </td>
</tr>
<tr valign="top">
  <th scope="row"><label for="inputtext">通知する変動</label></th>
  <td>
  <input type="number" class="small-text" name="search_engine_ad_essence_options[alert_range]" value="<?php echo $search_engine_opt['alert_range'] ?>">
  </td>
</tr>
<tr valign="top">
  <th scope="row"><label for="inputtext">取得する最大順位</label></th>
  <td>
  <select name="search_engine_ad_essence_options[get_search_page]">
		<?php
		for ($count = 1; $count < 10; $count++){
			echo '<option value="'.($count).'"';
			if( $search_engine_opt['get_search_page'] == $count ){
				echo ' selected';
			}
			echo'>'.($count*10).'</option>';
		}
		?>
	</select>
  </td>
</tr>
	
<tr valign="top">
  <th scope="row"><label for="inputtext">モバイルランク</label></th>
  <td>
  <input type="checkbox" name="search_engine_ad_essence_options[get_mobile_rank]" value="1"<?php
				 if( !empty( $search_engine_opt['get_mobile_rank'] ) && ($search_engine_opt['get_mobile_rank'] == 1) ){
					 echo ' checked';
				 };?>>
	取得</input>
 

  <p class="hint">PCサイトでの順位の代わりに、モバイルでの順位を取得します。取得できるのはどちらか１つです</p>
  </td>
</tr>

<tr valign="top">
  <th scope="row"><label for="inputtext">phpQueryを使用しない</label></th>
  <td>
  <input type="checkbox" name="search_engine_ad_essence_options[disable_phpquery]" value="1"<?php
				 if( !empty( $search_engine_opt['disable_phpquery'] ) && ($search_engine_opt['disable_phpquery'] == 1) ){
					 echo ' checked';
				 };?>>
	表示</input>
 

  <p class="hint">phpQueryが干渉している場合はチェックを入れてください</p>
  </td>
</tr>


</table>


<p class="submit"><input type="submit" name="Submit" class="button-primary" value="変更を保存" /></p>
</form>


<?php
require_once( SEARCH_ENGINE_ESSENCE_PLUGIN_PATH . '/template-parts/search_results.php' );
?>




</div><!-- /.wrap -->
