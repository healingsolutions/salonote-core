// JavaScript Document


$(document).ready(function() {

	
	$('#post_new').on('change', function(e) {
		if( $(this).prop('checked') ){
			$('#post_type_field').show('fast');
			$('#post_target_field').hide('fast');
			$('#post_title_field').show('fast');
		}else{
			$('#post_type_field').hide('fast');
			$('#post_target_field').show('fast');
			$('#post_title_field').hide('fast');
			
		}
	});

	var storedFiles = [];      
	$('#note_images').on('change', function() {
			$('#note_images').html('');
			var myfiles = document.getElementById('note_images');
			var files = myfiles.files;
			var i=0;
			for (i = 0; i<files.length; i++) {
					var readImg = new FileReader();
					var file=files[i];
					if(file.type.match('image.*')){
							storedFiles.push(file);
							readImg.onload = (function(file) {
									return function(e) {
											$('#uploadedfiles').append('<tr class="imageinfo"><td><img width="80" height="70" src="'+e.target.result+'"/></td><td>'+file.name+'</td><td>'+Math.round((file.size/1024))+'KB</td><td><a href="" class="lnkcancelimage" file="'+file.name+'" title="Cancel">X</a></td></tr>');
									};
							})(file);
							readImg.readAsDataURL(file);
					}else{
							alert('the file '+file.name+' is not an image<br/>');
					}
			}
	});

	$('#uploadedfiles').on('click','a.lnkcancelimage',function(){
			$(this).parent().parent().html('');
			var file=$(this).attr('file');
			for(var i=0;i<storedFiles.length;i++) {
					if(storedFiles[i].name == file) {
							storedFiles.splice(i,1);
							break;
					}
			}
			return false;
	});


});