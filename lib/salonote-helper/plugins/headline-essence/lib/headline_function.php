<?php



//本文からheadline_navクラスをリストアップ


add_filter( 'the_content','get_index_essence',10);
function get_index_essence( $content ) {
  global $post_type_set;


	if( !empty($post_type_set) && in_array('display_index_nav',$post_type_set) ){
		$check_index = true;
	}else{
		$check_index = false;
	}
  
 
  if(is_singular() && $check_index){
    $headline_list = [];

    preg_match_all('/<(h[1-6]|div) class="(.+)headline_nav(.+)?">(.+)<\/(h[1-6]|div)>/u', do_shortcode($content), $headline_list);

    list($plane,$before,$class_1,$class_2,$body,$after) = $headline_list;

    $search = $plane;
    $replace = array();
    $li_list = array();

    if(!empty($body) && !empty($headline_list)){

      foreach ($body as $key => $val) {
          $replace[] = sprintf('<div id="link%s" class="ancor headline_nav_item" rel="headline_nav_item-%s"><'.$before[$key].' class="'.$class_1[$key].' '.$class_2[$key].'">%s</'.$after[$key].'></div>', $key, $key, $val);
          $li_list[] = sprintf('<li id="headline_nav_item-%s"><a class="smoothscroll headline-type-'.$before[$key].'" href="#link%s">%s</a></li>', $key, $key, $val);
      }
      

      $word = mb_strlen(strip_tags($content));
      $m = floor($word / 600)+1;
      $time = ($m == 0 ? '' : $m) ;

      //目次部分
      $index_nav = null;
      $index_nav .= '<div class="index-nav-block clearfix">
                    <div class="menu_bkg menu_color can-toggle">目次</div>
                    <div class="index-nav-inner bdr-1 band_bkg">
                        この記事にはこんなことが書かれています';
      
       $index_nav .= '<ol class="list-icon">' .  implode("\n", $li_list) .'</ol>';
       $index_nav .= '<div>'.$word.'文字なので、およそ'.$time.'分で読み終わりそうです</div>
       </div>
      </div>
      ';

      $content = str_replace($search, $replace, do_shortcode($content));
			$content = $index_nav . $content;
    };
  }
  
    return $content;
}
?>
