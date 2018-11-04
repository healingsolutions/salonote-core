<?php

global $wp_query;
global $post_type;
global $post_type_name;
global $post_type_set;
global $post_taxonomies;
$post_type_name = !empty($post_type_name) ? $post_type_name : 'post';

$calendar_type_set = [];
date_default_timezone_set('Asia/Tokyo');


foreach( $post_type_set as $set_key => $set_value ){
	if(
		$set_value !== 'display_grid_title' &&
		$set_value !== 'display_post_date'
	)
		$calendar_type_set[$set_key] = $set_value;
}
$post_type_set = $calendar_type_set;
remove_filter('get_the_excerpt','event_manager_excerpt_hook');

$event_query = new WP_Query($wp_query);


if( !is_date() && is_archive() ){
	//echo 'is_index';
	
	$last_args = array(
		'post_type' 			=> $post_type,
		'post_status' 		=> 'publish',
		'posts_per_page' 	=> 1,
		'order'          	=> 'DESC',
	);
	$latest_posts = get_posts( $last_args );
	
	$current_y = get_the_date('Y',$latest_posts[0]->ID );
	$current_m = get_the_date('m',$latest_posts[0]->ID );
	$current_d = get_the_date('d'.$latest_posts[0]->ID );
		
}elseif( is_date() && is_archive() ){
	//echo 'id_archive';
	$current_y = get_query_var('year');
	$current_m = zeroise(get_query_var('monthnum'),2);
	$current_d = get_query_var('day');
}else{
	$last_args = array(
		'post_type' 			=> $post_type,
		'post_status' 		=> 'publish',
		'posts_per_page' 	=> 1,
		'order'          	=> 'DESC',
	);
	$latest_posts = get_posts( $last_args );
	
	$current_y = get_the_date('Y',$latest_posts[0]->ID );
	$current_m = get_the_date('m',$latest_posts[0]->ID );
	$current_d = get_the_date('d'.$latest_posts[0]->ID );
}


$today_flag = date_i18n('Y-m-d');

// ショートコードで年月が指定していなければ、現在の年月を設定
$calendar_ym = $current_y . '-' . $current_m;
$calendar_t = date_i18n('t', strtotime($calendar_ym.'-01'));


$events = array();

if( is_archive() || is_home() ){
	
	//echo 'is_archive';
	
	if(have_posts()):
	while (have_posts()) : the_post();
		$event_date = esc_html( get_the_date('Y-m-d') );
		$events[$event_date][] = $post;
	endwhile;
	endif;
	
}else{
	
	//echo 'is_else';

	$sql = $wpdb->prepare("
		SELECT *
		FROM $wpdb->posts
		WHERE post_date > '%s'
		AND MONTH( post_date ) = MONTH( '%s' )
		AND post_type = '$post_type' AND post_status = 'publish'
				ORDER   BY post_date ASC
				LIMIT 100",array( $calendar_ym.'-01',$calendar_ym.'-01'));
	$events_posts = $wpdb->get_results($sql);

	foreach( $events_posts as $post ){
		$event_date = esc_html( get_the_date('Y-m-d') );
		$events[$event_date][] = $post;
	}
	
	$obj = !empty($post_type) ? get_post_type_object($post_type) :  get_post_type_object('post') ;
	echo '<div class="archive-page-title-block type-calendar-type-group navbar-block">';

		echo '<div class="entry-block-title-wrap label-block calendar-type-group-title">';
		echo '<p class="entry_block_title nav_font"'. ((mb_strlen(esc_html( $obj->name )) > 6 ) ? ' style="font-size:1em;"' : '' ).'>'.strtoupper(str_replace('_',' ',esc_html( $obj->name ))).'</p>';
		echo '<p class="entry_block_sub_title body_font">'.esc_html( $obj->label ).'</p>';
		echo '</div>';
	
		echo '<div class="entry_block_taxonomy_label">';
		echo '<h1 class="month_lable">'.$current_y.'年'.$current_m.'月'.'</h1>';
		echo '</div>';
	
	echo '</div>';
	
}


// カレンダー表示 ?>


<div class="calendar-container">
<div class="calendar-block">
<table class="calendar table">
	
	<thead>
	<tr>
					<th class="w0">日</th>
					<th class="w1">月</th>
					<th class="w2">火</th>
					<th class="w3">水</th>
					<th class="w4">木</th>
					<th class="w5">金</th>
					<th class="w6">土</th>
	</tr>
	</thead>
	
	<tbody>
	<tr>
	<?php
	$index = 0;
	for ( $i = 1; $i <= $calendar_t; $i++ ){
		
		$calendar_day = date_i18n('w', strtotime($calendar_ym . '-' . $i));
		$calendar_date = ( $i < 10 ) ? '0' . $i : $i;
		$calendar_class = [];

		// 1日が日曜日ではない場合の空白セル
		if ( $i == 1 && $calendar_day != 0 ){
			for ( $index = 0; $index < $calendar_day; $index++ ){
			?>
			<td class="<?php echo 'w' . $index ?>"> </td>
			<?php
			};
		};

		// 祝日かどうか
		$hol = '';


		$calendar_class[] = 'w' . $calendar_day;
		$calendar_class[] = $hol;
		if( $calendar_ym.'-'.$calendar_date === $today_flag ) $calendar_class[] = 'is_today';
		if ( !empty($events[$calendar_ym.'-'.$calendar_date]) && count( $events[$calendar_ym.'-'.$calendar_date] ) > 0 ) $calendar_class[] = 'has_calendar_item';
		
		
		if (date('Y-m-d') > date('Y-m-d', strtotime($calendar_ym.'-'.$calendar_date)) ) $calendar_class[] = 'is_old_item';


		// 日付表示 ?>
		<td class="<?php echo implode(' ',$calendar_class); ?>"><span class="date"><?php echo $i ?></span><?

		if ( !empty($events[$calendar_ym.'-'.$calendar_date]) && count( $events[$calendar_ym.'-'.$calendar_date] ) > 0 ) {

			foreach ( $events[$calendar_ym . '-' .  $calendar_date] as $post ) {

				echo '<div class="calender_item headline_bkg">';
				echo '<a href="'.get_post_permalink($post->ID).'">';
				
					echo get_the_title($post->ID);

					$default_attr = array(
						'class' => "img-circled img-responsive",	// 指定した大きさ
						'alt'   => trim( strip_tags( $post->post_excerpt ) ),	// アイキャッチ画像の抜粋
						'title' => trim( strip_tags( $post->post_title ) ),	// アイキャッチ画像のタイトル
					);

					echo '<div class="calenter_item-thumbnail">';
					//echo get_the_post_thumbnail($post->ID , 'thumbnail', $default_attr);

					get_template_part( 'template-parts/module/list-part-inner' );
				
				if(
					!is_tax() &&
					!empty( $post_type_set ) &&
					in_array('display_list_term',$post_type_set)
				){
					echo '<div class="list-taxonomy-block">';
					foreach($post_taxonomies as $tax_item){
						echo get_the_term_list($post->ID ,$tax_item, '<span>', '</span><span>', '</span>');
					}
					echo '</div>';
				}
				
					echo '</div>';

				echo '</a>';

				echo '</div>';
			}
		}else{
			echo '<div class="calender_item_blank"></div>';
		}
			
			
		?></td>
		<?php

		// 土曜日なら行末
		if ( $calendar_day == 6 ){ ?>
			</tr>
			<tr>
			<?php
		};

		$index++;

		// 最終日の後の空白
		if ( $i == $calendar_t && $index < 42 ){
			for ( $index; $index < 42; $index++ ){
				if ( $calendar_day == 6 ) {
					$calendar_day = 0; ?>
					</tr>
					<tr>
					<?php
				} elseif ( $calendar_day < 6 ) {
					$calendar_day++;
				} ?>
				<td class="<?php echo implode($calendar_class); ?>"> </td>
				<?php
			};
		};
		
	};
	?>
	</tr>
		
	</tbody>
</table>



	
	
<?php
echo get_monthly_nav($calendar_ym.'-01', $post_type_name);
$post_type_path = ($post_type !== 'post') ? $post_type .'/date' : 'date' ;
	
$year_args = array(
	'period'		=> 'yearly',
	'post_type'	=> $post_type_name
);
$year_arr = get_archives_array($year_args);

if($year_arr){
	echo '<div class="archive_list_block row">';
	foreach($year_arr as $years){

		$month_args = array(
			'period'		=> 'monthly',
			'year'			=> $years->year,
			'post_type'	=> $post_type_name
		);
		$month_arr = array_reverse(get_archives_array($month_args));
		
		$month_list_arr = [];
		
		foreach( $month_arr as $month_key => $month_item ){
			$month_list_arr[ $month_item->year.zeroise($month_item->month,2)] = $month_item->posts;
		}

		
		if($month_arr){
			echo '<ul class="col-12 col-lg-6"><li>'.$years->year.'<ul>';
			
			for ($month_num = 1; $month_num <= 12; $month_num++){
				
				echo '<li class="inline-block">';

				if( !empty($month_list_arr[$years->year.zeroise($month_num,2)]) && $month_list_arr[$years->year.zeroise($month_num,2)] > 0 ){
					echo '<a class="icon-color';
					
					if( $calendar_ym === $years->year.'-'.zeroise($month_num,2) ) echo ' is_show_month';
					
					
					echo '" href="'.str_replace('date',$post_type_path ,get_month_link($years->year,zeroise($month_num,2))).'">'.$month_num;
					
					echo '<div class="calender_item_count">'. $month_list_arr[$years->year.zeroise($month_num,2)] .'件</div>';
					
					echo '</a>';
				}else{
					echo $month_num;
				}
				
				
				echo '</li>';
			}

			echo '</ul></li></ul>';
		}

	};
	echo '</div>';
};

?>
	
	<div class="ring-left"></div>
	<div class="ring-right"></div>
</div>
	
	
	<?php
	wp_reset_query();
	?>