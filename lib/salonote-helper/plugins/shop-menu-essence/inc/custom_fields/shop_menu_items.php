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

//add meta box
add_action('admin_menu', 'add_essence_shop_menu_item');
function add_essence_shop_menu_item(){
    add_meta_box('essence_shop_menu', '店舗メニュー', 'insert_essence_shop_menu_item', 'shop_menu', 'normal', 'high');
}


//insert form
function insert_essence_shop_menu_item(){
	global $post;
	wp_nonce_field(wp_create_nonce(__FILE__), 'essence_shop_menu_nonce');
	
	$shop_menu_import = get_post_meta($post->ID, 'shop_menu_import',true);
	if( !empty($shop_menu_import)){
		$shop_menu_import = unserialize($shop_menu_import);
		update_post_meta($post->ID, 'essence_shop_menu', $shop_menu_import);
		delete_post_meta($post->ID, 'shop_menu_import');
	}
	
  
  $shop_menu_items = get_post_meta($post->ID, 'essence_shop_menu',true);

	
	//options
	$shop_menu_essence_opt = get_option('shop_menu_essence_options');


	$shop_menu_type_id = get_post_meta($post->ID,'shop_menu_type',true);
	$args = array(
		'post_type'  => 'menu_fields',
		'posts_per_page' => -1,
	);
	$_menu_fields_posts = get_posts($args);

	
	if( empty( $shop_menu_type_id ) && count($_menu_fields_posts) == 0 ){
		echo 'メニューフィールドが登録されていません';
		return;
	}
	$shop_menu_fields_value = get_post_meta($shop_menu_type_id, 'essence_shop_menu_fields',true);
	
	
	
	$shop_menu_fields_arr = !empty( $shop_menu_fields_value ) ? $shop_menu_fields_value : get_post_meta($_menu_fields_posts[0]->ID, 'essence_shop_menu_fields',true) ;
	$shop_menu_fields = $shop_menu_fields_arr['fields'];
	
  if(is_user_logged_in()){
    //echo '<pre>shop_menu_fields'; print_r($shop_menu_fields); echo '</pre>';
		//echo '<pre>shop_menu_fields'; print_r($opt['fields']); echo '</pre>';
  }

	$menu_field_arr = [];
	/*
  $menu_field_arr = array(
		'menu_name'				=> array('表示名','text'),
		'menu_headline'		=> array('見出し','text'),
		'menu_price'			=> array('料金','textarea'),
		'menu_campaing'		=> array('キャンペーン価格','textarea'),
		'menu_time'				=> array('所要時間','textarea'),
		'menu_category'		=> array('カテゴリ','text'),
		'menu_recommend'	=> array('こんな方にオススメ','textarea'),
		'menu_excerpt'		=> array('説明','textarea'),
		//'menu_display'		=> array('表示','checkbox'),
		'menu_assets'		  => array('画像','upload'),
	);
	*/
	if( !empty($shop_menu_fields) ){
		foreach( $shop_menu_fields as $key => $value ){
			$menu_field_arr[$value['menu_field']] = array(
				$value['menu_label'],
				$value['menu_type'],
				$value['menu_values']
			);
		}
	}
	
	
	
	$repeat_field = '';

	
	
  
  $repeat_field .= '
  <div class="doraggable-fields">
  <div id="shop_menu_form___name__" class="shop_menu_form_item-unit"><span class="shop_menu_number">__name__label__</span>
  ';
	
	$repeat_field .= '<div class="shop_menu_essence-global-item">';
	$repeat_field .= '<div class="shop_menu_form_item item-type-text global_name-item">';
	$repeat_field .= '<label for="shop_menu_form___name___menu_global_name">メニュー名(管理用)</label>';
	$repeat_field .= '<input type="text" id="shop_menu_form___name___menu_global_name" name="essence_shop_menu[__name__][menu_global_name]" />';
	$repeat_field .= '</div>';
	
	$repeat_field .= '<div class="shop_menu_form_item item-type-text global_price-item">';
	$repeat_field .= '<label for="shop_menu_form___name___menu_global_price">設定価格(計算に使う場合は整数で入力)</label>';
	$repeat_field .= '<input type="number" id="shop_menu_form___name___menu_global_price" name="essence_shop_menu[__name__][menu_global_price]" />';
	$repeat_field .= '</div>';
	
	$repeat_field .= '<div class="shop_menu_form_item item-type-text global_option-item">';
	$repeat_field .= '<label for="shop_menu_form___name___menu_global_option">オプション</label>';
	$repeat_field .= '<select id="shop_menu_form___name___menu_global_option" name="essence_shop_menu[__name__][menu_global_option]">
	<option value="">無効</option>
	<option value="1">有効</option>
	</select>';
	$repeat_field .= '</div>';
	
	$repeat_field .= '<div class="shop_menu_form_item item-type-text global_reserve-item">';
	$repeat_field .= '<label for="shop_menu_form___name___menu_global_reserve">予約対象</label>';
	$repeat_field .= '<select id="shop_menu_form___name___menu_global_reserve" name="essence_shop_menu[__name__][menu_global_reserve]">
	<option value="">無効</option>
	<option value="1">有効</option>
	</select>';
	$repeat_field .= '</div>';
	$repeat_field .= '</div>';
	
	$repeat_field .= '<hr class="shop-menu-horizon">';
	
	
	$repeat_field .= '<div class="shop_menu_essence-menu-item">';
	foreach( $menu_field_arr as $key => $value ){
		
		$repeat_field .= '<div class="shop_menu_form_item item-type-'.$value[1].' '.$key.'-item">';
		$repeat_field .= '<label for="shop_menu_form___name___">'.$value[0].'</label>';

		
		switch ($value[1]) {
			case 'text':
				$repeat_field .= '
				<input type="text" id="shop_menu_form___name__" name="essence_shop_menu[__name__]['.$key.']" />';
			break;
				
			case 'textarea':
				$repeat_field .= '
				<textarea id="shop_menu_form___name__" name="essence_shop_menu[__name__]['.$key.']" rows="1"></textarea>';
			break;
				
			case 'checkbox':
					
					if( !empty($value[2]) ){
						$select_arr = br2array(value[2]);

						foreach($select_arr as $select_key => $select){
							if(strpos($select,':') !== false){
								$select_value = explode(":", $select); // とりあえず行に分割
							}else{
								$select_value = array($select,$select);
							}
							$repeat_field .= '<input type="checkbox" id="shop_menu_form_'.$key.'" name="essence_shop_menu[__name__]['.$key.'][]" value="'.$select_value[0].'"/>'.$select_value[1];
						}
					}else{
						$repeat_field .= '<p>選択肢が設定されていません</p>';	
					}

				break;
				
			case 'select':
				
				if( !empty($value[2]) ){

					$select_arr = br2array($value[2]);

					
				$repeat_field .= '
				<select id="shop_menu_form___name__" name="essence_shop_menu[__name__]['.$key.']">';
				$repeat_field .= '<option value="">---</option>';
				
				foreach($select_arr as $select_key => $select){
					if(strpos($select,':') !== false){
						$select_value = explode(":", $select); // とりあえず行に分割
					}else{
						$select_value = array($select,$select);
					}
					$repeat_field .= '<option value="'.$select_value[0].'">'.$select_value[1].'</option>';
				}
				
				$repeat_field .= '</select>';
				}
			break;
				
			case 'upload':
				$repeat_field .= '
				<a id="shop_menu_form___name__" type="button" class="button shop_menu_image_upload" title="画像を追加・変更">アイテム画像の追加・削除</a>
				画像ID:<input type="text" readonly id="shop_menu_form___name__" name="essence_shop_menu[__name__]['.$key.']" />
				';
			break;
		}
		
		$repeat_field .= '</div>';
		
	}
	$repeat_field .= '</div>';

  $repeat_field .= '  
  </div>
  </div>';
  
  $repeat_field = htmlspecialchars($repeat_field);
  
	
	echo '
	<div class="shop_menu_essence-more"><span class="dashicons dashicons-tagcloud"></span>詳細</div>
	<div class="shop_menu_essence-simple"><span class="dashicons dashicons-text"></span>シンプル</div>
	';
  
  echo '
	<div>
  <div id="shop_menu_form" data-prototype="'.$repeat_field.'" class="sfPrototypeMan ui-sortable">';

	
	if( empty($shop_menu_items) ){
		$shop_menu_items = [];
		foreach($menu_field_arr as $key => $value){
			$shop_menu_items[0][$key] = '';
		}
	}


	foreach( $shop_menu_items as $key => $items ){
		

		echo '
		<div class="doraggable-fields">
			<div id="shop_menu_form_'.$key.'" class="shop_menu_form_item-unit"><span class="shop_menu_number">'.$key.'</span>';
		
		
		$menu_label = !empty($items['menu_name']) ? $items['menu_name'] : '' ;
		
		echo '<div class="shop_menu_essence-global-item">';
			echo '<div class="shop_menu_form_item item-type-text global_name-item">';
			echo '<label for="shop_menu_form_'.$key.'_menu_global_name">メニュー名(管理用)</label>';
			echo '<input type="text" id="shop_menu_form_'.$key.'_menu_global_name" name="essence_shop_menu['.$key.'][menu_global_name]" value="'.(!empty($items['menu_global_price']) ? esc_attr($items['menu_global_name']) :$menu_label).'"/>';
			echo '</div>';

			echo '<div class="shop_menu_form_item item-type-text global_price-item">';
			echo '<label for="shop_menu_form_'.$key.'_menu_global_price">設定価格(計算に使う場合は整数で入力)</label>';
			echo '<input type="number" id="shop_menu_form_'.$key.'_menu_global_price" name="essence_shop_menu['.$key.'][menu_global_price]" value="'.(!empty($items['menu_global_price']) ? esc_attr($items['menu_global_price']) :'').'" />';
			echo '</div>';

			echo '<div class="shop_menu_form_item item-type-text global_option-item">';
			echo '<label for="shop_menu_form_'.$key.'_menu_global_option">オプション</label>';
			echo '<select id="shop_menu_form_'.$key.'_menu_global_option" name="essence_shop_menu['.$key.'][menu_global_option]">
			<option value="">無効</option>
			<option value="1"' .(!empty($items['menu_global_option']) ? ' selected' : '' ). '>有効</option>';
			echo '</select>';
			echo '</div>';

			echo '<div class="shop_menu_form_item item-type-text global_reserve-item">';
			echo '<label for="shop_menu_form_'.$key.'_menu_global_reserve">予約対象</label>';
			echo '<select id="shop_menu_form_'.$key.'_menu_global_reserve" name="essence_shop_menu['.$key.'][menu_global_reserve]">
			<option value="">---</option>
			<option value="1"' .(!empty($items['menu_global_reserve']) ? ' selected' : '' ). '>対象</option>';
			echo '</select>';
			echo '</div>';
		echo '</div>';
		
		echo '<hr class="shop-menu-horizon">';

		echo '<div class="shop_menu_essence-menu-item">';
		foreach( $menu_field_arr as $field_key => $field_value ){
						
			echo '<div class="shop_menu_form_item item-type-'.$field_value[1].' '.$field_key.'-item"">';
			echo '<label for="shop_menu_form_'.$key.'">'.$field_value[0].'</label>';
			
			//echo '$field_value[1]'.$field_value[1];
		
			switch ($field_value[1]) {
				case 'text':
					echo '
					<input type="text" id="shop_menu_form_'.$key.'" name="essence_shop_menu['.$key.']['.$field_key.']" value="'.(!empty($items[$field_key]) ? esc_attr($items[$field_key]) :'').'">';
				break;

				case 'textarea':
					echo '
					<textarea id="shop_menu_form_'.$key.'" name="essence_shop_menu['.$key.']['.$field_key.']" rows="1">'.(!empty($items[$field_key]) ? esc_attr($items[$field_key]) :'').'</textarea>';
				break;

				case 'checkbox':
					
					if( !empty($field_value[2]) ){
						$select_arr = br2array($field_value[2]);

						foreach($select_arr as $select_key => $select){
							if(strpos($select,':') !== false){
								$select_value = explode(":", $select); // とりあえず行に分割
							}else{
								$select_value = array($select,$select);
							}
							echo '<input type="checkbox" id="shop_menu_form_'.$key.'" name="essence_shop_menu['.$key.']['.$field_key.'][]" value="'.$select_value[0].'"';
							if( !empty($items[$field_key]) && $items[$field_key] == $select_value[0]){
								echo ' checked';
							}
							echo ' />'.$select_value[1];
						}
					}else{
						echo '<p>選択肢が設定されていません</p>';	
					}

				break;
					
				case 'select':

					if( !empty($field_value[2]) ){
						$select_arr = br2array($field_value[2]);

						echo '<select id="shop_menu_form_'.$key.'" name="essence_shop_menu['.$key.']['.$field_key.']">';
						echo '<option value="">---</option>';
						foreach($select_arr as $select_key => $select){
							if(strpos($select,':') !== false){
								$select_value = explode(":", $select); // とりあえず行に分割
							}else{
								$select_value = array($select,$select);
							}
							echo '<option value="'.$select_value[0].'"';
							if( !empty($items[$field_key]) && $items[$field_key] == $select_value[0] ){
								echo ' selected';
							}
							echo '>'.$select_value[1].'</option>';
						}
						echo '</select>';
					}else{
						echo '<p>選択肢が設定されていません</p>';	
					}
				break;
					
				case 'upload':
					echo '
					<a id="shop_menu_form_'.$key.'" type="button" class="button shop_menu_image_upload" title="画像を追加・変更">アイテム画像の追加・削除</a>
					';

					if( !empty($items[$field_key]) ){
						echo '
						<p class="shop_menu_img" id=img_'.$items[$field_key].'>
						<input type="hidden" name="essence_shop_menu['.$key.'][menu_assets]" value="'.$items[$field_key].'" />
						<a href="#" class="shop_menu_image_remove" title="画像を削除する"></a>
						<img src="'.wp_get_attachment_thumb_url($items[$field_key]).'" />
						</p>';
					}

				break;
			}
			
			echo '</div>';
		}
		echo '</div>';
			

		echo'
			</div>
		</div>
		';
	}
        
                
  echo '
      </div>
  </div>
  ';
	
	
	echo '
	<div class="shop_menu_essence-more"><span class="dashicons dashicons-tagcloud"></span>詳細</div>
	<div class="shop_menu_essence-simple"><span class="dashicons dashicons-text"></span>シンプル</div>
	';

	?>
	

	<table class="form-table">
		<tr>
			<th>インポート</th>
			<td><textarea class="large-text" name="shop_menu_import" rows="4"></textarea></td>
		</tr>
	</table>


	<table class="form-table">
		<tr>
			<th>エクスポート</th>
			<td><textarea class="large-text" name="shop_menu_export" rows="4" readonly><?php echo serialize($shop_menu_items); ?></textarea></td>
		</tr>
	</table>


<?php
}

//save action
add_action('save_post', 'save_essence_shop_menu_item');
function save_essence_shop_menu_item($post_id){
	$essence_shop_menu_nonce = isset($_POST['essence_shop_menu_nonce']) ? $_POST['essence_shop_menu_nonce'] : null;

	if( !empty($_POST['shop_menu_import']) ){
		update_post_meta($post_id, 'shop_menu_import', $_POST['shop_menu_import']);
	}
	
	if(!wp_verify_nonce($essence_shop_menu_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	
	
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }
  
	if(!current_user_can('edit_post', $post_id)) {
    return $post_id;
  }
	

	

 
	$data = $_POST['essence_shop_menu'];
 
	if(get_post_meta($post_id, 'essence_shop_menu') == ""){
		add_post_meta($post_id, 'essence_shop_menu', $data, true);
    
	}elseif($data != get_post_meta($post_id, 'essence_shop_menu', true)){
		update_post_meta($post_id, 'essence_shop_menu', $data);
    
	}elseif($data == ""){
		delete_post_meta($post_id, 'essence_shop_menu', get_post_meta($post_id, 'essence_shop_menu', true));
	}
}


?>
