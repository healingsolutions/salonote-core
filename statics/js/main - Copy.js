// JavaScript Document



jQuery(function($){
	
	var ua = window.navigator.userAgent;
	if( ua.indexOf("MSIE") > 0 ||  ua.indexOf("Trident") > 0 ){
		var msie = 1;
	}else{
		var msie = 0;
	}
	console.log(msie);

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
						bg_url = /^url\((['"]?)(.*)\1\)$/.exec(bg_url);
						bg_url = bg_url ? bg_url[2] : ""; // If matched, retrieve url, otherwise ""
						if(bg_url.length){
							$(this).next('.horizon-block').css('background-image', 'url('+bg_url+')').dequeue();
						}
					});

				}
			});
		}, 10);

	};
	
	
	
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
					//console.log( (content_height+200) +':'+cover_height);
					if( (content_height + 200) > cover_height )
						$(this).parent('.cover-image').css('height','auto'); 

					$(this).parent('.cover-image').next('.text-cover-block').insertBefore(this).children('.cover-image'); 
					$(this).parent('.cover-image').children('.text-cover-block').wrapInner('<div class="text-cover-inner" />');


				}


			});
		}, 10);

	};

	// resize events =================================================
	function essence_resize_script(){

		// サイドバー追従　=======================================================
		if($('.sidebar_inner').length && ( $(window).width() > 768 ) ){
			$(function(){

				var fix = $('.sidebar_inner');	//固定したいコンテンツ
				side = $('#sidebar');					 //サイドバーのID
				main = $('.main-content-unit'); //固定する要素を収める範囲
				
				content_h = $('.entry_block_content').height();
				
				console.log( fix.height() );
				console.log( content_h );
				
				if(fix.height() > content_h) return;

				var s_width = side.width();

				if (side != null) {

				 var sideTop = side.offset().top;
				 fixTop = fix.offset().top,
				 mainTop = main.offset().top,


				 w = $(window);

				 var adjust = function(){
					 fixTop = fix.css('position') === 'static' ? sideTop + fix.position().top : fixTop;
					 var fixHeight = fix.outerHeight(true),
					 mainHeight = main.outerHeight(),
					 winTop = w.scrollTop() + 40;

					 if(winTop + fixHeight > mainTop + mainHeight){
						fix.removeClass('position-fixed');
					}else if(winTop >= fixTop){
						var p_props = {
								width: s_width+'px',
								top  : "40px",
						}
						fix.addClass('position-fixed').css(p_props);
					}else{
						fix.removeClass('position-fixed');
					 }
				 }

				 w.on('scroll', adjust);
				};

		 });
		};



		


		// イメージをブロック化　=======================================================
		if($('.block-image').length && ( $(window).width() > 768 ) ){
			$('.block-image').parent('p').wrap('<div class="block-image-wrap" />');
		}


		// ブロックをグルーピング　=======================================================
		if($('.block-unit').length && ( $(window).width() > 768 ) ){

			var index = 0;

			var set_group = function(index) {
				return new Promise(function(resolve, reject) {
					resolve();
				});
			};


			var set_col = function(index) {
				return new Promise(function(resolve, reject) {

					setTimeout(function(){
						length = $('.block-index-'+index).length;
						if( length >= 6 )
							length = (length%6)+6;
						$('.block-index-'+index).each(function(){
							$(this).addClass('group-col-'+length);
						})
						resolve();
					}, 1);
				});
			};

			var group_col = function(index) {
				return new Promise(function(resolve, reject) {

					setTimeout(function(){

						if( $('.block-index-'+index).parent('.block-group-wrap').length == 0 ){
								$('.block-index-'+index).wrapInner('<div class="block-item-inner"><div class="block-content"></div></div>');
							 $('.block-index-'+index).wrapAll('<div class="block-group-wrap" />');
						}

						resolve();
					}, 1);
				});
			};

			var match_height = function(index) {
				return new Promise(function(resolve, reject) {

					setTimeout(function(){

						var height = $('.block-index-'+index).parent('.block-group-wrap').height();
						//console.log('height-'+index+':'+height);
						
						$('.block-index-'+index).children('.block-item-inner').each(function(){
							if(
								$('.block-index-'+index).find('.block-vertical-rl').length == 0 &&
								$('.block-index-'+index).find('.sns-block').length == 0
							){
								 $(this).css('height',height+'px');
							 }
						});

						resolve();
					}, 1);
				});
			};

			$('.block-unit').each(function(){

				var group = 0;

				if( $(this).next('.block-unit').length )
					$(this).removeClass('block-unit').addClass('block-group block-index-'+index);

				if( $(this).prev('.block-group').length ){
					$(this).removeClass('block-unit').addClass('block-group block-index-'+index);

					if( $(this).next('.block-unit').length == 0 )
						++index;
				};

					// If another browser, return 0
					/* 呼び出し */
					set_group(index)
						.then(set_col(index))
						.then(group_col(index))
						.then(match_height(index));


			});

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


				var block_width = 0; // 揃える高さ最大値の初期化
				$('.separate-block').each(function() {
					var block_set = $(this).children('div:eq(0)').width();

					var hThis = $(this).innerHeight(); // カラムの高さ取得
					if ( block_set > block_width ) { block_width = block_set; }    // 最大値を判定・更新
				});

				$('.separate-block').each(function() {
					$(this).children('div:eq(0)').css('width', block_width+'px'); // それに合わせる
				});
		}
		
	}// essence_resize_script

	
	$(function(){
		setTimeout(function(){
			essence_resize_script();
		},100);

		setTimeout(function(){
			//$('#body-wrap').removeClass('fader');
			
			var sct = $(window).scrollTop()
			$('.entry_block_content').children('div.block-group-wrap').each(function() {
				//console.log($(this).offset().top+sct);
				if($(this).offset().top+sct < 800) {
						$(this).addClass('is_active');
				}
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
					$(this).children('ul.sub-menu').css("max-height",(size*100)+"%");
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
	
	
	
	
	// color box ====================================================
	if (jQuery && jQuery.colorbox) {
		$('body.use_colorbox .gallery a').colorbox({
			maxWidth:"90%",
			maxHeight:"90%",
			opacity: 0.7,
			rel:'group'
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



	
