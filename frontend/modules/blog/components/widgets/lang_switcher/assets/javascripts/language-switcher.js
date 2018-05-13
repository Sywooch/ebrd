//$(document).ready(function(){
	$(document).on('click', '.cur_lang', function(){
		$('.lang_inac').show();
		console.log('hover3');		
	});
//});
if ($('#main_ls').find('li').length === 0){
	$('#main_ls').hide();
}

