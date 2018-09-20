<?php

echo '<div class="shop_menu_block_id shop_menu_block grid-view">';
foreach( $shop_menu_arr as $key => $item ){
	
	if( empty($item['menu_global_option'])|| empty($item['menu_global_reserve']) ) continue;

	// check menu item price
	$menu_price =  !empty($item['menu_price']) ? $item['menu_price'] : 0 ;
	$item_price =  !empty($item['menu_global_price']) ? $item['menu_global_price'] : $item['menu_price'] ;
	$item_price = preg_replace('/[^0-9]/', '', $item_price);
	
	$menu_time =  !empty($item['menu_time']) ? $item['menu_time'] : 0 ;
	$menu_time = preg_replace('/[^0-9]/', '', $menu_time);	
	
	echo '<div class="shop_menu_block-item menu_block_'.$key.'" data-index="'.$key.'" data-price="'.$item_price.'" data-time="'.$menu_time.'">';
	
	$field_images = 0;
	foreach( $item as $field => $value ){
		if( !empty($field_set[$field]['type']) && $field_set[$field]['type'] == 'upload' ){
			if( !empty($value) ) ++$field_images;	
		}
	}
	
	
	echo '<dl';
	if( $field_images > 0 ){
		echo ' class="has_upload_field"';
	}
	echo '>';
	foreach( $item as $field => $value ){
		
		if( empty($value) || $field === 'menu_global_name' || $field === 'menu_global_price' || $field === 'menu_global_option' || $field === 'menu_global_reserve' ) continue;
		
		$_dd_class = '';
		//echo '<pre>field'; print_r($field); echo '</pre>';
		//echo '<pre>$field_set'; print_r($field_set); echo '</pre>';
		
		if( !empty($field_set[$field]['type']) && $field_set[$field]['type'] == 'upload' ){
			echo '</dl><div class="'.$field.' image_type_dd">';
			echo wp_get_attachment_image( $value, $field_set[$field]['size'] );
			echo '</div><dl>';
		}else{
		
			
			if( !empty($field_set[$field]['display']) && $field_set[$field]['display'] !== 'false' ){
				echo '<dt class="'.$field.'">';
				echo !empty($field_set[$field]['label']) ? esc_attr($field_set[$field]['label'] ) : '' ;
				echo '</dt>';
			}else{
				echo '<dt class="hidden '.$field.'">';
				echo !empty($field_set[$field]['label']) ? esc_attr($field_set[$field]['label'] ) : '' ;
				echo '</dt>';
				$_dd_class = ' none_dt';
			}
			
			echo '<dd class="'.$field.$_dd_class.'">';
				echo !empty($value) ? wpautop( $value ) : '' ;
				//echo '<pre>fields'; print_r($value); echo '</pre>';
			echo '</dd>';
		}
	}
	
	echo '</dl>';
	
	
	echo '
	<div class="text-center shop_menu_check">
		<input id="menu_reserve_option-'.$key.'" type="checkbox" name="menu_reserve_option[]" value="%%'.$key.'%%'.$item['menu_name'] .'">
		<label for="menu_reserve_option-'.$key.'"><span>追加する</span></label>
	</div>
	';
	
	echo '</div>';
}
echo '</div>';


?>