// JavaScript Document


(function($) {
    var $wp_inline_edit = inlineEditPost.edit;
    inlineEditPost.edit = function( id ) {
        $wp_inline_edit.apply( this, arguments );
        var $post_id = 0;
        if ( typeof( id ) == 'object' )
            $post_id = parseInt( this.getId( id ) );
        if ( $post_id > 0 ) {
            var $edit_row = $( '#edit-' + $post_id );
            var $post_row = $( '#post-' + $post_id );

					var $chair = $( '.post_keywords', $post_row ).html();
            $( ':input[name="keywords"]', $edit_row ).val( $chair );
					
					var $subTitle = $( '.column-subTitle', $post_row ).html();
            $( ':input[name="subTitle"]', $edit_row ).val( $subTitle );
        }
    };
})(jQuery);//カプセル化





jQuery(document).ready( function($) {
    function media_upload(button_class) {
        var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;

        $('body').on('click', button_class, function(e) {
            var button_id ='#'+$(this).attr('id');
            var self = $(button_id);
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $(button_id);
            var id = button.attr('id').replace('_button', '');
            _custom_media = true;
            wp.media.editor.send.attachment = function(props, attachment){
                if ( _custom_media  ) {
                    $('.custom_media_id').val(attachment.id);
                    $('.custom_media_url').val(attachment.url);
                    $('.custom_media_image').attr('src',attachment.url).css('display','block');
                } else {
                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                }
            }
            wp.media.editor.open(button);
                return false;
        });
    }
    media_upload('.custom_media_button.button');
	
	
	
	var myOptions = {
			// デフォルトカラー（falseまたはカラーコード）
			defaultColor: false,
			// カラー変更時のイベント
			change: function(event, ui){},
			// カラークリア時のイベント
			clear: function() {},
			// 画面ロード時にカラーピッカーを隠すかどうか
			hide: true,
			// カラーパレットの表示方法
			palettes: true
	};

	$('#page_bkg_color').wpColorPicker(myOptions);
	
});




