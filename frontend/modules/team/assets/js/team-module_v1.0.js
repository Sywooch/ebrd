$(document).on("click", "#invite_us_btn", function(){
	setTimeout(function(){
		if ($(".field-teaminviteuser-email.has-error").html() == undefined){
			$("#invite_us_btn").hide();
			$("#ivite_spiner").show();
		}	
	}, 555); 
});
		
$("#refresh_table_btn").click(function(){
	$(this).children(".fa-refresh").addClass("fa-spin");
});

function modifyInvitation(invitationId, action){
	var data = {
		'invitationId' : invitationId,
		'action' : action
	}	
	$.post({
		url: '/team/default/modify-invitation',
		data: data,
		success: function(response){
			var obj = $.parseJSON(response);
			$("#status_name_" + obj.invitationId).html(obj.statusName);
			$("#updated_at_" + obj.invitationId).html(obj.updatedAt);
//			$("#action_" + obj.invitationId).html('');
			$("#action_" + obj.invitationId).html(obj.actions);
			console.log(obj.actions);
		}
	});	
	
	return false;
}

$(document).on('pjax:end', function(xhr) {
	if (xhr.target.id == "invite_user"){		
		setTimeout(function(){
			$("#refresh_table_btn").click();
		}, 333);
	}
});

$(document).on('pjax:success', function(data, status, xhr) {
	if (data.target.id == "pj_team_table"){		
		$('#team_table_grid').fadeOut(1, function(){
		   $('#team_table_grid').fadeIn(777);
		});
	}
});


$(document).on('click', '.edit_full', function(event){
    $('.ultra_team_name_active').addClass('hidden');
    $('.ultra_team_name').addClass('openeinif');
    $('.edit_full').addClass('hidden');
    $("#newNameSubmit").show();
    
});

// DK additions
$(document).on('focus', '#team_name' , function(e) {	 
	SetCaretAtEnd(e.target);
});

$(document).on('blur', '#team_name', function() {
	$('.ultra_team_name_active').text($('#teamsetname-teamname').val());
});

function SetCaretAtEnd(elem) {
        var elemLen = elem.value.length;
        // For IE Only
        if (document.selection) {
            // Set focus
            elem.focus();
            // Use IE Ranges
            var oSel = document.selection.createRange();
            // Reset position to 0 & then set at end
            oSel.moveStart('character', -elemLen);
            oSel.moveStart('character', elemLen);
            oSel.moveEnd('character', 0);
            oSel.select();
        }
        else if (elem.selectionStart || elem.selectionStart == '0') {
            // Firefox/Chrome
            elem.selectionStart = elemLen;
            elem.selectionEnd = elemLen;
            elem.focus();
        } // if
    } // SetCaretAtEnd()