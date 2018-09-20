<?php


/* Plugin Name: mailform essence TinyMCE Buttons */
add_action( 'admin_init', 'shop_menu_essence_tinymce_button',100000 );

function shop_menu_essence_tinymce_button() {
  if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
    add_filter( 'mce_buttons', 'shop_menu_essence_register_tinymce_button' );
    add_filter( 'mce_external_plugins', 'shop_menu_essence_add_tinymce_button' );
  }
}


// ボタンの追加
//add_filter('mce_buttons_3', 'shop_menu_essence_register_tinymce_button');
function shop_menu_essence_register_tinymce_button($buttons) {

   array_push($buttons, 'shop_menu_essence');
   return $buttons;
}

// TinyMCEプラグインの追加
//add_filter('mce_external_plugins', 'shop_menu_essence_add_tinymce_button');
function shop_menu_essence_add_tinymce_button($plugin_array) {
   $plugin_array['shop_menu_essence'] = SHOP_MENU_ESSENCE_PLUGIN_URI.'/tinymce/shop_menu_essence_buttons.js';
   return $plugin_array;
}


function shop_menu_essence_tinymce($initArray){
  $initArray[ 'toolbar2' ] .= ',shop_menu_essence';

  return $initArray;
}
add_filter('tiny_mce_before_init', 'shop_menu_essence_tinymce',20);

?>