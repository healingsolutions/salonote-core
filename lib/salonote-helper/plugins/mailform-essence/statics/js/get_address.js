// JavaScript Document

jQuery(function($){
  $('#get_address').click(function(){
    var zipcord = $('#zipcord').val(); //郵便版番号入力値 名前はそれぞれ
    if (zipcord != "" ){
      //loadingとか入れたいとき用　使用時は //を外します
      //$('#loading_address').fadeIn();
      $.ajaxSetup({
      // IE対策 キャッシュクリア
      cache: false, });
      $.ajax({
        type: 'GET',
        url: 'function/get_address.php?zipcord='+zipcord,
        datatype: 'json',
        success: function(json){
          $.each(json, function(i, item){
          $('#address').val(item.location1);
          //$('#loading_address').fadeOut();//loadingとか入れた人はこいつで読み込み後消せます。
          });
        }, error: function(){
          // $('#loading_address').fadeOut();//loadingとか入れた人はこいつで読み込み後消せます。
          alert('error');
        }
      });
    } else {
    alert('error');
    }
  });
});