<?php


/* Plugin Name: mailform essence TinyMCE Buttons */
add_action( 'admin_init', 'character_essence_tinymce_button',100000 );

function character_essence_tinymce_button() {
  if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
    add_filter( 'mce_buttons', 'character_essence_register_tinymce_button' );
    add_filter( 'mce_external_plugins', 'character_essence_add_tinymce_button' );
  }
}


// ボタンの追加
//add_filter('mce_buttons_3', 'character_essence_register_tinymce_button');
function character_essence_register_tinymce_button($buttons) {

   array_push($buttons, 'character_essence');
   return $buttons;
}

// TinyMCEプラグインの追加
//add_filter('mce_external_plugins', 'character_essence_add_tinymce_button');
function character_essence_add_tinymce_button($plugin_array) {
   $plugin_array['character_essence'] = CHARACTER_ESSENCE_PLUGIN_URI.'/tinymce/character_essence_buttons.js';
   return $plugin_array;
}


function character_essence_tinymce($initArray){
  $initArray[ 'toolbar3' ] .= ',character_essence';

  return $initArray;
}
add_filter('tiny_mce_before_init', 'character_essence_tinymce',20);

?>