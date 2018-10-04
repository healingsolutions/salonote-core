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

date_default_timezone_set('Asia/Tokyo');

//  セッションを開始する  
session_start();

$defalut_time = date_default_timezone_get();
$original_timezone = !empty( $defalut_time ) ? $defalut_time : 'Asia/Tokyo' ;
date_default_timezone_set( $original_timezone );

add_action('admin_print_styles', 'mailform_essence_admin_print_styles');
function mailform_essence_admin_print_styles() {
  wp_enqueue_style( 'wp-color-picker' );
}
add_action('admin_print_scripts', 'mailform_essence_admin_print_scripts');
function mailform_essence_admin_print_scripts() {
  wp_enqueue_script( 'wp-color-picker' );
  //wp_enqueue_script( 'my-admin-script', get_bloginfo('stylesheet_directory') . '/js/colorPicker.js', array( 'wp-color-picker' ), false, true );
}
 


function load_admin_mailform_essence_enqueue($hook) {
  global $post,$pagenow ;
  
  wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js');
  
  if ( is_admin() || $pagenow == 'edit.php' && $post->post_type === 'es_mailform') {
    
    $mail_form_essence_opt = get_option('mail_form_essence_options');

    wp_enqueue_style( 'ui-lightness', '//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css');
    if( !empty($mail_form_essence_opt['jquery_ui'])&&$mail_form_essence_opt['jquery_ui']){
    wp_enqueue_script( 'jquery-ui-core', '//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js');
    wp_enqueue_script( 'jquery-ui-datepicker', '//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js');
    }

  }
  
  if ( is_admin() || $pagenow == 'edit.php' && $post->post_type === 'es_contact') {
    wp_enqueue_style( 'es_contact-css', MAILFORM_ESSENCE_PLUGIN_URI.'/statics/css/mailform-essence.css',array(),'1.0.0');
    wp_enqueue_style( 'jquery-colorbox', MAILFORM_ESSENCE_PLUGIN_URI.'/statics/js/colorbox/colorbox.css');
    wp_enqueue_script( 'jquery-colorbox', MAILFORM_ESSENCE_PLUGIN_URI.'/statics/js/colorbox/jquery.colorbox-min.js');
    wp_enqueue_script('chart-js' , 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js', array(), '2.1.4');
    
    function my_custom_admin_head() {
      echo '<script type=""text/javascript">
      jQuery(function($) {
          $("a.colorbox").colorbox({
          maxWidth:"90%",
          maxHeight:"90%",
          opacity: 0.7
        });
      });
      </script>';
    }
    add_action( 'admin_head', 'my_custom_admin_head' );
    
  }
}
add_action( 'admin_enqueue_scripts', 'load_admin_mailform_essence_enqueue',10 );




function load_public_mailform_essence_enqueue($content){
	if( !is_singular() )
		return;
	
	global $post;
	if(strpos($post->post_content,'[essence-mailform-pro') == false){
		//return;
	}
	
	wp_enqueue_script( 'jquery-validationEngine', MAILFORM_ESSENCE_PLUGIN_URI.'/statics/jQuery-Validation-Engine/js/jquery.validationEngine.js',array(), '1.0',true);
	wp_enqueue_script( 'jquery-validationEngine-ja', MAILFORM_ESSENCE_PLUGIN_URI.'/statics/jQuery-Validation-Engine/js/languages/jquery.validationEngine-ja.js',array(), '1.0.1',true);
	wp_enqueue_script( 'jquery-sisyphus', MAILFORM_ESSENCE_PLUGIN_URI.'/statics/js/garlic.min.js',array(), '1.4.2',true);
	
}
add_action( 'wp_enqueue_scripts', 'load_public_mailform_essence_enqueue',10 );


add_action('wp_footer', function () {
 wp_enqueue_style( 'jquery-validationEngine', MAILFORM_ESSENCE_PLUGIN_URI.'/statics/jQuery-Validation-Engine/css/validationEngine.jquery.css');
	
	
	if( !is_singular() )
		return;
	
	global $post;
	if(strpos($post->post_content,'[essence-mailform-pro') === false)
		return;
	
	?>
<script>
jQuery(function($) {
	/*
	$("#controls-essence-mailform").sisyphus({
		locationBased: false,
		timeout: 60*60*12,
		excludeFields: $('input[type="hidden"]'),
		autoRelease: false
	});
	*/

	$("#controls-essence-mailform").garlic();
	$("#controls-essence-mailform").validationEngine();
});

jQuery(document).on('change', ':file', function($) {
		var input = jQuery(this),
		numFiles = input.get(0).files ? input.get(0).files.length : 1,
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

		console.log(label);
		input.parent().parent().next(':text').val(label);
		input.parent().parent().next(':hidden').val(label);

		var files = !!this.files ? this.files : [];
		if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
		if (/^image/.test( files[0].type)){ // only image file
				var reader = new FileReader(); // instance of the FileReader
				reader.readAsDataURL(files[0]); // read the local file
				reader.onloadend = function(){ // set image data as background of div
						input.parent().parent().parent().prev('.imagePreview').css("background-image","url("+this.result+")");
						input.parent().parent().parent().prev('.imagePreview').css({
							'height':'180px',
							'-webkit-box-shadow':'0 0 1px 1px rgba(0, 0, 0, .3)'
						});
				}
		}
});
</script>
	<?php
	
},99);

//async javascript
function addasync_mailformessence_enqueue_script( $tag, $handle ) {
    if (
			'jquery-validationEngine' !== $handle &&
			'jquery-validationEngine-ja' !== $handle &&
			'jquery-sisyphus' !== $handle
		)
		{
        return $tag;
    }
    return str_replace( ' src', ' async="async" src', $tag );
}
add_filter( 'script_loader_tag', 'addasync_mailformessence_enqueue_script', 10, 2 );







$mail_form_essence_opt = get_option('mail_form_essence_options');
$mail_form_essence_opt['create_contact']   = isset($mail_form_essence_opt['create_contact'])     ? $mail_form_essence_opt['create_contact']:    '';
if( $mail_form_essence_opt['create_contact'] !== 'disable' ){
	require( MAILFORM_ESSENCE_PLUGIN_PATH . '/inc/post_type/contact_post_type.php');
}




//attachment_id=ページに404を返す
function mailform_essence_attachment_template_redirect() {
    if ( is_attachment() ) { // 添付ファイルの個別ページなら
      global $post;
      $parent_id = wp_get_post_parent_id($post->ID);
      if(get_post_type($parent_id) ==- 'es_contact' ){
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
      }
    }
}
add_action( 'template_redirect', 'mailform_essence_attachment_template_redirect' );

//attachmentの場合は、htmlメール
function set_html_content_type() {
    return 'text/html';
}


// ショートコードが含まれている場合は、javascriptを強制
add_filter('wp_head','print_no_script_redirect');
function print_no_script_redirect(){
  if( is_singular() ){
    global $post;
    $content = $post->post_content;
    if(strpos($content,'essence-mailform-pro') !== false){
      echo '
      <noscript>
        <meta http-equiv="Refresh" content="0; URL='. home_url() .'">
      </noscript>
      ';
    }
  }
}







class Mailform_Essence_Theme_Customize
   {

    //管理画面のカスタマイズにテーマカラーの設定セクションを追加
    public static function mailform_essence_customize_register($wp_customize) {

			$wp_customize->add_setting( 'es_mailform_bkg', array( 'default' => '#DFEFF5','sanitize_callback' => 'sanitize_hex_color' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'es_mailform_bkg' , array(
					'label' => 'メールフォーム見出し背景',
					'section' => 'colors',
					'settings' => 'es_mailform_bkg',
			) ) );


			//リアルタイム反映
			$wp_customize->get_setting('es_mailform_bkg')->transport = 'postMessage';
			
    }

}//Slide_Essence_Theme_Customize

// テーマ設定やコントロールをセットアップします。
add_action( 'customize_register' , array( 'Mailform_Essence_Theme_Customize' , 'mailform_essence_customize_register' ),20 );



//redirect hook
/**
* テンプレートが読み込まれる直前で実行される
*/
//define('DONOTCACHEPAGE',true);


function mailform_essence_none_cache_hook_wrap() {
	global $post;
	if( is_singular()){

		
		if( has_shortcode( $post->post_content, 'essence-mailform-pro') ){
			define('LSCACHE_NO_CACHE', true);
			//echo 'clear default_cache';
			
			define('DONOTCACHEPAGE',true);
			
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if( is_plugin_active( 'wp-super-cache/wp-cache.php' ) ){
				wpsc_delete_post_cache($post->ID);
				//echo 'clear super_cache';
			}
			
			return;
			
		}
	}
	
	return;
}
add_action( 'template_redirect', 'mailform_essence_none_cache_hook_wrap');


function essence_mailform_get_post(){
	
	$mail_form_essence_opt = get_option('mail_form_essence_options');

	if( !empty($_GET) && is_singular() ){
		
		$args = array(
			'post_type' => 'es_mailform',
			'post_per_page' => -1
		);
		$posts = get_posts($args);
		
		foreach( $posts as $post ){
			$form_id = $post->ID;

			
			$_essence_mailform = get_post_meta( $form_id , 'essence_mailform',true );
			if(is_user_logged_in()){
				//echo '<pre>_essence_mailform'; print_r($_essence_mailform); echo '</pre>';
			}
			
			foreach( $_essence_mailform as $key => $value ){
				if( empty($value['field']) ) continue;
				
				$_field = 'es_mail_' . $value['field'];
				if( $value['type'] !== 'param' ) continue;
				
				$_fields[$value['field']]['name'] = $value['name'];
				$_fields[$value['field']]['type'] = $value['type'];
			}

			if(is_user_logged_in()){
				//echo '<pre>_fields'; print_r($_fields); echo '</pre>';
			}
			
			if( empty($_fields) ) continue;

			foreach( $_GET as $key => $value ){

				if( !empty($_fields[$key]['type']) && $_fields[$key]['type'] = 'param' ){
					setcookie($key, $value, time()+60*60*24*30);
				}
			}
		}
		
	}
	
	//echo '<pre>cookie'; print_r($_COOKIE); echo '</pre>';
	

	if( !empty($_POST['nonce_essence_mailform']) && wp_verify_nonce($_POST['nonce_essence_mailform'], 'add_essence_mailfrom_post')){
		
		global $form_id;
		global $post_fields;
		global $send_fields;
		global $_fields;
		global $insert_id;
		global $spam_html;
		
		global $_essence_mailform_setting;
		
		$post_fields = $_POST;


		//echo '<pre>_POST'; print_r($_POST); echo '</pre>';

		
		$form_id = $_POST['form_id'];
		$_essence_mailform_setting = get_post_meta( $form_id , 'essence_mailform_setting',true );


		// ===================================
		// 送信処理
		// ===================================
		//  ポストされたワンタイムチケットを取得する。
		$ticket = isset($_POST['ticket'])    ? $_POST['ticket']    : '';

		//  セッション変数に保存されたワンタイムチケットを取得する。
		$save   = isset($_SESSION['ticket']) ? $_SESSION['ticket'] : '';

		//  セッション変数を解放し、ブラウザの戻るボタンで戻った場合に備え
		//  る。
		unset($_SESSION['ticket']);

		if ($ticket === '') {
				die('不正なアクセスです');
		}
		
		// ================================
    // 禁止ワードリスト
    $spam_word_list = array(
      'POWERFUL and PRIVATE',
      'products',
      'free trial',
      'Unsubscribe',
      'Rebecca Sutton',
      'ブランド時計',
      '激安'
    );
		
		//オプションの禁止ワードを追加
    $span_word_option = !empty($mail_form_essence_opt['spam_list']) ? $mail_form_essence_opt['spam_list'] : null ;
    if( !empty($span_word_option) ){
      $span_word_option = explode("\n", $span_word_option); // 行に分割
      $span_word_option = array_map('trim', $span_word_option); // 各行にtrim()をかける
      $span_word_option = array_filter($span_word_option, 'strlen'); // 文字数が0の行を取り除く
      $span_word_option = array_values($span_word_option); // これはキーを連番に振りなおす
      $spam_word_list = array_merge($spam_word_list,$span_word_option);
    }

    
    //echo '<pre>'; print_r($post_fields); echo '</pre>';
    
    // ================================
    // スパムフィルタ共通テキスト
    $spam_html = '<div class="alert_block-attention"">
        <p>
          プログラムから送信されている可能性を検出したため、送信は行われていません。<br>
          お手数ですが、もう一度やり直してください。
        </p>
      </div>
      <p>
        <a class="btn btn-primary" href="'.get_the_permalink().'">お問い合わせフォームに戻る<a>
      </p>';
    
    
    // ================================
    // 送信が1秒以内に行われた場合
    $_send_time = date('Y-m-d H:i:s');
    $diff_hour = (strtotime($_send_time) - strtotime($_POST['post_date']));
    if( $diff_hour < 1 ){
			function mailform_essence_spam_filter($content){
				global $spam_html;
				
				echo $diff_hour .'秒で送信が行われました。';
				echo $spam_html;
				session_destroy();
				return;
			}
			add_filter('the_content','mailform_essence_spam_filter');
      
    };
    
		
		
		
		// ================================
		// 登録用フィールド
		unset($post_fields['nonce_essence_mailform']);
		unset($post_fields['_wp_http_referer']);
		unset($post_fields['post_microtime']);
		unset($post_fields['insert_user']);
		unset($post_fields['thread']);
		unset($post_fields['file_label']);
		unset($post_fields['btn_submit']);
		
		$post_fields['send_count'] = $diff_hour;
		$_essence_mailform = get_post_meta( $form_id , 'essence_mailform',true );

		
		foreach( $_essence_mailform as $key => $value ){
			$_field = 'es_mail_' . $value['field'];
			
			$_fields[$value['field']]['name'] = $value['name'];
			$_fields[$value['field']]['type'] = $value['type'];
			$_fields[$value['field']]['value'] = !empty($post_fields[$_field]) ? $post_fields[$_field] : '' ;
			
			
		}
		
		
		

		
		
		// ================================
		// 送信テスト用フィールド
		$post_check = $post_fields;
		unset($post_check['post_date']);
		unset($post_check['ticket']);
		unset($post_check['post_id']);
		unset($post_check['btn_submit']);

    // ===================================
    // 送信が空ではないかのチェック
    // 送信ラベルに??が含まれている場合
    $_post_fields_count = 0;
    foreach($post_check as $label => $value){
      if( $value !== '') ++ $_post_fields_count ;
      
      //??がラベルに含まれる
      if(strpos($label,'??') !== false){ return; }; 
      
      //禁止ワードが本文に含まれる
      foreach ($spam_word_list as $word){
          if ( !is_array($value) && strpos($value, $word) !== false){
              return false;// NGワードに該当
          }
      };
      
    };
    if( $_post_fields_count === 0 ){
			function mailform_essence_no_field($content){
				echo '
				<div class="alert_block-attention"">
					<p>
						入力された項目が見つからなかったため、送信は行われていません。<br>
						お手数ですが、もう一度やり直してください。
					</p>
				</div>
				<p>
					<a class="btn btn-primary" href="'.get_the_permalink().'">お問い合わせフォームに戻る<a>
				</p>';
				session_destroy();
				return;
			}
			add_filter('the_content','mailform_essence_no_field');
      
    };

		if ($ticket === $save) {
			

			//echo 'Normal Access';
			//コンタクトに挿入 =================================
			require_once( MAILFORM_ESSENCE_PLUGIN_PATH . '/inc/insert/insert_mailform_contact.php');
			
			
			//echo '<pre>_fields'; print_r($_fields['image']['value']); echo '</pre>';
			//echo '<pre>_FILES'; print_r($_FILES); echo '</pre>';

			//画像ファイルがある場合の処理
			if( !empty($_FILES) ){
				//echo 'ファイルがありました';
				global $file_item;
				global $attachments;
				$attachments = array();
				foreach($_FILES as $file_item){
					require( MAILFORM_ESSENCE_PLUGIN_PATH . '/inc/upload_file_hook.php');
				}

			}
			
			
			


			//ユーザー登録処理 =================================
			if( !empty ($_essence_mailform_setting['insert_user']) && $_essence_mailform_setting['insert_user'] === true ){
				//ユーザーを追加するアクション
				require_once( MAILFORM_ESSENCE_PLUGIN_PATH . '/inc/insert/insert_user_hook.php');
			}
			
			
			
			$send_fields = $post_fields;
			unset($send_fields['post_id']);
			unset($send_fields['form_id']);
			unset($send_fields['post_date']);
			unset($send_fields['ticket']);
			unset($send_fields['send_count']);
			
			
			//確認メール送信処理 =================================
			if( !empty ($_essence_mailform_setting['send_confirm']) ){
				//echo '確認メールを送信しました';
				require_once( MAILFORM_ESSENCE_PLUGIN_PATH . '/inc/sender/send_confirm_mail.php');
			}else{
				echo $_essence_mailform_setting['send_confirm'];
				//echo '確認メールは送られていません';
			}

			//管理者側メール送信処理 =================================
			require_once( MAILFORM_ESSENCE_PLUGIN_PATH . '/inc/sender/send_admin_mail.php');
			
			
			function mailform_essence_thanks_block($content){
				global $form_id;
				global $thanks_block;
				
				ob_start(); // バッファリング開始
				require_once( MAILFORM_ESSENCE_PLUGIN_PATH . '/template-parts/module/thanks-block.php');
				$thanks_block = ob_get_contents(); // バッファリング取得
				ob_end_clean(); // バッファリング終了
				
				echo '送信完了';
				return $thanks_block;
			}
			add_filter('the_content','mailform_essence_thanks_block');

      
    }
    else {
			//echo 'Dual Posted..';
			function mailform_essence_already_send($content){
				echo 'すでに送信済みです。ありがとうございました';
				return;
			}
			add_filter('the_content','mailform_essence_already_send');
			
			$_POST = array();
			session_destroy();
			header("Location: {$_SERVER['REQUEST_URI']}#posted"); //二重投稿防止
    }

    //echo 'send_confirm' . $_essence_mailform_setting['send_confirm'];
    //サンクスページ
		
		



  }elseif( !empty($_POST['nonce_essence_mailform']) ){
		function mailform_essence_nonce_error($content){
			global $_essence_mailform_setting;
			//管理者メール
			$_admin_mail = !empty( $_essence_mailform_setting['admin_mail'] )   ? $_essence_mailform_setting['admin_mail']    : get_option( 'admin_email' ) ;
			
echo <<< EOM
<h1 class="heading">error</h1>
<p>大変申し訳ありません。送信できませんでした。</p>
<p>恐れ入りますが、<a href="{$_admin_mail}">{$_admin_mail}</a>　まで、ご連絡いただきますよう、お願いいたします。</p>
<p>お手数をおかけし、申し訳ありません。</p>
EOM;
			return;
		}
		add_filter('the_content','mailform_essence_nonce_error');
		
	}else{
		return;
  }
	
	
}
add_action('template_redirect', 'essence_mailform_get_post');


?>