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
add_action('admin_menu', 'add_essence_shop_menu_fields');
function add_essence_shop_menu_fields(){
    add_meta_box('essence_shop_menu_fields', '店舗メニュー', 'insert_essence_shop_menu_fields', 'menu_fields', 'normal', 'high');
}


//insert form
function insert_essence_shop_menu_fields(){
	 global $post;
	 wp_nonce_field(wp_create_nonce(__FILE__), 'essence_shop_menu_nonce');
  
$shop_menu_fields = get_post_meta($post->ID, 'essence_shop_menu_fields',true);
$opt['set'] = !empty($shop_menu_fields['set']) ? $shop_menu_fields['set'] : 'salon' ;
$opt['fields'] = !empty($shop_menu_fields['fields']) ? $shop_menu_fields['fields'] : null ;
?>
  
<table class="form-table">


<tr valign="top">
  <th scope="row"><label for="inputtext">選択肢の基本セット</label></th>
  <td>
		<?php
			$set_arr = array(
				'salon' 		 => 'サロン',
				'cafe'			 => 'カフェ',
				'restaurant' => 'レストラン',
				'hair' 			 => 'ヘアサロン',
				'hp_beauty'	 => 'ホットペッパーBeauty',
				'reset' 		 => 'なし',
			);
		?>
		<select name="essence_shop_menu_fields[set]">
			<?php
			foreach( $set_arr as $key => $value ){
				echo '<option value="'.$key.'"';
				if( $opt['set'] == $key ){ echo ' selected'; };
				echo '>'.$value.'</option>';
			}
			?>
		</select>
		<p class="hint">下にフィールドが入っている場合は、上書きされません。一度全て削除して、保存し直してください。</p>
  </td>
</tr>


</table>

<?php
$shop_menu_fields = $opt['fields'];

//フィールドに値が入っていなくて、選択肢のタイプが設定されているときは、それを尊重する
if( empty($shop_menu_fields) && !empty($opt['set']) ){
	switch ($opt['set']) {
		case 'salon':
			$fields_arr = array(
					'menu_name'				=> array('表示名','text'),
					'menu_headline'		=> array('見出し','text'),
					'menu_price'			=> array('料金','text','true'),
					'menu_campaing'		=> array('キャンペーン価格','text','true'),
					'menu_time'				=> array('所要時間','text','true'),
					'menu_category'		=> array('カテゴリ','text'),
					'menu_recommend'	=> array('こんな方にオススメ','textarea','true'),
					'menu_excerpt'		=> array('説明','textarea'),
					'menu_assets'		  => array('画像','upload',false,'thumbnail'),
			);
		break;
			
		case 'cafe':
		case 'restaurant':
			$fields_arr = array(
					'menu_name'				=> array('表示名','text'),
					'menu_price'			=> array('料金','text','true'),
					'menu_category'		=> array('カテゴリ','text'),
					'menu_excerpt'		=> array('説明','textarea'),
					'menu_assets'		  => array('画像','upload'),
			);
		break;
			
		case 'hair':
			$fields_arr = array(
					'menu_name'				=> array('表示名','text'),
					'menu_headline'		=> array('見出し','text'),
					'menu_price'			=> array('料金','text','true'),
					'menu_campaing'		=> array('キャンペーン価格','text'),
					'menu_headline'		=> array('髪の長さ','select','true','S
M
L
それ以上'),
					'menu_time'				=> array('所要時間','textarea'),
					'menu_category'		=> array('カテゴリ','text'),
					'menu_recommend'	=> array('こんな方にオススメ','textarea'),
					'menu_excerpt'		=> array('説明','textarea'),
					'menu_assets'		  => array('画像','upload'),
			);
		break;
	}
	
	$shop_menu_fields = [];
	$counter = 0;
	foreach( $fields_arr as $key => $value ){
		
		$shop_menu_fields[$counter]['menu_field']   = $key;
		$shop_menu_fields[$counter]['menu_label']   = !empty($value[0]) ? $value[0] : null ;
		$shop_menu_fields[$counter]['menu_type'] 	  = !empty($value[1]) ? $value[1] : null ;
		$shop_menu_fields[$counter]['menu_display'] = !empty($value[2]) ? $value[2] : null ;
		$shop_menu_fields[$counter]['menu_values']  = !empty($value[3]) ? $value[3] : null ;

		++$counter;
	}
	
}
	
if(is_user_logged_in()){
	//echo '<pre>'; print_r($shop_menu_fields); echo '</pre>';
}
$custom_sizes = get_intermediate_image_sizes();
$custom_sizes_txt = '';
foreach( $custom_sizes as $key=>$value ){
	$custom_sizes_txt .= $value.':'.__($value,'salonote-essence').PHP_EOL;
}

	
$menu_field_arr = array(
		'menu_field'		=> array('フィールド名(半角英数)','text'),
		'menu_label'		=> array('表示名','text'),
		'menu_type'			=> array('タイプ','select',
'text:テキスト
textarea:テキストエリア
select:セレクト
upload:画像'),
		'menu_display'		=> array('ラベルを表示','select','false:しない
true:する'),
		'image_size'		=> array('画像サイズ','select',$custom_sizes_txt),
		'menu_values'		=> array('選択肢','textarea'),
	);

  
  $repeat_field = '
  <div class="doraggable-fields">
  <div id="shop_menu_form___name__"><span class="shop_menu_number">__name__label__</span>
  ';
	

	
	foreach( $menu_field_arr as $key => $value ){
		
		$repeat_field .= '<div class="shop_menu_form_item '.$key.'-item">';
		$repeat_field .= '<label for="shop_menu_form___name___">'.$value[0].'</label>';
		switch ($value[1]) {
			case 'text':
				$repeat_field .= '
				<input type="text" id="shop_menu_form___name__" name="essence_shop_menu_fields[fields][__name__]['.$key.']" />';
			break;
				
			case 'textarea':
				$repeat_field .= '
				<textarea id="shop_menu_form___name__" name="essence_shop_menu_fields[fields][__name__]['.$key.']" rows="1"></textarea>';
			break;
				
			case 'checkbox':
				$repeat_field .= '
				<input type="checkbox" id="shop_menu_form___name__" name="essence_shop_menu_fields[fields][__name__]['.$key.']" value="1" />';
			break;
				
			case 'select':

				if( !empty($value[2]) ){
					

					$select_arr = br2array($value[2]);

					
				$repeat_field .= '
				<select class="select_field" id="shop_menu_form___name__" name="essence_shop_menu_fields[__name__]['.$key.']">';
				
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
					<div id="es_menu_image_upload_buttons">
					<a id="shop_menu_form___name__" type="button" class="button shop_menu_image_upload" title="画像を追加・変更">アイテム画像の追加・削除</a>
					</div>';
			break;
		}
		
		$repeat_field .= '</div>';
		
	}
	

  $repeat_field .= '  
  </div>
  </div>';
  
  $repeat_field = htmlspecialchars($repeat_field);
  
  
  echo '
	<div>
  <div id="shop_menu_form" data-prototype="'.$repeat_field.'" class="sfPrototypeMan ui-sortable">';

	
	if( empty($shop_menu_fields) ){
		$shop_menu_fields = [];
		foreach($menu_field_arr as $key => $value){
			$shop_menu_fields[0][$key] = '';
		}
	}

	foreach( $shop_menu_fields as $key => $items ){

		echo '
		<div class="doraggable-fields">
			<div id="shop_menu_form_'.$key.'"><span class="shop_menu_number">'.$key.'</span>';
		
		foreach( $menu_field_arr as $field_key => $field_value ){
			
			echo '<div class="shop_menu_form_item '.$field_key.'-item"';
			if(
				($field_key == 'image_size'  && !empty($items['menu_type']) && $items['menu_type'] == 'upload') ||
				($field_key == 'menu_values' && !empty($items['menu_type']) && $items['menu_type'] == 'select')
			){
				echo ' style="display: inline-block;"';
			}
			echo '>';

			
			echo '<label for="shop_menu_form_'.$key.'">'.$field_value[0].'</label>';
		
			switch ($field_value[1]) {
				case 'text':
					echo '
					<input type="text" id="shop_menu_form_'.$key.'" name="essence_shop_menu_fields[fields]['.$key.']['.$field_key.']"  value="'.esc_attr($items[$field_key]).'">';
				break;

				case 'textarea':
					echo '
					<textarea id="shop_menu_form_'.$key.'" name="essence_shop_menu_fields[fields]['.$key.']['.$field_key.']" rows="1">'.esc_attr($items[$field_key]).'</textarea>';
				break;

				case 'checkbox':
					echo '
					<input type="checkbox" id="shop_menu_form_'.$key.'" name="essence_shop_menu_fields[fields]['.$key.']['.$field_key.']" value="1" '.( isset($items[$field_key]) ? ' checked' : '').' />';
				break;
					
				case 'select':
					

					if( !empty($field_value[2]) ){
						$select_arr = br2array($field_value[2]);


						echo '<select id="shop_menu_form___name__" name="essence_shop_menu_fields[fields]['.$key.']['.$field_key.']">';

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
					<div id="es_menu_image_upload_buttons">
					<a id="shop_menu_form_'.$key.'" type="button" class="button shop_menu_image_upload" title="画像を追加・変更">アイテム画像の追加・削除</a>
					</div>';
					
					if( !empty($items[$field_key]) ){
						echo '
						<p class="shop_menu_img" id=img_'.$items[$field_key].'>
						<a href="#" class="shop_menu_image_remove" title="画像を削除する"></a>
						<img src="'.wp_get_attachment_thumb_url($items[$field_key]).'" />
						<input type="hidden" name="essence_shop_menu_fields[fields]['.$key.'][menu_assets]" value="'.$items[$field_key].'" />
						</p>';
					}

				break;
			}
			
			echo '</div>';
		}
		
			

		echo'
			</div>
		</div>
		';
	}
        
                
  echo '
      </div>
  </div>
  ';
	?>




<?php
}

//save action
add_action('save_post', 'save_essence_shop_menu_fields');
function save_essence_shop_menu_fields($post_id){
	$essence_shop_menu_nonce = isset($_POST['essence_shop_menu_nonce']) ? $_POST['essence_shop_menu_nonce'] : null;
  
	if(!wp_verify_nonce($essence_shop_menu_nonce, wp_create_nonce(__FILE__))) {
		return $post_id;
	}
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post_id;
  }
  
	if(!current_user_can('edit_post', $post_id)) {
    return $post_id;
  }

 
	$data = $_POST['essence_shop_menu_fields'];
 
	if(get_post_meta($post_id, 'essence_shop_menu_fields') == ""){
		add_post_meta($post_id, 'essence_shop_menu_fields', $data, true);
    
	}elseif($data != get_post_meta($post_id, 'essence_shop_menu_fields', true)){
		update_post_meta($post_id, 'essence_shop_menu_fields', $data);
    
	}elseif($data == ""){
		delete_post_meta($post_id, 'essence_shop_menu_fields', get_post_meta($post_id, 'essence_shop_menu_fields', true));
	}
}


?>
