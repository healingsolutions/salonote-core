// JavaScript Document

jQuery(document).ready(function() {
		jQuery().sfPrototypeMan({
			rmButtonText: "<div class=\"shop_menu_remove_btn\"></div>",
			addButtonText: "<div class=\"shop_menu_add_btn\"></div>"
		});
		jQuery("#shop_menu_form").sortable({
			axis: 'y',
			opacity: 0.5,
		});
	
		jQuery("#recommend_times").sortable();

		$(function() {

			$(document).on("click", '.datepicker', function () {
				$(this).datepicker({
						altField: '#output',
						altFormat: 'y-m-d-D',
						dateFormat: 'yy-mm-dd',
						changeMonth: true,
						changeYear: true,
						dayNamesMin: ['日', '月', '火', '水', '木', '金', '土'],
						monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
				});
				$(this).datepicker("show");
			});
		});

		
		jQuery(function($){
			jQuery('.doraggable-fields > div').each(function(){
				var field_id = $(this).attr('id');
				console.log(field_id);
				jQuery(this).find('.shop_menu_form_item.menu_type-item select').change(function(){
					
					var valu = jQuery(this).find('option:selected').val();

					
					if(valu == 'select'){
						$('#'+field_id).find('.image_size-item').css('display','none');
						$('#'+field_id).find('.menu_values-item').css('display','inline-block');
					}else if(valu == 'upload'){
						$('#'+field_id).find('.menu_values-item').css('display','none');
						$('#'+field_id).find('.image_size-item').css('display','inline-block');
					}else{
						$('#'+field_id).find('.menu_values-item').css('display','none');
						$('#'+field_id).find('.image_size-item').css('display','none');
					}

						
				});
			});
			
			
			jQuery('.shop_menu_essence-simple').on('click',function(){
				jQuery('.shop_menu_essence-menu-item').hide();
			});
			
			jQuery('.shop_menu_essence-more').on('click',function(){
				jQuery('.shop_menu_essence-menu-item').show();
			});
			
    });

	});

jQuery( function(){
    
	
		//アップローダー起動
    jQuery('.shop_menu_image_upload').on('click',function(e) {
				var custom_uploader;
        e.preventDefault();
			
				var target_id = $(this).attr("id");
				var target_key = target_id.replace('shop_menu_form_','');
			
				
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
                    '<p class="shop_menu_img" id=img_'+ new_id +'>'+
                    '<a href="#" class="shop_menu_image_remove" title="画像を削除する"></a>' +
                    '<img src="'+file.attributes.sizes.thumbnail.url+'" />' +
                    '<input type="hidden" name="essence_shop_menu['+target_key+'][menu_assets]" value="'+ new_id +'" />' + 
										'</p>'
                );
            });
        });
        custom_uploader.open();
    });
	
	
		//画像削除処理
    jQuery( ".shop_menu_image_remove" ).live( 'click', function( e ) {
        e.preventDefault();
        e.stopPropagation();
        img_obj = jQuery(this).parents('p.shop_menu_img').remove();
    });
	
});