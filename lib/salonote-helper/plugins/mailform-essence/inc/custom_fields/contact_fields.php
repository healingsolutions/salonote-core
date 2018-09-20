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
add_action('admin_menu', 'add_essence_es_contact');
function add_essence_es_contact(){
    add_meta_box('essence_es_contact', 'お問い合わせ内容', 'insert_essence_es_contact', 'es_contact', 'normal', 'high');
}


function insert_essence_es_contact(){
  global $post;
  $post_fields = get_post_meta($post->ID, 'post_fields',true);


  if( !empty($post_fields) && is_array( $post_fields ) ){
    
    $page = get_page($post->ID);
    $slug = $page->post_name;
    
    echo '<link rel="stylesheet" href="'.MAILFORM_ESSENCE_PLUGIN_URI.'/statics/css/mailform-essence.css" type="text/css" media="all" />';
    echo '<table id="essence-mailform-contact-table" class="table table-bordered table-striped"><tbody>';
    foreach( $post_fields as $label => $value ){
      
      if( empty( $value['value']) ) continue;
        
        if( is_array($value['value']) ){
          echo '<tr><th class="text-left">'.$value['name'].'</th><td>';
          foreach( $value['value'] as $sub_label => $sub_field_item ){
            echo $sub_field_item .'<br>';
          }
          echo '</td></tr>';
          
        }else{
          echo '
            <tr>
            <th class="text-left">'.$value['name'].'</th>
            <td>'.$value['value']. ($label === 'send_count' ? '秒' : '' ).'</td>
            </tr>';
        }
    }
    
    echo '
      <tr>
      <th class="text-left">お問合せ日時</th>
      <td>'.get_the_date('Y-m-d H:i:s',$post->ID).'</td>
      </tr>
      <tr>
      <th class="text-left">お問合せチケット</th>
      <td>'.$slug.'</td>
      </tr>';
    
    echo '<tbody></table>';
    
    //投稿から画像リストを取得
      $image_args = array(
        'post_type'   => 'attachment',
        'numberposts' => -1,
        //'post_status' => null,
        'post_parent' => $post->ID,
      );
      $attachments = get_posts( $image_args );
      if ( $attachments ) {
        echo '<div class="es_contact-attachment-block">';
        foreach ( $attachments as $attachment ) {
          $image_src = wp_get_attachment_image_src( $attachment->ID , 'large' );
          if($image_src[0]){
            echo '<a class="colorbox" href="'. $image_src[0] . '"><div class="thumbnail-block thumbnail">';
            echo wp_get_attachment_image( $attachment->ID, 'thumbnail', false );
            echo '</div></a>';
          }
        }
        echo '</div>';
      }
    
  }
  
  
}


?>
