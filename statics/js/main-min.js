jQuery(function($){function e(){if($(".block-image").length&&$(window).width()>768&&$(".block-image").parent("p").wrap('<div class="block-image-wrap" />'),$(".block-vertical-rl").length&&$(window).width()>768&&setTimeout(function(){$(".block-vertical-rl").each(function(){$(this).wrap('<div class="block-vertical-rl-wrap" />'),$(this).parent(".block-group").length?$(this).parent(".block-group").addClass("has-vertical_text"):$(this).parent(".entry_block_content").length})},10),$(".separate-block").length&&$(window).width()>768){var e=0;$(".separate-block").each(function(){var t=$(this).children("div:eq(0)").height(),i=$(this).innerHeight();t>e&&(e=t)}),$(".separate-block").each(function(){$(this).children("div:eq(0)").css("height",e+"px")})}}if($("body.use_content_fade").length&&$("body.use_content_fade").animate({scrollTop:0},"1"),$("hr.block-horizon").length&&$(window).width()>768&&setTimeout(function(){$("hr.block-horizon").each(function(){$(this).nextAll("hr").length&&($(this).nextUntil("hr").wrapAll('<div class="horizon-block" />'),$(this).delay(10).queue(function(e){var e=$(this).css("background-image");$_data_repeat=$(this).attr("data-repeat");var t=$_data_repeat||"";$_data_size=$(this).attr("data-size");var i=$_data_size||"";if(e=/^url\((['"]?)(.*)\1\)$/.exec(e),e=e?e[2]:"",e.length||t.length||i.length){var o={"background-image":"url("+e+")","background-repeat":t,"background-size":i};$(this).next(".horizon-block").css(o).dequeue()}console.log(t)}))})},10),$(".block-group").length&&$(window).width()>768){var t=0;$(".block-group").each(function(){if($(this).parent(".block-group-wrap").children(".vertical-middle").length){var e=0,e=$(this).parent(".block-group-wrap").height();$(this).children(".block-item-inner").each(function(){0==$(this).find(".block-vertical-rl").length&&0==$(this).find(".sns-block").length&&$(this).css("min-height",e-50+"px")})}})}if($(".img-cover-block").length&&$(window).width()>768&&setTimeout(function(){$(".img-cover-block").each(function(){var e=$(this).attr("src"),t=$(this).height(),i=$(this).attr("class");if($(this).hide().unwrap(),$(this).wrap('<div class="cover-image" style="background-image:url('+e+"); height:"+t+'px;"></div>'),$(this).hasClass("bkg-fixed")){var t=t/2;$(this).parent(".cover-image").addClass("bkg-fixed").height(t)}if($(this).hasClass("bkg-right")&&$(this).parent(".cover-image").addClass("bkg-right"),$(this).hasClass("bkg-left")&&$(this).parent(".cover-image").addClass("bkg-left"),$(this).parent(".cover-image").next(".text-cover-block").length){var o=$(this).parent(".cover-image").next(".text-cover-block").height();console.log(o+200+":"+t),o+200>t&&$(this).parent(".cover-image").css("height","auto"),$(this).parent(".cover-image").next(".text-cover-block").insertBefore(this).children(".cover-image"),$(this).parent(".cover-image").children(".text-cover-block").wrapInner('<div class="text-cover-inner" />')}})},10),$(".has_sidebar").length&&$(window).width()>768){var i=$(".main-content-unit"),o=$("#sidebar"),n=$("#sidebar .sidebar_inner"),a=$(window),s=i.height(),l=o.height(),c=o.width();if(n.css({width:c+"px"}),l<s){o.css({height:s,position:"relative"});var r=a.height()-n.height(),h=n.offset().top+-r,d=n.offset().top+s;a.scroll(function(){if(a.height()<n.height())h<a.scrollTop()&&a.scrollTop()+a.height()<d?n.css({position:"fixed",bottom:"20px"}):a.scrollTop()+a.height()>=d?n.css({position:"absolute",bottom:"0"}):n.css("position","static");else{var e=a.scrollTop()+n.height();if(i.offset().top<a.scrollTop()&&e<d)n.css({position:"fixed",top:"20px"});else if(e>=d){var t=s-l;n.css({position:"absolute",top:t})}else n.css("position","static")}})}}if($(function(){setTimeout(function(){e()},100),setTimeout(function(){var e=window.innerHeight?window.innerHeight:$(window).height();$("body.use_content_fade .entry_block_content").children("div.block-group-wrap").first().addClass("is_active"),$("body.use_content_fade .landing-page-block").children("div.landing-page-item").first().addClass("is_active"),$(window).on("scroll",function(t){var i=$(window).scrollTop()?$(window).scrollTop()+(e-100):0;$("body.use_content_fade .entry_block_content").children("div.block-group-wrap").each(function(){$(this).offset().top-i<=0&&$(this).addClass("is_active")}),$("body.use_content_fade .landing-page-block").children("div.landing-page-item").each(function(){$(this).offset().top-i<=0&&$(this).addClass("is_active")})})},50)}),$(window).on("resize",function(){setTimeout(function(){e()},10)}),$(window).on("orientationchange",function(){setTimeout(function(){e()},10)}),$(function(){var e=window.location;$('ul li a[href$="'+e+'"]').parent().addClass("current")}),$(".sp-navbar-unit").length&&($(".sp-navbar-unit .menu-item-has-children").each(function(e){$(this).prepend("<a class='open-nav-button index-"+e+"'></a>")}),$("#navbar-button").on("click",function(){$(this.parentNode).toggleClass("open")}),$(".sp-navbar-unit .menu-item-has-children > a").on("click",function(){$(this).nextAll("ul.sub-menu").toggle("fast"),$(this).toggleClass("active")}),$(window).scroll(function(){if(navigator.userAgent.match(/(iPhone|iPad|iPod|Android)/)){var e=".sp-navbar-unit",t=$(e).height(),i=0,o=$(e).offset().top,n=$(this).scrollTop();n>i?$(window).scrollTop()>=200&&$(e).addClass("scrolling"):$(e).removeClass("scrolling"),i=n}})),$("#header_nav").length&&$("#header_nav li.menu-item-has-children").each(function(){var e=$(this).width();$("ul.sub-menu",this).css("min-width",e+"px");var t=$("ul.sub-menu",this).children("li").length;$(this).on({mouseenter:function(){$(this).children("ul.sub-menu").css("max-height",150*t+"%")},mouseleave:function(){$(this).children("ul.sub-menu").css("max-height","0")}})}),jQuery("body.use_gallery .gallery a").hover(function(){var e=jQuery(this).attr("href");jQuery("body.use_gallery").append('<div class="gallery-bkg active"><img src="'+e+'" /></div>'),jQuery("body.use_gallery .gallery-bkg.active").fadeIn("slow")},function(){jQuery("body.use_gallery .gallery-bkg.active:last-child").removeClass("active").fadeOut("slow").addClass("old"),setInterval(function(){jQuery("body.use_gallery .gallery-bkg.old").remove()},3e3)}),$(".sns-block").length&&setTimeout(function(){$(".sns-wrap.loader").hide("fast"),$(".sns-block").show("fast")},500),$(".entry_block_content").length){var u=$(window).height();$(window).scroll(function(){var e=$(window).scrollTop(),t=e+.85*u;$(".entry_block_content").children("div.block-group-wrap").each(function(){$(this).offset().top<t&&$(this).addClass("is_active")})})}$("a.smoothscroll").click(function(){var e=400,t=$(this).attr("href"),i=$("#"==t||""==t?"html":t),o=i.offset().top;return $("body,html").animate({scrollTop:o},400,"swing"),!1}),$("body.use_lazy_load").length&&$(window).width()>768&&($('body.use_lazy_load .entry_block_content img[class*="wp-image-"]').each(function(){$(this).attr("src","//dummyimage.com/1x1/ffffff/cccccc.gif")}),$("body.use_lazy_load .entry_block_content img.lazy").lazyload()),jQuery&&jQuery.colorbox&&($("body.use_colorbox .gallery a").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7,rel:"group"}),$("body.use_colorbox .entry_block_content a[href$=jpg]").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7}),$("body.use_colorbox .entry_block_content a[href$=png]").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7}),$("body.use_colorbox .entry_block_content a[href$=gif]").colorbox({maxWidth:"90%",maxHeight:"90%",opacity:.7}),$(window).width()>768?$("body.use_colorbox a.colorbox[rel*=iframe]").colorbox({iframe:!0,width:"90%",height:"90%",opacity:.7}):$("body.use_colorbox a.colorbox[rel*=iframe]").each(function(){$(this).attr("target","_blank")})),jQuery&&jQuery.slick&&($(".slick-unit-1").slick({infinite:!0,dots:!0,slidesToShow:1,slidesToScroll:1,autoplay:!0,autoplaySpeed:4e3}),$(".slick-unit-4").slick({infinite:!0,dots:!1,slidesToShow:4,slidesToScroll:2,autoplay:!0,autoplaySpeed:4e3}))});