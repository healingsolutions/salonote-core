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

global $shop_field_array;
$shop_field_array = array(
	'shop_name' => array(
      'label'       => 'Shop Name',
      'type'        => 'text'
  ),
	'google_map' => array(
      'label'       => 'GoogleMap',
      'description' => __('You can use shortcode [GoogleMap]','salonote-essence'),
      'type'        => 'textarea'
  ),
  'tel_number' => array(
      'label'       => __('Phone Number','salonote-essence'),
      'type'        => 'text'
  ),
  'fax_number' => array(
      'label'       => __('FAX Number','salonote-essence'),
      'type'        => 'text'
  ),
  'zip_code' => array(
      'label'       => __('ZipCode','salonote-essence'),
      'type'        => 'text'
  ),
  'contact_address' => array(
      'label'       => __('Address','salonote-essence'),
      'type'        => 'text'
  ),
	'biz_time' => array(
      'label'       => __('Business Time','salonote-essence'),
      'type'        => 'textarea'
  ),
	'biz_holiday' => array(
      'label'       => __('Business Holiday','salonote-essence'),
      'type'        => 'textarea'
  ),
	'biz_parking' => array(
      'label'       => __('Business Parking','salonote-essence'),
      'type'        => 'textarea'
  ),
	'biz_message' => array(
      'label'       => __('Business Message','salonote-essence'),
      'type'        => 'textarea'
  ),
);



add_action ( 'shop_edit_form_fields', 'extra_shop_taxonomy_fields');
function extra_shop_taxonomy_fields( $tag ) {
    $t_id = $tag->term_id;
    $shop_tax_meta = get_option( "shop_tax_$t_id" );
	
	global $shop_field_array;
	?>

<tr class="form-field">
    <th><label for="shop_tax_meta-page">紹介ページ</label></th>
    <td>
			<?php
			echo '<input id="shop_tax_meta-page" type="text" size="36" name="shop_tax_meta[page]" value="'. (isset ( $shop_tax_meta['page']) ? esc_html($shop_tax_meta['page']) : '') .'" />';
			?>
        
    </td>
</tr>

<?php
	
	
	foreach( $shop_field_array as $key => $value ){
		?>
<tr class="form-field">
    <th><label for="shop_tax_meta-<?php echo $key; ?>"><?php echo $value['label']; ?></label></th>
    <td>
			<?php
		if( $value['type'] === 'textarea' ){
			echo '<textarea id="shop_tax_meta-'.$key.'" rows="5" name="shop_tax_meta['.$key.']">'. (isset ( $shop_tax_meta[$key]) ? esc_html($shop_tax_meta[$key]) : '') .'</textarea>';
		}elseif( $value['type'] === 'text' ){
			echo '<input id="shop_tax_meta-'.$key.'" type="text" size="36" name="shop_tax_meta['.$key.']" value="'. (isset ( $shop_tax_meta[$key]) ? esc_html($shop_tax_meta[$key]) : '') .'" />';
		}
			?>
        
    </td>
</tr>
		<?php
	}
	
?>

<?php
}
add_action ( 'edited_term', 'save_extra_shop_taxonomy_fileds');
function save_extra_shop_taxonomy_fileds( $term_id ) {
    if ( isset( $_POST['shop_tax_meta'] ) ) {
       $t_id = $term_id;
       $shop_tax_meta = get_option( "shop_tax_$t_id");
       $cat_keys = array_keys($_POST['shop_tax_meta']);
          foreach ($cat_keys as $key){
          if (isset($_POST['shop_tax_meta'][$key])){
             $shop_tax_meta[$key] = $_POST['shop_tax_meta'][$key];
          }
       }
       update_option( "shop_tax_$t_id", $shop_tax_meta );
    }
}


?>