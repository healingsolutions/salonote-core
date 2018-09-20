<?php



if( !empty($_POST) ){
	if(is_user_logged_in()){
		//echo '<pre>_POST'; print_r($_POST); echo '</pre>';
	}
	$menu_item_id = isset($_POST['menu_item_id']) ? $_POST['menu_item_id'] : 'hoge' ;
	$menu_reserve_option = !empty($_POST['menu_reserve_option']) ? $_POST['menu_reserve_option'] : null ;
	$shop_menu_items	= !empty($_POST['menu_post_id']) ? get_post_meta($_POST['menu_post_id'],	'essence_shop_menu'	,true) : null ;
}else{
	echo 'ページ遷移が正しく行われませんでした';
	return;
}

if(is_user_logged_in()){
	$userinfo = wp_get_current_user( );
}else{
	$userinfo = null;
}


?>

<div id='progress'><div id='progress-complete'></div></div>

    <form id="reserve_form" action="<?php the_permalink();?>" method="post" class="shop_menu_block" name="shop_menu_reserve">
			<?php wp_nonce_field( 'post_shop_menu_reserve_send', 'nonce_shop_menu_reserve_send' ); ?>
			<input type="hidden" name="menu_post_id" value="<?php echo $_POST['menu_post_id'];?>">
			<input type="hidden" name="post_microtime" value="<?php echo microtime();?>">
			<input type="hidden" name="post_date" value="<?php echo date('Y-m-d H:i:s');?>">
			<input type="hidden" name="ticket" value="<?php echo $_POST['ticket']; ?>">
			
				<fieldset id="menu_check">
            <legend class="heading">ご予約メニュー</legend>
            <div class="form-group">
							<input id="reserve_menu" name="reserve_menu" type="text" class="form-control" value="<?php echo $shop_menu_items[$menu_item_id]['menu_global_name']; ?>" required readonly />
						</div>
						<?php
						if( !empty($menu_reserve_option) ){
							
							echo '<p class="heading">オプション</p>';
							
							foreach($menu_reserve_option as $key => $value){

								preg_match('/%%(.+?)%%/', $value, $matches);
								$_option_id = $matches[1];
								$_option_label = str_replace('%%'.$_option_id.'%%', '', $value);
								//echo $_option_label = $matches[2];

								echo '
								<div class="form-group shop_menu_check">

								<input id="shop_menu_option_'.$key.'" type="checkbox" class="form-checkbox" name="shop_menu_option[]" value="%%'.$_option_id.'%%'.$shop_menu_items[$_option_id]['menu_global_name'].'" checked />
								<label for="shop_menu_option_'.$key.'"><span>'.
									$shop_menu_items[$_option_id]['menu_global_name'] . 
									(!empty($shop_menu_items[$_option_id]['menu_global_time']) ? '【'.$shop_menu_items[$_option_id]['menu_global_time'].'】' : '').
									(!empty($shop_menu_items[$_option_id]['menu_global_price']) ? '<span class="menu_price">'. $shop_menu_items[$_option_id]['menu_global_price'] .'円</span>' : '').
								'</span></label>
								</div>
								';
							}
						}
						?>
        </fieldset>
			
			
        <fieldset id="profile_form">
            <legend class="heading">お客様の情報</legend>
            <div class="form-group required-item">
							<div class="col-form-label"><label for="user_name">お名前</label></div>
							<input id="user_name" name="user_name" type="text" class="form-control"<?php echo (!empty($userinfo->display_name) ? 'value="'.esc_attr($userinfo->display_name) .'"' : '' ); ?> required />
            </div>
            <div class="form-group required-item">
							<div class="col-form-label"><label for="user_email">Email</label></div>
							<input id="user_email" name="user_email" type="email" class="form-control"<?php echo (!empty($userinfo->user_email) ? 'value="'.esc_attr($userinfo->user_email) .'"' : '' ); ?> required />
            </div>
						<div class="form-group required-item">
							<div class="col-form-label"><label for="user_tel">お電話番号</label></div>
							<input id="user_tel" name="user_tel" type="tel" class="form-control"<?php echo (!empty($userinfo->user_tel) ? 'value="'.esc_attr($userinfo->user_tel) .'"' : '' ); ?> required />
							</div>
					
					<!--
						<div class="form-group">
							<div class="col-form-label"><label for="user_address">ご住所</label></div>
							<input id="user_address" name="user_address" type="text" class="form-control"<?php echo (!empty($userinfo->user_address) ? 'value="'.esc_attr($userinfo->user_address) .'"' : '' ); ?> />
            </div>

-->
					
					
						<div class="form-group required-item">
							<div class="col-form-label"><label for="user_address">性別</label></div>
		
							
							<div class="text-center">
							<input id="user_gender-female" name="user_gender" type="radio" value="female"<?php if( !empty($userinfo->user_gender) &&  $userinfo->user_gender === 'female' ){
								echo ' selected';
							} ; ?> required /><label for="user_gender-female" class="radio-inline"><span>女性</span></label>
							</div>
							
							<!--
							<div class="text-center">
							<input id="user_gender-male" name="user_gender" type="radio" value="male"<?php if($userinfo->user_gender === 'male' ){
								echo ' selected';
							} ; ?> /><label for="user_gender-male" class="radio-inline"><span>男性</span></label>
							</div>
-->
							
            </div>
					
	
					
						<div class="form-group">
							<div class="col-form-label"><label for="user_message">ご質問やご要望</label></div>
							<textarea id="user_message" name="user_message" class="form-control" rows="8"></textarea>
            </div>
					
					<?php
					if( !is_user_logged_in()){
						echo '<div class="form-group">
							<label for="register">ユーザー登録</label>
							<input id="register" name="register" type="checkbox"/>
							<p class="hint">ユーザー登録をしておかれると次回以降は入力が楽になります。</p>
            </div>';
					}else{
						echo '<input type="hidden" name="user_id" value="'.$userinfo->ID.'">';
					}
					?>
						
        </fieldset>
			
				<?php
					require_once( SHOP_MENU_ESSENCE_PLUGIN_PATH. "/template-parts/module/shop_menu_reserve-time.php");
				?>

        <button id="SaveAccount" type="submit" class="btn btn-item submit">予約送信</button>

    </form>