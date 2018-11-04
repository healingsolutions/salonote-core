// JavaScript Document

jQuery( function(){
    
	
		//アップローダー起動
    jQuery('.event_manager_image_upload').on('click',function(e) {
				var custom_uploader;
        e.preventDefault();
			
				var target_id = $(this).attr("id");
				var target_key = target_id.replace('event_manager_form_','');
			
				
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
								console.log('select'+target_id);
                ex_target.append(
                    '<p class="event_manager_img" id=img_'+ new_id +'>'+
                    '<a href="#" class="event_manager_image_remove" title="画像を削除する"></a>' +
                    '<img src="'+file.attributes.sizes.thumbnail.url+'" />' +
                    '<input type="hidden" name="essence_event_manager['+target_key+'][menu_assets]" value="'+ new_id +'" />' + 
										'</p>'
                );
            });
        });
        custom_uploader.open();
    });
	
	
		//画像削除処理
    jQuery( ".event_manager_image_remove" ).live( 'click', function( e ) {
        e.preventDefault();
        e.stopPropagation();
        img_obj = jQuery(this).parents('p.event_manager_img').remove();
    });
	

	
});