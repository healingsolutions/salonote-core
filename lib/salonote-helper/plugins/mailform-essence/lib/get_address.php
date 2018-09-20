<?php

$zipcord ="";
$user= array();
if(isset($_GET["zipcord"])){
$zipcord =$_GET["zipcord"];
}
if(!empty($zipcord)){
$data = 'http://api.zipaddress.net/?zipcode='. $zipcord;

  
$json = @file_get_contents($data);
if ($json == false) {
echo "false";
return;
}
$obj = json_decode($json,true);

//echo '<pre>'; print_r($obj); echo '</pre>';
  
$count =count($obj['data']);
for ($a=0;$a<$count;$a++){
  //都道府県名
  if($obj['data']['pref']){
    $pref = $obj['data']['pref'];
  }
  //郡
  if($obj['data']['address']){
    $address = $obj['data']['address'];
  }
  //市
  if($obj['data']['city']){
    $city = $obj['data']['city'];
  }
  //区
  if($obj['data']['town']){
    $town = $obj['data']['town'];
  }
  //以下
  if($obj['data']['fullAddress']){
    $fullAddress = $obj['data']['fullAddress'];
  }
}
$user[] = array(
'location1' => $fullAddress
);
//jsonとして出力
header('Content-type: application/json');
echo json_encode($user);
}

?>