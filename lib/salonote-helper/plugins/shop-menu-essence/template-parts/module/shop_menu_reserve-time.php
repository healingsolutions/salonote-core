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

global $id;

$shop_menu_opt = get_option('shop_menu_essence_options');
$shop_menu_items	= get_post_meta($id,	'essence_shop_menu'	,true);

function diff_date($date1, $date2) {
	// 渡ってきた日付をUNIXタイムスタンプに変換（UNIXタイムスタンプ値でわたってきたら値はそのまま利用）
	// UNIXタイムスタンプが何秒離れているかを計算
	$seconddiff = abs($date2 - $date1);
	// 日数に変換
	$daydiff = $seconddiff / (60 * 60 * 24);
	// 戻り値
	return $daydiff;
}

//曜日の配列
$weekday = array('日', '月', '火', '水', '木', '金', '土');

?>
<fieldset class="form-horizontal" role="form">
<legend class="h2 text-center stitch_headline headline_bkg mb-5">日程のご希望をお聞かせください</legend>

<?php
		
if( !empty($shop_menu_opt['reserve_type']) && count($shop_menu_opt['reserve_type']) > 1 ){
	echo '<div class="text-center">以下の'. count($shop_menu_opt['reserve_type']) .'つの方法からお選び頂けます</div>';

	echo '<div id="reserve_type-btn" class="text-center">';

	if( !empty($shop_menu_opt['reserve_type']) && in_array( 'hearing' , $shop_menu_opt['reserve_type'] ) ){
	echo '<div class="inline-block m-3">
		<div class="btn btn-item btn-lg" rel="reserve_type-hearing">
			希望を伝える<br>
			<span>ご要望をお伝えいただき、<br>当店から最適な日程の候補をご返信いたします</span>
		</div>
		</div>';
	}

	if( !empty($shop_menu_opt['reserve_type']) && in_array( 'recommend' , $shop_menu_opt['reserve_type'] ) ){
	echo '<div class="inline-block m-3">
		<div class="btn btn-item btn-lg" rel="reserve_type-recommend">
			空いている候補から選択する<br>
			<span>確実に空いているオススメの日程から<br>お選びいただけます</span>
		</div>
		</div>';
	}

	if( !empty($shop_menu_opt['reserve_type']) && in_array( 'preferred' , $shop_menu_opt['reserve_type'] ) ){
	echo '<div class="inline-block m-3">
		<div class="btn btn-item btn-lg" rel="reserve_type-preferred">
			第３希望まで伝える<br>
			<span>ご希望日を３つまで<br>お選びいただけます</span>
		</div>
		</div>';
	}

	echo '</div>';
	
}


// hearing
if( !empty($shop_menu_opt['reserve_type']) && in_array( 'hearing' , $shop_menu_opt['reserve_type'] ) ){
	?>

<div id="reserve_type-hearing" class="reserve_type-block mb-5"<?php
	if( count($shop_menu_opt['reserve_type']) === 1 && in_array( 'hearing' , $shop_menu_opt['reserve_type'] ) )
	echo ' style="display: block !important;"';
?>>
	
	<div class="mb-5">
	<p class="h2 heading">ご都合の良い曜日</p>
	<?php
	foreach( $weekday as $key => $value ){
		if( !empty($shop_menu_opt['holiday'][$key]) ) continue;
		
		echo '<label for="hearing-week-'.$key.'" class="inline-block" style="display: inline-block; margin-right: 15px;"><input id="hearing-week-'.$key.'" type="checkbox" name="hearing[week][]" value="'.$value.'" /> '. $value .'</label>';
	}
	?>
	</div>
	
	<div class="mb-5">
	<p class="h2 heading">ご都合の良い時間帯をお聞かせください</p>
	<?php
	if( !empty($shop_menu_opt['hearing_date_time']) ){
		$hearing_date_time = !empty($shop_menu_opt['hearing_date_time']) ? esc_attr($shop_menu_opt['hearing_date_time']) : null;
		$_date_time = br2array($hearing_date_time);
		
	}else{
		$_date_time = array(
			'午前中　早め',
			'午前中　遅め',
			'正午あたり',
			'お昼　少し過ぎ',
			'午後',
			'夕方ごろ',
			'夜　早め',
			'夜　遅め'
		);
	}
	foreach( $_date_time as $key => $value ){
		echo '<label for="hearing-date_time-'.$key.'" class="form-control"><input id="hearing-date_time-'.$key.'" type="checkbox" name="hearing[date_time][]" value="'.$value.'" /> '. $value .'</label>';
	}
	?>
	</div>
	
	
</div>
	

<?php
}//^ hearing


// select
if( !empty($shop_menu_opt['reserve_type']) && in_array( 'recommend' , $shop_menu_opt['reserve_type'] ) ){
	echo '
	<div id="reserve_type-recommend" class="reserve_type-block mb-5"';
	if( count($shop_menu_opt['reserve_type']) === 1 && in_array( 'recommend' , $shop_menu_opt['reserve_type'] ) )
	echo ' style="display: block !important;"';
	echo '>';
	
	echo '<p class="h2 heading">ご予約可能なオススメの時間帯</p>';
	
	$recommend_datetime = !empty($shop_menu_opt['recommend_datetime']) ? $shop_menu_opt['recommend_datetime'] : null ;

	if( !empty($recommend_datetime) ){
		foreach( $recommend_datetime as $key => $value ){
			echo '<label class="form-control" for="recommend_datetime-'.$key.'">';
			echo '<input type="radio" id="recommend_datetime-'.$key.'" name="recommend_datetime" value="'.$key.'">　' .$value['day'].($value['time'] ? ' 【'.$value['time'].'】' : '全日');
			echo '</label>';
		}
	}
	
	echo '</div>';
	
	
}//^ select

// preferred
if( !empty($shop_menu_opt['reserve_type']) && in_array( 'preferred' , $shop_menu_opt['reserve_type'] ) ){
	
	echo '
	<div id="reserve_type-preferred" class="reserve_type-block mb-5"';
	if( count($shop_menu_opt['reserve_type']) === 1 && in_array( 'preferred' , $shop_menu_opt['reserve_type'] ) )
	echo ' style="display: block !important;"';
	echo '>';
	
	echo '<p class="h2 heading">ご希望日</p>';

		$holiday_week = !empty($shop_menu_opt['holiday']) ? $shop_menu_opt['holiday'] : null;
		$_reserve_start = !empty($shop_menu_opt['enable_reserve']['start']) ? $shop_menu_opt['enable_reserve']['start'] : 0 ;
		$_reserve_end = !empty($shop_menu_opt['enable_reserve']['end']) ? '+'.$shop_menu_opt['enable_reserve']['end'].' day' : '+14 day' ;
	
		
		//今日のUNIXタイムスタンプを取得
		$date1 = mktime(0, 0, 0, date('m'), date('d'), date('y'));
		//終了予定日のUNIXタイムスタンプ値を取得（2015年1月27日までの場合）
		$beforedate = strtotime($_reserve_end);

		$days = diff_date($date1, $beforedate);
	
	
		$reserve_times = !empty($shop_menu_opt['reserve_times']) ? esc_attr($shop_menu_opt['reserve_times']) : null;
		if( $reserve_times ){
			$reserve_times_arr = br2array($reserve_times);
		}else{
			$reserve_times_arr = null;
		}

	
	echo '<div class="row">';
		for ($count = 0; $count < 3; $count++){
			echo '
			<div class="col-12 col-md-4 mb-5">
			<div class="preferred-block text-center">
			
			<div class="form-group">
			<label for="reserve_time_'.$count.'" class="control-label h2">第'.($count+1).'希望</label>
			</div>
			
			<div class="form-group">
			<select id="preferred_'.$count.'" class="form-control" name="preferred['.$count.'][date]" />
			<option value="">---</option>
			';

			//$iに、何日後から日付スタートするかを指定する
			for ($i = $_reserve_start; $i < $days; $i++) {
				$date2 = $date1 + (86400 * $i);
				$w = date('w', mktime(0, 0, 0, date('m', $date2), date('d', $date2), date('y', $date2)));
				$v = date('Y', $date2) . '年' . date('n月j日', $date2) . '（' . $weekday[$w] . '）';
				if ( $holiday_week[$w] ) continue;
				echo '<option value="' . $v . '">' . $v . '</option>';
			}
			
			echo '
			</select>
			</div>';
			
			
			if( !empty($reserve_times_arr) ){
				echo '<div class="form-group">';
				foreach( $reserve_times_arr as $key => $value ){
					echo '<label for="reserve_time_'.$count.'-'.$key.'" style="display:inline-block; margin-right: 15px;">';
					echo '<input type="checkbox" id="reserve_time_'.$count.'-'.$key.'" class="" name="preferred['.$count.'][time][]" value="'.$value.'" /> '.$value;
					echo '</label>';
				}
				echo '</div>';
			}

			echo '</div>';
			echo '</div>';
		}
	
	echo '</div>';

	echo '</div>';
}//^ preferred
	
	
	echo '<div class="mb-5">
	<p class="heading">ご予約についてのご希望などをお聞かせください</p>
	<textarea class="form-control" rows="7" name="hearing[reason]" placeholder="例：◯◯時までにサロンを出たい
	例：妊娠〇ヶ月です
	例：子どもが学校から帰ってくる時間よりも前に帰りたい
	例：午後から美容院に行く予約がある"></textarea>
	</div>';


echo '</fieldset>';
?>
