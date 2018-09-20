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


global $_POST;
global $post_fields;
global $form_id;
global $insert_id;

$post_fields  = $_POST;



unset($post_fields['nonce_essence_mailform']);
unset($post_fields['_wp_http_referer']);
unset($post_fields['post_microtime']);
unset($post_fields['insert_user']);
unset($post_fields['thread']);
unset($post_fields['comfirm']);

unset($post_fields['post_id']);
unset($post_fields['post_date']);
unset($post_fields['ticket']);
?>
<form method="post" action="">
<?php
  
//確認テキスト
  echo '<h1>確認</h1><p>以下のメールを送信します</p>';
  echo '<table class="table table-bordered table-striped"><tbody>';
  foreach( $post_fields as $field_label => $field_item ){
    echo '<tr><th>'.$field_label.'</th><td>'.$field_item . '</td></tr>';
  }
  echo '</tbody></table>';

?>
<div class="col-sm-9 form-inline" style="text-align: center; margin-left: auto;margin-right: auto;">
  <div style="display: inline-block;"><input class="form-control" type="submit" name="btn_submit" value="送信"></div>
  <div style="display: inline-block;"><input class="form-control" type="button" value="戻る" onclick="history.back()"></div>
</div>
</form>
