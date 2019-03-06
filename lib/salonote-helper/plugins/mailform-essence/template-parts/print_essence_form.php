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

//  セッションを開始する  
if ( !session_status()) {
    session_start();
}

global $form_id;
global $post;
global $_essence_mailform;
global $_essence_mailform_setting;

$mail_form_essence_opt = get_option('mail_form_essence_options');
$_essence_mailform = get_post_meta( $form_id , 'essence_mailform' );
$_essence_mailform_setting = get_post_meta( $form_id , 'essence_mailform_setting',true );


// ====================================
// 日程による受付制限がある場合
$_request_limit  = !empty( $_essence_mailform_setting['request_limit'] ) ? $_essence_mailform_setting['request_limit']   : 0 ;

if( $_request_limit > 0 ){

  $args = array(
      'post_type'   => 'es_contact',
      'showposts'   => -1,
      'post_parent' => $form_id
  );
  $requested_posts = query_posts($args);
	//echo '<pre>'; print_r($requested_posts); echo '</pre>';
  $requested_count = count($requested_posts);
  if( empty($_POST['post_microtime'])){
    if( $requested_count < $_request_limit ){
      echo '<div><h2>限定'.$_request_limit.'件の受付となります</h2></div>';
      echo '<div><p>あと<b style="font-size:1.3em;">'.($_request_limit - $requested_count).'件</b>で受付終了です</p></div>';
    }elseif( $requested_count >= $_request_limit ){
      echo '<div><h2>受付は終了しました</h2></div>';
      return;
    }
  }
}



// ====================================
// 日程による受付制限がある場合
$_start_date    = !empty( $_essence_mailform_setting['start_date'] )    ? $_essence_mailform_setting['start_date']   : '' ;
$_end_date      = !empty( $_essence_mailform_setting['end_date'] )      ? $_essence_mailform_setting['end_date']     : '' ;

if( isset($_start_date) || isset($_end_date) ){
  $_today      = date('Y-m-d');
  $start_date = date('Y-m-d',strtotime($_start_date));
  $end_date   = date('Y-m-d',strtotime($_end_date));
  
  if( !empty( $_start_date ) && $_today <= $start_date){
    echo date('Y年m月d日',strtotime($_start_date)). 'からの受付となります';
    return;
  }
  if( !empty( $_end_date ) && $end_date <= $_today){
    echo date('Y年m月d日',strtotime($_end_date)). 'を以って、終了しました';
    return;
  }
  
  //カウントダウンを表示 =================================
  if( !empty ($_essence_mailform_setting['count_down']) ){
    //echo 'カウントダウンを表示';
    require_once( MAILFORM_ESSENCE_PLUGIN_PATH . '/template-parts/module/count-block.php');
  }

};


  ?>

<style>

	.required-item .col-form-label::before{
		border-radius: 4px;
		padding: 4px 10px;
	}
  .essence_mailform-submit{
    font-size: 1.2em;
  }
  .form-check-label{
    margin-left: 10px;
  }
</style>

  
<?php

	require_once( MAILFORM_ESSENCE_PLUGIN_PATH . '/template-parts/module/form-block.php');

	//チャートを表示 =================================
	if( !empty ($_essence_mailform_setting['print_result']) ){
		//echo 'チャートを表示';
		require_once( MAILFORM_ESSENCE_PLUGIN_PATH . '/template-parts/module/chart-block.php');
	}
?>