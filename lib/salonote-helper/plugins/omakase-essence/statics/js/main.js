// JavaScript Document

jQuery( function(){
    var custom_uploader;
	
		//アップローダー起動
    jQuery('#es_slider_upload_media').click(function(e) {
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
            multiple: true, // falseのとき画像選択は一つのみ可能
            frame: 'select', // select | post. selectは左のnavを取り除く指定
            editing:   false,
        }); 
  
 
        custom_uploader.on('ready', function() {
           // jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
            //「この投稿への画像」をデフォルト表示　不要ならコメントアウト
        });
        custom_uploader.on('select', function() {
            var images = custom_uploader.state().get('selection'),
                ex_ul = jQuery('#es_slider_upload_images'),
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
							
								$file_src = file.attributes.url;
								
                ex_ul.append('<li class="img" id=img_'+ new_id +'></li>').find('li:last').append(
                    '<div class="img_wrap">' + 
                    '<a href="#" class="es_slider_upload_images_remove" title="画像を削除する"></a>' +
                    '<div class="slider-item" style="background-image: url('+$file_src+')"><!-- image -->' +
                    '<input type="hidden" name="es_slider_upload_images['+counter+'][image]" value="'+ new_id +'" />' + 
										'<input class="slider-text" type="text" name="es_slider_upload_images['+counter+'][text]" value="" />' + 
                    '</div>'
                );
							++counter;
            });
        });
        custom_uploader.open();
    });
	
	
		//画像削除処理
    jQuery( ".es_slider_upload_images_remove" ).live( 'click', function( e ) {
        e.preventDefault();
        e.stopPropagation();
        img_obj = jQuery(this).parents('li.img').remove();
    });
	
	
		//並べ替え
    jQuery( "#es_slider_upload_images" ).sortable({
        axis : 'y',
        cursor : "move",
        tolerance : "pointer",
        opacity: 0.6
    });
	
	
		jQuery('#es_slider_upload').insertAfter('#titlediv'); 
});