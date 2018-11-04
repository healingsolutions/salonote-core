<?php

global $id;

if( empty($id) ) return;




$event_opt = get_option('event_manager_essence_options');
$event_opt['baby_price']  = isset($event_opt['baby_price'])  ? $event_opt['baby_price'] : 0;  
$event_opt['child_price'] = isset($event_opt['child_price']) ? $event_opt['child_price']: 500;

//post meta
$event_member_arr = get_post_meta($id,'essence_event_manager',true); //参加者リスト
$event_price_arr  = get_post_meta($id,'essence_event_price',true); //経費リスト
$pay_per_member = get_post_meta($id, 'pay_per_member', true); //一人当たりの支払金額


if( empty($event_member_arr) )return;

echo '<div class="event_manager_unit">';
do_action('before_print_event_manager');

//if ( current_user_can( 'administrator' ) ) {
if ( current_user_can( 'edit_posts' ) ) {
	echo '
	<div class="only_login_member">
	<div class="alert_block-attention">
	以下は、権限を持つログインユーザーのみ表示されます
	</div>';

	echo '<link rel="stylesheet" id="essence-css" href="'. EVENT_MANAGER_ESSENCE_PLUGIN_URI . '/statics/css/public_style.css' .'">';


	echo '<div class="event_manager_block event_member_block">';
	echo '<h1>参加者リスト</h1>';

	$discount_price = [];
	$discount_arr = array(
		'未就学児' => $event_opt['baby_price'],
		'お子様'	 	=> $event_opt['child_price'],
		'ゲスト' 	=> 0,
		'ノーカウント' => 0,
		'功労者' 	=> 1000,
		'ショート滞在' 	=> 2000,
	);
	$return_price = []; //還元報酬


	foreach( $event_member_arr as $key => $item ){

		if( !empty($item['member_tag']) ){
			
			if( !empty($item['member_price']) ){
				 $discount_price[] = $item['member_price'];
			}else{
				 $discount_price[] = $discount_arr[$item['member_tag']];
			}
		}


		if($item['member_return']){
			$return_price[] = $item['member_return'];
		}




		echo '<dl class="events_block_'.$key.'">';

		foreach( $item as $field => $value ){

			if( empty($value) ) continue;

			//echo '<pre>field'; print_r($field); echo '</pre>';
			//echo '<pre>$field_set'; print_r($field_set); echo '</pre>';

			if( !empty($field_set[$field]['type']) && $field_set[$field]['type'] == 'upload' ){
				echo '<dd class="'.$field.'">';
				echo wp_get_attachment_image( $value, $field_set[$field]['size'] );
				echo '</dd>';
			}else{


				if( !empty($field_set[$field]['display']) && $field_set[$field]['display'] !== 'false' ){
					echo '<dt class="'.$field.'">';
					echo !empty($field_set[$field]['label']) ? esc_html($field_set[$field]['label']) : '' ;
					echo '</dt>';
				}

				echo '<dd class="'.$field.'">';
				echo !empty($value) ? esc_html($value) : '' ;
				//echo '<pre>fields'; print_r($value); echo '</pre>';
				echo '</dd>';
			}
		}

		echo '</dl>';
	}
	echo '</div>';

	// ==========================================

	
	if( empty($event_price_arr) ) return;

	echo '<div class="event_manager_block event_price_block">';
	echo '<h1>かかった費用（経費）</h1>';

	$price_result = 0; //最終料金


	foreach( $event_price_arr as $key => $item ){
		echo '<dl class="events_block_'.$key.'">';

		$price_result += $item['price_number'] * (!empty($item['price_times']) ? $item['price_times'] : 1) ;

		foreach( $item as $field => $value ){

			if( empty($value) ) continue;

			//echo '<pre>field'; print_r($field); echo '</pre>';
			//echo '<pre>$field_set'; print_r($field_set); echo '</pre>';

				if( !empty($field_set[$field]['display']) && $field_set[$field]['display'] !== 'false' ){
					echo '<dt class="'.$field.'">';
					echo !empty($field_set[$field]['label']) ? esc_html($field_set[$field]['label']) : '' ;
					echo '</dt>';
				}

			
				
			
				if( $field === 'price_times'){
					if( $item['price_times'] > 1 ){
						echo '<dd class="'.$field.'">';
							echo ' × ';
							echo !empty($value) ? esc_html($value) : '' ;
							echo ' = '. $item['price_number'] * (!empty($item['price_times']) ? $item['price_times'] : 1);
						echo '</dd>';
					};
				}else{
					echo '<dd class="'.$field.'">';
						echo !empty($value) ? esc_html($value) : '' ;
					echo '</dd>';
				}
			
				//echo '<pre>fields'; print_r($value); echo '</pre>';			
		}

		echo '</dl>';
	}
	echo '</div>';

	echo '<p>合計金額: <span>'.$price_result.'円</span></p>';



	$discount_count_reslut = count($discount_price); //割引対象の人数を集計
	$discount_price_reslut = array_sum($discount_price);//割引対象の支払額を集計

	//均等割人数
	$event_member_count 			= count($event_member_arr) - $discount_count_reslut;
	$calculated_price_result  = $price_result - $discount_price_reslut;

	//一人当たりの支払額
	$price_per_member = ceil($calculated_price_result/$event_member_count);


	echo '<p>割引対象人数: <span>'.count($event_member_arr).'人</span>のうち、<span>'.$discount_count_reslut.'人</span>は割引対象なので、<span>'.$event_member_count.'人</span>で分割</p>';
	echo '<p>割引した後の合計: <span>'.$price_result.' - '.$discount_price_reslut.'</span> = <span>'.$calculated_price_result.'</span>円</p>';
	echo '<p>一人当たりの費用: <span>'.$calculated_price_result.'</span>円を、<span>'.$event_member_count.'人</span>で割ると、<span class="result">'.$price_per_member.'</span>円（切上げ）</p>';



	//一人当たりの支払金額
	echo '<ul class="events_reslut_block">';
	echo '<li>一人当たりの集金金額：<span>'. $pay_per_member.'</span>円</li>';

	//お支払済
	$paid_price = [];
	foreach( $event_member_arr as $key => $item ){
		if( !empty($item['member_paid']) ){


			if( !empty($item['member_tag']) ){
				if( !empty($item['member_price']) ){
					 $paid_price[] = $item['member_price'];
				}else{
					 $paid_price[] = $discount_arr[$item['member_tag']];
				}
			}else{
				$paid_price[] = $pay_per_member;
			}

		}
	}


	if(is_user_logged_in()){
		//echo '<pre>'; print_r($paid_price); echo '</pre>';
	}

	echo '<li>集金済み額: <span>'.array_sum($paid_price).'</span>円</li>';

	echo '<li>還元済み金額: <span>'.array_sum($return_price).'</span>円</li>';

	if( (array_sum($paid_price) - $price_result - array_sum($return_price)) < 0 ){
		$result_minus = ' minus';
	}else{
		$result_minus = '';
	}
	echo '<li class="'.$result_minus.'">トータル余剰金'.(array_sum($paid_price) - $price_result - array_sum($return_price) ).'円</li>';

	echo '</ul>';



	echo '
	</div>

	<div class="alert_block-attention">
	ここからは、どなたでも表示されます
	</div>';


	};// is_login


//上記のデータを使って、以下は誰でも閲覧可能です
echo '<dl>';
echo '<dt>参加者</dt><dd><span>'. count($event_member_arr).'人</span></dd>';
echo '</dl>';

echo '<dl>';
echo '<dt>参加費</dt><dd><span>'. $pay_per_member.'円</span></dd>';
echo '</dl>';

echo '</div>';
do_action('after_print_event_manager');
?>