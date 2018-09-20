<?php


/* Plugin Name: mailform essence TinyMCE Buttons */
add_action( 'admin_init', 'mailform_essence_tinymce_button',100000 );

function mailform_essence_tinymce_button() {
  if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
    add_filter( 'mce_buttons', 'mailform_essence_register_tinymce_button' );
    add_filter( 'mce_external_plugins', 'mailform_essence_add_tinymce_button' );
  }
}


// ボタンの追加
//add_filter('mce_buttons_3', 'mailform_essence_register_tinymce_button');
function mailform_essence_register_tinymce_button($buttons) {

   array_push($buttons, 'mailform_essence');
   return $buttons;
}

// TinyMCEプラグインの追加
//add_filter('mce_external_plugins', 'mailform_essence_add_tinymce_button');
function mailform_essence_add_tinymce_button($plugin_array) {
   $plugin_array['mailform_essence'] = MAILFORM_ESSENCE_PLUGIN_URI.'/tinymce/mailform_essence_buttons.js';
   return $plugin_array;
}


function mailform_essence_tinymce($initArray){
  $initArray[ 'toolbar3' ] .= ',mailform_essence';

  return $initArray;
}
add_filter('tiny_mce_before_init', 'mailform_essence_tinymce',20);

?>