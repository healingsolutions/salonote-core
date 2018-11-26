// JavaScript Document
jQuery(function(){var r;
//アップローダー起動
jQuery(".upload_image_button").click(function(e){if("multiple"===$(this).attr("rel"))var i=!0;else var i=!1;var l=$(this).attr("data-name");
//var parent_id = $(this).attr('data-parent');
//wp.media.model.settings.post.id = parent_id;
e.preventDefault(),r||((r=wp.media({title:_wpMediaViewsL10n.mediaLibraryTitle,library:{type:""},button:{text:"画像を選択"},multiple:i,// falseのとき画像選択は一つのみ可能
frame:"select",// select | post. selectは左のnavを取り除く指定
editing:!1})).on("ready",function(){
// jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
//「この投稿への画像」をデフォルト表示　不要ならコメントアウト
}),r.on("select",function(){var e=r.state().get("selection"),i=jQuery(".upload_images"),a=0,t=[];i[0]&&//すでに登録されている画像を配列に格納
i.children("li").each(function(){a=Number(jQuery(this).attr("id").slice(4)),t.push(a)});var n=i.children("li").length;e.each(function(e){new_id=e.toJSON().id,-1<jQuery.inArray(new_id,t)&&//投稿編集画面のリストに重複している場合、削除
i.find("li#img_"+new_id).remove(),$file_src=e.attributes.sizes.thumbnail.url,
//console.log(file);
i.append('<li class="upload_images_wrap" id=img_'+new_id+"></li>").find("li:last").append('<div class="upload_images_item"><a href="#" class="upload_images_remove" title="画像を削除する"><span class="dashicons dashicons-dismiss"></span></a><div class="upload_images_bkg"><img src="'+$file_src+')"><input type="hidden" name="'+l+'[]" value="'+new_id+'" /></div></div>'),++n})})),r.open()}),
//画像削除処理
jQuery(document).on("click","a.upload_images_remove",function(e){e.preventDefault(),e.stopPropagation(),img_obj=jQuery(this).parents("li.upload_images_wrap").remove()}),
//並べ替え
jQuery(".upload_images").sortable({
//axis : 'y',
cursor:"move",tolerance:"pointer",opacity:.6})});