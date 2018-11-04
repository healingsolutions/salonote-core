<?php


	global $post;
	global $wpdb;
	
	if( !is_user_logged_in()){
		return;
	}
	$current_user = wp_get_current_user();	
	$table_name = $wpdb->prefix . 'event_manager_essence';
	$results = $wpdb->get_results("
		SELECT rsv_timetable
		FROM {$table_name}
		WHERE user_id = {$current_user->ID}
		LIMIT 500
	");
	
	$event_timetable_labels = get_post_meta($post->ID, 'essence_event_timetable_label',true);
	$event_timetable_fields = get_post_meta($post->ID, 'essence_event_timetable_value',true);

	$schedule_labels_arr = explode(",", $event_timetable_labels);
	foreach($schedule_labels_arr as $key => $value){
		$event_field_arr[] = $value;
	}

	if( empty($event_timetable_labels) && empty($event_timetable_fields) ){
		 return;
	}

	if( !empty($results) ){
		echo '<h2>あなたのご予約</h2>';
	}
	

	//result
	echo '<div class="side_list" style="margin-bottom:50px;">';
	echo '<ul class="list-bordered">';
	foreach( $results as $key => $value ){
		echo '<li>';
		foreach($value as $sub_key => $sub_value){
				$_timetable = explode('-',$sub_value);
			
				$_time_key = $_timetable[1] - 1;
			
				$_date = $event_timetable_fields[$_timetable[0]]['date'];
				echo date('Y年m月d日', strtotime($_date)). event_manager_weekday_japanese_convert($_date);
			
				if( !empty($event_field_arr[$_time_key]) ){
					echo ' 【'.$event_field_arr[$_time_key].'】';
				}
			
				$event_count =	intval((strtotime($_date) - strtotime(date('Y/m/d'))) / (60*60*24));
				if( date('Ymd',strtotime($_date))  <  (date('Ymd')) ) {
					$print_event = '<div class="event-status-block btn btn-success event_end inline-block">終了</div>';
				} else if (date('Ymd') == date("Ymd", strtotime($_date)) ){
					$print_event =  '<div class="event-status-block btn btn-danger event_today inline-block">本日</div>';
				} else if (date("Ymd", strtotime($_date))   >  (date('Ymd'))  ){
					$print_event =  '<div class="event-status-block btn btn-warning event_counter inline-block">あと'. $event_count .'日</div>';
				}
			
				echo $print_event;
			
		}
		echo '</li>';
	}
	echo '</ul>';
	echo '</div>';

?>