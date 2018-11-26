// JavaScript Document




jQuery( function(){
    var custom_uploader;
		
	
		//アップローダー起動
    jQuery('.upload_image_button').click(function(e) {
			
			
			
			if( $(this).attr('rel') === 'multiple' ){
				 var multiple = true;
			}else{
				var multiple = false;
			}
			
			var data_name = $(this).attr('data-name');
			//var parent_id = $(this).attr('data-parent');
			//wp.media.model.settings.post.id = parent_id;
			
        e.preventDefault();
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
        custom_uploader = wp.media({
            title: _wpMediaViewsL10n.mediaLibraryTitle,
            library: {
                type: ''
            },
            button: {
                text: '画像を選択'
            },
            multiple: multiple, // falseのとき画像選択は一つのみ可能
            frame: 'select', // select | post. selectは左のnavを取り除く指定
            editing:   false,
        });
				
				
 
        custom_uploader.on('ready', function() {
           // jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
            //「この投稿への画像」をデフォルト表示　不要ならコメントアウト
        });
        custom_uploader.on('select', function() {
						
            var images = custom_uploader.state().get('selection'),
                ex_ul = jQuery('.upload_images'),
                ex_id = 0, 
                array_ids = [];
            if ( ex_ul[0] ){ //すでに登録されている画像を配列に格納
                ex_ul.children('li').each( function( ){
                    ex_id = Number(jQuery(this).attr( 'id' ).slice(4));
                    array_ids.push( ex_id );
                });
            }
            
						var counter = ex_ul.children('li').length;
            images.each(function( file ){
                new_id = file.toJSON().id;
                if ( jQuery.inArray( new_id, array_ids ) > -1 ){ //投稿編集画面のリストに重複している場合、削除
                    ex_ul.find('li#img_'+ new_id).remove();
                }
							
								$file_src = file.attributes.sizes.thumbnail.url;
							
							//console.log(file);
								
                ex_ul.append('<li class="upload_images_wrap" id=img_'+ new_id +'></li>').find('li:last').append(
                    '<div class="upload_images_item"><a href="#" class="upload_images_remove" title="画像を削除する"><span class="dashicons dashicons-dismiss"></span></a>' +
                    '<div class="upload_images_bkg"><img src="'+$file_src+')">' +
                    '<input type="hidden" name="'+data_name+'[]" value="'+ new_id +'" />' + 
                    '</div></div>'
                );
							++counter;
            });
					
        });
        custom_uploader.open();
    });
	
	
		//画像削除処理
		jQuery(document).on('click', 'a.upload_images_remove', function (e) {
        e.preventDefault();
        e.stopPropagation();
        img_obj = jQuery(this).parents('li.upload_images_wrap').remove();
    });
	
	
		//並べ替え
    jQuery(".upload_images").sortable({
        //axis : 'y',
        cursor : "move",
        tolerance : "pointer",
        opacity: 0.6
    });
	

});