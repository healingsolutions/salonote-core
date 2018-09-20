<?php


/*

typeがセレクト・ラジオ・チェックの項目を抽出して、そのチャートを表示する
*/
global $mailform_fields;
global $post;
$post_id = $post->ID;


function chart_data($counter=0,$title=null,$data_item_arr=null){
  echo '
  <div class="chart_block" style="display:inline-block; width:33%">
  <canvas id="mailform_essence_chart-'.$counter.'" width="200" height="200"></canvas>
  </div>
  ';
    ?>
    <script>
    var ctx = document.getElementById("mailform_essence_chart-<?php echo $counter;?>");
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [<?php
            foreach($data_item_arr as $data_label => $data_item){
              echo '"'.$data_label.'",';
            };?>],
            datasets: [{
                label: '<?php echo $title; ?>',
                data: [<?php
                foreach($data_item_arr as $data_label => $data_item){
                  echo count($data_item) .',';
                };
                ?>],
                backgroundColor: [<?php
                
                $color_code = mailform_essence_hex2rgb( sprintf("#%06x",rand(0x000000, 0xFFFFFF)) );
                $color_counter = 0;
                foreach($data_item_arr as $key => $data_label){
                  ++$color_counter;
                  //echo 1-($color_counter/count($data_item_arr))*0.1;
                  echo '"rgba('.$color_code[0].','.$color_code[1].','.$color_code[2].','. round(((10-count($data_item_arr))/$color_counter)*0.1,2).')",';
                };
                ?>],
                borderColor: [<?php
                foreach($data_item_arr as $data_label){
                  echo '"'.sprintf("#%06x",rand(0x000000, 0xFFFFFF)).'",';
                };
                ?>],
                borderWidth: 0
            }]
        },
        options: {
            title: {
                display: true,
                text: '<?php echo $title; ?>'
            }
        }

    });
    </script>


    <?php
}


global $post;


//初期化
$chart_data = [];

//echo '<pre>'; print_r($mailform_fields[0]); echo '</pre>';




//まずはチャートにする項目を配列に振り直す
if( empty($mailform_fields[0]) ){
  return;
}

foreach( $mailform_fields[0] as $key => $value ){
  if( !empty( $value['type']  ) )
  if( $value['type'] === 'radio' || $value['type'] === 'checkbox' || $value['type'] === 'select' ){
    $field_name[] = $value['name'];
  }
}

if( empty($field_name) ){
  return;
}

//このフォームに関連するコンタクトから、投稿を抽出してチャートデータを生成する
$args = array(
    'post_type'   => 'es_contact',
    'showposts'   => -1,
    'post_parent' => $post->ID
);
$requested_posts = query_posts($args);
//echo '<pre>'; print_r($requested_posts); echo '</pre>';

if( count($requested_posts) == 0 ){
  return;
}

echo '<h1>解析データ</h1>';
foreach( $requested_posts as $post ){
  $post_fields = get_post_meta($post->ID,'post_fields');

  //echo '<pre>'; print_r($post_fields); echo '</pre>';

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
//echo '<pre>'; print_r($chart_data); echo '</pre>';
$counter = 0;
foreach($chart_data as $label => $data_item_arr){
  ++$counter;
  chart_data($counter,$label,$data_item_arr);
}

wp_reset_query();
?>
<div>
<a class="button-primary" href="<?php echo MAILFORM_ESSENCE_PLUGIN_URI;?>/module/download_csv.php?download&id=<?php echo $post_id;?>">CSVダウンロード</a>
</div>