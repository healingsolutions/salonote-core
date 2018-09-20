// JavaScript Document

(function() {
  tinymce.create('tinymce.plugins.mailform_essence', {
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
		editor.addButton( 'mailform_essence', {
      icon: 'icon dashicons-email-alt',
      onclick : function() {
				
				
					//JSONのURLを格納する
					var current_url = location.hostname+''+location.pathname;
					var json_url = current_url.replace('wp-admin/post.php','wp-json/wp/v2/es_mailform');
					$url = '//'+json_url;

					$.getJSON( $url, function(results) {
						var mailform_posts = [];	
						$.each(results, function(i, value) {
							var posts = {};
							posts['text']   = value.title.rendered;
							posts['value']  = String(value.id)+'__'+value.title.rendered;
							mailform_posts.push(posts);
						});
						//console.log(mailform_posts);
						
						editor.windowManager.open({
								title: 'メールフォーム',
							
								body: [
										{type: 'listbox' , name: 'mailformid', label: 'フォーム名',
										'values': mailform_posts
										},
								],
								onsubmit: function(e) {
									editor.focus();
									//console.log(e.data);
									
									var shortcode = e.data.mailformid;
									var mailform_id = shortcode.replace('__',' label="')+'"';
									
									var mailform_code = '[essence-mailform-pro id='+mailform_id+']';
									editor.selection.setContent(mailform_code);
								}//onsubmit

						});
						
					})// get json	
					.done(function(mailform_posts) {

					})
					.fail(function(mailform_posts) {
						
					})
					.always(function(mailform_posts) {
						
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
			longname : 'tinymce.plugins.mailform_essence',
			author : 'HealingSolutions',
			authorurl : 'https://www.healing-solutions.jp/',
			infourl : 'https://www.healing-solutions.jp/',
			version : "1.0"
		};
	}

    
});

  tinymce.PluginManager.add('mailform_essence', tinymce.plugins.mailform_essence);

})();