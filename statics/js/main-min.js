/*  Copyright 2016 Healing Solutions (email : info@healing-solutions.jp)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
//async
//load
// resize events =================================================
function essence_resize_script(){
// 区切りブロック処理　=======================================================
if(
// イメージをブロック化　=======================================================
$(".block-image").length&&768<$(window).width()&&$(".block-image").parent("p").wrap('<div class="block-image-wrap" />'),
// 円形ブロック処理　=======================================================
$(".circled_block").length&&$(".circled_block").each(function(){var e=$(this).width()+30;
//console.log(circled_height);
$(this).wrapInner('<div class="circled_block_inner" />').css("height",e+"px"),$(this).children(".circled_block_inner").css("height",e-30+"px")}),
// 縦書きの時のブロック処理　=======================================================
$(".block-vertical-rl").length&&768<$(window).width()&&setTimeout(function(){$(".block-vertical-rl").each(function(){$(this).wrap('<div class="block-vertical-rl-wrap" />'),$(this).parent(".block-group").length?$(this).parent(".block-group").addClass("has-vertical_text"):$(this).parent(".entry_block_content").length})},10),$(".separate-block").length&&768<$(window).width()){var i=0;// 揃える高さ最大値の初期化
$(".separate-block").each(function(){var e=$(this).children("div:eq(0)").height(),t=$(this).innerHeight();// カラムの高さ取得
i<e&&(i=e);// 最大値を判定・更新
}),$(".separate-block").each(function(){$(this).children("div:eq(0)").css("height",i+"px");// それに合わせる
})}}// essence_resize_script
jQuery(document).ready(function(n){var e,i=(e=window.navigator.userAgent).indexOf("MSIE ");n("body.use_content_fade").length,n("#super-top-nav").length&&(n(".header_logo-block").insertBefore(".super-top-container"),n(window).width()<768&&n(".super-top-container").insertBefore(".sp-navbar-unit .navbar-block")),n("#replace-target").length&&n(".replace-item img").each(function(){n(this).on("click",function(){var e=n(this).attr("data-src");return n("#replace-target img").fadeOut("fast",function(){n("figure#replace-target img").attr("src",e).fadeIn("fast")}),!1})}),n(".gallery-alt2link").length&&n(".gallery-alt2link img").each(function(){
//$(this).parents('li').removeClass('blocks-gallery-item').addClass('alt2link-gallery-item');
var e=n(this).attr("alt");n(this).wrapAll('<a href="'+e+'"></a>')}),n(".wp-block-media-text__content").length&&n(".wp-block-media-text__content").each(function(){n(this).wrap('<div class="wp-block-media-text__content-block"></div>')}),n(".img-diamond").length&&n(".img-diamond").each(function(){var e=n(this).width(),t=n(this).width()/Math.SQRT2;n(this).wrap('<div class="img-diamond-unit"><div class="img-diamond-wrap" /></div>'),n(this).parent(".img-diamond-wrap").css({width:t+"px",height:t+"px"});var i=n(this).width()*Math.SQRT2;n(this).css({"max-width":i+"px",width:i+"px",height:i+"px","margin-top":-.2*t+"px","margin-left":-.2*t+"px"}),n(this).parent(".img-diamond-wrap").css({"margin-bottom":.35*t+"px"})});
// current list ====================
var t=window.location;
//console.log(url);
// 要素のスクロール処理　=======================================================
if(n('ul li a[href$="'+t+'"]').each(function(){n(this).addClass("active").parents("li").addClass("current"),n(this).parents("li.current").each(function(){n(this).children("a").addClass("active")})}),
//SP nav ====================
n(".sp-navbar-unit").length&&(
//toggle button ====================
n(".sp-navbar-unit .menu-item-has-children").each(function(e){n(this).prepend("<a class='open-nav-button index-"+e+"'></a>")}),n("#navbar-button").on("click",function(){n(this.parentNode).toggleClass("open")}),n(".sp-navbar-unit .menu-item-has-children > a").on("click",function(){n(this).nextAll("ul.sub-menu").toggle("fast"),n(this).toggleClass("active")})),
//PC nav ====================
n("#header_nav").length&&n("#header_nav li.menu-item-has-children").each(function(){var e=n(this).width();n("ul.sub-menu",this).css("min-width",e+"px"),
//$(this).addClass( "sub-li-num-"+size );
n(this).children("ul.sub-menu").css("max-height","0"),n(this).on({mouseenter:function(){n(this).children("ul.sub-menu").css("max-height","100vh")},mouseleave:function(){n(this).children("ul.sub-menu").css("max-height","0")}})}),
//^ end PC nav ====================
// dldtdd toggle
n(".toggle-dl").length&&n(".toggle-dl dt").on("click",function(){n(this).nextAll("dd").toggle("fast"),n(this).toggleClass("dd_open")}),
// ギャラリー処理　=================================================
n("body.use_gallery").length&&768<n(window).width()&&jQuery("body.use_gallery .gallery a").hover(
//マウスオーバー時の処理
function(){
//マウスオーバーしているliの子・孫要素のimgのパスを変数化
var e=jQuery(this).attr("href");
//取得した画像のパスをbodyの背景に指定
//jQuery('body').addClass('gallery-bkg').css({backgroundImage:"url(" + imgPath + ")"});
jQuery("body.use_gallery .main-content-wrap").append('<div class="gallery-bkg active"><img src="'+e+'" /></div>'),jQuery("body.use_gallery .main-content-wrap .gallery-bkg.active").fadeIn("slow")},
//マウスアウト時の処理
function(){
//bodyの背景を初期化
jQuery("body.use_gallery .gallery-bkg.active:last-child").removeClass("active").fadeOut("slow").addClass("old"),setInterval(function(){jQuery("body.use_gallery .gallery-bkg.old").remove()},5e3)}),
// SNS遅延　=================================================
n(".sns-block").length&&
//$('.sns-block').hidden();
setTimeout(function(){n(".sns-wrap.loader").hide("fast"),n(".sns-block").show("fast")},500),n(".entry_block_content").length){var a=n(window).height();if(n(".index-nav-block").length&&n(window).width()<=768)var s=n(".index-nav-block").height(),r=[],o=!1,l=n(".entry_block_content").height()-200;
//scroll check ====================
var c=!0;n(window).scroll(function(){c&&(c=!1,setTimeout(function(){var o=n(window).scrollTop(),e=o+.85*a;
// ページインデックス処理　=================================================
if(
/*
			$('.entry_block_content').find('div.block-group-wrap').each(function() {
				if($(this).offset().top < scrollPos) {
						$(this).addClass('is_active');
				}
			});
			*/
n(".entry_block_content").children("div").each(function(){n(this).offset().top<e&&n(this).addClass("is_active")}),n(".character_essence").each(function(){n(this).offset().top<e&&n(this).addClass("is_active")}),n(".index-nav-block").length&&n(window).width()<=768)if(n(".index-nav-block").offset().top<o-(n(".index-nav-block").height()+100)){if(!t){n(".index-nav-block").addClass("is_hide"),n(".entry_block_content").css("padding-top",s+"px");var t=!0}if(n(".entry_block_content").offset().top+l<o&&t){n(".index-nav-block").removeClass("is_hide"),n(".entry_block_content").css("padding-top","0px");var t=!1}n(".headline_nav_item").each(function(e){if(n(this).offset().top<o){if(!0!==r[e]){n(this).addClass("is_show");var t=n(this).attr("rel"),i=n(this).prev(".headline_nav_item").attr("rel");n("#"+t).addClass("show_nav"),n("#"+i).removeClass("show_nav"),r[e]=!0,0==e&&n("body").addClass("index-nav-block-is_hide")}}else if(n(this).removeClass("is_show"),r[e]){var a=n(this).attr("rel");n("#"+a).removeClass("show_nav"),r[e]=!1,0==e&&n("body").removeClass("index-nav-block-is_hide")}})}else{n(".index-nav-block").removeClass("is_hide"),n(".entry_block_content").css("padding-top","0px");var t=!1}return c=!0},300))})}
// #で始まるアンカーをクリックした場合に処理
n("a.smoothscroll").click(function(){
// スクロールの速度
var e=400,t=n(this).attr("href"),i,a=n("#"==t||""==t?"html":t).offset().top;// ミリ秒
// アンカーの値取得
// スムーススクロール
return n("body,html").animate({scrollTop:a},e,"swing"),!1}),
//lazy image
//if($('body.use_lazy_load').length && ( $(window).width() > 768 ) ){
n("body.use_lazy_load").length&&n('body.use_lazy_load .entry_block_content img[class*="wp-image-"]').each(function(){if(n(this).hasClass("img-cover-block"))n(this).addClass("cover-figure");else if(0===i){var e=n(this).attr("src"),t=n(this).attr("srcset");n(this).attr("src","//dummyimage.com/1x1/ffffff/cccccc.gif"),n(this).attr("srcset",e)}}),n(".square_label_block").length&&n(".square_label_block").each(function(){n(this).wrapInner('<div class="square_label_block-inner caption_bkg" />')}),n(".gallery .wp-caption-text").length&&n(".gallery .wp-caption-text").each(function(){n(this).addClass("square_label_block"),n(this).removeClass("wp-caption-text");var e=n(this).prev("img").attr("title"),t=n(this).prev("img").attr("alt");n(this).wrapInner('<div class="square_label_block-inner caption_bkg" />'),e&&n(this).children(".square_label_block-inner").prepend("<p>"+e+"<br><span>"+t+"</span></p>")});
//keyv-landing ==================
var h=0,d=0,g=n(".site-header-block").height();if(n("body.has_header_nav #body-wrap").css("padding-top",g+"px"),n(window).width()<769)var g=80;n(".cover-image").each(function(){var e=n(this).offset().top;
//console.log(cvi_height);
});
// key-figure
var u=n(".figure-text").height();n(".figure-text-inner").height(u);var p=jQuery(document).scrollTop();n(window).on("scroll",function(){d=n(this).scrollTop(),
//console.log('winScrollTop>'+winScrollTop+':startPos>'+startPos);
h<=d?(n("#body-wrap").addClass("scroll_down"),n("#body-wrap").removeClass("scroll_up")):d<h-5&&(n("#body-wrap").removeClass("scroll_down"),n("#body-wrap").addClass("scroll_up")),h=d;var a=n(window).scrollTop(),e=n(window).height(),t=100-.05*(a-e),t;
//keyv-figure ==================
if(g<=a?n("#body-wrap, .site-header-block").addClass("hide_header").removeClass("show_header"):n("#body-wrap, .site-header-block").removeClass("hide_header").addClass("show_header"),
//keyv-figure ==================
n(".cover-image").length&&768<n(window).width()&&(n(".cover-image.bkg-fixed").each(function(){var e=n(this).offset().top,t=n(this).height()/8,i=.03*(a-e+t);0<a-e+t?(console.log(i),n(this).children(".text-cover-block").css({top:-1.3*i+20+"%",opacity:.01*(100-7*i)})):n(this).children(".text-cover-block").css({top:"0%",opacity:"1"})}),n(".cover-image.bkg-parallax").each(function(){var e=n(this).offset().top,t=.03*n(this).height(),i=.3*(a-e+t);0<a-e+t?n(this).css({"background-position-y":i+"px"}):n(this).css({"background-position-y":"0px"})})),n('body[class*="-template-keyv-landing"] #keyv-figure').length&&768<n(window).width())if(e<=a?t<64?n("#keyv-figure").css({width:"64%","max-width":"64%",flex:"0 0 64%"}):(n("#keyv-figure").css({width:t+"%","max-width":t+"%",flex:"0 0 "+t+"%"}),n("#keyv-figure picture img").css({left:-1*t+"%"})):n("#keyv-figure").css({width:"100%","max-width":"100%",flex:"0 0 100%"}),64<=(t=100-.05*a)){
//console.log(top * 0.03);
var i=.03*a;n(".figure-text").css({filter:"blur("+i+"px)",top:-1.3*i+20+"%",opacity:.01*(92-5*i)})}else{var i=.03*a;n(".figure-text").css({opacity:0})}//^ end keyv-figure ==================
}),
//^ end keyv-landing ==================
// color box ====================================================
jQuery&&jQuery.colorbox&&(n("body.use_colorbox .gallery a").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7,rel:"group"}),n("body.use_colorbox .gallery_group a").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7,rel:"group"}),0!==n("body.use_colorbox .blocks-gallery-item").hasClass("gallery-alt2link").length&&n(this).children("a").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7,rel:"group"}),n("body.use_colorbox .entry_block_content a[href$=jpg]").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7}),n("body.use_colorbox .entry_block_content a[href$=jpeg]").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7}),n("body.use_colorbox .entry_block_content a[href$=png]").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7}),n("body.use_colorbox .entry_block_content a[href$=gif]").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7}),n("body.use_colorbox a.inline-colorbox").colorbox({inline:!0,maxWidth:"90%",maxHeight:"90%",opacity:.7}),768<n(window).width()?n("body.use_colorbox a.colorbox[rel*=iframe]").colorbox({iframe:!0,width:"90%",height:"90%",opacity:.7}):n("body.use_colorbox a.colorbox[rel*=iframe]").each(function(){n(this).attr("target","_blank")})),
// slick box ====================================================
jQuery&&jQuery.slick&&(n(".slick-unit-1").slick({infinite:!0,dots:!0,slidesToShow:1,slidesToScroll:1,autoplay:!0,autoplaySpeed:4e3}),n(".slick-unit-4").slick({infinite:!0,dots:!1,slidesToShow:4,slidesToScroll:2,autoplay:!0,autoplaySpeed:4e3})),
//nav
n("#header_nav.navbar-block ul.menu").css("overflow","visible");
//sp_nav	
var e=navigator.userAgent;/iPhone|iPad|iPod|Android/.test(e)&&n(".tab-nav-unit ul.sub-menu").length&&n(".tab-nav-unit li.menu-item-has-children").each(function(){n(this).removeClass("menu-item-has-children"),n(this).find(".sub-menu").remove()})}),//async
//load
jQuery(window).on("load",function(){if($(".tab-nav-unit > ul > li.current").length){var e=$(".tab-nav-unit > ul > li.current").offset().left;$(".tab-nav-unit").animate({scrollLeft:e+10},500,"swing")}
//scroll event ===============================
var t=window.innerHeight?window.innerHeight:$(window).height();//^ end 拡張スタイル　=======================================================
// ブロックをグルーピング　=======================================================
if($("body.use_content_fade .entry_block_content").children("div.block-group-wrap").first().addClass("is_active"),$("body.use_content_fade .landing-page-block").children("div.landing-page-item").first().addClass("is_active"),$(window).on("scroll",function(e){var a=$(window).scrollTop()?$(window).scrollTop()+(t-100):0;$("body.use_content_fade .entry_block_content").children("div.block-group-wrap").each(function(){$(this).offset().top-a<=0&&$(this).addClass("is_active")}),$("body.use_content_fade .entry_block_content").children("div.gallery").each(function(){$(this).offset().top-a<=0&&$(this).addClass("is_active")}),$("body.use_content_fade .landing-page-block").children("div.landing-page-item").each(function(){$(this).offset().top-a<=0&&$(this).addClass("is_active")}),$("body.single-style").length&&768<$(window).width()&&$("body.single-style .entry_block_content img").each(function(e){if($(this).offset().top-(a-300)<=0){if($(this).addClass("is_active"),$(this).hasClass("is_keyv_added"));else if($(this).attr("srcset")){var t=$(this).attr("srcset"),i=$(this).attr("src");$("#keyv-figure picture").append('<img id="keyv_'+e+'" class="img-fit" src="'+i+'" srcset="'+t+'" />'),$(this).addClass("is_keyv_added")}}else $(this).removeClass("is_active"),$(this).hasClass("is_keyv_added")&&($(this).removeClass("is_keyv_added"),$("#keyv-figure picture #keyv_"+e).fadeOut().queue(function(){this.remove()}))})}),
//^ end scroll event ===============================
// 水平線でブロックを区切り、グルーピング　=======================================================
$("hr.block-horizon").length&&$("hr.block-horizon").each(function(){$(this).nextAll("hr").length&&($(this).nextUntil("hr").wrapAll('<div class="horizon-block" />'),$(this).delay(10).queue(function(e){var e=$(this).css("background-image");$_data_repeat=$(this).attr("data-repeat");var t=$_data_repeat||"";$_data_size=$(this).attr("data-size");var i=$_data_size||"";// If matched, retrieve url, otherwise ""
if((e=(e=/^url\((['"]?)(.*)\1\)$/.exec(e))?e[2]:"").length||t.length||i.length)if(-1!==e.indexOf("mp4")){var a='<video class="cover-video" src="'+e+'" poster="https://dummyimage.com/600x400/000/fff.gif&text=Please+wait+while+loading+movie" autoplay loop muted playsinline></video>';$(this).next(".horizon-block").wrapInner('<div class="video-text"/>').addClass("has_video").append(a).queue(function(){this.next(".horizon-block").children(".cover-video").get(0).play()})}else if(-1!==e.indexOf("#"))e=/(.+?)\#(.*)/.exec(e),console.log(e),$(this).next(".horizon-block").css("background-color","#"+e[2]).dequeue();else{var a={"background-image":"url("+e+")","background-repeat":t,"background-size":i};$(this).next(".horizon-block").css(a).dequeue()}}))}),
//banner ================================
$(".widget_media_image > .wp-caption a > img.banner").each(function(){var e=$(this).attr("alt");
//var caption = $(this).parents('.wp-caption').text();
//var caption_result = caption.replace(/\s/g,"<br />");
$(this).parents(".wp-caption").addClass("widget_banner_block").children(".wp-caption-text").insertAfter(this),$(this).after('<h1 class="banner_block_title">'+e+"</h1>"),$(this).nextAll(".banner_block_title, .wp-caption-text").wrapAll('<div class="banner_caption_block"></div>'),$(this).hasClass("text-right")?$(this).next(".banner_caption_block").addClass("text-right"):$(this).hasClass("text-left")?$(this).next(".banner_caption_block").addClass("text-left"):$(this).next(".banner_caption_block").addClass("text-center"),$(this).hasClass("text-black")&&$(this).next(".banner_caption_block").addClass("text-black");var t=$(this).next(".banner_caption_block").children(".wp-caption-text").text().replace(/\s/g,"<br />");$(this).next(".banner_caption_block").children(".wp-caption-text").html(t)}),
//^ end banner ================================
//list_item_block
$(".list_item_block").length&&$(".list-type-group .list_item_block a, .timeline-type-group .list_item_block a").each(function(){var e=$(this).height();
//console.log(list_height);
$(this).children(".list_block_inner").height(e)}),//^ end list_item_block
// 拡張スタイル　=======================================================
$(".img-cover-block").length&&768<$(window).width()&&$(".img-cover-block").each(function(){var e=$(this).attr("src");if($(this).height()<$(window).height())var t=$(this).height();else var t=$(window).height();var i=$(this).attr("class"),a;if($(this).hide().unwrap(),$(this).wrap('<div class="cover-image" style="background-image:url('+e+"); height:"+t+'px;"></div>'),$(this).hasClass("bkg-fixed")){var t=t/1.5;$(this).parent(".cover-image").addClass("bkg-fixed").height(t)}if($(this).hasClass("bkg-parallax")){var t=t/1.8;$(this).parent(".cover-image").addClass("bkg-parallax").height(t)}($(this).hasClass("bkg-right")&&$(this).parent(".cover-image").addClass("bkg-right"),$(this).hasClass("bkg-left")&&$(this).parent(".cover-image").addClass("bkg-left"),$(this).parent(".cover-image").next(".text-cover-block").length)&&($(this).parent(".cover-image").next(".text-cover-block").height(t),
//console.log( (content_height+200) +':'+cover_height);
t<$(this).parent(".cover-image").next(".text-cover-block").height()+200&&$(this).parent(".cover-image").css("height","auto"),$(this).parent(".cover-image").next(".text-cover-block").insertBefore(this).children(".cover-image"),$(this).parent(".cover-image").children(".text-cover-block").wrapInner('<div class="text-cover-inner"><div class="text-cover-inner-wrap"></div></div>'));$(this).queue(function(){this.remove()})}),$(".block-group").length&&768<$(window).width()){var i=0;$(".block-group").each(function(){if($(this).parent(".block-group-wrap").children(".vertical-middle").length){var e=0,e=$(this).parent(".block-group-wrap").height();
//console.log('height-'+index+':'+inner_height);
$(this).children(".block-item-inner").each(function(){0==$(this).find(".block-vertical-rl").length&&0==$(this).find(".sns-block").length&&$(this).css("min-height",e-50+"px")})}})}
// ブロックをグルーピング　=======================================================
if($(".left-and-right-unit").length&&$(window).width()<=768){group_text=[];var a=0,o="",n=$(".left-and-right-unit .block-group-wrap:eq(0) > .block-group").length;$(".block-group-wrap").each(function(){for(var e=0;e<n;e++)0===e&&(group_text[a]=[]),group_text[a][e]=$(this).children(".block-group").eq(e).html();$(this).next("hr").remove(),$(this).remove(),++a});for(var s=0;s<n;s++)$.each(group_text,function(e,t){$(".left-and-right-unit .entry_block_content").append('<div class="block-group-wrap">'+t[s]+"</div>")})}$(".entry_block_content header + .cover-image").length&&$(".main-content-wrap").addClass("first-cover")
/*
  $(function() {
    $(".each_char_headline").children().addBack().contents().each(function(){
        if (this.nodeType == 3) {
            $(this).replaceWith($(this).text().replace(/(\S)/g, "<span>$&</span>"));
        }
    });
  });
  */,$(".each_char_headline").each(function(){var a=$(this),e=$(this).html().split("");$(this).html(""),$.each(e,function(e,t){var i,i;$("#slider-essence").length?((i=$("<span/>").text(t)).appendTo(a),i.delay(70*e)):((i=$("<span/>").text(t).css({opacity:0})).appendTo(a),i.delay(70*e),i.animate({opacity:1},1100))})}),
/*
	$('#slider-essence h2').addClass('animation-style_01');
	$('.animation-style_01').children().addBack().contents().each(function() {
    if (this.nodeType == 3) {
        $(this).replaceWith($(this).text().replace(/(\w)/g, "<span class='char'>$&</span>"));
    }
	});
	$('.animation-style_01').each(function() {
		//span要素に番号付きのclassを与える
		$('span.char', this).each(function(i) {
			i = i+1;            
			$(this).css({
				'animation-delay': (1 + i*0.1)+'s'
			})
		});
	});
	*/
$("body").removeClass("no-scroll"),$("#content-loader").fadeOut().queue(function(){this.remove()}),$("#body-wrap").removeClass("fader"),0==document.body.scrollTop&&setTimeout(function(){scrollTo(0,1)},1)}),jQuery(function(e){essence_resize_script()}),$(window).on("resize",function(){essence_resize_script()}),
// デバイスの向きが変わったら　=================================================
$(window).on("orientationchange",function(){essence_resize_script()});var default_width=$(window).width(),timer=!1;$(window).resize(function(){!1!==timer&&clearTimeout(timer),timer=setTimeout(function(){768<default_width&&$(window).width()<=768&&location.reload(),default_width<768&&768<=$(window).width()&&location.reload()},200)}),function(n,t,i,e){n.fn.doubleTapToGo=function(e){return!!("ontouchstart"in t||navigator.msMaxTouchPoints||navigator.userAgent.toLowerCase().match(/windows phone os 7/i))&&(this.each(function(){var o=!1;n(this).on("click",function(e){var t=n(this);t[0]!=o[0]&&(e.preventDefault(),o=t)}),n(i).on("click touchstart MSPointerDown",function(e){for(var t=!0,i=n(e.target).parents(),a=0;a<i.length;a++)i[a]==o[0]&&(t=!1);t&&(o=!1)})}),this)}}(jQuery,window,document);