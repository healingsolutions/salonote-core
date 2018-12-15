<?php
// add style Gutenberg
define('GUTENBERG_PLUGIN_PATH' , dirname(__FILE__)  );

$module_url = preg_replace( '/https?\:/', '', get_template_directory_uri().'/lib/module');
define('GUTENBERG_PLUGIN_URI'  , $module_url.'/gutenberg'  );

add_action( 'enqueue_block_editor_assets', function () {
   wp_enqueue_style( 'salonote_plugin', GUTENBERG_PLUGIN_URI .'/assets/css/salonote-gutenberg.css');
   wp_enqueue_script( 'salonote_plugin', GUTENBERG_PLUGIN_URI. '/assets/js/salonote-guenberg.js',[
      'wp-element',
      'wp-rich-text',
      'wp-editor',
   ] );
   wp_localize_script( 'salonote_plugin', 'salonote_plugin_obj', [
      'title' => 'Salonote Plugin',
      'class' => 'line_marker',
   ] );
} );

?>