<?php

$theme_mods =get_theme_mods();
echo '<style>';
foreach($theme_mods as $key => $color){
  if(strpos($key,'color') !== false && isset($color) ){
    echo '.'.$key.'{ color: '.$color.' };';
    $color_set[$key] = $color;
  }elseif(strpos($key,'bkg') !== false && isset($color) ){
    echo '.'.$key.'{ background-color: '.$color.' };';
  }
}
echo '</style>';
