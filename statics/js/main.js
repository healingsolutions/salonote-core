// JavaScript Document



jQuery(function($){

	if($('body.use_content_fade').length ){
		$('body.use_content_fade').animate({ scrollTop: 0 }, '1');
	}
	
	
	if($('.toggle-dl').length ){
		$('.toggle-dl dt').on('click',function(){
			$(this).nextAll('dd').toggle('fast');
			$(this).toggleClass('dd_open');
		})
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
					var cover_height = cover_height/1.5;
					$(this).parent('.cover-image').addClass('bkg-fixed').height(cover_height);
				}
				if( $(this).hasClass("bkg-right"))
					$(this).parent('.cover-image').addClass('bkg-right');
				if( $(this).hasClass("bkg-left"))
					$(this).parent('.cover-image').addClass('bkg-left');

				if($(this).parent('.cover-image').next('.text-cover-block').length ){
					
					$(this).parent('.cover-image').next('.text-cover-block').height(cover_height);

					var content_height = $(this).parent('.cover-image').next('.text-cover-block').height();
					//console.log( (content_height+200) +':'+cover_height);
					if( (content_height + 200) > cover_height )
						$(this).parent('.cover-image').css('height','auto'); 

					$(this).parent('.cover-image').next('.text-cover-block').insertBefore(this).children('.cover-image'); 
					$(this).parent('.cover-image').children('.text-cover-block').wrapInner('<div class="text-cover-inner"><div class="text-cover-inner-wrap"></div></div>');


				}


			});
		}, 10);

	};
	
	

	// resize events =================================================
	function essence_resize_script(){


		// イメージをブロック化　=======================================================
		if($('.block-image').length && ( $(window).width() > 768 ) ){
			$('.block-image').parent('p').wrap('<div class="block-image-wrap" />');
		}
		
		// 円形ブロック処理　=======================================================
		if($('.circled_block').length ){
			$('.circled_block').each(function(){
				var circled_height = $(this).width() + 30;
				//console.log(circled_height);
				$(this).wrapInner('<div class="circled_block_inner" />').css('height',circled_height+'px');
				$(this).children('.circled_block_inner').css('height',(circled_height-30)+'px');
			})
			
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
				
				
				if($('body.single-style').length && ( $(window).width() > 768 ) ){
					$('body.single-style .entry_block_content img').each(function(i){
						if( $(this).offset().top - (sct-300) <= 0) {
							$(this).addClass('is_active');

							if($(this).hasClass('is_keyv_added')){

							}else{
								if( $(this).attr('srcset')){
									var img_srcset = $(this).attr('srcset');
									var img_src = $(this).attr('src');
									$('#keyv-figure picture').append('<img id="keyv_'+i+'" class="img-fit" src="'+img_src+'" srcset="'+img_srcset+'" />');
									$(this).addClass('is_keyv_added');
									//$('#keyv-figure img').attr('srcset',img_src).fadeIn();
								}
							}
						}else{
							$(this).removeClass('is_active');

							if($(this).hasClass('is_keyv_added')){
								$(this).removeClass('is_keyv_added');
								$("#keyv-figure picture #keyv_"+i).fadeOut().queue(function() {
									this.remove();
								});
							}
						}
					});
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


			//$(this).addClass( "sub-li-num-"+size );
			
			$(this).children('ul.sub-menu').css("max-height","0");

			$(this).on({
				'mouseenter': function() {
					$(this).children('ul.sub-menu').css("max-height","40vh");
				},
				'mouseleave': function() {
					$(this).children('ul.sub-menu').css("max-height","0");
				}
			})

		});
	};


	
	//list_item_block
	if($('.list_item_block').length ){
		$('.list-type-group .list_item_block a, .timeline-type-group .list_item_block a').each(function(){
			var list_height = $(this).height();
			//console.log(list_height);
			$(this).children('.list_block_inner').height(list_height);
		})
		
	}

	


	// ギャラリー処理　=================================================
	if($('body.use_gallery').length && ( $(window).width() > 768 ) ){
		jQuery('body.use_gallery .gallery a').hover(
			//マウスオーバー時の処理
			function () {
			//マウスオーバーしているliの子・孫要素のimgのパスを変数化
				var imgPath = jQuery(this).attr('href');
			//取得した画像のパスをbodyの背景に指定
				//jQuery('body').addClass('gallery-bkg').css({backgroundImage:"url(" + imgPath + ")"});
				jQuery('body.use_gallery .main-content-wrap').append('<div class="gallery-bkg active"><img src="'+imgPath+'" /></div>');
				jQuery('body.use_gallery .main-content-wrap .gallery-bkg.active').fadeIn('slow');

			},
			//マウスアウト時の処理
			function () {
			//bodyの背景を初期化
				jQuery('body.use_gallery .gallery-bkg.active:last-child').removeClass('active').fadeOut('slow').addClass('old');
				setInterval(function(){
					jQuery('body.use_gallery .gallery-bkg.old').remove();
				},5000);
			}
		);
	}
	
	
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
			
			if( $(this).hasClass('cover-image') === 0 ){
				$(this).attr('src','//dummyimage.com/1x1/ffffff/cccccc.gif');
			}
		});
		$('body.use_lazy_load .entry_block_content img.lazy').lazyload();
	}
	
	
	
	$('.widget_media_image > .wp-caption a > img.banner').each(function() {

		var banner_title = $(this).attr('alt');
		
		//var caption = $(this).parents('.wp-caption').text();
		//var caption_result = caption.replace(/\s/g,"<br />");
		
		$(this).parents('.wp-caption').addClass('widget_banner_block').children('.wp-caption-text').insertAfter(this);
		$(this).after('<h1 class="banner_block_title">'+banner_title+'</h1>');
		
		$(this).nextAll( '.banner_block_title, .wp-caption-text' ).wrapAll( '<div class="banner_caption_block"></div>' );
		
		
		
		if( $(this).hasClass('text-right') ){
			$(this).next('.banner_caption_block').addClass('text-right');
		}
		else if( $(this).hasClass('text-left') ){
			$(this).next('.banner_caption_block').addClass('text-left');
		}
		else{
			$(this).next('.banner_caption_block').addClass('text-center');
		}
		
		if( $(this).hasClass('text-black') ){
			$(this).next('.banner_caption_block').addClass('text-black');
		}
		
		var caption_value = $(this).next('.banner_caption_block').children('.wp-caption-text').text().replace(/\s/g,"<br />");
		$(this).next('.banner_caption_block').children('.wp-caption-text').html(caption_value);
		
		
	});
	
	
	// color box ====================================================
	if (jQuery && jQuery.colorbox) {
		$('body.use_colorbox .gallery a').colorbox({
			maxWidth:"90%",
			maxHeight:"90%",
			opacity: 0.7,
			rel:'group'
		});
		$('body.use_colorbox .gallery_group a').colorbox({
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



// keyv landing
jQuery(function($) {
	//$(window).on("load",function() {
		
		
		var startPos = 0,winScrollTop = 0;
		
		
		var nav_height = $('.site-header-block').height();
		$("#body-wrap").css("padding-top", nav_height+"px" );
		

		$( '.cover-image' ).each(function(){
			var cvi_height = $(this).offsetTop();
			//console.log(cvi_height);
		})
		
		// key-figure
		if( $(window).width() > 0 ){
			
		var key_content_height = $('.figure-text').height();
		$('.figure-text-inner').height(key_content_height);
		var keyv_figure = jQuery(document).scrollTop();
		
			$(window).on('scroll',function(){
				
				winScrollTop = $(this).scrollTop();
				if (winScrollTop >= startPos) {
						$('#body-wrap').addClass('scroll_down');
						$('#body-wrap').removeClass('scroll_up');
				} else {
						$('#body-wrap').removeClass('scroll_down');
						$('#body-wrap').addClass('scroll_up');
				}
				startPos = winScrollTop;
				
				
				var top = $(window).scrollTop();
				var w_height = $(window).height();
				var scroll_keyv = 100 - ((top - w_height) * 0.05);
				
				
				
				if( top >= nav_height){
					$('.site-header-block').addClass('hide_header');
				}else{
					$('.site-header-block').removeClass('hide_header');
				}
				
				
				//keyv-figure ==================
				if( $('.cover-image').length && $(window).width() > 768 ){
					$('.cover-image').each(function(){
						
						var cover_offset = $(this).offset().top;
						var cover_height = $(this).height() / 3;
						
						var blur = (top - cover_offset + cover_height) * 0.03;

						if( (top - cover_offset + cover_height) > 0 ){
							console.log(blur);
							$(this).children('.text-cover-block').css({
								"top"		:	(blur * -1.3 + 20) +'%',
								"opacity"	:	(100 - (blur * 7) )*0.01,
							});
						}else{
							$(this).children('.text-cover-block').css({
								"top"		:	'0%',
								"opacity"	:	'1',
							});
						}
						
					})
					
				}
				

				
				//keyv-figure ==================
				if( $('#keyv-figure').length && $(window).width() > 768 ){
					if( top >= w_height){
						if( scroll_keyv < 64){
							$('#keyv-figure').css({
								"width"　: "64%",
								"max-width": "64%",
								"flex": '0 0 ' + "64%",
							})
						}else{
							$('#keyv-figure').css({
								width　:scroll_keyv +'%',
								"max-width": scroll_keyv +'%',
								"flex": '0 0 ' + scroll_keyv +'%'
							})
							$('#keyv-figure picture img').css({
								left　: ((scroll_keyv * -1) )+'%',
							})


						}
					}else{
							$('#keyv-figure').css({
								"width"　: "100%",
								"max-width": "100%",
								"flex": '0 0 ' + "100%"
							})
					}

					//=====================
					

						var scroll_keyv = 100 - (top * 0.05);

						if( scroll_keyv >= 64 ){

							//console.log(top * 0.03);
							var blur = top * 0.03;
							$('.figure-text').css({
								"filter": "blur("+ blur +"px)",
								"top"		:	(blur * -1.3 + 20) +'%',
								"opacity"	:	(92 - (blur * 5) )*0.01,
							});

						}else{

							var blur = top * 0.03;
							$('.figure-text').css({
								"opacity"	:	0,
							});
						}
				
				}//end keyv-figure ==================
				
			});
			
		}//if
	
	
	//nav
	$(document).ready(function(){
		$('#header_nav.navbar-block ul.menu').css('overflow','visible');
  });
		
		//})
	});

