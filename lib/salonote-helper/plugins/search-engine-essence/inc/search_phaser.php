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


	$search_engine_opt = get_option('search_engine_ad_essence_options');

	$search_engine_opt['get_keywords']  		= isset($search_engine_opt['get_keywords'])  			? $search_engine_opt['get_keywords']			:  '';
	$search_engine_opt['alert_range']  			= isset($search_engine_opt['alert_range'])  			? $search_engine_opt['alert_range']				:  10;
	$search_engine_opt['get_search_page']  	= isset($search_engine_opt['get_search_page'])  	? $search_engine_opt['get_search_page']		:  5;
	$search_engine_opt['get_mobile_rank'] 	= isset($search_engine_opt['get_mobile_rank'])  	? $search_engine_opt['get_mobile_rank']		:  false;

	//必要ライブラリ
	if( empty($search_engine_opt['disable_phpquery']) ){
		//require_once( SEARCH_ENGINE_ESSENCE_PLUGIN_PATH. '/lib/phpQuery/phpQuery-onefile.php');
		require_once( SALONOTE_HELPER__PLUGIN_PATH. '/phpQuery/phpQuery-onefile.php' );
	}


	//検索ベース
	$search_google_url	= "https://www.google.com/search?client=safari&rls=en&ie=UTF-8&oe=UTF-8&q=";

	//取得するキーワード
	$search_words = explode(',',esc_html($search_engine_opt['get_keywords']));

	//ランキングを確認するURL
	$_my_url = esc_url( get_home_url());

	$find = array( 'http://', 'https://' );
	$_my_url = str_replace( $find, '', $_my_url );



	foreach( $search_words as $key => $keyword ){
		
		if( empty($keyword) ) continue;


		//URLを作成
		$google_url = $search_google_url . urlencode($keyword);

		$search_result = [];

		for ($count = 0; $count < $search_engine_opt['get_search_page']; $count++){

			if( $count > 0 ){
				$google_get_url = $google_url . '&start='.($count*10);
			}else{
				$google_get_url = $google_url;
			}

			//echo $google_get_url;

			//ページ取得
			//$html = file_get_contents($google_get_url);
			if( $search_engine_opt['get_mobile_rank'] !== false ){
				//get Mobile
				$user_agent = "Mozilla/5.0 (iPhone; CPU iPhone OS 9_0_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13A404 Safari/601.1";
			}else{
				//get PC
				$user_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.111 Safari/537.36';
			}
			

			$ch   = curl_init();
			$options = array(
				CURLOPT_URL => $google_get_url,
				CURLOPT_HEADER => false,
				CURLOPT_NOBODY => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 10,
				CURLOPT_USERAGENT => $user_agent,
			);
			curl_setopt_array($ch, $options);
			$html = curl_exec($ch);
			
			

			//DOM取得
			$doc = phpQuery::newDocument($html);

			$entrycontent = $doc['#search'];

			if( !empty($entrycontent) ){

				foreach ($entrycontent->find(".g") as $item){
				//更新日
					$url = pq($item)->find('cite')->text();
					echo '<pre>url'.$url .'</pre>';
				//タイトル
					$title = pq($item)->find('h3')->text();
				//配列に格納
					if( !empty($url) ){
						$search_result[] = ['url' => $url, 'title' => $title];
					}

				}
				

			}
			
			
			if(strpos($url,$_my_url) !== false){
				break;
			}
			
			//randam sleep
			sleep(rand(3,5));

		}// for 5




		if(is_user_logged_in()){
			//echo '<pre>'; print_r($search_result); echo '</pre>';
		}

		

		$_my_ranking = [];
		foreach( $search_result as $key => $value ){

			echo $value['url'] . ' | ' . $_my_url .'<br>';

			if(strpos($value['url'],$_my_url) !== false){

				$_my_ranking = array(
					'date' 		=> current_time( 'mysql' ),
					'rank' 		=> ($key+1),
					'title' 	=> $value['title'],
					'keywords'=> $keyword,
					'url'  		=> $value['url'],
				);
			}
		}
		
		if( empty($_my_ranking) ){
			$_my_ranking = array(
				'date' 		=> current_time( 'mysql' ),
				'rank' 		=> 0,
				'title' 	=> '',
				'keywords'=> $keyword,
				'url'  		=> '',
			);
		}

		if(is_user_logged_in()){
			echo '<pre>_my_ranking'; print_r($_my_ranking); echo '</pre>';
		}
		$today = current_time( 'mysql' );
		$from_date = date('Y-m-d 00:00:00', strtotime(str_replace('-', '/', $today)));		
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'ranking_essence';
		$check_results = $wpdb->get_results("
				SELECT date, keywords, url
				FROM {$table_name}
				WHERE date between '{$from_date}' and '{$today}'
				AND keywords LIKE '{$keyword}'
				ORDER BY date DESC
				LIMIT 100
		");
		
		if(is_user_logged_in()){
			//echo '<pre>check_results'; print_r($check_results); echo '</pre>';
		}
		
		if( !empty($check_results) ){
			//echo 'do not save.';
			//return;
		}else{
			//echo 'done saved.';
			$wpdb->insert(
				$table_name,
				$_my_ranking
			);
		}

		if(is_user_logged_in()){
			//echo '<pre>results'; print_r($results); echo '</pre>';
		}

		

		// save process ------------------------------------------
		/**/
		
		
		
		// notification process ------------------------------------------
		//echo $keyword;
		
		$_today_rank = $wpdb->get_results("
				SELECT date, rank, keywords
				FROM {$table_name}
				WHERE date between '{$from_date}' and '{$today}'
				AND keywords LIKE '{$keyword}'
				ORDER BY date DESC
				LIMIT 1
		");

		$_yesterday = date('Y/m/d 00:00:00', strtotime('-1 day')); // 昨日の日付
		
		$_yesterday_rank = $wpdb->get_results("
				SELECT date, rank, keywords
				FROM {$table_name}
				WHERE date between '{$_yesterday}' and '{$from_date}'
				AND keywords LIKE '{$keyword}'
				ORDER BY date DESC
				LIMIT 1
		");
		if(is_user_logged_in()){
			//echo '<pre>_today_rank'; print_r($_today_rank[0]->rank); echo '</pre>';
			//echo '<pre>_yesterday_rank'; print_r($_yesterday_rank[0]->rank); echo '</pre>';
		}
		
		echo '$_today_rank->rank' . $_today_rank[0]->rank;
		
		if( isset($_today_rank[0]->rank) && isset($_yesterday_rank[0]->rank)){
			//echo '差分'.$_rank_range = $_today_rank[0]->rank - $_yesterday_rank[0]->rank;
			if( abs($_rank_range) > $search_engine_opt['alert_range'] ){
				echo '変動がありました';
				
$return_text = <<< EOM
順位変動報告

キーワード：{$keyword}　において、{$search_engine_opt['alert_range']}以上の、順位の変動がありました

昨日：　{$_yesterday_rank[0]->rank}
今日：　{$_today_rank[0]->rank}
変動差：{$_rank_range}
EOM;
				$to      = get_option( 'admin_email' ) ;
				$subject = get_bloginfo('name').'　【'. $_rank_range .'位差】の　検索順位の変動がありました';
				$message = strip_tags($return_text);
				$headers = 'From: '.get_bloginfo('name').' <'.$_admin_mail.'>' . "\r\n";
				wp_mail( $to, $subject, $message, $headers);
			}
		}
		
		
		

	};//endforeach
	

?>