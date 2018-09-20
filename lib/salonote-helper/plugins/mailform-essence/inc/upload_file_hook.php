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


global $insert_id;
global $_FILES;
global $file_item;
global $attachments;



//post idを設定
$insert_id = isset($insert_id) ? $insert_id : null ;
$mail_form_essence_opt = get_option('mail_form_essence_options');

//投稿ID

//アップロードするディレクトリとファイルを設定
$mailform_dir = !empty( $mail_form_essence_opt['file_path'])  ? '/'.$mail_form_essence_opt['file_path'] : '' ;

$filename       = basename($file_item['name']);
$filename       = trim($filename);
$filename       = preg_replace("/ /", "-", $filename);
$upload_dir_var = wp_upload_dir();



// 保存先フォルダの作成する。
if ( isset($mailform_dir)){
  $upload_path = $upload_dir_var['basedir'].$mailform_dir.$upload_dir_var['subdir'];
  if (!is_dir($upload_path)) {
    if ( mkdir( $upload_path, 0755,true ) ) {
     //echo "ディレクトリ作成成功！！";      
    } else {
     //echo "ディレクトリ作成失敗！！";
    }
  }
  
  
  $upload_dir = $upload_dir_var['basedir'].$mailform_dir.$upload_dir_var['subdir'];
}else{
  $upload_dir = $upload_dir_var['path'];
}

$uploaddir      = realpath($upload_dir);
$attachments[]  = $uploadfile     = $upload_dir.'/'.$filename;
    

//ファイルを uploadfileにfilenameでアップロードする
if ($file_item["size"] === 0){
	//echo "ファイルはアップロードされてません！！ アップロードファイルを指定してください。";
}else {
  $attachments[] = $upload_dir_var['basedir'].$mailform_dir.$upload_dir_var['subdir'].$filename;
	$result = @move_uploaded_file( $file_item["tmp_name"], $uploadfile);
	if ($result === TRUE ){
		//echo "アップロード成功！！";
	}else{
		//echo "アップロード失敗！！";
	}
}

//ファイルタイプ
$typefile=$file_item['type'];
//ファイル名の拡張子なし
$slugname=preg_replace('/\.[^.]+$/', '', basename($uploadfile));

//アップロードファイルがある場合、以下実行
if ( file_exists($uploadfile) ) { 
		//拡張子をチェックする
          $exten = '';
          if ( $typefile == 'image/jpeg' ) { $exten = 'jpg'; }
	        elseif ( $typefile == 'image/png' ) { $exten = 'png'; }
       		elseif ( $typefile == 'image/gif' ) { $exten = 'gif'; }
					elseif ( $typefile == 'application/pdf' ) { $exten = 'pdf'; }
	  if($exten == ''){
			//echo " file type error. You can upload jpg, png, gif, pdf ";
			return;
	 }
	

	//アップロードファイルを添付する
    $attachment = array(
      'post_mime_type' => $typefile, 
      'post_title' => $slugname, 
      'post_content' => '', 
      'post_status' => 'inherit'
    );
   $attach_id = wp_insert_attachment( $attachment, $uploadfile, $insert_id );

   require_once(ABSPATH . "wp-admin" . '/includes/image.php');
   $attach_data = wp_generate_attachment_metadata( $attach_id, $uploadfile );
   wp_update_attachment_metadata( $attach_id,  $attach_data );

	//ファイル添付が完了したら
	if($attach_id != 0){
		//post_idの投稿に画像を反映させる処理
		$img_src = wp_get_attachment_url($attach_id);
		wp_update_post( array(
				'ID' => $insert_id, 
				'post_content' => '<img src="'.$img_src. '" >'
		  ) );
		//投稿の更新が成功した場合は投稿 ID。失敗した場合は 0。
	}else{
		echo "error attach <br>";
	}

} // fin if file_exists

?>