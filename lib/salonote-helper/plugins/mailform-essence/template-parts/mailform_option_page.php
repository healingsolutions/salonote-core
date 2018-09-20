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

<script>
(function( $ ) {
    $('.my-color-field').wpColorPicker();
})( jQuery );
</script>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>お問い合わせ　設定</h2>

<?php
//管理ページ内容
global $mail_form_essence_opt;

//初期化
$mail_form_essence_opt = array();

if ( isset($_POST['mail_form_essence_options'])) {
  
  check_admin_referer('shoptions');
  $mail_form_essence_opt = $_POST['mail_form_essence_options'];
  update_option('mail_form_essence_options', $mail_form_essence_opt);
  
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


<form action="" method="post" enctype="multipart/form-data">
<?php
wp_nonce_field('shoptions');
$mail_form_essence_opt = get_option('mail_form_essence_options');


$mail_form_essence_opt['file_path']             = isset($mail_form_essence_opt['file_path'])            ? $mail_form_essence_opt['file_path']:            '';
$mail_form_essence_opt['create_contact']        = isset($mail_form_essence_opt['create_contact'])       ? $mail_form_essence_opt['create_contact']:       '';
$mail_form_essence_opt['jquery_ui']             = isset($mail_form_essence_opt['jquery_ui'])            ? $mail_form_essence_opt['jquery_ui']:            '';
$mail_form_essence_opt['inline_comment_html']   = isset($mail_form_essence_opt['inline_comment_html'])  ? $mail_form_essence_opt['inline_comment_html']:  '';
$mail_form_essence_opt['spam_list']             = isset($mail_form_essence_opt['spam_list'])            ? $mail_form_essence_opt['spam_list']:           '';

$upload_dir_var = wp_upload_dir();
$upload_dir     = $upload_dir_var['baseurl'];
?>
  
<table class="form-table">


  
<tr valign="top">
  <th scope="row"><label for="inputtext">ファイルURL</label></th>
  <td>
  <?php echo $upload_dir; ?>/<input type="text" class="regular-text" name="mail_form_essence_options[file_path]" value="<?php echo $mail_form_essence_opt['file_path'] ?>" />
    <p class="hint">uploadディレクトリ直下のファイルパスを設定できます</p>
  </td>
</tr>


  
  
<?php
/*
<table class="form-table">
<tr valign="top">
  <th scope="row"><label for="inputtext">SMTPを利用</label></th>
  <td>
  <input type="checkbox" name="mail_form_essence_options[send_smtp]" value="1"<?php if ($mail_form_essence_opt['send_smtp'] == 1){
      echo ' checked';
}; ?>>利用する</input>
 

  <p class="hint">迷惑メール対策のため、送信メールをSMTP形式で送信できます</p>
  </td>
</tr>
</table>


  
<div id="mailform_essence_smtp_block"<?php if( !$mail_form_essence_opt['send_smtp'] ){ echo ' style="display: none;"'; } ?>>
  <table class="form-table">
  <?php
  $smtp_set_arr = array(
    'host'      => 'SMTP サーバー',
    'Username'  => 'ユーザー名',
  );
  foreach( $smtp_set_arr as $name => $label ){
    
    if($name == 'host'){
      $value = !empty($mail_form_essence_opt[$name]) ? $mail_form_essence_opt[$name] : gethostname();
    }else{
      $value = !empty($mail_form_essence_opt[$name]) ? $mail_form_essence_opt[$name] : '';
    }
    
    ?>
    <tr valign="top">
    <th scope="row"><label for="inputtext"><?php echo $label;?></label></th>
    <td>
    <input name="mail_form_essence_options[<?php echo $name;?>]" type="text" id="inputtext" value="<?php echo $value ; ?>" class="short-text" />
    </td>
  </tr>
  <?php
  }
  ?>
    
  <tr valign="top">
    <th scope="row"><label for="inputtext">SMTP認証</label></th>
    <td>
    <input type="checkbox" name="mail_form_essence_options[SMTPAuth]" value="true"<?php if ($mail_form_essence_opt['SMTPAuth'] == true){
      echo ' checked';
}; ?>>利用する</input>
    </td>
  </tr>

  <tr valign="top">
    <th scope="row"><label for="inputtext">SSL</label></th>
    <td>
    <input type="checkbox" name="mail_form_essence_options[SMTPSecure]" value="true"<?php if ($mail_form_essence_opt['SMTPSecure'] == true){
      echo ' checked';
}; ?>>利用する</input>
    </td>
  </tr>
    
  <tr valign="top">
    <th scope="row"><label for="inputtext">SMTPポート番号</label></th>
    <td>
    <select name="mail_form_essence_options[Port]">
      <option value="">---</option>
      <option value="25"<?php if($mail_form_essence_opt['Port'] == 25){ echo ' selected'; } ?>>25</option>
      <option value="465"<?php if($mail_form_essence_opt['Port'] == 465){ echo ' selected'; } ?>>465</option>
      <option value="587"<?php if($mail_form_essence_opt['Port'] == 587){ echo ' selected'; } ?>>587</option>
    </select>
    </td>
  </tr>
  
  
  <tr valign="top">
    <th scope="row"><label for="inputtext">パスワード</label></th>
    <td>
    <input name="mail_form_essence_options[Password]" type="password" id="inputtext" value="<?php echo !empty($mail_form_essence_opt['Password']) ? $mail_form_essence_opt['Password'] : '' ; ?>" class="short-text" />
    </td>
  </tr>
  </table>
</div>
*/
?>

<tr valign="top">
  <th scope="row"><label for="inputtext">コンタクトを作成</label></th>
  <td>
  <input type="checkbox" name="mail_form_essence_options[create_contact]" value="disable"<?php if ($mail_form_essence_opt['create_contact'] == 'disable'){
    echo ' checked';
}; ?>>しない</input>
  </td>
</tr>

<tr valign="top">
  <th scope="row"><label for="inputtext">jQuery-ui</label></th>
  <td>
  <input type="checkbox" name="mail_form_essence_options[jquery_ui]" value="true"<?php if ($mail_form_essence_opt['jquery_ui'] == true){
    echo ' checked';
}; ?>>利用</input>
  <p>使用しているプラグインによっては、重複する場合があるので、利用の「する／しない」を選択いただけます</p>
  </td>
</tr>

<tr valign="top">
  <th scope="row"><label for="inputtext">禁止ワードリスト</label></th>
  <td>
    <textarea rows="6" class="regular-text" width="100%" name="mail_form_essence_options[spam_list]" id="inputtext"><?php echo $mail_form_essence_opt['spam_list'] ?></textarea>
    <p class="hint">禁止ワードを、１つずつ改行して設定できます</p>
  </td>
</tr>

<tr valign="top">
  <th scope="row"><label for="inputtext">テーブルの背景色</label></th>
  <td>
    <input type="text" name="head-text-color" class="my-color-field" value="">
  </td>
</tr>


</table>

<p class="submit"><input type="submit" name="Submit" class="button-primary" value="変更を保存" /></p>
</form>

<script type="text/javascript">
  jQuery(function($){
    $('input[name="mail_form_essence_options[send_smtp]"]').change(function() {
      if ($(this).is(':checked')) $('#mailform_essence_smtp_block').css('display','table-row');
      else $('#mailform_essence_smtp_block').css('display','none');
    });
  });
  </script>


<div class="updated">
  <p>
    本プラグインの郵便番号自動入力には、<a href="http://zipaddress.net/" target="_blank">郵便番号-住所検索API</a>様のAPIを利用しております。
  </p>
</div>

</div><!-- /.wrap -->
