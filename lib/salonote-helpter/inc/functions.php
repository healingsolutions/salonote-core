<?php

/*=========================================================
// public css
----------------------------------------------------------*/
function salonote_essence_helper_head_enqueue() {
  global $theme_opt;
  
  
  if(!is_admin()){
    wp_deregister_script('jquery');
    wp_deregister_script('jquery-migrate');
  }
  
  //jQuery
  wp_enqueue_script('jquery','//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '3.2.1', true);

}
add_action( 'wp_enqueue_scripts', 'salonote_essence_helper_head_enqueue' ,1);




//===============================================
// edit the content
add_filter('the_content', 'edit_content_hook',10);
function edit_content_hook($content){

	
	if ( !wp_is_mobile() ) {

		require_once( SALONOTE_HELPER__PLUGIN_PATH. '/phpQuery/phpQuery-onefile.php' );
 
		$doc = phpQuery::newDocumentHTML($content);

		$counter = 0;
		foreach($doc->find('.block-unit') as $block_unit) {
			
			if( pq($block_unit)->next('.block-unit')->length && pq($block_unit)->prev('.block-group')->length == 0 ) {
				pq($block_unit)->removeClass('block-unit');
				pq($block_unit)->addClass('block-group block-index-'.$counter);
			}
			if( pq($block_unit)->prev('.block-group')->length && pq($block_unit)->next('.block-group')->length == 0 ) {
				pq($block_unit)->removeClass('block-unit');
				pq($block_unit)->addClass('block-group block-index-'.$counter);
			}
			if( pq($block_unit)->next('.block-unit')->length == 0 ) {
				++$counter;
			}
		}

		for ($count = 0; $count < $counter; $count++){
			$length = 0;

			$length = $doc->find('.block-index-'.$count)->length;
			if( $length >= 6 ) $length = ($length%6)+6;
			foreach($doc->find('.block-index-'.$count) as $group_col) {
				pq($group_col)->addClass('group-col-'. $length );
			}
			
		}
	
		for ($count = 0; $count < $counter; $count++){
			
			foreach($doc->find('.block-index-'.$count) as $group_col) {
				if( pq($block_unit)->parent('.block-group-wrap')->length == 0 ) {
					pq($group_col)->wrapInner('<div class="block-item-inner"><div class="block-content"></div></div>');
				}
			}
		}
	
		for ($count = 0; $count < $counter; $count++){
					pq('.block-index-'.$count)->wrapAll('<div class="block-group-wrap" />');
		}

		return do_shortcode($doc); //only pc
	}
	return do_shortcode($content); //only sp
}

?>