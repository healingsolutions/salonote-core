// JavaScript Document

jQuery( function(){
    
	
		//アップローダー起動
    jQuery('.character_image_upload').on('click',function(e) {
				var custom_uploader;
        e.preventDefault();
			
				var target_id = $(this).attr("rel");
				var target_key = target_id.replace('character_','');
				
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
				console.log('click:'+target_id);
        custom_uploader = wp.media({
            title: _wpMediaViewsL10n.mediaLibraryTitle,
            library: {
                type: 'image'
            },
            button: {
                text: '画像を選択'
            },
            multiple: false, // falseのとき画像選択は一つのみ可能
            frame:    'select', // select | post. selectは左のnavを取り除く指定
            editing:  true,
        }); 
  
 
        custom_uploader.on('ready', function() {
           // jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
            //「この投稿への画像」をデフォルト表示　不要ならコメントアウト
        });
        custom_uploader.on('select', function() {
            var images = custom_uploader.state().get('selection'),
                ex_target = jQuery('#'+target_id),
                ex_id = 0, 
                array_ids = [];

            images.each(function( file ){
                new_id = file.toJSON().id;
                if ( jQuery.inArray( new_id, array_ids ) > -1 ){ //投稿編集画面のリストに重複している場合、削除
                    ex_target.find('li#img_'+ new_id).remove();
                }
								//console.log('select'+target_id);
                ex_target.val(file.attributes.sizes.medium.url);
								//console.log(file);
								
								jQuery('a[rel="'+target_id+'"]').hide();
							
								jQuery('#'+target_id+'_asset')
									.html(
                    '<div class="character_asset_block　salonote_images_upload_block">'+
                    '<a href="#" class="salonote_images_upload_images_remove" title="画像を削除する"></a>' +
                    '<img src="'+file.attributes.sizes.medium.url+'" />' +
										'<input id="character_'+target_key+'_url" type="hidden" name="es_character_upload_images['+target_key+'][url]" value="'+file.attributes.sizes.medium.url+'" />'+
										'<input id="character_'+target_key+'_id" type="hidden" name="es_character_upload_images['+target_key+'][id]" value="'+file.attributes.id+'" />'+
										'</div>'
                );
            });
        });
        custom_uploader.open();
    });
	
	
		//画像削除処理
    jQuery( ".salonote_images_upload_images_remove" ).live( 'click', function( e ) {
        e.preventDefault();
        e.stopPropagation();
				$(this).parents('.character_td').children('.character_image_upload').show();
        img_obj = jQuery(this).parents('.character_asset_block').remove();
			
    });
	
});