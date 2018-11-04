<?php
global $post;
global $_place;

$event_information_fields = get_post_meta($post->ID, 'essence_event_information',true);

if( empty($event_information_fields) ) return;

$event_info_label = array(
	'event_start' => '開始時間',
	'event_end' 	=> '終了時間',
	'event_price' => '参加料金',
	'event_place' => '開催場所',
	'event_join'  => '参加方法',
	'event_owner' => '主催者',
	'event_url' 	=> 'URL',
	'event_map' 	=> '地図',
	
	'event_target'=> '対象となる人',
	'event_gain'	=> '得られるもの'
);


echo '<div class="events-information-block">';

echo '
<dl>
<dt>開催日</dt>
<dd>'.get_the_date('Y年m月d日').'</dd>
</dl>
';


foreach( $event_information_fields as $key => $value ){
	
	if( empty($value) ) continue;
	echo '<dl>';
		echo '<dt>'.$event_info_label[$key].'</dt>';

		if( $key == 'event_map' ){
			if(strpos($value,'<iframe') !== false){
				echo '<dd class="'.$key.'">'.$value.'</dd>';
			}else{
				echo '<dd class="'.$key.'">';
				echo '<a class="colorbox" href="'.$value.'" rel="iframe">MAP</a>';
				echo '</dd>';
			}
			
		}elseif( $key == 'event_target' || $key == 'event_gain' ){
			
			$value_arr = explode("\n", $value); // とりあえず行に分割
			$value_arr = array_map('trim', $value_arr); // 各行にtrim()をかける
			$value_arr = array_filter($value_arr, 'strlen'); // 文字数が0の行を取り除く
			$value_arr = array_values($value_arr); // これはキーを連番に振りなおしてるだけ
			
			echo '<dd class="'.$key.'"><ul class="list-icon">';
			foreach( $value_arr as $list_key => $list_value ){
				echo '<li>'.$list_value.'</li>';
			}
			echo '</ul></dd>';
			
		}elseif( $key !== 'event_url' ){
			echo '<dd class="'.$key.'">'.$value.'</dd>';

		}else{
			if( $_place !== 'is_excerpt' ){
				echo '<dd><a href="'.$value.'" target="_blank">'.$value.'</a></dd>';
			}else{
				echo '<dd class="'.$key.'">'.$value.'</dd>';
			}
			
		}
	echo '</dl>';
}

echo '</div>';
?>

<style>
	.events-information-block{
		display: block;
		clear: both;
		margin: 25px 0;
	}
	.events-information-block dl{
		border-bottom: 1px dotted #D3D3D3;
	}
	
	.events-information-block dl dt{
		display: inline-block;
		margin-right: 15px;
		font-weight: 700;
		width: 100px;
	}
	
	.events-information-block dl dd{
		display: inline-block;
	}

</style>