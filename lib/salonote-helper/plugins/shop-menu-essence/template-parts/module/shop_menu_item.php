<?php
global $list_type;


echo '<table class="table"><tbody>';
foreach( $shop_menu_arr as $key => $item ){
	
	if( !empty($search) ){
		$search_match = false;
		foreach( $item as $field => $value ){
			
			if( strpos($value,$search) !== false ){
				//echo '<p>'.$value.':'.$search.' match</p>';
				$search_match = true;
				continue;
			}
		}
		
		if( !$search_match ){
			continue;
		}
	}
	
	
	// check menu item price
	$menu_price =  !empty($item['menu_price']) ? $item['menu_price'] : 0 ;
	$item_price =  !empty($item['menu_global_price']) ? $item['menu_global_price'] : $item['menu_price'] ;
	$item_price = preg_replace('/[^0-9]/', '', $item_price);
	
	$menu_time =  !empty($item['menu_time']) ? $item['menu_time'] : 0 ;
	$menu_time = preg_replace('/[^0-9]/', '', $menu_time);	

	$field_images = 0;
	foreach( $item as $field => $value ){
		if( !empty($field_set[$field]['type']) && $field_set[$field]['type'] == 'upload' ){
			if( !empty($value) ) ++$field_images;	
		}
	}

	echo '<tr>';
	foreach( $item as $field => $value ){
		if( empty($value) || $field === 'menu_global_name' || $field === 'menu_global_price' || $field === 'menu_global_option' || $field === 'menu_global_reserve' ) continue;
			echo '<td class="'.$field.'">';
				echo !empty($value) ? wpautop( $value ) : '' ;
				//echo '<pre>fields'; print_r($value); echo '</pre>';
			echo '</td>';
	}
	
	echo '</tr>';
}
echo '</tbody></table>';


if(is_user_logged_in()){
	//echo '<pre>field_set'; print_r($field_set); echo '</pre>';
	//echo '<pre>menu_post'; print_r($menu_post); echo '</pre>';
}


?>