// JavaScript Document
jQuery(function(){
//アップローダー起動
jQuery(".character_image_upload").on("click",function(e){var r;e.preventDefault();var l=$(this).attr("rel"),s=l.replace("character_","");r||(console.log("click:"+l),(r=wp.media({title:_wpMediaViewsL10n.mediaLibraryTitle,library:{type:"image"},button:{text:"画像を選択"},multiple:!1,// falseのとき画像選択は一つのみ可能
frame:"select",// select | post. selectは左のnavを取り除く指定
editing:!0})).on("ready",function(){
// jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
//「この投稿への画像」をデフォルト表示　不要ならコメントアウト
}),r.on("select",function(){var e=r.state().get("selection"),a=jQuery("#"+l),t=0,i=[];e.each(function(e){new_id=e.toJSON().id,-1<jQuery.inArray(new_id,i)&&//投稿編集画面のリストに重複している場合、削除
a.find("li#img_"+new_id).remove(),console.log("select"+l),a.val(e.attributes.sizes.medium.url),jQuery('a[rel="'+l+'"]').hide(),jQuery("#"+l+"_asset").html('<div class="character_asset_block　salonote_images_upload_block"><a href="#" class="salonote_images_upload_images_remove" title="画像を削除する"></a><img src="'+e.attributes.sizes.medium.url+'" /><input id="character_'+s+'" type="hidden" name="es_character_upload_images['+s+']" value="'+e.attributes.sizes.medium.url+'" /></div>')})})),r.open()}),
//画像削除処理
jQuery(".salonote_images_upload_images_remove").live("click",function(e){e.preventDefault(),e.stopPropagation(),$(this).parents(".character_td").children(".character_image_upload").show(),img_obj=jQuery(this).parents(".character_asset_block").remove()})});