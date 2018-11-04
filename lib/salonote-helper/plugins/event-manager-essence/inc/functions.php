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
	exit; // Exit if accessed directly.
}


// ==================================
// 参加者リストなどのjQuery
add_action( 'admin_enqueue_scripts', 'event_manager_essence_admin_style' ); //管理画面用のCSS
function event_manager_essence_admin_style($hook){
	global $hook_suffix;
	if ( 'post.php' != $hook_suffix && 'post-new.php' != $hook_suffix ) {
			return;
	}
	
	if ('settings_page_shop-menu-essence/event_manager_essence' !== $hook_suffix ) {
		//return;
	}
	
	$event_opt = get_option('event_manager_essence_options');
	if( empty($event_opt['manage_member']) && empty($event_opt['event_timetable']) ){
		return;
	}
	wp_enqueue_script('jquery-ui-core');
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_style('jquery-ui-css', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');
  wp_enqueue_script('jquery-ui-js-ja', '//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js');
	
	//wp_enqueue_style( 'ui-lightness', '//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css');
	//wp_enqueue_script( 'jquery-ui-core', '//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js');
	wp_enqueue_script('sfprototypeman', EVENT_MANAGER_ESSENCE_PLUGIN_URI . '/statics/js/jquery.sfprototypeman.js', array(), '1.0.0');
	wp_enqueue_script('event_manager_essence', EVENT_MANAGER_ESSENCE_PLUGIN_URI . '/statics/js/main.js', array(), '1.0.0' ,true);
	wp_enqueue_style ('event_manager_essence', EVENT_MANAGER_ESSENCE_PLUGIN_URI . '/statics/css/style.css');
}



add_action( 'wp_enqueue_scripts', 'event_manager_essence_scripts' );
function event_manager_essence_scripts() {
	$event_opt = get_option('event_manager_essence_options');
	if( empty($event_opt['event_timetable']) ){
		return;
	}
  wp_enqueue_script( 'jquery-dataTables','//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js',true );
  wp_enqueue_script( 'bootstrap-dataTables','//cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js',true );
  
  //wp_enqueue_style('bootstrap','//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
  wp_enqueue_style('dataTables','//cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css');
}



if( !is_admin() ){
add_action('print_footer_scripts','print_event_manager_footer_script');
function print_event_manager_footer_script(){
		
	global $post_type;
	$event_opt['post_type']	= isset($event_opt['post_type'])? $event_opt['post_type']: null;
	if( !is_singular($event_opt['post_type'])){
		return;
	}
	?>
	<script>
	jQuery( function($){
		
			// モーダルウィンドウを開く
			function showModal(event) {
					event.preventDefault();

					var $shade = $('<div><\/div>');
					$shade
							.attr('id', 'shade')
							.on('click', hideModal);


					var $modalWin = $('#modalwin');
					var $window = $(window);
					var posX = ($window.width() - $modalWin.outerWidth()) / 2;
					var posY = ($window.height() - $modalWin.outerHeight()) / 4;
				
					//console.log('posX:'+posX+' posY:'+posY+' $window:'+$window.height()+' $modalWin.outerWidth()'+$modalWin.outerWidth()+' $modalWin.outerHeight()'+$modalWin.outerHeight());

					$modalWin
							.before($shade)
							.css({left: posX, top: posY})
							.removeClass('hide')
							.addClass('show')
							.on('click', 'button', function () {
									hideModal();
							});
			}

			function hideModal() {
					$('#shade').remove();
					$('#modalwin')
							.removeClass('show')
							.addClass('hide');
			}
		
			jQuery('.timetable-reserve-modal-btn').on('click',function(e) {
				var timetable_title 	= $(this).data('title');
				var timetable_date 		= $(this).data('date');
				var timetable_value 	= $(this).data('value');
				var timetable_limit 	= $(this).data('limit');
				
				$('#modalwin h1').text(timetable_title+'の予約');
				$('#modalwin input#timetable_modal_input-id').val(timetable_value);
				$('#modalwin input#timetable_modal_input-date').val(timetable_title);

				//console.log(timetable_date+':'+timetable_value+':'+timetable_limit);
				showModal(e);
			})
		
		<?php
		if( !empty($event_opt['manage_member']) && !empty($event_opt['event_timetable']) ){
		?>
			jQuery('table#sorting-table').DataTable({

				// 件数切替機能 無効
				lengthChange: false,
				// 検索機能 無効
				//searching: false,
				// 情報表示 無効
				info: false,
				// ページング機能 無効
				paging: false,

				//order: [[ 0, "DESC" ]],

				"language": {
					"url": "//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Japanese.json"
				},
			});
		<?php
		}
		?>
		
		
	});
	</script>
<?php
};
};



// ==================================
// コンテンツにメンバー表示
function event_manager_content_hook($content){
	
	$event_opt = get_option('event_manager_essence_options');
	if( empty($event_opt['manage_member']) && !in_the_loop() ){
		return $content;
	}

	$event_opt['post_type']	= isset($event_opt['post_type'])? $event_opt['post_type']: null;

	if( empty($event_opt['post_type']) || !is_singular($event_opt['post_type'])){
		return $content;
	}

	echo do_shortcode($content);
	echo '<hr style="margin-bottom: 50px;">';
	require( EVENT_MANAGER_ESSENCE_PLUGIN_PATH . '/template-parts/print_event_manager.php');
	
	return;

}
add_filter('the_content','event_manager_content_hook',999);





// ==================================
// コンテンツに情報を表示
function event_information_content_hook($content){

	
	$event_opt = get_option('event_manager_essence_options');
	if( empty($event_opt['event_info']) && empty($event_opt['event_timetable']) ){
		return $content;
	}

	$event_opt['post_type']	= isset($event_opt['post_type'])? $event_opt['post_type']: null;
	if( empty($event_opt['post_type']) || !is_singular($event_opt['post_type'])){
		return $content;
	}

	
	echo do_shortcode($content);
	echo '<hr style="margin-bottom: 50px;">';
	
	if( !empty($event_opt['event_info'])){
		require( EVENT_MANAGER_ESSENCE_PLUGIN_PATH . '/template-parts/print_event_informations.php');
	}
	
	if( !empty($event_opt['event_timetable'])){
		require( EVENT_MANAGER_ESSENCE_PLUGIN_PATH . '/template-parts/print_event_timetable.php');
	}

	return;

}
add_filter('the_content','event_information_content_hook',999);


// ==================================
// 概要にフィルターをかける
function event_manager_excerpt_hook($excerpt){
	
	$event_opt = get_option('event_manager_essence_options');
	if( empty($event_opt['event_info']) ){
		return $excerpt;
	}

	if( !is_singular('events') && !is_post_type_archive('events') && !is_tax('event_category') && !is_tax('event_area') && !is_search() ){
		return $excerpt;
	}
	global $_place;
	$_place = 'is_excerpt';
	require( EVENT_MANAGER_ESSENCE_PLUGIN_PATH . '/template-parts/print_event_informations.php');
	return;

}
add_filter('get_the_excerpt','event_manager_excerpt_hook');



// ==================================
// 日付にフィルターをかける
function event_manager_date_hook($date){
	
	if( !is_singular() ) return $date;
	

	if( !is_singular('events') && !is_post_type_archive('events') && !is_tax('event_category') && !is_tax('event_area')  ){
		return $date;
	}
	
	global $post;
	
	$print_event = '';
	
	date_default_timezone_set('Asia/Tokyo');
	$event_date = $post->post_date;

	if($event_date ){
		$event_count =	intval((strtotime($event_date) - strtotime(date('Y/m/d'))) / (60*60*24));

		if( date('Ymd',strtotime($event_date))  <  (date('Ymd')) ) {
			$print_event = '<div class="event-status-block btn btn-success event_end">終了</div>';
		} else if (date('Ymd') == date("Ymd", strtotime($event_date)) ){
			$print_event =  '<div class="event-status-block btn btn-danger event_today">本日</div>';
		} else if (date("Ymd", strtotime($event_date))   >  (date('Ymd'))  ){
			$print_event =  '<div class="event-status-block btn btn-warning event_counter">あと'. $event_count .'日</div>';
		}        
	};

	return $date . $print_event;

}
add_filter('get_the_date','event_manager_date_hook');





add_action('template_redirect','check_double_event_post' );
function check_double_event_post(){
	
	
	
	$event_opt = get_option('event_manager_essence_options');
	
	if( empty($event_opt['event_timetable'])) return;
	
	
	if( empty($_POST)) return;
	if( is_admin()){
		
		echo 'hoge';
	
		if(is_user_logged_in()){
			echo '<pre>_POST'; print_r($_POST); echo '</pre>';
		}

		if( !empty($_POST) && $_POST['token'] === '') {
			die('不正なアクセスです');
		};

		if( $_POST['token'] == $_SESSION['token'] ){
			//echo 'トークンが一致しました';
			$_SESSION['token'] = null;
			//  セッション変数を解放し、ブラウザの戻るボタンで戻った場合に備える。
			unset($_SESSION['token']);
			session_destroy();
			return;
		}else{
			//echo '二重投稿のようです';
			session_destroy();
			wp_redirect( $_SERVER["REQUEST_URI"] ); exit;
		}
		
	}

}



/*-------------------------------------------*/
/*	weekday function
/*-------------------------------------------*/
function event_manager_weekday_japanese_convert( $date ){
 global $weekday;
 $weekday = array(
	 '日',
	 '月',
	 '火',
	 '水',
	 '木',
	 '金',
	 '土',
 );
 return '('.$weekday[date( 'w',strtotime($date))].')';
}



function calendar_post_per( $query ) {
	if ( is_admin() || ! $query->is_main_query() ){
			return;
	}
	 if ( $query->is_month() ) {
		 $query->set('posts_per_page', -1);
		}
	}
add_action('pre_get_posts','calendar_post_per');

?>