	/*
	 * reset serch form and submit it
	 */
	$('#trans_serch_reset').click(function(event){
		event.preventDefault();
		$('#searchsourcemessage-category').val('');
		$('#searchsourcemessage-searchtext').val('');
		$('#searchsourcemessage-message').val('');
		$('#trans_search_form').submit();
	});
	
	/**
	 * autosubmit form on category select
	 */
	$('#searchsourcemessage-category').change(function(){
		$('#trans_search_form').submit();
	});
	
	/**
	 * Hide-show translation lines filtered by language
	 * not active yet
	 */
	$(document).on('click', '.hide_lang', function(event){
		var lang = $(event.target).attr('data-lang');
		$.each($('.trans_line.' + lang), function(index, value){
			$(value).addClass('hide');
		});
		$(event.target).removeClass('btn-success');
		$(event.target).removeClass('hide_lang');
		$(event.target).addClass('btn-danger');
		$(event.target).addClass('show_lang');
	});
	$(document).on('click', '.show_lang', function(event){
		var lang = $(event.target).attr('data-lang');
		$.each($('.trans_line.' + lang), function(index, value){
			$(value).removeClass('hide');
		});
		$(event.target).removeClass('btn-danger');
		$(event.target).removeClass('show_lang');
		$(event.target).addClass('btn-success');
		$(event.target).addClass('hide_lang');
	});
	
	
	/**------------------------------------------------
	 * Inline-translations
	 *-------------------------------------------------*/
		function editTranslation(event){
        target = $(event.target);
        var action = target.parents('.trble').find('.edit_translation');
        $(action).removeClass('edit_translation');
        $(action).addClass('save_translation');
        
        var transLine = target.parents('.trble').find('.trline');
        var transLineText = $(transLine).html();
        $(transLine).html('<textarea class="tredit">' + transLineText + '</textarea>');
		putCarrotAtTheEnd ($(transLine).children('textarea'));
//		$(transLine).children('textarea').focus();
	}
	
	/**
	 * Puts carrot to the end of text in input or textbox
	 */
	function putCarrotAtTheEnd(input){
		var searchInput = input;

		// Multiply by 2 to ensure the cursor always ends up at the end;
		// Opera sometimes sees a carriage return as 2 characters.
		var strLength = searchInput.val().length * 2;

		searchInput.focus();
		searchInput[0].setSelectionRange(strLength, strLength);
	}
	
	function saveTranslation(event){
        target = $(event.target);
		var parent = target.parents('.trble');
		var data = {
			id : $(parent).attr('data-id'),
			message : $(parent).attr('data-message'),
			category : $(parent).attr('data-category'),
			language : $(parent).attr('data-lang'),
			translation : $(parent).find('textarea').val()
		};

		$.post({
			url : '/translation/default/save',
			data : data
		}).done(function(response){
			var myEvent = {
				type : "translationUpdated",
				message : target.parents('.trble').attr('data-message'),
				category : target.parents('.trble').attr('data-category')
			}
			target.parents('.trble').find('.trline').html(response);
			$.event.trigger(myEvent);
		});
		
        var action = target.parents('.trble').find('.save_translation');
        $(action).removeClass('save_translation');
        $(action).addClass('edit_translation'); 
	}
	
	function openAllTranslations(event){
		var target = $(event.target);
		var parent = target.parents('.trble');
		var data = {
			message : $(parent).attr('data-message'),
			category : $(parent).attr('data-category')
		};
		$.post({
			url : '/translation/default/get-translations',
			data : data
		}).done(function(response){
			$('body').append('<div class="pet_pop_up_wrap close_pet_pop"><div class="pet_pop_up_block"><div id="pet_pop_up_cont">test</div></div></div>');
			$('#pet_pop_up_cont').html(response);
			addTransIcons();
		});
	}

	/**
	 * Add edit_translation icons
	 */
	function addTransIcons(){
		if ($('.trble').size() > $('.edit_translation').size()){
			$.each($('.trble'), function(index, value){
				if ($(value).find('.edit_translation').size() === 0){
					$(value).append('<div class="edit_translation"><i class="glyphicon glyphicon-pencil edit_ico act_ico"></i><i class="glyphicon glyphicon-floppy-disk save_ico act_ico"></i></div>');
				}
			});
		}
	}
	
	/**
	 * Add all translations icon
	 */
	function addGlobeIcons(){
		if (($('.trglobe').size() > 0) && ($('.globe_translation').size() === 0)){
			$.each($('.trglobe'), function(index, value){
				if ($(value).find('.globe_translation').size() === 0){
					$(value).append('<div class="globe_translation"><i class="glyphicon glyphicon-globe globe_ico act_ico"></i></div>');
				}
			});
		}
	}
	/**
	 * Start editing
	 */
    $(document).on('click', '.edit_translation', function(event){
		if ($('.tredit').size() === 0){
			editTranslation(event);
		}		
    });
	
	$(document).on('click', 'div.trline', function(event){
//		if ($(event.target).parents('.trline').find('textarea').size() === 0){
		if ($('.tredit').size() === 0){
			editTranslation(event);
		}		
    });
    
	/**
	 * Events for saveing translations
	 */
    $(document).on('click', '.save_translation', function(event){
        saveTranslation(event); 
    });
	
    $(document).on('focusout', '.tredit', function(event){
        saveTranslation(event); 
    });
	
	/**
	 * Open all translations editor
	 */
	$(document).on('click', '.globe_ico', function(event){
		openAllTranslations(event);
	});

	$(document).on('click', '.close_pet_pop', function(event){
		if ($(event.target).hasClass('close_pet_pop')){
			$(event.target)[0].remove();
			location.reload();
		}
	});
	
	addTransIcons();
	addGlobeIcons();