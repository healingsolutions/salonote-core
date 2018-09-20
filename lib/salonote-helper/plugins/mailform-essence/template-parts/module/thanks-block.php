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
	//exit; // Exit if accessed directly.
}

global $post;
global $post_fields;
global $_fields;
global $form_id;
global $insert_id;
global $thanks_text;

$thanks_text_arr = get_post_meta($form_id, 'essence_mailform_thanks', true);


//echo '<pre>_fields'; print_r($_fields); echo '</pre>';

$thanks_fields = $post_fields;
unset($thanks_fields['post_id']);
unset($thanks_fields['form_id']);
unset($thanks_fields['post_date']);
unset($thanks_fields['ticket']);
unset($thanks_fields['send_count']);


if( empty($thanks_text_arr['thanks']) ){
  return;
}
$thanks_text = $thanks_text_arr['thanks'];


//echo '<pre>thanks_fields'; print_r($thanks_fields); echo '</pre>';

foreach( $thanks_fields as $field_label => $field_item ){

	$_field = str_replace('es_mail_', '', $field_label);
	if( $_fields[$_field]['type'] === 'file' ) continue;

	if( is_array($field_item) ){
		$sub_field_text = '';
		foreach( $field_item as $sub_label => $sub_field_item ){
			if( !empty($sub_field_item) ){
				$sub_field_text .= $sub_label.':'.$sub_field_item. PHP_EOL;
			}
		}
		$field_item = $sub_field_text;
	}

	$target = '%%'.$_fields[$_field]['name'].'%%';
	$thanks_text = str_replace($target, $field_item, $thanks_text);

}

$thanks_text = preg_replace('/%%(.+?)%%/', '', $thanks_text);

if( !empty($_FILES) ){
	//投稿から画像リストを取得
	$image_args = array(
		'post_type'   => 'attachment',
		'numberposts' => -1,
		//'post_status' => null,
		'post_parent' => $insert_id
	);
	$attachments = get_posts( $image_args );
	if ( $attachments ) {
		$thanks_text .= '<div class="es_contact-attachment-block" style="margin-bottom:50px;">';
		$thanks_text .= '<div class="heading">送信画像</div>';
		foreach ( $attachments as $attachment ) {
			$image_src = wp_get_attachment_image_src( $attachment->ID , 'large' );
			if($image_src[0]){
				$thanks_text .=  '<a class="colorbox" href="'. $image_src[0] . '" target="_blank"><div class="thumbnail-block thumbnail">';
				$thanks_text .=  wp_get_attachment_image( $attachment->ID, 'thumbnail', false );
				$thanks_text .=  '</div></a>';
			}
		}
		$thanks_text .=  '</div>';
	}
}

$thanks_block = $thanks_text;
?>
<div id="mailform-essence-thanks-block" onLoad="ga('send', 'event', 'form', 'thanks', 'essence-mailform-pro id=<?php echo $form_id;?>', null);">
<h1>お問い合わせありがとうございます</h1>

<p>
  <?php
  echo nl2br($thanks_text);
  ?>
</p>


<section>
<h3 class="heading">Yahooメール・Gmail・Hotmailをご利用の方</h3>
<p>また、Ｙａｈｏｏなどのフリーメールを使用している場合は、サーバーの『迷惑メールフォルダ』に自動的に振り分けられている可能性がありますので、お手数ですが一度ご確認をお願いいたします。</p>
</section>

<section>
<h3 class="heading">携帯電話・スマートフォンをご利用の方</h3>
<p>携帯電話・スマートフォンのメールアドレスをご入力された方は、<span class="attention">携帯会社のサーバー</span>でメールが拒否されている場合が多々あります。
<span class="attention">必ず携帯会社の設定をご確認下さい。</span></p>
</section>

<?php
$_mailform_setting = get_post_meta($form_id, 'essence_mailform_setting', true);
if( !empty( $_mailform_setting['thread'] )):
?>
<section>
<h3 class="heading">会員様はこちらからもお問い合せをご確認いただけます</h3>
<p><a href="<?php echo get_the_permalink($insert_id); ?>">このお問い合わせチケットの確認URL</a></p>
<div class="essence-mailform-contact-qrcode">
  <img src="//api.qrserver.com/v1/create-qr-code/?data=<?php echo get_the_permalink($insert_id); ?>&size=120x120" alt="QRコード" />
</div>
</section>
<?php
endif;
?>

</div>