var debouncer;
var targetEntityId;
var sourceEntityId;
var url;

/*
* Block of events that will trigger saving fields process
*/

$(document).on('paste','.target_trans_wrap', function(e){
	fieldEdited(e);
});

$(document).on('keyup','.target_trans_wrap', function(e){
	fieldEdited(e);
});

//$(document).on('blur','.target_trans_cont', function(e){
//	fieldEdited(e);
//});
/*
*	Starts debounce and saving process
*/
function fieldEdited(e){	
	targetEntityId = $(e.target).parents('.target_trans_wrap').attr('data-id');
	sourceEntityId = $('.source_trans_wrap').attr('data-id');
	url = $(e.target).parents('.target_trans_wrap').attr('data-url');
	$('.trans_status').addClass('awaiting');
	$('.trans_status').html(messageAwaiting);
	$('#change_status').attr('disabled', 'true');
	debounce();
};

function saveTranslation(){
	var data = getTranslationData();
	data.entity.id = targetEntityId;
	data.sourceEntId = sourceEntityId;
	$.post({
		url : url,
		data: data
	}).done(function(res){
		var result = $.parseJSON(res);	
		removeStatusClasses($('.trans_status'));
		$('.trans_status').addClass(result.status);
		$('.trans_status').html(result.message);
		if (result.status == 'success'){
			$('#change_status').prop('disabled', false);
		}		
	}).fail(function(){
		$('.trans_status').addClass('error');
		$('.trans_status').html(messageError);
	});
}

function getTranslationData(){
	var data = {};
	var entity = {};
	$('.target_trans_cont').each(function(index, element){
		entity[$(element).attr('data-field')] = removeBr($(element).html());
	});
	data.entity = entity;
	return data;
}

function debounce(){
	clearTimeout(debouncer);
	debouncer = setTimeout(function(){ 
		saveTranslation();
	}, 1500);			
}

function removeStatusClasses(target){
	target.removeClass('awaiting');
	target.removeClass('error');
	target.removeClass('success');		
}	

/**
* Removes <br> tag that appears in firefox
*/
function removeBr(str){
	var parasit = '<br>';
	if (str.endsWith(parasit)) {
		console.log('ends!');
		return str.slice(0, (str.length - parasit.length));
	}
	return str;
}

/**
 * Change element status
 */
$('.main_body_content').on('click', '#change_status', function(e){
	var target = $(e.target);
	var data = {
		entityTypeId : target.attr('data-entityTypeId'),
		entityId : target.attr('data-entityId'),
		statusId : target.attr('data-statusId')
	};
	console.log(target);
	$.post({
		url : '/blog/common/change-status',
		data : data
	}).done(function(r){
//		var res = $.parseJSON(r);
		target.closest('div').html(r.button);
		$('#el_status').html(r.status);
		console.log(target.closest('div'));
	});
});
