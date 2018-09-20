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


global $post;
global $form_id;
global $_essence_mailform;
global $_essence_mailform_setting;

//初期化
unset($_SESSION['already_send']);

date_default_timezone_set('Asia/Tokyo');

//  ワンタイムチケットを生成する。
$ticket = md5(uniqid(rand(), true));

//  生成したチケットをセッション変数へ保存する。
$_SESSION['ticket'] = $ticket;


if(is_user_logged_in()){
	//echo '<pre>'; print_r($_SESSION); echo '</pre>';
}

  do_action( 'mailform_essence_before_form_block' );
?>


    <style>
      .imagePreview {
          width: 100%;
          background-position: center center;
        background-repeat: no-repeat;
          background-size:contain;
          display: inline-block;
      }

      .col-mailform_es-3,
      .col-mailform_es-9{
          display: inline-block;
        }
      .col-mailform_es-3 {
        width: 33%;
        box-sizing: border-box;
        vertical-align: top;
        font-weight: 700;
        position: relative;
        padding: 10px;
      }
      .col-mailform_es-9 {
        width: 66%;
        box-sizing: border-box;
        background-color: #FFFFFF;
        padding: 10px;
        float: right;
      }    
      .required-item .col-form-label::before{
        content: '必須';
        display: inline-block;
        position: absolute;
        right: 10px;
        background-color: #E83336;
        color: #FFFFFF;
        padding: 0px 7px;
        font-size: 0.6em;
      }
      #controls-essence-mailform form *:focus{
        background-color: #FFFBD1;
      }
      #controls-essence-mailform form .form-group{
        border: solid #999999 1px;
        margin-bottom: -1px;

        clear: both;
      }
      
      .essence_mailform-submit{
        margin-top: 20px;
      }

      
    @media screen and (max-width: 750px) {
      .col-mailform_es-3,
      .col-mailform_es-9{
          display: block;
        }
      .col-mailform_es-3 {
        width: 100%;
      }
      .col-mailform_es-9 {
        width: 100%;
      }
    }
			
			<?php
				$mods = get_theme_mods();	
				echo '#controls-essence-mailform form .form-group{
					background-color: '.( !empty($mods['es_mailform_bkg']) ? $mods['es_mailform_bkg'] : '#DFEFF5') .';
				}';
			?>
    </style>
    

  <div id="controls-essence-mailform">
  <form method="post" action="#thanks" enctype="multipart/form-data" data-persist="garlic">

  <?php wp_nonce_field( 'add_essence_mailfrom_post', 'nonce_essence_mailform' ); ?>
  <input type="hidden" name="post_id" value="<?php echo $post->ID;?>">
	<input type="hidden" name="form_id" value="<?php echo $form_id;?>">
  <input type="hidden" name="post_microtime" value="<?php echo microtime();?>">
  <input type="hidden" name="post_date" value="<?php echo date('Y-m-d H:i:s');?>">
  <input type="hidden" name="ticket" value="<?php echo $ticket; ?>">
  
  
  <?php
	if( !empty($_GET) ){
		
	}


  do_action( 'mailform_essence_before_inline_form' );

  $counter = 0;
  foreach( $_essence_mailform[0] as $key => $item ){
		
		

    //初期化
    $_required_class = '';
    $_required_label = '';
    
    if( empty($item['type'])){
      continue;
    }elseif( empty( $item['name'] && $item['type'] !== 'hr' )){
      continue;
    }
		
		//フィールド名を設定
		$form_field = !empty($item['field']) ? 'es_mail_'.esc_attr($item['field']) : 'es_mail_'.$item['name'] ;
		
    
    if( !empty($item['required']) ){
      
      $_required_label = ' required';
      
      if( $item['type'] === 'email' ){
        $_required_class = ' validate[required,custom[email]]';
      }elseif( $item['type'] === 'zip' ){
        $_required_class = ' validate[required,custom[zip]]';
      }elseif( $item['type'] === 'tel' ){
        $_required_class = ' validate[required,custom[tel]]';
      }else{
        $_required_class = ' validate[required]';
      }
    }else{
      if( $item['type'] == 'zip' ){
        $_required_class = ' validate[custom[zip]]';
      }
      if( $item['type'] == 'tel' ){
        $_required_class = ' validate[custom[tel]]';
      }
      if( $item['type'] == 'email' ){
        $_required_class = ' validate[custom[email]]';
      }
    }
    
		if( $item['type'] === 'param' ){
			$_field = str_replace('es_mail_', '', $form_field);
			
			$_param[$form_field] = !empty($_GET && $_GET[$_field]) ? $_GET[$_field] : '' ;

			if( empty($_param[$form_field]) && !empty($_COOKIE[$_field]) ){
				$_param[$form_field] = esc_attr($_COOKIE[$_field]);
			}
			
			 echo '<input id="form-input-' . $counter .'" type="hidden" name="'.$form_field.'" class="form-control'.$_required_class.'" value="'.esc_attr($_param[$form_field]).'" />';
		}else{
    echo '<div id="mailform_essence_form-'.$counter.'" class="form-group clearfix ';
    if(isset($_required_label)){
      echo $_required_label.'-item';
    }
    echo '">';
		
		
		echo '<div class="col-mailform_es-3 col-form-label" for="'.$item['name'].'"><label for="form-input-' . $counter .'">' . $item['name'] .'</label></div>';
		echo '<div class="col-mailform_es-9">';
    
    if( $item['type'] === 'text' || $item['type'] === 'email' || $item['type'] === 'tel' ){
			 echo '<input id="form-input-' . $counter .'" name="'.$form_field.'" class="form-control'.$_required_class.'" type="'.$item['type'].'" value=""'.$_required_label.' />';
		}
    
    if( $item['type'] === 'zip' ){
			
			echo '

			<script>
			jQuery( function($) {
				$(\'#get_address\').click(function(){
					var zipcord = $(\'#mailform_essence_form-'.$counter.' input\').val(); //郵便版番号入力値 名前はそれぞれ
					if (zipcord != "" ){
						//loadingとか入れたいとき用　使用時は //を外します
						//$(\'#loading_address\').fadeIn();
						$.ajaxSetup({
						// IE対策 キャッシュクリア
						cache: false, });
						$.ajax({
							type: \'GET\',
							url: \''.MAILFORM_ESSENCE_PLUGIN_URI.'/lib/get_address.php?zipcord=\'+zipcord,
							datatype: \'json\',
							success: function(json){
								$.each(json, function(i, item){
								$(\'#mailform_essence_form-'.$counter.' + div input\').val(item.location1);
								//$(\'#loading_address\').fadeOut();//loadingとか入れた人はこいつで読み込み後消せます。
								});
							}, error: function(){
								// $(\'#loading_address\').fadeOut();//loadingとか入れた人はこいつで読み込み後消せます。
								alert(\'error\');
							}
						});
					} else {
						alert(\'error\');
					}
				});
			});
			</script>

			<div class="row">
				<div class="col-sm-5" style="display:inline-block">
				<input id="form-input-' . $counter .'" name="'.$form_field.'" class="form-control'.$_required_class.'" type="'.$item['type'].'" value="" '.$_required_label.'/>
				</div>
				<div class="col-sm-5" style="display:inline-block">
				<button type="button" id="get_address">自動入力</button>
				</div>
			</div>
			';
		}
    
    if( $item['type'] === 'textarea' ) echo '<textarea id="form-input-' . $counter .'" class="form-control'.$_required_class.'" name="'.$form_field.'" rows="8"'.$_required_label.'></textarea>';
    
    if( $item['type'] === 'select' && !empty($item['fields']) ){
      
      $fields_arr = explode("\n", $item['fields']); // 行に分割
      $fields_arr = array_map('trim', $fields_arr); // 各行にtrim()をかける
      $fields_arr = array_filter($fields_arr, 'strlen'); // 文字数が0の行を取り除く
      $fields_arr = array_values($fields_arr); // これはキーを連番に振りなおす
  
       echo '<select id="form-input-' . $counter .'" class="form-control'.$_required_class.'" name="'.$form_field.'"'.$_required_label.'>';
       foreach( $fields_arr as $select ){
         echo '<option value="'.$select.'">'.$select.'</option>';
       }
       echo '</select>';
    }
    

    if($item['type'] == 'radio' && !empty($item['fields']) ){
      
      $fields_arr = explode("\n", $item['fields']); // 行に分割
      $fields_arr = array_map('trim', $fields_arr); // 各行にtrim()をかける
      $fields_arr = array_filter($fields_arr, 'strlen'); // 文字数が0の行を取り除く
      $fields_arr = array_values($fields_arr); // これはキーを連番に振りなおす
      echo '<div class="form-check">';
       foreach( $fields_arr as $key => $check_item ){
         echo '<div class="form-'.$item['type'].'-item form-check-inline">';
         echo '<input "'.$form_field.'-'.$key.'" name="'.$form_field.'" class="form-check-input'.$_required_class.'" type="'.$item['type'].'" value="'.$check_item.'"'.$_required_label.'>';
         echo '<label class="form-check-label" for="'.$form_field.'-'.$key.'">'.$check_item .'</label>'; 
         echo '</div>';
       }
      echo '</div>';
    }
    
    
    if( $item['type'] == 'checkbox' && !empty($item['fields']) ){
      
      $fields_arr = explode("\n", $item['fields']); // 行に分割
      $fields_arr = array_map('trim', $fields_arr); // 各行にtrim()をかける
      $fields_arr = array_filter($fields_arr, 'strlen'); // 文字数が0の行を取り除く
      $fields_arr = array_values($fields_arr); // これはキーを連番に振りなおす
      echo '<div class="form-check">';
       foreach( $fields_arr as $key => $check_item ){
         echo '<div class="form-'.$item['type'].'-item form-check-inline">';
         echo '<input id="'.$form_field.'-'.$key.'" name="'.$form_field.'[]" class="form-check-input'.$_required_class.'" type="'.$item['type'].'" value="'.$check_item.'">';
         echo '<label class="form-check-label" for="'.$form_field.'-'.$key.'">'.$check_item .'</label>'; 
         echo '</div>';
       }
      echo '</div>';
    }
    
    if( $item['type'] === 'file' ){
    echo '
    <div class="imagePreview"></div>
    <div class="input-group">
        <label class="input-group-btn">
            <span class="btn btn-primary">
                ファイルを選択<input name="'.$form_field.'" type="file" style="display:none" class="uploadFile">
            </span>
        </label>
        <input id="form-input-' . $counter .'" type="text" class="form-control" readonly="">
        <input type="hidden" name="file_label" value="'.$item['name'].'" '.$_required_label.'/>
    </div>';
    };
    
		if( $item['type'] === 'pagetitle'){
			 echo '<input id="form-input-' . $counter .'" name="'.$form_field.'" class="form-control'.$_required_class.'" type="text" value="'.get_the_title($post->ID).'" readonly />';
		}
		
		
		
    
    if( $item['type'] == 'hr' ){
      echo ' <div><hr></div>';
    }

    
    if(  !empty($item['memo']) ){
      echo '<small class="form-text text-muted">'. nl2br($item['memo']).'</small>';
    }
    
    
    
    
    echo '</div>';
    echo '</div>';
		}
    ++$counter;
  }//endforeach

  do_action( 'mailform_essence_after_inline_form' );

  //ユーザー登録の有無
  if( !empty($_essence_mailform_setting['insert_user']) ){
    echo '
    <div id="mailform_essence_form-'.$counter.'" class="form-group clearfix">
      <div class="col-mailform_es-3 col-form-label">
       ユーザー登録をする
      </div>
      <div class="col-mailform_es-9">
        <input type="hidden" name="thread" value="1">
        <input type="checkbox" name="insert_user" value="1" /><label class="form-check-label">する</label>
      </div>
    </div>';
  }
  

  //送信確認の有無
  if( !empty($_essence_mailform_setting['print_confirm']) ){
    echo '<div class="text-center"><button type="submit" name="btn_confirm" class="essence_mailform-submit btn btn-primary" value="入力内容を確認する">確認</button></div>';
  }else{
    echo '<div class="text-center"><button type="submit" class="essence_mailform-submit btn btn-item" name="btn_submit" value="送信">送信</button></div>';
  }

  echo '</form></div>';


  do_action( 'mailform_essence_after_form_block' );


wp_reset_query();
?>