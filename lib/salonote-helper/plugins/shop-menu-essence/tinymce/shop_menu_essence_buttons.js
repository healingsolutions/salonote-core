// JavaScript Document

(function() {
  tinymce.create('tinymce.plugins.shop_menu_essence', {
  init : function( editor,  url) {
  
  var t = this;
  t.url = url;
		

	//replace shortcode before editor content set
	//エディターコンテンツが読み込まれる前に　ショートコードの置き換え
	editor.onBeforeSetContent.add(function(ed, o) {
		o.content = t._do_spot(o.content);
	});
		
	//replace shortcode as its inserted into editor (which uses the exec command)
	editor.onExecCommand.add(function(ed, cmd) {
		console.log(cmd);
			if (cmd ==='mceInsertContent'){
			tinyMCE.activeEditor.setContent( t._do_spot(tinyMCE.activeEditor.getContent()) );
		}
	});
		

	//replace the image back to shortcode on save
	//保存時にはショートコードそのものを保存する
	editor.onPostProcess.add(function(ed, o) {
		if (o.get)
			o.content = t._get_spot(o.content);
	});



		//メールフォームショートコードを追加 =============================================
		editor.addButton( 'shop_menu_essence', {
      icon: 'icon dashicons-email-alt',
      onclick : function() {
				
				
					//JSONのURLを格納する
					var current_url = location.hostname+''+location.pathname;
					var json_url = current_url.replace('wp-admin/post.php','wp-json/wp/v2/shop_menu');
					$url = '//'+json_url;

					$.getJSON( $url, function(results) {
						var shop_menu_posts = [];	
						$.each(results, function(i, value) {
							var posts = {};
							posts['text']   = value.title.rendered;
							posts['value']  = String(value.id)+'__'+value.title.rendered;
							shop_menu_posts.push(posts);
						});
						//console.log(shop_menu_posts);
						
						editor.windowManager.open({
								title: 'メールフォーム',
							
								body: [
										{type: 'listbox' , name: 'shop_menuid', label: 'フォーム名',
										'values': shop_menu_posts
										},
								],
								onsubmit: function(e) {
									editor.focus();
									//console.log(e.data);
									
									var shortcode = e.data.shop_menuid;
									var shop_menu_id = shortcode.replace('__',' label="')+'"';
									
									var shop_menu_code = '[essence-shop_menu-pro id='+shop_menu_id+']';
									editor.selection.setContent(shop_menu_code);
								}//onsubmit

						});
						
					})// get json	
					.done(function(shop_menu_posts) {

					})
					.fail(function(shop_menu_posts) {
						
					})
					.always(function(shop_menu_posts) {
						
					});

				
			} // onclick

    });
		//^ メールフォームショートコードを追加 =============================================

  },


	

	_do_spot : function(content) {
		return content;
	},

	_get_spot : function(content) {
		return content;
	},
    


      
    
	//information =============================================
	getInfo : function() {
		return {
			longname : 'tinymce.plugins.shop_menu_essence',
			author : 'HealingSolutions',
			authorurl : 'https://www.healing-solutions.jp/',
			infourl : 'https://www.healing-solutions.jp/',
			version : "1.0"
		};
	}

    
});

  tinymce.PluginManager.add('shop_menu_essence', tinymce.plugins.shop_menu_essence);

})();