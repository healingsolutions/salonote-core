// JavaScript Document



jQuery(function($){

	if($('body.use_content_fade').length ){
		$('body.use_content_fade').animate({ scrollTop: 0 }, '1');
	}
	
	
	
	// 水平線でブロックを区切り、グルーピング　=======================================================
	if($('hr.block-horizon').length && ( $(window).width() > 768 ) ){

		setTimeout(function(){
			$('hr.block-horizon').each(function() {
				if($(this).nextAll('hr').length){

					$(this).nextUntil('hr').wrapAll('<div class="horizon-block" />');

					$(this).delay(10).queue(function(bg_url) {
						var bg_url = $(this).css('background-image');
						$_data_repeat = $(this).attr('data-repeat');
						var data_repeat = $_data_repeat ? $_data_repeat : "";
						$_data_size = $(this).attr('data-size');
						var data_size = $_data_size ? $_data_size : "";
						
						
						bg_url = /^url\((['"]?)(.*)\1\)$/.exec(bg_url);
						bg_url = bg_url ? bg_url[2] : ""; // If matched, retrieve url, otherwise ""
						
						if( bg_url.length || data_repeat.length || data_size.length ){
							var hr_props = {
									"background-image" : 'url('+bg_url+')',
									"background-repeat" : data_repeat,
									"background-size" : data_size
							}
							$(this).next('.horizon-block').css(hr_props).dequeue();
						}
						
						
						
						/*
						if(bg_url.length){
							$(this).next('.horizon-block').css('background-image', 'url('+bg_url+')');
						}
						if(data_repeat.length){
							$(this).next('.horizon-block').css('background-repeat', data_repeat);
						}
						if(data_size.length){
							$(this).next('.horizon-block').css('background-size', data_size);
						}
						if(bg_url.length && (repeat.length == 0) ){
							$(this).next('.horizon-block').css('background-image', 'url('+bg_url+')').dequeue();
						}
						if(bg_url.length && repeat.length){
							$(this).next('.horizon-block').css({
								background-repeat: $repeat,
								background-image: 'url('+bg_url+')',
							}).dequeue();
						}
						*/
						
						console.log(data_repeat);
					});

				}
			});
		}, 10);

	};
	
	// ブロックをグルーピング　=======================================================
		if($('.block-group').length && ( $(window).width() > 768 ) ){
				var index = 0;

				$('.block-group').each(function(){
					
					if( $(this).parent('.block-group-wrap').children('.vertical-middle').length ){

						
						var inner_height = 0;
						var inner_height = $(this).parent('.block-group-wrap').height();
						//console.log('height-'+index+':'+inner_height);

						$(this).children('.block-item-inner').each(function(){
							if(
								$(this).find('.block-vertical-rl').length == 0 &&
								$(this).find('.sns-block').length == 0
							){
								 $(this).css('min-height',(inner_height-50)+'px');
							 }
						});
						
					};
					
				});
		}
	

	
	// 拡張スタイル　=======================================================
	if($('.img-cover-block').length && ( $(window).width() > 768 ) ){

		setTimeout(function(){
			$('.img-cover-block').each(function() {

				var cover_image  = $(this).attr('src');
				var cover_height = $(this).height();
				var cover_class  = $(this).attr('class');

				$(this).hide().unwrap();
				$(this).wrap('<div class="cover-image" style="background-image:url('+cover_image+'); height:'+cover_height+'px;"></div>');

				if( $(this).hasClass("bkg-fixed")){
					var cover_height = cover_height/2;
					$(this).parent('.cover-image').addClass('bkg-fixed').height(cover_height);
				}
				if( $(this).hasClass("bkg-right"))
					$(this).parent('.cover-image').addClass('bkg-right');
				if( $(this).hasClass("bkg-left"))
					$(this).parent('.cover-image').addClass('bkg-left');

				if($(this).parent('.cover-image').next('.text-cover-block').length ){

					var content_height = $(this).parent('.cover-image').next('.text-cover-block').height();
					console.log( (content_height+200) +':'+cover_height);
					if( (content_height + 200) > cover_height )
						$(this).parent('.cover-image').css('height','auto'); 

					$(this).parent('.cover-image').next('.text-cover-block').insertBefore(this).children('.cover-image'); 
					$(this).parent('.cover-image').children('.text-cover-block').wrapInner('<div class="text-cover-inner" />');


				}


			});
		}, 10);

	};
	
	
	// 拡張スタイル　=======================================================
	if($('.has_sidebar').length && ( $(window).width() > 768 ) ){

				//該当のセレクタなどを代入

				var mainArea = $(".main-content-unit"); //メインコンテンツ
				var sideWrap = $("#sidebar"); //サイドバーの外枠
				var sideArea = $("#sidebar .sidebar_inner"); //サイドバー

				/*設定ここまで*/

				var wd = $(window); //ウィンドウ自体

				//メインとサイドの高さを比べる

				var mainH = mainArea.height();
				var sideH = sideWrap.height();
				var sideW = sideWrap.width();
				
				sideArea.css({"width": sideW+"px"});

				if(sideH < mainH) { //メインの方が高ければ色々処理する

							//サイドバーの外枠をメインと同じ高さにしてrelaltiveに（#sideをポジションで上や下に固定するため）
							sideWrap.css({"height": mainH,"position": "relative"});

							//サイドバーがウィンドウよりいくらはみ出してるか
							var sideOver = wd.height()-sideArea.height();

							//固定を開始する位置 = サイドバーの座標＋はみ出す距離
							var starPoint = sideArea.offset().top + (-sideOver);

							//固定を解除する位置 = メインコンテンツの終点
							var breakPoint = sideArea.offset().top + mainH;

							wd.scroll(function() { //スクロール中の処理

										if(wd.height() < sideArea.height()){ //サイドメニューが画面より大きい場合
													if(starPoint < wd.scrollTop() && wd.scrollTop() + wd.height() < breakPoint){ //固定範囲内
																sideArea.css({"position": "fixed", "bottom": "20px"});

													}else if(wd.scrollTop() + wd.height() >= breakPoint){ //固定解除位置を超えた時
																sideArea.css({"position": "absolute", "bottom": "0"});

													} else { //その他、上に戻った時
																sideArea.css("position", "static");

													}

										}else{ //サイドメニューが画面より小さい場合

													var sideBtm = wd.scrollTop() + sideArea.height(); //サイドメニューの終点

													if(mainArea.offset().top < wd.scrollTop() && sideBtm < breakPoint){ //固定範囲内
																sideArea.css({"position": "fixed", "top": "20px"});

													}else if(sideBtm >= breakPoint){ //固定解除位置を超えた時

																//サイドバー固定場所（bottom指定すると不具合が出るのでtopからの固定位置を算出する）
																var fixedSide = mainH - sideH;

																sideArea.css({"position": "absolute", "top": fixedSide});

													} else {
																sideArea.css("position", "static");
													}
										}


							});

				} 
};

	// resize events =================================================
	function essence_resize_script(){


		// イメージをブロック化　=======================================================
		if($('.block-image').length && ( $(window).width() > 768 ) ){
			$('.block-image').parent('p').wrap('<div class="block-image-wrap" />');
		}

		// 縦書きの時のブロック処理　=======================================================
		if($('.block-vertical-rl').length && ( $(window).width() > 768 ) ){
			setTimeout(function(){
				$('.block-vertical-rl').each(function() {

					$(this).wrap('<div class="block-vertical-rl-wrap" />');

					if($(this).parent('.block-group').length){
						$(this).parent('.block-group').addClass('has-vertical_text');
					}else if($(this).parent('.entry_block_content').length){
						//console.log($(this).parent('.entry_block_content').length);
						//$(this).wrap('<div class="block-vertical-rl-wrap" />');
					}
				});
			}, 10);
		}


		// 区切りブロック処理　=======================================================
		if($('.separate-block').length && ( $(window).width() > 768 ) ){


				var block_height = 0; // 揃える高さ最大値の初期化
				$('.separate-block').each(function() {
					var block_set = $(this).children('div:eq(0)').height();

					var hThis = $(this).innerHeight(); // カラムの高さ取得
					if ( block_set > block_height ) { block_height = block_set; }    // 最大値を判定・更新
				});

				$('.separate-block').each(function() {
					$(this).children('div:eq(0)').css('height', block_height+'px'); // それに合わせる
				});
		}
		
	}// essence_resize_script

	
	$(function(){
		setTimeout(function(){
			essence_resize_script();
		},100);

		setTimeout(function(){
			//$('#body-wrap').removeClass('fader');
			
			var h = window.innerHeight ? window.innerHeight: $(window).height();
			
			$("body.use_content_fade .entry_block_content").children("div.block-group-wrap").first().addClass('is_active');
			$('body.use_content_fade .landing-page-block').children('div.landing-page-item').first().addClass('is_active');
			
			$(window).on('scroll', function(event){
				
				var sct = $(window).scrollTop() ? $(window).scrollTop()+(h-100) : 0 ;
				
				$("body.use_content_fade .entry_block_content").children("div.block-group-wrap").each(function() {
					if( $(this).offset().top - sct <= 0) {
							$(this).addClass('is_active');
					}
				});
				$('body.use_content_fade .landing-page-block').children('div.landing-page-item').each(function() {
					if( $(this).offset().top - sct <= 0) {
							$(this).addClass('is_active');
					}
				});
			});
		},50);
		
	});
	
	$(window).on('resize', function(){	
		setTimeout(function(){
			essence_resize_script();
		},10);
	});
	
	// デバイスの向きが変わったら　=================================================
	$(window).on('orientationchange', function(){
	 setTimeout(function(){
			essence_resize_script();
		},10);
	});
	
	// ^ resize events =================================================
	
	
	
	
	// current list ====================
	$(function(){
		var url = window.location;
		//console.log(url);
		$('ul li a[href$="'+url+'"]').parent().addClass('current');
	});


	//SP nav ====================
	if($('.sp-navbar-unit').length ){

		//toggle button ====================
		$('.sp-navbar-unit .menu-item-has-children').each(function(index) {
			$(this).prepend("<a class='open-nav-button index-" + index + "'></a>" );
		});

		$('#navbar-button').on('click', function() {
			$(this.parentNode).toggleClass('open');
		});

		$('.sp-navbar-unit .menu-item-has-children > a').on('click', function() {
			$(this).nextAll('ul.sub-menu').toggle('fast');
			$(this).toggleClass('active');
		});


		//scroll check ====================
		$(window).scroll(function(){

			//スマートフォンの場合
			if(navigator.userAgent.match(/(iPhone|iPad|iPod|Android)/)){

				var nav_bar		= ".sp-navbar-unit";

				var menuHeight = $(nav_bar).height();		 //ナビゲーションの高さ
				var startPos	 = 0;														 //初期値
				var boxTop		 = $(nav_bar).offset().top; //トップとの差

				var currentPos = $(this).scrollTop();
				if (currentPos > startPos) {
					if($(window).scrollTop() >= 200) {
						$(nav_bar).addClass('scrolling');
					}
				} else {
					$(nav_bar).removeClass('scrolling');
				}
				startPos = currentPos;
			}

		});
	}



	//PC nav ====================
	if($('#header_nav').length ){

		$('#header_nav li.menu-item-has-children').each(function() {

			var parent_width = $(this).width();
			$("ul.sub-menu",this).css('min-width',parent_width+'px');

			var size = $("ul.sub-menu",this).children('li').length;
			//$(this).addClass( "sub-li-num-"+size );

			$(this).on({
				'mouseenter': function() {
					$(this).children('ul.sub-menu').css("max-height",(size*150)+"%");
				},
				'mouseleave': function() {
					$(this).children('ul.sub-menu').css("max-height","0");
				}
			})

		});
	};


	

	


	// ギャラリー処理　=================================================
	jQuery('body.use_gallery .gallery a').hover(
		//マウスオーバー時の処理
		function () {
		//マウスオーバーしているliの子・孫要素のimgのパスを変数化
			var imgPath = jQuery(this).attr('href');
		//取得した画像のパスをbodyの背景に指定
			//jQuery('body').addClass('gallery-bkg').css({backgroundImage:"url(" + imgPath + ")"});
			jQuery('body.use_gallery').append('<div class="gallery-bkg active"><img src="'+imgPath+'" /></div>');
			jQuery('body.use_gallery .gallery-bkg.active').fadeIn('slow');

		},
		//マウスアウト時の処理
		function () {
		//bodyの背景を初期化
			jQuery('body.use_gallery .gallery-bkg.active:last-child').removeClass('active').fadeOut('slow').addClass('old');
			setInterval(function(){
				jQuery('body.use_gallery .gallery-bkg.old').remove();
			},3000);
		}
	);
	
	
	// SNS遅延　=================================================
	if($('.sns-block').length ){
		//$('.sns-block').hidden();
		setTimeout(function(){
			$('.sns-wrap.loader').hide('fast');
			$('.sns-block').show('fast');
		},500);
	}
	
	
	// 要素のスクロール処理　=======================================================
	if($('.entry_block_content').length ){
		
		var winHeight = $(window).height();
	//scroll check ====================
		$(window).scroll(function(){
			
			var winScroll = $(window).scrollTop();
			var scrollPos = winScroll + (winHeight * 0.85);

			$('.entry_block_content').children('div.block-group-wrap').each(function() {
				if($(this).offset().top < scrollPos) {
						$(this).addClass('is_active');
				}
			});
			
		});
	};
  
  
   // #で始まるアンカーをクリックした場合に処理
   $('a.smoothscroll').click(function() {
      // スクロールの速度
      var speed = 400; // ミリ秒
      // アンカーの値取得
      var href= $(this).attr("href");
      // 移動先を取得
      var target = $(href == "#" || href == "" ? 'html' : href);
      // 移動先を数値で取得
      var position = target.offset().top;
      // スムーススクロール
      $('body,html').animate({scrollTop:position}, speed, 'swing');
      return false;
   });
	
	
	//lazy image
	if($('body.use_lazy_load').length && ( $(window).width() > 768 ) ){
		$('body.use_lazy_load .entry_block_content img[class*="wp-image-"]').each(function() {
			$(this).attr('src','//dummyimage.com/1x1/ffffff/cccccc.gif');
		});
		$('body.use_lazy_load .entry_block_content img.lazy').lazyload();
	}
	
	
	
	
	// color box ====================================================
	if (jQuery && jQuery.colorbox) {
		$('body.use_colorbox .gallery a').colorbox({
			maxWidth:"90%",
			maxHeight:"90%",
			opacity: 0.7,
			rel:'group'
		});
		
		$('body.use_colorbox .entry_block_content a[href$=jpg]').colorbox({
			maxWidth:"90%",
			maxHeight:"90%",
			opacity: 0.7,
		});
		$('body.use_colorbox .entry_block_content a[href$=png]').colorbox({
			maxWidth:"90%",
			maxHeight:"90%",
			opacity: 0.7,
		});
		$('body.use_colorbox .entry_block_content a[href$=gif]').colorbox({
			maxWidth:"90%",
			maxHeight:"90%",
			opacity: 0.7,
		});
		


		if($(window).width() > 768 ){
			$('body.use_colorbox a.colorbox[rel*=iframe]').colorbox({
				iframe:true,
				width:"90%",
				height:"90%",
				opacity: 0.7,
			});
		}else{
			$('body.use_colorbox a.colorbox[rel*=iframe]').each(function() {
				$(this).attr('target','_blank');
			});
		}
	};

	// slick box ====================================================
	if (jQuery && jQuery.slick) {
		$('.slick-unit-1').slick({
			infinite: true,
			dots: true,
			slidesToShow: 1,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 4000,
		});

		$('.slick-unit-4').slick({
			infinite: true,
			dots: false,
			slidesToShow: 4,
			slidesToScroll: 2,
			autoplay: true,
			autoplaySpeed: 4000,
		});
	};
	

  
});



	
