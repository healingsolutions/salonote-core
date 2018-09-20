<?php

if (isset($_GET['download']) && isset($_GET['id']) ) {
  
    
  
    //パス
    require( '../../../../wp-blog-header.php');
  
    $post_id = $_GET['id'];
    $title = get_the_title($post_id);
    $mailform_fields = get_post_meta($post_id, 'essence_mailform');


    header('Content-Disposition: attachment; filename='.$title.'.csv');
    header('Content-Type: text/csv');
  
    
    $rows = array();
  
  
    //まずはチャートにする項目を配列に振り直す
    foreach( $mailform_fields[0] as $key => $value ){
      if( $value['type'] === 'radio' || $value['type'] === 'checkbox' || $value['type'] === 'select' ){
        $field_name[] = $value['name'];
      }
    }
  
    $args = array(
        'post_type'   => 'es_contact',
        'showposts'   => -1,
        'post_parent' => $post_id
    );
    $requested_posts = query_posts($args);
  
    foreach( $requested_posts as $post ){
      $post_fields = get_post_meta($post->ID,'post_fields');

      foreach( $post_fields[0] as $label => $item ){
        if( in_array($label , $field_name) ){
          if(is_array($item)){
            foreach( $item as $sub_label => $sub_item ){
              $chart_data[$label][$sub_item][] = true;
            }
          }else{
            $chart_data[$label][$item][] = true;
          }
        }
      }
    }
  
    foreach($chart_data as $label => $data_item_arr){
      foreach($data_item_arr as $data_label => $data_item){
        $rows[] = array(
          'title' => $label,
          'label' => $data_label,
          'count' => count($data_item)
          );
      };
    }

  
    //echo '<pre>'; print_r($rows); echo '</pre>';

    $fp = fopen('php://output', 'wb');
    foreach ($rows as $row) {
      //mb_convert_variables('SJIS-win', 'UTF-8', $row);
      fputcsv($fp, $row);
    }
    fclose($fp);
    exit;

}

?>
