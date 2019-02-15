<?php
/*
Version: 1.0.0
Author:Healing Solutions
Author URI: https://www.healing-solutions.jp/
License: GPL2
*/

/*  Copyright 2018 Healing Solutions (email : info@healing-solutions.jp)
 
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

add_action('wp_dashboard_setup', 'search_engine_essence_dashboard_widgets');
function search_engine_essence_dashboard_widgets() {
	wp_add_dashboard_widget('search_engine_essence_ranking_widget', '検索順位チェック(2週間)', 'search_engine_essence_dashboard_widget_function');
}
function search_engine_essence_dashboard_widget_function() {

global $wpdb;

$search_engine_opt = get_option('search_engine_ad_essence_options');
$search_engine_opt['get_keywords']  		= isset($search_engine_opt['get_keywords'])  			? $search_engine_opt['get_keywords']			:  '';

//取得するキーワード
$search_words = explode(',',esc_html($search_engine_opt['get_keywords']));
//echo '<pre>_ranks'; print_r($search_words); echo '</pre>';

$table_name = $wpdb->prefix . 'ranking_essence';

$today = current_time( 'mysql' );
$_this_year = date('Y');
$_year = !empty($_POST['rank_year']) ? $_POST['rank_year'] : date('Y');
$_month = !empty($_POST['rank_month']) ? $_POST['rank_month'] : date('m');
$_last_day = date('t', strtotime($_year.'-'.$_month.'-01'));

//$_from_date = $_year.'-'.$_month.'-01 00:00:00';
//$_last_date = $_year.'-'.$_month.'-'.$_last_day.' 00:00:00';
	
$_from_date = date("Y-m-d H:i:s",strtotime("-1 week"));
$_last_date = date("Y-m-d H:i:s");
	

if( empty( $_POST['rank_keyword'] ) ){
	$results = $wpdb->get_results("
    SELECT rank, title, date, keywords, url
    FROM {$table_name}
    WHERE date between '{$_from_date}' and '{$_last_date}'
    ORDER BY date DESC
    LIMIT 100
	");
}else{
	$results = $wpdb->get_results("
    SELECT rank, title, date, keywords, url
    FROM {$table_name}
    WHERE date between '{$_from_date}' and '{$_last_date}'
		AND keywords LIKE '{$_POST['rank_keyword']}'
    ORDER BY date DESC
    LIMIT 100
	");
}


if( empty($search_words) ){
  return;
}
if( empty($results) ){
  echo '<p>該当期間に保存された順位がありません</p>';
  return;
}

$_ranks = [];
$_word_count = 0;
foreach ( $search_words as $key => $words) {
	foreach ( array_reverse($results) as $value) {
		if( $words !== $value->keywords ) continue;
		
		$_date = date('Y-m-d', strtotime($value->date));
		$_rank = !empty($value->rank) ? $value->rank : 99 ;
		$_ranks[$_date][] = $_rank;
	}
	++$_word_count;
};

//echo '<pre>_ranks'; print_r(array_reverse($_ranks)); echo '</pre>';

?>

<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['日付', <?php echo '"'.implode('","', $search_words).'"'; ?>],
			<?php
			$max_count = count($search_words);
			foreach( $_ranks as $date => $rank ){
				echo '["'.$date.'",';
				
				$date_rank = [];
				for ($count = 0; $count < $max_count; $count++){
					$date_rank[] = !empty( $rank[$count] ) ? $rank[$count] : 99 ;
				}
				echo implode(',', $date_rank);
				echo '],';
			}
			?>
		]);

		var options = {
			title:'<?php echo $_year.'年'.$_month.'月' ?>　検索順位',
			width:100+'%',
			height:500,
			pointSize: 6,
			//curveType: 'function',
			legend: { position: 'bottom' },
			vAxis: {direction:-1},
		};
		var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

		chart.draw(data, options);
	}
	
	
</script>

<div id="curve_chart"></div>

<?php
}
?>