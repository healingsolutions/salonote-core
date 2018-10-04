// JavaScript Document
!function(r){var d=inlineEditPost.edit;inlineEditPost.edit=function(t){d.apply(this,arguments);var e=0;if("object"==typeof t&&(e=parseInt(this.getId(t))),0<e){var i=r("#edit-"+e),a=r("#post-"+e),n=r(".post_keywords",a).html();r(':input[name="keywords"]',i).val(n);var o=r(".column-subTitle",a).html();r(':input[name="subTitle"]',i).val(o)}}}(jQuery),//カプセル化
jQuery(document).ready(function(u){function t(t){var r=!0,d=wp.media.editor.send.attachment;u("body").on("click",t,function(t){var i="#"+u(this).attr("id"),e=u(i),a=wp.media.editor.send.attachment,n=u(i),o=n.attr("id").replace("_button","");return r=!0,wp.media.editor.send.attachment=function(t,e){if(!r)return d.apply(i,[t,e]);u(".custom_media_id").val(e.id),u(".custom_media_url").val(e.url),u(".custom_media_image").attr("src",e.url).css("display","block")},wp.media.editor.open(n),!1})}t(".custom_media_button.button");var e={
// デフォルトカラー（falseまたはカラーコード）
defaultColor:!1,
// カラー変更時のイベント
change:function(t,e){},
// カラークリア時のイベント
clear:function(){},
// 画面ロード時にカラーピッカーを隠すかどうか
hide:!0,
// カラーパレットの表示方法
palettes:!0};u("#page_bkg_color").wpColorPicker(e)});