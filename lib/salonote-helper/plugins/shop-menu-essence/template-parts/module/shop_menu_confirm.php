<?php

//echo '<pre>'; print_r($_POST); echo '</pre>';

//echo get_the_title($_POST['menu_post_id']);
$id = $_POST['menu_post_id'];
$menu_item_id = $_POST['menu_item_id'];
$shop_menu_items	= get_post_meta($id,	'essence_shop_menu'	,true);
//echo '<pre>shop_menu_items'; print_r($shop_menu_items); echo '</pre>';


//  ワンタイムチケットを生成する。
$ticket = md5(uniqid(rand(), true));

//  生成したチケットをセッション変数へ保存する。
$_SESSION['ticket'] = $ticket;


?>
<form method="post" action="">
<?php wp_nonce_field( 'post_shop_menu_reserve_confirm', 'nonce_shop_menu_reserve_confirm' ); ?>
<input type="hidden" name="post_microtime" value="<?php echo microtime();?>">
<input type="hidden" name="post_date" value="<?php echo date('Y-m-d H:i:s');?>">
<input type="hidden" name="ticket" value="<?php echo $ticket; ?>">

<?php
echo '
<p class="heading">選択したメニュー</p>
<input type="hidden" name="menu_post_id" value="'.$id.'">
<input type="hidden" name="menu_item_id" value="'.$menu_item_id.'">
<div class="shop_menu_block_id shop_menu_block list-view">
<div class="shop_menu_block-item">
<dl>
';
echo !empty($shop_menu_items[$menu_item_id]['menu_global_name']) ? '<dt class="hidden">メニュー名</dt><dd class="menu_name none_dt">'. $shop_menu_items[$menu_item_id]['menu_global_name'].'</dd>' : '' ;
echo !empty($shop_menu_items[$menu_item_id]['menu_global_time']) ? '<dt>所要時間</dt><dd>'. $shop_menu_items[$menu_item_id]['menu_global_time'].'</dd>' : '' ;
echo !empty($shop_menu_items[$menu_item_id]['menu_global_price']) ? '<dt>料金</dt><dd>'. $shop_menu_items[$menu_item_id]['menu_global_price'].'円</dd>' : '' ;

echo '
</dl>
</div>
</div>
';

//show option check
$option_check = false;
foreach($shop_menu_items as $key => $value){
	$option_check = array_key_exists('menu_global_option' , $value);
}


$_option_html = '';

foreach( $shop_menu_items as $key => $value ){
	if( $value['menu_global_option'] ){
		$_option_html .= '<li>'.$value['menu_global_name'].'</li>';
	}
}

$shop_menu_arr = get_post_meta($id,'essence_shop_menu',true);
if( empty($shop_menu_arr) ) return;


$post_meta = get_post_custom($id);

$shop_menu_items 				= get_post_meta($id,	'essence_shop_menu'	,true);
$shop_menu_type_id 			= get_post_meta($id,	'shop_menu_type'		,true);
$shop_menu_fields_value = get_post_meta($shop_menu_type_id, 'essence_shop_menu_fields',true);
$shop_menu_fields = $shop_menu_fields_value['fields'];


if( empty($shop_menu_fields) ) return;

if( !empty($shop_menu_fields) ){
	foreach( $shop_menu_fields as $key => $value ){
		$menu_field_arr[$value['menu_field']] = array(
			$value['menu_label'],
			$value['menu_type'],
			$value['menu_values']
		);
	}
}

$field_set = [];


foreach( $shop_menu_fields as $key => $value ){
	$field_set[$value['menu_field']]['label']   = $value['menu_label'];
	$field_set[$value['menu_field']]['type']    = !empty($value['menu_type']) 	 ? $value['menu_type'] 		: null ;
	$field_set[$value['menu_field']]['display'] = !empty($value['menu_display']) ? $value['menu_display'] : false ;
	$field_set[$value['menu_field']]['size']    = !empty($value['image_size']) 	 ? $value['image_size'] 	: 'thumbnail' ;
}

if( $option_check ){
	echo '<p class="heading">以下のオプションもオススメしております</p>';
	require( SHOP_MENU_ESSENCE_PLUGIN_PATH. "/template-parts/module/shop_menu_options.php");
}

echo '
<div class="text-center">
<button type="submit" class="shop_menu_reserve-submit btn btn-item" name="btn_submit" value="送信">予約へ進む</button>
</div>
';


echo '</form>';
	
?>