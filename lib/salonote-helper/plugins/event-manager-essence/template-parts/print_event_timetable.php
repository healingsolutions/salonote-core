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

global $post;
global $wpdb;


$table_name = $wpdb->prefix . 'event_manager_essence';

$post_id = $post->ID;
$_can_reserve = true;

//初期化
$_SESSION['already_send'] = null;
//$_SESSION['token'] = null;

if(is_user_logged_in()){
		echo '<pre>_POST'; print_r($_POST); echo '</pre>';
	}

//save process
if( !empty($_POST['page_id']) ){
	if ( !empty($_POST['timetable_modal_nonce'] ) && wp_verify_nonce( $_POST['timetable_modal_nonce'], 'timetable_modal' ) ) {
		
		if( empty($_POST['reseve_timetable']['rsv_id']) ){ return; };
		
		// ===================================
    // 送信処理
    // ===================================
		/*
		$insert_value = array(
			'post_id' 	=> $_POST['page_id'],
			'user_id' 	=> $_POST['user_id'],
			'date' 			=> current_time( 'mysql' ),
			'name' 			=> esc_html($_POST['reseve_timetable']['rsv_name']),
			'mail' 			=> esc_html($_POST['reseve_timetable']['rsv_mail']),
			'timetable' => esc_html($_POST['reseve_timetable']['rsv_id']),
			'phone' 		=> esc_html($_POST['reseve_timetable']['rsv_phone']),
			'message' 	=> esc_html($_POST['reseve_timetable']['rsv_message']),
		);
		
		$wpdb->insert(
			$table_name,
			$insert_value
		);
		*/
		
		//echo '<pre>insert_value'; print_r($insert_value); echo '</pre>';
		$sql = $wpdb->prepare(
				"INSERT INTO {$table_name}
				(post_id, user_id, rsv_date, rsv_name, rsv_mail, rsv_timetable, rsv_phone, rsv_message)
				VALUES (%d, %d, %s, %s, %s, %s, %s ,%s)",
				$_POST['page_id'],
				$_POST['user_id'],
				current_time( 'mysql' ),
				esc_html($_POST['reseve_timetable']['rsv_name']),
				esc_html($_POST['reseve_timetable']['rsv_mail']),
				esc_html($_POST['reseve_timetable']['rsv_id']),
				esc_html($_POST['reseve_timetable']['rsv_phone']),
				esc_html($_POST['reseve_timetable']['rsv_message'])
		);

		$wpdb->query($sql);		
    $wpdb->show_errors();
		
		//send notification
		
		//確認メール
		$return_text = '';
		$return_text .= get_the_title($post->ID) . 'の予約を受け付けました。'.PHP_EOL;
		$return_text .= '管理者用の確認メールを送信いたします。'.PHP_EOL.PHP_EOL;
		$return_text .= '予約日時： '.esc_html($_POST['reseve_timetable']['rsv_date']).PHP_EOL;
		$return_text .= '予約者： '.esc_html($_POST['reseve_timetable']['rsv_name']).PHP_EOL;
		$return_text .= '電話番号： '.esc_html($_POST['reseve_timetable']['rsv_phone']).PHP_EOL;
		$return_text .= 'メッセージ： '.esc_html($_POST['reseve_timetable']['rsv_message']).PHP_EOL;

		//$to      = get_option( 'admin_email' );
		$to      = 'info@healing-solutions.jp';
		$subject = '【管理者 予約確認メール】 ' . get_bloginfo('name') .'|'. get_the_title($post->ID);
		$message = strip_tags($return_text);
		$headers = 'From: '.get_bloginfo('name').' <'.$to.'>' . "\r\n";
		wp_mail( $to, $subject, $message, $headers);
		

	}elseif ( !empty($_POST['timetable_delete_nonce'] ) && wp_verify_nonce( $_POST['timetable_delete_nonce'], 'timetable_delete' ) ) {
		if( current_user_can('administrator')) {
			$delete_value = array(
				'rsv_timetable' 	=> $_POST['delete'],
			);
			$wpdb->delete(
				$table_name,
				$delete_value
			);
		}
	}else {
		print '認証できませんでした。';
	}
}else{
	//echo 'postではないので、チケットを生成しました';
	
}

//  ワンタイムチケットを生成する。
$token = md5(uniqid(rand(), true));

//  生成したチケットをセッション変数へ保存する。
$_SESSION['token'] = $token;

//get reserved timetable data
$results = $wpdb->get_results("
	SELECT user_id, rsv_name, rsv_timetable, rsv_mail, rsv_phone, rsv_message
	FROM {$table_name}
	WHERE post_id = {$post_id}
	LIMIT 500
");

//echo '<pre>insert_value'; print_r($results); echo '</pre>';

$_resereved = [];
foreach($results as $key=>$value){
	$_resereved[$value->rsv_timetable][] = $value->rsv_name;
}
//echo '<pre>insert_value'; print_r($_resereved); echo '</pre>';

$event_timetable_labels = get_post_meta($post->ID, 'essence_event_timetable_label',true);
$event_timetable_fields = get_post_meta($post->ID, 'essence_event_timetable_value',true);


if( empty($event_timetable_labels) && empty($event_timetable_fields) ){
	 return;
}

$schedule_labels_arr = explode(",", $event_timetable_labels);
foreach($schedule_labels_arr as $key => $value){
	$event_field_arr[] = $value;
}


if( !empty($event_opt['event_timetable_login']) ){
	//ログイン必須
	if(is_user_logged_in()){
		//echo '<pre>event_timetable_labels'; print_r($event_field_arr); echo '</pre>';
		//echo '<pre>event_timetable_fields'; print_r($event_timetable_fields); echo '</pre>';

		//ユーザーの予約件数を取得
		$event_timetable_reserve_limit 	= get_post_meta($post->ID, 'essence_event_timetable_reserve_limit',true);

		if( $event_timetable_reserve_limit > 0 ){
			$current_user = wp_get_current_user();	
			$table_name = $wpdb->prefix . 'event_manager_essence';
			$reserve_results = $wpdb->get_results("
				SELECT rsv_timetable
				FROM {$table_name}
				WHERE user_id = {$current_user->ID}
				LIMIT 500
			");
		}

		if( $event_timetable_reserve_limit <= count($reserve_results) ){
			if( current_user_can('administrator')) {
				echo '<p class="text-center">'.$current_user->display_name.'さんは、すでに<span>'.count($reserve_results).'</span>件　予約済みですが<br>
				管理者権限のため、代理予約が可能となっています</p>';
			}else{
				echo '<h2 class="text-center">'.$current_user->display_name.'さんは、すでに<span>'.count($reserve_results).'</span>件　予約済みです</h2>';
				$_can_reserve = false;
			}
			
		}

	}else{
		$_can_reserve = false;
		echo '<h2>ユーザー登録・ログインをしてください</h2>';
		echo '<div id="login" class="login">';
		$args = array(
        'echo'           => true,
        'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
        'form_id'        => 'loginform',
        'label_username' => __( 'Username' ),
        'label_password' => __( 'Password' ),
        'label_remember' => __( 'Remember Me' ),
        'label_log_in'   => __( 'Log In' ),
        'id_username'    => 'user_login',
        'id_password'    => 'user_pass',
        'id_remember'    => 'rememberme',
        'id_submit'      => 'wp-submit',
        'remember'       => true,
        'value_username' => '',
        'value_remember' => false
		);
		wp_login_form( $args );
		echo '</div>';
		echo '<a class="button" href="'. wp_login_url( $_SERVER["REQUEST_URI"] )  .'">登録／ログイン</a>';
	}
};


$_table_head = '<div class="event-timetable-block">
<table';

if( !wp_is_mobile() ){
	$_table_head .= ' id="sorting-table"';
};

$_table_head .= ' class="table table-striped table-bordered">
<thead>
<tr>';

$_table_head .= '<th>日にち</th>';
$_table_head .= '<th>場所</th>';
$_table_head .= '<th>メモ</th>';

foreach( $event_field_arr as $key => $label ){
	$_table_head .= '<th class="timetable-item">'.$label.'</th>';
}
	
$_table_head .= '
</tr>
</thead>
<tbody>';

$_table_foot = '</tbody></table></div>';


if( !wp_is_mobile() ){
	echo $_table_head;
}

foreach( $event_timetable_fields as $key => $timetable_item ){
	$date = '';
	
	if( wp_is_mobile() ){
		echo $_table_head;
	}
	$date = date('c', strtotime($timetable_item['date']));
	if( date('Ymd',strtotime($date))  <  (date('Ymd')) ) {
		continue;
	};
	
	echo '<tr>';
	foreach( $timetable_item as $item_key => $value ){
		
		if( $item_key == 'user_id' ) continue;
		
		if( $item_key == 'date'){
			//$date = date('c', strtotime($value));
			echo '<td class="timetable_date">'.date('Y年m月d日', strtotime($value)). event_manager_weekday_japanese_convert($value).'</td>';
		}
		elseif($item_key == 'place' || $item_key == 'memo' ){
			echo '<td class="timetable_'.$item_key.'">'. (!empty($value) ? nl2br($value) : '') .'</td>';
		}else{
			//check resereved
			$_reserve_count = !empty($_resereved[$key.'-'.$item_key]) ? count($_resereved[$key.'-'.$item_key]) : 0 ;
			
			$_reserve_diff = $value - $_reserve_count;
			
			$_timetable_class = '';
			$_item_value = '';
			if( $value == 0 ){
				$_timetable_class = ' item-none';
				$_item_value = '-';
			}elseif($_reserve_diff == 1){
				$_timetable_class = ' item-little';
				if( $value == 1 ){
					$_item_value = '◯';
				}else{
					$_item_value = '１';
				}

			}elseif($_reserve_diff <= 0){
				$_timetable_class = ' item-reserved';
				$_item_value = '予約済み';
			}elseif($_reserve_diff > 1){
				$_timetable_class = ' item-vacancy';
				$_item_value = '◯';
			}
			
			if( date('Ymd',strtotime($date)) < (date('Ymd') ) ){
				$_timetable_class = ' item-reserved';
			}

			echo '<td id="timetable-'.$key.'-'.$item_key.'" class="timetable-item'.$_timetable_class.'">';
			if( $_reserve_diff > 0 ){

				
				if( $_can_reserve && date('Ymd',strtotime($date)) >= (date('Ymd') ) ){
				
					$_time_key = $item_key - 1;
					if( !empty($event_field_arr[$_time_key]) ){
						$_item_table_value = ' 【'.$event_field_arr[$_time_key].'】';
					}
					
					echo '<a class="timetable-reserve-modal-btn" data-title="'.date('Y年m月d日', strtotime($date)). event_manager_weekday_japanese_convert($date).$_item_table_value.'" data-date="'.date('Y-m-d 00:00:00', strtotime($date)).'" data-value="'.$key.'-'.$item_key.'" data-limit="'.$value.'">'.$_item_value;
				}else{
					echo $_item_value;
				}
				
				if( $value > 1 && $_reserve_diff <= 1 ){
					echo '<span>/'.$value.'</span>';
				}
				
				echo '</a>';
			}else{
				echo $_item_value;
			}
			
			
			
			echo '</td>';
		}

	}
	echo '</tr>';
	if( wp_is_mobile() ){
		echo $_table_foot;
	}
}

if( !wp_is_mobile() ){
	echo $_table_foot;
}



?>

<?php
if( current_user_can('administrator')) {
?>
<div style="background-color: #EDF8E9; padding: 10px; margin: 25px auto;">
<h1>管理者用<span class="small">(管理者権限を持つユーザーのみ表示)</span></h1>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>お名前</th>
			<th>タイムテーブル</th>
			<th>e-mail</th>
			<th>電話番号</th>
			<th>メッセージ</th>
			<th>削除</th>
		</tr>
	</thead>
<tbody>
	<?php
	//result
	foreach( $results as $key => $value ){
		echo '<tr>';
		foreach($value as $sub_key => $sub_value){
			
			if( $sub_key == 'user_id' ) continue;
			
			if( $sub_key !== 'rsv_timetable' ){
				echo '<td>'.nl2br(esc_html($sub_value)).'</td>';
			}else{
				$_timetable = explode('-',$sub_value);
				echo '<td>';
				$_date = $event_timetable_fields[$_timetable[0]]['date'];
				echo date('Y年m月d日', strtotime($_date)). event_manager_weekday_japanese_convert($_date);
				
				$_time_key = $_timetable[1] - 1;
				if( !empty($event_field_arr[$_time_key]) ){
					echo ' 【'.$event_field_arr[$_time_key].'】';
				}
				
				echo '</td>';
			}
		}
		echo '
		<td>
		<form action="" method="post">';
		
		wp_nonce_field( 'timetable_delete', 'timetable_delete_nonce' );
		
		echo '
		<input type="hidden" name="token" value="'.$token.'">
		<input type="hidden" id="page_id" name="page_id" value="'.get_the_ID().'">
		<input type="hidden" name="delete" value="'.$_timetable[0].'-'.$_timetable[1].'">
		<button type="submit" value="">x</button>
		</form>
		</td>';
		echo '</tr>';
	}
	?>
	
</tbody>
</table>
</div>
<?php
};
?>

<div id="modalwin" class="modalwin hide">
    <a herf="#" class="modal-close"></a>
    <h1>タイトル</h1>
    <div class="modalwin-contents">
			<form action="" method="post">
				<?php
				wp_nonce_field( 'timetable_modal', 'timetable_modal_nonce' );

				$value = [];
				if( is_user_logged_in() ){
					$current_user = wp_get_current_user();
					$value['user_id'] = $current_user->ID;
					$value['rsv_name'] = $current_user->display_name;
					$value['rsv_mail'] = $current_user->user_email;
				}else{
					$value['user_id'] = 0;
					$value['rsv_name'] = '';
					$value['rsv_mail'] = '';
				};
				?>
				
				<input type="hidden" id="user_id" name="user_id" value="<?php echo $value['user_id']; ?>">
				<input type="hidden" id="page_id" name="page_id" value="<?php echo get_the_ID();?>">
				<input type="hidden" id="timetable_modal_input-id" name="reseve_timetable[rsv_id]" value="">
				<input type="hidden" id="timetable_modal_input-date" name="reseve_timetable[rsv_date]" value="">
				<input type="hidden" name="token" value="<?php echo $token; ?>">
				
				<table class="table timetable_form_table">
					<tbody>
						<tr>
							<th><label>お名前</label></th>
							<td><input type="text" id="timetable_modal_input-name" name="reseve_timetable[rsv_name]" value="<?php echo $value['rsv_name']; ?>" required></td>
						</tr>
						
						<tr>
							<th><label>メールアドレス</label></th>
							<td><input type="text" id="timetable_modal_input-mail" name="reseve_timetable[rsv_mail]" value="<?php echo $value['rsv_mail']; ?>" required></td>
						</tr>
						
						<tr>
							<th><label>お電話番号</label></th>
							<td><input type="text" id="timetable_modal_input-phone" name="reseve_timetable[rsv_phone]" value="" required></td>
						</tr>
						
						<tr>
							<th><label>メッセージ</label></th>
							<td><textarea id="timetable_modal_input-phone" name="reseve_timetable[rsv_message]"></textarea></td>
						</tr>
					
					</tbody>
				</table>
				
				
				<div class="timetable_form_buttons">
					<input class="btn btn-success" type="submit" value="予約する">
					<button class="btn">閉じる</button>
				</div>
				
			</form>

    </div>
</div>


<style>
	.event-timetable-block{
		display: block;
		clear: both;
		margin: 25px 0;
	}
	.event-timetable-block .timetable-item{
		text-align: center;
		vertical-align: middle;
	}
	
	.modalwin {
            position: fixed;
            width: 600px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px 0 #000;
            z-index: 1;
        }

        .modalwin dl {
            padding: 0px 10px;
        }

        .show {
            display: block;
        }

        .hide {
            display: none;
        }

        .modalwin h1 {
            background: #ededed;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            font-size: 1.2em;
            margin-top: 0;
            text-align: center;
        }

        .modalwin-contents {
            padding: 5px;
        }

        .modalwin-contents img {
            margin: 0 0 1em 0;
            float: left;
            width: 30%;
            height: 30%;
        }

        .modalwin-contents p {
            margin: 0 0 1em 0;
            line-height: 1.8em;
        }

        #shade {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #999;
            opacity: 0.9;
            z-index: 1;
        }

        @media screen and (max-width: 600px) {
            .modalwin {
                width: 90%;
            }
        }
	
	.timetable_form_table{
		margin: 0 auto;
	}
	.timetable_form_buttons{
		display: block;
		text-align: center;
		margin: 25px auto;
	}
	.timetable_form_buttons > *{
		display: inline-block;
	}
	table td.timetable-item{
		padding: 0;
	}
	.timetable-item a{
		display: block;
		width: 100%;
		height: 100%;
		cursor: pointer;
		padding: .75rem;
	}
	.timetable-item a:hover{
		text-decoration: none;
	}
	.timetable-item a span{
		font-size: 0.7em;
		color: #8C8C8C;
	}
	.timetable-item.item-reserved{
		background-color: #AEAEAE;
		color: #FFFFFF;
	}
	.timetable-item.item-little{
		background-color: #FFFF00;
		color: #000000;
		font-weight: 700;
				-webkit-transition: background-color 0.3s;
        -moz-transition: background-color 0.3s;
        -ms-transition: background-color 0.3s;
        -o-transition: background-color 0.3s;
        transition: background-color 0.3s;
	}
	.timetable-item.item-little:hover{
		background-color: #FFBE84;
		-webkit-transition: background-color 0.3s;
        -moz-transition: background-color 0.3s;
        -ms-transition: background-color 0.3s;
        -o-transition: background-color 0.3s;
        transition: background-color 0.3s;
	}
	
	.timetable_form_table input{
		border: 1px solid #CCCCCC;
		padding: 4px;
	}
	
	.timetable_date{
		word-break: keep-all;
	}
	
	@media screen and (max-width: 768px) {
    .event-timetable-block table { 
			display: block; 
			width: 100%; 
			margin: 0 -10px;
			text-align: center;
		}
		.event-timetable-block table thead{ 
			display: block; 
			width: 30%;
			float: left;
			overflow-x:scroll;
		}
		.event-timetable-block table tbody{ 
			display: block; 
			width: 70%; 
			overflow-x: auto; 
			white-space: nowrap;
		}
		.event-timetable-block table th{ 
			display: block;
			text-align: center;
		}
		.event-timetable-block table tbody tr{ 
			display: inline-block; 
			margin: 0 -3px;
		}
		.event-timetable-block table td{ 
			display: block;
		}
		
		.event-timetable-block table tr{
			display: block;
			width: 100%;
		}
		.event-timetable-block table th,
		.event-timetable-block table td{
			width: 100%;
			height: 3em;
		}
		.event-timetable-block table .timetable-item a{
			padding: 0;
		}
		
		#modalwin{
			left: 5% !important;
			right: 5% !important;
		}
	}
</style>
