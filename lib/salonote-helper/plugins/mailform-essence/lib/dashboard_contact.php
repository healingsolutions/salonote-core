<?php


add_action('wp_dashboard_setup', 'mailform_essence_dashboard_widgets');
function mailform_essence_dashboard_widgets() {
	wp_add_dashboard_widget('mailform_essence_dashboard_options_widget', 'コンタクト', 'mailform_essence_dashboard_widget_function');
}
function mailform_essence_dashboard_widget_function() {
	
	$defalut_time = date_default_timezone_get();
	$original_timezone = !empty( $defalut_time ) ? $defalut_time : 'Asia/Tokyo' ;
	date_default_timezone_set( $original_timezone );
	

	$args = array(
		'post_type'   => 'es_contact',
		'numberposts' => 3,
	);
	
	$posts = get_posts($args);
	
	foreach( $posts as $post ){
	
	
		$post_fields = get_post_meta($post->ID, 'post_fields',true);

		if( is_array( $post_fields ) ){

			unset($post_fields['btn_submit']);
			unset($post_fields['file_label']);

			echo '<dl class="mailform-essence-list">';
			foreach( $post_fields as $label => $value ){
				
				

				if( empty( $value['value']) || $label === 'send_count' ) continue;

				if( is_array($value['value']) ){
					echo '<dt>'.esc_attr($value['name']).'</dt><dd>';
					foreach( $value['value'] as $sub_label => $sub_field_item ){
						echo esc_attr($sub_field_item) .'<br>';
					}
					echo '</dd>';

				}else{
					echo '
						<dt>'.esc_attr($value['name']).'</dt>
						<dd>'.esc_attr($value['value']).'</dd>
						';
				}
			}

			
			// 日時
			$from = get_the_date('c',$post->ID);
			$to = date('c');

			// 日時からタイムスタンプを作成
			$fromSec = strtotime($from);
			$toSec   = strtotime($to);

			// 秒数の差分を求める
			$differences = $toSec - $fromSec;

			// フォーマットする
			$_result_day = gmdate("j", $differences) - 1;
			
			$result = '';
			if( $_result_day > 0 ){
				$result .= $_result_day .'日と';
			}
			$result .= gmdate("G時間 i分", $differences) ;
			
			echo '<dt>送信日</dt><dd>'.get_the_date('Y-m-d H:i:s',$post->ID). '<span class="mailform-essence-differ">'.$result.'前</span></dd>';
			echo '</dl>';
		}
		
	}

}


?>
