<?php
global $_essence_mailform_setting;

  $_today = date('Y-m-d');
  $_start_date    = !empty( $_essence_mailform_setting['start_date'] )    ? $_essence_mailform_setting['start_date']   : '' ;
  $_end_date      = !empty( $_essence_mailform_setting['end_date'] )      ? $_essence_mailform_setting['end_date']     : '' ;
  
  $_private_date = $end_date;


/*
  if( $_private_essence_atts['display'] == 1 ){
    $display_limit = date('Y年m月d日',strtotime( $_private_date));
    $text = $_private_essence_atts['text'];
  }else{
    $display_limit = $text = '';
  }
  */
$_sec = true;
$_mili = true;
$display_limit = '公開終了まであと';
$text = '';
?>


<script type="text/javascript">
<!-- start of JavaScript
function CountdownTimer( elemID, timeLimit, limitMessage, msgClass ) {
	this.initialize.apply( this, arguments );
}

CountdownTimer.prototype = 	{

	/**
	 * Constructor
	 */
	initialize: function( elemID, timeLimit, limitMessage, msgClass ) {
		this.elem = document.getElementById( elemID );
		this.timeLimit = timeLimit;
		this.limitMessage = limitMessage;
		this.msgClass = msgClass;
	},

	/**
	 * カウントダウン
	 */
	countDown : function()	{
		var	timer;
		var	today = new Date()
		var	days = Math.floor( ( this.timeLimit - today ) / ( 24 * 60 * 60 * 1000 ) );
		var	hours = Math.floor( ( ( this.timeLimit - today ) % ( 24 * 60 * 60 * 1000 ) ) / ( 60 * 60 * 1000 ) );
		var	mins = Math.floor( ( ( this.timeLimit - today ) % ( 24 * 60 * 60 * 1000 ) ) / ( 60 * 1000 ) ) % 60;
    <?php if( !empty($_sec) && $_sec == 1 ){
      echo 'var	secs = Math.floor( ( ( this.timeLimit - today ) % ( 24 * 60 * 60 * 1000 ) ) / 1000 ) % 60 % 60;';
    }?>
    <?php if( !empty($_mili) && $_mili == 1 ){
      echo 'var	milis = Math.floor( ( ( this.timeLimit - today ) % ( 24 * 60 * 60 * 1000 ) ) / 10 ) % 100;';
    }?>
		
		
		var	me = this;

	        if( ( this.timeLimit - today ) > 0 ){
			timer = '<?php echo $display_limit . $text;?>' + days + '日' + this.addZero( hours ) + '時間' + this.addZero( mins ) + '分'<?php
            if( !empty($_sec) && $_sec == 1 ){
            echo "+ this.addZero( secs ) + '秒'";
            }
            if( !empty($_sec) && $_sec == 1 && !empty($_mili) && $_mili == 1  ){
              echo '+ this.addZero( milis )';
            }
            echo PHP_EOL;
        ?>
			this.elem.innerHTML = timer;
			tid = setTimeout( function() { me.countDown(); }, 10 );

	        }else{
			this.elem.innerHTML = this.limitMessage;
			if( this.msgClass )	{
				this.elem.setAttribute( 'class', this.msgClass );
			}
			return;
	        }
	},

	/**
	 * ゼロを付与
	 */
	addZero : function( num )	{
		num = '00' + num;
		str = num.substring( num.length - 2, num.length );

		return str ;
	}
}

// end of JavaScript -->
</script>

<div class="timer-block">  
<div class="private-access-essence-timer" id="private-access-essence"></div>  
<script type="text/javascript">  
<!--  
cdTimer1();  
  
function cdTimer1() {  
  
// 設定項目 ここから---------------------------------------------  
    // タグ要素のID名  
    var elemID = 'private-access-essence';  
  
    // 期限日を設定  
    var year    =   <?php echo date('Y',strtotime( $_private_date));?>;           // 年  
    var month   =   <?php echo date('m',strtotime( $_private_date));?>;              // 月  
    var day     =   <?php echo date('d',strtotime( $_private_date));?>;             // 日  
  
    // 期限終了後のメッセージ  
    var limitMessage    =   '一般公開は終了しました。';  
  
    // メッセージのスタイルクラス名（変更しない場合は空欄）  
    var msgClass = 'private_essence_msg';  
// 設定項目 ここまで---------------------------------------------  
  
  
    var timeLimit = new Date( year, month - 1, day );  
    var timer = new CountdownTimer( elemID, timeLimit, limitMessage, msgClass );  
    timer.countDown();  
}  
  
// -->  
</script>  
</div>  