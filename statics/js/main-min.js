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
jQuery(document).ready(function(o){o("body.use_content_fade").length,o("#super-top-nav").length&&(o(".header_logo-block").insertBefore(".super-top-container"),o(window).width()<768&&o(".super-top-container").insertBefore(".sp-navbar-unit .navbar-block")),o("#replace-target").length&&o(".replace-item img").each(function(){o(this).on("click",function(){var e=o(this).attr("data-src");return o("#replace-target img").fadeOut("fast",function(){o("figure#replace-target img").attr("src",e).fadeIn("fast")}),!1})});
// current list ====================
var e=window.location;
//console.log(url);
// 要素のスクロール処理　=======================================================
if(o('ul li a[href$="'+e+'"]').each(function(){o(this).addClass("active").parents("li").addClass("current"),o(this).parents("li.current").each(function(){o(this).children("a").addClass("active")})}),
//SP nav ====================
o(".sp-navbar-unit").length&&(
//toggle button ====================
o(".sp-navbar-unit .menu-item-has-children").each(function(e){o(this).prepend("<a class='open-nav-button index-"+e+"'></a>")}),o("#navbar-button").on("click",function(){o(this.parentNode).toggleClass("open")}),o(".sp-navbar-unit .menu-item-has-children > a").on("click",function(){o(this).nextAll("ul.sub-menu").toggle("fast"),o(this).toggleClass("active")})),
//PC nav ====================
o("#header_nav").length&&o("#header_nav li.menu-item-has-children").each(function(){var e=o(this).width();o("ul.sub-menu",this).css("min-width",e+"px"),
//$(this).addClass( "sub-li-num-"+size );
o(this).children("ul.sub-menu").css("max-height","0"),o(this).on({mouseenter:function(){o(this).children("ul.sub-menu").css("max-height","100vh")},mouseleave:function(){o(this).children("ul.sub-menu").css("max-height","0")}})}),
//^ end PC nav ====================
// dldtdd toggle
o(".toggle-dl").length&&o(".toggle-dl dt").on("click",function(){o(this).nextAll("dd").toggle("fast"),o(this).toggleClass("dd_open")}),
// ギャラリー処理　=================================================
o("body.use_gallery").length&&768<o(window).width()&&jQuery("body.use_gallery .gallery a").hover(
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
o(".sns-block").length&&
//$('.sns-block').hidden();
setTimeout(function(){o(".sns-wrap.loader").hide("fast"),o(".sns-block").show("fast")},500),o(".entry_block_content").length){var i=o(window).height();
//scroll check ====================
o(window).scroll(function(){var e,t=o(window).scrollTop()+.85*i;o(".entry_block_content").children("div.block-group-wrap").each(function(){o(this).offset().top<t&&o(this).addClass("is_active")})})}
// #で始まるアンカーをクリックした場合に処理
o("a.smoothscroll").click(function(){
// スクロールの速度
var e=400,t=o(this).attr("href"),i,a=o("#"==t||""==t?"html":t).offset().top;// ミリ秒
// アンカーの値取得
// スムーススクロール
return o("body,html").animate({scrollTop:a},e,"swing"),!1}),
//lazy image
o("body.use_lazy_load").length&&768<o(window).width()&&o('body.use_lazy_load .entry_block_content img[class*="wp-image-"]').each(function(){if(o(this).hasClass("img-cover-block"))o(this).addClass("cover-figure");else{var e=o(this).attr("src"),t=o(this).attr("srcset");o(this).attr("src","//dummyimage.com/1x1/ffffff/cccccc.gif"),o(this).attr("srcset",e)}});
//keyv-landing ==================
var n=0,s=0,r=o(".site-header-block").height();if(o("#body-wrap").css("padding-top",r+"px"),o(window).width()<769)var r=80;o(".cover-image").each(function(){var e=o(this).offset().top;
//console.log(cvi_height);
});
// key-figure
var t=o(".figure-text").height();o(".figure-text-inner").height(t);var a=jQuery(document).scrollTop();o(window).on("scroll",function(){s=o(this).scrollTop(),
//console.log('winScrollTop>'+winScrollTop+':startPos>'+startPos);
n<=s?(o("#body-wrap").addClass("scroll_down"),o("#body-wrap").removeClass("scroll_up")):s<n-5&&(o("#body-wrap").removeClass("scroll_down"),o("#body-wrap").addClass("scroll_up")),n=s;var a=o(window).scrollTop(),e=o(window).height(),t=100-.05*(a-e),t;
//keyv-figure ==================
if(r<=a?o("#body-wrap, .site-header-block").addClass("hide_header"):o("#body-wrap, .site-header-block").removeClass("hide_header"),
//keyv-figure ==================
o(".cover-image").length&&768<o(window).width()&&o(".cover-image.bkg-fixed").each(function(){var e=o(this).offset().top,t=o(this).height()/8,i=.03*(a-e+t);0<a-e+t?(console.log(i),o(this).children(".text-cover-block").css({top:-1.3*i+20+"%",opacity:.01*(100-7*i)})):o(this).children(".text-cover-block").css({top:"0%",opacity:"1"})}),o("#keyv-figure").length&&768<o(window).width())if(e<=a?t<64?o("#keyv-figure").css({width:"64%","max-width":"64%",flex:"0 0 64%"}):(o("#keyv-figure").css({width:t+"%","max-width":t+"%",flex:"0 0 "+t+"%"}),o("#keyv-figure picture img").css({left:-1*t+"%"})):o("#keyv-figure").css({width:"100%","max-width":"100%",flex:"0 0 100%"}),64<=(t=100-.05*a)){
//console.log(top * 0.03);
var i=.03*a;o(".figure-text").css({filter:"blur("+i+"px)",top:-1.3*i+20+"%",opacity:.01*(92-5*i)})}else{var i=.03*a;o(".figure-text").css({opacity:0})}//^ end keyv-figure ==================
}),
//^ end keyv-landing ==================
// color box ====================================================
jQuery&&jQuery.colorbox&&(o("body.use_colorbox .gallery a").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7,rel:"group"}),o("body.use_colorbox .gallery_group a").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7,rel:"group"}),o("body.use_colorbox .entry_block_content a[href$=jpg]").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7}),o("body.use_colorbox .entry_block_content a[href$=png]").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7}),o("body.use_colorbox .entry_block_content a[href$=gif]").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7}),768<o(window).width()?o("body.use_colorbox a.colorbox[rel*=iframe]").colorbox({iframe:!0,width:"90%",height:"90%",opacity:.7}):o("body.use_colorbox a.colorbox[rel*=iframe]").each(function(){o(this).attr("target","_blank")})),
// slick box ====================================================
jQuery&&jQuery.slick&&(o(".slick-unit-1").slick({infinite:!0,dots:!0,slidesToShow:1,slidesToScroll:1,autoplay:!0,autoplaySpeed:4e3}),o(".slick-unit-4").slick({infinite:!0,dots:!1,slidesToShow:4,slidesToScroll:2,autoplay:!0,autoplaySpeed:4e3})),
//nav
o("#header_nav.navbar-block ul.menu").css("overflow","visible");
//sp_nav	
var c=navigator.userAgent;/iPhone|iPad|iPod|Android/.test(c)&&o(".tab-nav-unit ul.sub-menu").length&&o(".tab-nav-unit li.menu-item-has-children").each(function(){o(this).removeClass("menu-item-has-children"),o(this).find(".sub-menu").remove()})}),//async
//load
jQuery(window).on("load",function(){if($(".tab-nav-unit > ul > li.current").length){var e=$(".tab-nav-unit > ul > li.current").offset().left;$(".tab-nav-unit").animate({scrollLeft:e+10},500,"swing")}
//scroll event ===============================
var t=window.innerHeight?window.innerHeight:$(window).height();//^ end 拡張スタイル　=======================================================
// ブロックをグルーピング　=======================================================
if($("body.use_content_fade .entry_block_content").children("div.block-group-wrap").first().addClass("is_active"),$("body.use_content_fade .landing-page-block").children("div.landing-page-item").first().addClass("is_active"),$(window).on("scroll",function(e){var a=$(window).scrollTop()?$(window).scrollTop()+(t-100):0;$("body.use_content_fade .entry_block_content").children("div.block-group-wrap").each(function(){$(this).offset().top-a<=0&&$(this).addClass("is_active")}),$("body.use_content_fade .landing-page-block").children("div.landing-page-item").each(function(){$(this).offset().top-a<=0&&$(this).addClass("is_active")}),$("body.single-style").length&&768<$(window).width()&&$("body.single-style .entry_block_content img").each(function(e){if($(this).offset().top-(a-300)<=0){if($(this).addClass("is_active"),$(this).hasClass("is_keyv_added"));else if($(this).attr("srcset")){var t=$(this).attr("srcset"),i=$(this).attr("src");$("#keyv-figure picture").append('<img id="keyv_'+e+'" class="img-fit" src="'+i+'" srcset="'+t+'" />'),$(this).addClass("is_keyv_added")}}else $(this).removeClass("is_active"),$(this).hasClass("is_keyv_added")&&($(this).removeClass("is_keyv_added"),$("#keyv-figure picture #keyv_"+e).fadeOut().queue(function(){this.remove()}))})}),
//^ end scroll event ===============================
// 水平線でブロックを区切り、グルーピング　=======================================================
$("hr.block-horizon").length&&$("hr.block-horizon").each(function(){$(this).nextAll("hr").length&&($(this).nextUntil("hr").wrapAll('<div class="horizon-block" />'),$(this).delay(10).queue(function(e){var e=$(this).css("background-image");$_data_repeat=$(this).attr("data-repeat");var t=$_data_repeat||"";$_data_size=$(this).attr("data-size");var i=$_data_size||"";// If matched, retrieve url, otherwise ""
if((e=(e=/^url\((['"]?)(.*)\1\)$/.exec(e))?e[2]:"").length||t.length||i.length)if(-1!==e.indexOf("mp4")){var a='<video class="cover-video" src="'+e+'" poster="https://dummyimage.com/600x400/000/fff.gif&text=Please+wait+while+loading+movie" autoplay loop muted playsinline></video>';$(this).next(".horizon-block").wrapInner('<div class="video-text"/>').addClass("has_video").append(a).queue(function(){this.next(".horizon-block").children(".cover-video").get(0).play()})}else{var a={"background-image":"url("+e+")","background-repeat":t,"background-size":i};$(this).next(".horizon-block").css(a).dequeue()}}))}),
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
$(".img-cover-block").length&&768<$(window).width()&&$(".img-cover-block").each(function(){var e=$(this).attr("src"),t=$(this).height(),i=$(this).attr("class"),a;if($(this).hide().unwrap(),$(this).wrap('<div class="cover-image" style="background-image:url('+e+"); height:"+t+'px;"></div>'),$(this).hasClass("bkg-fixed")){var t=t/1.5;$(this).parent(".cover-image").addClass("bkg-fixed").height(t)}($(this).hasClass("bkg-right")&&$(this).parent(".cover-image").addClass("bkg-right"),$(this).hasClass("bkg-left")&&$(this).parent(".cover-image").addClass("bkg-left"),$(this).parent(".cover-image").next(".text-cover-block").length)&&($(this).parent(".cover-image").next(".text-cover-block").height(t),
//console.log( (content_height+200) +':'+cover_height);
t<$(this).parent(".cover-image").next(".text-cover-block").height()+200&&$(this).parent(".cover-image").css("height","auto"),$(this).parent(".cover-image").next(".text-cover-block").insertBefore(this).children(".cover-image"),$(this).parent(".cover-image").children(".text-cover-block").wrapInner('<div class="text-cover-inner"><div class="text-cover-inner-wrap"></div></div>'));$(this).queue(function(){this.remove()})}),$(".block-group").length&&768<$(window).width()){var i=0;$(".block-group").each(function(){if($(this).parent(".block-group-wrap").children(".vertical-middle").length){var e=0,e=$(this).parent(".block-group-wrap").height();
//console.log('height-'+index+':'+inner_height);
$(this).children(".block-item-inner").each(function(){0==$(this).find(".block-vertical-rl").length&&0==$(this).find(".sns-block").length&&$(this).css("min-height",e-50+"px")})}})}$(".entry_block_content header + .cover-image").length&&$(".main-content-wrap").addClass("first-cover"),$("body").removeClass("no-scroll"),$("#content-loader").fadeOut().queue(function(){this.remove()}),$("#body-wrap").removeClass("fader")}),jQuery(function(e){essence_resize_script()}),$(window).on("resize",function(){essence_resize_script()}),
// デバイスの向きが変わったら　=================================================
$(window).on("orientationchange",function(){essence_resize_script()}),function(n,t,i,e){n.fn.doubleTapToGo=function(e){return!!("ontouchstart"in t||navigator.msMaxTouchPoints||navigator.userAgent.toLowerCase().match(/windows phone os 7/i))&&(this.each(function(){var o=!1;n(this).on("click",function(e){var t=n(this);t[0]!=o[0]&&(e.preventDefault(),o=t)}),n(i).on("click touchstart MSPointerDown",function(e){for(var t=!0,i=n(e.target).parents(),a=0;a<i.length;a++)i[a]==o[0]&&(t=!1);t&&(o=!1)})}),this)}}(jQuery,window,document);