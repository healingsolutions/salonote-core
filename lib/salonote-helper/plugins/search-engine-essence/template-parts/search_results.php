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

$_from_date = $_year.'-'.$_month.'-01 00:00:00';
$_last_date = $_year.'-'.$_month.'-'.$_last_day.' 00:00:00';

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


if(is_user_logged_in()){
	//echo '<pre>results'; print_r(array_reverse($results)); echo '</pre>';
}

?>

<form action="" method="post">
	<select name="rank_year">
		<?php

		for ($count = $_this_year; $count >= ($_this_year-3); $count--){
			echo '<option value="'.$count.'"';
			if( $count == $_year ) echo ' selected' ;
			echo '>'.$count.'</option>';
		}
		?>
	</select>
	<select name="rank_month">
		<?php
		for ($count = 1; $count <= 12; $count++){
			echo '<option value="'.$count.'"';
			if( $count == $_month ) echo ' selected' ;
			echo '>'.$count.'</option>';
		}
		?>
	</select>
	
	<select name="rank_keyword">
		<option value="">---</option>
		<?php
		foreach( $search_words as $key => $words ){
			echo '<option value="'.$words.'"';
			if( !empty( $_POST['rank_keyword'] ) && $words == $_POST['rank_keyword'] ) echo ' selected' ;
			echo '>'.$words.'</option>';
		}
		?>
	</select>
	
	<input type="submit" value="検索">
</form>

<?php


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





<div class="wrap col-sm-12">
  <h2>全ての検索順位リスト</h2>
  <table id="sorting-table" class="table table-striped table-bordered" style="width: 100%;">
    <thead>
      <tr>
        <td>日付</td>
        <td>キーワード</td>
        <td>順位</td>
        <td>タイトル</td>
        <td>URL</td>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ( array_reverse($results) as $value) {
        echo '<tr>';
          echo '<td>'.date('Y-m-d', strtotime($value->date)).'</td>';
          echo '<td>'. (!empty($value->keywords) ? $value->keywords : '') .'</td>';
          echo '<td>' .(!empty($value->rank) ? $value->rank : '圏外') . '</td>';
          echo '<td>'. (!empty($value->title) ? $value->title : '') .'</td>';
          echo '<td>'. (!empty($value->url) ? '<a href="'.$value->url.'" target="_blank">'.str_replace(get_home_url(''), "",$value->url).'</a>' : '') .'</td>';
        echo '</tr>';
      }
      ?>
    </tbody>
  </table>
</div>
<script>
<!--
  jQuery(document).ready( function($) {
    $('table#sorting-table').DataTable({
			lengthMenu: [ 10, 20, 30, 40, 50 ],
			displayLength: 30,  
			order: [ [ 0, "DESC" ] ],
      "language": {
        "url": "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Japanese.json"
      },
    });
});
// -->
</script>
<style>
  #sorting-table_wrapper .row{
    width: 100%;
  }
  
  #sorting-table_wrapper .row .col-sm-6{
    display: inline-block;
  }
</style>
